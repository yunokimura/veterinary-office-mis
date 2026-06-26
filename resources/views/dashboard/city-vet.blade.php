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
    <!-- Confirmed Bite Cases (Highest Priority) -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-red-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-exclamation-triangle text-red-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Confirmed Bite Cases</p>
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

@endsection
