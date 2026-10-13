<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssistantVetController;
use App\Http\Controllers\CityVetController;
use App\Http\Controllers\Client\AdoptionFormController;
use App\Http\Controllers\Client\AdoptionRequestController;
use App\Http\Controllers\Client\OtpController;
use App\Http\Controllers\Client\PetController;
use App\Http\Controllers\Client\PetRegistrationController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\DiseaseControlController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LivestockCensusController;
use App\Http\Controllers\MeatInspectionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RabiesCaseController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\SpayNeuterController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Fallback Routes (Available in all contexts including console)
|--------------------------------------------------------------------------
*/
// Fallback route for announcements - used by NotificationService and redirects
Route::get('/announcements-public', [AnnouncementController::class, 'index'])->name('announcements.index');

// Fallback route for system-logs.show - used by views
Route::get('/fallback/system-logs/{log}', [SystemLogController::class, 'show'])->name('admin.system-logs.show');

// Fallback route for notifications.index - used by bell dropdown
Route::get('/fallback/notifications', [NotificationController::class, 'index'])->name('notifications.index');
// Include Breeze authentication routes
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Veterinary Services Office Management Information System
| 7 User Roles from Thesis Paper:
| 1. Super Administrator
| 2. Administrator
| 3. City Veterinarian
| 4. Administrative Staff
| 5. Assistant Veterinary Personnel
| 6. City Pound Personnel
| 7. Meat Inspection Officer
|
*/

use App\Exceptions\AppointmentSlotTakenException;
use App\Http\Controllers\AdminAsst\AdoptionApplicationController;
use App\Http\Controllers\AdminAsst\AppointmentController;
use App\Http\Controllers\AdminAsst\BusinessProfileController;
use App\Http\Controllers\AdminAsst\ClinicalActionController;
use App\Http\Controllers\AdminAsst\DashboardController;
use App\Http\Controllers\AdminAsst\ImpoundController;
use App\Http\Controllers\AdminAsst\MissingPetController;
use App\Http\Controllers\AdoptionPetController;
use App\Http\Controllers\Client\BiteRabiesReportController;
use App\Http\Controllers\Client\MissingPetReportController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\MedicalRecordController;
use App\Models\Address;
use App\Models\AdoptionTrait;
use App\Models\Announcement;
use App\Models\Barangay;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\SpayNeuterAppointment;
use App\Models\SpayNeuterReport;
use App\Models\VaccinationAppointment;
use App\Models\VaccinationReport;
use App\Services\AppointmentBookingService;
use App\Services\VeterinarianRotationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

// ... existing imports

Route::get('/', function () {
    // If user is authenticated, redirect to their role-based dashboard
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('super_admin')) {
            return redirect()->route('super-admin.dashboard');
        } elseif ($user->hasRole('city_vet')) {
            return redirect()->route('city-vet.dashboard');
        } elseif ($user->hasRole('admin_asst')) {
            return redirect()->intended('/admin-asst/dashboard')
                ->with('success', 'Welcome back, Administrative Assistant ' . $user->name . '!');
        } elseif ($user->hasRole('assistant_vet')) {
            return redirect()->route('assistant-vet.dashboard');
        } elseif ($user->hasRole('meat_inspector')) {
            return redirect()->route('meat-inspection.dashboard');
        } elseif ($user->hasRole('pet_owner')) {
            return redirect()->route('owner.dashboard');
        } else {
            // Unknown role - log out and redirect to login for security
            Auth::logout();

            return redirect()->route('login');
        }
    }
    // Get missing pets for the landing page
    $missingPets = Pet::where('pet_status', 'missing')
        ->with(['missingReport' => function ($query) {
            $query->whereIn('status', ['approved', 'pending review'])->latest()->take(1);
        }])
        ->limit(5)
        ->get();

    // Get adoption pets for the landing page
    $adoptionPets = Pet::availableForAdoption()
        ->with(['barangay'])
        ->limit(5)
        ->get();

    // Get active announcements for public
    $announcements = Announcement::where('is_active', true)
        ->where('status', 'Published')
        ->orderBy('created_at', 'desc')
        ->get();

    // Dynamic stats
    $vaccinationReportsCount = \App\Models\VaccinationReport::count();
    $petsRegisteredCount = Pet::whereHas('owner')->count();
    $spayedNeuteredCount = SpayNeuterReport::count();
    $reunitedCount = \App\Models\MissingPetsReport::where('status', 'resolved - reunited')->count();
    $rehomedCount = \App\Models\AdoptionApplication::where('status', 'adopted')->count();

    return view('Client.welcome', compact('missingPets', 'adoptionPets', 'announcements', 'vaccinationReportsCount', 'petsRegisteredCount', 'spayedNeuteredCount', 'reunitedCount', 'rehomedCount'));
})->name('landing');

// Public Home Route - Always shows welcome page
Route::get('/home', function () {
    // Get missing pets for the landing page
    $missingPets = Pet::where('pet_status', 'missing')
        ->with(['missingReport' => function ($query) {
            $query->whereIn('status', ['approved', 'pending review'])->latest()->take(1);
        }])
        ->limit(5)
        ->get();

    // Get adoption pets for the landing page
    $adoptionPets = Pet::availableForAdoption()
        ->with(['barangay'])
        ->limit(5)
        ->get();

    // Get active announcements for public
    $announcements = Announcement::where('is_active', true)
        ->where('status', 'Published')
        ->orderBy('created_at', 'desc')
        ->get();

    // Dynamic stats
    $vaccinationReportsCount = \App\Models\VaccinationReport::count();
    $petsRegisteredCount = Pet::whereHas('owner')->count();
    $spayedNeuteredCount = \App\Models\SpayNeuterReport::where('status', 'completed')->count();
    $reunitedCount = \App\Models\MissingPetsReport::where('status', 'resolved - reunited')->count();
    $rehomedCount = \App\Models\AdoptionApplication::where('status', 'adopted')->count();

    return view('Client.welcome', compact('missingPets', 'adoptionPets', 'announcements', 'vaccinationReportsCount', 'petsRegisteredCount', 'spayedNeuteredCount', 'reunitedCount', 'rehomedCount'));
})->name('public.home');

// ==============================
// AUTHENTICATION ROUTES - Client Portal (Default)
// ==============================
// Login routes moved to routes/auth.php (loaded at end of this file)

// ==============================
// PUBLIC ANNOUNCEMENTS (Citizen View)
// ==============================
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.public.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');

// ==============================
// AUTHENTICATED NON-ADMIN ANNOUNCEMENTS (Barangay, Clinic, etc.)
// ==============================
Route::middleware(['auth'])->group(function () {
    Route::get('/portal/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.portal.index');
    Route::post('/portal/announcements/mark-read', [AnnouncementController::class, 'markAsRead'])->name('announcements.markAsRead');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});

