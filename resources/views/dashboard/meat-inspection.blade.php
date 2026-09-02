@extends('layouts.admin')

@section('title', 'Meat Inspection Reports')

@section('header', 'Meat Inspection Reports')
@section('subheader', 'View and manage meat inspection records')

@php
$role = auth()->user()->getRoleAttribute() ?? 'city_vet';
$dashboardRoutes = [
    'super_admin' => 'super-admin.dashboard',
    'city_vet' => 'city-vet.dashboard',
    'admin_staff' => 'admin-staff.dashboard',
    'admin_asst' => 'admin-staff.dashboard',
    'assistant_vet' => 'assistant-vet.dashboard',
    'meat_inspector' => 'meat-inspection.dashboard',
    'livestock_inspector' => 'livestock.dashboard',
    'pet_owner' => 'owner.dashboard',
];
$rolePrefix = str_replace('_', '-', $role);
$dashboardRoute = $dashboardRoutes[$role] ?? $rolePrefix . '.dashboard';

// Determine the correct route prefix for meat inspection reports
$meatInspectionRoutePrefix = ($role === 'meat_inspector') ? 'meat-inspection.reports' : 'admin.meat-inspection-reports';
@endphp

@section('content')
@php
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good afternoon';
    } else {
        $greeting = 'Good evening';
    }
@endphp

