@extends('layouts.admin')

@section('title', 'Rabies Geomap')
@section('header', 'Confirmed Rabies Geospatial Map')
@section('subheader', 'City of Dasmariñas Rabies Monitoring')

@php
    $currentYear = date('Y');
    $selectedYear = (int) ($year ?? $currentYear);
    $years = range($currentYear, $currentYear - 5);
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $totalCases = collect($heatmapData)->sum('count');
    $activeBarangays = collect($heatmapData)->where('count', '>', 0)->count();
    $criticalCount = collect($heatmapData)->where('count', '>', 20)->count();
@endphp

@section('topbar-actions')
    <button type="button" onclick="openNewReportModal()" class="inline-flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition border border-red-500/50">
        <i class="bi bi-plus-lg"></i>
        <span>New Report</span>
    </button>
@endsection

@section('content')
    <div class="geomap-wrapper">

        {{-- Map Container --}}
        <div id="geomap" class="geomap-leaflet" role="application" aria-label="Rabies cases geomap">
            <div class="geomap-loading">
                <div class="text-center">
                    <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                    <p class="text-sm text-slate-400">Initializing map...</p>
                </div>
            </div>
        </div>

        {{-- Floating: Left Column — Stats + Legend (top-left) --}}
        <div class="geomap-left-column">
            {{-- Stats Pills --}}
            <div class="geomap-stats">
                <div class="geomap-stats-inner">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-red-500" id="statTotalIcon"></div>
                        <span class="text-[11px] text-slate-400 font-medium" id="statTotalLabel">Total Cases</span>
                        <span class="text-base font-bold text-slate-800" id="statTotalCases">{{ $totalCases }}</span>
                    </div>
                    <div class="w-px h-4 bg-slate-200"></div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-amber-500" id="statAffectedIcon"></div>
                        <span class="text-[11px] text-slate-400 font-medium" id="statAffectedLabel">Affected</span>
                        <span class="text-base font-bold text-amber-600" id="statAffected">{{ $activeBarangays }}</span>
                    </div>
                    <div class="w-px h-4 bg-slate-200"></div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-rose-500" id="statCriticalIcon"></div>
                        <span class="text-[11px] text-slate-400 font-medium" id="statCriticalLabel">Critical</span>
                        <span class="text-base font-bold text-rose-600" id="statCritical">{{ $criticalCount }}</span>
                    </div>
                </div>
            </div>

            {{-- Legend Panel (below stats) --}}
            <div class="geomap-legend">
                {{-- Simple Legend Card --}}
                <div class="simple-legend-card">
                    <div class="simple-legend">
                        <p class="simple-legend-title">Severity Legend</p>
                        <div class="simple-legend-items">
                            <div class="simple-legend-item" onclick="setSeverityFilter('critical')">
                                <span class="simple-legend-dot" style="background: #dc2626;"></span>
                                <span class="simple-legend-text">Critical (20+)</span>
                            </div>
                            <div class="simple-legend-item" onclick="setSeverityFilter('high')">
                                <span class="simple-legend-dot" style="background: #ea580c;"></span>
                                <span class="simple-legend-text">High (11-19)</span>
                            </div>
                            <div class="simple-legend-item" onclick="setSeverityFilter('moderate')">
                                <span class="simple-legend-dot" style="background: #eab308;"></span>
                                <span class="simple-legend-text">Moderate (6-10)</span>
                            </div>
                            <div class="simple-legend-item" onclick="setSeverityFilter('low')">
                                <span class="simple-legend-dot" style="background: #fde68a;"></span>
                                <span class="simple-legend-text">Low (1-5)</span>
                            </div>
                            <div class="simple-legend-item" onclick="setSeverityFilter('none')">
                                <span class="simple-legend-dot" style="background: #cbd5e1;"></span>
                                <span class="simple-legend-text">No Cases</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Floating: View Changers + Filters (top-right column) --}}
        <div class="geomap-view-changers">
            <button id="btnRabiesLayer" class="layer-toggle-btn active" onclick="switchLayer('rabies')">
                <i class="bi bi-virus"></i>
                <span>Confirmed Rabies Cases</span>
            </button>
            <button id="btnVaccinationLayer" class="layer-toggle-btn" onclick="switchLayer('vaccination')">
                <i class="bi bi-shield-check"></i>
                <span>Anti-Rabies Vaccination</span>
            </button>

            {{-- Top Barangays Button --}}
            <button id="btnTopBarangays" class="layer-toggle-btn" onclick="openTopBarangaysModal()">
                <i class="bi bi-list-ol"></i>
                <span>Top Barangays</span>
            </button>

            {{-- Filter Button --}}
            <div class="geomap-filter-controls" x-data="{ filterOpen: false }">
                <button @click="filterOpen = !filterOpen" class="filter-toggle-btn">
                    <i class="bi bi-funnel text-[10px]"></i>
                    <span>Filters</span>
                    <i class="bi bi-chevron-down text-[8px] opacity-40"></i>
                </button>

                {{-- Filter Panel --}}
                <div x-show="filterOpen" x-transition @click.away="filterOpen = false" class="filter-panel">
                    {{-- Year Filter --}}
                    <div class="filter-section">
                        <label class="filter-label">Year</label>
                        <select id="filterYear" onchange="setFilter('year', parseInt(this.value))" class="filter-select">
                            @foreach($years as $y)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Month Filter --}}
                    <div class="filter-section">
                        <label class="filter-label">Month</label>
                        <select id="filterMonth" onchange="setFilter('month', this.value ? parseInt(this.value) : null)" class="filter-select">
                            <option value="">All Months</option>
                            @foreach($months as $num => $name)
                            <option value="{{ $num }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Week Filter --}}
                    <div class="filter-section">
                        <label class="filter-label">Week</label>
                        <select id="filterWeek" onchange="setFilter('week', this.value ? parseInt(this.value) : null)" class="filter-select">
                            <option value="">All Weeks</option>
                            @for($w = 1; $w <= 53; $w++)
                            <option value="{{ $w }}">Week {{ $w }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Date Range Filter --}}
                    <div class="filter-section">
                        <label class="filter-label">Date Range</label>
                        <div class="filter-date-range">
                            <div class="filter-date-field">
                                <label class="filter-date-label">From</label>
                                <input type="date" id="filterDateFrom" class="filter-date-input">
                            </div>
                            <div class="filter-date-field">
                                <label class="filter-date-label">To</label>
                                <input type="date" id="filterDateTo" class="filter-date-input">
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button id="clearFilterBtn" class="filter-clear-btn">
                            <i class="bi bi-x-circle text-[10px]"></i> Clear Filter
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div id="mapLoading" class="geomap-loading-overlay" style="display: none;">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-[3px] border-indigo-500 border-t-transparent"></div>
                <p class="mt-3 text-sm text-slate-500 font-medium">Loading map data...</p>
            </div>
        </div>

        {{-- Error --}}
        <div id="mapError" class="geomap-error hidden">
            <div class="geomap-error-inner">
                <i class="bi bi-exclamation-triangle text-red-500"></i>
                <div>
                    <p class="text-sm font-medium text-red-800" id="errorTitle">Error loading map</p>
                    <p class="text-xs text-red-600" id="errorMessage">Please refresh the page.</p>
                </div>
                <button onclick="location.reload()" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition">Retry</button>
            </div>
        </div>
    </div>

    {{-- New Report Modal --}}
    <div id="newReportModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-red-100 text-red-600 rounded-lg">
                        <i class="bi bi-file-earmark-plus w-5 h-5"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight">New Report</h5>
                        <p class="text-xs text-slate-500 leading-none">Record a rabies bite incident</p>
                    </div>
                </div>
                <button onclick="closeNewReportModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
                <form id="newReportForm" onsubmit="submitNewReport(event)">
                    @csrf

                    {{-- Section 1: Incident Information (red) --}}
                    <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                        <div class="bg-red-600 px-4 py-2.5 flex items-center gap-2 border-b border-red-500/50">
                            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.332-2.694-1.332-3.464 0L3.34 16c-.77 1.332.192 3 1.732 3z" /></svg>
                            <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Incident Information</h3>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-red-50 text-red-600 rounded-lg shrink-0 border border-red-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Report Number</label>
                                        <input type="text" name="report_number" id="modalReportNumber" readonly
                                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 font-mono">
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-red-50 text-red-600 rounded-lg shrink-0 border border-red-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Incident Date <span class="text-red-500">*</span></label>
                                        <input type="date" name="incident_date" id="modalIncidentDate" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-sm">
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-red-50 text-red-600 rounded-lg shrink-0 border border-red-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-2.828-2.828a1.998 1.998 0 010-2.828l4.244-4.243a9 9 0 111.414 1.414z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Barangay <span class="text-red-500">*</span></label>
                                        <select name="barangay_id" id="modalBarangayId" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-sm">
                                            <option value="">Select barangay</option>
                                            @foreach($barangays as $brgy)
                                                <option value="{{ $brgy->barangay_id }}">{{ $brgy->barangay_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3 md:col-span-2">
                                    <div class="p-2 bg-red-50 text-red-600 rounded-lg shrink-0 border border-red-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Exact Location</label>
                                        <input type="text" name="exact_location" id="modalExactLocation" placeholder="Specific location description"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Animal Information (purple) --}}
                    <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                        <div class="bg-purple-600 px-4 py-2.5 flex items-center gap-2 border-b border-purple-500/50">
                            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Animal Information</h3>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Animal Type <span class="text-red-500">*</span></label>
                                        <select name="animal_type" id="modalAnimalType" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm">
                                            <option value="">Select animal</option>
                                            <option value="dog">Dog</option>
                                            <option value="cat">Cat</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Animal Name</label>
                                        <input type="text" name="animal_name" id="modalAnimalName" placeholder="Pet name"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm">
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Animal Gender</label>
                                        <select name="animal_gender" id="modalAnimalGender"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm">
                                            <option value="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Animal Status <span class="text-red-500">*</span></label>
                                        <select name="animal_status" id="modalAnimalStatus" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm">
                                            <option value="">Select status</option>
                                            <option value="owned">Owned</option>
                                            <option value="stray">Stray</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Vaccination Status</label>
                                        <select name="vaccination_status" id="modalVaccinationStatus"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm">
                                            <option value="">Select status</option>
                                            <option value="vaccinated">Vaccinated</option>
                                            <option value="unvaccinated">Unvaccinated</option>
                                            <option value="unknown">Unknown</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Owner Information (indigo) --}}
                    <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                        <div class="bg-indigo-600 px-4 py-2.5 flex items-center gap-2 border-b border-indigo-500/50">
                            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Owner Information</h3>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Owner Name</label>
                                        <input type="text" name="animal_owner_name" id="modalOwnerName" placeholder="Owner full name"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm">
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" /></svg>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-medium mb-1">Owner Contact</label>
                                        <input type="tel" name="animal_owner_contact" id="modalOwnerContact" placeholder="Phone number"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-indigo-100">
                                <label class="block text-xs text-slate-400 font-medium mb-1">Notes</label>
                                <textarea name="notes" id="modalNotes" rows="2" placeholder="Additional notes or observations"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeNewReportModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition-colors">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Top Barangays Modal --}}
    <div id="topBarangaysModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-lg">
                        <i class="bi bi-list-ol w-5 h-5"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight">Top Barangays</h5>
                        <p class="text-xs text-slate-500 leading-none" id="topBarangaysModalSubtitle">Confirmed Rabies Cases</p>
                    </div>
                </div>
                <button onclick="closeTopBarangaysModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
                <!-- Type Tabs: Rabies Cases | Vaccination Coverage -->
                <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                    <button onclick="setTopBarangaysType('rabies')" id="topBarangaysTypeRabies" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-indigo-600 bg-white shadow-sm transition-colors">
                        Rabies Cases
                    </button>
                    <button onclick="setTopBarangaysType('vaccination')" id="topBarangaysTypeVaccination" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-slate-600 hover:text-slate-700 transition-colors">
                        Vaccination Coverage
                    </button>
                </div>

                <!-- Count Toggle: Top 5 | Top 10 -->
                <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                    <button onclick="setTopBarangaysLimit(5)" id="topBarangaysLimit5" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-indigo-600 bg-white shadow-sm transition-colors">
                        Top 5
                    </button>
                    <button onclick="setTopBarangaysLimit(10)" id="topBarangaysLimit10" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-slate-600 hover:text-slate-700 transition-colors">
                        Top 10
                    </button>
                </div>

                <!-- Loading State -->
                <div id="topBarangaysLoading" class="text-center py-8 hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading top barangays...</p>
                </div>

                <!-- Top Barangays List -->
                <div id="topBarangaysList" class="space-y-2">
                    <!-- Rows injected here via JS -->
                </div>

                <!-- Empty State -->
                <div id="topBarangaysEmpty" class="hidden text-center py-8">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-geo-alt text-slate-400 text-xl"></i>
                    </div>
                    <p class="text-sm text-slate-500">No barangays found for the selected filters.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <span class="text-xs text-slate-400" id="topBarangaysFilterLabel"></span>
                <button onclick="closeTopBarangaysModal()" class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors">
                    Done
                </button>
            </div>
        </div>
    </div>
