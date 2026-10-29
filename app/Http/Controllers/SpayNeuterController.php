<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Pet;
use App\Models\SpayNeuterAppointment;
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
        $query = SpayNeuterAppointment::query()->with(['pet', 'owner', 'barangay']);

        // Search filter (pet name, owner name, procedure type, status, barangay)
        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->whereHas('pet', function ($p) use ($term) {
                            $p->where('pet_name', 'like', "%{$term}%");
                        })
                            ->orWhereHas('owner', function ($o) use ($term) {
                                $o->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                            })
                            ->orWhere('procedure_type', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($b) use ($term) {
                                $b->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('id', 'like', "%{$term}%");
                    });
                }
            });
        }

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

        // KPI stats from filtered query
        $stats = [
            'total' => $query->count(),
            'pending' => $query->where('status', 'pending')->count(),
            'scheduled' => $query->where('status', 'scheduled')->count(),
            'completed' => $query->where('status', 'completed')->count(),
            'cancelled' => $query->where('status', 'cancelled')->count(),
            'today' => $query->whereDate('scheduled_at', today())->count(),
        ];

        $reports = $query->latest()->paginate(10)->appends(request()->query());

        return view('reports.spay_neuter_index', compact('reports', 'stats'));
    }

    /**
     * List all spay/neuter reports with KPI summary cards.
     */
    public function allReports(Request $request)
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

        $totalReports = $query->count();
        $completed = $query->where('status', 'completed')->count();
        $scheduled = $query->where('status', 'scheduled')->count();
        $pending = $query->whereIn('status', ['pending', 'cancelled'])->count();

        $reports = $query->latest()->paginate(10)->appends(request()->query());

        return view('reports.spay_neuter_report', compact(
            'reports',
            'totalReports',
            'completed',
            'scheduled',
            'pending'
        ));
    }

    /**
     * AJAX filter for all spay/neuter reports (JSON response for partial table update).
     */
    public function filterReports(Request $request)
    {
        $query = SpayNeuterReport::query()->with(['pet', 'owner', 'barangay']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->whereHas('pet', function ($p) use ($term) {
                            $p->where('pet_name', 'like', "%{$term}%");
                        })
                            ->orWhereHas('owner', function ($o) use ($term) {
                                $o->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                            })
                            ->orWhere('procedure_type', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($b) use ($term) {
                                $b->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('id', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('procedure_type')) {
            $query->where('procedure_type', $request->procedure_type);
        }
        if ($request->filled('pet_type')) {
            $query->whereHas('pet', function ($q) use ($request) {
                $q->where('species', $request->pet_type);
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('scheduled_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('scheduled_at', '<=', $request->end_date);
        }

        if (! Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'assistant_vet'])) {
            $query->where('user_id', Auth::id());
        }

        $reports = $query->latest()->paginate(10);

        try {
            $html = view('reports.partials.spay-neuter-reports-table', compact('reports'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="7" class="px-6 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $reports->links()->render(),
            'has_results' => $reports->count() > 0,
        ]);
    }

    /**
     * Show spay/neuter report details (JSON for modal).
     */
    public function showSpayNeuterReportJson(SpayNeuterReport $report)
    {
        $report->load(['pet.owner.barangay', 'barangay']);

        $owner = $report->owner;
        $pet = $report->pet;
        $barangay = $report->barangay;

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'report_number' => 'SN-' . str_pad($report->id, 5, '0', STR_PAD_LEFT),
                'patient_name' => optional($owner)->full_name ?? 'N/A',
                'patient_contact' => optional($owner)->phone_number ?? 'N/A',
                'patient_address' => $report->owner_address ?? 'N/A',
                'pet_name' => $report->pet_name,
                'pet_species' => ucfirst($report->species ?? 'N/A'),
                'pet_breed' => $pet?->breed ?? 'N/A',
                'pet_age' => $report->pet_age ?? 'N/A',
                'pet_gender' => ucfirst($report->gender ?? 'N/A'),
                'procedure_type' => ucfirst($report->procedure_type),
                'weight' => $report->weight,
                'veterinarian' => $report->veterinarian ?? 'N/A',
                'scheduled_at' => $report->scheduled_at ? \Carbon\Carbon::parse($report->scheduled_at)->format('M d, Y') : 'N/A',
                'status' => $report->status,
                'remarks' => $report->remarks,
                'barangay' => optional($barangay)->barangay_name ?? $report->barangay_name ?? 'N/A',
                'created_at' => $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('M d, Y') : null,
            ]
        ]);
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
            'pet_id' => 'nullable|exists:pets,pet_id',
            'procedure_type' => 'nullable|string|in:spay,neuter',
            'scheduled_at' => 'nullable|date',
            'veterinarian' => 'nullable|in:City Veterinarian,Assistant Veterinarian',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:scheduled,completed,cancelled,pending',
            'remarks' => 'nullable|string',
        ]);

        // Re-derive owner_id and barangay_id from the selected pet only if pet_id is provided
        if ($request->filled('pet_id')) {
            $pet = Pet::with('owner')->findOrFail($validated['pet_id']);
            $owner = $pet->owner;
            if (! $owner) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Selected pet has no owner.'], 422);
                }
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
        }

        // Remove null fields so they are not overwritten
        foreach ($validated as $key => $value) {
            if ($value === null) {
                unset($validated[$key]);
            }
        }

        $report->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Spay/Neuter report updated successfully!']);
        }

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
