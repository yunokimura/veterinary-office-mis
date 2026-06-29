<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BiteRabiesReport;
use App\Models\RabiesVaccinationReport;
use App\Models\MeatInspectionReport;
use App\Models\MeatEstablishment;
use App\Models\ImpoundRecord;
use App\Models\User;
use App\Models\Announcement;
use App\Models\StrayReport;
use App\Models\SystemLog;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (System Admin - Full Access).
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Viewers cannot access the admin dashboard - redirect to their own
        if ($user->hasRole('viewer')) {
            return redirect()->route('viewer.dashboard');
        }

        // Get statistics
        $stats = [
            'total_bite_reports' => BiteRabiesReport::count(),
            'pending_bite_reports' => BiteRabiesReport::where('status', 'Pending Review')->count(),
            'total_vaccination_reports' => RabiesVaccinationReport::count(),
            'total_meat_inspection_reports' => MeatInspectionReport::count(),
            'total_users' => User::count(),
            'compliant_meat_inspections' => MeatInspectionReport::where('compliance_status', 'compliant')->count(),
        ];

        // Get recent reports
        $recent_bites = BiteRabiesReport::latest()->take(5)->get();
        $recent_vaccinations = RabiesVaccinationReport::latest()->take(5)->get();
        $recent_meat_inspections = MeatInspectionReport::latest()->take(5)->get();

        return view('dashboard.admin', compact('user', 'stats', 'recent_bites', 'recent_vaccinations', 'recent_meat_inspections'));
    }

    /**
     * Show all reports (city-wide view).
     */
    public function allReports()
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('super_admin');

        // Get all statistics from database
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_announcements' => Announcement::count(),
            'total_bite_reports' => BiteRabiesReport::count(),
            'total_vaccinations' => RabiesVaccinationReport::count(),
            'total_meat_inspections' => MeatInspectionReport::count(),
            'total_stray_reports' => StrayReport::count(),
        ];

        // Bite reports by status
        $biteStats = [
            'pending' => BiteRabiesReport::where('status', 'Pending Review')->count(),
            'investigating' => BiteRabiesReport::where('status', 'Under Review')->count(),
            'resolved' => BiteRabiesReport::where('status', 'Resolved')->count(),
        ];

        // Rabies vaccinations by species
        $vaccinationStats = [
            'dogs' => RabiesVaccinationReport::where('pet_species', 'dog')->count(),
            'cats' => RabiesVaccinationReport::where('pet_species', 'cat')->count(),
            'other' => RabiesVaccinationReport::where('pet_species', 'other')->count(),
        ];

        // Meat inspections by compliance status
        $meatInspectionStats = [
            'compliant' => MeatInspectionReport::where('compliance_status', 'compliant')->count(),
            'non_compliant' => MeatInspectionReport::where('compliance_status', 'non_compliant')->count(),
            'pending' => MeatInspectionReport::where('compliance_status', 'pending')->count(),
        ];

        // User distribution by role
        $userRoles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        // Recent activity (bite reports)
        $recentActivity = BiteRabiesReport::latest()->take(5)->get();

        // Get reports for export/generation
        $biteReports = BiteRabiesReport::latest()->get();
        $vaccinationReports = RabiesVaccinationReport::latest()->get();
        $inspectionReports = MeatInspectionReport::latest()->get();

        // Additional data for super_admin view
        $recentAnnouncements = Announcement::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // For super_admin, show simplified user-focused view
        if ($isSuperAdmin) {
            return view('super-admin.all-reports', compact(
                'user',
                'isSuperAdmin',
                'stats',
                'biteStats',
                'vaccinationStats',
                'meatInspectionStats',
                'userRoles',
                'recentActivity',
                'recentAnnouncements',
                'recentUsers',
                'biteReports',
                'vaccinationReports',
                'inspectionReports'
            ));
        }

        // For other admins (city_vet), show full reports view
        return view('admin.all-reports', compact(
            'user',
            'isSuperAdmin',
            'stats',
            'biteStats',
            'vaccinationStats',
            'meatInspectionStats',
            'userRoles',
            'recentActivity',
            'biteReports',
            'vaccinationReports',
            'inspectionReports'
        ));
    }

    /**
     * List all confirmed rabies reports.
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();

        // Get counts for confirmed rabies cases only
        $stats = [
            'total' => BiteRabiesReport::where('rabies_confirmed', true)->count(),
            'dog_cases' => BiteRabiesReport::where('rabies_confirmed', true)->whereRaw('LOWER(animal_type) = ?', ['dog'])->count(),
            'cat_cases' => BiteRabiesReport::where('rabies_confirmed', true)->whereRaw('LOWER(animal_type) = ?', ['cat'])->count(),
            'other_cases' => BiteRabiesReport::where('rabies_confirmed', true)->whereRaw('LOWER(animal_type) = ?', ['other'])->count(),
            'confirmed_this_year' => BiteRabiesReport::where('rabies_confirmed', true)->whereYear('incident_date', date('Y'))->count(),
        ];

        $query = BiteRabiesReport::where('rabies_confirmed', true)
            ->with(['barangay']);

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = \Carbon\Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('incident_date', $today);
                    break;
                case 'week':
                    $query->where('incident_date', '>=', \Carbon\Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('incident_date', '>=', \Carbon\Carbon::now()->startOfMonth());
                    break;
            }
        }

        $reports = $query->latest()->paginate(10);
        return view('dashboard.bite-reports', compact('user', 'reports', 'stats'));
    }

    /**
     * Show bite report details (JSON for modal).
     */
    public function showBiteReportJson(BiteRabiesReport $report)
    {
        $report->load(['barangay', 'patientBarangay', 'reportedBy']);
        
        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'report_number' => $report->report_number,
                'status' => $report->status,
                'patient_name' => trim(($report->patient_first_name ?? '') . ' ' . ($report->patient_middle_name ?? '') . ' ' . ($report->patient_last_name ?? '') . ' ' . ($report->patient_suffix ?? '')),
                'age' => $report->age,
                'gender' => $report->gender,
                'patient_address' => $report->patient_address,
                'patient_contact' => $report->patient_contact,
                'barangay' => $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A'),
                'incident_date' => \Carbon\Carbon::parse($report->incident_date)->format('M d, Y'),
                'exact_location' => $report->exact_location,
                'exposure_type' => $report->exposure_type,
                'bite_site' => $report->bite_site,
                'category' => $report->category,
                'animal_type' => ucfirst($report->animal_type),
                'animal_status' => ucfirst($report->animal_status),
                'vaccination_status' => $report->vaccination_status,
                'animal_owner_name' => $report->animal_owner_name,
                'animal_owner_contact' => $report->animal_owner_contact,
                'reporting_facility' => $report->reporting_facility,
                'wound_management' => is_array($report->wound_management) ? implode(', ', $report->wound_management) : 'None',
                'post_exposure_prophylaxis' => $report->post_exposure_prophylaxis,
                'notes' => $report->notes,
                'rabies_confirmed' => $report->rabies_confirmed ? 'Yes' : 'No',
                'created_at' => $report->created_at->format('M d, Y h:i A'),
            ]
        ]);
    }

    /**
     * Show bite report details.
     */
    public function showBiteReport(BiteRabiesReport $report)
    {
        $user = Auth::user();
        $report->load(['patientBarangay', 'user']);
        return view('dashboard.bite-reports.show', compact('report', 'user'));
    }

    /**
     * List all rabies vaccination reports (from Clinic).
     */
    public function indexVaccinationReports(Request $request)
    {
        $user = Auth::user();
        
        $query = RabiesVaccinationReport::latest();

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('vaccination_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('vaccination_date', '<=', $request->date_to);
        }

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = \Carbon\Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('vaccination_date', $today);
                    break;
                case 'week':
                    $query->where('vaccination_date', '>=', \Carbon\Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('vaccination_date', '>=', \Carbon\Carbon::now()->startOfMonth());
                    break;
            }
        }

        $reports = $query->paginate(10);
        return view('dashboard.vaccination-reports', compact('user', 'reports'));
    }

    /**
     * Show rabies vaccination report details (JSON for modal).
     */
    public function showVaccinationReportJson(RabiesVaccinationReport $report)
    {
        $report->load(['user', 'barangay']);
        
        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'report_number' => 'RV-' . str_pad($report->id, 5, '0', STR_PAD_LEFT),
                'clinic_name' => $report->clinic_name,
                'patient_name' => $report->patient_name,
                'patient_contact' => $report->patient_contact,
                'patient_address' => $report->patient_address,
                'pet_name' => $report->pet_name,
                'pet_species' => ucfirst($report->pet_species),
                'pet_breed' => $report->pet_breed,
                'pet_age' => $report->pet_age,
                'pet_gender' => ucfirst($report->pet_gender),
                'pet_color' => $report->pet_color,
                'vaccine_brand' => $report->vaccine_brand,
                'vaccine_batch_number' => $report->vaccine_batch_number,
                'vaccination_date' => \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y'),
                'vaccination_time' => $report->vaccination_time,
                'next_vaccination_date' => $report->next_vaccination_date ? \Carbon\Carbon::parse($report->next_vaccination_date)->format('M d, Y') : 'N/A',
                'weight' => $report->weight,
                'vaccination_type' => ucfirst($report->vaccination_type),
                'observations' => $report->observations,
                'status' => $report->status,
                'notes' => $report->notes,
                'barangay' => optional($report->barangay)->barangay_name ?? 'N/A',
                'created_at' => $report->created_at->format('M d, Y h:i A'),
            ]
        ]);
    }

    /**
     * Show rabies vaccination report details.
     */
    public function showVaccinationReport(RabiesVaccinationReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.vaccination-report-view', compact('report', 'user'));
    }

    /**
     * List all meat establishments.
     */
    public function indexMeatInspectionReports()
    {
        $user = Auth::user();
        $establishments = MeatEstablishment::with('barangay')->latest()->paginate(10);
        return view('dashboard.meat-inspection', compact('user', 'establishments'));
    }

    /**
     * Show meat inspection report details.
     */
    public function showMeatInspectionReport(MeatInspectionReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.meat-inspection-view', compact('report', 'user'));
    }

    /**
     * Show meat establishment details (JSON for modal).
     */
    public function showMeatEstablishmentJson(MeatEstablishment $establishment)
    {
        $establishment->load('barangay', 'user');
        
        return response()->json([
            'success' => true,
            'establishment' => [
                'id' => $establishment->establishment_id,
                'establishment_name' => $establishment->establishment_name,
                'establishment_type' => ucfirst(str_replace('_', ' ', $establishment->establishment_type)),
                'owner_name' => $establishment->owner_name,
                'contact_person' => $establishment->contact_person,
                'contact_number' => $establishment->contact_number,
                'email' => $establishment->email,
                'address_text' => $establishment->address_text,
                'landmark' => $establishment->landmark,
                'permit_no' => $establishment->permit_no,
                'inspection_date' => $establishment->inspection_date ? \Carbon\Carbon::parse($establishment->inspection_date)->format('M d, Y') : 'N/A',
                'status' => $establishment->status,
                'permit_expiry_date' => $establishment->permit_expiry_date ? \Carbon\Carbon::parse($establishment->permit_expiry_date)->format('M d, Y') : 'N/A',
                'barangay' => optional($establishment->barangay)->barangay_name ?? 'N/A',
                'registered_by' => optional($establishment->user)->name ?? 'N/A',
                'created_at' => $establishment->created_at->format('M d, Y h:i A'),
            ]
        ]);
    }

    /**
     * List all impound records.
     */
    public function indexImpoundRecords()
    {
        $user = Auth::user();
        $impounds = ImpoundRecord::with('strayReport')->latest()->paginate(10);
        return view('dashboard.impound-records', compact('user', 'impounds'));
    }

    /**
     * Update animal bite report status.
     */
    public function updateBiteReport(Request $request, BiteRabiesReport $report)
    {
        $request->validate([
            'status' => 'required|in:Pending Review,Under Review,Resolved,Closed',
        ]);

        $report->update(['status' => $request->status]);

        return redirect()->route('admin.bite-reports.index')->with('success', 'Report status updated successfully.');
    }
}
