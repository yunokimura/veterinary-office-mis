<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\AdoptionPet;
use App\Models\FormSubmission;
use App\Models\ImpoundRecord;
use App\Models\InventoryControl;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPets = Pet::count();

        $pendingAppointments = FormSubmission::where('status', 'pending')->count();
        $todayAppointments = FormSubmission::whereDate('submitted_at', now()->toDateString())->count();

        $totalInventoryItems = InventoryControl::count();
        $lowStockItems = InventoryControl::whereRaw('quantity <= minimum_stock')->count();
        $expiringItems = InventoryControl::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();

        $totalAdoptions = AdoptionPet::count();
        $pendingAdoptions = AdoptionApplication::where('status', 'pending')->count();
        $approvedAdoptions = AdoptionApplication::where('status', 'approved')->count();

        $totalImpounds = ImpoundRecord::count();
        $availableForAdoption = ImpoundRecord::where('current_disposition', 'impounded')->count();

        $recentPetRegistrations = Pet::latest()->take(5)->get();
        $recentAdoptions = AdoptionPet::latest()->take(5)->get();
        $recentSubmissions = FormSubmission::with('form')->latest()->take(5)->get();

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
            'pendingAppointments',
            'todayAppointments',
            'totalInventoryItems',
            'lowStockItems',
            'expiringItems',
            'totalAdoptions',
            'pendingAdoptions',
            'approvedAdoptions',
            'totalImpounds',
            'availableForAdoption',
            'recentPetRegistrations',
            'recentAdoptions',
            'recentSubmissions',
            'monthlyRegistrations'
        ));
    }
}
