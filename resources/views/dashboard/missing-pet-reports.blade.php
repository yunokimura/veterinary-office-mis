@extends('layouts.admin')

@section('title', 'Missing Pet Reports Management')

@section('header', 'Missing Pet Reports Management')
@section('subheader', 'View and manage all missing pet reports')

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
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Missing Pet Reports</h1>
                <p class="text-gray-500 mt-1">View and manage all missing pet reports</p>
            </div>
            <div class="flex items-center gap-3">
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 mb-1">Total Reports</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-file-earmark-text text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Currently Missing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 mb-1">Currently Missing</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-exclamation-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Resolved Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 mb-1">Resolved Cases</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['resolved'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <!-- This Month -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 mb-1">This Month</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['this_month'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-calendar-month text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <div class="row g-3 align-items-end">
            <!-- Pet Name Search -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pet Name</label>
                <input type="text" id="petNameSearch" value="{{ request('pet_name_search') }}" placeholder="Search pet name..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            </div>

            <!-- Animal Type Search -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Animal Type</label>
                <select id="animalTypeSearch" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Animal Types</option>
                    <option value="dog" {{ request('animal_type') === 'dog' ? 'selected' : '' }}>Dog</option>
                    <option value="cat" {{ request('animal_type') === 'cat' ? 'selected' : '' }}>Cat</option>
                    <option value="other" {{ request('animal_type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Barangay Filter -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                <div class="relative">
                    <div id="missingPetBarangayDisplay" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-gray-400 transition" onclick="toggleMissingPetBarangayDropdown()">
                        <span id="selectedMissingPetBarangayText" class="text-gray-500">All Barangays</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="missingPetBarangayDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                        <div class="p-2 border-b border-gray-200">
                            <input type="text" id="missingPetBarangaySearch" placeholder="Search barangay..." class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-green-500" onkeyup="filterMissingPetBarangays()" onclick="event.stopPropagation()">
                        </div>
                        <div id="missingPetBarangayOptions" class="max-h-48 overflow-y-auto py-1">
                            @foreach($barangays as $barangay)
                                <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                    <input type="checkbox" value="{{ $barangay->barangay_name }}" class="missing-pet-barangay-checkbox h-4 w-4 text-green-600 border-gray-300 rounded" onchange="updateMissingPetBarangaySelection()" {{ request('barangay') && str_contains(request('barangay'), $barangay->barangay_name) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">{{ $barangay->barangay_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" id="missingPetBarangay" value="{{ request('barangay') ?? '' }}">
            </div>

            <!-- Status Filter -->
            <div class="col-12 col-md-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">All Status</option>
                    <option value="missing" {{ request('status') === 'missing' ? 'selected' : '' }}>Missing</option>
                    <option value="found" {{ request('status') === 'found' ? 'selected' : '' }}>Found</option>
                    <option value="reunited" {{ request('status') === 'reunited' ? 'selected' : '' }}>Reunited</option>
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
                <button type="button" onclick="clearMissingPetFilters()"
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report No.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pet Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animal Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Last Seen</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Barangay</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="reportsTableBody">
                        @include('dashboard.partials.missing-pet-reports-table')
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100" id="reportsPagination">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-12 text-center" id="reportsEmptyState">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-search text-2xl text-blue-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Missing Pet Reports Found</h3>
                <p class="text-gray-500">There are currently no missing pet reports in the system.</p>
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
            <h3 class="text-xl font-bold text-gray-800">Missing Pet Report Details</h3>
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
    fetch(`{{ route($rolePrefix . '.missing-pet-reports.show-json', ':id') }}`.replace(':id', reportId))
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
                        <p class="text-sm text-gray-600">Reported By</p>
                        <p class="font-medium text-gray-800">${report.reported_by}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created At</p>
                        <p class="font-medium text-gray-800">${report.created_at}</p>
                    </div>
                </div>
            </div>

            <!-- Pet Information -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Pet Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Pet Name</p>
                        <p class="font-medium text-gray-800">${report.pet_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Species</p>
                        <p class="font-medium text-gray-800">${report.species}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Breed</p>
                        <p class="font-medium text-gray-800">${report.breed}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Color</p>
                        <p class="font-medium text-gray-800">${report.color}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Gender</p>
                        <p class="font-medium text-gray-800">${report.gender}</p>
                    </div>
                </div>
            </div>

            <!-- Missing Pet Details -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Missing Pet Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Last Seen Date</p>
                        <p class="font-medium text-gray-800">${report.last_seen_at}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Last Seen Time</p>
                        <p class="font-medium text-gray-800">${report.last_seen_time}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-medium text-gray-800">${report.location}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Barangay</p>
                        <p class="font-medium text-gray-800">${report.barangay}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Description</p>
                        <p class="font-medium text-gray-800 whitespace-pre-wrap">${report.description || 'N/A'}</p>
                    </div>
                </div>
            </div>

            <!-- Reporter Information -->
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Reporter Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Reporter Name</p>
                        <p class="font-medium text-gray-800">${report.reporter_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact Number</p>
                        <p class="font-medium text-gray-800">${report.reporter_contact}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-gray-800">${report.reporter_email}</p>
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

const missingPetFilterUrl = `{{ route($rolePrefix . '.missing-pet-reports.filter') }}`;

function getMissingPetFilterParams() {
    return {
        animal_type: document.getElementById('animalTypeSearch').value,
        barangay: document.getElementById('missingPetBarangay').value,
        pet_name_search: document.getElementById('petNameSearch').value,
        status: document.getElementById('statusFilter').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function toggleMissingPetBarangayDropdown() {
    const dropdown = document.getElementById('missingPetBarangayDropdown');
    dropdown.classList.toggle('hidden');
}

function updateMissingPetBarangaySelection() {
    const checkboxes = document.querySelectorAll('.missing-pet-barangay-checkbox:checked');
    const selected = Array.from(checkboxes).map(cb => cb.value).sort();
    const hiddenInput = document.getElementById('missingPetBarangay');
    const displayText = document.getElementById('selectedMissingPetBarangayText');

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

    reorderMissingPetBarangayOptions();
    document.getElementById('missingPetBarangayDropdown').classList.add('hidden');
    applyMissingPetFilters();
}

function reorderMissingPetBarangayOptions() {
    const container = document.getElementById('missingPetBarangayOptions');
    const labels = Array.from(container.querySelectorAll('label'));
    const selected = labels.filter(label => label.querySelector('.missing-pet-barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });
    const unselected = labels.filter(label => !label.querySelector('.missing-pet-barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });

    container.innerHTML = '';
    selected.forEach(label => container.appendChild(label));
    unselected.forEach(label => container.appendChild(label));
}

function filterMissingPetBarangays() {
    const search = document.getElementById('missingPetBarangaySearch').value.toLowerCase();
    const labels = document.querySelectorAll('#missingPetBarangayOptions label');
    labels.forEach(label => {
        const text = label.textContent.toLowerCase();
        label.style.display = text.includes(search) ? 'flex' : 'none';
    });
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('missingPetBarangayDropdown');
    const display = document.getElementById('missingPetBarangayDisplay');
    if (dropdown && display && !dropdown.contains(e.target) && !display.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function applyMissingPetFilters() {
    const params = getMissingPetFilterParams();
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

    fetch(`${missingPetFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering missing pet reports:', error);
        if (tableBody) tableBody.style.opacity = '1';
        if (pagination) pagination.style.opacity = '1';
        if (loading) loading.classList.add('hidden');
    });
}

function clearMissingPetFilters() {
    document.getElementById('animalTypeSearch').value = '';
    document.querySelectorAll('.missing-pet-barangay-checkbox:checked').forEach(cb => cb.checked = false);
    document.getElementById('selectedMissingPetBarangayText').textContent = 'All Barangays';
    document.getElementById('selectedMissingPetBarangayText').classList.add('text-gray-500');
    document.getElementById('selectedMissingPetBarangayText').classList.remove('text-gray-900');
    document.getElementById('missingPetBarangay').value = '';
    document.getElementById('petNameSearch').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    applyMissingPetFilters();
}

document.getElementById('animalTypeSearch').addEventListener('change', applyMissingPetFilters);
document.querySelectorAll('.missing-pet-barangay-checkbox').forEach(cb => cb.addEventListener('change', applyMissingPetFilters));
document.getElementById('petNameSearch').addEventListener('input', applyMissingPetFilters);
document.getElementById('statusFilter').addEventListener('change', applyMissingPetFilters);
document.getElementById('dateFrom').addEventListener('change', applyMissingPetFilters);
document.getElementById('dateTo').addEventListener('change', applyMissingPetFilters);
</script>
@endsection