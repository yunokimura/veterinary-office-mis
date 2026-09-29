@extends('layouts.admin')

@section('title', 'Meat Inspection Reports')
@section('header', 'Meat Inspection Reports')
@section('subheader', 'View and manage meat inspection records')

@php
$routePrefix = request()->routeIs('admin.*') ? 'admin' : 'meat-inspection.reports';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Establishments</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Active</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['active'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Expired</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['expired'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Pending Inspection</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['pending_inspection'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Establishments Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Meat Establishments</h3>
                <p class="text-sm text-gray-500">Search and filter meat establishments</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="meatSearchInput" value="{{ request('search') }}" placeholder="Search establishment, owner, type, barangay, status..."
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
            <button type="button" id="clearMeatFiltersBtn" onclick="clearMeatFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="establishmentsTableContainer">
            @include('dashboard.partials.meat-inspection-table')
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="establishmentsPagination">
            {{ $establishments->links() }}
        </div>
        <div id="establishmentsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="establishmentsEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-search text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Establishments Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Establishment Details Modal -->
<div class="modal fade" id="establishmentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Establishment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="establishmentModalBody">
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
const meatFilterUrl = `{{ route($routePrefix . '.meat-inspection-reports.filter') }}`;

function getMeatFilterParams() {
    return {
        search: document.getElementById('meatSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyMeatFilters() {
    const params = getMeatFilterParams();
    const tableContainer = document.getElementById('establishmentsTableContainer');
    const paginationContainer = document.getElementById('establishmentsPagination');
    const loadingEl = document.getElementById('establishmentsLoading');
    const emptyState = document.getElementById('establishmentsEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${meatFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering meat inspection reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearMeatFilters() {
    document.getElementById('meatSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearMeatFiltersVisibility();
    applyMeatFilters();
}

function updateClearMeatFiltersVisibility() {
    const searchInput = document.getElementById('meatSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearMeatFiltersBtn');

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

document.getElementById('meatSearchInput').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearMeatFiltersVisibility();
        applyMeatFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearMeatFiltersVisibility();
    applyMeatFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearMeatFiltersVisibility();
    applyMeatFilters();
});

document.getElementById('establishmentsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${meatFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('establishmentsTableContainer').innerHTML = data.html;
            document.getElementById('establishmentsPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading establishments page:', error);
    });
});

function openEstablishmentModal(establishmentId) {
    const modalEl = document.getElementById('establishmentDetailsModal');
    const modalBody = document.getElementById('establishmentModalBody');
    const modal = new bootstrap.Modal(modalEl);

    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-green-600" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();

    fetch(`{{ route($routePrefix . '.meat-inspection-reports.show-json', ':id') }}`.replace(':id', establishmentId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayEstablishmentDetails(data.establishment);
            } else {
                modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load establishment details.</div>';
            }
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load establishment details.</div>';
        });
}

function displayEstablishmentDetails(establishment) {
    const modalBody = document.getElementById('establishmentModalBody');

    modalBody.innerHTML = `
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Establishment Name</p>
                    <p class="text-lg font-semibold text-gray-800">${establishment.establishment_name}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        ${establishment.status}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Type</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.establishment_type}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Permit Number</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.permit_no || 'N/A'}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Inspection Date</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.inspection_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Permit Expiry Date</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.permit_expiry_date}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Owner Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Owner Name</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.owner_name || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Person</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.contact_person || 'N/A'}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.contact_number || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.email || 'N/A'}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Location Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.address_text || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Landmark</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.landmark || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Barangay</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.barangay}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Registration Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Registered By</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.registered_by}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="font-medium text-gray-800 mt-1">${establishment.created_at}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearMeatFiltersVisibility();
</script>
@endsection