// ==============================
// SUPER ADMIN PORTAL (Super Administrator)
// Role: Super Admin
// Access: Full system access with account management
// ==============================
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    // Roles & Permissions
    Route::get('/roles', [SuperAdminController::class, 'roles'])->name('roles.index');
    Route::get('/roles/filter', [SuperAdminController::class, 'filterRoles'])->name('roles.filter');
    Route::get('/roles/create', [SuperAdminController::class, 'createRole'])->name('roles.create');
    Route::post('/roles', [SuperAdminController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{role}/edit', [SuperAdminController::class, 'editRole'])->name('roles.edit');
    Route::put('/roles/{role}', [SuperAdminController::class, 'updateRole'])->name('roles.update');
    Route::post('/roles/{role}/permissions', [SuperAdminController::class, 'syncPermissions'])->name('roles.permissions.sync');

    // User Management (Full Access - Super Admin Only)
    // These routes are protected by super_admin role middleware
    Route::get('/users/search', [SuperAdminController::class, 'searchUsers'])->name('users.search');
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('users.toggle-status');

    // System Statistics API
    Route::get('/stats', [SuperAdminController::class, 'systemStats'])->name('stats');
    Route::get('/user-stats', [SuperAdminController::class, 'userStats'])->name('user-stats');

    // System Activity Chart Data
    Route::get('/system-activity', [SuperAdminController::class, 'systemActivity'])->name('system-activity');

    // Activity Logs
    Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity-logs');

    // Reports Export
    Route::get('/export', [SuperAdminController::class, 'exportReport'])->name('export');

    // System Settings
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [SuperAdminController::class, 'updateSettings'])->name('settings.update');

    // All Reports (City-wide View)
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Animal Bite Reports (from Barangay)
    Route::get('/animal-bite-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/animal-bite-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');

    // Rabies Vaccination Reports (from Clinic)
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/filter', [AdminController::class, 'filterVaccinationReports'])->name('vaccination-reports.filter');
    Route::get('/vaccination-reports/{report}/json', [AdminController::class, 'showVaccinationReportJson'])->name('vaccination-reports.show-json');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Meat Inspection Reports
    Route::get('/meat-inspection-reports', [AdminController::class, 'indexMeatInspectionReports'])->name('meat-inspection-reports.index');
    Route::get('/meat-inspection-reports/filter', [AdminController::class, 'filterMeatInspectionReports'])->name('meat-inspection-reports.filter');
    Route::get('/meat-inspection-reports/{report}', [AdminController::class, 'showMeatInspectionReport'])->name('meat-inspection-reports.show');
    Route::get('/meat-inspection-reports/{establishment}/json', [AdminController::class, 'showMeatEstablishmentJson'])->name('meat-inspection-reports.show-json');

    // System Logs
    Route::get('/system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');
    Route::get('/system-logs/filter', [SystemLogController::class, 'filter'])->name('system-logs.filter');
    Route::get('/system-logs/{log}', [SystemLogController::class, 'show'])->name('system-logs.show');
    Route::get('/system-logs/{log}/modal', [SystemLogController::class, 'modal'])->name('system-logs.modal');
    Route::get('/system-logs/export', [SystemLogController::class, 'export'])->name('system-logs.export');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/filter', [AnnouncementController::class, 'filter'])->name('announcements.filter');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

// ==============================
// ADMIN PORTAL (Administrator)
// Role: Admin
// Access: System management and user oversight
// ==============================
Route::middleware(['auth', 'role:city_vet'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management (Limited - can manage users below their level)
    // Protected by city_vet role and additional hierarchy check in controller
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // All Reports (City-wide View)
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Bite & Rabies Reports
    Route::get('/bite-rabies-reports', [AdminController::class, 'indexBiteReports'])->name('bite-reports.index');
    Route::get('/bite-rabies-reports/filter', [AdminController::class, 'filterBiteReports'])->name('bite-reports.filter');
    Route::get('/bite-rabies-reports/{report}', [AdminController::class, 'showBiteReport'])->name('bite-reports.show');
    Route::get('/bite-rabies-reports/{report}/json', [AdminController::class, 'showBiteReportJson'])->name('bite-reports.show-json');

    // Rabies Vaccination Reports (from Clinic)
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/filter', [AdminController::class, 'filterVaccinationReports'])->name('vaccination-reports.filter');
    Route::get('/vaccination-reports/{report}/json', [AdminController::class, 'showVaccinationReportJson'])->name('vaccination-reports.show-json');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Anti-Rabies Vaccination Appointments
    Route::get('/vaccination-appointments', [AdminController::class, 'indexVaccinationAppointments'])->name('vaccination-appointments.index');
    Route::get('/vaccination-appointments/filter', [AdminController::class, 'filterVaccinationAppointments'])->name('vaccination-appointments.filter');
    Route::get('/vaccination-appointments/{appointment}/json', [AdminController::class, 'showVaccinationAppointmentJson'])->name('vaccination-appointments.show-json');
    Route::get('/vaccination-appointments/{appointment}/edit', [AdminController::class, 'editVaccinationAppointmentJson'])->name('vaccination-appointments.edit');
    Route::put('/vaccination-appointments/{appointment}', [AdminController::class, 'updateVaccinationAppointment'])->name('vaccination-appointments.update');
    Route::put('/vaccination-appointments/{appointment}/status', [AdminController::class, 'updateVaccinationAppointmentStatus'])->name('vaccination-appointments.update-status');

    // Meat Inspection Reports
    Route::get('/meat-inspection-reports', [AdminController::class, 'indexMeatInspectionReports'])->name('meat-inspection-reports.index');
    Route::get('/meat-inspection-reports/filter', [AdminController::class, 'filterMeatInspectionReports'])->name('meat-inspection-reports.filter');
    Route::get('/meat-inspection-reports/{report}', [AdminController::class, 'showMeatInspectionReport'])->name('meat-inspection-reports.show');
    Route::get('/meat-inspection-reports/{establishment}/json', [AdminController::class, 'showMeatEstablishmentJson'])->name('meat-inspection-reports.show-json');

    // Meat Establishments (shared view compatibility)
    Route::get('/establishments/filter', [AdminController::class, 'filterMeatInspectionReports'])->name('establishments.filter');
    Route::get('/establishments/{establishment}/json', [AdminController::class, 'showMeatEstablishmentJson'])->name('establishments.show-json');

    // Missing Pet Reports
    Route::get('/missing-pet-reports', [CityVetController::class, 'indexMissingPetReports'])->name('missing-pet-reports.index');
    Route::get('/missing-pet-reports/filter', [CityVetController::class, 'filterMissingPetReports'])->name('missing-pet-reports.filter');
    Route::get('/missing-pet-reports/{missingPet}', [CityVetController::class, 'showMissingPetReport'])->name('missing-pet-reports.show');
    Route::get('/missing-pet-reports/{missingPet}/json', [CityVetController::class, 'showMissingPetReportJson'])->name('missing-pet-reports.show-json');

    // Adoption Reports
    Route::get('/adoption-reports', [CityVetController::class, 'indexAdoptionReports'])->name('adoption-reports.index');
    Route::get('/adoption-reports/filter', [CityVetController::class, 'filterAdoptionReports'])->name('adoption-reports.filter');
    Route::get('/adoption-reports/{adoption}', [CityVetController::class, 'showAdoptionReport'])->name('adoption-reports.show');
    Route::get('/adoption-reports/{adoption}/json', [CityVetController::class, 'showAdoptionReportJson'])->name('adoption-reports.show-json');

    // System Logs
    Route::get('/system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');
    Route::get('/system-logs/filter', [SystemLogController::class, 'filter'])->name('system-logs.filter');
    Route::get('/system-logs/{log}', [SystemLogController::class, 'show'])->name('system-logs.show');
    Route::get('/system-logs/{log}/modal', [SystemLogController::class, 'modal'])->name('system-logs.modal');
    Route::get('/system-logs/export', [SystemLogController::class, 'export'])->name('system-logs.export');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/filter', [AnnouncementController::class, 'filter'])->name('announcements.filter');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

// ==============================
// CITY VETERINARIAN PORTAL
// Role: City Veterinarian
// Access: Consolidated reports, planning, regulatory decision-making
// ==============================
Route::middleware(['auth', 'role:city_vet'])->prefix('city-vet')->name('city-vet.')->group(function () {
    Route::get('/dashboard', [CityVetController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/chart-data', [CityVetController::class, 'chartData'])->name('dashboard.chart-data');

    // Vaccination Reports
    Route::get('/vaccination-reports', [AdminController::class, 'indexVaccinationReports'])->name('vaccination-reports.index');
    Route::get('/vaccination-reports/filter', [AdminController::class, 'filterVaccinationReports'])->name('vaccination-reports.filter');
    Route::get('/vaccination-reports/{report}', [AdminController::class, 'showVaccinationReport'])->name('vaccination-reports.show');

    // Rabies Geomap
    Route::get('/rabies-geomap', [CityVetController::class, 'geomap'])->name('rabies-geomap');
    Route::get('/rabies-geomap/data', [CityVetController::class, 'geomapData'])->name('rabies-geomap.data');

    // All Reports
    Route::get('/all-reports', [AdminController::class, 'allReports'])->name('all-reports');

    // Impound Records
    Route::get('/impounds', [ImpoundController::class, 'index'])->name('impounds.index');
    Route::get('/impounds/{impound}', [ImpoundController::class, 'show'])->name('impounds.show');
    Route::put('/impounds/{impound}', [ImpoundController::class, 'updateDisposition'])->name('impounds.update');

    // Bite & Rabies Reports - View Only
    Route::get('/bite-rabies-reports', [DiseaseControlController::class, 'indexRabiesReports'])->name('rabies-bite-reports.index');
    Route::get('/bite-rabies-reports/{rabiesReport}', [DiseaseControlController::class, 'showRabiesReport'])->name('rabies-bite-reports.show');

    // ========== ADMIN ASST MODULES (merged into assistant_vet) ==========
    // Pet Registrations (Portal Admin Assistant)
    Route::get('/pet-registrations', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'index'])->name('pet-registrations.index');
    Route::get('/pet-registrations/create', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'create'])->name('pet-registrations.create');
    Route::post('/pet-registrations', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'store'])->name('pet-registrations.store');
    Route::get('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'show'])->name('pet-registrations.show');
    Route::get('/pet-registrations/{pet}/edit', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'edit'])->name('pet-registrations.edit');
    Route::put('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'update'])->name('pet-registrations.update');
    Route::delete('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'destroy'])->name('pet-registrations.destroy');

    // Appointment/Service Requests
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/reset', [AppointmentController::class, 'reset'])->name('appointments.reset');

    // Business Profiles (Poultry & Livestock)
    Route::get('/business-profiles', [BusinessProfileController::class, 'index'])->name('business-profiles.index');
    Route::get('/business-profiles/create', [BusinessProfileController::class, 'create'])->name('business-profiles.create');
    Route::post('/business-profiles', [BusinessProfileController::class, 'store'])->name('business-profiles.store');
    Route::get('/business-profiles/{businessProfile}', [BusinessProfileController::class, 'show'])->name('business-profiles.show');
    Route::get('/business-profiles/{businessProfile}/edit', [BusinessProfileController::class, 'edit'])->name('business-profiles.edit');
    Route::put('/business-profiles/{businessProfile}', [BusinessProfileController::class, 'update'])->name('business-profiles.update');
    Route::delete('/business-profiles/{businessProfile}', [BusinessProfileController::class, 'destroy'])->name('business-profiles.destroy');
    Route::post('/business-profiles/{businessProfile}/approve', [BusinessProfileController::class, 'approve'])->name('business-profiles.approve');
    Route::post('/business-profiles/{businessProfile}/suspend', [BusinessProfileController::class, 'suspend'])->name('business-profiles.suspend');
    Route::get('/business-profiles/export', [BusinessProfileController::class, 'export'])->name('business-profiles.export');

    // Impound Records (merged with city-pound)
    Route::get('/impounds', [ImpoundController::class, 'index'])->name('impounds.index');
    Route::get('/impounds/{impound}', [ImpoundController::class, 'show'])->name('impounds.show');
    Route::put('/impounds/{impound}', [ImpoundController::class, 'updateDisposition'])->name('impounds.update');

    // Clinical Actions
    Route::get('/clinical-actions', [ClinicalActionController::class, 'index'])->name('clinical-actions.index');
    Route::get('/clinical-actions/create', [ClinicalActionController::class, 'create'])->name('clinical-actions.create');
    Route::post('/clinical-actions', [ClinicalActionController::class, 'store'])->name('clinical-actions.store');
    Route::get('/clinical-actions/{clinicalAction}', [ClinicalActionController::class, 'show'])->name('clinical-actions.show');
    Route::get('/clinical-actions/{clinicalAction}/edit', [ClinicalActionController::class, 'edit'])->name('clinical-actions.edit');
    Route::put('/clinical-actions/{clinicalAction}', [ClinicalActionController::class, 'update'])->name('clinical-actions.update');
    Route::delete('/clinical-actions/{clinicalAction}', [ClinicalActionController::class, 'destroy'])->name('clinical-actions.destroy');

    // Medical Records
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');

    // Rabies Geomap (Geospatial Mapping)
    Route::get('/rabies-geomap', [CityVetController::class, 'geomap'])->name('rabies-geomap');
    Route::get('/rabies-geomap/data', [CityVetController::class, 'geomapData'])->name('rabies-geomap.data');

    // Missing Pet Reports
    Route::get('/missing-pet-reports', [CityVetController::class, 'indexMissingPetReports'])->name('missing-pet-reports.index');
    Route::get('/missing-pet-reports/filter', [CityVetController::class, 'filterMissingPetReports'])->name('missing-pet-reports.filter');
    Route::get('/missing-pet-reports/{missingPet}', [CityVetController::class, 'showMissingPetReport'])->name('missing-pet-reports.show');
    Route::get('/missing-pet-reports/{missingPet}/json', [CityVetController::class, 'showMissingPetReportJson'])->name('missing-pet-reports.show-json');

    // Adoption Reports
    Route::get('/adoption-reports', [CityVetController::class, 'indexAdoptionReports'])->name('adoption-reports.index');
    Route::get('/adoption-reports/filter', [CityVetController::class, 'filterAdoptionReports'])->name('adoption-reports.filter');
    Route::get('/adoption-reports/{adoption}', [CityVetController::class, 'showAdoptionReport'])->name('adoption-reports.show');
    Route::get('/adoption-reports/{adoption}/json', [CityVetController::class, 'showAdoptionReportJson'])->name('adoption-reports.show-json');
});

// ==============================
// ADMIN ASSISTANT PORTAL
// Role: Admin Assistant
// Access: Pet registrations, adoption, missing pets
// ==============================
Route::middleware(['auth', 'role:admin_asst'])->prefix('admin-asst')->name('admin-asst.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pet Registrations
    Route::get('/pet-registrations', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'index'])->name('pet-registrations.index');
    Route::get('/pet-registrations/create', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'create'])->name('pet-registrations.create');
    Route::post('/pet-registrations', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'store'])->name('pet-registrations.store');
    Route::get('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'show'])->name('pet-registrations.show');
    Route::get('/pet-registrations/{pet}/edit', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'edit'])->name('pet-registrations.edit');
    Route::put('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'update'])->name('pet-registrations.update');
    Route::delete('/pet-registrations/{pet}', [App\Http\Controllers\AdminAsst\PetRegistrationController::class, 'destroy'])->name('pet-registrations.destroy');

    // Adoption Applications
    Route::get('/adoption-applications', [AdoptionApplicationController::class, 'index'])->name('adoption-applications.index');
    Route::get('/adoption-applications/{application}', [AdoptionApplicationController::class, 'show'])->name('adoption-applications.show');
    Route::post('/adoption-applications/{application}/approve', [AdoptionApplicationController::class, 'approve'])->name('adoption-applications.approve');
    Route::post('/adoption-applications/{application}/reject', [AdoptionApplicationController::class, 'reject'])->name('adoption-applications.reject');
    Route::post('/adoption-applications/{application}/pending', [AdoptionApplicationController::class, 'pending'])->name('adoption-applications.pending');
    Route::post('/adoption-applications/{application}/adopt', [AdoptionApplicationController::class, 'adopt'])->name('adoption-applications.adopt');

    // Adoption Pets
    Route::get('/adoption-pets', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'index'])->name('adoption-pets.index');
    Route::get('/adoption-pets/create', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'create'])->name('adoption-pets.create');
    Route::post('/adoption-pets', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'store'])->name('adoption-pets.store');
    Route::get('/adoption-pets/{pet}', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'show'])->name('adoption-pets.show');
    Route::get('/adoption-pets/{pet}/edit', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'edit'])->name('adoption-pets.edit');
    Route::put('/adoption-pets/{pet}', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'update'])->name('adoption-pets.update');
    Route::delete('/adoption-pets/{pet}', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'destroy'])->name('adoption-pets.destroy');
    Route::post('/adoption-pets/{pet}/approve', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'approve'])->name('adoption-pets.approve');
    Route::post('/adoption-pets/{pet}/reject', [App\Http\Controllers\AdminAsst\AdoptionPetController::class, 'reject'])->name('adoption-pets.reject');

    // Missing Pets
    Route::get('/missing-pets', [MissingPetController::class, 'index'])->name('missing-pets.index');
    Route::get('/missing-pets/create', [MissingPetController::class, 'create'])->name('missing-pets.create');
    Route::post('/missing-pets', [MissingPetController::class, 'store'])->name('missing-pets.store');
    Route::get('/missing-pets/{missingPet}', [MissingPetController::class, 'show'])->name('missing-pets.show');
    Route::get('/missing-pets/{missingPet}/edit', [MissingPetController::class, 'edit'])->name('missing-pets.edit');
    Route::put('/missing-pets/{missingPet}', [MissingPetController::class, 'update'])->name('missing-pets.update');
    Route::post('/missing-pets/{missingPet}/approve', [MissingPetController::class, 'approve'])->name('missing-pets.approve');
    Route::post('/missing-pets/{missingPet}/reject', [MissingPetController::class, 'reject'])->name('missing-pets.reject');
    Route::post('/missing-pets/{missingPet}/found', [MissingPetController::class, 'markFound'])->name('missing-pets.mark-found');
    Route::post('/missing-pets/{missingPet}/shelter-intake', [MissingPetController::class, 'markShelterIntake'])->name('missing-pets.shelter-intake');
    Route::post('/missing-pets/{missingPet}/close-expired', [MissingPetController::class, 'closeExpired'])->name('missing-pets.close-expired');
    Route::post('/missing-pets/{missingPet}/cancel', [MissingPetController::class, 'cancel'])->name('missing-pets.cancel');
    Route::post('/missing-pets/{missingPet}/duplicate', [MissingPetController::class, 'markDuplicate'])->name('missing-pets.duplicate');

    // Pet Owners
    Route::get('/owners', [RecordsController::class, 'owners'])->name('owners.index');
    Route::get('/owners/{owner}', [RecordsController::class, 'showOwner'])->name('owners.show');

    // Appointments/Service Requests
    Route::get('/appointments', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/approve', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/reject', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{appointment}/complete', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/reset', [App\Http\Controllers\AdminAsst\AppointmentController::class, 'reset'])->name('appointments.reset');

    // Inventory
    Route::get('/inventory', [App\Http\Controllers\AdminAsst\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [App\Http\Controllers\AdminAsst\InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [App\Http\Controllers\AdminAsst\InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}', [App\Http\Controllers\AdminAsst\InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{inventory}/edit', [App\Http\Controllers\AdminAsst\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [App\Http\Controllers\AdminAsst\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [App\Http\Controllers\AdminAsst\InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/low-stock', [App\Http\Controllers\AdminAsst\InventoryController::class, 'lowStock'])->name('inventory.low-stock');
    Route::get('/inventory/expiring', [App\Http\Controllers\AdminAsst\InventoryController::class, 'expiring'])->name('inventory.expiring');
    Route::get('/inventory/movements', [App\Http\Controllers\AdminAsst\InventoryController::class, 'movements'])->name('inventory.movements');

    Route::get('/inventory/{inventory}/stock-in', [App\Http\Controllers\AdminAsst\InventoryController::class, 'stockInForm'])->name('inventory.stock-in');
    Route::post('/inventory/{inventory}/stock-in', [App\Http\Controllers\AdminAsst\InventoryController::class, 'stockIn'])->name('inventory.stock-in.process');
    Route::get('/inventory/{inventory}/stock-out', [App\Http\Controllers\AdminAsst\InventoryController::class, 'stockOutForm'])->name('inventory.stock-out');
    Route::post('/inventory/{inventory}/stock-out', [App\Http\Controllers\AdminAsst\InventoryController::class, 'stockOut'])->name('inventory.stock-out.process');
    Route::get('/inventory/{inventory}/adjustment', [App\Http\Controllers\AdminAsst\InventoryController::class, 'adjustmentForm'])->name('inventory.adjustment');
    Route::post('/inventory/{inventory}/adjustment', [App\Http\Controllers\AdminAsst\InventoryController::class, 'adjustment'])->name('inventory.adjustment.process');
    Route::get('/inventory/{inventory}/transfer', [App\Http\Controllers\AdminAsst\InventoryController::class, 'transferForm'])->name('inventory.transfer');
    Route::post('/inventory/{inventory}/transfer', [App\Http\Controllers\AdminAsst\InventoryController::class, 'transfer'])->name('inventory.transfer.process');
});

// ==============================
// ASSISTANT VET PORTAL
// Role: Assistant Veterinarian
// Access: Shares access with city_vet (merged modules)
// ==============================
Route::middleware(['auth', 'role:assistant_vet'])->prefix('assistant-vet')->name('assistant-vet.')->group(function () {
    Route::get('/dashboard', [AssistantVetController::class, 'dashboard'])->name('dashboard');

    // Vaccination Records
    Route::get('/vaccinations', [RecordsController::class, 'vaccinations'])->name('vaccinations.index');
    Route::get('/vaccinations/create', [RecordsController::class, 'createVaccination'])->name('vaccinations.create');
    Route::post('/vaccinations', [RecordsController::class, 'storeVaccination'])->name('vaccinations.store');

    // Medical Records
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
});

// ==============================
// MEAT INSPECTION OFFICER PORTAL
// Role: Meat Inspector / Post-Abattoir Inspector
// Access: Inspection results, compliance monitoring, regulatory reports
// ==============================
Route::middleware(['auth', 'role:meat_inspector'])->prefix('meat-inspection')->name('meat-inspection.')->group(function () {
    Route::get('/dashboard', [MeatInspectionController::class, 'dashboard'])->name('dashboard');
    Route::get('/establishments-overview', [MeatInspectionController::class, 'establishmentsOverview'])->name('establishments-overview');

    // Meat Establishment JSON (for modal)
    Route::get('/establishments/{establishment}/json', [MeatInspectionController::class, 'showMeatEstablishmentJson'])->name('establishments.show-json');

    // Meat Inspection Reports
    Route::get('/reports', [MeatInspectionController::class, 'indexReports'])->name('reports.index');
    Route::get('/reports/create', [MeatInspectionController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [MeatInspectionController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports/{report}', [MeatInspectionController::class, 'showReport'])->name('reports.show');
    Route::get('/reports/{report}/edit', [MeatInspectionController::class, 'editReport'])->name('reports.edit');
    Route::put('/reports/{report}', [MeatInspectionController::class, 'updateReport'])->name('reports.update');
    Route::delete('/reports/{report}', [MeatInspectionController::class, 'destroyReport'])->name('reports.destroy');

    // Meat Shop Inspections
    Route::get('/meat-shop', [MeatInspectionController::class, 'indexMeatShopInspections'])->name('meat-shop.index');
    Route::get('/meat-shop/create', [MeatInspectionController::class, 'createMeatShopInspection'])->name('meat-shop.create');
    Route::post('/meat-shop', [MeatInspectionController::class, 'storeMeatShopInspection'])->name('meat-shop.store');
    Route::get('/meat-shop/{inspection}', [MeatInspectionController::class, 'showMeatShopInspection'])->name('meat-shop.show');
    Route::put('/meat-shop/{inspection}', [MeatInspectionController::class, 'updateMeatShopInspection'])->name('meat-shop.update');
    Route::get('/meat-shop/address', [MeatInspectionController::class, 'getMeatShopAddress'])->name('meat-shop.address');

    // Meat Establishment Registration
    Route::get('/establishments', [MeatInspectionController::class, 'indexEstablishments'])->name('establishments.index');
    Route::get('/establishments/create', [MeatInspectionController::class, 'createEstablishment'])->name('establishments.create');
    Route::post('/establishments', [MeatInspectionController::class, 'storeEstablishment'])->name('establishments.store');
    Route::get('/establishments/{establishment}', [MeatInspectionController::class, 'showEstablishment'])->name('establishments.show');
    Route::put('/establishments/{establishment}', [MeatInspectionController::class, 'updateEstablishment'])->name('establishments.update');
    Route::get('/establishments/filter', [MeatInspectionController::class, 'filterEstablishments'])->name('establishments.filter');
});

// ==============================
// SPAY/NEUTER PROGRAM MODULE
// Roles: city_vet, super_admin, assistant_vet
// Access: Spay and neuter procedure reports
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet'])->prefix('spay-neuter')->name('spay-neuter.')->group(function () {
    Route::get('/dashboard', [SpayNeuterController::class, 'dashboard'])->name('dashboard');

    // Spay/Neuter Reports
    Route::get('/reports', [SpayNeuterController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [SpayNeuterController::class, 'create'])->name('reports.create');
    Route::post('/reports', [SpayNeuterController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [SpayNeuterController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/edit', [SpayNeuterController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [SpayNeuterController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [SpayNeuterController::class, 'destroy'])->name('reports.destroy');
});

// ==============================
// LIVESTOCK CENSUS MODULE
// Roles: city_vet, super_admin, assistant_vet
// Access: Provincial livestock census data
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet'])->prefix('livestock-census')->name('livestock-census.')->group(function () {
    Route::get('/dashboard', [LivestockCensusController::class, 'index'])->name('dashboard');
    Route::get('/', [LivestockCensusController::class, 'index'])->name('index');
    Route::get('/create', [LivestockCensusController::class, 'create'])->name('create');
    Route::post('/', [LivestockCensusController::class, 'store'])->name('store');
    Route::get('/{census}', [LivestockCensusController::class, 'show'])->name('show');
    Route::get('/{census}/edit', [LivestockCensusController::class, 'edit'])->name('edit');
    Route::put('/{census}', [LivestockCensusController::class, 'update'])->name('update');
    Route::delete('/{census}', [LivestockCensusController::class, 'destroy'])->name('destroy');
    Route::get('/summary', [LivestockCensusController::class, 'summary'])->name('summary');
});

// ==============================
// RABIES CASE MANAGEMENT MODULE
// Roles: city_vet (full), super_admin (view-only)
// Access: Rabies case tracking and management
// ==============================
Route::middleware(['auth', 'role:city_vet|super_admin|assistant_vet'])->prefix('rabies-cases')->name('rabies-cases.')->group(function () {
    Route::get('/', [RabiesCaseController::class, 'index'])->name('index');
    Route::get('/create', [RabiesCaseController::class, 'create'])->name('create');
    Route::post('/', [RabiesCaseController::class, 'store'])->name('store');
    Route::get('/{case}', [RabiesCaseController::class, 'show'])->name('show');
    Route::get('/{case}/edit', [RabiesCaseController::class, 'edit'])->name('edit');
    Route::put('/{case}', [RabiesCaseController::class, 'update'])->name('update');
    Route::delete('/{case}', [RabiesCaseController::class, 'destroy'])->name('destroy');
    Route::get('/summary', [RabiesCaseController::class, 'summary'])->name('summary');
});

// ==============================
// RABIES HEATMAP (GEOMAPPING)
// Roles: city_vet, assistant_vet
// Access: Rabies hotspots visualization
// ==============================
Route::middleware(['auth', 'role:city_vet|assistant_vet'])->prefix('rabies')->name('rabies.')->group(function () {
    Route::get('/heatmap', [RabiesCaseController::class, 'heatmap'])->name('heatmap');
    Route::get('/geomap', [CityVetController::class, 'geomap'])->name('geomap');
    Route::get('/geomap/data', [CityVetController::class, 'geomapData'])->name('geomap.data');
});

// ==============================
// PUBLIC PAGES (Citizen Portal)
// ==============================
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/pet-owner-info', function () {
        return view('pages.pet-owner-info');
    })->name('pet-owner-info');

    Route::get('/programs-schedules', function () {
        return view('pages.programs-schedules');
    })->name('programs-schedules');

    Route::get('/reports-safety', function () {
        return view('pages.reports-safety');
    })->name('reports-safety');
});

// ==============================
// DEVICE TOKEN ROUTES (Push Notifications)
// ==============================
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Store device token
    Route::post('/device-tokens', [DeviceTokenController::class, 'store'])->name('device-tokens.store');

    // Update token usage
    Route::put('/device-tokens/usage', [DeviceTokenController::class, 'updateUsage'])->name('device-tokens.update-usage');

    // Deactivate token
    Route::delete('/device-tokens', [DeviceTokenController::class, 'destroy'])->name('device-tokens.destroy');

    // Get user's tokens
    Route::get('/device-tokens', [DeviceTokenController::class, 'index'])->name('device-tokens.index');
});

// ==============================
// CLIENT PORTAL (Pet Owner) - NEW
// ==============================
// Only 'citizen' role can access these routes
// Admin/staff roles should use their respective dashboards

// Landing page for client portal
Route::get('/client', function () {
    $missingPets = Pet::where('pet_status', 'missing')
        ->with(['missingReport' => function ($query) {
            $query->whereIn('status', ['approved', 'pending review'])->latest()->take(1);
        }])
        ->limit(5)
        ->get();

    $adoptionPets = Pet::availableForAdoption()
        ->with(['barangay'])
        ->limit(5)
        ->get();

    $announcements = Announcement::where('is_active', true)
        ->where('status', 'Published')
        ->orderBy('created_at', 'desc')
        ->get();

    // Dynamic stats
    $vaccinationReportsCount = \App\Models\VaccinationReport::count();
    $petsRegisteredCount = Pet::whereHas('owner')->count();
    $spayedNeuteredCount = SpayNeuterReport::count();
    $reunitedCount = \App\Models\MissingPetsReport::where('status', 'resolved - reunited')->count();
    $rehomedCount = \App\Models\AdoptionApplication::where('status', 'adopted')->count();

    return view('Client.welcome', compact('missingPets', 'adoptionPets', 'announcements', 'vaccinationReportsCount', 'petsRegisteredCount', 'spayedNeuteredCount', 'reunitedCount', 'rehomedCount'));
});

// OTP Routes - Only for citizens/clients
Route::prefix('otp')->group(function () {
    Route::get('/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/send', [OtpController::class, 'sendOtp'])->name('otp.send');
    Route::post('/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
});

// Password Reset OTP Routes - Only for citizens/clients
Route::prefix('password')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showResetVerifyForm'])->name('password.otp.form');
    Route::post('/otp/send', [OtpController::class, 'sendResetOtp'])->name('password.otp.send');
    Route::post('/otp/verify', [OtpController::class, 'verifyResetOtp'])->name('password.otp.verify');
    Route::get('/otp/resend', [OtpController::class, 'resendResetOtp'])->name('password.otp.resend');
});

