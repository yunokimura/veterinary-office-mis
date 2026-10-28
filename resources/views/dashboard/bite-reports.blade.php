@extends('layouts.admin')

@section('title', 'Confirmed Rabies Reports Management')
@section('header', 'Confirmed Rabies Reports Management')
@section('subheader', 'View and manage all confirmed rabies cases')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Confirmed Rabies Cases</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statTotal">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Dog Cases</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statDogCases">{{ $stats['dog_cases'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Cat Cases</p>
                <p class="text-2xl font-bold text-gray-800 mt-1" id="statCatCases">{{ $stats['cat_cases'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Confirmed Rabies Reports</h3>
                <p class="text-sm text-gray-500">Search and filter rabies bite reports</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="biteSearch" value="{{ request('search') }}"                  placeholder="Search reports, animal name, type..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <button type="button" id="searchHelpBtn"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                        data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus click"
                        data-bs-html="true"
                        data-bs-content="
                            <div class='text-sm text-gray-700 space-y-1'>
                                <div><strong>Examples:</strong></div>
                                <div>B1 <span class='text-gray-400'>(Report No.)</span></div>
                                <div>Dog <span class='text-gray-400'>(Animal Type)</span></div>
                                <div>Stray <span class='text-gray-400'>(Animal Status)</span></div>
                                <div>Poblacion <span class='text-gray-400'>(Barangay)</span></div>
                            </div>
                        ">
                    <i class="bi bi-info-circle"></i>
                </button>
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">From Date</label>
                    <input type="date" id="biteDateFrom" value="{{ request('date_from') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">To Date</label>
                    <input type="date" id="biteDateTo" value="{{ request('date_to') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
            </div>
            <button type="button" id="clearBiteFiltersBtn" onclick="clearBiteFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="reportsTableContainer">
            @include('dashboard.partials.bite-reports-table')
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
                <i class="bi bi-virus text-2xl text-gray-400"></i>
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
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-slate-100 text-slate-600 rounded-lg">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="font-bold text-slate-800 text-lg leading-tight">Report Details</h5>
                    <p class="text-xs text-slate-500 leading-none mt-0.5" id="reportModalNumber"></p>
                </div>
            </div>
            <button onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-6 space-y-5 overflow-y-auto bg-white max-h-[calc(90vh-140px)]">
            <div id="reportDetailsModalContent">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading report details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let searchDebounce;
const biteFilterUrl = '{{ route('admin.bite-reports.filter') }}';

function getBiteFilterParams() {
    return {
        search: document.getElementById('biteSearch').value,
        date_from: document.getElementById('biteDateFrom').value,
        date_to: document.getElementById('biteDateTo').value,
    };
}

function applyBiteFilters() {
    const params = getBiteFilterParams();
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

    fetch(`${biteFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering bite reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearBiteFilters() {
    document.getElementById('biteSearch').value = '';
    document.getElementById('biteDateFrom').value = '';
    document.getElementById('biteDateTo').value = '';
    updateClearFiltersVisibility();
    applyBiteFilters();
}

function updateClearFiltersVisibility() {
    const searchInput = document.getElementById('biteSearch');
    const dateFrom = document.getElementById('biteDateFrom');
    const dateTo = document.getElementById('biteDateTo');
    const clearBtn = document.getElementById('clearBiteFiltersBtn');

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

document.getElementById('biteSearch').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearFiltersVisibility();
        applyBiteFilters();
    }, 300);
});

document.getElementById('biteDateFrom').addEventListener('change', () => {
    updateClearFiltersVisibility();
    applyBiteFilters();
});

document.getElementById('biteDateTo').addEventListener('change', () => {
    updateClearFiltersVisibility();
    applyBiteFilters();
});

document.getElementById('reportsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${biteFilterUrl}?${query}`, {
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
    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
    }, 10);

    fetch(`{{ route('admin.bite-reports.show-json', ':id') }}`.replace(':id', reportId))
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
    if (numberEl) numberEl.textContent = 'Report # ' + report.report_number;

    const genderVal = report.animal_gender ? report.animal_gender.charAt(0).toUpperCase() + report.animal_gender.slice(1) : 'N/A';

    content.innerHTML = `
        <div class="p-6 space-y-5 overflow-y-auto max-h-[calc(100vh-200px)]">
            <div class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/40">
                <h3 class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Incident Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Incident Date</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.incident_date}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-2.828-2.828a1.998 1.998 0 010-2.828l4.244-4.243a9 9 0 111.414 1.414z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Barangay</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.barangay || 'N/A'}</p>
                        </div>
                    </div>
                </div>
                ${report.notes ? `
                <div class="mt-5 pt-4 border-t border-slate-200/50">
                    <p class="text-xs text-slate-400">Notes</p>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${report.notes}</p>
                </div>
                ` : ''}
            </div>
            <div class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/40">
                <h3 class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Animal Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Animal Type</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.animal_type || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Animal Gender</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${genderVal}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Animal Status</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.animal_status || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-slate-100 text-slate-600 rounded-lg shrink-0 border border-slate-200/50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Vaccination Status</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.vaccination_status || 'N/A'}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearFiltersVisibility();
</script>
@endsection
