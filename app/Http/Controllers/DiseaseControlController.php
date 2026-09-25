<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BiteRabiesReport;
use Carbon\Carbon;

/**
 * DiseaseControlController - Assistant Veterinarian Module
 *
 * THESIS ROLE MAPPING:
 * - Primary Role: assistant_vet (Assistant Veterinarian / Vet 3)
 *
 * MODule ASSIGNMENTS:
 * - Rabies Case Management (CRUD)
 * - Animal Bite Reports (Clinical Actions)
 * - Vaccination Records
 * - Spay/Neuter Program
 * - Cruelty Assessment
 *
 * ACCESSIBLE ROUTES:
 * - assistant-vet.dashboard
 * - rabies-cases.*
 * - assistant-vet.animal-bite-reports.*
 * - assistant-vet.vaccinations.*
 */
class DiseaseControlController extends Controller
{
    /**
     * Show disease control / Assistant Vet dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total' => BiteRabiesReport::count(),
            'pending' => BiteRabiesReport::count(),
        ];

        $recentCases = BiteRabiesReport::with(['barangay'])
            ->latest()
            ->take(5)
            ->get();

        $recentReports = BiteRabiesReport::latest()->take(5)->get();

        return view('dashboard.assistant-veterinary', compact('user', 'stats', 'recentCases', 'recentReports'));
    }

    /**
     * List rabies cases.
     */
    public function indexCases(Request $request)
    {
        $user = Auth::user();
        $query = BiteRabiesReport::with(['barangay']);

        $cases = $query->latest()->paginate(10);
        return view('dashboard.rabies-cases', compact('user', 'cases'));
    }

    /**
     * List animal bite reports.
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();

        $stats = [
            'total' => BiteRabiesReport::count(),
            'pending' => BiteRabiesReport::count(),
        ];

        $query = BiteRabiesReport::with(['barangay']);

        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('created_at', $today);
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
            }
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(15);

        return view('dashboard.bite-reports', compact('user', 'reports', 'stats'));
    }

    /**
     * Show rabies case details.
     */
    public function showCase(BiteRabiesReport $case)
    {
        $case->load(['barangay']);
        return view('dashboard.rabies-cases.show', compact('case'));
    }

    /**
     * List vaccination records.
     */
    public function indexVaccinations(Request $request)
    {
        $user = Auth::user();
        $reports = \App\Models\VaccinationReport::latest()->paginate(10);
        return view('dashboard.vaccination-reports', compact('user', 'reports'));
    }

    /**
     * Show create vaccination form.
     */
    public function createVaccination()
    {
        return redirect()->route('admin-staff.vaccinations.index')
            ->with('info', 'Vaccination creation is available through the Clinic portal.');
    }