// About Us Page Route - Public
Route::get('/about-us', function () {
    return view('Client.about_us');
});

// Services Page Route - Public
Route::get('/services', function () {
    return view('Client.services');
});

// Kapon Page Route - Public
Route::get('/kapon', function () {
    return view('Client.kapon');
});

// Kapon Form Page Route - Public
Route::get('/kapon/form', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }
    $userId = $user->id;
    $petOwner = $user->petOwner()->with(['address' => function ($query) {
        $query->with('barangay');
    }])->first();
    $pets = $petOwner ? $petOwner->pets : collect([]);

    $petsArray = $pets->map(function ($pet) {
        return [
            'id' => $pet->pet_id,
            'name' => $pet->pet_name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'age' => $pet->age,
            'weight' => $pet->weight,
            'sex' => $pet->sex ?? $pet->gender, // Use sex or gender (either may be populated)
            'image' => $pet->pet_image,
            'is_neutered' => $pet->petInfo?->is_neutered,
        ];
    })->toArray();

    // Sort: non-neutered pets first, then neutered pets
    $petsArray = collect($petsArray)->sortBy(function ($pet) {
        return strtolower((string) ($pet['is_neutered'] ?? '')) === 'yes' ? 1 : 0;
    })->values()->toArray();

    return view('Client.kapon_form', compact('user', 'petOwner', 'petsArray', 'userId'));
});

