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
    <!-- Confirmed Rabies Cases by Month -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Confirmed Rabies Cases by Month</h3>
            <select onchange="window.location.href='?chart_month='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Months</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ ($chartMonth ?? '') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="h-64">
            <canvas id="biteCasesByMonthChart"></canvas>
        </div>
    </div>

    <!-- Adoption Reports by Month -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Adoption Reports by Month</h3>
            <select onchange="window.location.href='?adoption_month='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Months</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ ($adoptionMonth ?? '') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="h-64">
            <canvas id="adoptionReportsChart"></canvas>
        </div>
    </div>

    <!-- Missing Pet Reports by Month -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">Missing Pet Reports by Month</h3>
            <select onchange="window.location.href='?missing_month='+this.value" 
                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">All Months</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ ($missingMonth ?? '') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
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
    const monthlyBiteCases = @json($monthlyCases ?? []);
    const adoptionReportsByMonth = @json($adoptionReportsByMonth ?? []);
    const missingPetReportsByMonth = @json($missingPetReportsByMonth ?? []);
    const monthLabels = Array.from({length: 12}, (_, i) => {
        const date = new Date({{ $monthlyYear ?? date('Y') }}, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });
    const biteData = monthLabels.map((_, i) => monthlyBiteCases[i + 1] || 0);
    const adoptionData = monthLabels.map((_, i) => adoptionReportsByMonth[i + 1] || 0);
    const missingData = monthLabels.map((_, i) => missingPetReportsByMonth[i + 1] || 0);
    
    // Barangay data for bar charts
    const vaccinationsByBarangay = @json($vaccinationsByBarangay ?? []);
    const biteCasesByBarangay = @json($biteCasesByBarangay ?? []);
    const barangays = @json($barangays ?? []);

    // Confirmed Rabies Cases by Month Chart
    const biteCtx = document.getElementById('biteCasesByMonthChart').getContext('2d');
    new Chart(biteCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Confirmed Rabies Cases',
                data: biteData,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Adoption Reports by Month Chart
    const adoptionCtx = document.getElementById('adoptionReportsChart').getContext('2d');
    new Chart(adoptionCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Adoption Reports',
                data: adoptionData,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#22c55e',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Missing Pet Reports by Month Chart
    const missingCtx = document.getElementById('missingPetReportsChart').getContext('2d');
    new Chart(missingCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Missing Pet Reports',
                data: missingData,
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

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
