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
                <input type="text" id="biteSearch" value="{{ request('search') }}" placeholder="Search reports..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <button type="button" id="searchHelpBtn"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                        data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus click"
                        data-bs-html="true"
                        data-bs-content="
                            <div class='text-sm text-gray-700 space-y-1'>
                                <div><strong>Examples:</strong></div>
                                <div>BR-2026 <span class='text-gray-400'>(Report No.)</span></div>
                                <div>Juan <span class='text-gray-400'>(Patient Name)</span></div>
                                <div>Dog <span class='text-gray-400'>(Animal Type)</span></div>
                                <div>Category I <span class='text-gray-400'>(Category)</span></div>
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
<div id="reportModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Report Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>
        <div id="modalContent" class="mt-4">
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
                <p class="mt-4 text-gray-600">Loading report details...</p>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 mt-4">
            <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                Close
            </button>
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
    const modal = document.getElementById('reportModal');
    const modalContent = document.getElementById('modalContent');

    modal.classList.remove('hidden');
    modalContent.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
            <p class="mt-4 text-gray-600">Loading report details...</p>
        </div>
    `;

    fetch(`{{ route('admin.bite-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayReportDetails(data.report);
            } else {
                modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading report details.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading report details.</p>';
        });
}

function displayReportDetails(report) {
    const modalContent = document.getElementById('modalContent');

    modalContent.innerHTML = `
        <div class="space-y-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Report Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Report Number</p>
                        <p class="font-medium text-gray-800">${report.report_number}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium text-gray-800">${report.status}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rabies Confirmed</p>
                        <p class="font-medium ${report.rabies_confirmed === 'Yes' ? 'text-red-600' : 'text-gray-800'}">${report.rabies_confirmed}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created At</p>
                        <p class="font-medium text-gray-800">${report.created_at}</p>
                    </div>
                </div>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Patient Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Full Name</p>
                        <p class="font-medium text-gray-800">${report.patient_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Age / Gender</p>
                        <p class="font-medium text-gray-800">${report.age} yrs old / ${report.gender}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="font-medium text-gray-800">${report.patient_address || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Barangay</p>
                        <p class="font-medium text-gray-800">${report.barangay}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact</p>
                        <p class="font-medium text-gray-800">${report.patient_contact || 'N/A'}</p>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Incident Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Incident Date</p>
                        <p class="font-medium text-gray-800">${report.incident_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Exact Location</p>
                        <p class="font-medium text-gray-800">${report.exact_location || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Exposure Type</p>
                        <p class="font-medium text-gray-800">${report.exposure_type || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Bite Site</p>
                        <p class="font-medium text-gray-800">${report.bite_site || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Category</p>
                        <p class="font-medium text-gray-800">${report.category || 'N/A'}</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Animal Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Animal Type</p>
                        <p class="font-medium text-gray-800">${report.animal_type}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Animal Status</p>
                        <p class="font-medium text-gray-800">${report.animal_status}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vaccination Status</p>
                        <p class="font-medium text-gray-800">${report.vaccination_status || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Owner Name</p>
                        <p class="font-medium text-gray-800">${report.animal_owner_name || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Owner Contact</p>
                        <p class="font-medium text-gray-800">${report.animal_owner_contact || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Reporting Facility</p>
                        <p class="font-medium text-gray-800">${report.reporting_facility || 'N/A'}</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Treatment Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Wound Management</p>
                        <p class="font-medium text-gray-800">${report.wound_management}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Post Exposure Prophylaxis</p>
                        <p class="font-medium text-gray-800">${report.post_exposure_prophylaxis || 'N/A'}</p>
                    </div>
                </div>
            </div>
            ${report.notes ? `
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Notes</h4>
                <p class="text-gray-800 whitespace-pre-wrap">${report.notes}</p>
            </div>
            ` : ''}
        </div>
    `;
}

function closeModal() {
    document.getElementById('reportModal').classList.add('hidden');
}

window.onclick = function(event) {
    const modal = document.getElementById('reportModal');
    if (event.target == modal) {
        closeModal();
    }
}

updateClearFiltersVisibility();
</script>
@endsection
