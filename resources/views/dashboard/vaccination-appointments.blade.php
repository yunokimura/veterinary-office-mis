@extends('layouts.admin')

@section('title', 'Anti-Rabies Vaccination Appointments')

@section('header', 'Anti-Rabies Vaccination Appointments')
@section('subheader', 'Manage and track vaccination appointment schedules')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Vaccination Appointments</h1>
                <p class="text-gray-500 mt-1">Manage and track anti-rabies vaccination appointment schedules</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Appointments</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-calendar-check text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Pending</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Approved</p>
                    <p class="text-xl md:text-2xl font-bold text-blue-600">{{ $stats['approved'] }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Completed</p>
                    <p class="text-xl md:text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-10 h-10 md:w-11 md:h-11 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-all text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <form method="GET" action="{{ route('admin.vaccination-appointments.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Owner</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by owner name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <!-- Buttons -->
                <div class="md:col-span-3 flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-funnel mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.vaccination-appointments.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="bi bi-arrow-counterclockwise mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pets</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $appointment->owner_name }}</div>
                            <div class="text-xs text-gray-500">by {{ $appointment->user->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            @php
                                $pets = $appointment->selected_pets ?? [];
                                $petNames = array_slice($pets, 0, 2);
                                $petCount = count($pets);
                            @endphp
                            @if(count($petNames) > 0)
                                <div class="text-sm">
                                    {{ implode(', ', array_column($petNames, 'name')) }}
                                    @if($petCount > 2)
                                        <span class="text-gray-400">+{{ $petCount - 2 }} more</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $appointment->owner->contact_number ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'no_show' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $appointment->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewAppointment({{ $appointment->id }})" 
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition" 
                                        title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <i class="bi bi-calendar-x text-4xl mb-2 block"></i>
                            No vaccination appointments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($appointments->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="appointmentDetails">
                    <!-- Details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let appointmentModal;

document.addEventListener('DOMContentLoaded', function() {
    appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
});

function viewAppointment(appointmentId) {
    const url = `{{ route('admin.vaccination-appointments.show-json', ['appointment' => ':id']) }}`.replace(':id', appointmentId);
    
    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const appointment = data.appointment;
            const pets = appointment.selected_pets || [];
            
            let petsHtml = '';
            if (pets.length > 0) {
                petsHtml = '<ul class="list-disc list-inside space-y-1">';
                pets.forEach(pet => {
                    petsHtml += `<li><strong>${pet.name || 'N/A'}</strong> - ${pet.species || 'N/A'} (${pet.breed || 'N/A'})</li>`;
                });
                petsHtml += '</ul>';
            } else {
                petsHtml = '<p class="text-gray-500">No pets specified</p>';
            }

            const html = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Status:</label>
                        <div id="currentStatus">
                            <span class="badge bg-${getStatusColor(appointment.status)} fs-6">${appointment.status}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Scheduled At:</label>
                        <p class="mb-0">${appointment.scheduled_at}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Owner Name:</label>
                        <p class="mb-0">${appointment.owner_name}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Contact Number:</label>
                        <p class="mb-0">${appointment.owner_contact}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Email:</label>
                        <p class="mb-0">${appointment.owner_email}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Address:</label>
                        <p class="mb-0">${appointment.address}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Last Anti-Rabies Vaccination:</label>
                        <p class="mb-0">${appointment.last_anti_rabies_date}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Recent Surgery:</label>
                        <p class="mb-0">${appointment.recent_surgery}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Submitted By:</label>
                        <p class="mb-0">${appointment.submitted_by}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-gray-700">Submitted At:</label>
                        <p class="mb-0">${appointment.created_at}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-gray-700 d-block mb-2">Selected Pets:</label>
                    ${petsHtml}
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-12">
                        <label class="fw-bold text-gray-700 d-block mb-2">Update Status:</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button onclick="updateStatus(${appointment.id}, 'approved')" class="btn btn-sm btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Approve
                            </button>
                            <button onclick="updateStatus(${appointment.id}, 'completed')" class="btn btn-sm btn-success">
                                <i class="bi bi-check-all me-1"></i> Complete
                            </button>
                            <button onclick="updateStatus(${appointment.id}, 'cancelled')" class="btn btn-sm btn-danger">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </button>
                            <button onclick="updateStatus(${appointment.id}, 'no_show')" class="btn btn-sm btn-secondary">
                                <i class="bi bi-person-x me-1"></i> No Show
                            </button>
                            <button onclick="updateStatus(${appointment.id}, 'pending')" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset to Pending
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('appointmentDetails').innerHTML = html;
            appointmentModal.show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load appointment details. Please try again.');
    });
}

function updateStatus(appointmentId, newStatus) {
    if (!confirm(`Are you sure you want to change the status to "${newStatus.replace('_', ' ').toUpperCase()}"?`)) {
        return;
    }

    const url = `{{ route('admin.vaccination-appointments.update-status', ['appointment' => ':id']) }}`.replace(':id', appointmentId);
    
    fetch(url, {
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            appointmentModal.hide();
            location.reload();
        } else {
            alert('Failed to update status. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status. Please try again.');
    });
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'approved': 'info',
        'completed': 'success',
        'cancelled': 'danger',
        'no_show': 'secondary'
    };
    return colors[status.toLowerCase()] || 'secondary';
}
</script>
@endpush