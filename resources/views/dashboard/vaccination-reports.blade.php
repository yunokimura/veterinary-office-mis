@extends('layouts.admin')

@section('title', 'Rabies Vaccination Reports Management')

@section('header', 'Rabies Vaccination Reports Management')
@section('subheader', 'View and manage all anti-rabies vaccination reports')

@php
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
                <li class="text-gray-800">Vaccination Reports</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Rabies Vaccination Reports</h1>
                <p class="text-gray-500 mt-1">View and manage all anti-rabies vaccination reports</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Reports</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $reports->total() }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-file-earmark-text text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- This Month -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">This Month</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $reports->where('vaccination_date', '>=', now()->startOfMonth())->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-calendar-check text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <!-- Clinics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Clinics</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $reports->unique('clinic_name')->count() }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-building text-purple-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route($rolePrefix . '.vaccination-reports.index') }}" class="space-y-4">
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
                <a href="{{ route($rolePrefix . '.vaccination-reports.index') }}"
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Report ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Clinic</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Vaccine</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Animals</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-800">RV-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->clinic_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->vaccine_brand ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $report->pet_species ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $report->vaccination_date ? \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <button onclick="openVaccinationModal({{ $report->id }})"
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
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-shield-check text-green-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Vaccination Reports</h3>
                <p class="text-gray-500 mb-6">No records found.</p>
            </div>
        @endif
    </div>
</div>

<!-- Vaccination Report Details Modal -->
<div id="vaccinationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Vaccination Report Details</h3>
            <button onclick="closeVaccinationModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div id="vaccinationModalContent" class="mt-4">
            <!-- Content will be loaded dynamically -->
            <div class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
                <p class="mt-4 text-gray-600">Loading vaccination report details...</p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 mt-4">
            <button onclick="closeVaccinationModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openVaccinationModal(reportId) {
    const modal = document.getElementById('vaccinationModal');
    const modalContent = document.getElementById('vaccinationModalContent');
    
    // Show modal with loading state
    modal.classList.remove('hidden');
    modalContent.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-green-600"></div>
            <p class="mt-4 text-gray-600">Loading vaccination report details...</p>
        </div>
    `;

    // Fetch vaccination report data
    fetch(`{{ route($rolePrefix . '.vaccination-reports.show-json', ':id') }}`.replace(':id', reportId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayVaccinationDetails(data.report);
            } else {
                modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading vaccination report details.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = '<p class="text-red-600 text-center py-8">Error loading vaccination report details.</p>';
        });
}

function displayVaccinationDetails(report) {
    const modalContent = document.getElementById('vaccinationModalContent');
    
    modalContent.innerHTML = `
        <div class="space-y-6">
            <!-- Report Information -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Report Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Report ID</p>
                        <p class="font-medium text-gray-800">${report.report_number}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium text-gray-800">${report.status}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vaccination Date</p>
                        <p class="font-medium text-gray-800">${report.vaccination_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vaccination Time</p>
                        <p class="font-medium text-gray-800">${report.vaccination_time || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Next Vaccination</p>
                        <p class="font-medium text-gray-800">${report.next_vaccination_date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created At</p>
                        <p class="font-medium text-gray-800">${report.created_at}</p>
                    </div>
                </div>
            </div>

            <!-- Clinic Information -->
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Clinic Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Clinic Name</p>
                        <p class="font-medium text-gray-800">${report.clinic_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vaccine Brand</p>
                        <p class="font-medium text-gray-800">${report.vaccine_brand}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Batch Number</p>
                        <p class="font-medium text-gray-800">${report.vaccine_batch_number || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vaccination Type</p>
                        <p class="font-medium text-gray-800">${report.vaccination_type}</p>
                    </div>
                </div>
            </div>

            <!-- Pet Information -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Pet Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Pet Name</p>
                        <p class="font-medium text-gray-800">${report.pet_name || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Species</p>
                        <p class="font-medium text-gray-800">${report.pet_species}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Breed</p>
                        <p class="font-medium text-gray-800">${report.pet_breed || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Age</p>
                        <p class="font-medium text-gray-800">${report.pet_age ? report.pet_age + ' years' : 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Gender</p>
                        <p class="font-medium text-gray-800">${report.pet_gender}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Color</p>
                        <p class="font-medium text-gray-800">${report.pet_color || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Weight</p>
                        <p class="font-medium text-gray-800">${report.weight ? report.weight + ' kg' : 'N/A'}</p>
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Owner Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Owner Name</p>
                        <p class="font-medium text-gray-800">${report.patient_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact</p>
                        <p class="font-medium text-gray-800">${report.patient_contact || 'N/A'}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="font-medium text-gray-800">${report.patient_address || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Barangay</p>
                        <p class="font-medium text-gray-800">${report.barangay}</p>
                    </div>
                </div>
            </div>

            <!-- Observations & Notes -->
            ${report.observations || report.notes ? `
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">Additional Information</h4>
                ${report.observations ? `
                <div class="mb-3">
                    <p class="text-sm text-gray-600">Observations</p>
                    <p class="text-gray-800 whitespace-pre-wrap">${report.observations}</p>
                </div>
                ` : ''}
                ${report.notes ? `
                <div>
                    <p class="text-sm text-gray-600">Notes</p>
                    <p class="text-gray-800 whitespace-pre-wrap">${report.notes}</p>
                </div>
                ` : ''}
            </div>
            ` : ''}
        </div>
    `;
}

function closeVaccinationModal() {
    document.getElementById('vaccinationModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('vaccinationModal');
    if (event.target == modal) {
        closeVaccinationModal();
    }
}
</script>
@endsection