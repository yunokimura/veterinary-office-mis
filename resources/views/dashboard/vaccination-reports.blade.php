@extends('layouts.admin')

@section('title', 'Rabies Vaccination Reports Management')
@section('header', 'Rabies Vaccination Reports Management')
@section('subheader', 'View and manage all anti-rabies vaccination reports')

@php
$routePrefix = request()->routeIs('city-vet.*') ? 'city-vet' : (request()->routeIs('super-admin.*') ? 'super-admin' : 'admin');
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Reports</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $reports->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Vaccinations</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\VaccinationReport::count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\VaccinationReport::where('vaccination_date', '>=', now()->startOfMonth())->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Vaccination Reports</h3>
                <p class="text-sm text-gray-500">Search and filter rabies vaccination reports</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="vaccineSearchInput" value="{{ request('search') }}" placeholder="Search reports, pet..."
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
            <button type="button" id="clearVaccineFiltersBtn" onclick="clearVaccineFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="reportsTableContainer">
            @include('dashboard.partials.vaccination-reports-table')
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

<!-- Vaccination Report Details Modal -->
<div class="modal fade" id="vaccinationDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vaccination Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="vaccinationModalBody">
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
const vaccinationFilterUrl = `{{ route($routePrefix . '.vaccination-reports.filter') }}`;

function getVaccineFilterParams() {
    return {
        search: document.getElementById('vaccineSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyVaccineFilters() {
    const params = getVaccineFilterParams();
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

    fetch(`${vaccinationFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering vaccination reports:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearVaccineFilters() {
    document.getElementById('vaccineSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearVaccineFiltersVisibility();
    applyVaccineFilters();
}

function updateClearVaccineFiltersVisibility() {
    const searchInput = document.getElementById('vaccineSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearVaccineFiltersBtn');

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

document.getElementById('vaccineSearchInput').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearVaccineFiltersVisibility();
        applyVaccineFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearVaccineFiltersVisibility();
    applyVaccineFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearVaccineFiltersVisibility();
    applyVaccineFilters();
});

document.getElementById('reportsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${vaccinationFilterUrl}?${query}`, {
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

function openVaccinationModal(reportId) {
    const modalEl = document.getElementById('vaccinationDetailsModal');
    const modalBody = document.getElementById('vaccinationModalBody');
    const modal = new bootstrap.Modal(modalEl);

    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-green-600" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();

    fetch(`{{ route($routePrefix . '.vaccination-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayVaccinationDetails(data.report);
            } else {
                modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
            }
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load report details.</div>';
        });
}

function displayVaccinationDetails(report) {
    const modalBody = document.getElementById('vaccinationModalBody');

    modalBody.innerHTML = `
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Report Number</p>
                    <p class="text-lg font-semibold text-gray-800">${report.report_number}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="bi bi-shield-check mr-1"></i> ${report.status}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Vaccination Details</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Vaccination Date</p>
                        <p class="font-medium text-gray-800 mt-1">${report.vaccination_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Vaccination Time</p>
                        <p class="font-medium text-gray-800 mt-1">${report.vaccination_time || 'N/A'}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Next Vaccination</p>
                        <p class="font-medium text-gray-800 mt-1">${report.next_vaccination_date}</p>
                    </div>
                </div>
                ${report.observations || report.notes ? `
                <div class="mt-4">
                    ${report.observations ? `
                    <div class="mb-3">
                        <p class="text-sm text-gray-500">Observations</p>
                        <p class="text-gray-800 whitespace-pre-wrap">${report.observations}</p>
                    </div>
                    ` : ''}
                    ${report.notes ? `
                    <div>
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="text-gray-800 whitespace-pre-wrap">${report.notes}</p>
                    </div>
                    ` : ''}
                </div>
                ` : ''}
            </div>
            <hr class="border-gray-100">

            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Pet Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Pet Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_name || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Species</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_species}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Breed</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_breed || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Age</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_age ? report.pet_age + ' years' : 'N/A'}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-800 mt-1">${report.pet_gender}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Weight</p>
                        <p class="font-medium text-gray-800 mt-1">${report.weight ? report.weight + ' kg' : 'N/A'}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Owner Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Owner Name</p>
                        <p class="font-medium text-gray-800 mt-1">${report.patient_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact</p>
                        <p class="font-medium text-gray-800 mt-1">${report.patient_contact}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium text-gray-800 mt-1">${report.patient_address}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Barangay</p>
                        <p class="font-medium text-gray-800 mt-1">${report.barangay}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

updateClearVaccineFiltersVisibility();
</script>
@endsection
