@extends('layouts.admin')

@section('title', 'Anti-Rabies Vaccination Appointments')
@section('header', 'Anti-Rabies Vaccination Appointments')
@section('subheader', 'Manage and track vaccination appointment schedules')

@php
$routePrefix = request()->routeIs('city-vet.*') ? 'city-vet' : (request()->routeIs('super-admin.*') ? 'super-admin' : 'admin');
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Appointments</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['pending'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Approved</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['approved'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Completed</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['completed'] }}</p>
            </div>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Vaccination Appointments</h3>
                <p class="text-sm text-gray-500">Search and filter vaccination appointments</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="appointmentSearchInput" value="{{ request('search') }}" placeholder="Search pet, owner, vet, status..."
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
            <button type="button" id="clearAppointmentFiltersBtn" onclick="clearAppointmentFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="appointmentsTableContainer">
            @include('dashboard.partials.vaccination-appointments-table')
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="appointmentsPagination">
            {{ $appointments->links() }}
        </div>
        <div id="appointmentsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="appointmentsEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-calendar-x text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Appointments Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalTitle">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="appointmentModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentModalTitle">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editAppointmentModalBody">
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
const appointmentFilterUrl = `{{ route($routePrefix . '.vaccination-appointments.filter') }}`;

function escapeHtml(str) {
    if (str == null) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

    function getStatusBadgeClasses(status) {
        const map = {
            'pending': 'bg-yellow-100 text-yellow-700',
            'approved': 'bg-blue-100 text-blue-700',
            'completed': 'bg-green-100 text-green-700',
            'cancelled': 'bg-red-100 text-red-700',
            'no_show': 'bg-gray-100 text-gray-700',
        };
        return map[status.toLowerCase()] || 'bg-gray-100 text-gray-700';
    }

function getAppointmentFilterParams() {
    return {
        search: document.getElementById('appointmentSearchInput').value,
        date_from: document.getElementById('dateFrom').value,
        date_to: document.getElementById('dateTo').value,
    };
}

function applyAppointmentFilters() {
    const params = getAppointmentFilterParams();
    const tableContainer = document.getElementById('appointmentsTableContainer');
    const paginationContainer = document.getElementById('appointmentsPagination');
    const loadingEl = document.getElementById('appointmentsLoading');
    const emptyState = document.getElementById('appointmentsEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${appointmentFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering appointments:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearAppointmentFilters() {
    document.getElementById('appointmentSearchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    updateClearAppointmentFiltersVisibility();
    applyAppointmentFilters();
}

function updateClearAppointmentFiltersVisibility() {
    const searchInput = document.getElementById('appointmentSearchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const clearBtn = document.getElementById('clearAppointmentFiltersBtn');

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

document.getElementById('appointmentSearchInput').addEventListener('input', () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        updateClearAppointmentFiltersVisibility();
        applyAppointmentFilters();
    }, 300);
});

document.getElementById('dateFrom').addEventListener('change', () => {
    updateClearAppointmentFiltersVisibility();
    applyAppointmentFilters();
});

document.getElementById('dateTo').addEventListener('change', () => {
    updateClearAppointmentFiltersVisibility();
    applyAppointmentFilters();
});

document.getElementById('appointmentsPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${appointmentFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('appointmentsTableContainer').innerHTML = data.html;
            document.getElementById('appointmentsPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading appointments page:', error);
    });
});

function viewAppointment(appointmentId) {
    const modalEl = document.getElementById('appointmentModal');
    const modalBody = document.getElementById('appointmentModalBody');
    const modal = new bootstrap.Modal(modalEl);

    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-green-600" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();

    fetch(`{{ route($routePrefix . '.vaccination-appointments.show-json', ':id') }}`.replace(':id', appointmentId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAppointmentDetails(data.appointment);
            } else {
                modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
            }
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
        });
}

