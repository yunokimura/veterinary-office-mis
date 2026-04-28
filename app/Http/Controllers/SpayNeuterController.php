<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Barangay;
use App\Models\Pet;
use App\Models\SpayNeuterReport;
use App\Services\NotificationService;
use App\Services\VeterinarianRotationService;
use Carbon\Carbon;
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
        if (! Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'disease_control', 'admin_staff'])) {
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

        // Check if status is changing to 'scheduled'
        $wasPending = $report->status === 'pending';
        $isNowScheduled = isset($validated['status']) && $validated['status'] === 'scheduled';

        // Get scheduled_at from validated data or use existing
        $scheduledAt = null;
        if (isset($validated['scheduled_at'])) {
            $scheduledAt = Carbon::parse($validated['scheduled_at']);
        } elseif ($report->scheduled_at) {
            $scheduledAt = Carbon::parse($report->scheduled_at);
        }

        // If status changed from pending to scheduled, create an Appointment
        if ($wasPending && $isNowScheduled && $scheduledAt) {
            // Double booking protection - check if already scheduled
            $existingAppointment = Appointment::where('service_type', 'kapon')
                ->where('service_id', $report->id)
                ->where('status', 'scheduled')
                ->exists();

            if ($existingAppointment) {
                return redirect()->back()->with('error', 'This pet is already scheduled for a kapon appointment.');
            }

            // Capacity limit validation for kapon
            $appointmentDate = $scheduledAt->format('Y-m-d');
            $appointmentTime = $scheduledAt->format('H:00:00');

            // Check hourly capacity (2 per hour for kapon)
            $hourlyCount = Appointment::where('service_type', 'kapon')
                ->where('appointment_date', $appointmentDate)
                ->where('appointment_time', '>=', $appointmentTime)
                ->where('appointment_time', '<', date('H:00:00', strtotime($appointmentTime.'+1 hour')))
                ->where('status', 'scheduled')
                ->count();

            if ($hourlyCount >= 2) {
                return redirect()->back()->with('error', 'Hourly capacity (2 kapon appointments per hour) is full. Please choose a different time.');
            }

            // Check daily capacity (12 per day for kapon)
            $dailyCount = Appointment::where('service_type', 'kapon')
                ->where('appointment_date', $appointmentDate)
                ->where('status', 'scheduled')
                ->count();

            if ($dailyCount >= 12) {
                return redirect()->back()->with('error', 'Daily capacity (12 kapon appointments per day) is full. Please choose a different date.');
            }

            Appointment::create([
                'appointment_date' => $scheduledAt->format('Y-m-d'),
                'appointment_time' => $scheduledAt->format('H:i:s'),
                'service_type' => 'kapon',
                'service_id' => $report->id,
                'status' => 'scheduled',
                'metadata' => json_encode([
                    'pet_name' => $report->pet_name, // accessor
                    'owner_name' => $report->owner_name, // accessor
                    'procedure_type' => $report->procedure_type,
                ]),
            ]);
        }

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
            ! Auth::user()->hasAnyRole(['super_admin', 'city_vet', 'disease_control', 'admin_staff'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
