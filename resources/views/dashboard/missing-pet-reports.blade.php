@extends('layouts.admin')

@section('title', 'Missing Pet Reports Management')
@section('header', 'Missing Pet Reports Management')
@section('subheader', 'View and manage all missing pet reports')

@php
$routePrefix = request()->routeIs('city-vet.*') ? 'city-vet' : (request()->routeIs('super-admin.*') ? 'super-admin' : 'admin');
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Reports</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Currently Missing</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['active'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Resolved Cases</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['resolved'] ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['this_month'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Missing Pet Reports</h3>
                <p class="text-sm text-gray-500">Search and filter missing pet reports</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-[480px]">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="missingPetSearchInput" value="{{ request('search') }}" placeholder="Search report no, pet name, species, barangay, status..."
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
            <button type="button" id="clearMissingPetFiltersBtn" onclick="clearMissingPetFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="reportsTableContainer">
            @include('dashboard.partials.missing-pet-reports-table')
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
                <h5 class="modal-title">Missing Pet Report Details</h5>
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
const missingPetFilterUrl = `{{ route($routePrefix . '.missing-pet-reports.filter') }}`;

function getMissingPetStatusBadge(status) {
    const map = {
        'pending review': 'bg-[#FEF3C7] text-[#92400E]',
        'approved': 'bg-[#DCFCE7] text-[#166534]',
        'rejected': 'bg-[#FEE2E2] text-[#991B1B]',
        'resolved - reunited': 'bg-[#E0E7FF] text-[#3730A3]',
        'resolved - shelter intake': 'bg-[#E0F2FE] text-[#075985]',
        'closed - expired': 'bg-[#F3F4F6] text-[#4B5563]',
        'closed - cancelled': 'bg-[#E5E7EB] text-[#374151]',
        'closed - duplicate': 'bg-[#F3F4F6] text-[#6B7280]',
        'missing': 'bg-red-100 text-red-800',
        'found': 'bg-blue-100 text-blue-800',
    };
    return map[status.toLowerCase()] || 'bg-gray-100 text-gray-800';
}

function getMissingPetStatusLabel(status) {
    const map = {
        'pending review': 'Pending Review',
        'resolved - reunited': 'Resolved - Reunited',
        'resolved - shelter intake': 'Resolved - Shelter Intake',
        'closed - expired': 'Closed - Expired',
        'closed - cancelled': 'Closed - Cancelled',
        'closed - duplicate': 'Closed - Duplicate',
    };
    return map[status.toLowerCase()] || status.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
}

function getMissingPetFilterParams() {
    return {
        search: document.getElementById('missingPetSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyMissingPetFilters() {
    const params = getMissingPetFilterParams();
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

    fetch(`${missingPetFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering missing pet reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearMissingPetFilters() {
    document.getElementById('missingPetSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearMissingPetFiltersVisibility();
    applyMissingPetFilters();
}

function updateClearMissingPetFiltersVisibility() {
    const searchInput = document.getElementById('missingPetSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearMissingPetFiltersBtn');

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

document.getElementById('missingPetSearchInput').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearMissingPetFiltersVisibility();
        applyMissingPetFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearMissingPetFiltersVisibility();
    applyMissingPetFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearMissingPetFiltersVisibility();
    applyMissingPetFilters();
});

document.getElementById('reportsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${missingPetFilterUrl}?${query}`, {
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

    fetch(`{{ route($routePrefix . '.missing-pet-reports.show-json', ':id') }}`.replace(':id', reportId))
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
                    <p class="text-sm text-gray-500">Report Number</p>
                    <p class="text-lg font-semibold text-gray-800">${report.report_number}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getMissingPetStatusBadge(report.status)}">
                        ${getMissingPetStatusLabel(report.status)}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Reported By</p>
                        <p class="font-medium text-gray-800 mt-1">${report.reported_by}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="font-medium text-gray-800 mt-1">${report.created_at}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Pet Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Pet Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Species</p>
                        <p class="font-medium text-gray-800 mt-1">${report.species}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Breed</p>
                        <p class="font-medium text-gray-800 mt-1">${report.breed}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Color</p>
                        <p class="font-medium text-gray-800 mt-1">${report.color}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-800 mt-1">${report.gender}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Missing Pet Details</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Last Seen Date</p>
                        <p class="font-medium text-gray-800 mt-1">${report.last_seen_at}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Seen Time</p>
                        <p class="font-medium text-gray-800 mt-1">${report.last_seen_time}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Barangay</p>
                        <p class="font-medium text-gray-800 mt-1">${report.barangay}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="font-medium text-gray-800 mt-1 whitespace-pre-wrap">${report.description || 'N/A'}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Reporter Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Reporter Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.reporter_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium text-gray-800 mt-1">${report.reporter_contact}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800 mt-1">${report.reporter_email}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearMissingPetFiltersVisibility();
</script>
@endsection
