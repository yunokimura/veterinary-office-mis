@extends('layouts.admin')

@section('title', 'Confirmed Rabies Reports Management')

@section('header', 'Confirmed Rabies Reports Management')
@section('subheader', 'View and manage all confirmed rabies cases')

@php
// Use 'admin' prefix for this page since it's under the admin route group
$rolePrefix = 'admin';
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Confirmed Rabies Reports</h1>
                <p class="text-gray-500 mt-1">View and manage all confirmed rabies cases</p>
            </div>
            <div class="flex items-center gap-3">
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Confirmed Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Confirmed Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800" id="statTotal">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-virus text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Confirmed Rabies Cases This Year -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Confirmed Rabies Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800" id="statConfirmedThisYear">{{ $stats['confirmed_this_year'] ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">This Year</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-calendar-check text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Dog Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Dog Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800" id="statDogCases">{{ $stats['dog_cases'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-briefcase text-orange-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Cat Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Cat Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800" id="statCatCases">{{ $stats['cat_cases'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-briefcase text-purple-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <div class="row g-3 align-items-end">
            <!-- Search -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="biteSearch" value="{{ request('search') }}" placeholder="Patient Name"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Barangay Filter -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                <div class="relative">
                    <div id="barangayDisplay" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-gray-400 transition" onclick="toggleBarangayDropdown()">
                        <span id="selectedBarangayText" class="text-gray-500">All Barangays</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="barangayDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                        <div class="p-2 border-b border-gray-200">
                            <input type="text" id="barangaySearch" placeholder="Search barangay..." class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-green-500" onkeyup="filterBarangays()" onclick="event.stopPropagation()">
                        </div>
                        <div id="barangayOptions" class="max-h-48 overflow-y-auto py-1">
                            @foreach($barangays as $barangay)
                                <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                    <input type="checkbox" value="{{ $barangay->barangay_name }}" class="barangay-checkbox h-4 w-4 text-green-600 border-gray-300 rounded" onchange="updateBarangaySelection()" {{ request('barangay_id') && str_contains(request('barangay_id'), $barangay->barangay_name) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">{{ $barangay->barangay_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" id="biteBarangay" value="{{ request('barangay_id') ?? '' }}">
            </div>

            <!-- Bite Category -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bite Category</label>
                <select id="biteCategory" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Categories</option>
                    <option value="I" {{ request('category') === 'I' ? 'selected' : '' }}>Category I</option>
                    <option value="II" {{ request('category') === 'II' ? 'selected' : '' }}>Category II</option>
                    <option value="III" {{ request('category') === 'III' ? 'selected' : '' }}>Category III</option>
                </select>
            </div>

            <!-- Animal Type -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Animal Type</label>
                <select id="biteAnimalType" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Types</option>
                    <option value="dog" {{ request('animal_type') === 'dog' ? 'selected' : '' }}>Dog</option>
                    <option value="cat" {{ request('animal_type') === 'cat' ? 'selected' : '' }}>Cat</option>
                    <option value="others" {{ request('animal_type') === 'others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>

            <!-- Age Filter -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                <select id="biteAgeFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Ages</option>
                    <option value="0-4" {{ request('age_filter') === '0-4' ? 'selected' : '' }}>0 – 4 Years</option>
                    <option value="5-14" {{ request('age_filter') === '5-14' ? 'selected' : '' }}>5 – 14 Years</option>
                    <option value="15-59" {{ request('age_filter') === '15-59' ? 'selected' : '' }}>15 – 59 Years</option>
                    <option value="60+" {{ request('age_filter') === '60+' ? 'selected' : '' }}>60+ Years</option>
                    <option value="unknown" {{ request('age_filter') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                </select>
            </div>

            <!-- Date From -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" id="biteDateFrom" value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Date To -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" id="biteDateTo" value="{{ request('date_to') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Clear Button -->
            <div class="col-12 col-md-3">
                <div class="d-flex align-items-end h-100">
                <button type="button" onclick="clearBiteFilters()"
                   class="btn btn-outline-danger w-100">
                         <i class="bi bi-x-circle mr-1"></i>Clear Filters
                </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="reportsTableContainer">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Patient Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Barangay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Incident Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="reportsTableBody">
                        @include('dashboard.partials.bite-reports-table')
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100" id="reportsPagination">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-12 text-center" id="reportsEmptyState">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-virus text-2xl text-red-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Confirmed Rabies Reports Found</h3>
                <p class="text-gray-500">There are currently no confirmed rabies cases in the system.</p>
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
            <h3 class="text-xl font-bold text-gray-800">Report Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div id="modalContent" class="mt-4">
            <!-- Content will be loaded dynamically -->
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
                <p class="mt-4 text-gray-600">Loading report details...</p>
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
            <p class="mt-4 text-gray-600">Loading report details...</p>
        </div>
    `;

    // Fetch report data
    fetch(`{{ route($rolePrefix . '.bite-reports.show-json', ':id') }}`.replace(':id', reportId))
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
            <!-- Report Info -->
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

            <!-- Patient Information -->
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

            <!-- Incident Information -->
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

            <!-- Animal Information -->
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

            <!-- Treatment Information -->
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

            <!-- Notes -->
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

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('reportModal');
    if (event.target == modal) {
        closeModal();
    }
}

let biteFilterTimeout;
const biteFilterUrl = '{{ route($rolePrefix . '.bite-reports.filter') }}';

function getBiteFilterParams() {
    return {
        search: document.getElementById('biteSearch').value,
        age_filter: document.getElementById('biteAgeFilter').value,
        category: document.getElementById('biteCategory').value,
        animal_type: document.getElementById('biteAnimalType').value,
        barangay_id: document.getElementById('biteBarangay').value,
        date_from: document.getElementById('biteDateFrom').value,
        date_to: document.getElementById('biteDateTo').value,
    };
}

function toggleBarangayDropdown() {
    const dropdown = document.getElementById('barangayDropdown');
    dropdown.classList.toggle('hidden');
}

function updateBarangaySelection() {
    const checkboxes = document.querySelectorAll('.barangay-checkbox:checked');
    const selected = Array.from(checkboxes).map(cb => cb.value).sort();
    const hiddenInput = document.getElementById('biteBarangay');
    const displayText = document.getElementById('selectedBarangayText');

    hiddenInput.value = selected.join(',');

    if (selected.length === 0) {
        displayText.textContent = 'All Barangays';
        displayText.classList.add('text-gray-500');
        displayText.classList.remove('text-gray-900');
    } else {
        displayText.textContent = selected.length === 1 ? selected[0] : selected.length + ' barangays selected';
        displayText.classList.remove('text-gray-500');
        displayText.classList.add('text-gray-900');
    }

    reorderBarangayOptions();
    document.getElementById('barangayDropdown').classList.add('hidden');
    applyBiteFilters();
}

function reorderBarangayOptions() {
    const container = document.getElementById('barangayOptions');
    const labels = Array.from(container.querySelectorAll('label'));
    const selected = labels.filter(label => label.querySelector('.barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });
    const unselected = labels.filter(label => !label.querySelector('.barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });

    container.innerHTML = '';
    selected.forEach(label => container.appendChild(label));
    unselected.forEach(label => container.appendChild(label));
}

function filterBarangays() {
    const search = document.getElementById('barangaySearch').value.toLowerCase();
    const labels = document.querySelectorAll('#barangayOptions label');
    labels.forEach(label => {
        const text = label.textContent.toLowerCase();
        label.style.display = text.includes(search) ? 'flex' : 'none';
    });
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('barangayDropdown');
    const display = document.getElementById('barangayDisplay');
    if (dropdown && display && !dropdown.contains(e.target) && !display.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function applyBiteFilters() {
    const params = getBiteFilterParams();
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

    fetch(`${biteFilterUrl}?${query.toString()}`, {
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

            document.getElementById('statTotal').textContent = data.stats.total ?? 0;
            document.getElementById('statConfirmedThisYear').textContent = data.stats.confirmed_this_year ?? 0;
            document.getElementById('statDogCases').textContent = data.stats.dog_cases ?? 0;
            document.getElementById('statCatCases').textContent = data.stats.cat_cases ?? 0;
        }
    })
    .catch(error => {
        console.error('Error filtering bite reports:', error);
        if (tableBody) tableBody.style.opacity = '1';
        if (pagination) pagination.style.opacity = '1';
    })
    .finally(() => {
        if (loading) loading.classList.add('hidden');
    });
}

function clearBiteFilters() {
    document.getElementById('biteSearch').value = '';
    document.getElementById('biteAgeFilter').value = '';
    document.getElementById('biteAnimalType').value = '';
    document.getElementById('biteCategory').value = '';
    document.getElementById('biteBarangay').value = '';
    document.getElementById('biteDateFrom').value = '';
    document.getElementById('biteDateTo').value = '';
    document.querySelectorAll('.barangay-checkbox').forEach(cb => cb.checked = false);
    const selectedText = document.getElementById('selectedBarangayText');
    if (selectedText) {
        selectedText.textContent = 'All Barangays';
        selectedText.classList.add('text-gray-500');
        selectedText.classList.remove('text-gray-900');
    }
    reorderBarangayOptions();
    applyBiteFilters();
}

document.getElementById('biteSearch').addEventListener('input', () => {
    clearTimeout(biteFilterTimeout);
    biteFilterTimeout = setTimeout(applyBiteFilters, 300);
});

document.getElementById('biteAgeFilter').addEventListener('change', applyBiteFilters);
document.getElementById('biteAnimalType').addEventListener('change', applyBiteFilters);
document.getElementById('biteCategory').addEventListener('change', applyBiteFilters);
document.getElementById('biteDateFrom').addEventListener('change', applyBiteFilters);
document.getElementById('biteDateTo').addEventListener('change', applyBiteFilters);

(function initializeBarangayDisplay() {
    const initialBarangay = document.getElementById('biteBarangay').value;
    if (initialBarangay) {
        const names = initialBarangay.split(',').map(name => name.trim()).filter(Boolean);
        names.forEach(name => {
            const checkbox = document.querySelector(`.barangay-checkbox[value="${name}"]`);
            if (checkbox) checkbox.checked = true;
        });
    }
    updateBarangaySelection();
})();
</script>
@endsection