// Kapon Form POST Route
Route::post('/kapon/form', function (Request $request) {
    $validated = $request->validate([
        'selected_pets' => 'required|array|min:1|max:3',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
        'general_agreement' => 'nullable|array',
    ]);

    // Get authenticated user's PetOwner, with address + barangay prefetched
    $petOwner = auth()->user()->petOwner()->with(['address.barangay'])->first();

    if (! $petOwner) {
        return redirect()->back()->with('error', 'Please complete your profile first.');
    }

    // Get pet details from form's pets_data JSON
    $petsData = json_decode($request->input('pets_data'), true);

    // Double booking check - prevent same pet from being scheduled twice
    foreach ($validated['selected_pets'] as $petId) {
        $pet = collect($petsData)->firstWhere('id', (string) $petId);

        if ($pet && isset($pet['name'])) {
            $existingBooking = SpayNeuterAppointment::where('user_id', auth()->id())
                ->where('pet_id', $petId)
                ->whereDate('scheduled_at', $validated['appointment_date'])
                ->whereIn('status', ['pending', 'scheduled'])
                ->whereNotNull('scheduled_at')
                ->exists();

            if ($existingBooking) {
                return redirect()->back()->with('error', 'Pet "'.$pet['name'].'" already has a kapon appointment scheduled for '.Carbon::parse($validated['appointment_date'])->format('F j, Y').'. Please choose a different pet or date.');
            }
        }
    }

    // Check for slot availability with locking to prevent race conditions
    try {
        $bookingService = new AppointmentBookingService;
        $bookingService->checkAndBookKaponSlot(
            $validated['appointment_date'],
            $validated['appointment_time'],
            $validated['selected_pets']
        );
    } catch (AppointmentSlotTakenException $e) {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }

    // Resolve barangay_id from the owner's primary address (falls back to null)
    $barangayId = $petOwner->address?->barangay_id
        ?? $petOwner->address?->barangay?->barangay_id
        ?? null;

    // Resolve the owner's existing address (same fallback used by the vaccination form)
    $addressId = $petOwner->address_id ?? null;
    if (! $addressId && $petOwner->address) {
        $addressId = $petOwner->address->id ?? null;
    }

    // Initialize veterinarian rotation service
    $rotationService = new VeterinarianRotationService;
    $assignedVeterinarian = $rotationService->assignVeterinarian();

    // Create one appointment per selected pet (reports are generated on completion)
    foreach ($validated['selected_pets'] as $petId) {
        $pet = collect($petsData)->firstWhere('id', (string) $petId);

        // Get pet sex (use whatever is available)
        $petSex = $pet['sex'] ?? 'male';

        // Determine procedure type based on pet sex
        $procedureType = ($petSex === 'male') ? 'neuter' : 'spay';

        // Extract the numeric part of the weight (stored as e.g. "17 kg")
        $weight = $pet['weight'] ?? null;
        if (is_string($weight)) {
            preg_match('/\d+(\.\d+)?/', $weight, $weightMatches);
            $weight = $weightMatches[0] ?? null;
        }

        SpayNeuterAppointment::create([
            'user_id' => auth()->id(),
            'pet_id' => $petId,
            'owner_id' => $petOwner->owner_id,
            'address_id' => $addressId,
            'barangay_id' => $barangayId,
            'procedure_type' => $procedureType,
            'scheduled_at' => $validated['appointment_date'].' '.$validated['appointment_time'].':00',
            'weight' => $weight,
            'status' => 'pending',
            'general_agreement' => $request->input('general_agreement', []),
            'veterinarian' => $assignedVeterinarian,
            'assigned_vet' => null,
        ]);
    }

    return redirect('/kapon')->with('status', 'Kapon application submitted successfully! You will be notified once reviewed.');
})->middleware('auth');