@endsection

{{-- Styles --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* ========================================
       Geomap Layout — uses viewport height
       instead of flex-1/min-h-0 to ensure
       Leaflet always has a definite container
       ======================================== */

    /* Scoped override: only when .geomap-wrapper exists inside .content-wrapper */
    .content-wrapper:has(.geomap-wrapper) {
        height: calc(100vh - 64px) !important;
        min-height: 0 !important;
        overflow: hidden !important;
        padding: 0.5rem !important;
    }

    .geomap-wrapper {
        position: relative;
        width: auto;
        flex: 1;
        margin: -0.5rem;
        height: calc(100vh - 4rem);
        min-height: 400px;
        overflow: hidden;
    }

    .geomap-leaflet {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .leaflet-container {
        height: 100% !important;
        width: 100% !important;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .leaflet-control {
        z-index: 1001 !important;
    }
    .leaflet-popup {
        z-index: 1003 !important;
    }
    .leaflet-tooltip {
        z-index: 1003 !important;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .leaflet-popup-content {
        margin: 14px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* Loading placeholder */
    .geomap-loading {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        z-index: 0;
    }

    .geomap-loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1004;
    }

    /* Floating left column: stats + legend */
    .geomap-left-column {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
        pointer-events: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Floating stats pills */
    .geomap-stats {
        pointer-events: none;
    }
    .geomap-stats-inner {
        backdrop-filter: blur(12px);
        background: rgba(255,255,255,0.9);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        pointer-events: auto;
    }

    /* Floating legend panel (below stats) */
    .geomap-legend {
        pointer-events: none;
    }

    /* Legend card styling */
    .simple-legend-card {
        width: 180px;
        backdrop-filter: blur(12px);
        background: rgba(255,255,255,0.95);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
        border: 1px solid #e2e8f0;
        pointer-events: auto;
    }

    /* Error */
    .geomap-error {
        position: absolute;
        top: 4rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 60;
    }
    .geomap-error-inner {
        backdrop-filter: blur(12px);
        background: rgba(254,242,242,0.95);
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }


    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 0.8s linear infinite;
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* View Changers column (top-right) */
    .geomap-view-changers {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .geomap-view-changers .layer-toggle-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        color: #64748b;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
        font-family: 'Inter', system-ui, sans-serif;
        white-space: nowrap;
        width: 100%;
        justify-content: flex-start;
    }

    .geomap-view-changers .layer-toggle-btn:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        border-color: #cbd5e1;
    }

    .geomap-view-changers .layer-toggle-btn.active {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    }

    .geomap-view-changers .layer-toggle-btn i {
        font-size: 12px;
    }

    /* Filter Controls */
    .geomap-filter-controls {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        z-index: 1000;
    }

    .filter-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        color: #475569;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-toggle-btn:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .filter-panel {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(12px);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 12px;
        width: 240px;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        z-index: 1005;
    }

    .filter-section {
        margin-bottom: 12px;
    }
    .filter-section:last-of-type {
        margin-bottom: 0;
    }

    .filter-label {
        display: block;
        font-size: 10px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .filter-select {
        width: 100%;
        padding: 5px 8px;
        font-size: 11px;
        font-weight: 500;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-select:hover {
        border-color: #cbd5e1;
    }
    .filter-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
    }

    .filter-date-range {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-date-field {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .filter-date-label {
        font-size: 9px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .filter-date-input {
        padding: 4px 6px;
        font-size: 10px;
        font-weight: 500;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-date-input:hover {
        border-color: #cbd5e1;
    }
    .filter-date-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
    }

    .filter-actions {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }

    .filter-clear-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 500;
        color: #dc2626;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'Inter', system-ui, sans-serif;
    }
    .filter-clear-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
    }

    /* Simple Legend */
    .simple-legend {
    }

    .simple-legend-title {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 8px;
    }

    .simple-legend-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .simple-legend-item {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .simple-legend-item.severity-active {
        background: #e0e7ff;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .simple-legend-item:hover {
        background: #f8fafc;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .simple-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        flex-shrink: 0;
        box-shadow: inset 0 -1px 2px rgba(0,0,0,0.15);
    }

    .simple-legend-text {
        font-size: 12px;
        font-weight: 500;
        color: #475569;
    }

    @media (max-width: 768px) {
        .leaflet-control-zoom {
            display: none;
        }
        .geomap-wrapper {
            height: calc(100vh - 9rem);
            margin: -1.5rem;
        }
        .geomap-left-column {
            top: 0.5rem;
            left: 0.5rem;
        }
        .geomap-view-changers {
            top: 0.5rem;
            right: 0.5rem;
        }
        .geomap-filter-controls {
            top: calc(100% + 8px);
            right: 0;
        }
        .filter-panel {
            width: 180px;
            padding: 10px;
        }
        .filter-toggle-btn {
            padding: 5px 10px;
            font-size: 10px;
        }
        .filter-toggle-btn span {
            display: none;
        }
    }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var filters = { year: {{ $selectedYear }}, month: null, week: null, severity: null };
    var currentLayer = 'rabies'; // 'rabies' or 'vaccination'
    var map, barangayLayer, outsideMaskLayer, cityBounds, geojsonData;

    // --- Initialize Map ---
    map = L.map('geomap', {
        zoomControl: false, // Disable default zoom control
        minZoom: 12,
        maxZoom: 18,
        zoomSnap: 0.5,
        worldCopyJump: false
    }).setView([14.3270, 120.9370], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(map);

    // --- Zoom Control (bottom-right) ---
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Hide the loading placeholder
    var loadingEl = document.querySelector('.geomap-loading');
    if (loadingEl) loadingEl.style.display = 'none';

    // Ensure map fills its container after init
    setTimeout(function() {
        map.invalidateSize();
    }, 150);

    // --- Color helpers ---
    function getColor(cases) {
        if (currentLayer === 'vaccination') {
            // Green gradient for vaccination coverage
            return cases > 20 ? '#166534'
                 : cases > 10 ? '#15803d'
                 : cases > 5  ? '#22c55e'
                 : cases > 0  ? '#86efac'
                              : '#cbd5e1';
        } else {
            // Red/Orange/Yellow gradient for rabies cases
            return cases > 20 ? '#dc2626'
                 : cases > 10 ? '#ea580c'
                 : cases > 5  ? '#eab308'
                 : cases > 0  ? '#fde68a'
                              : '#cbd5e1';
        }
    }
    
    function getBorderColor(cases) {
        return cases > 0 ? '#1e293b' : '#94a3b8';
    }

    function style(feature) {
        var c = feature.properties.cases || 0;
        return {
            fillColor: getColor(c),
            weight: c > 0 ? 2.5 : 1.5,
            color: getBorderColor(c),
            fillOpacity: c > 0 ? 0.8 : 0.45,
            opacity: 1
        };
    }

    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({ weight: 4, color: '#4338ca', fillOpacity: 0.55 });
        layer.bringToFront();
    }

    function resetHighlight(e) {
        var c = e.target.feature.properties.cases || 0;
        e.target.setStyle({
            weight: c > 0 ? 2.5 : 1.5,
            color: getBorderColor(c),
            fillOpacity: c > 0 ? 0.8 : 0.45
        });
    }

    function onEachFeature(feature, layer) {
        var name = feature.properties.name || 'Unknown';
        var cases = feature.properties.cases || 0;
        var status, label;
        
        if (currentLayer === 'vaccination') {
            if (cases > 20) { status = 'High Coverage'; label = 'Excellent'; }
            else if (cases > 10) { status = 'Moderate Coverage'; label = 'Good'; }
            else if (cases > 5) { status = 'Low Coverage'; label = 'Fair'; }
            else if (cases > 0) { status = 'Minimal'; label = 'Low'; }
            else { status = 'No Data'; label = 'None'; }
        } else {
            if (cases > 20) { status = 'Critical'; label = 'Critical'; }
            else if (cases > 10) { status = 'High'; label = 'High'; }
            else if (cases > 5) { status = 'Moderate'; label = 'Moderate'; }
            else if (cases > 0) { status = 'Low'; label = 'Low'; }
            else { status = 'No Cases'; label = 'None'; }
        }

        layer.bindTooltip(
            '<div style="font-family:Inter,system-ui;min-width:110px;">' +
            '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;">' + name + '</div>' +
            '<div style="font-size:20px;font-weight:700;color:' + getColor(cases) + ';">' + cases + '</div>' +
            '<div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:1px;">' + status + '</div>' +
            '</div>',
            { direction: 'center', className: '', offset: [0, 0], pane: 'popupPane' }
        );
        layer.on({ mouseover: highlightFeature, mouseout: resetHighlight });
    }

    // --- Outside city mask ---
    function createOutsideMask(bounds) {
        var s = bounds.getSouth(), n = bounds.getNorth(),
            e = bounds.getEast(), w = bounds.getWest();
        return L.polygon([
            [[s-10, w-10], [s-10, e+10], [n+10, e+10], [n+10, w-10], [s-10, w-10]],
            [[s, e], [n, e], [n, w], [s, w], [s, e]]
        ], {
            fillColor: '#f1f5f9',
            fillOpacity: 0.7,
            color: 'transparent',
            weight: 0
        });
    }

    // --- Boundary ---
    fetch('/geojson/dasmarinas-city-boundary.geojson')
        .then(function(r) { return r.json(); })
        .then(function(boundary) {
            var polys = {
                type: 'FeatureCollection',
                features: boundary.features.filter(function(f) {
                    return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon';
                })
            };
            L.geoJSON(polys, {
                fillColor: 'transparent', color: '#334155', weight: 2.5, opacity: 1
            }).addTo(map);

            cityBounds = L.geoJSON(polys).getBounds();
            outsideMaskLayer = createOutsideMask(cityBounds).addTo(map);
            map.setMaxBounds(cityBounds);
            map.fitBounds(cityBounds);
            map.on('drag', function() {
                map.panInsideBounds(cityBounds, { animate: false });
            });
        });

    // --- Barangay GeoJSON + Case Data ---
    function normalizeBarangayName(name) {
        var n = name.toLowerCase()
            .replace(/\s+/g, '')
            .replace(/\(.*\)/, '');
        n = n.replace(/iii$/, '3');
        n = n.replace(/ii$/, '2');
        n = n.replace(/iv$/, '4');
        n = n.replace(/v$/, '5');
        n = n.replace(/i$/, '1');
        return n;
    }

    fetch('/geojson/barangays/dasmarinas-barangays.geojson')
        .then(function(r) { return r.json(); })
        .then(function(geojson) {
            geojsonData = geojson;
            fetchFilteredData();
        })
        .catch(function(err) {
            console.error('GeoJSON Error:', err);
            document.getElementById('mapError').classList.remove('hidden');
        });

    // --- Layer Switching ---
    window.switchLayer = function(layerType) {
        currentLayer = layerType;
        
        // Update button states
        document.getElementById('btnRabiesLayer').classList.toggle('active', layerType === 'rabies');
        document.getElementById('btnVaccinationLayer').classList.toggle('active', layerType === 'vaccination');
        
        // Update legend
        updateLegend();
        
        // Update stats labels
        updateStatsLabels();
        
        // Fetch new data for the selected layer
        fetchFilteredData();
    };

    function updateLegend() {
        var legendItems = document.querySelectorAll('.simple-legend-item');
        if (currentLayer === 'vaccination') {
            // Vaccination legend (green gradient)
            legendItems[0].querySelector('.simple-legend-dot').style.background = '#166534';
            legendItems[0].querySelector('.simple-legend-text').textContent = 'Excellent (20+)';
            legendItems[1].querySelector('.simple-legend-dot').style.background = '#15803d';
            legendItems[1].querySelector('.simple-legend-text').textContent = 'Good (11-19)';
            legendItems[2].querySelector('.simple-legend-dot').style.background = '#22c55e';
            legendItems[2].querySelector('.simple-legend-text').textContent = 'Fair (6-10)';
            legendItems[3].querySelector('.simple-legend-dot').style.background = '#86efac';
            legendItems[3].querySelector('.simple-legend-text').textContent = 'Low (1-5)';
            legendItems[4].querySelector('.simple-legend-dot').style.background = '#cbd5e1';
            legendItems[4].querySelector('.simple-legend-text').textContent = 'No Vaccinations';
        } else {
            // Rabies cases legend (red/orange/yellow gradient)
            legendItems[0].querySelector('.simple-legend-dot').style.background = '#dc2626';
            legendItems[0].querySelector('.simple-legend-text').textContent = 'Critical (20+)';
            legendItems[1].querySelector('.simple-legend-dot').style.background = '#ea580c';
            legendItems[1].querySelector('.simple-legend-text').textContent = 'High (11-19)';
            legendItems[2].querySelector('.simple-legend-dot').style.background = '#eab308';
            legendItems[2].querySelector('.simple-legend-text').textContent = 'Moderate (6-10)';
            legendItems[3].querySelector('.simple-legend-dot').style.background = '#fde68a';
            legendItems[3].querySelector('.simple-legend-text').textContent = 'Low (1-5)';
            legendItems[4].querySelector('.simple-legend-dot').style.background = '#cbd5e1';
            legendItems[4].querySelector('.simple-legend-text').textContent = 'No Cases';
        }
    }

    function updateStatsLabels() {
        var totalLabel = document.getElementById('statTotalLabel');
        var totalIcon = document.getElementById('statTotalIcon');
        var affectedLabel = document.getElementById('statAffectedLabel');
        var affectedIcon = document.getElementById('statAffectedIcon');
        var criticalLabel = document.getElementById('statCriticalLabel');
        var criticalIcon = document.getElementById('statCriticalIcon');

        if (currentLayer === 'vaccination') {
            totalLabel.textContent = 'Total Vaccinations';
            totalIcon.className = 'w-2 h-2 rounded-full bg-green-600';
            affectedLabel.textContent = 'Coverage Areas';
            affectedIcon.className = 'w-2 h-2 rounded-full bg-emerald-500';
            criticalLabel.textContent = 'High Coverage';
            criticalIcon.className = 'w-2 h-2 rounded-full bg-emerald-700';
        } else {
            totalLabel.textContent = 'Total Cases';
            totalIcon.className = 'w-2 h-2 rounded-full bg-red-500';
            affectedLabel.textContent = 'Affected';
            affectedIcon.className = 'w-2 h-2 rounded-full bg-amber-500';
            criticalLabel.textContent = 'Critical';
            criticalIcon.className = 'w-2 h-2 rounded-full bg-rose-500';
        }
    }

    // Filter functionality
    window.setFilter = function(type, value) {
        filters[type] = value;
        fetchFilteredData();
    };

    // Severity filter functionality (clickable legend items)
    window.setSeverityFilter = function(severity) {
        if (filters.severity === severity) {
            filters.severity = null; // toggle off if same
        } else {
            filters.severity = severity;
        }
        updateSeverityLegendUI();
        fetchFilteredData();
    };

    function updateSeverityLegendUI() {
        document.querySelectorAll('.simple-legend-item').forEach(function(item) {
            item.classList.remove('severity-active');
        });
        if (filters.severity) {
            var activeItem = document.querySelector('.simple-legend-item[onclick*="' + filters.severity + '"]');
            if (activeItem) activeItem.classList.add('severity-active');
        }
    }

    // Date picker handlers
    document.getElementById('filterDateFrom')?.addEventListener('change', function() {
        filters.date_from = this.value || null;
        fetchFilteredData();
    });

    document.getElementById('filterDateTo')?.addEventListener('change', function() {
        filters.date_to = this.value || null;
        fetchFilteredData();
    });

    // Clear filter functionality
    document.getElementById('clearFilterBtn')?.addEventListener('click', function() {
        // Reset filters to default values
        filters.month = null;
        filters.week = null;
        filters.severity = null;
        filters.date_from = null;
        filters.date_to = null;

        // Reset dropdowns to default
        document.getElementById('filterMonth').value = '';
        document.getElementById('filterWeek').value = '';
        document.getElementById('filterDateFrom').value = '';
        document.getElementById('filterDateTo').value = '';

        // Refresh map with unfiltered data
        fetchFilteredData();
    });

    function fetchFilteredData() {
        var params = new URLSearchParams();
        params.append('year', filters.year);
        params.append('type', currentLayer); // Add layer type parameter
        if (filters.month) params.append('month', filters.month);
        if (filters.week) params.append('week', filters.week);
        if (filters.date_from) params.append('date_from', filters.date_from);
        if (filters.date_to) params.append('date_to', filters.date_to);
        if (filters.severity) params.append('severity', filters.severity);

        var baseUrl = window.location.pathname.replace(/\/$/, '');
        fetch(baseUrl + '/data?' + params.toString())
            .then(function(r) { return r.json(); })
            .then(function(data) {
                updateMap(data.heatmapData);
                updateStats(data);
            })
            .catch(function(err) {
                console.error('Data Error:', err);
                document.getElementById('mapError').classList.remove('hidden');
            });
    }

    function updateMap(heatmapData) {
        var caseData = {};
        heatmapData.forEach(function(item) {
            caseData[normalizeBarangayName(item.name)] = item.count;
        });

        if (!geojsonData || !geojsonData.features) return;

        var copy = JSON.parse(JSON.stringify(geojsonData));
        copy.features.forEach(function(f) {
            var name = normalizeBarangayName(f.properties.name || '');
            f.properties.cases = caseData[name] || 0;
        });

        var polygons = {
            type: 'FeatureCollection',
            features: copy.features.filter(function(f) {
                return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon';
            })
        };

        if (barangayLayer) map.removeLayer(barangayLayer);
        barangayLayer = L.geoJSON(polygons, {
            style: style,
            onEachFeature: onEachFeature,
            pointToLayer: function() { return null; }
        }).addTo(map);
        barangayLayer.bringToFront();

        map.eachLayer(function(l) {
            if (l instanceof L.TileLayer) l.bringToBack();
        });
    }

    function updateStats(data) {
        var total = 0, affected = 0, highCount = 0;
        data.heatmapData.forEach(function(item) {
            total += item.count;
            if (item.count > 0) affected++;
            if (currentLayer === 'vaccination') {
                if (item.count > 10) highCount++; // High coverage areas
            } else {
                if (item.count > 20) highCount++; // Critical areas
            }
        });
        document.getElementById('statTotalCases').textContent = total;
        document.getElementById('statAffected').textContent = affected;
        document.getElementById('statCritical').textContent = highCount;
    }

    // --- Reset view button (bottom-right) ---
    var resetControl = L.control({ position: 'bottomright' });
    resetControl.onAdd = function() {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        div.innerHTML = '<a href="#" title="Reset view" style="display:flex;align-items:center;justify-content:center;width:30px;height:30px;font-size:16px;cursor:pointer;">⟲</a>';
        div.onclick = function(e) {
            e.preventDefault();
            if (cityBounds) map.fitBounds(cityBounds);
            else map.setView([14.3270, 120.9370], 12);
        };
        return div;
    };
    resetControl.addTo(map);
});
</script>

<script>
function openNewReportModal() {
    const backdrop = document.getElementById('newReportModalBackdrop');
    const form = document.getElementById('newReportForm');

    // Reset form
    form.reset();

    // Auto-generate report number
    const year = new Date().getFullYear();
    document.getElementById('modalReportNumber').value = 'BR-' + year + '-00000';

    // Set default incident date to today
    document.getElementById('modalIncidentDate').valueAsDate = new Date();

    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
    }, 10);
}

function closeNewReportModal() {
    const backdrop = document.getElementById('newReportModalBackdrop');
    backdrop.classList.add('opacity-0');
    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 200);
}

function submitNewReport(e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    const data = {};
    formData.forEach((value, key) => {
        if (value !== '') data[key] = value;
    });

    // Ensure CSRF token is included (Laravel expects X-XSRF-TOKEN or X-CSRF-TOKEN)
    const token = document.querySelector('meta[name="csrf-token"]');
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };
    if (token) {
        headers['X-CSRF-TOKEN'] = token.getAttribute('content');
    }

    fetch('{{ route('city-vet.rabies-geomap.store') }}', {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            closeNewReportModal();
            // Refresh page so the new case appears on the map
            setTimeout(() => location.reload(), 300);
        } else {
            alert(result.message || 'Failed to submit report.');
        }
    })
    .catch(error => {
        console.error('Error submitting report:', error);
        alert('Failed to submit report. Please try again.');
    });
}

