<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\RabiesVaccinationReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityVetController extends Controller
{
    /**
     * Show city veterinarian dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Get statistics year (used for stats cards)
        $year = $request->year ?? date('Y');
        // Separate years for charts
        $speciesYear = $request->species_year ?? $year;
        $monthlyYear = $request->monthly_year ?? $year;

        $stats = [
            'confirmed_bite_cases' => BiteRabiesReport::where('rabies_confirmed', true)->whereYear('incident_date', $year)->count(),
            'anti_rabies_vaccinations' => RabiesVaccinationReport::whereYear('vaccination_date', $year)->count(),
            'adoption_reports' => \App\Models\AdoptionApplication::whereYear('created_at', $year)->count(),
            'missing_pet_reports' => \App\Models\MissingPetsReport::whereYear('created_at', $year)->count(),
            'registered_meat_establishments' => \App\Models\MeatEstablishment::count(),
        ];

        // Get recent confirmed rabies cases only from current year
        $recentCases = BiteRabiesReport::where('rabies_confirmed', true)
            ->whereYear('incident_date', date('Y'))
            ->with('barangay')
            ->latest()
            ->take(5)
            ->get();

        // Get top 5 barangays with highest confirmed rabies cases
        $topBarangays = BiteRabiesReport::where('rabies_confirmed', true)
            ->whereYear('incident_date', $year)
            ->with('barangay')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Get lowest vaccination coverage by barangay
        $lowestVaccination = RabiesVaccinationReport::whereYear('vaccination_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0)
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderBy('count')
            ->limit(5)
            ->get();

        // Get recent meat establishments
        $establishments = \App\Models\MeatEstablishment::latest()->take(5)->get();

        // Get monthly trends for confirmed rabies cases only
        $monthlyCases = BiteRabiesReport::where('rabies_confirmed', true)
            ->whereYear('incident_date', $monthlyYear)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get cases by type for the selected year
        $casesByType = BiteRabiesReport::whereYear('incident_date', $speciesYear)
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();

        // Get adoption reports by month
        $adoptionReportsByMonth = \App\Models\AdoptionApplication::whereYear('created_at', $monthlyYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get missing pet reports by month
        $missingPetReportsByMonth = \App\Models\MissingPetsReport::whereYear('created_at', $monthlyYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get vaccinations by barangay
        $vaccinationsByBarangay = \App\Models\RabiesVaccinationReport::whereYear('vaccination_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0)
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Get bite cases by barangay
        $biteCasesByBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Get heatmap data
        $heatmapData = $this->getHeatmapData($year);

        // Get all barangays for filter dropdown
        $barangays = Barangay::pluck('barangay_name', 'barangay_id');

        // Analytics Data
        $analytics = $this->getAnalyticsData($year);

        return view('dashboard.city-vet', compact(
            'user',
            'stats',
            'recentCases',
            'monthlyCases',
            'casesByType',
            'heatmapData',
            'barangays',
            'year',
            'speciesYear',
            'monthlyYear',
            'analytics',
            'adoptionReportsByMonth',
            'missingPetReportsByMonth',
            'vaccinationsByBarangay',
            'biteCasesByBarangay',
            'topBarangays',
            'lowestVaccination',
            'establishments'
        ));
    }

    /**
     * Show rabies geomap.
     */
    public function geomap(Request $request)
    {
        $user = Auth::user();
        $year = $request->year ?? date('Y');
        $previousYear = $year - 1;

        // Get heatmap data
        $heatmapData = $this->getHeatmapData($year);

        // Get case type breakdown
        $caseTypeBreakdown = $this->getCaseTypeBreakdown($year);

        // Get monthly timeline
        $monthlyTimeline = $this->getMonthlyTimeline($year);

        // Get year comparison
        $yearComparison = $this->getYearComparison($year, $previousYear);

        // Get top hotspots
        $hotspots = $this->getHotspots($year);

        return view('city-vet.rabies-geomap', compact(
            'user',
            'heatmapData',
            'year',
            'caseTypeBreakdown',
            'monthlyTimeline',
            'yearComparison',
            'hotspots'
        ));
    }

    /**
     * Get heatmap data for rabies cases.
     */
    private function getHeatmapData(int $year): array
    {
        // Get cases grouped by barangay from bite_rabies_reports
        // Use barangay_id (where the bite incident occurred)
        $byBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get ALL barangays with coordinates (not just those with cases)
        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? (int) $caseCount->count : 0;

            return [
                'id' => 'rabies-'.$barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'rabies',
            ];
        })->toArray();
    }

    /**
     * Get case type breakdown.
     */
    private function getCaseTypeBreakdown(int $year): array
    {
        return BiteRabiesReport::whereYear('incident_date', $year)
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();
    }

    /**
     * Get monthly timeline data.
     */
    private function getMonthlyTimeline(int $year): array
    {
        $months = ['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6,
            'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];

        $data = [];
        foreach ($months as $monthName => $monthNum) {
            $count = BiteRabiesReport::whereYear('incident_date', $year)
                ->whereMonth('incident_date', $monthNum)
                ->count();
            $data[$monthName] = $count;
        }

        return $data;
    }

    /**
     * Get year-over-year comparison.
     */
    private function getYearComparison(int $currentYear, int $previousYear): array
    {
        $current = BiteRabiesReport::whereYear('incident_date', $currentYear)->count();
        $previous = BiteRabiesReport::whereYear('incident_date', $previousYear)->count();

        $change = $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : 0;

        return [
            'current' => $current,
            'previous' => $previous,
            'change' => $change,
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
        ];
    }

    /**
     * Get top hotspots (barangays with most cases).
     */
    private function getHotspots(int $year): array
    {
        return BiteRabiesReport::whereYear('incident_date', $year)
            ->with('barangay')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'barangay_id' => $item->barangay_id,
                    'barangay_name' => $item->barangay?->barangay_name ?? 'Unknown',
                    'count' => (int) $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * API endpoint for filtered geomap data (AJAX).
     */
    public function geomapData(Request $request)
    {
        $year = (int) ($request->year ?? date('Y'));
        $month = $request->month ? (int) $request->month : null;
        $week = $request->week ? (int) $request->week : null;
        $dateFrom = $request->date_from ?: null;
        $dateTo = $request->date_to ?: null;

        // Debug: Check if data exists
        $totalInDb = BiteRabiesReport::whereYear('incident_date', $year)->count();
        $withBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')->count();

        $heatmapData = $this->getFilteredHeatmapData($year, $month, $week, $dateFrom, $dateTo);
        $caseTypeBreakdown = $this->getFilteredCaseTypeBreakdown($year, $month, $week, $dateFrom, $dateTo);
        $totalCases = collect($heatmapData)->sum('count');

        $filterLabel = $year;
        if ($dateFrom && $dateTo) {
            $filterLabel = Carbon::parse($dateFrom)->format('M d').' - '.Carbon::parse($dateTo)->format('M d, Y');
        } elseif ($month && $week) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $filterLabel = "Week $week, $monthName $year";
        } elseif ($month) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $filterLabel = "$monthName $year";
        }

        return response()->json([
            'heatmapData' => $heatmapData,
            'caseTypeBreakdown' => $caseTypeBreakdown,
            'totalCases' => $totalCases,
            'filterLabel' => $filterLabel,
            'year' => $year,
            'month' => $month,
            'week' => $week,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'debug' => [
                'total_in_db' => $totalInDb,
                'with_barangay' => $withBarangay,
            ],
        ]);
    }

    /**
     * Get filtered heatmap data by year, month, and/or week.
     */
    private function getFilteredHeatmapData(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $query = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '');

        if ($dateFrom) {
            $query->where('incident_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('incident_date', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('incident_date', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(incident_date, 1) = ?', [$week]);
        }

        $byBarangay = $query
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $caseCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $caseCount ? (int) $caseCount->count : 0;

            return [
                'id' => 'bite-'.$barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'rabies',
            ];
        })->toArray();
    }

    /**
     * Get filtered case type breakdown by year, month, and/or week.
     */
    private function getFilteredCaseTypeBreakdown(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $query = BiteRabiesReport::whereYear('incident_date', $year);

        if ($dateFrom) {
            $query->where('incident_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('incident_date', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('incident_date', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(incident_date, 1) = ?', [$week]);
        }

        return $query
            ->selectRaw('animal_type, COUNT(*) as count')
            ->groupBy('animal_type')
            ->pluck('count', 'animal_type')
            ->toArray();
    }

    /**
     * List all missing pet reports.
     */
    public function indexMissingPetReports(Request $request)
    {
        $user = Auth::user();

        $query = \App\Models\MissingPetsReport::with(['pet', 'user']);

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('last_seen_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('last_seen_at', '<=', $request->date_to);
        }

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = \Carbon\Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('last_seen_at', $today);
                    break;
                case 'week':
                    $query->where('last_seen_at', '>=', \Carbon\Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('last_seen_at', '>=', \Carbon\Carbon::now()->startOfMonth());
                    break;
            }
        }

        $reports = $query->latest()->paginate(10);

        // Get statistics
        $stats = [
            'total' => \App\Models\MissingPetsReport::count(),
            'active' => \App\Models\MissingPetsReport::where('status', 'missing')->count(),
            'resolved' => \App\Models\MissingPetsReport::whereIn('status', ['found', 'reunited'])->count(),
            'this_month' => \App\Models\MissingPetsReport::whereMonth('last_seen_at', date('m'))
                ->whereYear('last_seen_at', date('Y'))
                ->count(),
        ];

        return view('dashboard.missing-pet-reports', compact('user', 'reports', 'stats'));
    }

    /**
     * Show missing pet report details (JSON for modal).
     */
    public function showMissingPetReportJson(\App\Models\MissingPetsReport $missingPet)
    {
        $missingPet->load(['pet', 'user']);

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $missingPet->report_id,
                'report_number' => 'MP-' . str_pad($missingPet->report_id, 5, '0', STR_PAD_LEFT),
                'status' => $missingPet->status,
                'pet_name' => $missingPet->pet->pet_name ?? 'N/A',
                'species' => ucfirst($missingPet->pet->species ?? 'N/A'),
                'breed' => $missingPet->pet->breed ?? 'N/A',
                'color' => $missingPet->pet->color ?? 'N/A',
                'gender' => ucfirst($missingPet->pet->gender ?? 'N/A'),
                'last_seen_at' => \Carbon\Carbon::parse($missingPet->last_seen_at)->format('M d, Y'),
                'last_seen_time' => \Carbon\Carbon::parse($missingPet->last_seen_at)->format('h:i A'),
                'location' => $missingPet->location_description,
                'barangay' => $missingPet->location_barangay,
                'description' => $missingPet->body_marks,
                'reporter_name' => $missingPet->user->name ?? 'N/A',
                'reporter_contact' => $missingPet->emergency_contact ?? 'N/A',
                'reporter_email' => $missingPet->user->email ?? 'N/A',
                'reported_by' => optional($missingPet->user)->name ?? 'N/A',
                'created_at' => $missingPet->created_at->format('M d, Y h:i A'),
                'updated_at' => $missingPet->updated_at->format('M d, Y h:i A'),
            ]
        ]);
    }

    /**
     * Show missing pet report details.
     */
    public function showMissingPetReport(\App\Models\MissingPetsReport $missingPet)
    {
        $user = Auth::user();
        $missingPet->load(['pet', 'user']);
        return view('dashboard.missing-pet-reports.show', compact('missingPet', 'user'));
    }

    /**
     * List all adoption reports.
     */
    public function indexAdoptionReports(Request $request)
    {
        $user = Auth::user();

        $query = \App\Models\AdoptionApplication::with(['user', 'pet']);

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply quick filter
        if ($request->has('quick_filter') && $request->quick_filter) {
            $today = \Carbon\Carbon::now()->startOfDay();
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('created_at', $today);
                    break;
                case 'week':
                    $query->where('created_at', '>=', \Carbon\Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth());
                    break;
            }
        }

        $reports = $query->latest()->paginate(10);

        // Get statistics
        $stats = [
            'total' => \App\Models\AdoptionApplication::count(),
            'pending' => \App\Models\AdoptionApplication::where('status', 'pending')->count(),
            'approved' => \App\Models\AdoptionApplication::where('status', 'approved')->count(),
            'completed' => \App\Models\AdoptionApplication::where('status', 'completed')->count(),
            'rejected' => \App\Models\AdoptionApplication::where('status', 'rejected')->count(),
            'this_month' => \App\Models\AdoptionApplication::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
        ];

        return view('dashboard.adoption-reports', compact('user', 'reports', 'stats'));
    }

    /**
     * Show adoption report details (JSON for modal).
     */
    public function showAdoptionReportJson(\App\Models\AdoptionApplication $adoption)
    {
        $adoption->load(['user', 'pet']);

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $adoption->id,
                'report_number' => 'AD-' . str_pad($adoption->id, 5, '0', STR_PAD_LEFT),
                'status' => $adoption->status,
                'applicant_name' => $adoption->user->name ?? 'N/A',
                'applicant_email' => $adoption->user->email ?? 'N/A',
                'applicant_contact' => $adoption->user->contact_number ?? 'N/A',
                'pet_name' => $adoption->pet->pet_name ?? 'N/A',
                'pet_species' => ucfirst($adoption->pet->species ?? 'N/A'),
                'pet_breed' => $adoption->pet->breed ?? 'N/A',
                'pet_gender' => ucfirst($adoption->pet->gender ?? 'N/A'),
                'reason' => $adoption->reason,
                'has_other_pets' => $adoption->has_other_pets ? 'Yes' : 'No',
                'other_pets_details' => $adoption->other_pets_details ?? 'N/A',
                'home_type' => ucfirst($adoption->home_type ?? 'N/A'),
                'yard_has_fence' => $adoption->yard_has_fence ? 'Yes' : 'No',
                'adoption_date' => $adoption->adoption_date ? \Carbon\Carbon::parse($adoption->adoption_date)->format('M d, Y') : 'N/A',
                'notes' => $adoption->notes ?? 'N/A',
                'created_at' => $adoption->created_at->format('M d, Y h:i A'),
                'updated_at' => $adoption->updated_at->format('M d, Y h:i A'),
            ]
        ]);
    }

    /**
     * Show adoption report details.
     */
    public function showAdoptionReport(\App\Models\AdoptionApplication $adoption)
    {
        $user = Auth::user();
        $adoption->load(['user', 'pet']);
        return view('dashboard.adoption-reports.show', compact('adoption', 'user'));
    }

    /**
     * Get analytics data for dashboard.
     */
    private function getAnalyticsData(int $year): array
    {
        // Monthly Bite Case Trend
        $currentYearCases = BiteRabiesReport::whereYear('incident_date', $year)->count();
        $previousYear = $year - 1;
        $previousYearCases = BiteRabiesReport::whereYear('incident_date', $previousYear)->count();
        $monthlyTrend = $previousYearCases > 0 ? round((($currentYearCases - $previousYearCases) / $previousYearCases) * 100, 1) : 0;

        // Bite Cases by Barangay (for analytics)
        $biteCasesByBarangayAnalytics = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', '')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->get();
        
        $biteCasesStats = [
            'highest' => $biteCasesByBarangayAnalytics->first(),
            'lowest' => $biteCasesByBarangayAnalytics->last(),
            'average' => $biteCasesByBarangayAnalytics->avg('count') ?? 0,
        ];

        // Adoption Performance
        $adoptionStats = [
            'pending' => \App\Models\AdoptionApplication::where('status', 'pending')->count(),
            'completed_this_month' => \App\Models\AdoptionApplication::where('status', 'completed')
                ->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', $year)
                ->count(),
        ];

        // Missing Pet Recovery
        $missingPetStats = [
            'active' => \App\Models\MissingPetsReport::where('status', 'missing')->count(),
            'resolved' => \App\Models\MissingPetsReport::whereIn('status', ['found', 'reunited'])->count(),
        ];
        $totalMissing = $missingPetStats['active'] + $missingPetStats['resolved'];
        $missingPetStats['recovery_rate'] = $totalMissing > 0 ? round(($missingPetStats['resolved'] / $totalMissing) * 100, 1) : 0;

        // Meat Establishment Monitoring
        $meatEstablishmentStats = [
            'active' => \App\Models\MeatEstablishment::where('status', 'Active')->count(),
            'expired' => \App\Models\MeatEstablishment::where('status', 'Expired')->count(),
            'pending_inspection' => \App\Models\MeatEstablishment::where('status', 'Pending Inspection')->count(),
            'due_for_renewal' => \App\Models\MeatEstablishment::where('permit_expiry_date', '<=', date('Y-m-d', strtotime('+30 days')))
                ->where('status', 'Active')
                ->count(),
        ];

        return [
            'monthly_trend' => $monthlyTrend,
            'bite_cases_by_barangay' => $biteCasesStats,
            'adoption_performance' => $adoptionStats,
            'missing_pet_recovery' => $missingPetStats,
            'meat_establishment_monitoring' => $meatEstablishmentStats,
        ];
    }
}
