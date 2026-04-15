<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\OtpController;
use App\Http\Controllers\Client\PetController;
use App\Http\Controllers\Client\PetRegistrationController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ServiceFormController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RabiesCaseController;
use App\Http\Controllers\BarangayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes (No Authentication Required)
Route::prefix('public')->name('api.public.')->group(function () {
    // Landing page - API root returns JSON
    Route::get('/', function () {
        return response()->json([
            'message' => 'Vet MIS API',
            'version' => '1.0',
            'endpoints' => [
                'public/announcements',
                'public/certificates/verify/{series}',
                'public/service-forms',
                'auth/otp/*',
            ]
        ]);
    });

    // Public Announcements
    Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'publicShow'])->name('announcements.show');
    
    // Public Barangays (for map display)
    Route::get('/barangays', function () {
        return response()->json(\App\Models\Barangay::select('barangay_id', 'barangay_name', 'latitude', 'longitude')->whereNotNull('latitude')->whereNotNull('longitude')->get());
    })->name('barangays.index');

    // Service Forms (Public submission)
    Route::post('/service-forms', [ServiceFormController::class, 'apiStore'])->middleware('throttle:5,1')->name('service-forms.store');

    // Certificate Verification
    Route::get('/certificates/verify/{certificateSeries}', [CertificateController::class, 'verify'])->name('certificates.verify');
});

// Authentication Routes (Mobile App)
Route::prefix('auth')->name('api.auth.')->group(function () {
    // Send OTP
    Route::post('/otp/send', [OtpController::class, 'sendOtp'])->middleware('throttle:3,1')->name('otp.send');

    // Verify OTP
    Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('otp.verify');

    // Resend OTP
    Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->middleware('throttle:3,1')->name('otp.resend');

    // Send OTP for Password Reset
    Route::post('/otp/reset/send', [OtpController::class, 'sendResetOtp'])->middleware('throttle:3,1')->name('otp.reset.send');

    // Verify OTP for Password Reset
    Route::post('/otp/reset/verify', [OtpController::class, 'verifyResetOtp'])->middleware('throttle:5,1')->name('otp.reset.verify');
});

// Protected Routes (Authentication Required)
Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user');

    // User Profile
    Route::prefix('profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Pet Management (for Pet Owners)
    Route::prefix('pets')->name('api.pets.')->group(function () {
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::post('/', [PetRegistrationController::class, 'store'])->name('store');
        Route::get('/{pet}', [PetController::class, 'show'])->name('show');
        Route::put('/{pet}', [PetController::class, 'update'])->name('update');
        Route::delete('/{pet}', [PetController::class, 'destroy'])->name('destroy');
    });

    // Device Token Routes (Push Notifications)
    Route::prefix('device-tokens')->name('api.device-tokens.')->group(function () {
        Route::post('/', [DeviceTokenController::class, 'store'])->name('store');
        Route::get('/', [DeviceTokenController::class, 'index'])->name('index');
        Route::put('/usage', [DeviceTokenController::class, 'updateUsage'])->name('update-usage');
        Route::delete('/', [DeviceTokenController::class, 'destroy'])->name('destroy');
    });

    // Authenticated Announcements
    Route::prefix('announcements')->name('api.announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::post('/mark-read', [AnnouncementController::class, 'markAsRead'])->name('mark-read');
        Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
    });

    // Rabies Heatmap Data (for visualizations)
    // Access: city_vet (full), super_admin (view-only)
    Route::prefix('rabies')->name('api.rabies.')->group(function () {
        Route::get('/heatmap', [RabiesCaseController::class, 'heatmap'])->name('heatmap');
        Route::get('/heatmap-data', [RabiesCaseController::class, 'getHeatmapData'])->name('heatmap-data');
        Route::get('/incidents', [RabiesCaseController::class, 'getIncidents'])->name('incidents');
        Route::get('/barangays', [RabiesCaseController::class, 'getBarangaysWithCaseCounts'])->name('barangays');
    });

    // Service Forms (Authenticated)
    Route::prefix('service-forms')->name('api.service-forms.')->group(function () {
        Route::get('/', [ServiceFormController::class, 'apiIndex'])->name('index');
        Route::get('/{serviceForm}', [ServiceFormController::class, 'apiShow'])->name('show');
    });
});

