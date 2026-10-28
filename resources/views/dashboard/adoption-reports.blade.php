@extends('layouts.admin')

@section('title', 'Adoption Reports Management')
@section('header', 'Adoption Reports Management')
@section('subheader', 'View and manage all adoption applications')

@php
$routePrefix = request()->routeIs('city-vet.*') ? 'city-vet' : (request()->routeIs('super-admin.*') ? 'super-admin' : 'admin');
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Applications</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['pending_review'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Approved</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['approved'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Adopted</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['adopted'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Rejected</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Adoption Applications</h3>
                <p class="text-sm text-gray-500">Search and filter adoption applications</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="adoptionSearchInput" value="{{ request('search') }}" placeholder="Search applicant, pet, breed, status..."
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
            <button type="button" id="clearAdoptionFiltersBtn" onclick="clearAdoptionFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="reportsTableContainer">
            @include('dashboard.partials.adoption-reports-table')
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
                <i class="bi bi-search text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Reports Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Report Details Modal -->
<div id="reportDetailsModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-lg">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight">Adoption Application Details</h5>
                        <span id="reportModalNumber" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold text-indigo-700 bg-indigo-100 border border-indigo-200 whitespace-nowrap">#AD-00000</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-none" id="reportModalSubmitted">Submitted at: --</p>
                </div>
            </div>
            <button onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
            <div id="reportDetailsModalContent">
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
            <button onclick="closeReportModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors">
                Done
            </button>
        </div>
    </div>
</div>

<script>
let searchDebounce;
const adoptionFilterUrl = `{{ route($routePrefix . '.adoption-reports.filter') }}`;

function getAdoptionFilterParams() {
    return {
        search: document.getElementById('adoptionSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyAdoptionFilters() {
    const params = getAdoptionFilterParams();
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

    fetch(`${adoptionFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering adoption reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearAdoptionFilters() {
    document.getElementById('adoptionSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearAdoptionFiltersVisibility();
    applyAdoptionFilters();
}

function updateClearAdoptionFiltersVisibility() {
    const searchInput = document.getElementById('adoptionSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearAdoptionFiltersBtn');

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

document.getElementById('adoptionSearchInput').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearAdoptionFiltersVisibility();
        applyAdoptionFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearAdoptionFiltersVisibility();
    applyAdoptionFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearAdoptionFiltersVisibility();
    applyAdoptionFilters();
});

document.getElementById('reportsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${adoptionFilterUrl}?${query}`, {
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
        console.error('Error loading reports page:', error);
    });
});

function openReportModal(reportId) {
    const backdrop = document.getElementById('reportDetailsModalBackdrop');
    const content = document.getElementById('reportDetailsModalContent');

    content.innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
            <p class="text-slate-500 text-sm">Loading report details...</p>
        </div>
    `;
    document.getElementById('reportModalNumber').textContent = '';
    document.getElementById('reportModalSubmitted').textContent = 'Submitted at: --';
    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
    }, 10);

    fetch(`{{ route($routePrefix . '.adoption-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayReportDetails(data.report);
            } else {
                content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
            }
        })
        .catch(() => {
            content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
        });
}

function closeReportModal() {
    const backdrop = document.getElementById('reportDetailsModalBackdrop');
    backdrop.classList.add('opacity-0');
    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 200);
}

function displayReportDetails(report) {
    const content = document.getElementById('reportDetailsModalContent');
    const numberEl = document.getElementById('reportModalNumber');
    if (numberEl) numberEl.textContent = report.report_number;

    const submittedEl = document.getElementById('reportModalSubmitted');
    if (submittedEl) submittedEl.textContent = 'Submitted at: ' + (report.created_at ? report.created_at : '--');

    const statusClass = report.status === 'pending_review' ? 'bg-yellow-100 text-yellow-800' :
        report.status === 'approved' ? 'bg-blue-100 text-blue-800' :
        report.status === 'adopted' ? 'bg-emerald-100 text-emerald-800' :
        report.status === 'rejected' ? 'bg-red-100 text-red-800' :
        'bg-gray-100 text-gray-800';

    const statusText = report.status
        .replace(/_/g, ' ')
        .replace(/\b\w/g, c => c.toUpperCase());

    const homePhotos = Array.isArray(report.home_photos) ? report.home_photos : [];
    const validIdPath = report.valid_id_path || '';
    const validIdExt = validIdPath ? validIdPath.split('.').pop().toLowerCase() : '';
    const validIdIsImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(validIdExt);

    const homePhotosHtml = homePhotos.length > 0 ? `
        <div class="grid grid-cols-3 gap-2 mt-2">
            ${homePhotos.map(path => `
                <a href="${window.location.origin}/storage/${path}" target="_blank" class="block">
                    <img src="${window.location.origin}/storage/${path}" alt="Home photo" class="w-full h-24 object-cover rounded border border-indigo-200 hover:opacity-90 transition">
                </a>
            `).join('')}
        </div>
    ` : '<p class="text-xs text-slate-500 mt-1">No home photos uploaded.</p>';

    const validIdHtml = validIdPath ? `
        <div class="mt-2">
            ${validIdIsImage ? `
                <a href="${window.location.origin}/storage/${validIdPath}" target="_blank">
                    <img src="${window.location.origin}/storage/${validIdPath}" alt="Valid ID" class="w-full h-28 object-cover rounded border border-indigo-200 hover:opacity-90 transition">
                </a>
            ` : `
                <a href="${window.location.origin}/storage/${validIdPath}" target="_blank" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:underline">
                    <i class="fas fa-file-alt"></i> View document
                </a>
            `}
        </div>
    ` : '<p class="text-xs text-slate-500 mt-1">No valid ID uploaded.</p>';

    content.innerHTML = `
        <div class="p-3 space-y-4">
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-indigo-600 px-4 py-2.5 flex items-center gap-2 border-b border-indigo-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Applicant Information</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Name</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.applicant_name}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 011 1.726D7.848 9.648 5 11.618 5 13.25v2.5a1 1 0 01-1 1v3.5a1 1 0 001 1H6a1 1 0 011-1v-2.5a2 2 0 002-2h4a2 2 0 002 2v2.5a1 1 0 001 1V19a1 1 0 01-1-1h-2.318c.173.448.285.952.285 1.5v2.5a1 1 0 001 1h4a1 1 0 001-1v-3.5a1 1 0 01-1-1V13.25c0-.592-.235-1.156-.598-1.608L13 11.618C12.686 9.421 13 7.786 13 6h1.72c.553.229.894.762.997 1.336l.164 1.09c.043.286.07.576.078.866.006.21-.009.422-.048.629l-.075.412c-.045.242-.089.484-.147.721L12 18c-.184.72-.574 1.344-1.05 1.772a1 1 0 01-1.5.318L8 18.707A7 7 0 015 13c0-1.45.39-2.82 1.094-3.978l1.01-.999A1 1 0 017 9h4a1 1 0 011 1 .993.993 0 01-.293.707L11 11.414V13a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1.586z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Email</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 break-all">${report.applicant_email}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21v-1a2 2 0 00-2-2v-3a2 2 0 012-2h6a2 2 0 012 2v3a2 2 0 00-2 2v1z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Contact</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.applicant_contact}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Occupation</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.occupation}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 col-span-2">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Address</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.address ? report.address.replace(/,/g, '<br>') : ''}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Marital Status</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.marital_status}</p>
                                </div>
                            </div>
                            ${report.company !== 'N/A' ? `
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Company</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.company}</p>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-amber-600 px-4 py-2.5 flex items-center gap-2 border-b border-amber-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Pet Information</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg shrink-0 border border-amber-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4l2 2m0 0l-2 2m-2 2l-2-2m2 2l2 2m0 0l-2 2m-2 2l2 2m0 0l2-2m-2-2l-2-2m-2 2l-2 2m0 0l2 2m0 0l-2-2m-2 2l-2-2m2 2l2-2m0 0l-2 2m-2 2l2-2m0 0l2-2m0 0l-2 2m-2 2l-2-2m2 2l2-2" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Name</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_name}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg shrink-0 border border-amber-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Species</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_species}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg shrink-0 border border-amber-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Breed</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_breed}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg shrink-0 border border-amber-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Gender</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.pet_gender}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-blue-600 px-4 py-2.5 flex items-center gap-2 border-b border-blue-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Application Details</h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Housing Type</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.home_type}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 00-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h2a2 2 0 012 2v7a4 4 0 004 4v0a4 4 0 004-4m0 0v3.01" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Has Other Pets</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.has_other_pets}</p>
                            </div>
                        </div>
                        ${report.other_pets_details && report.other_pets_details !== 'N/A' ? `
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-slate-400">Pet Experience</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.other_pets_details}</p>
                            </div>
                        </div>
                        ` : ''}
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Appointment Date</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.adoption_date}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M3 17.364l.707-.707M13 17.364l.707-.707M17 12h-.707m0 0l-.707-.707M17 7l-.707-.707M13 7l.707.707M13 17l-.707.707" /></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Appointment Time</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.appointment_time}</p>
                            </div>
                        </div>
                        ${report.notes && report.notes !== 'N/A' ? `
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg shrink-0 border border-blue-100">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-slate-400">Notes</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.notes}</p>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-green-600 px-4 py-2.5 flex items-center gap-2 border-b border-green-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Valid ID</h3>
                </div>
                <div class="p-3">
                    ${validIdHtml}
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                <div class="bg-amber-600 px-4 py-2.5 flex items-center gap-2 border-b border-amber-500/50">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Home Photos</h3>
                </div>
                <div class="p-3">
                    ${homePhotosHtml}
                </div>
            </div>
        </div>
    `;
}

updateClearAdoptionFiltersVisibility();
</script>
@endsection
