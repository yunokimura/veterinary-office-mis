<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RabiesVaccinationReport;
use App\Models\BiteRabiesReport;
use App\Models\Barangay;

class ClinicController extends Controller
{
    /**
     * Show clinic dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $biteReports = BiteRabiesReport::latest()->take(5)->get();
        $rabiesReports = RabiesVaccinationReport::where('user_id', $user->id)->latest()->take(5)->get();

        $stats = [
            'total_bite' => BiteRabiesReport::count(),
            'total_rabies' => RabiesVaccinationReport::where('user_id', $user->id)->count(),
        ];

        return view('dashboard.clinic', compact('biteReports', 'rabiesReports', 'stats'));
    }

    /**
     * Show data entry form.
     */
    public function showDataEntry()
    {
        return view('dashboard.clinic-data-entry');
    }

    // ==============================
    // BITE REPORTS
    // ==============================

    /**
     * List clinic's bite reports.
     */
    public function indexBiteReports()
    {
        $reports = BiteRabiesReport::latest()->paginate(10);
        return view('dashboard.clinic-bite-reports', compact('reports'));
    }

    /**
     * Show bite report create form.
     */
    public function createBiteReport()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        $caseNumber = 'BITE-' . date('Y') . '-' . str_pad(BiteRabiesReport::count() + 1, 5, '0', STR_PAD_LEFT);
        return view('reports.animal_bite_form', compact('barangays', 'caseNumber'));
    }

    /**
     * Store bite report.
     */
    public function storeBiteReport(Request $request)
    {
        $validated = $request->validate([
            'victim_last_name' => 'required|string|max:255',
            'victim_first_name' => 'required|string|max:255',
            'victim_middle_name' => 'nullable|string|max:255',
            'victim_suffix' => 'nullable|string|max:50',
            'victim_case_id' => 'nullable|string|max:50',
            'victim_age' => 'required|integer|min:0|max:150',
            'victim_sex' => 'required|in:male,female',
            'victim_contact' => 'nullable|string|max:11',
            'victim_address' => 'required|string|max:500',
            'victim_barangay' => 'nullable|string|max:255',
            'incident_barangay' => 'required|string|max:255',
            'exact_location' => 'nullable|string|max:500',
            'incident_date' => 'required|date',
            'animal_type' => 'required|in:dog,cat',
            'animal_gender' => 'nullable|in:male,female',
            'ownership_status' => 'required|in:owned,stray',
            'vaccination_status' => 'nullable|in:vaccinated,unvaccinated,unknown',
            'bite_category' => 'required|in:category_i,category_ii,category_iii',
            'body_part' => 'required|string|max:255',
            'location_description' => 'nullable|string|max:500',
            'pep' => 'nullable|in:yes,no',
            'wound_management' => 'nullable|array',
            'hospital_referred' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $barangay = \App\Models\Barangay::where('barangay_name', $validated['incident_barangay'])->first();
        $barangayId = $barangay ? $barangay->barangay_id : null;

        $reportNumber = $validated['victim_case_id']
            ? $validated['victim_case_id']
            : ($request->input('case_number') ?? BiteRabiesReport::generateReportNumber());

        $report = BiteRabiesReport::create([
            'report_number' => $reportNumber,
            'date_reported' => now()->toDateString(),
            'barangay_id' => $barangayId,
            'incident_date' => \Carbon\Carbon::parse($validated['incident_date'])->toDateString(),
            'exact_location' => $validated['exact_location'] ?? null,
            'exposure_type' => 'bite',
            'bite_site' => $validated['body_part'],
            'category' => strtoupper(str_replace('category_', '', $validated['bite_category'])),
            'animal_type' => $validated['animal_type'],
            'animal_gender' => $validated['animal_gender'] ?? null,
            'animal_status' => $validated['ownership_status'],
            'vaccination_status' => $validated['vaccination_status'] ?? 'unknown',
            'notes' => $validated['remarks'] ?? '',
        ]);

        return redirect()->route('clinic.bite-reports.index')
            ->with('success', 'Bite report submitted successfully!');
    }

    /**
     * Show bite report detail.
     */
    public function showBiteReport(BiteRabiesReport $report)
    {
        return view('dashboard.clinic-bite-report-view', compact('report'));
    }

    // ==============================
    // RABIES VACCINATION REPORTS
    // ==============================

    /**
     * Show rabies vaccination report form.
     */
    public function createVaccinationReport()
    {
        return view('reports.rabies_vaccination_form');
    }

    /**
     * Store rabies vaccination report.
     */
    public function storeVaccinationReport(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:255',
            'patient_address' => 'required|string',
            'pet_name' => 'nullable|string|max:255',
            'pet_species' => 'required|string|max:255',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer|min:0|max:30',
            'pet_gender' => 'nullable|string|in:male,female',
            'pet_color' => 'nullable|string|max:255',
            'vaccine_brand' => 'required|string|max:255',
            'vaccine_batch_number' => 'nullable|string|max:255',
            'vaccination_date' => 'required|date',
            'vaccination_time' => 'required',
            'vaccination_type' => 'required|string|in:primary,booster',
        ]);

        $report = RabiesVaccinationReport::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('clinic.vaccination-reports.index')
            ->with('success', 'Rabies vaccination report submitted successfully!');
    }

    /**
     * List rabies vaccination reports.
     */
    public function indexVaccinationReports()
    {
        $reports = RabiesVaccinationReport::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('reports.rabies_vaccination_index', compact('reports'));
    }

    /**
     * Show rabies vaccination report detail.
     */
    public function showVaccinationReport(RabiesVaccinationReport $report)
    {
        return view('reports.rabies_vaccination_show', compact('report'));
    }
}
