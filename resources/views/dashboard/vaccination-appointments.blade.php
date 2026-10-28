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
<div id="appointmentModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <i data-lucide="calendar-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Appointment Details</h2>
                    <p class="text-xs text-slate-400">ID: <span id="appointmentModalId" class="font-mono font-semibold text-slate-600">#APT-2026-0010</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span id="appointmentModalStatus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"></span>
                <button onclick="toggleModal(false)" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-6 space-y-5 overflow-y-auto bg-white max-h-[calc(90vh-140px)]">
            <div id="appointmentModalContent">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading appointment details...</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer / Actions -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button onclick="window.print()" class="w-full sm:w-auto px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                    <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                    <span>Print</span>
                </button>
                <button onclick="toast('Downloading PDF summary...')" class="w-full sm:w-auto px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Export</span>
                </button>
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button onclick="toggleModal(false)" class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors">
                    Close
                </button>
                <button onclick="toast('Opening reschedule dialog...')" class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg shadow-sm transition-colors">
                    Reschedule
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast" class="fixed bottom-5 right-5 bg-slate-900 text-white text-xs px-4 py-2.5 rounded-lg shadow-xl opacity-0 translate-y-2 transition-all duration-200 pointer-events-none flex items-center space-x-2 z-50">
    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
    <span id="toastMsg">Notification message</span>
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
    const modalBackdrop = document.getElementById('appointmentModalBackdrop');
    const modalContent = document.getElementById('appointmentModalContent');

    modalContent.innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
            <p class="text-slate-500 text-sm">Loading appointment details...</p>
        </div>
    `;
    modalBackdrop.classList.remove('hidden');
    setTimeout(() => {
        modalBackdrop.classList.remove('opacity-0');
    }, 10);

    fetch(`{{ route($routePrefix . '.vaccination-appointments.show-json', ':id') }}`.replace(':id', appointmentId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAppointmentDetails(data.appointment);
            } else {
                modalContent.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
            }
        })
        .catch(() => {
            modalContent.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
        });
}

function displayAppointmentDetails(appointment) {
    const modalBackdrop = document.getElementById('appointmentModalBackdrop');
    const modalContent = document.getElementById('appointmentModalContent');
    const modalIdEl = document.getElementById('appointmentModalId');
    const modalStatusEl = document.getElementById('appointmentModalStatus');

    const paddedId = String(appointment.id).padStart(4, '0');
    const appointmentDisplayId = 'APT-2026-' + paddedId;

    if (modalIdEl) modalIdEl.textContent = '#' + appointmentDisplayId;

    const statusBadgeClass = getStatusBadgeClasses(appointment.status);
    const statusLabel = appointment.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    if (modalStatusEl) {
        modalStatusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border ' + statusBadgeClass;
        modalStatusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5 animate-pulse"></span>${escapeHtml(statusLabel)}`;
    }

    const rabiesValue = appointment.last_anti_rabies_date;
    const rabiesDisplay = (!rabiesValue || rabiesValue === 'N/A' || rabiesValue === '') ? 'First Time/No History' : escapeHtml(rabiesValue);

    const surgeryValue = appointment.recent_surgery;
    const surgeryDisplay = (surgeryValue === 1 || surgeryValue === '1' || surgeryValue === true) ? 'Yes' : 'No';

    modalContent.innerHTML = `
        <div class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 flex items-start space-x-3.5">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Scheduled At</span>
                        <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(appointment.scheduled_at_date || '')}</p>
                        <p class="text-xs text-slate-500">${escapeHtml(appointment.scheduled_at_time || '')}</p>
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 flex items-start space-x-3.5">
                    <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-lg shrink-0">
                        <i data-lucide="file-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Submitted On</span>
                        <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(appointment.created_at_date || '')}</p>
                        <p class="text-xs text-slate-500">${escapeHtml(appointment.created_at_time || '')}</p>
                    </div>
                </div>
            </div>
            <div class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/40">
                <h3 class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Medical Summary</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                            <i data-lucide="syringe" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Anti-Rabies Vaccination</p>
                            <p class="text-sm font-semibold text-slate-700">${rabiesDisplay}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Recent Surgery</p>
                            <p class="text-sm font-semibold text-slate-700">${surgeryDisplay}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/30 p-5">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-emerald-100/80">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="user" class="w-4 h-4 text-emerald-600"></i>
                        <h3 class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Owner Information</h3>
                    </div>
                    <span class="text-[11px] text-emerald-700 bg-emerald-100/70 px-2 py-0.5 rounded-md font-medium">Verified Pet Owner</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Owner Name</span>
                        <span class="font-semibold text-slate-800">${escapeHtml(appointment.owner_name)}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Contact Number</span>
                        <div class="flex items-center space-x-2">
                            <a href="tel:${escapeHtml(appointment.owner_contact)}" class="font-semibold text-slate-800 hover:text-emerald-600 transition-colors">
                                ${escapeHtml(appointment.owner_contact)}
                            </a>
                            <button onclick="copyToClipboard('${escapeHtml(appointment.owner_contact)}')" class="text-slate-400 hover:text-emerald-600 p-1 transition-colors" title="Copy Number">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-xs text-slate-400 block mb-0.5">Email Address</span>
                        <div class="flex items-center space-x-2">
                            <a href="mailto:${escapeHtml(appointment.owner_email)}" class="font-semibold text-emerald-600 hover:underline">
                                ${escapeHtml(appointment.owner_email)}
                            </a>
                            <button onclick="copyToClipboard('${escapeHtml(appointment.owner_email)}')" class="text-slate-400 hover:text-emerald-600 p-1 transition-colors" title="Copy Email">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sm:col-span-2 pt-2 border-t border-emerald-100/80">
                        <span class="text-xs text-slate-400 block mb-0.5">Complete Address</span>
                        <div class="flex items-start space-x-1.5 text-slate-700">
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 shrink-0 mt-0.5"></i>
                            <span class="font-medium text-slate-700">${escapeHtml(appointment.address)}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    lucide.createIcons();
}

function toggleModal(show) {
    const backdrop = document.getElementById('appointmentModalBackdrop');
    if (show) {
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
        }, 10);
    } else {
        backdrop.classList.add('opacity-0');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 200);
    }
}

function copyToClipboard(text) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    toast(`Copied "${text}" to clipboard!`);
}

function toast(message) {
    const toastEl = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    toastMsg.innerText = message;
    toastEl.classList.remove('opacity-0', 'translate-y-2');
    toastEl.classList.add('opacity-100', 'translate-y-0');
    setTimeout(() => {
        toastEl.classList.remove('opacity-100', 'translate-y-0');
        toastEl.classList.add('opacity-0', 'translate-y-2');
    }, 3000);
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

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush
@endsection
