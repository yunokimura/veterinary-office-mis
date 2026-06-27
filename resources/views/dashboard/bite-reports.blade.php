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
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Confirmed Rabies Reports</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Confirmed Rabies Reports Management</h1>
                <p class="text-gray-500 mt-1">View and manage all confirmed rabies cases</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
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
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-virus text-red-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Dog Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Dog Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['dog_cases'] ?? 0 }}</p>
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
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['cat_cases'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-briefcase text-purple-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Other Cases -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Other Cases</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['other_cases'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-briefcase text-gray-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route($rolePrefix . '.bite-reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <!-- Quick Filters -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quick Filter</label>
                    <select name="quick_filter" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" onchange="this.form.submit()">
                        <option value="">All Time</option>
                        <option value="today" {{ request('quick_filter') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('quick_filter') === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('quick_filter') === 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-start gap-3">
                <a href="{{ route($rolePrefix . '.bite-reports.index') }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                    <i class="bi bi-x-circle mr-1"></i>Clear
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-funnel mr-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">{{ $report->report_number ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ trim(($report->patient_first_name ?? '') . ' ' . ($report->patient_middle_name ?? '') . ' ' . ($report->patient_last_name ?? '') . ' ' . ($report->patient_suffix ?? '')) ?: 'Unknown' }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $report->age ?? 'N/A' }} yrs old</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient_barangay ?? 'N/A') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-gray-800">{{ ucfirst($report->animal_type) }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($report->animal_status) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openReportModal({{ $report->id }})"
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
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-virus text-2xl text-red-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Confirmed Rabies Reports Found</h3>
                <p class="text-gray-500">There are currently no confirmed rabies cases in the system.</p>
            </div>
        @endif
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
</script>
@endsection