// Appointment Slots (Public - for kapon only)
Route::get('/appointments/slots', function (Request $request) {
    $date = $request->query('date');
    $serviceType = 'kapon'; // Only kapon for now
    
    if (!$date) {
        return response()->json(['success' => false, 'message' => 'Date is required'], 400);
    }
    
    // Kapon capacity: 2 per hour, 12 per day
    $hourlyCapacity = 2;
    $dailyCapacity = 12;
    
    // Time slots: 8 AM to 4 PM (removed 12:00 and 16:00)
    $timeSlots = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00'];
    
    // Get existing kapon appointments from appointments table
    $existingByHour = \App\Models\Appointment::where('appointment_date', $date)
        ->where('service_type', 'kapon')
        ->get()
        ->groupBy('appointment_time')
        ->map(fn($group) => $group->count())
        ->toArray();
    
    // Get kapon requests from spay_neuter_reports table (pending + scheduled)
    $existingKapon = \App\Models\SpayNeuterReport::whereDate('scheduled_at', $date)
        ->whereIn('status', ['pending', 'scheduled'])
        ->whereNotNull('scheduled_at')
        ->get();
    
    // Count by hour from spay_neuter_reports
    $reportsByHour = [];
    foreach ($existingKapon as $report) {
        $time = date('H:00', strtotime($report->scheduled_at));
        if (!isset($reportsByHour[$time])) {
            $reportsByHour[$time] = 0;
        }
        $reportsByHour[$time]++;
    }
    
    // Merge counts from both tables
    $combinedByHour = [];
    foreach ($timeSlots as $time) {
        $combinedByHour[$time] = ($existingByHour[$time] ?? 0) + ($reportsByHour[$time] ?? 0);
    }
    
    // Build slot data
    $slots = collect($timeSlots)->map(function ($time) use ($combinedByHour, $hourlyCapacity) {
        $count = $combinedByHour[$time] ?? 0;
        
        $status = 'available';
        if ($count >= $hourlyCapacity) {
            $status = 'full';
        } elseif ($count >= $hourlyCapacity - 1) {
            $status = 'limited';
        }
        
        return [
            'time' => $time,
            'display_time' => \Carbon\Carbon::parse($time)->format('h:i A'),
            'status' => $status,
            'is_past' => false,
            'remaining' => max(0, $hourlyCapacity - $count),
        ];
    })->toArray();
    
    $dailyRemaining = max(0, $dailyCapacity - array_sum($combinedByHour));
    
    return response()->json([
        'success' => true,
        'slots' => $slots,
        'daily_weight_used' => array_sum($combinedByHour),
        'daily_remaining' => $dailyRemaining,
        'capacity_limit' => $dailyCapacity,
        'hourly_capacity' => $hourlyCapacity,
        'service_type' => 'kapon',
    ]);
})->name('api.appointments.slots');

// Check if a specific pet already has a kapon appointment
Route::get('/appointments/check-pet/{petName}/{userId}', function ($petName, $userId) {
    $existingAppointment = \App\Models\SpayNeuterReport::where('user_id', $userId)
        ->where('pet_name', $petName)
        ->whereIn('status', ['pending', 'scheduled'])
        ->whereNotNull('scheduled_at')
        ->orderBy('scheduled_at', 'asc')
        ->first();
    
    if ($existingAppointment) {
        return response()->json([
            'success' => true,
            'already_booked' => true,
            'pet_name' => $petName,
            'scheduled_at' => $existingAppointment->scheduled_at,
            'scheduled_date' => \Carbon\Carbon::parse($existingAppointment->scheduled_at)->format('F j, Y'),
            'scheduled_time' => \Carbon\Carbon::parse($existingAppointment->scheduled_at)->format('h:i A'),
            'status' => $existingAppointment->status,
        ]);
    }
    
    return response()->json([
        'success' => true,
        'already_booked' => false,
        'pet_name' => $petName,
    ]);
});

// Additional Public API endpoints can be added as needed