// Top Barangays Modal JS
let topBarangaysCurrentType = 'rabies';
let topBarangaysCurrentLimit = 5;
let topBarangaysCurrentFilters = {};

function openTopBarangaysModal() {
    const backdrop = document.getElementById('topBarangaysModalBackdrop');
    const list = document.getElementById('topBarangaysList');
    const empty = document.getElementById('topBarangaysEmpty');
    const loading = document.getElementById('topBarangaysLoading');

    list.innerHTML = '';
    list.classList.add('hidden');
    empty.classList.add('hidden');
    loading.classList.remove('hidden');

    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
    }, 10);

    loadTopBarangays();
}

function closeTopBarangaysModal() {
    const backdrop = document.getElementById('topBarangaysModalBackdrop');
    backdrop.classList.add('opacity-0');
    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 200);
}

function setTopBarangaysType(type) {
    topBarangaysCurrentType = type;
    document.getElementById('topBarangaysTypeRabies').classList.toggle('text-indigo-600', type === 'rabies');
    document.getElementById('topBarangaysTypeRabies').classList.toggle('bg-white', type === 'rabies');
    document.getElementById('topBarangaysTypeRabies').classList.toggle('shadow-sm', type === 'rabies');
    document.getElementById('topBarangaysTypeRabies').classList.toggle('text-slate-600', type !== 'rabies');
    document.getElementById('topBarangaysTypeRabies').classList.toggle('hover:text-slate-700', type !== 'rabies');

    document.getElementById('topBarangaysTypeVaccination').classList.toggle('text-indigo-600', type === 'vaccination');
    document.getElementById('topBarangaysTypeVaccination').classList.toggle('bg-white', type === 'vaccination');
    document.getElementById('topBarangaysTypeVaccination').classList.toggle('shadow-sm', type === 'vaccination');
    document.getElementById('topBarangaysTypeVaccination').classList.toggle('text-slate-600', type !== 'vaccination');
    document.getElementById('topBarangaysTypeVaccination').classList.toggle('hover:text-slate-700', type !== 'vaccination');

    document.getElementById('topBarangaysModalSubtitle').textContent = type === 'rabies' ? 'Confirmed Rabies Cases' : 'Vaccination Coverage';

    loadTopBarangays();
}