// Adoption Page Route - Public
Route::get('/adoption', function (Request $request) {
    $userPets = [];
    $client = null;
    $hasPets = false;

    if (auth()->check()) {
        $client = PetOwner::where('user_id', auth()->id())->first();
        if ($client) {
            $userPets = $client->pets()->get(['species', 'gender']);
            $hasPets = $client->pets()->exists();
        }
    }

    $adoptionPets = Pet::availableForAdoption()->with('traits');

    $availableBreeds = Pet::where('source_module', 'adoption_pets')
        ->whereNotNull('breed')
        ->where('breed', '!=', '')
        ->distinct()
        ->orderBy('breed')
        ->pluck('breed');

    $availableTraits = AdoptionTrait::orderBy('name')->pluck('name');

    $filter = $request->input('filter', 'all');
    $species = $request->input('species', 'all');
    $gender = $request->input('gender', 'all');
    $age = $request->input('age', 'all');
    $breeds = $request->input('breeds', 'all');

    // Handle special filters first
    if ($filter === 'recommended' && auth()->check() && $hasPets) {
        // Recommended: prioritize pets matching user's existing pets species/gender
        $userSpecies = $userPets->pluck('species')->filter()->unique()->toArray();
        $userGenders = $userPets->pluck('gender')->filter()->unique()->toArray();

        // Only apply ordering if we have valid matches
        $hasSpeciesMatches = ! empty($userSpecies);
        $hasGenderMatches = ! empty($userGenders);

        if ($hasSpeciesMatches || $hasGenderMatches) {
            if ($hasSpeciesMatches) {
                $adoptionPets = $adoptionPets->orderByRaw(
                    'CASE WHEN species IN ('.implode(',', array_fill(0, count($userSpecies), '?')).') THEN 0 ELSE 1 END',
                    $userSpecies
                );
            }
            if ($hasGenderMatches) {
                $adoptionPets = $adoptionPets->orderByRaw(
                    'CASE WHEN gender IN ('.implode(',', array_fill(0, count($userGenders), '?')).') THEN 0 ELSE 1 END',
                    $userGenders
                );
            }
        }
        // Continue to apply other filters (breeds, traits) below
    } else {
        // Normal filter application
        if ($species === 'Dog') {
            $adoptionPets = $adoptionPets->where('species', 'Dog');
        } elseif ($species === 'Cat') {
            $adoptionPets = $adoptionPets->where('species', 'Cat');
        }

        if ($gender === 'male') {
            $adoptionPets = $adoptionPets->where('gender', 'male');
        } elseif ($gender === 'female') {
            $adoptionPets = $adoptionPets->where('gender', 'female');
        }

        if ($age === '0-6') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '>=', now()->subMonths(6));
        } elseif ($age === '6-12') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subMonths(6))
                ->where('birthdate', '>=', now()->subMonths(12));
        } elseif ($age === '1-3') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subMonths(12))
                ->where('birthdate', '>=', now()->subYears(3));
        } elseif ($age === '3+') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subYears(3));
        }
    }

    if ($breeds !== 'all' && ! empty($breeds)) {
        $breedArray = explode(',', $breeds);
        $adoptionPets = $adoptionPets->whereIn('breed', $breedArray);
    }

    $traits = $request->input('traits', 'all');
    if ($traits !== 'all' && ! empty($traits)) {
        $traitArray = explode(',', $traits);
        $adoptionPets = $adoptionPets->whereHas('traits', function ($query) use ($traitArray) {
            $query->whereIn('name', $traitArray);
        });
    }

    $adoptionPets = $adoptionPets->paginate(10);

    return view('Client.adoption', compact('adoptionPets', 'userPets', 'hasPets', 'availableBreeds', 'availableTraits'));
})->name('adoption.index');

