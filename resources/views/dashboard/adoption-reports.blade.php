@extends('layouts.admin')

@section('title', 'Adoption Reports Management')

@section('header', 'Adoption Reports Management')
@section('subheader', 'View and manage all adoption applications')

@php
// Use 'city-vet' prefix for this page since it's under the city-vet route group
$rolePrefix = 'city-vet';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Adoption Reports</h1>
                <p class="text-gray-500 mt-1">View and manage all adoption applications</p>
            </div>
            <div class="flex items-center gap-3">
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Applications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Applications</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-file-earmark-text text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Pending</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Approved -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Approved</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Rejected -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Rejected</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['rejected'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-x-circle text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <div class="row g-3 align-items-end">
            <!-- Applicant Name/Pet Name Search -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Applicant Name/Pet Name</label>
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Search by name..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Animal Type -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Animal Type</label>
                <select id="animalTypeSearch" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Animal Types</option>
                    @foreach($animalTypes as $type)
                        <option value="{{ $type }}" {{ request('animal_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Date From -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" id="dateFrom" value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Date To -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" id="dateTo" value="{{ request('date_to') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Clear Button -->
            <div class="col-12 col-md-3">
                <button type="button" onclick="clearAdoptionFilters()"
                        class="btn btn-outline-danger w-100">
                    <i class="bi bi-x-circle mr-1"></i>Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Application No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Applicant</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pet</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Applied Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="reportsTableBody">
                        @include('dashboard.partials.adoption-reports-table')
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100" id="reportsPagination">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-12 text-center" id="reportsEmptyState">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-heart text-2xl text-purple-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Adoption Applications Found</h3>
                <p class="text-gray-500">There are currently no adoption applications in the system.</p>
            </div>
        @endif
        <div id="reportsLoading" class="hidden p-12 text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
            <p class="mt-4 text-gray-600">Loading reports...</p>
        </div>
    </div>
</div>

<!-- Report Details Modal -->
<div id="reportModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Adoption Application Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div id="modalContent" class="mt-4">
            <!-- Content will be loaded dynamically -->
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
                <p class="mt-4 text-gray-600">Loading application details...</p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 mt-4">
            <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openReportModal(reportId) {
    const modal = document.getElementById('reportModal');
    const modalContent = document.getElementById('modalContent');
    
    // Show modal with loading state
    modal.classList.remove('hidden');
    modalContent.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
            <p class="mt-4 text-gray-600">Loading application details...</p>
        </div>
    `;

    // Fetch report data
    fetch(`{{ route($rolePrefix . '.adoption-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayReportDetails(data.report);
            } else {
                modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading application details.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading application details.</p>';
        });
}

function displayReportDetails(report) {
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="space-y-6">
            <!-- Application Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Application Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Application Number</p>
                        <p class="font-medium text-gray-800">${report.report_number}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium text-gray-800">${report.status}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Applied Date</p>
                        <p class="font-medium text-gray-800">${report.created_at}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Last Updated</p>
                        <p class="font-medium text-gray-800">${report.updated_at}</p>
                    </div>
                </div>
            </div>

            <!-- Applicant Information -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Applicant Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Full Name</p>
                        <p class="font-medium text-gray-800">${report.applicant_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-gray-800">${report.applicant_email}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact Number</p>
                        <p class="font-medium text-gray-800">${report.applicant_contact}</p>
                    </div>
                </div>
            </div>

            <!-- Pet Information -->
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Pet Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Pet Name</p>
                        <p class="font-medium text-gray-800">${report.pet_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Species</p>
                        <p class="font-medium text-gray-800">${report.pet_species}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Breed</p>
                        <p class="font-medium text-gray-800">${report.pet_breed}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Gender</p>
                        <p class="font-medium text-gray-800">${report.pet_gender}</p>
                    </div>
                </div>
            </div>

            <!-- Application Details -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Application Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Reason for Adoption</p>
                        <p class="font-medium text-gray-800 whitespace-pre-wrap">${report.reason || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Has Other Pets</p>
                        <p class="font-medium text-gray-800">${report.has_other_pets}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Home Type</p>
                        <p class="font-medium text-gray-800">${report.home_type}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Yard Has Fence</p>
                        <p class="font-medium text-gray-800">${report.yard_has_fence}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Adoption Date</p>
                        <p class="font-medium text-gray-800">${report.adoption_date}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Other Pets Details</p>
                        <p class="font-medium text-gray-800 whitespace-pre-wrap">${report.other_pets_details || 'N/A'}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Notes</p>
                        <p class="font-medium text-gray-800 whitespace-pre-wrap">${report.notes || 'N/A'}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function closeModal() {
    document.getElementById('reportModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('reportModal');
    if (event.target == modal) {
        closeModal();
    }
}

const adoptionFilterUrl = `{{ route($rolePrefix . '.adoption-reports.filter') }}`;

function getAdoptionFilterParams() {
    return {
        search: document.getElementById('searchInput').value,
        animal_type: document.getElementById('animalTypeSearch').value,
        status: document.getElementById('statusFilter').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyAdoptionFilters() {
    const params = getAdoptionFilterParams();
    const loading = document.getElementById('reportsLoading');
    const tableBody = document.getElementById('reportsTableBody');
    const pagination = document.getElementById('reportsPagination');
    const emptyState = document.getElementById('reportsEmptyState');

    if (loading) loading.classList.remove('hidden');
    if (tableBody) tableBody.style.opacity = '0.3';
    if (pagination) pagination.style.opacity = '0.3';

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
            if (tableBody) {
                tableBody.innerHTML = data.table_html;
                tableBody.style.opacity = '1';
            }
            if (pagination) {
                pagination.innerHTML = data.pagination_html;
                pagination.style.opacity = '1';
            }
            if (emptyState) emptyState.style.display = data.has_results ? 'none' : 'block';
            if (loading) loading.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error filtering adoption reports:', error);
        if (tableBody) tableBody.style.opacity = '1';
        if (pagination) pagination.style.opacity = '1';
        if (loading) loading.classList.add('hidden');
    });
}

function clearAdoptionFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('animalTypeSearch').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    applyAdoptionFilters();
}

document.getElementById('searchInput').addEventListener('input', applyAdoptionFilters);
document.getElementById('animalTypeSearch').addEventListener('change', applyAdoptionFilters);
document.getElementById('statusFilter').addEventListener('change', applyAdoptionFilters);
document.getElementById('dateFrom').addEventListener('change', applyAdoptionFilters);
document.getElementById('dateTo').addEventListener('change', applyAdoptionFilters);
</script>
@endsection