function setTopBarangaysLimit(limit) {
    topBarangaysCurrentLimit = limit;
    document.getElementById('topBarangaysLimit5').classList.toggle('text-indigo-600', limit === 5);
    document.getElementById('topBarangaysLimit5').classList.toggle('bg-white', limit === 5);
    document.getElementById('topBarangaysLimit5').classList.toggle('shadow-sm', limit === 5);
    document.getElementById('topBarangaysLimit5').classList.toggle('text-slate-600', limit !== 5);
    document.getElementById('topBarangaysLimit5').classList.toggle('hover:text-slate-700', limit !== 5);

    document.getElementById('topBarangaysLimit10').classList.toggle('text-indigo-600', limit === 10);
    document.getElementById('topBarangaysLimit10').classList.toggle('bg-white', limit === 10);
    document.getElementById('topBarangaysLimit10').classList.toggle('shadow-sm', limit === 10);
    document.getElementById('topBarangaysLimit10').classList.toggle('text-slate-600', limit !== 10);
    document.getElementById('topBarangaysLimit10').classList.toggle('hover:text-slate-700', limit !== 10);

    loadTopBarangays();
}

function getSeverityChip(count, type) {
    let severity, color, bgColor;
    if (type === 'vaccination') {
        if (count > 20) { severity = 'Excellent'; color = '#166534'; bgColor = '#dcfce7'; }
        else if (count > 10) { severity = 'Good'; color = '#15803d'; bgColor = '#bbf7d0'; }
        else if (count > 5) { severity = 'Fair'; color = '#22c55e'; bgColor = '#86efac'; }
        else if (count > 0) { severity = 'Low'; color = '#86efac'; bgColor = '#d1fae5'; }
        else { severity = 'None'; color = '#94a3b8'; bgColor = '#f1f5f9'; }
    } else {
        if (count > 20) { severity = 'Critical'; color = '#dc2626'; bgColor = '#fee2e2'; }
        else if (count > 10) { severity = 'High'; color = '#ea580c'; bgColor = '#fed7aa'; }
        else if (count > 5) { severity = 'Moderate'; color = '#eab308'; bgColor = '#fef3c7'; }
        else if (count > 0) { severity = 'Low'; color = '#fde68a'; bgColor = '#fef9c3'; }
        else { severity = 'No Cases'; color = '#94a3b8'; bgColor = '#f1f5f9'; }
    }
    return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium border" style="background:${bgColor};color:${color};border-color:${color}">${severity}</span>`;
}