<!-- Welcome Banner -->
<div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-6 border border-gray-200">
    <h2 class="text-xl md:text-2xl font-bold mb-2 text-gray-800">
        Meat Inspection Reports
    </h2>
    <p class="text-sm md:text-base text-gray-600">
        View and manage meat inspection records
    </p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Establishments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 mb-1">Total Establishments</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-shop text-red-600 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Active -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 mb-1">Active</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['active'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-11 md:h-11 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-check-circle text-green-600 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Expired -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 mb-1">Expired</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['expired'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-x-circle text-red-600 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Inspection -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 mb-1">Pending Inspection</p>
                <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['pending_inspection'] ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-11 md:h-11 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="row g-3 align-items-end">
        <!-- Owner/Establishment Name Search -->
        <div class="col-12 col-md-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Owner/Establishment Name</label>
            <input type="text" id="searchInput" placeholder="Search by name..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
        </div>

        <!-- Type Filter -->
        <div class="col-12 col-md-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select id="typeFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                <option value="">All Types</option>
                @foreach($establishmentTypes as $type)
                    <option value="{{ $type }}">{{ str_replace('_', ' ', ucfirst($type)) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Barangay Filter -->
        <div class="col-12 col-md-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
            <div class="relative">
                <div id="meatBarangayDisplay" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-gray-400 transition" onclick="toggleMeatBarangayDropdown()">
                    <span id="selectedMeatBarangayText" class="text-gray-500">All Barangays</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div id="meatBarangayDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                    <div class="p-2 border-b border-gray-200">
                        <input type="text" id="meatBarangaySearch" placeholder="Search barangay..." class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-green-500" onkeyup="filterMeatBarangays()" onclick="event.stopPropagation()">
                    </div>
                    <div id="meatBarangayOptions" class="max-h-48 overflow-y-auto py-1">
                        @foreach($barangays as $barangay)
                            <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                <input type="checkbox" value="{{ $barangay->barangay_name }}" class="meat-barangay-checkbox h-4 w-4 text-green-600 border-gray-300 rounded" onchange="updateMeatBarangaySelection()">
                                <span class="ml-3 text-sm text-gray-700">{{ $barangay->barangay_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <input type="hidden" id="meatBarangay" value="">
        </div>

        <!-- Status Filter -->
        <div class="col-12 col-md-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="statusFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                <option value="">All Status</option>
                <option value="Active">Active</option>
                <option value="Expired">Expired</option>
                <option value="Pending Inspection">Pending Inspection</option>
            </select>
        </div>

        <!-- Clear Button -->
        <div class="col-12 col-md-3">
            <button type="button" onclick="clearMeatFilters()"
                    class="btn btn-outline-danger w-100">
                <i class="bi bi-x-circle mr-1"></i>Clear
            </button>
        </div>
    </div>
</div>

<!-- Establishments Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($establishments->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Establishment Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Owner</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Barangay</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="establishmentsTableBody">
                    @include('dashboard.partials.meat-inspection-table')
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100" id="establishmentsPagination">
            {{ $establishments->links() }}
        </div>
    @else
        <div class="p-12 text-center" id="establishmentsEmptyState">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-shop text-red-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No Meat Establishments Found</h3>
            <p class="text-gray-500 mb-6">No establishments registered yet.</p>
        </div>
    @endif
    <div id="establishmentsLoading" class="hidden p-12 text-center">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-red-600"></div>
        <p class="mt-4 text-gray-600">Loading establishments...</p>
    </div>
</div>

<!-- Establishment Details Modal -->
<div id="establishmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Establishment Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div id="modalContent" class="mt-4">
            <!-- Content will be loaded dynamically -->
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-red-600"></div>
                <p class="mt-4 text-gray-600">Loading establishment details...</p>
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
function openEstablishmentModal(establishmentId) {
    const modal = document.getElementById('establishmentModal');
    const modalContent = document.getElementById('modalContent');
    
    // Show modal with loading state
    modal.classList.remove('hidden');
    modalContent.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-red-600"></div>
            <p class="mt-4 text-gray-600">Loading establishment details...</p>
        </div>
    `;

    // Fetch establishment data
    fetch(`{{ route('meat-inspection.establishments.show-json', ':id') }}`.replace(':id', establishmentId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayEstablishmentDetails(data.establishment);
            } else {
                modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading establishment details.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading establishment details.</p>';
        });
}

function displayEstablishmentDetails(establishment) {
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="space-y-6">
            <!-- Establishment Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Establishment Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Establishment Name</p>
                        <p class="font-medium text-gray-800">${establishment.establishment_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <p class="font-medium text-gray-800">${establishment.establishment_type}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium text-gray-800">${establishment.status}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Permit Number</p>
                        <p class="font-medium text-gray-800">${establishment.permit_no || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Inspection Date</p>
                        <p class="font-medium text-gray-800">${establishment.inspection_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Permit Expiry Date</p>
                        <p class="font-medium text-gray-800">${establishment.permit_expiry_date}</p>
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Owner Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Owner Name</p>
                        <p class="font-medium text-gray-800">${establishment.owner_name || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact Person</p>
                        <p class="font-medium text-gray-800">${establishment.contact_person || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact Number</p>
                        <p class="font-medium text-gray-800">${establishment.contact_number || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-gray-800">${establishment.email || 'N/A'}</p>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Location Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="font-medium text-gray-800">${establishment.address_text || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Landmark</p>
                        <p class="font-medium text-gray-800">${establishment.landmark || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Barangay</p>
                        <p class="font-medium text-gray-800">${establishment.barangay}</p>
                    </div>
                </div>
            </div>

            <!-- Registration Information -->
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Registration Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Registered By</p>
                        <p class="font-medium text-gray-800">${establishment.registered_by}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created At</p>
                        <p class="font-medium text-gray-800">${establishment.created_at}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function closeModal() {
    document.getElementById('establishmentModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('establishmentModal');
    if (event.target == modal) {
        closeModal();
    }
}

const meatFilterUrl = `{{ route('admin.meat-inspection-reports.filter') }}`;

function getMeatFilterParams() {
    return {
        search: document.getElementById('searchInput').value,
        type: document.getElementById('typeFilter').value,
        barangay: document.getElementById('meatBarangay').value,
        status: document.getElementById('statusFilter').value,
    };
}

function toggleMeatBarangayDropdown() {
    const dropdown = document.getElementById('meatBarangayDropdown');
    dropdown.classList.toggle('hidden');
}

function updateMeatBarangaySelection() {
    const checkboxes = document.querySelectorAll('.meat-barangay-checkbox:checked');
    const selected = Array.from(checkboxes).map(cb => cb.value).sort();
    const hiddenInput = document.getElementById('meatBarangay');
    const displayText = document.getElementById('selectedMeatBarangayText');

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

    reorderMeatBarangayOptions();
    document.getElementById('meatBarangayDropdown').classList.add('hidden');
    applyMeatFilters();
}

function reorderMeatBarangayOptions() {
    const container = document.getElementById('meatBarangayOptions');
    const labels = Array.from(container.querySelectorAll('label'));
    const selected = labels.filter(label => label.querySelector('.meat-barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });
    const unselected = labels.filter(label => !label.querySelector('.meat-barangay-checkbox')?.checked).sort((a, b) => {
        const aText = a.querySelector('span')?.textContent?.trim() || '';
        const bText = b.querySelector('span')?.textContent?.trim() || '';
        return aText.localeCompare(bText);
    });

    container.innerHTML = '';
    selected.forEach(label => container.appendChild(label));
    unselected.forEach(label => container.appendChild(label));
}

function filterMeatBarangays() {
    const search = document.getElementById('meatBarangaySearch').value.toLowerCase();
    const labels = document.querySelectorAll('#meatBarangayOptions label');
    labels.forEach(label => {
        const text = label.textContent.toLowerCase();
        label.style.display = text.includes(search) ? 'flex' : 'none';
    });
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('meatBarangayDropdown');
    const display = document.getElementById('meatBarangayDisplay');
    if (dropdown && display && !dropdown.contains(e.target) && !display.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function applyMeatFilters() {
    const params = getMeatFilterParams();
    const loading = document.getElementById('establishmentsLoading');
    const tableBody = document.getElementById('establishmentsTableBody');
    const pagination = document.getElementById('establishmentsPagination');
    const emptyState = document.getElementById('establishmentsEmptyState');

    if (loading) loading.classList.remove('hidden');
    if (tableBody) tableBody.style.opacity = '0.3';
    if (pagination) pagination.style.opacity = '0.3';

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
        console.error('Error filtering meat inspection reports:', error);
        if (tableBody) tableBody.style.opacity = '1';
        if (pagination) pagination.style.opacity = '1';
        if (loading) loading.classList.add('hidden');
    });
}

function clearMeatFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    document.querySelectorAll('.meat-barangay-checkbox:checked').forEach(cb => cb.checked = false);
    document.getElementById('selectedMeatBarangayText').textContent = 'All Barangays';
    document.getElementById('selectedMeatBarangayText').classList.add('text-gray-500');
    document.getElementById('selectedMeatBarangayText').classList.remove('text-gray-900');
    document.getElementById('meatBarangay').value = '';
    document.getElementById('statusFilter').value = '';
    applyMeatFilters();
}

document.getElementById('searchInput').addEventListener('input', applyMeatFilters);
document.getElementById('typeFilter').addEventListener('change', applyMeatFilters);
document.querySelectorAll('.meat-barangay-checkbox').forEach(cb => cb.addEventListener('change', applyMeatFilters));
document.getElementById('statusFilter').addEventListener('change', applyMeatFilters);
</script>
@endsection