function displayAppointmentDetails(appointment) {
    const modalBody = document.getElementById('appointmentModalBody');

    const statusBadgeClass = getStatusBadgeClasses(appointment.status);

    modalBody.innerHTML = `
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Appointment ID</p>
                    <p class="text-lg font-semibold text-gray-800">#${escapeHtml(appointment.id)}</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusBadgeClass}">
                        ${escapeHtml(appointment.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()))}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Scheduled At</p>
                        <p class="font-medium text-gray-800 mt-1">Date: ${escapeHtml(appointment.scheduled_at_date || '')}</p>
                        <p class="font-medium text-gray-800">Time: ${escapeHtml(appointment.scheduled_at_time || '')}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Submitted At</p>
                        <p class="font-medium text-gray-800 mt-1">Date: ${escapeHtml(appointment.created_at_date || '')}</p>
                        <p class="font-medium text-gray-800">Time: ${escapeHtml(appointment.created_at_time || '')}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Last Anti-Rabies Vaccination</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.last_anti_rabies_date)}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Recent Surgery</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.recent_surgery)}</p>
                    </div>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Owner Information</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Owner Name</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.owner_name)}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.owner_contact)}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.owner_email)}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium text-gray-800 mt-1">${escapeHtml(appointment.address)}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function updateStatus(appointmentId, newStatus) {
    if (!confirm(`Are you sure you want to change the status to "${newStatus.replace('_', ' ').toUpperCase()}"?`)) {
        return;
    }

    const url = `{{ route($routePrefix . '.vaccination-appointments.update-status', ['appointment' => ':id']) }}`.replace(':id', appointmentId);

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
            const modalEl = document.getElementById('appointmentModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            applyAppointmentFilters();
        } else {
            alert('Failed to update status. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status. Please try again.');
    });
}

function approveAppointment(appointmentId) {
    updateStatus(appointmentId, 'approved');
}

function editAppointment(appointmentId) {
    const modalEl = document.getElementById('editAppointmentModal');
    const modalBody = document.getElementById('editAppointmentModalBody');
    const modal = new bootstrap.Modal(modalEl);

    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-green-600" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();

    const url = `{{ route($routePrefix . '.vaccination-appointments.edit', ':id') }}`.replace(':id', appointmentId);

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment data.</div>';
            return;
        }

        const a = data.appointment;
        const vetOptions = (a.vets || []).map(vet => {
            const selected = a.assigned_vet == vet.id ? 'selected' : '';
            return `<option value="${escapeHtml(vet.id)}" ${selected}>${escapeHtml(vet.name)}</option>`;
        }).join('');

        modalBody.innerHTML = `
            <form id="editAppointmentForm" onsubmit="submitEditForm(event, ${escapeHtml(a.id)})">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled At</label>
                        <input type="datetime-local" name="scheduled_at" value="${escapeHtml(a.scheduled_at || '')}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="pending" ${a.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="approved" ${a.status === 'approved' ? 'selected' : ''}>Approved</option>
                            <option value="completed" ${a.status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="cancelled" ${a.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            <option value="no_show" ${a.status === 'no_show' ? 'selected' : ''}>No Show</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Veterinarian</label>
                        <select name="assigned_vet"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">N/A</option>
                            ${vetOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Anti-Rabies Vaccination</label>
                        <input type="date" name="last_anti_rabies_date" value="${escapeHtml(a.last_anti_rabies_date || '')}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Recent Surgery</label>
                        <select name="recent_surgery" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="0" ${a.recent_surgery ? '' : 'selected'}>No</option>
                            <option value="1" ${a.recent_surgery ? 'selected' : ''}>Yes</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        `;
    })
    .catch(() => {
        modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment data.</div>';
    });
}

function submitEditForm(event, appointmentId) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const data = {
        scheduled_at: formData.get('scheduled_at'),
        status: formData.get('status'),
        last_anti_rabies_date: formData.get('last_anti_rabies_date') || null,
        recent_surgery: formData.get('recent_surgery') === '1',
        assigned_vet: formData.get('assigned_vet') || null,
    };

    const url = `{{ route($routePrefix . '.vaccination-appointments.update', ':id') }}`.replace(':id', appointmentId);

    fetch(url, {
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            const modalEl = document.getElementById('editAppointmentModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            applyAppointmentFilters();
        } else {
            alert('Failed to update appointment. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update appointment. Please try again.');
    });
}

updateClearAppointmentFiltersVisibility();
</script>
@endsection
