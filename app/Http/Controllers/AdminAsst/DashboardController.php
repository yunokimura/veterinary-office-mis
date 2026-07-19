<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\FormSubmission;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Pets Module - Operational Metrics
        $newPetRegistrationsToday = Pet::whereDate('created_at', today())->count();
        $newPetRegistrationsYesterday = Pet::whereDate('created_at', today()->subDay())->count();
        $newPetRegistrationsTrend = $this->calculateTrend($newPetRegistrationsToday, $newPetRegistrationsYesterday);
        
        $newPetRegistrationsThisWeek = Pet::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $newPetRegistrationsLastWeek = Pet::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $newPetRegistrationsWeekTrend = $this->calculateTrend($newPetRegistrationsThisWeek, $newPetRegistrationsLastWeek);
        
        $recentPetRegistrations = Pet::with('owner')->latest()->take(5)->get();

        // Missing Pets Module - Operational Metrics
        $activeMissingPets = MissingPetsReport::where('status', 'missing')->count();
        $activeMissingPetsLastWeek = MissingPetsReport::where('status', 'missing')
            ->whereDate('created_at', '<=', now()->subWeek())
            ->count();
        $activeMissingPetsTrend = $this->calculateTrend($activeMissingPets, $activeMissingPetsLastWeek);
        
        $totalMissingPets = MissingPetsReport::count();
        $foundMissingPets = MissingPetsReport::whereIn('status', ['found', 'reunited'])->count();
        $recentMissingPets = MissingPetsReport::with('pet')->latest()->take(5)->get();

        // Adoption Module - Operational Metrics
        $pendingAdoptions = AdoptionApplication::where('status', 'pending')->count();
        $pendingAdoptionsLastWeek = AdoptionApplication::where('status', 'pending')
            ->whereDate('created_at', '<=', now()->subWeek())
            ->count();
        $pendingAdoptionsTrend = $this->calculateTrend($pendingAdoptions, $pendingAdoptionsLastWeek);
        
        $totalAdoptions = Pet::where('source_module', 'adoption_pets')->count();
        $approvedAdoptions = AdoptionApplication::where('status', 'approved')->count();
        $recentAdoptions = Pet::where('source_module', 'adoption_pets')->with('owner')->latest()->take(5)->get();

        // Pet Owners Module - Operational Metrics
        $newPetOwnersThisWeek = PetOwner::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $newPetOwnersLastWeek = PetOwner::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $newPetOwnersTrend = $this->calculateTrend($newPetOwnersThisWeek, $newPetOwnersLastWeek);
        
        $totalOwners = PetOwner::count();
        $recentOwners = PetOwner::with('user')->latest()->take(5)->get();

        // Urgent Tasks Summary
        $pendingAdoptionReviews = AdoptionApplication::where('status', 'pending')->count();
        $missingPetReportsWaitingVerification = MissingPetsReport::where('status', 'missing')->count();
        $newPetRegistrationsCount = Pet::whereDate('created_at', today())->count();
        $ownersMissingContactInfo = PetOwner::where(function($query) {
            $query->whereNull('phone_number')
                  ->orWhere('phone_number', '')
                  ->orWhereNull('alternate_phone_number')
                  ->orWhere('alternate_phone_number', '');
        })->count();

        // Additional Operational Metrics
        $pendingAppointments = FormSubmission::where('status', 'pending')->count();
        $todayAppointments = FormSubmission::whereDate('submitted_at', today())->count();
        $missingPetReportsPending = MissingPetsReport::where('status', 'pending')->count();
        $adoptionPetsAvailable = Pet::where('source_module', 'adoption_pets')
            ->where('pet_status', '!=', 'adopted')
            ->count();

        // Recent Items Requiring Action
        $recentPendingAdoptions = AdoptionApplication::with(['owner', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        $recentMissingPetsPending = MissingPetsReport::with('pet')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        $recentAppointments = FormSubmission::with('form')
            ->where('status', 'pending')
            ->whereDate('submitted_at', today())
            ->latest()
            ->take(3)
            ->get();

        // Monthly registrations for chart
        $monthlyRegistrations = Pet::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Analytics Data
        // Pet Registration Trend (last 7 and 30 days)
        $petRegistrationTrend7Days = Pet::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $petRegistrationTrend30Days = Pet::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Adoption Status Distribution
        $adoptionStatusDistribution = AdoptionApplication::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Missing Pet Status Breakdown
        $missingPetStatusBreakdown = MissingPetsReport::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin-asst.dashboard', compact(
            'newPetRegistrationsToday',
            'newPetRegistrationsYesterday',
            'newPetRegistrationsTrend',
            'newPetRegistrationsThisWeek',
            'newPetRegistrationsLastWeek',
            'newPetRegistrationsWeekTrend',
            'recentPetRegistrations',
            'totalMissingPets',
            'activeMissingPets',
            'activeMissingPetsLastWeek',
            'activeMissingPetsTrend',
            'foundMissingPets',
            'recentMissingPets',
            'totalAdoptions',
            'pendingAdoptions',
            'pendingAdoptionsLastWeek',
            'pendingAdoptionsTrend',
            'approvedAdoptions',
            'recentAdoptions',
            'newPetOwnersThisWeek',
            'newPetOwnersLastWeek',
            'newPetOwnersTrend',
            'totalOwners',
            'recentOwners',
            'monthlyRegistrations',
            'petRegistrationTrend7Days',
            'petRegistrationTrend30Days',
            'adoptionStatusDistribution',
            'missingPetStatusBreakdown',
            'pendingAdoptionReviews',
            'missingPetReportsWaitingVerification',
            'newPetRegistrationsCount',
            'ownersMissingContactInfo',
            'pendingAppointments',
            'todayAppointments',
            'missingPetReportsPending',
            'adoptionPetsAvailable',
            'recentPendingAdoptions',
            'recentMissingPetsPending',
            'recentAppointments'
        ));
    }

    private function calculateTrend($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 'up' : 'neutral';
        }
        
        $change = (($current - $previous) / $previous) * 100;
        
        if ($change > 0) {
            return 'up';
        } elseif ($change < 0) {
            return 'down';
        }
        
        return 'neutral';
    }
}
