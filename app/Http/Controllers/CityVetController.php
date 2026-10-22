<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\BiteRabiesReport;
use App\Models\VaccinationReport;
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
            'confirmed_bite_cases' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'anti_rabies_vaccinations' => VaccinationReport::whereYear('vaccination_date', $year)->count(),
            'adoption_reports' => \App\Models\AdoptionApplication::whereYear('created_at', $year)->count(),
            'missing_pet_reports' => \App\Models\MissingPetsReport::whereYear('created_at', $year)->count(),
            'registered_meat_establishments' => \App\Models\MeatEstablishment::count(),
        ];

        $kpiSecondary = [
            'rabies_total' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
            'vaccination_target' => 50,
            'adoption_dogs' => \App\Models\AdoptionApplication::whereYear('created_at', $year)->whereHas('pet', function ($q) {
                $q->where('species', 'Dog');
            })->count(),
            'adoption_cats' => \App\Models\AdoptionApplication::whereYear('created_at', $year)->whereHas('pet', function ($q) {
                $q->where('species', 'Cat');
            })->count(),
            'missing_reunited' => \App\Models\MissingPetsReport::where('status', 'resolved - reunited')->count(),
            'missing_pending' => \App\Models\MissingPetsReport::whereIn('status', ['pending review', 'approved'])->count(),
        ];

        // Get recent confirmed rabies cases only from current year
        $recentCases = BiteRabiesReport::whereYear('incident_date', date('Y'))
            ->with('barangay')
            ->latest()
            ->take(5)
            ->get();

        // Get top 5 barangays with highest confirmed rabies cases
        $topBarangays = BiteRabiesReport::whereYear('incident_date', $year)
            ->with('barangay')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Get lowest vaccination coverage by barangay
        $lowestVaccination = VaccinationReport::whereYear('vaccination_date', $year)
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
        $monthlyCases = BiteRabiesReport::whereYear('incident_date', $monthlyYear)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $dbYears = BiteRabiesReport::selectRaw('DISTINCT YEAR(incident_date) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $adoptionDbYears = \App\Models\AdoptionApplication::selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $missingDbYears = \App\Models\MissingPetsReport::selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $allDbYears = array_unique(array_merge($dbYears, $adoptionDbYears, $missingDbYears));

        $requiredYears = [date('Y'), date('Y') - 1, 2024];
        $availableYears = array_values(array_unique(array_merge($requiredYears, $allDbYears)));
        $availableYears = array_filter($availableYears, function ($y) {
            return $y >= 2024;
        });
        rsort($availableYears);
        $availableYears = array_values($availableYears);

        $currentYear = (int) date('Y');

        $biteChartMode = $request->bite_chart_mode ?? 'months';
        $biteChartTimeframe = $request->bite_chart_timeframe ?? ($biteChartMode === 'years' ? '3' : $currentYear);

        $biteMonthlyData = [];
        $yearlyLabels = [];
        $yearlyTotalData = [];

        if ($biteChartMode === 'months') {
            $biteMonthlyData = $this->getMonthlyCasesByYear((int)$biteChartTimeframe);
            $chartTotalCount = BiteRabiesReport::whereYear('incident_date', $biteChartTimeframe)->count();
        } else {
            $yearsBack = $biteChartTimeframe === 'all' ? 50 : (int)$biteChartTimeframe;
            $yearlyRaw = $this->getYearlyRabiesTotalsByYear($yearsBack);
            $yearlyLabels = array_column($yearlyRaw, 'year');
            $yearlyTotalData = array_column($yearlyRaw, 'total');
            $chartTotalCount = BiteRabiesReport::count();
        }

        $biteYearlyData = $this->getYearlyRabiesTotalsByYear();

        $adoptionChartMode = $request->adoption_chart_mode ?? 'months';
        $adoptionChartTimeframe = $request->adoption_chart_timeframe ?? $currentYear;

        $adoptionMonthlyPendingData = [];
        $adoptionMonthlyApprovedData = [];
        $adoptionMonthlyRejectedData = [];
        $yearlyAdoptionLabels = [];
        $yearlyAdoptionPendingData = [];
        $yearlyAdoptionApprovedData = [];
        $yearlyAdoptionRejectedData = [];

        if ($adoptionChartMode === 'months') {
            $adoptionMonthlyPendingData = $this->getMonthlyAdoptionStatusByYear((int)$adoptionChartTimeframe, 'pending_review');
            $adoptionMonthlyApprovedData = $this->getMonthlyAdoptionStatusByYear((int)$adoptionChartTimeframe, 'approved');
            $adoptionMonthlyRejectedData = $this->getMonthlyAdoptionStatusByYear((int)$adoptionChartTimeframe, 'rejected');
            $chartPendingCount = \App\Models\AdoptionApplication::where('status', 'pending_review')->whereYear('created_at', $adoptionChartTimeframe)->count();
            $chartApprovedCount = \App\Models\AdoptionApplication::where('status', 'approved')->whereYear('created_at', $adoptionChartTimeframe)->count();
            $chartRejectedCount = \App\Models\AdoptionApplication::where('status', 'rejected')->whereYear('created_at', $adoptionChartTimeframe)->count();
        } else {
            $yearsBack = $adoptionChartTimeframe === 'all' ? 50 : (int)$adoptionChartTimeframe;
            $yearlyRaw = $this->getYearlyAdoptionStatusCases($yearsBack);
            $yearlyAdoptionLabels = array_column($yearlyRaw, 'year');
            $yearlyAdoptionPendingData = array_column($yearlyRaw, 'pending_review');
            $yearlyAdoptionApprovedData = array_column($yearlyRaw, 'approved');
            $yearlyAdoptionRejectedData = array_column($yearlyRaw, 'rejected');
            $chartPendingCount = \App\Models\AdoptionApplication::where('status', 'pending_review')->count();
            $chartApprovedCount = \App\Models\AdoptionApplication::where('status', 'approved')->count();
            $chartRejectedCount = \App\Models\AdoptionApplication::where('status', 'rejected')->count();
        }

        $adoptionMonthlyData = $this->getMonthlyAdoptionByYear($adoptionChartTimeframe);
        $adoptionYearlyData = $this->getYearlyAdoptionTotals();

        $missingChartMode = $request->missing_chart_mode ?? 'months';
        $missingChartTimeframe = $request->missing_chart_timeframe ?? ($missingChartMode === 'years' ? '3' : $currentYear);

        $missingMonthlyPendingData = [];
        $missingMonthlyApprovedData = [];
        $missingMonthlyResolvedData = [];
        $missingMonthlyClosedData = [];
        $yearlyMissingLabels = [];
        $yearlyMissingPendingData = [];
        $yearlyMissingApprovedData = [];
        $yearlyMissingResolvedData = [];
        $yearlyMissingClosedData = [];

        if ($missingChartMode === 'months') {
            $missingMonthlyPendingData = $this->getMonthlyMissingStatusByYear((int)$missingChartTimeframe, 'pending review');
            $missingMonthlyApprovedData = $this->getMonthlyMissingStatusByYear((int)$missingChartTimeframe, 'approved');
            $missingMonthlyResolvedData = $this->getMonthlyMissingResolvedByYear((int)$missingChartTimeframe);
            $missingMonthlyClosedData = $this->getMonthlyMissingClosedByYear((int)$missingChartTimeframe);
            $chartMissingPendingCount = \App\Models\MissingPetsReport::where('status', 'pending review')->whereYear('created_at', $missingChartTimeframe)->count();
            $chartMissingApprovedCount = \App\Models\MissingPetsReport::where('status', 'approved')->whereYear('created_at', $missingChartTimeframe)->count();
            $chartMissingResolvedCount = \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->whereYear('created_at', $missingChartTimeframe)->count();
            $chartMissingClosedCount = \App\Models\MissingPetsReport::whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])->whereYear('created_at', $missingChartTimeframe)->count();
        } else {
            $yearsBack = $missingChartTimeframe === 'all' ? 50 : (int)$missingChartTimeframe;
            $yearlyRaw = $this->getYearlyMissingStatusCases($yearsBack);
            $yearlyMissingLabels = array_column($yearlyRaw, 'year');
            $yearlyMissingPendingData = array_column($yearlyRaw, 'pending_review');
            $yearlyMissingApprovedData = array_column($yearlyRaw, 'approved');
            $yearlyMissingResolvedData = array_column($yearlyRaw, 'resolved');
            $yearlyMissingClosedData = array_column($yearlyRaw, 'closed');
            $chartMissingPendingCount = \App\Models\MissingPetsReport::where('status', 'pending review')->count();
            $chartMissingApprovedCount = \App\Models\MissingPetsReport::where('status', 'approved')->count();
            $chartMissingResolvedCount = \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->count();
            $chartMissingClosedCount = \App\Models\MissingPetsReport::whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])->count();
        }

        $missingMonthlyData = $this->getMonthlyMissingByYear($missingChartTimeframe);
        $missingYearlyData = $this->getYearlyMissingTotals();

        $adoptionVolumeYear = $request->adoption_volume_year ?? $year;
        $adoptionVolumeApplications = array_map(fn($m) => $this->getMonthlyAdoptionByYear((int)$adoptionVolumeYear)[$m] ?? 0, range(1, 12));
        $adoptionVolumeCompleted = array_map(fn($m) => $this->getMonthlyAdoptionStatusByYear((int)$adoptionVolumeYear, 'Completed')[$m] ?? 0, range(1, 12));

        $lostFoundYear = $request->lost_found_year ?? $year;
        $lostFoundReportsFiled = array_map(fn($m) => $this->getMonthlyMissingByYear((int)$lostFoundYear)[$m] ?? 0, range(1, 12));
        $lostFoundPetsReunited = array_map(fn($m) => $this->getMonthlyMissingStatusByYear((int)$lostFoundYear, 'Resolved')[$m] ?? 0, range(1, 12));

        $compareChartMode = $request->compare_chart_mode ?? 'months';
        $compareChartTimeframe = $request->compare_chart_timeframe ?? ($compareChartMode === 'years' ? '3' : $currentYear);
        $compareBarangayId = $request->compare_barangay ?? null;

        $spayneuterChartMode = $request->spayneuter_chart_mode ?? 'months';
        $spayneuterChartTimeframe = $request->spayneuter_chart_timeframe ?? ($spayneuterChartMode === 'years' ? '3' : $currentYear);
        $spayneuterBarangayId = $request->spayneuter_barangay ?? null;

        if ($spayneuterChartMode === 'months') {
            $spayneuterLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $spayneuterData = $this->getMonthlySpayneuterData((int)$spayneuterChartTimeframe, $spayneuterBarangayId ? (int)$spayneuterBarangayId : null);
        } else {
            $yearsBack = $spayneuterChartTimeframe === 'all' ? 50 : (int)$spayneuterChartTimeframe;
            $yearlyRaw = $this->getYearlySpayneuterData($yearsBack, $spayneuterBarangayId ? (int)$spayneuterBarangayId : null);
            $spayneuterLabels = $yearlyRaw['labels'];
            $spayneuterData = $yearlyRaw['total'];
        }

        if ($compareChartMode === 'months') {
            $compareMonthlyRaw = $this->getMonthlyCompareData((int)$compareChartTimeframe, $compareBarangayId ? (int)$compareBarangayId : null);
            $compareLabels = $compareMonthlyRaw['labels'];
            $compareBiteData = $compareMonthlyRaw['bite'];
            $compareVaccData = $compareMonthlyRaw['vacc'];
        } else {
            $yearsBack = $compareChartTimeframe === 'all' ? 50 : (int)$compareChartTimeframe;
            $compareYearlyRaw = $this->getYearlyCompareData($yearsBack, $compareBarangayId ? (int)$compareBarangayId : null);
            $compareLabels = $compareYearlyRaw['labels'];
            $compareBiteData = $compareYearlyRaw['bite'];
            $compareVaccData = $compareYearlyRaw['vacc'];
        }

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
        $vaccinationsByBarangay = \App\Models\VaccinationReport::whereYear('vaccination_date', $year)
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
            'establishments',
            'availableYears',
            'biteChartMode',
            'biteChartTimeframe',
            'biteMonthlyData',
            'chartTotalCount',
            'biteYearlyData',
            'yearlyLabels',
            'yearlyTotalData',
            'adoptionChartMode',
            'adoptionChartTimeframe',
            'adoptionMonthlyData',
            'adoptionMonthlyPendingData',
            'adoptionMonthlyApprovedData',
            'adoptionMonthlyRejectedData',
            'chartPendingCount',
            'chartApprovedCount',
            'chartRejectedCount',
            'adoptionYearlyData',
            'yearlyAdoptionLabels',
            'yearlyAdoptionPendingData',
            'yearlyAdoptionApprovedData',
            'yearlyAdoptionRejectedData',
            'missingChartMode',
            'missingChartTimeframe',
            'missingMonthlyData',
            'missingMonthlyPendingData',
            'missingMonthlyApprovedData',
            'missingMonthlyResolvedData',
            'missingMonthlyClosedData',
            'chartMissingPendingCount',
            'chartMissingApprovedCount',
            'chartMissingResolvedCount',
            'chartMissingClosedCount',
            'missingYearlyData',
            'adoptionVolumeApplications',
            'adoptionVolumeCompleted',
            'lostFoundReportsFiled',
            'lostFoundPetsReunited',
            'yearlyMissingLabels',
            'yearlyMissingPendingData',
            'yearlyMissingApprovedData',
            'yearlyMissingResolvedData',
            'yearlyMissingClosedData',
            'compareChartMode',
            'compareChartTimeframe',
            'compareBarangayId',
            'compareLabels',
            'compareBiteData',
            'compareVaccData',
            'spayneuterChartMode',
            'spayneuterChartTimeframe',
            'spayneuterBarangayId',
            'spayneuterLabels',
            'spayneuterData',
            'kpiSecondary'
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
     * Get heatmap data for anti-rabies vaccinations.
     */
    private function getVaccinationHeatmapData(int $year): array
    {
        // Get vaccinations grouped by barangay
        $byBarangay = VaccinationReport::whereYear('vaccination_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0)
            ->where('barangay_id', '!=', '')
            ->selectRaw('barangay_id, COUNT(*) as count')
            ->groupBy('barangay_id')
            ->get();

        // Get ALL barangays with coordinates
        $barangays = Barangay::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['barangay_id', 'barangay_name', 'latitude', 'longitude']);

        $maxCount = $byBarangay->max('count') ?: 1;

        return $barangays->map(function ($barangay) use ($byBarangay, $maxCount) {
            $vaccCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $vaccCount ? (int) $vaccCount->count : 0;

            return [
                'id' => 'vaccination-'.$barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'vaccination',
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
     * Get monthly confirmed rabies cases for a given year as 1-indexed array.
     */
    private function getMonthlyCasesByYear(int $year): array
    {
        return BiteRabiesReport::whereYear('incident_date', $year)
            ->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getYearlyRabiesTotalsByYear(int $yearsBack = 50): array
    {
        $currentYear = (int) date('Y');
        $startYear = $currentYear - $yearsBack + 1;

        $total = BiteRabiesReport::whereYear('incident_date', '>=', $startYear)
            ->selectRaw('YEAR(incident_date) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $result = [];
        for ($y = $startYear; $y <= $currentYear; $y++) {
            $result[] = [
                'year' => $y,
                'total' => $total[$y] ?? 0,
            ];
        }

        return $result;
    }

    private function getMonthlyAdoptionByYear(int $year): array
    {
        return \App\Models\AdoptionApplication::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getYearlyAdoptionTotals(): array
    {
        return \App\Models\AdoptionApplication::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();
    }

    private function getMonthlyAdoptionStatusByYear(int $year, string $status): array
    {
        return \App\Models\AdoptionApplication::whereYear('created_at', $year)
            ->where('status', $status)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getYearlyAdoptionStatusCases(int $yearsBack = 50): array
    {
        $currentYear = (int) date('Y');
        $startYear = $currentYear - $yearsBack + 1;

        $pending = \App\Models\AdoptionApplication::where('status', 'pending_review')
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $approved = \App\Models\AdoptionApplication::where('status', 'approved')
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $rejected = \App\Models\AdoptionApplication::where('status', 'rejected')
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $result = [];
        for ($y = $startYear; $y <= $currentYear; $y++) {
            $result[] = [
                'year' => $y,
                'pending_review' => $pending[$y] ?? 0,
                'approved' => $approved[$y] ?? 0,
                'rejected' => $rejected[$y] ?? 0,
            ];
        }

        return $result;
    }

    private function getMonthlyMissingByYear(int $year): array
    {
        return \App\Models\MissingPetsReport::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getYearlyMissingTotals(): array
    {
        return \App\Models\MissingPetsReport::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();
    }

    private function getMonthlyMissingStatusByYear(int $year, string $status): array
    {
        return \App\Models\MissingPetsReport::whereYear('created_at', $year)
            ->where('status', $status)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getMonthlyMissingResolvedByYear(int $year): array
    {
        return \App\Models\MissingPetsReport::whereYear('created_at', $year)
            ->whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getMonthlyMissingClosedByYear(int $year): array
    {
        return \App\Models\MissingPetsReport::whereYear('created_at', $year)
            ->whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    private function getYearlyMissingStatusCases(int $yearsBack = 50): array
    {
        $currentYear = (int) date('Y');
        $startYear = $currentYear - $yearsBack + 1;

        $pending = \App\Models\MissingPetsReport::where('status', 'pending review')
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $approved = \App\Models\MissingPetsReport::where('status', 'approved')
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $resolved = \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $closed = \App\Models\MissingPetsReport::whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $result = [];
        for ($y = $startYear; $y <= $currentYear; $y++) {
            $result[] = [
                'year' => $y,
                'pending_review' => $pending[$y] ?? 0,
                'approved' => $approved[$y] ?? 0,
                'resolved' => $resolved[$y] ?? 0,
                'closed' => $closed[$y] ?? 0,
            ];
        }

        return $result;
    }

    private function getMonthlyCompareData(int $year, ?int $barangayId = null): array
    {
        $biteQuery = BiteRabiesReport::whereYear('incident_date', $year);
        $vaccQuery = \App\Models\VaccinationReport::whereYear('vaccination_date', $year);

        if ($barangayId) {
            $biteQuery->where('barangay_id', $barangayId);
            $vaccQuery->where('barangay_id', $barangayId);
        }

        $biteMonthly = $biteQuery->selectRaw('MONTH(incident_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $vaccMonthly = $vaccQuery->selectRaw('MONTH(vaccination_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $biteData = [];
        $vaccData = [];
        for ($m = 1; $m <= 12; $m++) {
            $biteData[] = $biteMonthly[$m] ?? 0;
            $vaccData[] = $vaccMonthly[$m] ?? 0;
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'bite' => $biteData,
            'vacc' => $vaccData,
        ];
    }

    private function getYearlyCompareData(int $yearsBack = 50, ?int $barangayId = null): array
    {
        $currentYear = (int) date('Y');
        $startYear = $currentYear - $yearsBack + 1;

        $biteQuery = BiteRabiesReport::whereYear('incident_date', '>=', $startYear);
        $vaccQuery = \App\Models\VaccinationReport::whereYear('vaccination_date', '>=', $startYear);

        if ($barangayId) {
            $biteQuery->where('barangay_id', $barangayId);
            $vaccQuery->where('barangay_id', $barangayId);
        }

        $biteYearly = $biteQuery->selectRaw('YEAR(incident_date) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $vaccYearly = $vaccQuery->selectRaw('YEAR(vaccination_date) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $labels = [];
        $biteData = [];
        $vaccData = [];
        for ($y = $startYear; $y <= $currentYear; $y++) {
            $labels[] = $y;
            $biteData[] = $biteYearly[$y] ?? 0;
            $vaccData[] = $vaccYearly[$y] ?? 0;
        }

        return [
            'labels' => $labels,
            'bite' => $biteData,
            'vacc' => $vaccData,
        ];
    }

    private function getMonthlySpayneuterData(int $year, ?int $barangayId = null): array
    {
        $query = \App\Models\SpayNeuterReport::whereYear('report_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0);

        if ($barangayId) {
            $query->where('barangay_id', $barangayId);
        }

        $spayneuterMonthly = $query->selectRaw('MONTH(report_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = $spayneuterMonthly[$m] ?? 0;
        }

        return $data;
    }

    private function getYearlySpayneuterData(int $yearsBack = 50, ?int $barangayId = null): array
    {
        $currentYear = (int) date('Y');
        $startYear = $currentYear - $yearsBack + 1;

        $query = \App\Models\SpayNeuterReport::whereYear('report_date', '>=', $startYear)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0);

        if ($barangayId) {
            $query->where('barangay_id', $barangayId);
        }

        $spayneuterYearly = $query->selectRaw('YEAR(report_date) as year, COUNT(*) as count')
            ->groupBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $labels = [];
        $data = [];
        for ($y = $startYear; $y <= $currentYear; $y++) {
            $labels[] = $y;
            $data[] = $spayneuterYearly[$y] ?? 0;
        }

        return [
            'labels' => $labels,
            'total' => $data,
        ];
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
        $type = $request->type ?? 'rabies'; // 'rabies' or 'vaccination'
        $severity = $request->severity ?? null; // 'critical', 'high', 'moderate', 'low', 'none'

        // Debug: Check if data exists
        $totalInDb = BiteRabiesReport::whereYear('incident_date', $year)->count();
        $withBarangay = BiteRabiesReport::whereYear('incident_date', $year)
            ->whereNotNull('barangay_id')->count();

        // Get data based on type
        if ($type === 'vaccination') {
            $heatmapData = $this->getFilteredVaccinationHeatmapData($year, $month, $week, $dateFrom, $dateTo, $severity);
            $caseTypeBreakdown = [];
            $totalCases = collect($heatmapData)->sum('count');
        } else {
            $heatmapData = $this->getFilteredHeatmapData($year, $month, $week, $dateFrom, $dateTo, $severity);
            $caseTypeBreakdown = $this->getFilteredCaseTypeBreakdown($year, $month, $week, $dateFrom, $dateTo);
            $totalCases = collect($heatmapData)->sum('count');
        }

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
            'type' => $type,
            'debug' => [
                'total_in_db' => $totalInDb,
                'with_barangay' => $withBarangay,
            ],
        ]);
    }

    /**
     * Get filtered heatmap data by year, month, and/or week.
     */
    private function getFilteredHeatmapData(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null, ?string $severity = null): array
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

        // Apply severity filter on aggregated case count
        if ($severity) {
            switch ($severity) {
                case 'critical':
                    $query->havingRaw('COUNT(*) > 20');
                    break;
                case 'high':
                    $query->havingRaw('COUNT(*) BETWEEN 11 AND 19');
                    break;
                case 'moderate':
                    $query->havingRaw('COUNT(*) BETWEEN 6 AND 10');
                    break;
                case 'low':
                    $query->havingRaw('COUNT(*) BETWEEN 1 AND 5');
                    break;
                case 'none':
                    $query->havingRaw('COUNT(*) = 0');
                    break;
            }
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
     * Get filtered vaccination heatmap data by year, month, and/or week.
     */
    private function getFilteredVaccinationHeatmapData(int $year, ?int $month = null, ?int $week = null, ?string $dateFrom = null, ?string $dateTo = null, ?string $severity = null): array
    {
        $query = VaccinationReport::whereYear('vaccination_date', $year)
            ->whereNotNull('barangay_id')
            ->where('barangay_id', '!=', 0)
            ->where('barangay_id', '!=', '');

        if ($dateFrom) {
            $query->where('vaccination_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('vaccination_date', '<=', $dateTo);
        }

        if ($month) {
            $query->whereMonth('vaccination_date', $month);
        }

        if ($week) {
            $query->whereRaw('WEEK(vaccination_date, 1) = ?', [$week]);
        }

        // Apply severity filter on aggregated vaccination count
        if ($severity) {
            switch ($severity) {
                case 'critical':
                    $query->havingRaw('COUNT(*) > 20');
                    break;
                case 'high':
                    $query->havingRaw('COUNT(*) BETWEEN 11 AND 19');
                    break;
                case 'moderate':
                    $query->havingRaw('COUNT(*) BETWEEN 6 AND 10');
                    break;
                case 'low':
                    $query->havingRaw('COUNT(*) BETWEEN 1 AND 5');
                    break;
                case 'none':
                    $query->havingRaw('COUNT(*) = 0');
                    break;
            }
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
            $vaccCount = $byBarangay->firstWhere('barangay_id', $barangay->barangay_id);
            $count = $vaccCount ? (int) $vaccCount->count : 0;

            return [
                'id' => 'vaccination-'.$barangay->barangay_id,
                'barangay_id' => $barangay->barangay_id,
                'barangay' => $barangay->barangay_name,
                'name' => $barangay->barangay_name,
                'latitude' => (float) $barangay->latitude,
                'longitude' => (float) $barangay->longitude,
                'lat' => (float) $barangay->latitude,
                'lng' => (float) $barangay->longitude,
                'count' => $count,
                'intensity' => round($count / $maxCount, 2),
                'incident_type' => 'vaccination',
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

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('report_id', 'like', "%{$term}%")
                            ->orWhereHas('pet', function ($q2) use ($term) {
                                $q2->where('pet_name', 'like', "%{$term}%")
                                    ->orWhere('species', 'like', "%{$term}%")
                                    ->orWhere('breed', 'like', "%{$term}%");
                            })
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('reported_by_name', 'like', "%{$term}%")
                            ->orWhere('reporter_contact', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('report_type')) {
            $query->where('report_type', $request->report_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('last_seen_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('last_seen_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(5);

        $stats = [
            'total' => \App\Models\MissingPetsReport::count(),
            'active' => \App\Models\MissingPetsReport::whereIn('status', ['pending review', 'approved'])->count(),
            'resolved' => \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->count(),
            'this_month' => \App\Models\MissingPetsReport::whereMonth('last_seen_at', date('m'))
                ->whereYear('last_seen_at', date('Y'))
                ->count(),
        ];

        return view('dashboard.missing-pet-reports', compact('user', 'reports', 'stats'));
    }

    public function filterMissingPetReports(Request $request)
    {
        $query = \App\Models\MissingPetsReport::with(['pet', 'user']);

        if ($request->filled('search')) {
            $terms = array_values(array_filter(explode(' ', $request->search)));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('report_id', 'like', "%{$term}%")
                            ->orWhereHas('pet', function ($q2) use ($term) {
                                $q2->where('pet_name', 'like', "%{$term}%")
                                    ->orWhere('species', 'like', "%{$term}%")
                                    ->orWhere('breed', 'like', "%{$term}%");
                            })
                            ->orWhereHas('barangay', function ($q2) use ($term) {
                                $q2->where('barangay_name', 'like', "%{$term}%");
                            })
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('reported_by_name', 'like', "%{$term}%")
                            ->orWhere('reporter_contact', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('report_type')) {
            $query->where('report_type', $request->report_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('last_seen_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('last_seen_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(5);

        try {
            $html = view('dashboard.partials.missing-pet-reports-table', compact('reports'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $reports->links()->render(),
            'has_results' => $reports->count() > 0,
        ]);
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
                'report_type' => $missingPet->report_type ?? 'missing',
                'status' => $missingPet->status,
                'pet_name' => $missingPet->pet->pet_name ?? 'N/A',
                'species' => ucfirst($missingPet->pet->species ?? 'N/A'),
                'breed' => $missingPet->pet->breed ?? 'N/A',
                'color' => $missingPet->pet->color ?? 'N/A',
                'gender' => ucfirst($missingPet->pet->gender ?? 'N/A'),
                'last_seen_at' => \Carbon\Carbon::parse($missingPet->last_seen_at)->format('M d, Y'),
                'last_seen_time' => \Carbon\Carbon::parse($missingPet->last_seen_at)->format('h:i A'),
                'location' => $missingPet->location_description,
                'barangay' => $missingPet->barangay->barangay_name ?? 'N/A',
                'description' => $missingPet->body_marks,
                'reporter_name' => $missingPet->reported_by_name ?? optional($missingPet->user)->name ?? 'Guest',
                'reporter_contact' => $missingPet->reporter_contact ?? ($missingPet->user->contact_number ?? 'N/A'),
                'reporter_email' => $missingPet->reporter_email ?? ($missingPet->user->email ?? 'N/A'),
                'reported_by' => $missingPet->reported_by_name ?? optional($missingPet->user)->name ?? 'N/A',
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

        $query = \App\Models\AdoptionApplication::with(['user', 'pet', 'owner']);

        if ($request->filled('search')) {
            $search = $request->search;
            $terms = array_values(array_filter(explode(' ', $search)));

            $dateFilter = null;
            if (preg_match('/\b(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\b/i', $search)) {
                $dateStr = str_replace([',', '  '], [' ', ' '], $search);

                try {
                    $dateFilter = \Carbon\Carbon::parse(trim($dateStr))->format('Y-m-d');
                } catch (\Throwable $e) {
                    $dateFilter = null;
                }
            }

            $query->where(function ($q) use ($terms, $dateFilter) {
                if ($dateFilter) {
                    $q->orWhereDate('created_at', $dateFilter);
                }

                foreach ($terms as $term) {
                    $q->orWhere(function ($sub) use ($term) {
                        $sub->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('created_at', 'like', "%{$term}%")
                            ->orWhereHas('pet', function ($q2) use ($term) {
                                $q2->where('pet_name', 'like', "%{$term}%")
                                    ->orWhere('breed', 'like', "%{$term}%")
                                    ->orWhere('species', 'like', "%{$term}%");
                            })
                            ->orWhereHas('owner', function ($q2) use ($term) {
                                $q2->where('first_name', 'like', "%{$term}%")
                                    ->orWhere('last_name', 'like', "%{$term}%")
                                    ->orWhere('phone_number', 'like', "%{$term}%");
                            })
                            ->orWhereHas('user', function ($q2) use ($term) {
                                $q2->where('email', 'like', "%{$term}%");
                            });
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(10);

        $stats = [
            'total' => \App\Models\AdoptionApplication::count(),
            'pending_review' => \App\Models\AdoptionApplication::where('status', 'pending_review')->count(),
            'approved' => \App\Models\AdoptionApplication::where('status', 'approved')->count(),
            'rejected' => \App\Models\AdoptionApplication::where('status', 'rejected')->count(),
            'adopted' => \App\Models\AdoptionApplication::where('status', 'adopted')->count(),
            'this_month' => \App\Models\AdoptionApplication::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
        ];

        return view('dashboard.adoption-reports', compact('user', 'reports', 'stats'));
    }

    public function filterAdoptionReports(Request $request)
    {
        $query = \App\Models\AdoptionApplication::with(['user', 'pet', 'owner']);

        if ($request->filled('search')) {
            $search = $request->search;
            $terms = array_values(array_filter(explode(' ', $search)));

            $dateFilter = null;
            if (preg_match('/\b(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\b/i', $search)) {
                $dateStr = str_replace([',', '  '], [' ', ' '], $search);

                try {
                    $dateFilter = \Carbon\Carbon::parse(trim($dateStr))->format('Y-m-d');
                } catch (\Throwable $e) {
                    $dateFilter = null;
                }
            }

            $query->where(function ($q) use ($terms, $dateFilter) {
                if ($dateFilter) {
                    $q->orWhereDate('created_at', $dateFilter);
                }

                foreach ($terms as $term) {
                    $q->orWhere(function ($sub) use ($term) {
                        $sub->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('created_at', 'like', "%{$term}%")
                            ->orWhereHas('pet', function ($q2) use ($term) {
                                $q2->where('pet_name', 'like', "%{$term}%")
                                    ->orWhere('breed', 'like', "%{$term}%")
                                    ->orWhere('species', 'like', "%{$term}%");
                            })
                            ->orWhereHas('owner', function ($q2) use ($term) {
                                $q2->where('first_name', 'like', "%{$term}%")
                                    ->orWhere('last_name', 'like', "%{$term}%")
                                    ->orWhere('phone_number', 'like', "%{$term}%");
                            })
                            ->orWhereHas('user', function ($q2) use ($term) {
                                $q2->where('email', 'like', "%{$term}%");
                            });
                    });
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(10);

        try {
            $html = view('dashboard.partials.adoption-reports-table', compact('reports'))->render();
        } catch (\Throwable $e) {
            $html = '<tr><td colspan="7" class="px-4 py-8 text-center text-red-600">Error loading results. Please try again.</td></tr>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $reports->links()->render(),
            'has_results' => $reports->count() > 0,
        ]);
    }

    /**
     * Show adoption report details (JSON for modal).
     */
    public function showAdoptionReportJson(\App\Models\AdoptionApplication $adoption)
    {
        $adoption->load(['user', 'pet', 'owner', 'address']);

        $q = $adoption->questionnaire ?? [];

        return response()->json([
            'success' => true,
            'report' => [
                'id' => $adoption->id,
                'report_number' => 'AD-' . str_pad($adoption->id, 5, '0', STR_PAD_LEFT),
                'status' => $adoption->status,
                'applicant_name' => trim(($adoption->first_name ?? '') . ' ' . ($adoption->last_name ?? '')) ?: 'N/A',
                'applicant_email' => $adoption->email ?? 'N/A',
                'applicant_contact' => $adoption->mobile_number ?? ($adoption->owner?->phone_number ?? 'N/A'),
                'pet_name' => $adoption->pet->pet_name ?? 'N/A',
                'pet_species' => ucfirst($adoption->pet->species ?? 'N/A'),
                'pet_breed' => $adoption->pet->breed ?? 'N/A',
                'pet_gender' => ucfirst($adoption->pet->gender ?? 'N/A'),
                'reason' => $q['relocation_plan'] ?? $adoption->rejection_reason ?? 'N/A',
                'has_other_pets' => $q['current_pets'] ?? 'N/A',
                'other_pets_details' => $q['past_pet_experience'] ?? 'N/A',
                'home_type' => ucfirst($q['housing_type'] ?? 'N/A'),
                'yard_has_fence' => 'N/A',
                'adoption_date' => $adoption->appointment_date ? \Carbon\Carbon::parse($adoption->appointment_date)->format('M d, Y') : 'N/A',
                'appointment_time' => $adoption->appointment_time ? \Carbon\Carbon::createFromFormat('H:i:s', $adoption->appointment_time)->format('h:i A') : 'N/A',
                'notes' => $adoption->rejection_reason ?? 'N/A',
                'created_at' => $adoption->created_at->format('F j, Y \a\t g:i A'),
                'marital_status' => $adoption->marital_status ?? 'N/A',
                'occupation' => $adoption->occupation ?? 'N/A',
                'company' => $adoption->company ?? 'N/A',
                'social_media' => $adoption->social_media ?? 'N/A',
                'address' => trim(($adoption->address?->block_lot_phase ?? '') . ' ' . ($adoption->address?->street ?? '') . ', ' . ($adoption->address?->barangay?->barangay_name ?? '')) ?: 'N/A',
                'valid_id_path' => $adoption->valid_id_path,
                'home_photos' => collect($q['home_photos'] ?? [])->flatten()->filter()->values()->all(),
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

        $totalConfirmedCases = BiteRabiesReport::whereYear('incident_date', $year)->count();
        $dogCases = BiteRabiesReport::whereYear('incident_date', $year)->where('animal_type', 'dog')->count();
        $catCases = BiteRabiesReport::whereYear('incident_date', $year)->where('animal_type', 'cat')->count();
        $strayCases = BiteRabiesReport::whereYear('incident_date', $year)->where('animal_status', 'stray')->count();
        $ownedCases = BiteRabiesReport::whereYear('incident_date', $year)->where('animal_status', 'owned')->count();

        $biteCasesStats = [
            'total_confirmed_cases' => $totalConfirmedCases,
            'dog_cases' => $dogCases,
            'cat_cases' => $catCases,
            'stray_cases' => $strayCases,
            'owned_cases' => $ownedCases,
        ];

        // Adoption Performance
        $totalAdoptions = \App\Models\AdoptionApplication::count();
        $approvedCount = \App\Models\AdoptionApplication::where('status', 'approved')->count();
        $adoptionStats = [
            'pending' => \App\Models\AdoptionApplication::where('status', 'pending_review')->count(),
            'approved' => $approvedCount,
            'adoption_rate' => $totalAdoptions > 0 ? round(($approvedCount / $totalAdoptions) * 100, 1) : 0,
        ];

        // Missing Pet Recovery
        $missingPetActive = \App\Models\MissingPetsReport::whereIn('status', ['pending review', 'approved'])->count();
        $missingPetResolved = \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->count();
        $missingPetStats = [
            'active' => $missingPetActive,
            'resolved' => $missingPetResolved,
        ];
        $totalMissing = $missingPetActive + $missingPetResolved;
        $missingPetStats['recovery_rate'] = $totalMissing > 0 ? round(($missingPetResolved / $totalMissing) * 100, 1) : 0;
        // Vaccination Performance
        $actualVaccinations = VaccinationReport::whereYear('vaccination_date', $year)->count();
        $vaccinationTarget = 600; // 50 doses/month × 12 months
        $vaccinationStats = [
            'actual' => $actualVaccinations,
            'target' => $vaccinationTarget,
            'percentage' => $vaccinationTarget > 0 ? round(($actualVaccinations / $vaccinationTarget) * 100, 1) : 0,
        ];

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
            'vaccination_performance' => $vaccinationStats,
            'adoption_performance' => $adoptionStats,
            'missing_pet_recovery' => $missingPetStats,
            'meat_establishment_monitoring' => $meatEstablishmentStats,
        ];
    }

    public function chartData(Request $request)
    {
        $mode = $request->query('mode', 'months');
        $timeframe = $request->query('timeframe');

        if ($mode === 'compare') {
            $barangayId = $request->query('barangay_id');

            if ($request->query('view') === 'years') {
                $yearsBack = $timeframe === 'all' ? 50 : (int) $timeframe;
                $yearlyRaw = $this->getYearlyCompareData($yearsBack, $barangayId);

                return response()->json([
                    'mode' => 'years',
                    'labels' => $yearlyRaw['labels'],
                    'bite' => $yearlyRaw['bite'],
                    'vacc' => $yearlyRaw['vacc'],
                ]);
            }

            $year = (int) ($timeframe ?? date('Y'));
            $monthlyRaw = $this->getMonthlyCompareData($year, $barangayId);

            return response()->json([
                'mode' => 'months',
                'labels' => $monthlyRaw['labels'],
                'bite' => $monthlyRaw['bite'],
                'vacc' => $monthlyRaw['vacc'],
            ]);
        }

        if ($mode === 'missing') {
            if ($request->query('view') === 'years') {
                $yearsBack = $timeframe === 'all' ? 50 : (int) $timeframe;
                $yearlyRaw = $this->getYearlyMissingStatusCases($yearsBack);

                return response()->json([
                    'mode' => 'years',
                    'labels' => array_column($yearlyRaw, 'year'),
                    'pending' => array_column($yearlyRaw, 'pending_review'),
                    'approved' => array_column($yearlyRaw, 'approved'),
                    'resolved' => array_column($yearlyRaw, 'resolved'),
                    'closed' => array_column($yearlyRaw, 'closed'),
                    'pendingCount' => \App\Models\MissingPetsReport::where('status', 'pending review')->count(),
                    'approvedCount' => \App\Models\MissingPetsReport::where('status', 'approved')->count(),
                    'resolvedCount' => \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->count(),
                    'closedCount' => \App\Models\MissingPetsReport::whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])->count(),
                ]);
            }

            $year = (int) ($timeframe ?? date('Y'));

            return response()->json([
                'mode' => 'months',
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'pending' => array_values(array_map(fn($m) => $this->getMonthlyMissingStatusByYear($year, 'pending review')[$m] ?? 0, range(1, 12))),
                'approved' => array_values(array_map(fn($m) => $this->getMonthlyMissingStatusByYear($year, 'approved')[$m] ?? 0, range(1, 12))),
                'resolved' => array_values(array_map(fn($m) => $this->getMonthlyMissingResolvedByYear($year)[$m] ?? 0, range(1, 12))),
                'closed' => array_values(array_map(fn($m) => $this->getMonthlyMissingClosedByYear($year)[$m] ?? 0, range(1, 12))),
                'pendingCount' => \App\Models\MissingPetsReport::where('status', 'pending review')->whereYear('created_at', $year)->count(),
                'approvedCount' => \App\Models\MissingPetsReport::where('status', 'approved')->whereYear('created_at', $year)->count(),
                'resolvedCount' => \App\Models\MissingPetsReport::whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])->whereYear('created_at', $year)->count(),
                'closedCount' => \App\Models\MissingPetsReport::whereIn('status', ['rejected', 'closed - expired', 'closed - cancelled', 'closed - duplicate'])->whereYear('created_at', $year)->count(),
            ]);
        }

        if ($mode === 'adoptions') {
            if ($request->query('view') === 'years') {
                $yearsBack = $timeframe === 'all' ? 50 : (int) $timeframe;
                $yearlyRaw = $this->getYearlyAdoptionStatusCases($yearsBack);

                return response()->json([
                    'mode' => 'years',
                    'labels' => array_column($yearlyRaw, 'year'),
                    'pending' => array_column($yearlyRaw, 'pending_review'),
                    'approved' => array_column($yearlyRaw, 'approved'),
                    'rejected' => array_column($yearlyRaw, 'rejected'),
                    'pendingCount' => \App\Models\AdoptionApplication::where('status', 'pending_review')->count(),
                    'approvedCount' => \App\Models\AdoptionApplication::where('status', 'approved')->count(),
                    'rejectedCount' => \App\Models\AdoptionApplication::where('status', 'rejected')->count(),
                ]);
            }

            $year = (int) ($timeframe ?? date('Y'));

            return response()->json([
                'mode' => 'months',
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'pending' => array_values(array_map(fn($m) => $this->getMonthlyAdoptionStatusByYear($year, 'pending_review')[$m] ?? 0, range(1, 12))),
                'approved' => array_values(array_map(fn($m) => $this->getMonthlyAdoptionStatusByYear($year, 'approved')[$m] ?? 0, range(1, 12))),
                'rejected' => array_values(array_map(fn($m) => $this->getMonthlyAdoptionStatusByYear($year, 'rejected')[$m] ?? 0, range(1, 12))),
                'pendingCount' => \App\Models\AdoptionApplication::where('status', 'pending_review')->whereYear('created_at', $year)->count(),
                'approvedCount' => \App\Models\AdoptionApplication::where('status', 'approved')->whereYear('created_at', $year)->count(),
                'rejectedCount' => \App\Models\AdoptionApplication::where('status', 'rejected')->whereYear('created_at', $year)->count(),
            ]);
        }

        if ($mode === 'spayneuter') {
            $barangayId = $request->query('barangay_id');

            if ($request->query('view') === 'years') {
                $yearsBack = $timeframe === 'all' ? 50 : (int) $timeframe;
                $yearlyRaw = $this->getYearlySpayneuterData($yearsBack, $barangayId);

                return response()->json([
                    'mode' => 'years',
                    'labels' => $yearlyRaw['labels'],
                    'total' => $yearlyRaw['total'],
                    'totalCount' => \App\Models\SpayNeuterReport::whereNotNull('barangay_id')
                        ->where('barangay_id', '!=', 0)
                        ->count(),
                ]);
            }

            $year = (int) ($timeframe ?? date('Y'));

            return response()->json([
                'mode' => 'months',
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'total' => array_values(array_map(fn($m) => $this->getMonthlySpayneuterData($year, $barangayId)[$m] ?? 0, range(1, 12))),
                'totalCount' => \App\Models\SpayNeuterReport::whereNotNull('barangay_id')
                    ->where('barangay_id', '!=', 0)
                    ->whereYear('report_date', $year)
                    ->count(),
            ]);
        }

        if ($mode === 'years') {
            $yearsBack = $timeframe === 'all' ? 50 : (int) $timeframe;
            $yearlyRaw = $this->getYearlyRabiesTotalsByYear($yearsBack);

            return response()->json([
                'mode' => 'years',
                'labels' => array_column($yearlyRaw, 'year'),
                'total' => array_column($yearlyRaw, 'total'),
                'totalCount' => BiteRabiesReport::count(),
            ]);
        }

        $year = (int) ($timeframe ?? date('Y'));

        return response()->json([
            'mode' => 'months',
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'total' => array_values(array_map(fn($m) => $this->getMonthlyCasesByYear($year)[$m] ?? 0, range(1, 12))),
            'totalCount' => BiteRabiesReport::whereYear('incident_date', $year)->count(),
        ]);
    }
}