// Adoption AJAX Pagination Route
Route::get('/adoption/paginate', function (Request $request) {
    $userPets = [];
    $client = null;
    $hasPets = false;

    if (auth()->check()) {
        $client = PetOwner::where('user_id', auth()->id())->first();
        if ($client) {
            $userPets = $client->pets()->get(['species', 'gender']);
            $hasPets = $client->pets()->exists();
        }
    }

    $adoptionPets = Pet::availableForAdoption()->with('traits');

    $filter = $request->input('filter', 'all');
    $species = $request->input('species', 'all');
    $gender = $request->input('gender', 'all');
    $age = $request->input('age', 'all');
    $breeds = $request->input('breeds', 'all');

    // Handle special filters first
    if ($filter === 'recommended' && auth()->check() && $hasPets) {
        // Recommended: prioritize pets matching user's existing pets species/gender
        $userSpecies = $userPets->pluck('species')->filter()->unique()->toArray();
        $userGenders = $userPets->pluck('gender')->filter()->unique()->toArray();

        // Only apply ordering if we have valid matches
        $hasSpeciesMatches = ! empty($userSpecies);
        $hasGenderMatches = ! empty($userGenders);

        if ($hasSpeciesMatches || $hasGenderMatches) {
            if ($hasSpeciesMatches) {
                $adoptionPets = $adoptionPets->orderByRaw(
                    'CASE WHEN species IN ('.implode(',', array_fill(0, count($userSpecies), '?')).') THEN 0 ELSE 1 END',
                    $userSpecies
                );
            }
            if ($hasGenderMatches) {
                $adoptionPets = $adoptionPets->orderByRaw(
                    'CASE WHEN gender IN ('.implode(',', array_fill(0, count($userGenders), '?')).') THEN 0 ELSE 1 END',
                    $userGenders
                );
            }
        }
        // Continue to apply other filters (breeds, traits) below
    } else {
        // Normal filter application
        if ($species === 'Dog') {
            $adoptionPets = $adoptionPets->where('species', 'Dog');
        } elseif ($species === 'Cat') {
            $adoptionPets = $adoptionPets->where('species', 'Cat');
        }

        if ($gender === 'male') {
            $adoptionPets = $adoptionPets->where('gender', 'male');
        } elseif ($gender === 'female') {
            $adoptionPets = $adoptionPets->where('gender', 'female');
        }

        if ($age === '0-6') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '>=', now()->subMonths(6));
        } elseif ($age === '6-12') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subMonths(6))
                ->where('birthdate', '>=', now()->subMonths(12));
        } elseif ($age === '1-3') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subMonths(12))
                ->where('birthdate', '>=', now()->subYears(3));
        } elseif ($age === '3+') {
            $adoptionPets = $adoptionPets->whereNotNull('birthdate')
                ->where('birthdate', '<', now()->subYears(3));
        }
    }

    if ($breeds !== 'all' && ! empty($breeds)) {
        $breedArray = explode(',', $breeds);
        $adoptionPets = $adoptionPets->whereIn('breed', $breedArray);
    }

    $traits = $request->input('traits', 'all');
    if ($traits !== 'all' && ! empty($traits)) {
        $traitArray = explode(',', $traits);
        $adoptionPets = $adoptionPets->whereHas('traits', function ($query) use ($traitArray) {
            $query->whereIn('name', $traitArray);
        });
    }

    $adoptionPets = $adoptionPets->paginate(10);

    $pets = collect($adoptionPets->items())->map(function ($pet) {
        return [
            'id' => $pet->pet_id,
            'pet_name' => $pet->pet_name,
            'species' => $pet->species,
            'gender' => $pet->gender,
            'breed' => $pet->breed,
            'description' => $pet->description,
            'traits' => $pet->traits->pluck('name')->toArray(),
            'weight' => $pet->weight,
            'image' => $pet->image ? asset(str_replace(' ', '%20', $pet->image)) : null,
            'image_path' => $pet->image,
            'date_of_birth' => $pet->date_of_birth,
            'is_age_estimated' => $pet->is_age_estimated,
            'age' => $pet->age,
        ];
    });

    return response()->json([
        'pets' => $pets,
        'currentPage' => $adoptionPets->currentPage(),
        'lastPage' => $adoptionPets->lastPage(),
        'hasMorePages' => $adoptionPets->hasMorePages(),
        'total' => $adoptionPets->total(),
    ]);
});

