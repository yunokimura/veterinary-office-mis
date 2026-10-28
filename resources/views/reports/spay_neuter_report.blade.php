@extends('layouts.admin')

@section('title', 'Spay/Neuter (Kapon) Reports Management')
@section('header', 'Spay/Neuter (Kapon) Reports Management')
@section('subheader', 'View and manage all spay/neuter procedure reports')

@php
    $routePrefix = 'spay-neuter';
@endphp

@section('content')
<div class="space-y-6">
    <!-- KPI Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Reports</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalReports) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Vaccinations</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($completed) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($scheduled) }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Spay/Neuter Reports</h3>
                <p class="text-sm text-gray-500">Search and filter spay/neuter procedure reports</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="spayNeuterSearchInput" value="{{ request('search') }}" placeholder="Search reports, pet..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">From Date</label>
                    <input type="date" id="dateFrom" value="{{ request('date_from') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">To Date</label>
                    <input type="date" id="dateTo" value="{{ request('date_to') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
            </div>
            <button type="button" id="clearSpayNeuterFiltersBtn" onclick="clearSpayNeuterFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="reportsTableContainer">
            @include('reports.partials.spay-neuter-reports-table')
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="reportsPagination">
            {{ $reports->links() }}
        </div>
        <div id="reportsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="reportsEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-shield-check text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Reports Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Spay/Neuter Report Details Modal -->
<div id="spayNeuterDetailsModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight">Spay/Neuter Report Details</h5>
                        <span id="spayNeuterModalNumber" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-100 border border-emerald-200 whitespace-nowrap">#SN-00000</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-none" id="spayNeuterModalSubmitted">Submitted at: --</p>
                </div>
            </div>
            <button onclick="closeSpayNeuterModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
            <div id="spayNeuterDetailsModalContent">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading report details...</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
            <button onclick="window.print()" class="px-3 py-2 text-xs font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm3 4v1h-5v-1a2 2 0 002-2h0a2 2 0 00-2-2V7a2 2 0 002-2h0a2 2 0 002 2v1h-5v1a2 2 0 002-2h0a2 2 0 00-2-2H9a2 2 0 00-2 2v1H6a2 2 0 00-2 2v1a2 2 0 002 2h12a2 2 0 002-2v-1a2 2 0 00-2-2z" /></svg>
                <span>Print</span>
            </button>
            <button onclick="closeSpayNeuterModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors">
                Done
            </button>
        </div>
    </div>
</div>

<script>
let spayNeuterSearchDebounce;
const spayNeuterFilterUrl = `{{ route('spay-neuter.reports.filter') }}`;

