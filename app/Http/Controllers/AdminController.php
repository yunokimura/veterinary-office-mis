<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\VaccinationReport;
use App\Models\MeatInspectionReport;
use App\Models\VaccinationAppointment;
use App\Models\MeatEstablishment;
use App\Models\ImpoundRecord;
use App\Models\User;
use App\Models\Announcement;
use App\Models\StrayReport;
use App\Models\SystemLog;
use App\Models\MissingPetsReport;
use App\Models\AdoptionApplication;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard (System Admin - Full Access).
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total_bite_reports' => BiteRabiesReport::count(),
            'total_vaccination_reports' => VaccinationReport::count(),
            'total_meat_inspection_reports' => MeatInspectionReport::count(),
            'total_users' => User::count(),
            'compliant_meat_inspections' => MeatInspectionReport::where('compliance_status', 'compliant')->count(),
        ];

        $recent_bites = BiteRabiesReport::latest()->take(5)->get();
        $recent_vaccinations = VaccinationReport::latest()->take(5)->get();
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

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_announcements' => Announcement::count(),
            'total_bite_reports' => BiteRabiesReport::count(),
            'total_vaccinations' => VaccinationReport::count(),
            'total_meat_inspections' => MeatInspectionReport::count(),
            'total_stray_reports' => StrayReport::count(),
        ];

        $recentActivity = BiteRabiesReport::latest()->take(5)->get();

        $biteReports = BiteRabiesReport::latest()->paginate(10);
        $vaccinationReports = VaccinationReport::latest()->paginate(10);
        $inspectionReports = MeatInspectionReport::latest()->paginate(10);
        $totalMeatEstablishments = MeatEstablishment::count();
        $meatEstablishments = MeatEstablishment::with('barangay')->latest()->paginate(10);

        $missingPetReports = MissingPetsReport::with(['pet', 'user'])->latest()->paginate(10);
        $missingPetStats = [
            'total' => MissingPetsReport::count(),
            'pending' => MissingPetsReport::where('status', 'pending review')->count(),
            'approved' => MissingPetsReport::where('status', 'approved')->count(),
            'rejected' => MissingPetsReport::where('status', 'rejected')->count(),
            'resolved' => MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->count(),
            'closed' => MissingPetsReport::whereIn('status', ['closed - expired', 'closed - cancelled', 'closed - duplicate'])->count(),
        ];

        $adoptionReports = AdoptionApplication::with(['pet', 'user'])->latest()->paginate(10);
        $adoptionStats = [
            'total' => AdoptionApplication::count(),
            'pending_review' => AdoptionApplication::where('status', 'pending_review')->count(),
            'approved' => AdoptionApplication::where('status', 'approved')->count(),
            'rejected' => AdoptionApplication::where('status', 'rejected')->count(),
        ];

        $recentAnnouncements = Announcement::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        if ($isSuperAdmin) {
            return view('super-admin.all-reports', compact(
                'user',
                'isSuperAdmin',
                'stats',
                'recentActivity',
                'recentAnnouncements',
                'recentUsers',
                'biteReports',
                'vaccinationReports',
                'inspectionReports',
                'meatEstablishments',
                'totalMeatEstablishments',
                'missingPetReports',
                'missingPetStats',
                'missingPetsReportRecords',
                'adoptionReports',
                'adoptionStats'
            ));
        }

        return view('admin.all-reports', compact(
            'user',
            'isSuperAdmin',
            'stats',
            'recentActivity',
            'biteReports',
            'vaccinationReports',
            'inspectionReports',
            'meatEstablishments',
            'totalMeatEstablishments',
            'missingPetReports',
            'missingPetStats',
            'missingPetsReportRecords',
            'adoptionReports',
            'adoptionStats'
        ));
    }

    /**
     * List all confirmed rabies reports.
     */
    public function indexBiteReports(Request $request)
    {
        $user = Auth::user();

        $stats = [
            'total' => BiteRabiesReport::count(),
            'dog_cases' => BiteRabiesReport::where('animal_type', 'dog')->count(),
            'cat_cases' => BiteRabiesReport::where('animal_type', 'cat')->count(),
            'confirmed_this_year' => BiteRabiesReport::whereYear('incident_date', date('Y'))->count(),
        ];

        $query = BiteRabiesReport::with(['barangay']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('report_number', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('animal_type', 'like', "%{$term}%")
                            ->orWhere('animal_gender', 'like', "%{$term}%")
                            ->orWhere('animal_status', 'like', "%{$term}%")
                            ->orWhere('animal_name', 'like', "%{$term}%")
                            ->orWhere('exact_location', 'like', "%{$term}%")
                            ->orWhere('animal_owner_name', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        $reports = $query->orderByDesc('incident_date')->paginate(10);
        return view('dashboard.bite-reports', compact('user', 'reports', 'stats'));
    }

    public function filterBiteReports(Request $request)
    {
        $query = BiteRabiesReport::with(['barangay']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('report_number', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('animal_type', 'like', "%{$term}%")
                            ->orWhere('animal_gender', 'like', "%{$term}%")
                            ->orWhere('animal_status', 'like', "%{$term}%")
                            ->orWhere('animal_name', 'like', "%{$term}%")
                            ->orWhere('exact_location', 'like', "%{$term}%")
                            ->orWhere('animal_owner_name', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        $reports = $query->orderByDesc('incident_date')->paginate(10);

        try {
            $html = view('dashboard.partials.bite-reports-table', compact('reports'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $reports->links()->render(),
            'has_results' => $reports->count() > 0,
        ]);
    }

    /**
     * Show bite report details (JSON for modal).
     */
    public function showBiteReportJson(BiteRabiesReport $report)
    {
        $report->load(['barangay']);

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'report_number' => $report->report_number,
                'barangay' => $report->barangay?->barangay_name ?? 'N/A',
                'incident_date' => \Carbon\Carbon::parse($report->incident_date)->format('M d, Y'),
                'exact_location' => $report->exact_location,
                'animal_type' => ucfirst($report->animal_type),
                'animal_gender' => $report->animal_gender,
                'animal_status' => ucfirst($report->animal_status),
                'animal_name' => $report->animal_name,
                'vaccination_status' => $report->vaccination_status,
                'animal_owner_name' => $report->animal_owner_name,
                'animal_owner_contact' => $report->animal_owner_contact,
                'notes' => $report->notes,
            ]
        ]);
    }

    /**
     * Show bite report details.
     */
    public function showBiteReport(BiteRabiesReport $report)
    {
        $user = Auth::user();
        $report->load(['barangay']);
        return view('dashboard.bite-reports.show', compact('report', 'user'));
    }

    /**
     * List anti-rabies vaccination appointments.
     */
    public function indexVaccinationAppointments(Request $request)
    {
        $user = Auth::user();

        $query = VaccinationAppointment::with(['owner.pets', 'user', 'address', 'assignedVet']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('owner', function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        $appointments = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        $stats = [
            'total' => VaccinationAppointment::count(),
            'pending' => VaccinationAppointment::where('status', 'pending')->count(),
            'approved' => VaccinationAppointment::where('status', 'approved')->count(),
            'completed' => VaccinationAppointment::where('status', 'completed')->count(),
            'cancelled' => VaccinationAppointment::where('status', 'cancelled')->count(),
            'today' => VaccinationAppointment::whereDate('scheduled_at', now()->toDateString())->count(),
            'this_week' => VaccinationAppointment::whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('dashboard.vaccination-appointments', compact('user', 'appointments', 'stats'));
    }

    /**
     * Show vaccination appointment details (JSON for modal).
     */
    public function showVaccinationAppointmentJson(VaccinationAppointment $appointment)
    {
        $appointment->load(['address.barangay', 'pet']);

        $scheduledAt = \Carbon\Carbon::parse($appointment->scheduled_at);
        $createdAt = \Carbon\Carbon::parse($appointment->created_at);

        return response()->json([
            'success' => true,
            'appointment' => [
                'id' => $appointment->id,
                'status' => ucfirst($appointment->status),
                'scheduled_at_date' => $scheduledAt->format('M d, Y'),
                'scheduled_at_time' => $scheduledAt->format('h:i A'),
                'last_anti_rabies_date' => $appointment->last_anti_rabies_date ? \Carbon\Carbon::parse($appointment->last_anti_rabies_date)->format('M d, Y') : 'N/A',
                'recent_surgery' => $appointment->recent_surgery ? 'Yes' : 'No',
                'created_at_date' => $createdAt->format('M d, Y'),
                'created_at_time' => $createdAt->format('h:i A'),
                'owner_name' => $appointment->owner_name,
                'owner_contact' => $appointment->user->contact_number ?? 'N/A',
                'owner_email' => $appointment->user->email ?? 'N/A',
                'address' => $appointment->address ? trim(
                    ($appointment->address->block_lot_phase ? $appointment->address->block_lot_phase . ' ' : '') .
                    ($appointment->address->street ?? '') .
                    ', ' . ($appointment->address->barangay->barangay_name ?? 'N/A') .
                    ', ' . ($appointment->address->city ?? '')
                ) : 'N/A',
                'submitted_by' => $appointment->user->name ?? 'N/A',
                'assigned_vet_name' => $appointment->assigned_vet_name,
            ]
        ]);
    }

    /**
     * Filter vaccination appointments for AJAX.
     */
    public function filterVaccinationAppointments(Request $request)
    {
        $query = VaccinationAppointment::with(['owner.pets', 'user', 'address.barangay', 'assignedVet']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('owner_name', 'like', "%{$term}%")
                            ->orWhereHas('owner', function ($q2) use ($term) {
                                $q2->where('first_name', 'like', "%{$term}%")
                                    ->orWhere('last_name', 'like', "%{$term}%");
                            })
                            ->orWhere('status', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        $appointments = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        try {
            $html = view('dashboard.partials.vaccination-appointments-table', compact('appointments'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $appointments->links()->render(),
            'total_count' => $appointments->total(),
            'has_results' => $appointments->count() > 0,
        ]);
    }

    /**
     * Update vaccination appointment status.
     */
    public function updateVaccinationAppointmentStatus(Request $request, VaccinationAppointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled,no_show',
        ]);

        $appointment->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            $appointment->update(['last_anti_rabies_date' => now()->toDateString()]);
            if ($appointment->vaccinationReports()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vaccination reports have already been generated for this appointment.',
                ]);
            }

            $selectedPets = $appointment->metadata['selected_pets'] ?? [];
            if (empty($selectedPets)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pets selected for this appointment.',
                ]);
            }

            $owner = $appointment->owner;
            $address = $appointment->address;
            $barangay = $address->barangay ?? null;

            $validPets = [];
            foreach ($selectedPets as $petData) {
                $petId = is_array($petData) ? ($petData['id'] ?? null) : $petData;
                if (!$petId) {
                    continue;
                }

                $pet = Pet::withTrashed()->find($petId);
                if (!$pet) {
                    continue;
                }

                $validPets[] = [
                    'pet' => $pet,
                    'metadata' => is_array($petData) ? $petData : [],
                ];
            }

            if (empty($validPets)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid pets found for this appointment.',
                ]);
            }

            DB::transaction(function () use ($appointment, $owner, $address, $barangay, $validPets) {
                $now = now();

                foreach ($validPets as $item) {
                    $pet = $item['pet'];
                    $petMeta = $item['metadata'];

                    VaccinationReport::create([
                        'vaccination_appointment_id' => $appointment->id,
                        'pet_id' => $pet->pet_id,
                        'barangay_id' => $barangay?->barangay_id,
                        'pet_name' => $pet->pet_name,
                        'pet_species' => $pet->species,
                        'pet_breed' => $pet->breed,
                        'pet_gender' => $pet->gender,
                        'pet_age' => $pet->age,
                        'vaccine_brand' => null,
                        'vaccine_batch_number' => null,
                        'vaccination_date' => $appointment->scheduled_at->toDateString(),
                        'vaccination_time' => $appointment->scheduled_at->toTimeString(),
                        'next_vaccination_date' => null,
                        'weight' => $petMeta['weight'] ?? null,
                        'vaccination_type' => null,
                        'status' => 'completed',
                        'observations' => null,
                        'notes' => null,
                        'administered_by' => Auth::id(),
                        'inventory_control_id' => null,
                    ]);
                }
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
            'appointment' => [
                'id' => $appointment->id,
                'status' => $appointment->status,
            ]
        ]);
    }

    public function editVaccinationAppointmentJson(VaccinationAppointment $appointment)
    {
        $appointment->load(['address.barangay', 'assignedVet']);

        $vets = Admin::whereHas('user', function ($query) {
                $query->whereIn('role_type', ['city_vet', 'assistant_vet']);
            })
            ->with('user')
            ->get()
            ->map(fn ($admin) => [
                'id' => $admin->id,
                'name' => trim(($admin->user->name ?? '') . ' (' . ($admin->user->role_type === 'city_vet' ? 'City Veterinarian' : 'Assistant Veterinarian') . ')'),
            ])
            ->values()
            ->all();

        return response()->json([
            'success' => true,
            'appointment' => [
                'id' => $appointment->id,
                'scheduled_at' => $appointment->scheduled_at ? $appointment->scheduled_at->format('Y-m-d\TH:i') : null,
                'status' => $appointment->status,
                'last_anti_rabies_date' => $appointment->last_anti_rabies_date ? $appointment->last_anti_rabies_date->format('Y-m-d') : null,
                'recent_surgery' => $appointment->recent_surgery,
                'assigned_vet' => $appointment->assigned_vet,
                'vets' => $vets,
            ]
        ]);
    }

    public function updateVaccinationAppointment(Request $request, VaccinationAppointment $appointment)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date',
            'status' => 'required|in:pending,approved,completed,cancelled,no_show',
            'last_anti_rabies_date' => 'nullable|date',
            'recent_surgery' => 'required|boolean',
            'assigned_vet' => 'nullable|exists:admins,id',
        ]);

        $appointment->update([
            'scheduled_at' => $validated['scheduled_at'],
            'status' => $validated['status'],
            'last_anti_rabies_date' => $validated['last_anti_rabies_date'],
            'recent_surgery' => $validated['recent_surgery'],
            'assigned_vet' => $validated['assigned_vet'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully.',
        ]);
    }

    /**
     * List all rabies vaccination reports (from Clinic).
     */
    public function indexVaccinationReports(Request $request)
    {
        $user = Auth::user();

        $query = VaccinationReport::latest()->with(['pet.owner']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('pet_name', 'like', "%{$term}%")
                            ->orWhere('pet_species', 'like', "%{$term}%")
                            ->orWhere('vaccine_brand', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('id', 'like', "%{$term}%")
                            ->orWhereHas('pet.owner', function ($q2) use ($term) {
                                $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                            });
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('vaccination_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('vaccination_date', '<=', $request->date_to);
        }

        $reports = $query->paginate(10);
        return view('dashboard.vaccination-reports', compact('user', 'reports'));
    }

    public function filterVaccinationReports(Request $request)
    {
        $query = VaccinationReport::latest()->with(['pet.owner']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('pet_name', 'like', "%{$term}%")
                            ->orWhere('pet_species', 'like', "%{$term}%")
                            ->orWhere('vaccine_brand', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('id', 'like', "%{$term}%")
                            ->orWhereHas('pet.owner', function ($q2) use ($term) {
                                $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                            });
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('vaccination_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('vaccination_date', '<=', $request->date_to);
        }

        $reports = $query->paginate(10);

        try {
            $html = view('dashboard.partials.vaccination-reports-table', compact('reports'))->render();
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
     * Show rabies vaccination report details (JSON for modal).
     */
    public function showVaccinationReportJson(VaccinationReport $report)
    {
        $report->load(['pet.owner', 'pet.owner.address', 'barangay']);

        $owner = $report->pet?->owner;
        $address = $owner?->address;

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $report->id,
                'report_number' => 'RV-' . str_pad($report->id, 5, '0', STR_PAD_LEFT),
                'patient_name' => $owner ? trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) : 'N/A',
                'patient_contact' => $owner->phone_number ?? 'N/A',
                'patient_address' => $address ? trim(($address->block_lot_phase ?? '') . ' ' . ($address->street ?? '') . ', ' . ($address->barangay?->barangay_name ?? '')) : 'N/A',
                'pet_name' => $report->pet_name,
                'pet_species' => ucfirst($report->pet_species),
                'pet_breed' => $report->pet_breed,
                'pet_age' => $report->pet_age,
                'pet_gender' => ucfirst($report->pet_gender),
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
            ]
        ]);
    }

    /**
     * Show rabies vaccination report details.
     */
    public function showVaccinationReport(VaccinationReport $report)
    {
        $user = Auth::user();
        $report->load('user');
        return view('dashboard.vaccination-report-view', compact('report', 'user'));
    }

    /**
     * List all meat establishments.
     */
    public function indexMeatInspectionReports(Request $request)
    {
        $user = Auth::user();
        $query = MeatEstablishment::with('barangay');

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('establishment_name', 'like', "%{$term}%")
                            ->orWhere('owner_name', 'like', "%{$term}%")
                            ->orWhere('establishment_type', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('status', 'like', "%{$term}%");
                    });
                }
            });
        }

        $establishments = $query->latest()->paginate(10);

        $stats = [
            'total' => MeatEstablishment::count(),
            'active' => MeatEstablishment::where('status', 'Active')->count(),
            'expired' => MeatEstablishment::where('status', 'Expired')->count(),
            'pending_inspection' => MeatEstablishment::where('status', 'Pending Inspection')->count(),
        ];

        return view('dashboard.meat-inspection', compact('user', 'establishments', 'stats'));
    }

    public function filterMeatInspectionReports(Request $request)
    {
        $query = MeatEstablishment::with('barangay');

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('establishment_name', 'like', "%{$term}%")
                            ->orWhere('owner_name', 'like', "%{$term}%")
                            ->orWhere('establishment_type', 'like', "%{$term}%")
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('status', 'like', "%{$term}%");
                    });
                }
            });
        }

        $establishments = $query->latest()->paginate(10);

        try {
            $html = view('dashboard.partials.meat-inspection-table', compact('establishments'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $establishments->links()->render(),
            'has_results' => $establishments->count() > 0,
        ]);
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
}