// Adoption Form Page Route
Route::get('/adoption/form', [AdoptionFormController::class, 'create'])
    ->middleware(['auth'])
    ->name('adoption.form');

// Adoption Form Edit Route
Route::get('/adoption/form/{application}/edit', [AdoptionFormController::class, 'edit'])
    ->middleware(['auth'])
    ->name('adoption.form.edit');

// Adoption Form Update Route
Route::put('/adoption/form/{application}', [AdoptionFormController::class, 'update'])
    ->middleware(['auth'])
    ->name('adoption.form.update');

// Adoption Form POST Route
Route::post('/adoption/form', [AdoptionFormController::class, 'store'])
    ->middleware(['auth'])
    ->name('adoption.form.submit');

// Store Adoption Pet Route
Route::post('/adoption', [AdoptionPetController::class, 'store'])->name('adoption.store');

// Missing Pets Page Route - Public
Route::get('/missing-pets', function () {
    $missingPets = Pet::where('pet_status', 'missing')
        ->with(['missingReport' => function ($query) {
            $query->whereIn('status', ['approved', 'pending review'])->latest()->take(1);
        }])
        ->paginate(12);

    $availableBreeds = Pet::where('pet_status', 'missing')
        ->whereNotNull('breed')
        ->where('breed', '!=', '')
        ->distinct()
        ->orderBy('breed')
        ->pluck('breed');

    $availableLocations = \App\Models\Barangay::orderBy('barangay_name')
        ->pluck('barangay_name');

    $announcements = Announcement::where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('Client.missing_pets_page', compact('missingPets', 'announcements', 'availableBreeds', 'availableLocations'));
});

Route::get('/missing-pets/paginate', function (Request $request) {
    $query = Pet::where('pet_status', 'missing')
        ->with(['missingReport' => function ($query) {
            $query->whereIn('status', ['approved', 'pending review'])->latest()->take(1);
        }]);

    if ($request->filled('species') && in_array($request->species, ['Dog', 'Cat'])) {
        $query->where('species', strtolower($request->species));
    }

    if ($request->filled('gender')) {
        $gender = strtolower($request->gender);
        if (in_array($gender, ['male', 'female'])) {
            $query->where('gender', $gender);
        }
    }

    if ($request->filled('breeds')) {
        $breeds = array_map('trim', explode(',', $request->breeds));
        $query->whereIn('breed', $breeds);
    }

    if ($request->filled('location')) {
        $locations = array_map('trim', explode(',', $request->location));
        $query->whereHas('missingReport.barangay', function ($q) use ($locations) {
            $q->whereIn('barangay_name', $locations);
        });
    }

    $missingPets = $query->paginate(12);

    $pets = $missingPets->map(function ($pet) {
        $report = $pet->missingReport->first();
        $rawImage = $pet->pet_image;
        $resolvedImage = null;
        if ($rawImage) {
            $candidate = public_path('images/missing pets/' . $rawImage);
            if (file_exists($candidate)) {
                $resolvedImage = asset('images/missing pets/'.$rawImage);
            } else {
                $baseName = pathinfo($rawImage, PATHINFO_FILENAME);
                foreach (['jpeg', 'jpg'] as $ext) {
                    $alt = public_path('images/missing pets/' . $baseName . '.' . $ext);
                    if (file_exists($alt)) {
                        $resolvedImage = asset('images/missing pets/' . $baseName . '.' . $ext);
                        break;
                    }
                }
            }
        }
        return [
            'pet_id' => $pet->pet_id,
            'pet_name' => $pet->pet_name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'gender' => $pet->gender,
            'age' => $pet->petInfo?->pet_age,
            'weight' => $pet->weight,
            'color' => $pet->color,
            'description' => $pet->notes,
            'location_barangay' => $report && $report->barangay ? $report->barangay->barangay_name : null,
            'location_description' => $report ? $report->location_description : null,
            'last_seen_at' => $report ? $report->last_seen_at : null,
            'pet_image' => $resolvedImage,
            'pet_status' => $pet->pet_status,
        ];
    });

    return response()->json([
        'pets' => $pets,
        'currentPage' => $missingPets->currentPage(),
        'lastPage' => $missingPets->lastPage(),
        'total' => $missingPets->total(),
    ]);
});

// Missing Pets Form Page Route
Route::get('/missing-pets/form', function () {
    $user = auth()->user();
    $petOwner = $user ? $user->petOwner()->with(['address' => function ($query) {
        $query->with('barangay');
    }])->first() : null;
    $pets = $petOwner ? $petOwner->pets : collect([]);

    $petsArray = $pets->map(function ($pet) {
        return [
            'id' => $pet->pet_id,
            'name' => $pet->pet_name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'gender' => $pet->gender,
            'is_neutered' => $pet->petInfo?->is_neutered,
            'age' => $pet->age,
            'weight' => $pet->weight,
            'image' => $pet->pet_image,
        ];
    })->toArray();

    $barangays = \App\Models\Barangay::orderBy('barangay_name')->get();

    return view('Client.missing_pets_form', compact('user', 'petOwner', 'petsArray', 'barangays'));
})->middleware('auth')->name('missing-pets.form');

Route::post('/missing-pets/report', [\App\Http\Controllers\Client\MissingPetReportController::class, 'store'])
    ->middleware('auth')
    ->name('missing-pets.report.store');

Route::get('/missing-pets/report', function () {
    return view('Client.missing_pets_landing');
})->name('missing-pets.report-landing');

Route::get('/missing-pets/report/guest', [\App\Http\Controllers\Client\GuestMissingPetReportController::class, 'create'])
    ->name('missing-pets.report.guest.create');

Route::post('/missing-pets/report/guest', [\App\Http\Controllers\Client\GuestMissingPetReportController::class, 'store'])
    ->name('missing-pets.report.guest.store');

// Pet Registration Page Route - Public
Route::get('/pet-registration', function () {
    return view('Client.pet_registration_page');
});

// Pet Registration Form Page Route - Protected
Route::get('/pet-registration/form', function () {
    $user = auth()->user();
    $petOwner = $user ? $user->petOwner()->with(['address' => function ($query) {
        $query->with('barangay');
    }])->first() : null;

    return view('Client.pet_registration_form', compact('user', 'petOwner'));
})->middleware('auth')->name('pet.registration.form');

// Pet Registration Form POST Route - Protected
Route::post('/pet-registration/form', [PetRegistrationController::class, 'store'])->name('pet.registration.store')->middleware('auth');