function getSpayNeuterFilterParams() {
    return {
        search: document.getElementById('spayNeuterSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applySpayNeuterFilters() {
    const params = getSpayNeuterFilterParams();
    const tableContainer = document.getElementById('reportsTableContainer');
    const paginationContainer = document.getElementById('reportsPagination');
    const loadingEl = document.getElementById('reportsLoading');
    const emptyState = document.getElementById('reportsEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${spayNeuterFilterUrl}?${query.toString()}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (tableContainer) {
                tableContainer.innerHTML = data.html;
                tableContainer.style.opacity = '1';
            }
            if (paginationContainer) {
                paginationContainer.innerHTML = data.pagination;
                paginationContainer.style.opacity = '1';
            }
            if (emptyState) emptyState.style.display = data.has_results ? 'none' : 'block';
        }
    })
    .catch(error => {
        console.error('Error filtering spay/neuter reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearSpayNeuterFilters() {
    document.getElementById('spayNeuterSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearSpayNeuterFiltersVisibility();
    applySpayNeuterFilters();
}

function updateClearSpayNeuterFiltersVisibility() {
    const searchInput = document.getElementById('spayNeuterSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearSpayNeuterFiltersBtn');

    const hasFilters = (searchInput && searchInput.value.trim() !== '') ||
                       (dateFrom && dateFrom.value.trim() !== '') ||
                       (dateTo && dateTo.value.trim() !== '');

    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.getElementById('spayNeuterSearchInput').addEventListener('input', () => {
    clearTimeout(spayNeuterSearchDebounce);
    spayNeuterSearchDebounce = setTimeout(() => {
        updateClearSpayNeuterFiltersVisibility();
        applySpayNeuterFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearSpayNeuterFiltersVisibility();
    applySpayNeuterFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearSpayNeuterFiltersVisibility();
    applySpayNeuterFilters();
});

document.getElementById('reportsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${spayNeuterFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('reportsTableContainer').innerHTML = data.html;
            document.getElementById('reportsPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading spay/neuter reports page:', error);
    });
});

function openSpayNeuterModal(reportId) {
    const backdrop = document.getElementById('spayNeuterDetailsModalBackdrop');
    const content = document.getElementById('spayNeuterDetailsModalContent');

    content.innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
            <p class="text-slate-500 text-sm">Loading report details...</p>
        </div>
    `;
    document.getElementById('spayNeuterModalNumber').textContent = '';
    document.getElementById('spayNeuterModalSubmitted').textContent = 'Submitted at: --';
    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
    }, 10);

    fetch(`{{ route('spay-neuter.reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySpayNeuterDetails(data.report);
            } else {
                content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
            }
        })
        .catch(() => {
            content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
        });
}

function closeSpayNeuterModal() {
    const backdrop = document.getElementById('spayNeuterDetailsModalBackdrop');
    backdrop.classList.add('opacity-0');
    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 200);
}

function displaySpayNeuterDetails(report) {
    const content = document.getElementById('spayNeuterDetailsModalContent');
    const numberEl = document.getElementById('spayNeuterModalNumber');
    if (numberEl) numberEl.textContent = report.report_number;

    const submittedEl = document.getElementById('spayNeuterModalSubmitted');
    if (submittedEl) submittedEl.textContent = 'Submitted at: ' + (report.created_at ? report.created_at : '--');

    content.innerHTML = `
        <div class="p-3 space-y-4">
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-emerald-600 px-4 py-2.5 flex items-center gap-2 border-b border-emerald-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Spay/Neuter Details</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Procedure Date</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.scheduled_at}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M3 17.364l.707-.707M13 17.364l.707-.707M17 12h-.707m0 0l-.707-.707M17 7l-.707-.707M13 7l.707.707M13 17l-.707.707" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Weight</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.weight ? report.weight + ' kg' : 'N/A'}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Procedure Type</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.procedure_type}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 11.969A5 5 0 0110.474 8H12a5 5 0 014.9 5.969L12 18l-4.9-5.969zM12 14a1 1 0 100-2 1 1 0 000 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Status</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 capitalize">${report.status}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Veterinarian</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.veterinarian}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Remarks</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.remarks || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-yellow-600 px-4 py-2.5 flex items-center gap-2 border-b border-yellow-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2M11 15h2m0 0h2m0 0l2 2m-2-2v2h-2v-2m-2-2l-2-2m-2 2v2H7v-2m-2 2l-2-2M7 17a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2a2 2 0 012-2zm0-2v2a2 2 0 00-2 2H5a2 2 0 01-2-2v-2a2 2 0 012-2h2a2 2 0 002-2zM7 7v2l2 2m2-2l2-2m2 2l2 2m-2-2H7z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Pet Information</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4l2 2m0 0l-2 2m-2 2l-2-2m2 2l2 2m0 0l-2 2m-2 2l2 2m0 0l2-2m-2-2l-2-2m-2 2l-2 2m0 0l2 2m0 0l-2-2m-2 2l2-2m0 0l-2 2m-2 2l2-2m0 0l2-2m0 0l-2 2m-2 2l-2-2m2 2l2-2m0 0l-2 2m-2 2l-2-2m2 2l2-2" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Pet Name</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_name}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Species</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_species}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v4m0 2m-4 3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Breed</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_breed}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Age</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_age}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21v-1a2 2 0 00-2-2v-3a2 2 0 012-2h6a2 2 0 012 2v3a2 2 0 00-2 2v1z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Gender</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_gender}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-purple-600 px-4 py-2.5 flex items-center gap-2 border-b border-purple-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Owner Information</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Owner Name</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.patient_name}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 011 1.726D7.848 9.648 5 11.618 5 13.25v2.5a1 1 0 01-1 1v3.5a1 1 0 001 1H6a1 1 0 011-1v-2.5a2 2 0 002-2h4a2 2 0 002 2v2.5a1 1 0 001 1V19a1 1 0 01-1-1h-2.318c.173.448.285.952.285 1.5v2.5a1 1 0 001 1h4a1 1 0 001-1v-3.5a1 1 0 01-1-1V13.25c0-.592-.235-1.156-.598-1.608L13 11.618C12.686 9.421 13 7.786 13 6h1.72c.553.229.894.762.997 1.336l.164 1.09c.043.286.07.576.078.866.006.21-.009.422-.048.629l-.075.412c-.045.242-.089.484-.147.721L12 18c-.184.72-.574 1.344-1.05 1.772a1 1 0 01-1.5.318L8 18.707A7 7 0 015 13c0-1.45.39-2.82 1.094-3.978l1.01-.999A1 1 0 017 9h4a1 1 0 011 1 .993.993 0 01-.293.707L11 11.414V13a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1.586z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Contact</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.patient_contact}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 col-span-2">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-2.828-2.828a1.998 1.998 0 010-2.828l4.244-4.243a9 9 0 111.414 1.414z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Address</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.patient_address}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Barangay</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.barangay}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearSpayNeuterFiltersVisibility();
</script>
@endsection
