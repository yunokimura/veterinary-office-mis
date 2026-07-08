<?php

namespace App\Http\Controllers;

use App\Models\SpayNeuterReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantVetController extends Controller
{
    /**
     * Show assistant veterinarian dashboard.
     * Focuses on Spay/Neuter (Kapon) Appointments only.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $year = $request->year ?? date('Y');

        // ==============================
        // SPAY/NEUTER (KAPON) STATS
        // ==============================
        $kaponStats = [
            'total' => SpayNeuterReport::whereYear('created_at', $year)->count(),
            'pending' => SpayNeuterReport::where('status', 'pending')->whereYear('created_at', $year)->count(),
            'scheduled' => SpayNeuterReport::where('status', 'scheduled')->whereYear('created_at', $year)->count(),
            'completed' => SpayNeuterReport::where('status', 'completed')->whereYear('created_at', $year)->count(),
            'cancelled' => SpayNeuterReport::where('status', 'cancelled')->whereYear('created_at', $year)->count(),
            'today' => SpayNeuterReport::whereDate('scheduled_at', today())->count(),
            'this_week' => SpayNeuterReport::whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => SpayNeuterReport::whereYear('scheduled_at', now()->year)->whereMonth('scheduled_at', now()->month)->count(),
        ];

        // Kapon by procedure type
        $kaponByType = [
            'spay' => SpayNeuterReport::where('procedure_type', 'spay')->whereYear('created_at', $year)->count(),
            'neuter' => SpayNeuterReport::where('procedure_type', 'neuter')->whereYear('created_at', $year)->count(),
        ];

        // Recent kapon reports
        $recentKapon = SpayNeuterReport::with(['pet', 'owner', 'barangay'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly trend
        $monthlyKapon = SpayNeuterReport::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('dashboard.assistant-veterinary', compact(
            'user',
            'year',
            'kaponStats',
            'kaponByType',
            'recentKapon',
            'monthlyKapon'
        ));
    }
}