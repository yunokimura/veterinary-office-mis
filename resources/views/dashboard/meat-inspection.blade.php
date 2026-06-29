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
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Meat Inspection Reports</h1>
                <p class="text-gray-500 mt-1">Manage and track all meat inspection records</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('meat-inspection.reports.create') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-md flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i>New Report
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Establishments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Establishments</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $establishments->count() }}</p>
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
                    <p class="text-xl md:text-2xl font-bold text-green-600">{{ $establishments->where('status', 'Active')->count() }}</p>
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
                    <p class="text-xl md:text-2xl font-bold text-red-600">{{ $establishments->where('status', 'Expired')->count() }}</p>
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
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ $establishments->where('status', 'Pending Inspection')->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-list-ul text-red-600"></i>
                Recent Inspection Records
            </h3>
            <a href="{{ route('meat-inspection.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
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
                    <tbody class="divide-y divide-gray-100">
                        @foreach($establishments as $establishment)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-shop text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $establishment->establishment_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $establishment->address_text }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 capitalize">
                                    {{ str_replace('_', ' ', $establishment->establishment_type ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">{{ $establishment->owner_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700">{{ $establishment->barangay->barangay_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'Active' => 'bg-green-100 text-green-700 border-green-200',
                                        'Expired' => 'bg-red-100 text-red-700 border-red-200',
                                        'Pending Inspection' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium border whitespace-nowrap {{ $statusColors[$establishment->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ $establishment->status ?? 'Unknown' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openEstablishmentModal({{ $establishment->establishment_id }})"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                                    <i class="bi bi-eye"></i>View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $establishments->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-shop text-red-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Meat Establishments Found</h3>
                <p class="text-gray-500 mb-6">No establishments registered yet.</p>
            </div>
        @endif
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
    fetch(`{{ route('admin.meat-inspection-reports.show-json', ':id') }}`.replace(':id', establishmentId))
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
</script>
@endsection
