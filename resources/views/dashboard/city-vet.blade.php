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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  
    <!-- Card 1: Rabies Cases -->
    <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100 flex flex-col justify-between h-full">
        <!-- Title Section (Fixed height ensures 1-line and 2-line titles take identical space) -->
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Confirmed Rabies Cases
            </span>
        </div>

        <!-- Metric & Badges Section -->
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">30</span>
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
    <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Anti-Rabies Vaccination
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">0.2%</span>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2 py-0.5 rounded-md">
                    Performance
                </span>
            </div>
            
            <div class="pt-3 space-y-1.5">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500 font-medium">Progress</span>
                    <span class="font-bold text-slate-700">1 / 600 Output</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                    <div class="bg-emerald-600 h-2 rounded-full" style="width: 0.2%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Pet Adoption Performance -->
    <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Pet Adoption Rate
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">0%</span>
                <span class="text-xs font-medium text-slate-500">Adoption Rate</span>
            </div>
            
            <div class="pt-3 flex items-center space-x-2">
                <span class="px-2.5 py-1.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-semibold flex-1 text-center">
                    0 Approved
                </span>
                <span class="px-2.5 py-1.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200/60 text-xs font-semibold flex-1 text-center">
                    4 Pending
                </span>
            </div>
        </div>
    </div>

    <!-- Card 4: Missing Pet Recovery -->
    <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Missing Pet Recovery
            </span>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">0%</span>
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

    <!-- Pet Adoption Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Pet Adoption Reports</h3>
                <p class="text-xs text-gray-500">By Status</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex bg-gray-100 rounded-md p-0.5">
                    <button type="button" data-mode="months" data-timeframe="{{ date('Y') }}" class="adoption-mode-btn px-2.5 py-1 text-xs rounded {{ $adoptionChartMode === 'months' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Months
                    </button>
                    <button type="button" data-mode="years" data-timeframe="3" class="adoption-mode-btn px-2.5 py-1 text-xs rounded {{ $adoptionChartMode === 'years' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Years
                    </button>
                </div>
                @if($adoptionChartMode === 'months')
                    <select id="adoptionChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $adoptionChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                @else
                    <select id="adoptionChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        <option value="3" {{ $adoptionChartTimeframe == '3' ? 'selected' : '' }}>Last 3 Years</option>
                        <option value="5" {{ $adoptionChartTimeframe == '5' ? 'selected' : '' }}>Last 5 Years</option>
                        <option value="all" {{ $adoptionChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                    </select>
                @endif
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <button type="button" id="adoptionLegendPending" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-amber-500"></span>
                <span class="text-xs text-gray-600">Pending Review: <span class="font-semibold">{{ ($chartPendingCount ?? 0) }}</span></span>
            </button>
            <button type="button" id="adoptionLegendApproved" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-green-500"></span>
                <span class="text-xs text-gray-600">Approved: <span class="font-semibold">{{ ($chartApprovedCount ?? 0) }}</span></span>
            </button>
            <button type="button" id="adoptionLegendRejected" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-red-500"></span>
                <span class="text-xs text-gray-600">Rejected: <span class="font-semibold">{{ ($chartRejectedCount ?? 0) }}</span></span>
            </button>
        </div>
        <div class="h-64">
            <canvas id="adoptionReportsChart"></canvas>
        </div>
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Missing Pet Reports</h3>
                <p class="text-xs text-gray-500">By Status</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex bg-gray-100 rounded-md p-0.5">
                    <button type="button" data-mode="months" data-timeframe="{{ date('Y') }}" class="missing-mode-btn px-2.5 py-1 text-xs rounded {{ $missingChartMode === 'months' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Months
                    </button>
                    <button type="button" data-mode="years" data-timeframe="3" class="missing-mode-btn px-2.5 py-1 text-xs rounded {{ $missingChartMode === 'years' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Years
                    </button>
                </div>
                @if($missingChartMode === 'months')
                    <select id="missingChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $missingChartTimeframe == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                @else
                    <select id="missingChartTimeframe" class="bg-white border border-gray-300 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none leading-tight">
                        <option value="3" {{ $missingChartTimeframe == '3' ? 'selected' : '' }}>Last 3 Years</option>
                        <option value="5" {{ $missingChartTimeframe == '5' ? 'selected' : '' }}>Last 5 Years</option>
                        <option value="all" {{ $missingChartTimeframe == 'all' ? 'selected' : '' }}>All Years</option>
                    </select>
                @endif
            </div>
        </div>
        <div class="flex gap-4 mb-4">
            <button type="button" id="missingLegendPending" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-amber-500"></span>
                <span class="text-xs text-gray-600">Pending Review: <span class="font-semibold">{{ ($chartMissingPendingCount ?? 0) }}</span></span>
            </button>
            <button type="button" id="missingLegendApproved" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-blue-500"></span>
                <span class="text-xs text-gray-600">Missing: <span class="font-semibold">{{ ($chartMissingApprovedCount ?? 0) }}</span></span>
            </button>
            <button type="button" id="missingLegendResolved" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-green-500"></span>
                <span class="text-xs text-gray-600">Resolved: <span class="font-semibold">{{ ($chartMissingResolvedCount ?? 0) }}</span></span>
            </button>
            <button type="button" id="missingLegendClosed" class="flex items-center gap-2 text-left px-2 py-1 rounded transition hover:bg-gray-100 cursor-pointer">
                <span class="w-3 h-3 rounded bg-red-500"></span>
                <span class="text-xs text-gray-600">Closed/Rejected: <span class="font-semibold">{{ ($chartMissingClosedCount ?? 0) }}</span></span>
            </button>
        </div>
        <div class="h-64">
            <canvas id="missingPetReportsChart"></canvas>
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
    const adoptionMonthlyRaw = @json($adoptionMonthlyData ?? []);
    const adoptionMonthlyPendingRaw = @json($adoptionMonthlyPendingData ?? []);
    const adoptionMonthlyApprovedRaw = @json($adoptionMonthlyApprovedData ?? []);
    const adoptionMonthlyRejectedRaw = @json($adoptionMonthlyRejectedData ?? []);
    const yearlyAdoptionLabels = @json($yearlyAdoptionLabels ?? []);
    const yearlyAdoptionPendingData = @json($yearlyAdoptionPendingData ?? []);
    const yearlyAdoptionApprovedData = @json($yearlyAdoptionApprovedData ?? []);
    const yearlyAdoptionRejectedData = @json($yearlyAdoptionRejectedData ?? []);
    const missingMonthlyRaw = @json($missingMonthlyData ?? []);
    const missingMonthlyPendingRaw = @json($missingMonthlyPendingData ?? []);
    const missingMonthlyApprovedRaw = @json($missingMonthlyApprovedData ?? []);
    const missingMonthlyResolvedRaw = @json($missingMonthlyResolvedData ?? []);
    const missingMonthlyClosedRaw = @json($missingMonthlyClosedData ?? []);
    const yearlyMissingLabels = @json($yearlyMissingLabels ?? []);
    const yearlyMissingPendingData = @json($yearlyMissingPendingData ?? []);
    const yearlyMissingApprovedData = @json($yearlyMissingApprovedData ?? []);
    const yearlyMissingResolvedData = @json($yearlyMissingResolvedData ?? []);
    const yearlyMissingClosedData = @json($yearlyMissingClosedData ?? []);
    const compareChartMode = '{{ $compareChartMode ?? 'months' }}';
    const compareBarangayId = '{{ $compareBarangayId ?? '' }}';
    const compareLabels = @json($compareLabels ?? []);
    const compareBiteData = @json($compareBiteData ?? []);
    const compareVaccData = @json($compareVaccData ?? []);
    const biteChartMode = '{{ $biteChartMode ?? 'months' }}';
    const adoptionChartMode = '{{ $adoptionChartMode ?? 'months' }}';
    const missingChartMode = '{{ $missingChartMode ?? 'months' }}';
    const spayneuterChartMode = '{{ $spayneuterChartMode ?? 'months' }}';
    const spayneuterChartTimeframe = '{{ $spayneuterChartTimeframe ?? '' }}';
    const spayneuterBarangayId = '{{ $spayneuterBarangayId ?? '' }}';
    const spayneuterLabels = @json($spayneuterLabels ?? []);
    const spayneuterData = @json($spayneuterData ?? []);
    const availableYears = @json($availableYears ?? []);

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

    function getAdoptionDatasets() {
        let pendingData, approvedData, rejectedData, labels;
        if (adoptionChartMode === 'years') {
            labels = yearlyAdoptionLabels.map(String);
            pendingData = yearlyAdoptionPendingData;
            approvedData = yearlyAdoptionApprovedData;
            rejectedData = yearlyAdoptionRejectedData;
        } else {
            labels = monthLabels;
            pendingData = monthLabels.map((_, i) => adoptionMonthlyPendingRaw[i + 1] || 0);
            approvedData = monthLabels.map((_, i) => adoptionMonthlyApprovedRaw[i + 1] || 0);
            rejectedData = monthLabels.map((_, i) => adoptionMonthlyRejectedRaw[i + 1] || 0);
        }
        return [
            {
                label: 'Pending Review',
                data: pendingData,
                backgroundColor: '#f59e0b',
                borderRadius: 4,
                stack: 'adoptions'
            },
            {
                label: 'Approved',
                data: approvedData,
                backgroundColor: '#22c55e',
                borderRadius: 4,
                stack: 'adoptions'
            },
            {
                label: 'Rejected',
                data: rejectedData,
                backgroundColor: '#ef4444',
                borderRadius: 4,
                stack: 'adoptions'
            }
        ];
    }

    function getMissingDatasets() {
        let pendingData, approvedData, resolvedData, closedData, labels;
        if (missingChartMode === 'years') {
            labels = yearlyMissingLabels.map(String);
            pendingData = yearlyMissingPendingData;
            approvedData = yearlyMissingApprovedData;
            resolvedData = yearlyMissingResolvedData;
            closedData = yearlyMissingClosedData;
        } else {
            labels = monthLabels;
            pendingData = monthLabels.map((_, i) => missingMonthlyPendingRaw[i + 1] || 0);
            approvedData = monthLabels.map((_, i) => missingMonthlyApprovedRaw[i + 1] || 0);
            resolvedData = monthLabels.map((_, i) => missingMonthlyResolvedRaw[i + 1] || 0);
            closedData = monthLabels.map((_, i) => missingMonthlyClosedRaw[i + 1] || 0);
        }
        return [
            {
                label: 'Pending Review',
                data: pendingData,
                backgroundColor: '#f59e0b',
                borderRadius: 4,
                stack: 'missing'
            },
            {
                label: 'Missing',
                data: approvedData,
                backgroundColor: '#3b82f6',
                borderRadius: 4,
                stack: 'missing'
            },
            {
                label: 'Resolved',
                data: resolvedData,
                backgroundColor: '#22c55e',
                borderRadius: 4,
                stack: 'missing'
            },
            {
                label: 'Closed/Rejected',
                data: closedData,
                backgroundColor: '#ef4444',
                borderRadius: 4,
                stack: 'missing'
            }
        ];
    }

    const adoptionCtx = document.getElementById('adoptionReportsChart').getContext('2d');
    const adoptionChart = new Chart(adoptionCtx, {
        type: 'bar',
        data: {
            labels: adoptionChartMode === 'years' ? yearlyAdoptionLabels.map(String) : monthLabels,
            datasets: getAdoptionDatasets()
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
                    stacked: true,
                    beginAtZero: true, 
                    min: 0, 
                    ticks: { stepSize: 2, color: '#374151' }, 
                    grid: { color: '#f3f4f6' },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                },
                x: { stacked: true, grid: { display: false }, ticks: { color: '#374151' } }
            }
        }
    });

    const adoptionPendingToggle = document.getElementById('adoptionLegendPending');
    const adoptionApprovedToggle = document.getElementById('adoptionLegendApproved');
    const adoptionRejectedToggle = document.getElementById('adoptionLegendRejected');
    if (adoptionPendingToggle && adoptionApprovedToggle && adoptionRejectedToggle && adoptionChart) {
        const updateToggleVisual = (el, visible) => {
            el.style.opacity = visible ? '1' : '0.5';
            el.style.textDecoration = visible ? 'none' : 'line-through';
        };
        adoptionPendingToggle.addEventListener('click', () => {
            const idx = 0;
            const next = !adoptionChart.isDatasetVisible(idx);
            adoptionChart.setDatasetVisibility(idx, next);
            adoptionChart.update();
            updateToggleVisual(adoptionPendingToggle, next);
        });
        adoptionApprovedToggle.addEventListener('click', () => {
            const idx = 1;
            const next = !adoptionChart.isDatasetVisible(idx);
            adoptionChart.setDatasetVisibility(idx, next);
            adoptionChart.update();
            updateToggleVisual(adoptionApprovedToggle, next);
        });
        adoptionRejectedToggle.addEventListener('click', () => {
            const idx = 2;
            const next = !adoptionChart.isDatasetVisible(idx);
            adoptionChart.setDatasetVisibility(idx, next);
            adoptionChart.update();
            updateToggleVisual(adoptionRejectedToggle, next);
        });
    }

    const loadAdoptionChart = async (mode, timeframe) => {
        const url = new URL('{{ route('city-vet.dashboard.chart-data') }}', window.location.origin);
        url.searchParams.set('mode', 'adoptions');
        url.searchParams.set('view', mode);
        url.searchParams.set('timeframe', timeframe);

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            adoptionChart.data.labels = data.labels.map(String);
            adoptionChart.data.datasets[0].data = data.pending;
            adoptionChart.data.datasets[1].data = data.approved;
            adoptionChart.data.datasets[2].data = data.rejected;
            adoptionChart.update();

            adoptionPendingToggle.querySelector('.font-semibold').textContent = data.pendingCount;
            adoptionApprovedToggle.querySelector('.font-semibold').textContent = data.approvedCount;
            adoptionRejectedToggle.querySelector('.font-semibold').textContent = data.rejectedCount;
        } catch (error) {
            console.error('Failed to load adoption chart data:', error);
        }
    };

    document.querySelectorAll('.adoption-mode-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const mode = btn.dataset.mode;
            const timeframe = btn.dataset.timeframe;
            const timeframeSelect = document.getElementById('adoptionChartTimeframe');

            document.querySelectorAll('.adoption-mode-btn').forEach(b => {
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

            loadAdoptionChart(mode, timeframeSelect ? timeframeSelect.value : timeframe);
        });
    });

    const adoptionChartTimeframe = document.getElementById('adoptionChartTimeframe');
    if (adoptionChartTimeframe) {
        adoptionChartTimeframe.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.adoption-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadAdoptionChart(mode, adoptionChartTimeframe.value);
        });
    }

    const missingCtx = document.getElementById('missingPetReportsChart').getContext('2d');
    const missingChart = new Chart(missingCtx, {
        type: 'bar',
        data: {
            labels: missingChartMode === 'years' ? yearlyMissingLabels.map(String) : monthLabels,
            datasets: getMissingDatasets()
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
                    stacked: true,
                    beginAtZero: true, 
                    min: 0, 
                    ticks: { stepSize: 2, color: '#374151' }, 
                    grid: { color: '#f3f4f6' },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#374151',
                        font: { size: 12, weight: 'normal' }
                    }
                },
                x: { stacked: true, grid: { display: false }, ticks: { color: '#374151' } }
            }
        }
    });

    const missingPendingToggle = document.getElementById('missingLegendPending');
    const missingApprovedToggle = document.getElementById('missingLegendApproved');
    const missingResolvedToggle = document.getElementById('missingLegendResolved');
    const missingClosedToggle = document.getElementById('missingLegendClosed');
    if (missingPendingToggle && missingApprovedToggle && missingResolvedToggle && missingClosedToggle && missingChart) {
        const updateToggleVisual = (el, visible) => {
            el.style.opacity = visible ? '1' : '0.5';
            el.style.textDecoration = visible ? 'none' : 'line-through';
        };
        missingPendingToggle.addEventListener('click', () => {
            const idx = 0;
            const next = !missingChart.isDatasetVisible(idx);
            missingChart.setDatasetVisibility(idx, next);
            missingChart.update();
            updateToggleVisual(missingPendingToggle, next);
        });
        missingApprovedToggle.addEventListener('click', () => {
            const idx = 1;
            const next = !missingChart.isDatasetVisible(idx);
            missingChart.setDatasetVisibility(idx, next);
            missingChart.update();
            updateToggleVisual(missingApprovedToggle, next);
        });
        missingResolvedToggle.addEventListener('click', () => {
            const idx = 2;
            const next = !missingChart.isDatasetVisible(idx);
            missingChart.setDatasetVisibility(idx, next);
            missingChart.update();
            updateToggleVisual(missingResolvedToggle, next);
        });
        missingClosedToggle.addEventListener('click', () => {
            const idx = 3;
            const next = !missingChart.isDatasetVisible(idx);
            missingChart.setDatasetVisibility(idx, next);
            missingChart.update();
            updateToggleVisual(missingClosedToggle, next);
        });
    }

    const loadMissingChart = async (mode, timeframe) => {
        const url = new URL('{{ route('city-vet.dashboard.chart-data') }}', window.location.origin);
        url.searchParams.set('mode', 'missing');
        url.searchParams.set('view', mode);
        url.searchParams.set('timeframe', timeframe);

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            missingChart.data.labels = data.labels.map(String);
            missingChart.data.datasets[0].data = data.pending;
            missingChart.data.datasets[1].data = data.approved;
            missingChart.data.datasets[2].data = data.resolved;
            missingChart.data.datasets[3].data = data.closed;
            missingChart.update();

            missingPendingToggle.querySelector('.font-semibold').textContent = data.pendingCount;
            missingApprovedToggle.querySelector('.font-semibold').textContent = data.approvedCount;
            missingResolvedToggle.querySelector('.font-semibold').textContent = data.resolvedCount;
            missingClosedToggle.querySelector('.font-semibold').textContent = data.closedCount;
        } catch (error) {
            console.error('Failed to load missing chart data:', error);
        }
    };

    document.querySelectorAll('.missing-mode-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const mode = btn.dataset.mode;
            const timeframe = btn.dataset.timeframe;
            const timeframeSelect = document.getElementById('missingChartTimeframe');

            document.querySelectorAll('.missing-mode-btn').forEach(b => {
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

            loadMissingChart(mode, timeframeSelect ? timeframeSelect.value : timeframe);
        });
    });

    const missingChartTimeframe = document.getElementById('missingChartTimeframe');
    if (missingChartTimeframe) {
        missingChartTimeframe.addEventListener('change', () => {
            const activeModeBtn = document.querySelector('.missing-mode-btn.bg-white');
            const mode = activeModeBtn ? activeModeBtn.dataset.mode : 'months';
            loadMissingChart(mode, missingChartTimeframe.value);
        });
    }

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