// Vaccination Page Route - Public
Route::get('/vaccination', function (Request $request) {
    $showSuccessModal = $request->query('booked') === '1';
    return view('Client.vaccination_page', compact('showSuccessModal'));
});

// Vaccination Form Page Route - Public
Route::get('/vaccination/form', function () {
    $user = auth()->user();
    $petOwner = $user ? $user->petOwner()->with(['address' => function ($query) {
        $query->with('barangay');
    }])->first() : null;
    $pets = $petOwner ? Pet::where('owner_id', $petOwner->owner_id)->get() : collect([]);

    $petsArray = $pets->map(function ($pet) {
        return [
            'id' => $pet->pet_id,
            'name' => $pet->pet_name,
            'species' => $pet->species,
            'breed' => $pet->breed,
            'gender' => $pet->gender,
            'color' => $pet->color,
            'age' => $pet->age,
            'weight' => $pet->weight,
            'vaccination_status' => $pet->vaccination_status,
            'vaccination_date' => $pet->vaccination_date,
            'next_vaccination_date' => $pet->next_vaccination_date,
            'birthdate' => $pet->birthdate,
            'image' => $pet->pet_image,
        ];
    })->toArray();

    $userId = $user ? $user->id : null;

    return view('Client.vaccination_form', compact('user', 'petOwner', 'petsArray', 'userId'));
});

// Vaccination Form POST Route
Route::post('/vaccination/form', function (Request $request) {
    $validated = $request->validate([
        // Owner info is derived from authenticated user
        'selected_pets' => 'required|array|min:1|max:3',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
        'pet_medical_history' => 'required|array',
        'pet_medical_history.*.has_previous_vaccine' => 'required|in:yes,no',
        'pet_medical_history.*.last_anti_rabies_date' => 'nullable|date',
        'pet_medical_history.*.clinic_name' => 'nullable|string|max:255',
        'pet_medical_history.*.vaccination_certificate' => 'nullable|string|max:255',
        'pet_medical_history.*.vaccine_lot_number' => 'nullable|string|max:6',
        'pet_medical_history.*.special_notes' => 'nullable|string|max:1000',
        'pet_medical_history.*.recent_surgery' => 'required|in:yes,no',
        'pet_medical_history.*.surgery_date' => 'nullable|date|before_or_equal:today',
        'pet_medical_history.*.vaccination_certificate_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'alt_mobile_number' => 'nullable|string|max:12',
    ]);

    // Parse selected_pets - now received as real array input
    $selectedPets = $validated['selected_pets'] ?? [];

    $user = auth()->user();

    // Check for duplicate appointment for the same user and datetime
    $scheduledAt = Carbon::parse($validated['appointment_date'].' '.$validated['appointment_time']);
    $existingAppointment = VaccinationAppointment::where('user_id', $user->id)
        ->where('scheduled_at', $scheduledAt)
        ->whereIn('status', ['pending', 'scheduled'])
        ->exists();

    if ($existingAppointment) {
        return redirect()->back()->with('error', 'You already have a vaccination appointment scheduled for this date and time.')->with('error_reason', 'slot_overbooked')->withInput();
    }

    // Check for slot availability with locking to prevent race conditions
    try {
        $bookingService = new AppointmentBookingService;
        $bookingService->checkAndBookVaccinationSlot(
            $validated['appointment_date'],
            $validated['appointment_time'],
            $user->id
        );
    } catch (AppointmentSlotTakenException $e) {
        return redirect()->back()->with('error', $e->getMessage())->with('error_reason', 'slot_overbooked')->withInput();
    }

    $petOwner = $user->petOwner;

    // Handle vaccination certificate file uploads
    $petMedicalHistory = $validated['pet_medical_history'] ?? [];

    if (!empty($request->file('pet_medical_history'))) {
        foreach ($request->file('pet_medical_history') as $petId => $petFiles) {
            if (isset($petFiles['vaccination_certificate_file']) && $petFiles['vaccination_certificate_file']->isValid()) {
                $file = $petFiles['vaccination_certificate_file'];
                $path = $file->store('vaccination-certificates', 'public');

                if (!isset($petMedicalHistory[$petId])) {
                    $petMedicalHistory[$petId] = [];
                }
                $petMedicalHistory[$petId]['vaccination_certificate_path'] = $path;
            }
        }
    }

    // Use existing owner address instead of creating a new one
    $addressId = $petOwner->address_id ?? null;
    if (!$addressId && $petOwner->address) {
        $addressId = $petOwner->address->id ?? null;
    }

    foreach ($selectedPets as $petId) {
        $history = $petMedicalHistory[$petId] ?? [];

        // Backend validation: rabies vaccination gap
        if (!empty($history['last_anti_rabies_date']) && !empty($validated['appointment_date'])) {
            $lastVaccinationDate = Carbon::parse($history['last_anti_rabies_date']);
            $appointmentDate = Carbon::parse($validated['appointment_date']);
            $monthsDiff = $lastVaccinationDate->diffInMonths($appointmentDate);
            
            if ($monthsDiff < 11) {
                return redirect()->back()->with('error', 'Rabies vaccination gap is too short for pet ' . $petId . '.')->with('error_reason', 'vaccination_too_early')->withInput();
            }
        }

        // Backend validation: recent surgery
        if (isset($history['recent_surgery']) && $history['recent_surgery'] === 'yes') {
            return redirect()->back()->with('error', 'Pet ' . $petId . ' has recent surgery and is not eligible for vaccination.')->with('error_reason', 'recent_surgery')->withInput();
        }

        $recentSurgery = null;
        if (isset($history['recent_surgery'])) {
            $recentSurgery = $history['recent_surgery'] === 'yes';
        } elseif (isset($history['recentSurgery'])) {
            $recentSurgery = $history['recentSurgery'] === true || $history['recentSurgery'] === 'true' || $history['recentSurgery'] === 'yes';
        }

        VaccinationAppointment::create([
            'user_id' => $user->id,
            'owner_id' => $petOwner->owner_id,
            'address_id' => $addressId,
            'pet_id' => $petId,
            'scheduled_at' => $scheduledAt,
            'status' => 'pending',
            'last_anti_rabies_date' => $history['last_anti_rabies_date'] ?? null,
            'recent_surgery' => $recentSurgery,
            'clinic_name' => $history['clinic_name'] ?? null,
            'vaccination_certificate' => $history['vaccination_certificate'] ?? null,
            'vaccine_lot_number' => $history['vaccine_lot_number'] ?? null,
            'vaccination_certificate_path' => $history['vaccination_certificate_path'] ?? null,
        ]);
    }

    return redirect('/vaccination?booked=1')->with('success', 'Vaccination request submitted successfully!');
})->middleware(['auth'])->name('vaccination.form.submit');

// Owner Dashboard Route - Protected (any authenticated user)
Route::get('/owner/dashboard', function () {
    return view('Client.owner_dashboard');
})->middleware(['auth'])->name('owner.dashboard');

// View Pets Route
Route::get('/owner/pets', function () {
    return view('Client.view_pets');
})->middleware(['auth'])->name('owner.pets');

// Edit Pet Route
Route::get('/owner/pets/{id}/edit', [PetController::class, 'edit'])->middleware(['auth'])->name('pet.edit');

// Update Pet Route
Route::put('/owner/pets/{id}', [PetController::class, 'update'])->middleware(['auth'])->name('pet.update');

// Delete Pet Route
Route::delete('/owner/pets/{id}', [PetController::class, 'destroy'])->middleware(['auth'])->name('pet.destroy');

// Submit Pet for Adoption Route
Route::post('/owner/pets/{pet}/submit-for-adoption', [AdoptionRequestController::class, 'submitForAdoption'])->middleware(['auth'])->name('pet.submit-for-adoption');

// ==============================
// PROFILE ROUTES (Authenticated Users)
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// BITE & RABIES REPORT - PUBLIC FORM
// ==============================
Route::get('/bite-rabies-report', [BiteRabiesReportController::class, 'create'])->name('bite-rabies-report.create');
Route::post('/bite-rabies-report', [BiteRabiesReportController::class, 'store'])->name('bite-rabies-report.store');
Route::get('/bite-rabies-report/success', [BiteRabiesReportController::class, 'success'])->name('bite-rabies-report.success');

require __DIR__.'/auth.php';