function loadTopBarangays() {
    const params = new URLSearchParams();
    params.append('year', document.getElementById('filterYear')?.value || new Date().getFullYear());
    params.append('month', document.getElementById('filterMonth')?.value || '');
    params.append('week', document.getElementById('filterWeek')?.value || '');
    params.append('date_from', document.getElementById('filterDateFrom')?.value || '');
    params.append('date_to', document.getElementById('filterDateTo')?.value || '');
    params.append('type', topBarangaysCurrentType);
    params.append('limit', topBarangaysCurrentLimit);

    const token = document.querySelector('meta[name="csrf-token"]');
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };
    if (token) {
        headers['X-CSRF-TOKEN'] = token.getAttribute('content');
    }

    fetch('{{ route('city-vet.rabies-geomap.top-barangays') }}?' + params.toString(), {
        headers: headers,
    })
    .then(response => response.json())
    .then(data => {
        renderTopBarangays(data);
    })
    .catch(error => {
        console.error('Error loading top barangays:', error);
        document.getElementById('topBarangaysLoading').classList.add('hidden');
        document.getElementById('topBarangaysEmpty').classList.remove('hidden');
    });
}

function renderTopBarangays(data) {
    const loading = document.getElementById('topBarangaysLoading');
    const list = document.getElementById('topBarangaysList');
    const empty = document.getElementById('topBarangaysEmpty');

    loading.classList.add('hidden');

    if (!data || data.length === 0) {
        list.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
    }

    // Build filter label for footer
    const year = document.getElementById('filterYear')?.value || new Date().getFullYear();
    const monthEl = document.getElementById('filterMonth');
    const weekEl = document.getElementById('filterWeek');
    const fromEl = document.getElementById('filterDateFrom');
    const toEl = document.getElementById('filterDateTo');

    let filterLabel = year;
    if (fromEl?.value && toEl?.value) filterLabel = fromEl.value + ' to ' + toEl.value;
    else if (monthEl?.value && weekEl?.value) filterLabel = 'Week ' + weekEl.value + ', Month ' + monthEl.value + ', ' + year;
    else if (monthEl?.value) filterLabel = 'Month ' + monthEl.value + ', ' + year;
    else if (weekEl?.value) filterLabel = 'Week ' + weekEl.value + ', ' + year;
    document.getElementById('topBarangaysFilterLabel').textContent = filterLabel;

    list.innerHTML = '';
    data.forEach((item, index) => {
        const rank = index + 1;
        const rankColor = rank === 1 ? '#dc2626' : rank === 2 ? '#ea580c' : rank === 3 ? '#eab308' : '#64748b';
        const chip = getSeverityChip(item.count, topBarangaysCurrentType);
        const lat = item.latitude;
        const lng = item.longitude;
        const hasCoords = lat && lng;

        const row = document.createElement('div');
        row.className = 'flex items-center gap-3 px-3 py-2.5 border border-slate-200 rounded-xl bg-white hover:bg-indigo-50 hover:border-indigo-200 transition-colors cursor-pointer';
        row.onclick = () => {
            closeTopBarangaysModal();
        };

        row.innerHTML = `
            <div class="flex items-center justify-center w-6">
                <span class="text-xs font-bold" style="color:${rankColor}">#${rank}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800 truncate" title="${item.barangay_name}">${item.barangay_name}</p>
                <p class="text-[10px] text-slate-500 truncate">Barangay ID: ${item.barangay_id}</p>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800">${item.count}</p>
                <p class="text-[10px] text-slate-400">${topBarangaysCurrentType === 'vaccination' ? 'doses' : 'cases'}</p>
            </div>
            <div class="flex items-center gap-2 hidden sm:block">
                ${chip}
            </div>
            <div class="w-8 flex items-center justify-end text-[10px] text-slate-400">
                ${hasCoords ? '<i class="bi bi-geo-alt"></i>' : '<i class="bi bi-slash-circle opacity-30"></i>'}
            </div>
        `;
        list.appendChild(row);
    });

    list.classList.remove('hidden');
    empty.classList.add('hidden');

    if (topBarangaysCurrentLimit === 10) {
        setTimeout(() => {
            const list = document.getElementById('topBarangaysList');
            if (list) {
                list.scrollTo({ top: list.scrollHeight, behavior: 'smooth' });
            }
        }, 50);
    }
}

function highlightTopBarangayOnMap(lat, lng) {
    if (!window.map || !lat || !lng) return;
    window.map.setView([lat, lng], 15);
    window.map.invalidateSize();
}
</script>
@endpush