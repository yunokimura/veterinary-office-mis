@extends('layouts.admin')

@section('title', 'City Veterinarian Dashboard')

@section('header', 'City Veterinarian Dashboard')
@section('subheader', 'Rabies Control & Vaccination Program Overview')

@section('content')


<!-- KPI Cards Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-6">
    <!-- Confirmed Rabies Cases (Highest Priority) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <p class="text-xs md:text-sm text-gray-500 mb-1">Confirmed Rabies Cases</p>
        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['confirmed_bite_cases'] ?? 0 }}</p>
    </div>

    <!-- Anti-Rabies Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <p class="text-xs md:text-sm text-gray-500 mb-1">Anti-Rabies Vaccinations</p>
        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['anti_rabies_vaccinations'] ?? 0 }}</p>
    </div>

    <!-- Adoption Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <p class="text-xs md:text-sm text-gray-500 mb-1">Adoption Reports</p>
        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['adoption_reports'] ?? 0 }}</p>
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <p class="text-xs md:text-sm text-gray-500 mb-1">Missing Pet Reports</p>
        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['missing_pet_reports'] ?? 0 }}</p>
    </div>
</div>


<!-- Analytics Section -->
<div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Analytics Overview</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        <!-- Bite Cases by Barangay -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs font-medium text-gray-500 mb-2">Rabies Cases by Barangay</p>
            <p class="text-4xl font-bold text-gray-800 mb-1">{{ $analytics['bite_cases_by_barangay']['highest']->count ?? 0 }}</p>
            <p class="text-xs text-gray-500 mb-3">Peak Cases</p>
            <p class="text-xs text-gray-400">Avg: {{ round($analytics['bite_cases_by_barangay']['average'] ?? 0, 1) }} per barangay</p>
        </div>

        <!-- Adoption Performance -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs font-medium text-gray-500 mb-2">Adoption Performance</p>
            <p class="text-2xl font-bold text-gray-800 mb-1">{{ $analytics['adoption_performance']['adoption_rate'] ?? 0 }}%</p>
            <p class="text-xs text-gray-500 mb-3">Adoption Rate</p>
            <div class="flex gap-2">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ $analytics['adoption_performance']['approved'] ?? 0 }} Approved</span>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">{{ $analytics['adoption_performance']['pending'] ?? 0 }} Pending</span>
            </div>
        </div>

        <!-- Missing Pet Recovery -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs font-medium text-gray-500 mb-2">Missing Pet Recovery</p>
            <p class="text-2xl font-bold text-gray-800 mb-1">{{ $analytics['missing_pet_recovery']['recovery_rate'] ?? 0 }}%</p>
            <p class="text-xs text-gray-500 mb-3">Recovery Rate</p>
            <div class="flex gap-2">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ $analytics['missing_pet_recovery']['resolved'] ?? 0 }} Resolved</span>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">{{ $analytics['missing_pet_recovery']['active'] ?? 0 }} Active</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Confirmed Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
            <h3 class="text-base font-semibold text-gray-800">Confirmed Rabies Cases</h3>
            <div class="flex items-center gap-2 flex-wrap">
                <select id="biteChartMode" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="months" {{ $biteChartMode == 'months' ? 'selected' : '' }}>by months</option>
                    <option value="years" {{ $biteChartMode == 'years' ? 'selected' : '' }}>by years</option>
                </select>
                <div id="biteMonthsFilter" class="flex items-center gap-2">
                    <select id="biteChartTimeframe" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $biteChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="biteYearsFilter" class="hidden items-center gap-2">
                    <select id="biteChartRange" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="3" {{ $biteChartTimeframe == 3 ? 'selected' : '' }}>Last 3 Years</option>
                        <option value="5" {{ $biteChartTimeframe == 5 ? 'selected' : '' }}>Last 5 Years</option>
                        <option value="all" {{ $biteChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                    </select>
                </div>
                <span id="biteLegend" class="text-xs text-gray-600 font-medium"></span>
            </div>
        </div>
        <div class="h-64 relative">
            <canvas id="biteCasesByMonthChart"></canvas>
        </div>
    </div>

    <!-- Adoption Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
            <h3 class="text-base font-semibold text-gray-800">Adoption Reports</h3>
            <div class="flex items-center gap-2 flex-wrap">
                <select id="adoptionChartMode" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="months" {{ $adoptionChartMode == 'months' ? 'selected' : '' }}>by months</option>
                    <option value="years" {{ $adoptionChartMode == 'years' ? 'selected' : '' }}>by years</option>
                </select>
                <div id="adoptionMonthsFilter" class="flex items-center gap-2">
                    <select id="adoptionChartTimeframe" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $adoptionChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="adoptionYearsFilter" class="hidden items-center gap-2">
                    <select id="adoptionChartRange" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="3" {{ $adoptionChartTimeframe == 3 ? 'selected' : '' }}>Last 3 Years</option>
                        <option value="5" {{ $adoptionChartTimeframe == 5 ? 'selected' : '' }}>Last 5 Years</option>
                        <option value="all" {{ $adoptionChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                    </select>
                </div>
                <span id="adoptionLegend" class="text-xs text-gray-600 font-medium"></span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="adoptionReportsChart"></canvas>
        </div>
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
            <h3 class="text-base font-semibold text-gray-800">Missing Pet Reports</h3>
            <div class="flex items-center gap-2 flex-wrap">
                <select id="missingChartMode" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="months" {{ $missingChartMode == 'months' ? 'selected' : '' }}>by months</option>
                    <option value="years" {{ $missingChartMode == 'years' ? 'selected' : '' }}>by years</option>
                </select>
                <div id="missingMonthsFilter" class="flex items-center gap-2">
                    <select id="missingChartTimeframe" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $missingChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="missingYearsFilter" class="hidden items-center gap-2">
                    <select id="missingChartRange" class="bg-white border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="3" {{ $missingChartTimeframe == 3 ? 'selected' : '' }}>Last 3 Years</option>
                        <option value="5" {{ $missingChartTimeframe == 5 ? 'selected' : '' }}>Last 5 Years</option>
                        <option value="all" {{ $missingChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                    </select>
                </div>
                <span id="missingLegend" class="text-xs text-gray-600 font-medium"></span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="missingPetReportsChart"></canvas>
        </div>
    </div>

    <!-- Anti-Rabies Vaccinations per Barangay -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Anti-Rabies Vaccinations per Barangay</h3>
            <select onchange="window.location.href='?vaccination_barangay='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Barangays</option>
                @foreach($barangays as $id => $name)
                    <option value="{{ $id }}" {{ ($vaccinationBarangay ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="h-64">
            <canvas id="vaccinationsByBarangayChart"></canvas>
        </div>
    </div>

    <!-- Confirmed Rabies Cases per Barangay -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Confirmed Rabies Cases per Barangay</h3>
            <select onchange="window.location.href='?bite_barangay='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Barangays</option>
                @foreach($barangays as $id => $name)
                    <option value="{{ $id }}" {{ ($biteBarangay ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="h-64">
            <canvas id="biteCasesByBarangayChart"></canvas>
        </div>
    </div>

    <!-- Rabies Cases vs Vaccinations per Barangay -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Rabies Cases vs Vaccinations per Barangay</h3>
            <select onchange="window.location.href='?compare_barangay='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Barangays</option>
                @foreach($barangays as $id => $name)
                    <option value="{{ $id }}" {{ ($compareBarangay ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="h-64">
            <canvas id="biteVsVaccinationChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart data from PHP
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Barangay data for bar charts
    const vaccinationsByBarangay = @json($vaccinationsByBarangay ?? []);
    const biteCasesByBarangay = @json($biteCasesByBarangay ?? []);
    const barangays = @json($barangays ?? []);

    const biteMonthlyRaw = @json($biteMonthlyData ?? []);
    const biteYearlyRaw = @json($biteYearlyData ?? []);
    const adoptionMonthlyRaw = @json($adoptionMonthlyData ?? []);
    const adoptionYearlyRaw = @json($adoptionYearlyData ?? []);
    const missingMonthlyRaw = @json($missingMonthlyData ?? []);
    const missingYearlyRaw = @json($missingYearlyData ?? []);
    const currentMonth = new Date().getMonth() + 1;

    function buildLineDataset(label, data, borderColor, backgroundColor) {
        return {
            label,
            data,
            borderColor,
            backgroundColor,
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: borderColor,
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        };
    }

    function getBiteLabels(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            return years.map(String);
        }
        return monthLabels;
    }

    function getBiteDatasets(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            const data = years.map(y => biteYearlyRaw[y] || 0);
            return [buildLineDataset('Confirmed Rabies Cases', data, '#DC2626', 'rgba(220, 38, 38, 0.08)')];
        }
        const selectedMonth = parseInt(document.getElementById('biteChartTimeframe')?.value || '12', 10);
        const data = monthLabels.map((_, i) => {
            const monthNum = i + 1;
            if (monthNum > selectedMonth) return null;
            return biteMonthlyRaw[monthNum] || 0;
        });
        return [buildLineDataset('Confirmed Rabies Cases', data, '#DC2626', 'rgba(220, 38, 38, 0.08)')];
    }

    function getAdoptionLabels(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            return years.map(String);
        }
        return monthLabels;
    }

    function getAdoptionDatasets(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            const data = years.map(y => adoptionYearlyRaw[y] || 0);
            return [buildLineDataset('Adoption Reports', data, '#22c55e', 'rgba(34, 197, 94, 0.08)')];
        }
        const selectedMonth = parseInt(document.getElementById('adoptionChartTimeframe')?.value || '12', 10);
        const data = monthLabels.map((_, i) => {
            const monthNum = i + 1;
            if (monthNum > selectedMonth) return null;
            return adoptionMonthlyRaw[monthNum] || 0;
        });
        return [buildLineDataset('Adoption Reports', data, '#22c55e', 'rgba(34, 197, 94, 0.08)')];
    }

    function getMissingLabels(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            return years.map(String);
        }
        return monthLabels;
    }

    function getMissingDatasets(mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            const data = years.map(y => missingYearlyRaw[y] || 0);
            return [buildLineDataset('Missing Pet Reports', data, '#f97316', 'rgba(249, 115, 22, 0.08)')];
        }
        const selectedMonth = parseInt(document.getElementById('missingChartTimeframe')?.value || '12', 10);
        const data = monthLabels.map((_, i) => {
            const monthNum = i + 1;
            if (monthNum > selectedMonth) return null;
            return missingMonthlyRaw[monthNum] || 0;
        });
        return [buildLineDataset('Missing Pet Reports', data, '#f97316', 'rgba(249, 115, 22, 0.08)')];
    }

    function getYearRange(rangeValue) {
        const years = @json($availableYears ?? []);
        if (rangeValue === 'all') return years;
        const count = parseInt(rangeValue, 10);
        return years.slice(0, count);
    }

    function getLegendText(chart, mode, timeframe) {
        if (mode === 'years') {
            const years = getYearRange(timeframe);
            if (years.length === 0) return '';
            if (years.length === 1) return `● ${years[0]}`;
            return `● ${years[years.length - 1]} - ${years[0]}`;
        }
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const currentYear = new Date().getFullYear();
        if (chart === 'bite') {
            const selectedMonth = parseInt(document.getElementById('biteChartTimeframe')?.value || '12', 10);
            const monthName = monthNames[selectedMonth - 1] || '';
            return `● ${monthName} ${currentYear}`.trim();
        }
        if (chart === 'adoption') {
            const selectedMonth = parseInt(document.getElementById('adoptionChartTimeframe')?.value || '12', 10);
            const monthName = monthNames[selectedMonth - 1] || '';
            return `● ${monthName} ${currentYear}`.trim();
        }
        if (chart === 'missing') {
            const selectedMonth = parseInt(document.getElementById('missingChartTimeframe')?.value || '12', 10);
            const monthName = monthNames[selectedMonth - 1] || '';
            return `● ${monthName} ${currentYear}`.trim();
        }
        return '';
    }

    const biteCtx = document.getElementById('biteCasesByMonthChart').getContext('2d');
    const biteChart = new Chart(biteCtx, {
        type: 'line',
        data: {
            labels: getBiteLabels('{{ $biteChartMode }}', '{{ $biteChartTimeframe }}'),
            datasets: getBiteDatasets('{{ $biteChartMode }}', '{{ $biteChartTimeframe }}')
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 10
                }
            },
            scales: {
                y: { beginAtZero: true, min: 0, ticks: { stepSize: 2 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    const adoptionCtx = document.getElementById('adoptionReportsChart').getContext('2d');
    const adoptionChart = new Chart(adoptionCtx, {
        type: 'line',
        data: {
            labels: getAdoptionLabels('{{ $adoptionChartMode }}', '{{ $adoptionChartTimeframe }}'),
            datasets: getAdoptionDatasets('{{ $adoptionChartMode }}', '{{ $adoptionChartTimeframe }}')
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 10
                }
            },
            scales: {
                y: { beginAtZero: true, min: 0, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    const missingCtx = document.getElementById('missingPetReportsChart').getContext('2d');
    const missingChart = new Chart(missingCtx, {
        type: 'line',
        data: {
            labels: getMissingLabels('{{ $missingChartMode }}', '{{ $missingChartTimeframe }}'),
            datasets: getMissingDatasets('{{ $missingChartMode }}', '{{ $missingChartTimeframe }}')
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 10
                }
            },
            scales: {
                y: { beginAtZero: true, min: 0, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    function updateBiteChart() {
        const mode = document.getElementById('biteChartMode')?.value || 'months';
        const timeframe = document.getElementById('biteChartRange')?.value || document.getElementById('biteChartTimeframe')?.value || '{{ $biteChartTimeframe }}';
        const monthsFilter = document.getElementById('biteMonthsFilter');
        const yearsFilter = document.getElementById('biteYearsFilter');
        if (mode === 'years') {
            monthsFilter.classList.add('hidden');
            yearsFilter.classList.remove('hidden');
            yearsFilter.classList.add('flex');
        } else {
            monthsFilter.classList.remove('hidden');
            yearsFilter.classList.add('hidden');
            yearsFilter.classList.remove('flex');
        }
        biteChart.data.labels = getBiteLabels(mode, timeframe);
        biteChart.data.datasets = getBiteDatasets(mode, timeframe);
        document.getElementById('biteLegend').textContent = getLegendText('bite', mode, timeframe);
        biteChart.update();
    }

    function updateAdoptionChart() {
        const mode = document.getElementById('adoptionChartMode')?.value || 'months';
        const timeframe = document.getElementById('adoptionChartRange')?.value || document.getElementById('adoptionChartTimeframe')?.value || '{{ $adoptionChartTimeframe }}';
        const monthsFilter = document.getElementById('adoptionMonthsFilter');
        const yearsFilter = document.getElementById('adoptionYearsFilter');
        if (mode === 'years') {
            monthsFilter.classList.add('hidden');
            yearsFilter.classList.remove('hidden');
            yearsFilter.classList.add('flex');
        } else {
            monthsFilter.classList.remove('hidden');
            yearsFilter.classList.add('hidden');
            yearsFilter.classList.remove('flex');
        }
        adoptionChart.data.labels = getAdoptionLabels(mode, timeframe);
        adoptionChart.data.datasets = getAdoptionDatasets(mode, timeframe);
        document.getElementById('adoptionLegend').textContent = getLegendText('adoption', mode, timeframe);
        adoptionChart.update();
    }

    function updateMissingChart() {
        const mode = document.getElementById('missingChartMode')?.value || 'months';
        const timeframe = document.getElementById('missingChartRange')?.value || document.getElementById('missingChartTimeframe')?.value || '{{ $missingChartTimeframe }}';
        const monthsFilter = document.getElementById('missingMonthsFilter');
        const yearsFilter = document.getElementById('missingYearsFilter');
        if (mode === 'years') {
            monthsFilter.classList.add('hidden');
            yearsFilter.classList.remove('hidden');
            yearsFilter.classList.add('flex');
        } else {
            monthsFilter.classList.remove('hidden');
            yearsFilter.classList.add('hidden');
            yearsFilter.classList.remove('flex');
        }
        missingChart.data.labels = getMissingLabels(mode, timeframe);
        missingChart.data.datasets = getMissingDatasets(mode, timeframe);
        document.getElementById('missingLegend').textContent = getLegendText('missing', mode, timeframe);
        missingChart.update();
    }

    const biteChartMode = document.getElementById('biteChartMode');
    if (biteChartMode) biteChartMode.addEventListener('change', updateBiteChart);
    const biteChartTimeframe = document.getElementById('biteChartTimeframe');
    if (biteChartTimeframe) biteChartTimeframe.addEventListener('change', updateBiteChart);
    const biteChartRange = document.getElementById('biteChartRange');
    if (biteChartRange) biteChartRange.addEventListener('change', updateBiteChart);

    const adoptionChartMode = document.getElementById('adoptionChartMode');
    if (adoptionChartMode) adoptionChartMode.addEventListener('change', updateAdoptionChart);
    const adoptionChartTimeframe = document.getElementById('adoptionChartTimeframe');
    if (adoptionChartTimeframe) adoptionChartTimeframe.addEventListener('change', updateAdoptionChart);
    const adoptionChartRange = document.getElementById('adoptionChartRange');
    if (adoptionChartRange) adoptionChartRange.addEventListener('change', updateAdoptionChart);

    const missingChartMode = document.getElementById('missingChartMode');
    if (missingChartMode) missingChartMode.addEventListener('change', updateMissingChart);
    const missingChartTimeframe = document.getElementById('missingChartTimeframe');
    if (missingChartTimeframe) missingChartTimeframe.addEventListener('change', updateMissingChart);
    const missingChartRange = document.getElementById('missingChartRange');
    if (missingChartRange) missingChartRange.addEventListener('change', updateMissingChart);

    // Initialize legends
    const biteMode = document.getElementById('biteChartMode')?.value || '{{ $biteChartMode }}';
    const adoptionMode = document.getElementById('adoptionChartMode')?.value || '{{ $adoptionChartMode }}';
    const missingMode = document.getElementById('missingChartMode')?.value || '{{ $missingChartMode }}';
    document.getElementById('biteLegend').textContent = getLegendText('bite', biteMode, '{{ $biteChartTimeframe }}');
    document.getElementById('adoptionLegend').textContent = getLegendText('adoption', adoptionMode, '{{ $adoptionChartTimeframe }}');
    document.getElementById('missingLegend').textContent = getLegendText('missing', missingMode, '{{ $missingChartTimeframe }}');

    // Vaccinations per Barangay Chart (Horizontal Bar)
    const vaccCtx = document.getElementById('vaccinationsByBarangayChart').getContext('2d');
    const vaccLabels = vaccinationsByBarangay.map(item => barangays[item.barangay_id] || 'Unknown');
    const vaccData = vaccinationsByBarangay.map(item => item.count);
    new Chart(vaccCtx, {
        type: 'bar',
        data: {
            labels: vaccLabels,
            datasets: [{
                label: 'Vaccinations',
                data: vaccData,
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                y: { grid: { display: false } }
            }
        }
    });

    // Bite Cases per Barangay Chart (Horizontal Bar)
    const biteBarangayCtx = document.getElementById('biteCasesByBarangayChart').getContext('2d');
    const biteBarangayLabels = biteCasesByBarangay.map(item => barangays[item.barangay_id] || 'Unknown');
    const biteBarangayData = biteCasesByBarangay.map(item => item.count);
    new Chart(biteBarangayCtx, {
        type: 'bar',
        data: {
            labels: biteBarangayLabels,
            datasets: [{
                label: 'Bite Cases',
                data: biteBarangayData,
                backgroundColor: '#ef4444',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                y: { grid: { display: false } }
            }
        }
    });

    // Bite Cases vs Vaccinations per Barangay (Clustered Bar)
    const compareCtx = document.getElementById('biteVsVaccinationChart').getContext('2d');
    
    // Get all unique barangays from both datasets
    const allBarangayIds = [...new Set([
        ...vaccinationsByBarangay.map(item => item.barangay_id),
        ...biteCasesByBarangay.map(item => item.barangay_id)
    ])].slice(0, 10); // Limit to top 10
    
    const compareLabels = allBarangayIds.map(id => barangays[id] || 'Unknown');
    const compareBiteData = allBarangayIds.map(id => {
        const found = biteCasesByBarangay.find(item => item.barangay_id == id);
        return found ? found.count : 0;
    });
    const compareVaccData = allBarangayIds.map(id => {
        const found = vaccinationsByBarangay.find(item => item.barangay_id == id);
        return found ? found.count : 0;
    });
    
    new Chart(compareCtx, {
        type: 'bar',
        data: {
            labels: compareLabels,
            datasets: [
                {
                    label: 'Bite Cases',
                    data: compareBiteData,
                    backgroundColor: '#ef4444',
                    borderRadius: 4
                },
                {
                    label: 'Vaccinations',
                    data: compareVaccData,
                    backgroundColor: '#3b82f6',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: 'top' } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush
