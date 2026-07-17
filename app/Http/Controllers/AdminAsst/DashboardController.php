<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\MissingPetsReport;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Pets Module
        $totalPets = Pet::count();
        $recentPetRegistrations = Pet::with('owner')->latest()->take(5)->get();

        // Missing Pets Module
        $totalMissingPets = MissingPetsReport::count();
        $activeMissingPets = MissingPetsReport::where('status', 'missing')->count();
        $foundMissingPets = MissingPetsReport::whereIn('status', ['found', 'reunited'])->count();
        $recentMissingPets = MissingPetsReport::with('pet')->latest()->take(5)->get();

        // Adoption Module
        $totalAdoptions = Pet::where('source_module', 'adoption_pets')->count();
        $pendingAdoptions = AdoptionApplication::where('status', 'pending')->count();
        $approvedAdoptions = AdoptionApplication::where('status', 'approved')->count();
        $recentAdoptions = Pet::where('source_module', 'adoption_pets')->with('owner')->latest()->take(5)->get();

        // Pet Owners Module
        $totalOwners = PetOwner::count();
        $recentOwners = PetOwner::with('user')->latest()->take(5)->get();

        // Monthly registrations for chart
        $monthlyRegistrations = Pet::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin-asst.dashboard', compact(
            'totalPets',
            'recentPetRegistrations',
            'totalMissingPets',
            'activeMissingPets',
            'foundMissingPets',
            'recentMissingPets',
            'totalAdoptions',
            'pendingAdoptions',
            'approvedAdoptions',
            'recentAdoptions',
            'totalOwners',
            'recentOwners',
            'monthlyRegistrations'
        ));
    }
}
