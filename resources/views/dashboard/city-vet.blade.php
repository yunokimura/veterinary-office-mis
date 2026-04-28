@extends('layouts.admin')

@section('title', 'City Veterinarian Dashboard')

@section('header', 'City Veterinarian Dashboard')
@section('subheader', 'Rabies Control & Vaccination Program Overview')

@section('content')
@php
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good afternoon';
    } else {
        $greeting = 'Good evening';
    }
@endphp

<!-- Welcome Banner -->
<div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-6 border border-gray-200">
    <h2 class="text-xl md:text-2xl font-bold mb-2 text-gray-800">
        {{ $greeting }}, {{ auth()->user()->name ?? 'City Veterinarian' }}!
    </h2>
    <p class="text-sm md:text-base text-gray-600">
        Monitor rabies cases, vaccination programs, and animal health statistics.
    </p>
</div>

<!-- Alert Banner for critical issues -->
@if(($stats['open_cases'] ?? 0) > 0 || ($stats['confirmed_cases'] ?? 0) > 0)
<div class="bg-white border border-amber-200 rounded-xl p-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
            <i class="bi bi-exclamation-triangle text-amber-600"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-800">Attention Required</p>
            <p class="text-xs text-gray-600">
                @if(($stats['open_cases'] ?? 0) > 0)
                    <span class="font-semibold">{{ $stats['open_cases'] }}</span> open case(s) pending.
                @endif
                @if(($stats['confirmed_cases'] ?? 0) > 0)
                    <span class="ml-2"><span class="font-semibold">{{ $stats['confirmed_cases'] }}</span> confirmed positive case(s).</span>
                @endif
            </p>
        </div>
        <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-medium rounded-lg transition whitespace-nowrap">
            View Cases
        </a>
    </div>
</div>
@endif

<!-- Quick Stats Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
    <!-- Total Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Total Cases</p>
                <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ $stats['total_rabies_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Open Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Open</p>
                <p class="text-xl md:text-3xl font-bold text-orange-600 mt-1">{{ $stats['open_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-clock text-orange-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Confirmed Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Confirmed</p>
                <p class="text-xl md:text-3xl font-bold text-purple-600 mt-1">{{ $stats['confirmed_cases'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-virus text-purple-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Bite Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Bite Reports</p>
                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $stats['total_bite_reports'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-file-earmark-medical text-green-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-500">Vaccinations</p>
                <p class="text-xl md:text-3xl font-bold text-blue-600 mt-1">{{ $stats['total_vaccinations'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-eyedropper text-blue-600 text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Charts Section -->
    <div class="lg:col-span-2 space-y-4 md:space-y-6">
        <!-- Cases by Type Chart -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800">Cases by Type ({{ $year ?? date('Y') }})</h3>
                <span class="text-xs text-gray-500">Source: Rabies Case Records</span>
            </div>
            <div class="h-48 md:h-64">
                <canvas id="speciesChart"></canvas>
            </div>
        </div>

        <!-- Monthly Cases Chart -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800">Monthly Trend ({{ $year ?? date('Y') }})</h3>
                <span class="text-xs text-gray-500">Cases per month</span>
            </div>
            <div class="h-48 md:h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="space-y-4 md:space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-red-100 hover:bg-red-200 rounded-xl transition group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                        <i class="bi bi-eyedropper text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Vaccination</span>
                </a>
                <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="flex flex-col items-center p-3 md:p-4 bg-orange-100 hover:bg-orange-200 rounded-xl transition group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                        <i class="bi bi-file-earmark-medical text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Bite Reports</span>
                </a>
                <a href="{{ route('city-vet.rabies-geomap') }}" class="flex flex-col items-center p-3 md:p-4 bg-purple-100 hover:bg-purple-200 rounded-xl transition group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                        <i class="bi bi-geo-alt-fill text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Heatmap</span>
                </a>
                <a href="{{ route('admin.all-reports') }}" class="flex flex-col items-center p-3 md:p-4 bg-blue-100 hover:bg-blue-200 rounded-xl transition group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                        <i class="bi bi-file-earmark-bar-graph text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm font-medium text-gray-700 text-center">Reports</span>
                </a>
            </div>
        </div>

        <!-- Recent Bite Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Recent Bite Reports</h3>
            <div class="divide-y divide-gray-100">
                @forelse(\App\Models\BiteRabiesReport::latest()->take(5)->get() as $report)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-file-earmark-medical text-orange-600 text-sm md:text-base"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $report->patient_name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $report->barangay->barangay_name ?? 'N/A' }} • {{ $report->status }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent bite reports</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Vaccinations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Recent Vaccinations</h3>
            <div class="divide-y divide-gray-100">
                @forelse(\App\Models\RabiesVaccinationReport::latest()->take(5)->get() as $vaccination)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-eyedropper text-blue-600 text-sm md:text-base"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $vaccination->pet_name ?? $vaccination->patient_name ?? 'Vaccination' }}</p>
                                <p class="text-xs text-gray-500">{{ $vaccination->status }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($vaccination->vaccination_date)->format('M d, Y') }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent vaccinations</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Cases Table -->
<div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold text-gray-800">Recent Rabies Cases</h3>
        <a href="{{ route('rabies-cases.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
            View All <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Case #</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Animal Status</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentCases ?? [] as $case)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-gray-900 font-medium">{{ $case->report_number }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ ucfirst($case->animal_type) }}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 text-xs rounded-full @if($case->animal_status == 'stray') bg-red-100 text-red-800 @elseif($case->animal_status == 'owned') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($case->animal_status) }}
                        </span>
                    </td>
                    <td class="px-3 py-2 text-gray-600">{{ $case->barangay->barangay_name ?? 'N/A' }}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 text-xs rounded-full @if($case->status == 'Pending Review') bg-yellow-100 text-yellow-800 @elseif($case->status == 'Under Investigation') bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                            {{ $case->status }}
                        </span>
                    </td>
                    <td class="px-3 py-2 text-gray-500">{{ \Carbon\Carbon::parse($case->incident_date)->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-3 py-4 text-center text-gray-500">No recent cases</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cases by Type Chart
    const casesByType = @json($casesByType ?? []);
    const typeLabels = Object.keys(casesByType).map(k => k.charAt(0).toUpperCase() + k.slice(1));
    const typeData = Object.values(casesByType);
    const typeColors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6'];
    
    const speciesCtx = document.getElementById('speciesChart').getContext('2d');
    new Chart(speciesCtx, {
        type: 'bar',
        data: {
            labels: typeLabels,
            datasets: [{
                label: 'Cases',
                data: typeData,
                backgroundColor: typeColors.slice(0, typeLabels.length),
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1 },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Monthly Cases Chart
    const monthlyCases = @json($monthlyCases ?? []);
    const monthLabels = Array.from({length: 12}, (_, i) => {
        const date = new Date({{ $year ?? date('Y') }}, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });
    const monthlyData = monthLabels.map((_, i) => monthlyCases[i + 1] || 0);
    
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Cases',
                data: monthlyData,
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
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush