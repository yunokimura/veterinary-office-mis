@extends('layouts.admin')

@section('title', 'City Veterinarian Dashboard')

@section('header', 'City Veterinarian Dashboard')
@section('subheader', 'Rabies Control & Vaccination Program Overview')

@section('content')

<!-- Top Row: Key Metrics Summary Cards -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white rounded-xl shadow-sm p-4 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-slate-400">|</span>
                    <span class="text-xs text-slate-500">Updated today at 08:30 AM</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="refreshData()" class="px-3 py-1.5 rounded-xl text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center space-x-1.5">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                        <span>Refresh</span>
                    </button>
                    <button class="px-3.5 py-1.5 rounded-xl text-xs font-semibold text-white bg-brand-700 hover:bg-brand-800 transition-colors shadow-sm flex items-center space-x-1.5">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Export Summary Report</span>
                    </button>
                </div>
            </div>

<!-- KPI Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
  
    <!-- Card 1: Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <!-- Title Section (Fixed height ensures 1-line and 2-line titles take identical space) -->
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Confirmed Rabies Cases
            </span>
        </div>

        <!-- Metric & Badges Section -->
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $stats['confirmed_bite_cases'] ?? 0 }}</span>
                <span class="text-xs font-medium text-slate-500">Total Cases</span>
            </div>
            
            <div class="pt-3 grid grid-cols-2 gap-1.5">
                <span class="px-2 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60 flex items-center justify-between">
                    <span>Dog:</span> <span class="font-bold">12</span>
                </span>
                <span class="px-2 py-1 rounded-md text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60 flex items-center justify-between">
                    <span>Cat:</span> <span class="font-bold">18</span>
                </span>
                <span class="px-2 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/60 flex items-center justify-between">
                    <span>Stray:</span> <span class="font-bold">10</span>
                </span>
                <span class="px-2 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 flex items-center justify-between">
                    <span>Owned:</span> <span class="font-bold">20</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Card 2: Anti-Rabies Vaccination Performance -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Anti-Rabies Vaccination
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ ceil($analytics['vaccination_performance']['percentage'] ?? 0) }}%</span>
                <span class="text-xs font-medium text-slate-500">Performance</span>
            </div>
            
            <div class="pt-3 space-y-1.5">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500 font-medium">Progress</span>
                    <span class="font-bold text-slate-700">{{ ceil($analytics['vaccination_performance']['percentage'] ?? 0) }}% Output</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                    <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ ceil($analytics['vaccination_performance']['percentage'] ?? 0) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Pet Adoption Performance -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Pet Adoption Rate
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ ceil($analytics['adoption_performance']['adoption_rate'] ?? 0) }}%</span>
                <span class="text-xs font-medium text-slate-500">Adoption Rate</span>
            </div>
            
            <div class="pt-3 flex items-center space-x-2">
                <span class="px-2.5 py-1.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-semibold flex-1 text-center whitespace-nowrap">
                    0 Completed
                </span>
                <span class="px-2.5 py-1.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200/60 text-xs font-semibold flex-1 text-center">
                    4 Pending
                </span>
            </div>
        </div>
    </div>

    <!-- Card 4: Missing Pet Recovery -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Missing Pet Recovery
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ ceil($analytics['missing_pet_recovery']['recovery_rate'] ?? 0) }}%</span>
                <span class="text-xs font-medium text-slate-500">Recovery Rate</span>
            </div>
            
            <div class="pt-3 flex items-center space-x-2">
                <span class="px-2.5 py-1.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-semibold flex-1 text-center">
                    0 Resolved
                </span>
                <span class="px-2.5 py-1.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200/60 text-xs font-semibold flex-1 text-center">
                    10 Active
                </span>
            </div>
        </div>
    </div>

</div>

