<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Pet;
use App\Models\SpayNeuterReport;
use App\Services\NotificationService;
use App\Services\VeterinarianRotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpayNeuterController extends Controller
{
    /**
     * Show spay/neuter dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reports = SpayNeuterReport::where('user_id', $user->id)
            ->with(['owner', 'pet'])
            ->latest()
            ->take(5)
            ->get();

        $totalReports = SpayNeuterReport::count();
        $completed = SpayNeuterReport::where('status', 'completed')->count();
        $scheduled = SpayNeuterReport::where('status', 'scheduled')->count();

        return view('dashboard.spay-neuter', compact('reports', 'totalReports', 'completed', 'scheduled'));
    }

    /**
     * Show spay/neuter report form.
     */
    public function create()
    {
        $pets = Pet::with('owner')->orderBy('pet_name')->get();
        $report = null;

        return view('reports.spay_neuter_form', compact('pets', 'report'));
    }

    /**
     * Store spay/neuter report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,pet_id',
            'procedure_type' => 'required|string|in:spay,neuter',
            'scheduled_at' => 'required|date',
            'veterinarian' => 'nullable|in:City Veterinarian,Assistant Veterinarian',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:scheduled,completed,cancelled,pending',
            'remarks' => 'nullable|string',
        ]);

        // Load pet and derive owner and barangay
        $pet = Pet::with('owner')->findOrFail($validated['pet_id']);
        $owner = $pet->owner;
        if (! $owner) {
            return redirect()->back()->with('error', 'Selected pet has no owner.')->withInput();
        }

        // Resolve barangay from owner's barangay string
        $barangay = null;
        if ($owner->barangay) {
            $barangay = Barangay::firstOrCreate(
                ['barangay_name' => $owner->barangay],
                ['city' => 'Dasmariñas City', 'province' => 'Cavite', 'status' => 'active']
            );
        }

        $validated['user_id'] = Auth::id();
        $validated['owner_id'] = $owner->owner_id;
        $validated['barangay_id'] = $barangay?->barangay_id;
        $validated['report_date'] = now();

        // If veterinarian not provided, use rotation service to assign
        if (empty($validated['veterinarian'])) {
            $rotationService = new VeterinarianRotationService;
            $validated['veterinarian'] = $rotationService->assignVeterinarian();
        }

        SpayNeuterReport::create($validated);

        NotificationService::spayNeuterCreated(SpayNeuterReport::latest()->first()->id);

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report submitted successfully!');
    }

    /**
     * List spay/neuter reports.
     */
    public function index(Request $request)
    {
        $query = SpayNeuterReport::query()->with(['pet', 'owner', 'barangay']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by procedure type
        if ($request->has('procedure_type') && $request->procedure_type) {
            $query->where('procedure_type', $request->procedure_type);
        }

        // Filter by pet type/species
        if ($request->has('pet_type') && $request->pet_type) {
            $query->whereHas('pet', function ($q) use ($request) {
                $q->where('species', $request->pet_type);
            });
        }

        // Filter by date range (scheduled_at)
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('scheduled_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('scheduled_at', '<=', $request->end_date);
        }

        // Non-admin users can only see their own reports
        if (! Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'assistant_vet'])) {
            $query->where('user_id', Auth::id());
        }

        $reports = $query->latest()->paginate(10);

        return view('reports.spay_neuter_index', compact('reports'));
    }

    /**
     * Show spay/neuter report details.
     */
    public function show(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);

        return view('reports.spay_neuter_show', compact('report'));
    }

    /**
     * Edit spay/neuter report.
     */
    public function edit(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);
        $pets = Pet::with('owner')->orderBy('pet_name')->get();
        // Eager load relationships for the report to pre-select pet and display owner/barangay
        $report->load(['pet', 'owner', 'barangay']);

        return view('reports.spay_neuter_form', compact('report', 'pets'));
    }

    /**
     * Update spay/neuter report.
     */
    public function update(Request $request, SpayNeuterReport $report)
    {
        $this->authorizeReport($report);

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,pet_id',
            'procedure_type' => 'required|string|in:spay,neuter',
            'scheduled_at' => 'nullable|date',
            'veterinarian' => 'nullable|in:City Veterinarian,Assistant Veterinarian',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:scheduled,completed,cancelled,pending',
            'remarks' => 'nullable|string',
        ]);

        // Re-derive owner_id and barangay_id from the selected pet
        $pet = Pet::with('owner')->findOrFail($validated['pet_id']);
        $owner = $pet->owner;
        if (! $owner) {
            return redirect()->back()->with('error', 'Selected pet has no owner.')->withInput();
        }

        $barangay = null;
        if ($owner->barangay) {
            $barangay = Barangay::firstOrCreate(
                ['barangay_name' => $owner->barangay],
                ['city' => 'Dasmariñas City', 'province' => 'Cavite', 'status' => 'active']
            );
        }

        $validated['owner_id'] = $owner->owner_id;
        $validated['barangay_id'] = $barangay?->barangay_id;

        $report->update($validated);

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report updated successfully!');
    }

    /**
     * Delete spay/neuter report.
     */
    public function destroy(SpayNeuterReport $report)
    {
        $this->authorizeReport($report);
        $report->delete();

        return redirect()->route('spay-neuter.reports.index')
            ->with('success', 'Spay/Neuter report deleted successfully!');
    }

    /**
     * Export reports to PDF.
     */
    public function export(Request $request)
    {
        // Implementation for PDF export
        return redirect()->back()->with('info', 'PDF export feature coming soon!');
    }

    /**
     * Authorize report access.
     */
    private function authorizeReport($report)
    {
        if ($report->user_id !== Auth::id() &&
            ! Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'assistant_vet'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