    /**
     * Store new vaccination.
     */
    public function storeVaccination(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vaccine_type' => 'required|string',
            'vaccination_date' => 'required|date',
            'next_vaccination_date' => 'nullable|date',
            'batch_number' => 'nullable|string',
            'veterinarian' => 'nullable|string',
        ]);

        $validated['vaccinated_by'] = auth()->id();
        \App\Models\VaccinationAppointment::create($validated);

        return redirect()->route('admin-staff.vaccinations.index')
            ->with('success', 'Vaccination recorded successfully.');
    }

    /**
     * List spay/neuter records.
     */
    public function indexSpayNeuter(Request $request)
    {
        $reports = \App\Models\SpayNeuterReport::with(['barangay'])
            ->latest()
            ->paginate(10);

        $totalReports = \App\Models\SpayNeuterReport::count();
        $completed = \App\Models\SpayNeuterReport::where('status', 'completed')->count();
        $scheduled = \App\Models\SpayNeuterReport::where('status', 'scheduled')->count();

        return view('dashboard.spay-neuter', compact('reports', 'totalReports', 'completed', 'scheduled'));
    }

    /**
     * Show create spay/neuter form.
     */
    public function createSpayNeuter()
    {
        return view('dashboard.spay-neuter.create');
    }

    /**
     * Store new spay/neuter record.
     */
    public function storeSpayNeuter(Request $request)
    {
        $validated = $request->validate([
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => 'required|string',
            'procedure_type' => 'required|string',
            'procedure_date' => 'required|date',
            'vet_name' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
        ]);

        $validated['recorded_by'] = auth()->id();
        \App\Models\SpayNeuterReport::create($validated);

        return redirect()->route('disease-control.spay-neuter.index')
            ->with('success', 'Spay/Neuter record created successfully.');
    }

    /**
     * List confirmed rabies reports for city_vet.
     */
    public function indexRabiesReports(Request $request)
    {
        $user = Auth::user();

        $query = BiteRabiesReport::with(['barangay']);

        if ($request->has('source') && $request->source) {
            $query->where('report_source', $request->source);
        }

        $stats = [
            'total' => BiteRabiesReport::count(),
            'dog_cases' => BiteRabiesReport::where('animal_type', 'dog')->count(),
            'cat_cases' => BiteRabiesReport::where('animal_type', 'cat')->count(),
        ];

        $reports = $query->latest()->paginate(10);

        return view('dashboard.bite-rabies-reports.index', compact('user', 'reports', 'stats'));
    }

    /**
     * Show rabies bite report details.
     */
    public function showRabiesReport(BiteRabiesReport $rabiesReport)
    {
        $rabiesReport->load(['barangay']);
        return view('dashboard.bite-rabies-reports.show', compact('rabiesReport'));
    }

    /**
     * Show form to create Rabies Case from Rabies Report.
     */
    public function createBiteRabiesReportFromReport(BiteRabiesReport $rabiesReport)
    {
        $barangays = \App\Models\Barangay::pluck('barangay_name', 'barangay_id');

        $prefill = [
            'case_type' => 'suspect',
            'species' => $this->mapSpecies($rabiesReport->animal_type),
            'animal_name' => $rabiesReport->animal_owner_name ?? $rabiesReport->report_number,
            'owner_name' => $rabiesReport->animal_owner_name,
            'incident_date' => $rabiesReport->incident_date,
            'incident_location' => $rabiesReport->barangay->barangay_name ?? '',
            'barangay_id' => $rabiesReport->barangay_id ?? null,
            'remarks' => $this->generateRemarksFromReport($rabiesReport),
        ];

        return view('rabies-cases.create', compact('barangays', 'prefill', 'rabiesReport'));
    }

    /**
     * Store Rabies Case created from Bite & Rabies Report.
     */
    public function storeBiteRabiesReportFromReport(Request $request, BiteRabiesReport $rabiesReport)
    {
        $validated = $request->validate([
            'case_type' => 'required|string|in:positive,probable,suspect,negative',
            'species' => 'required|string|in:dog,cat,other',
            'animal_name' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'incident_date' => 'required|date',
            'incident_location' => 'nullable|string',
            'findings' => 'nullable|string',
            'actions_taken' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $validated['rabies_report_id'] = $rabiesReport->id;

        if (empty($validated['case_number'])) {
            $validated['case_number'] = 'RAB-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        $case = BiteRabiesReport::create($validated);

        $rabiesReport->update([
            'notes' => ($rabiesReport->notes ? $rabiesReport->notes . "\n\n" : '') . 'Converted to Rabies Case: ' . $case->case_number,
        ]);

        return redirect()->route('rabies-cases.show', $case)
            ->with('success', 'Rabies Case created successfully from the report!');
    }

    /**
     * Map species from RabiesReport to BiteRabiesReport format.
     */
    private function mapSpecies(string $reportSpecies): string
    {
        return match($reportSpecies) {
            'Dog' => 'dog',
            'Cat' => 'cat',
            default => 'other',
        };
    }

    /**
     * Generate remarks from Rabies Report data.
     */
    private function generateRemarksFromReport(BiteRabiesReport $report): string
    {
        $remarks = [];
        $remarks[] = "Created from Rabies Bite Report: {$report->report_number}";
        $remarks[] = "Nature of Incident: {$report->nature_of_incident}";
        $remarks[] = "Exposure Category: {$report->exposure_category}";
        $remarks[] = "Animal Status: {$report->animal_status}";
        $remarks[] = "Vaccination Status: {$report->animal_vaccination_status}";
        $remarks[] = "Current Condition: {$report->animal_current_condition}";
        $remarks[] = "Bite Site: {$report->bite_site}";

        return implode('\n', $remarks);
    }
}