<!-- Spacing between KPI and Charts -->
<div class="mb-6"></div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Confirmed Rabies Cases vs Vaccinations per Barangay -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Confirmed Rabies Cases vs Vaccinations per Barangay</h3>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <div class="flex bg-gray-100 rounded-md p-0.5">
                        <button type="button" data-mode="months" data-timeframe="{{ date('Y') }}" class="compare-mode-btn px-2.5 py-1 text-xs rounded {{ $compareChartMode === 'months' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                            Months
                        </button>
                        <button type="button" data-mode="years" data-timeframe="3" class="compare-mode-btn px-2.5 py-1 text-xs rounded {{ $compareChartMode === 'years' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                            Years
                        </button>
                    </div>
                    @if($compareChartMode === 'months')
                        <select id="compareChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $compareChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    @else
                        <select id="compareChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                            <option value="3" {{ $compareChartTimeframe == '3' ? 'selected' : '' }}>Last 3 Years</option>
                            <option value="5" {{ $compareChartTimeframe == '5' ? 'selected' : '' }}>Last 5 Years</option>
                            <option value="all" {{ $compareChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                        </select>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <select id="compareBarangaySelect" onchange="window.location.href='?compare_barangay='+this.value" 
                            class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $id => $name)
                            <option value="{{ $id }}" {{ ($compareBarangayId ?? '') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="h-64">
            <canvas id="biteVsVaccinationChart"></canvas>
        </div>
    </div>

    <!-- Spay/Neuter (Kapon) Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Spay/Neuter (<i> Kapon </i>) Reports</h3>
                <p class="text-xs text-gray-500">By Barangay</p>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <div class="flex bg-gray-100 rounded-md p-0.5">
                        <button type="button" data-mode="months" data-timeframe="{{ date('Y') }}" class="spayneuter-mode-btn px-2.5 py-1 text-xs rounded {{ $spayneuterChartMode === 'months' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                            Months
                        </button>
                        <button type="button" data-mode="years" data-timeframe="3" class="spayneuter-mode-btn px-2.5 py-1 text-xs rounded {{ $spayneuterChartMode === 'years' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                            Years
                        </button>
                    </div>
                    @if($spayneuterChartMode === 'months')
                        <select id="spayneuterChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $spayneuterChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    @else
                        <select id="spayneuterChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                            <option value="3" {{ $spayneuterChartTimeframe == '3' ? 'selected' : '' }}>Last 3 Years</option>
                            <option value="5" {{ $spayneuterChartTimeframe == '5' ? 'selected' : '' }}>Last 5 Years</option>
                            <option value="all" {{ $spayneuterChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                        </select>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <select id="spayneuterBarangaySelect" onchange="window.location.href='?spayneuter_barangay='+this.value" 
                            class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $id => $name)
                            <option value="{{ $id }}" {{ ($spayneuterBarangayId ?? '') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="h-64">
            <canvas id="spayneuterReportsChart"></canvas>
        </div>
    </div>

    <!-- Pet Adoption Operational Volume -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Pet Adoption Operational Volume</h3>
                <p class="text-xs text-gray-500">Applications vs Successful Adoptions</p>
            </div>
        </div>
        <div class="h-64">
            <canvas id="petAdoptionVolumeChart"></canvas>
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
    const yearlyLabels = @json($yearlyLabels ?? []);
    const yearlyTotalData = @json($yearlyTotalData ?? []);

    const compareChartMode = '{{ $compareChartMode ?? 'months' }}';
    const compareBarangayId = '{{ $compareBarangayId ?? '' }}';
    const compareLabels = @json($compareLabels ?? []);
    const compareBiteData = @json($compareBiteData ?? []);
    const compareVaccData = @json($compareVaccData ?? []);
    const biteChartMode = '{{ $biteChartMode ?? 'months' }}';

    const spayneuterChartMode = '{{ $spayneuterChartMode ?? 'months' }}';
    const spayneuterChartTimeframe = '{{ $spayneuterChartTimeframe ?? '' }}';
    const spayneuterBarangayId = '{{ $spayneuterBarangayId ?? '' }}';
    const spayneuterLabels = @json($spayneuterLabels ?? []);
    const spayneuterData = @json($spayneuterData ?? []);
    const availableYears = @json($availableYears ?? []);

    const adoptionVolumeApplications = @json($adoptionVolumeApplications ?? []);
    const adoptionVolumeCompleted = @json($adoptionVolumeCompleted ?? []);

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

    function getBiteDatasets() {
        let totalData, labels;
        if (biteChartMode === 'years') {
            labels = yearlyLabels.map(String);
            totalData = yearlyTotalData;
        } else {
            labels = monthLabels;
            totalData = monthLabels.map((_, i) => biteMonthlyRaw[i + 1] || 0);
        }
        return [{
            label: 'Confirmed Cases',
            data: totalData,
            backgroundColor: '#3b82f6',
            borderRadius: 4
        }];
    }


    // Pet Adoption Operational Volume (Dual-Line)
    const adoptionVolumeCtx = document.getElementById('petAdoptionVolumeChart').getContext('2d');
    const adoptionVolumeChart = new Chart(adoptionVolumeCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [
                buildLineDataset('Applications Submitted', adoptionVolumeApplications, '#3b82f6', 'rgba(59, 130, 246, 0.1)'),
                buildLineDataset('Successful Adopted Pets', adoptionVolumeCompleted, '#22c55e', 'rgba(34, 197, 94, 0.1)')
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 16,
                        font: { size: 12 },
                        color: '#374151',
                        useBorderRadius: true,
                        borderRadius: 4
                    }
                },
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
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 15,
                    ticks: { stepSize: 1, color: '#374151' },
                    grid: { color: '#f3f4f6' },
                    title: {
                        display: true,
                        text: 'Number of Applications / Adoptions',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#374151' },
                    title: {
                        display: true,
                        text: 'Month (Jan to Dec)',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                }
            }
        }
    });

    // Confirmed Rabies Cases vs Vaccinations per Barangay (Clustered Bar)
    const compareCtx = document.getElementById('biteVsVaccinationChart').getContext('2d');
    const compareChart = new Chart(compareCtx, {
        type: 'bar',
        data: {
            labels: compareLabels.map(String),
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
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'rect',
                        padding: 16,
                        font: { size: 12 },
                        color: '#374151',
                        useBorderRadius: true,
                        borderRadius: 4
                    }
                },
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
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 2, color: '#374151' }, 
                    grid: { color: '#f3f4f6' },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                },
                x: { grid: { display: false }, ticks: { color: '#374151' } }
            }
        }
    });

    const loadCompareChart = async (mode, timeframe, barangayId) => {
        const url = new URL('{{ route('city-vet.dashboard.chart-data') }}', window.location.origin);
        url.searchParams.set('mode', 'compare');
        url.searchParams.set('view', mode);
        url.searchParams.set('timeframe', timeframe);
        if (barangayId) {
            url.searchParams.set('barangay_id', barangayId);
        }

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            compareChart.data.labels = data.labels.map(String);
            compareChart.data.datasets[0].data = data.bite;
            compareChart.data.datasets[1].data = data.vacc;
            compareChart.update();
        } catch (error) {
            console.error('Failed to load compare chart data:', error);
        }
    };

    document.querySelectorAll('.compare-mode-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const mode = btn.dataset.mode;
            const timeframe = btn.dataset.timeframe;
            const timeframeSelect = document.getElementById('compareChartTimeframe');
            const barangaySelect = document.getElementById('compareBarangaySelect');

            document.querySelectorAll('.compare-mode-btn').forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
                b.classList.add('text-gray-500', 'hover:text-gray-700');
            });
            btn.classList.remove('text-gray-500', 'hover:text-gray-700');
            btn.classList.add('bg-white', 'shadow-sm', 'text-gray-900');

            if (timeframeSelect) {
                if (mode === 'months') {
                    timeframeSelect.innerHTML = availableYears.map(y => `<option value="${y}">${y}</option>`).join('');
                    const selected = timeframeSelect.querySelector(`option[value="${timeframe}"]`);
                    if (selected) selected.selected = true;
                } else {
                    timeframeSelect.innerHTML = `
                        <option value="3">Last 3 Years</option>
                        <option value="5">Last 5 Years</option>
                        <option value="all">All Years</option>
                    `;
                    const selected = timeframeSelect.querySelector(`option[value="${timeframe}"]`);
                    if (selected) selected.selected = true;
                }
            }

            loadCompareChart(mode, timeframeSelect ? timeframeSelect.value : timeframe, barangaySelect ? barangaySelect.value : '');
        });
    });

    const compareChartTimeframe = document.getElementById('compareChartTimeframe');
    const compareBarangaySelect = document.getElementById('compareBarangaySelect');
    if (compareChartTimeframe) {
        compareChartTimeframe.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.compare-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadCompareChart(mode, compareChartTimeframe.value, compareBarangaySelect ? compareBarangaySelect.value : '');
        });
    }
    if (compareBarangaySelect) {
        compareBarangaySelect.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.compare-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadCompareChart(mode, compareChartTimeframe ? compareChartTimeframe.value : '{{ date('Y') }}', compareBarangaySelect.value);
        });
    }

    // Spay/Neuter (Kapon) Reports Chart
    const spayneuterCtx = document.getElementById('spayneuterReportsChart').getContext('2d');
    const spayneuterChart = new Chart(spayneuterCtx, {
        type: 'bar',
        data: {
            labels: spayneuterChartMode === 'years' ? spayneuterLabels.map(String) : monthLabels,
            datasets: [{
                label: 'Spay/Neuter Procedures',
                data: spayneuterData,
                backgroundColor: '#10b981',
                borderRadius: 4
            }]
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
                y: {
                    beginAtZero: true,
                    min: 0,
                    ticks: { stepSize: 1, color: '#374151' },
                    grid: { color: '#f3f4f6' },
                    title: {
                        display: true,
                        text: 'Number of Procedures',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                },
                x: { grid: { display: false }, ticks: { color: '#374151' } }
            }
        }
    });

    const loadSpayneuterChart = async (mode, timeframe, barangayId = null) => {
        const url = new URL('{{ route('city-vet.dashboard.chart-data') }}', window.location.origin);
        url.searchParams.set('mode', 'spayneuter');
        url.searchParams.set('view', mode);
        url.searchParams.set('timeframe', timeframe);
        if (barangayId) {
            url.searchParams.set('barangay_id', barangayId);
        } else if (spayneuterBarangayId) {
            url.searchParams.set('barangay_id', spayneuterBarangayId);
        }

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            spayneuterChart.data.labels = data.labels.map(String);
            spayneuterChart.data.datasets[0].data = data.total;
            spayneuterChart.update();
        } catch (error) {
            console.error('Failed to load spayneuter chart data:', error);
        }
    };

    document.querySelectorAll('.spayneuter-mode-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const mode = btn.dataset.mode;
            const timeframe = btn.dataset.timeframe;
            const timeframeSelect = document.getElementById('spayneuterChartTimeframe');

            document.querySelectorAll('.spayneuter-mode-btn').forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
                b.classList.add('text-gray-500', 'hover:text-gray-700');
            });
            btn.classList.remove('text-gray-500', 'hover:text-gray-700');
            btn.classList.add('bg-white', 'shadow-sm', 'text-gray-900');

            if (timeframeSelect) {
                if (mode === 'months') {
                    timeframeSelect.innerHTML = availableYears.map(y => `<option value="${y}">${y}</option>`).join('');
                    const selected = timeframeSelect.querySelector(`option[value="${timeframe}"]`);
                    if (selected) selected.selected = true;
                } else {
                    timeframeSelect.innerHTML = `
                        <option value="3">Last 3 Years</option>
                        <option value="5">Last 5 Years</option>
                        <option value="all">All Years</option>
                    `;
                    const selected = timeframeSelect.querySelector(`option[value="${timeframe}"]`);
                    if (selected) selected.selected = true;
                }
            }

            loadSpayneuterChart(mode, timeframeSelect ? timeframeSelect.value : timeframe);
        });
    });

    const spayneuterChartTimeframeEl = document.getElementById('spayneuterChartTimeframe');
    if (spayneuterChartTimeframeEl) {
        spayneuterChartTimeframeEl.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.spayneuter-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadSpayneuterChart(mode, spayneuterChartTimeframeEl.value);
        });
    }

    const spayneuterBarangaySelect = document.getElementById('spayneuterBarangaySelect');
    if (spayneuterBarangaySelect) {
        spayneuterBarangaySelect.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.spayneuter-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadSpayneuterChart(mode, spayneuterChartTimeframeEl ? spayneuterChartTimeframeEl.value : '{{ date('Y') }}', spayneuterBarangaySelect.value);
        });
    }
});
</script>
@endpush
