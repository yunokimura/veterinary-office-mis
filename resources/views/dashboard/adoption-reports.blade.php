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
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
<div class="modal fade" id="reportDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adoption Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="reportModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
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
    const modalEl = document.getElementById('reportDetailsModal');
    const modalBody = document.getElementById('reportModalBody');
    const modal = new bootstrap.Modal(modalEl);

    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-green-600" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();

    fetch(`{{ route($routePrefix . '.adoption-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayReportDetails(data.report);
            } else {
                modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
            }
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
        });
}

function displayReportDetails(report) {
    const modalBody = document.getElementById('reportModalBody');

    modalBody.innerHTML = `
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Application Number</p>
                    <p class="text-lg font-semibold text-gray-800">${report.report_number}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        ${report.status}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Applied Date</p>
                        <p class="font-medium text-gray-800 mt-1">${report.created_at}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="font-medium text-gray-800 mt-1">${report.updated_at}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Applicant Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.applicant_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800 mt-1">${report.applicant_email}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium text-gray-800 mt-1">${report.applicant_contact}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Pet Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Pet Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Species</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_species}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Breed</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_breed}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_gender}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Application Details</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Reason for Adoption</p>
                        <p class="font-medium text-gray-800 mt-1 whitespace-pre-wrap">${report.reason || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Has Other Pets</p>
                        <p class="font-medium text-gray-800 mt-1">${report.has_other_pets}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Home Type</p>
                        <p class="font-medium text-gray-800 mt-1">${report.home_type}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Yard Has Fence</p>
                        <p class="font-medium text-gray-800 mt-1">${report.yard_has_fence}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Adoption Date</p>
                        <p class="font-medium text-gray-800 mt-1">${report.adoption_date}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="font-medium text-gray-800 mt-1 whitespace-pre-wrap">${report.notes || 'N/A'}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearAdoptionFiltersVisibility();
</script>
@endsection
