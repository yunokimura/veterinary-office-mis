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
@if(($stats['confirmed_bite_cases'] ?? 0) > 0)
<div class="bg-white border border-red-200 rounded-xl p-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
            <i class="bi bi-exclamation-triangle text-red-600"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-800">Attention Required</p>
            <p class="text-xs text-gray-600">
                <span class="font-semibold">{{ $stats['confirmed_bite_cases'] }}</span> confirmed bite case(s) requiring attention.
            </p>
        </div>
        <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition whitespace-nowrap">
            View Cases
        </a>
    </div>
</div>
@endif

<!-- KPI Cards Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
    <!-- Confirmed Rabies Cases (Highest Priority) -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-red-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-exclamation-triangle text-red-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Confirmed Rabies Cases</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $stats['confirmed_bite_cases'] ?? 0 }}</p>
            <p class="text-xs text-red-600 font-medium">Highest Priority</p>
        </div>
    </div>

    <!-- Anti-Rabies Vaccinations -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-eyedropper text-blue-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Anti-Rabies Vaccinations</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $stats['anti_rabies_vaccinations'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">This Year</p>
        </div>
    </div>

    <!-- Adoption Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-green-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-heart text-green-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Adoption Reports</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $stats['adoption_reports'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">This Year</p>
        </div>
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-orange-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-search text-orange-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Missing Pet Reports</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $stats['missing_pet_reports'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">This Year</p>
        </div>
    </div>

    <!-- Registered Meat Establishments -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-purple-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-shop text-purple-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Registered Meat Establishments</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $stats['registered_meat_establishments'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">Total</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 mb-6">
    <h3 class="text-base font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center justify-center p-3 md:p-4 pr-4 mr-1 bg-white rounded-xl shadow-sm transition group hover:-translate-y-1 h-full">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-red-600 rounded-xl flex items-center justify-center mb-1 md:mb-2">
                <i class="bi bi-eyedropper text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-semibold text-gray-700 text-center leading-tight whitespace-nowrap">Vaccination</span>
        </a>
        <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="flex flex-col items-center justify-center p-3 md:p-4 ml-1 bg-white rounded-xl shadow-sm transition group hover:-translate-y-1 h-full">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-orange-600 rounded-xl flex items-center justify-center mb-1 md:mb-2">
                <i class="bi bi-file-earmark-medical text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-semibold text-gray-700 text-center leading-tight whitespace-nowrap">Bite Reports</span>
        </a>
        <a href="{{ route('city-vet.rabies-geomap') }}" class="flex flex-col items-center justify-center p-3 md:p-4 ml-1 bg-white rounded-xl shadow-sm transition group hover:-translate-y-1 h-full">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-1 md:mb-2">
                <i class="bi bi-geo-alt-fill text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-semibold text-gray-700 text-center leading-tight whitespace-nowrap">Heatmap</span>
        </a>
        <a href="{{ route('admin.all-reports') }}" class="flex flex-col items-center justify-center p-3 md:p-4 ml-1 bg-white rounded-xl shadow-sm transition group hover:-translate-y-1 h-full">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-1 md:mb-2">
                <i class="bi bi-file-earmark-bar-graph text-white text-lg md:text-xl"></i>
            </div>
            <span class="text-xs md:text-sm font-semibold text-gray-700 text-center leading-tight whitespace-nowrap">Reports</span>
        </a>
    </div>
</div>

<!-- Analytics Section -->
<div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Analytics Overview</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Monthly Bite Case Trend -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-gray-500">Monthly Bite Case Trend</p>
                <i class="bi bi-graph-up text-gray-400"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800 mb-1">
                {{ $analytics['monthly_trend'] ?? 0 }}%
            </p>
            <p class="text-xs text-gray-500">
                @if(($analytics['monthly_trend'] ?? 0) > 0)
                    <span class="text-red-600">↑</span> vs last year
                @elseif(($analytics['monthly_trend'] ?? 0) < 0)
                    <span class="text-green-600">↓</span> vs last year
                @else
                    <span class="text-gray-600">→</span> vs last year
                @endif
            </p>
        </div>

        <!-- Bite Cases by Barangay -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-gray-500">Rabies Cases by Barangay</p>
                <i class="bi bi-geo-alt text-gray-400"></i>
            </div>
        <div class="space-y-1">
            <div class="flex justify-between text-xs">
                <span class="text-gray-600">Highest:</span>
                <span class="font-semibold text-gray-800">{{ $analytics['bite_cases_by_barangay']['highest']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-gray-600">Lowest:</span>
                <span class="font-semibold text-gray-800">{{ $analytics['bite_cases_by_barangay']['lowest']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-gray-600">Average:</span>
                <span class="font-semibold text-gray-800">{{ round($analytics['bite_cases_by_barangay']['average'] ?? 0, 1) }}</span>
            </div>
        </div>
        </div>

        <!-- Adoption Performance -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-gray-500">Adoption Performance</p>
                <i class="bi bi-heart text-gray-400"></i>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Pending:</span>
                    <span class="font-semibold text-orange-600">{{ $analytics['adoption_performance']['pending'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Completed:</span>
                    <span class="font-semibold text-green-600">{{ $analytics['adoption_performance']['completed_this_month'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Missing Pet Recovery -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-gray-500">Missing Pet Recovery</p>
                <i class="bi bi-search text-gray-400"></i>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Active:</span>
                    <span class="font-semibold text-orange-600">{{ $analytics['missing_pet_recovery']['active'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Resolved:</span>
                    <span class="font-semibold text-green-600">{{ $analytics['missing_pet_recovery']['resolved'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Recovery Rate:</span>
                    <span class="font-semibold text-blue-600">{{ $analytics['missing_pet_recovery']['recovery_rate'] ?? 0 }}%</span>
                </div>
            </div>
        </div>

        <!-- Meat Establishment Monitoring -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-gray-500">Meat Establishment</p>
                <i class="bi bi-shop text-gray-400"></i>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Active:</span>
                    <span class="font-semibold text-green-600">{{ $analytics['meat_establishment_monitoring']['active'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Expired:</span>
                    <span class="font-semibold text-red-600">{{ $analytics['meat_establishment_monitoring']['expired'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600">Pending:</span>
                    <span class="font-semibold text-orange-600">{{ $analytics['meat_establishment_monitoring']['pending_inspection'] ?? 0 }}</span>
                </div>
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

<!-- Operational Details Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- Recent Confirmed Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Recent Confirmed Rabies Cases</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Animal Type</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bite Category</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentCases ?? [] as $case)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-900">{{ \Carbon\Carbon::parse($case->incident_date)->format('M d, Y') }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $case->barangay->barangay_name ?? 'N/A' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ ucfirst($case->animal_type) }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $case->category ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-gray-500">No recent cases</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top 5 Barangays with Highest Confirmed Rabies Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Top 5 Barangays with Highest Confirmed Rabies Cases</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cases</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($topBarangays ?? [] as $index => $barangay)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-900 font-medium">#{{ $index + 1 }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $barangay->barangay->barangay_name ?? 'Unknown' }}</td>
                        <td class="px-3 py-2 text-gray-900 font-semibold">{{ $barangay->count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-3 py-4 text-center text-gray-500">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Lowest Vaccination Coverage -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Lowest Vaccination Coverage</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vaccinations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($lowestVaccination ?? [] as $vaccination)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-600">
                            {{ \App\Models\Barangay::find($vaccination->barangay_id)->barangay_name ?? 'Unknown' }}
                        </td>
                        <td class="px-3 py-2 text-gray-900 font-semibold">{{ $vaccination->count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-3 py-4 text-center text-gray-500">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Meat Establishments -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Meat Establishments</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Establishment</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Late Inspection</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($establishments ?? [] as $establishment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-900 font-medium">{{ $establishment->establishment_name }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($establishment->status == 'Active') bg-green-100 text-green-800
                                @elseif($establishment->status == 'Expired') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $establishment->status }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-600">
                            @if($establishment->last_inspection_date && \Carbon\Carbon::parse($establishment->last_inspection_date)->lt(now()->subMonths(3)))
                                <span class="text-red-600 font-medium">Yes</span>
                            @else
                                <span class="text-green-600">No</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-3 py-4 text-center text-gray-500">No establishments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
