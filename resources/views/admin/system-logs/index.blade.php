@extends('layouts.admin')

@section('title', 'System Logs')
@section('header', 'System Logs')
@auth
@if(auth()->user()->hasRole('super_admin'))
@section('subheader', 'Track all user activities and system events')
@endif
@endauth

@section('content')

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div>
            <p class="text-xs font-medium text-gray-500">Total Logs</p>
            <p class="text-xl font-semibold text-gray-800">{{ $totalLogs }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div>
            <p class="text-xs font-medium text-gray-500">Successful Actions</p>
            <p class="text-xl font-semibold text-gray-800">{{ $successfulActions }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div>
            <p class="text-xs font-medium text-gray-500">Failed Actions</p>
            <p class="text-xl font-semibold text-gray-800">{{ $failedActions }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div>
            <p class="text-xs font-medium text-gray-500">Active Users Today</p>
            <p class="text-xl font-semibold text-gray-800">{{ $activeUsersToday }}</p>
        </div>
    </div>
</div>

<!-- Logs Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">System Logs</h3>
            <p class="text-sm text-gray-500">Track all user activities and system events</p>
        </div>
        <a href="{{ route('admin.system-logs.export', request()->query()) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
            <i class="bi bi-download mr-2"></i> Export CSV
        </a>
    </div>

    <!-- Search & Filters -->
    <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
        <div class="relative w-96">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="systemLogSearch" value="{{ request('search') }}" placeholder="Search by user, IP, date, module, action, or status..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            <button type="button" id="searchHelpBtn"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                    data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus click"
                    data-bs-html="true"
                    data-bs-content="
                        <div class='text-sm text-gray-700 space-y-1'>
                            <div><strong>Examples:</strong></div>
                            <div>John <span class='text-gray-400'>(User)</span></div>
                            <div>127.0.0.1 <span class='text-gray-400'>(IP)</span></div>
                            <div>Success <span class='text-gray-400'>(Status)</span></div>
                            <div>Auth <span class='text-gray-400'>(Module)</span></div>
                        </div>
                    ">
                <i class="bi bi-info-circle"></i>
            </button>
        </div>
        <div class="flex gap-2 items-center">
            <select id="systemLogTimeFilter" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Time</option>
                <option value="today" {{ request('time_filter') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="yesterday" {{ request('time_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                <option value="week" {{ request('time_filter') == 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ request('time_filter') == 'month' ? 'selected' : '' }}>This Month</option>
            </select>
            <button type="button" id="clearSystemLogFiltersBtn" onclick="clearSystemLogFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>
    </div>

    <div class="overflow-x-auto" id="systemLogsTableContainer">
        @include('admin.system-logs.partials.table', ['logs' => $logs])
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200" id="systemLogsPagination">
        {{ $logs->onEachSide(2)->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
    <div id="systemLogsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
        <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
        Loading...
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Entry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="logModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('logDetailsModal');
    const modalBody = document.getElementById('logModalBody');
    const modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.log-row').forEach(row => {
        row.addEventListener('click', function(e) {
            const link = this.querySelector('a');
            if (link && e.target.closest('a')) return;

            const logId = this.dataset.logId;
            const url = "{{ route('admin.system-logs.modal', ['log' => '__ID__']) }}".replace('__ID__', logId);

            modalBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            modal.show();

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    const statusBadge = data.status === 'success'
                        ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><i class="bi bi-check-circle mr-1"></i> Success</span>'
                        : '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"><i class="bi bi-x-circle mr-1"></i> Failed</span>';

                    modalBody.innerHTML = `
                        <div class="space-y-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Log ID</p>
                                    <p class="text-lg font-semibold text-gray-800">#${data.log_id}</p>
                                </div>
                                <div>${statusBadge}</div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">User</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                            <i class="bi bi-person text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">${data.user}</p>
                                            <p class="text-sm text-gray-500">${data.role}</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">IP Address</p>
                                    <p class="font-mono text-gray-800 mt-1">${data.ip_address}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Event</p>
                                    <p class="font-medium text-gray-800 mt-1 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                ${data.module_display}
                                            </span>
                                            <span>${data.action_display}</span>
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Record ID</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.record_id}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Created At</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.created_at}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-gray-800 mt-1">${data.description}</p>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Time Elapsed</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.diff_for_humans}</p>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(() => {
                    modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load log details.</div>';
                });
        });
    });
});

let systemLogFilterDebounce;
const systemLogFilterUrl = window.location.pathname + '/filter';

function applySystemLogFilters(page = 1) {
    const search = document.getElementById('systemLogSearch')?.value || '';
    const timeFilter = document.getElementById('systemLogTimeFilter')?.value || '';

    const params = new URLSearchParams({
        search: search,
        time_filter: timeFilter,
        page: page
    });

    const tableContainer = document.getElementById('systemLogsTableContainer');
    const paginationContainer = document.getElementById('systemLogsPagination');
    const loadingEl = document.getElementById('systemLogsLoading');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    fetch(`${systemLogFilterUrl}?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (tableContainer) {
                    tableContainer.innerHTML = data.table_html;
                    tableContainer.style.opacity = '1';
                }
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                    paginationContainer.style.opacity = '1';
                }
            }
        })
        .catch(error => {
            console.error('Error filtering system logs:', error);
            if (tableContainer) tableContainer.style.opacity = '1';
            if (paginationContainer) paginationContainer.style.opacity = '1';
        })
        .finally(() => {
            if (loadingEl) loadingEl.classList.add('hidden');
        });
}

function clearSystemLogFilters() {
    const searchInput = document.getElementById('systemLogSearch');
    const timeFilterSelect = document.getElementById('systemLogTimeFilter');
    if (searchInput) searchInput.value = '';
    if (timeFilterSelect) timeFilterSelect.value = '';
    updateClearFiltersVisibility();
    applySystemLogFilters(1);
}

function updateClearFiltersVisibility() {
    const searchInput = document.getElementById('systemLogSearch');
    const timeFilterSelect = document.getElementById('systemLogTimeFilter');
    const clearBtn = document.getElementById('clearSystemLogFiltersBtn');
    
    const hasFilters = (searchInput && searchInput.value.trim() !== '') || 
                       (timeFilterSelect && timeFilterSelect.value !== '');
    
    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('logDetailsModal');
    const modalBody = document.getElementById('logModalBody');
    const modal = new bootstrap.Modal(modalEl);

    const searchHelpBtn = document.getElementById('searchHelpBtn');
    if (searchHelpBtn) {
        new bootstrap.Popover(searchHelpBtn);
    }

    document.querySelectorAll('.log-row').forEach(row => {
        row.addEventListener('click', function(e) {
            const link = this.querySelector('a');
            if (link && e.target.closest('a')) return;

            const logId = this.dataset.logId;
            const url = "{{ route('admin.system-logs.modal', ['log' => '__ID__']) }}".replace('__ID__', logId);

            modalBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            modal.show();

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    const statusBadge = data.status === 'success'
                        ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><i class="bi bi-check-circle mr-1"></i> Success</span>'
                        : '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"><i class="bi bi-x-circle mr-1"></i> Failed</span>';

                    modalBody.innerHTML = `
                        <div class="space-y-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Log ID</p>
                                    <p class="text-lg font-semibold text-gray-800">#${data.log_id}</p>
                                </div>
                                <div>${statusBadge}</div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">User</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                            <i class="bi bi-person text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">${data.user}</p>
                                            <p class="text-sm text-gray-500">${data.role}</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">IP Address</p>
                                    <p class="font-mono text-gray-800 mt-1">${data.ip_address}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Event</p>
                                    <p class="font-medium text-gray-800 mt-1 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                ${data.module_display}
                                            </span>
                                            <span>${data.action_display}</span>
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Record ID</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.record_id}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Created At</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.created_at}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-gray-800 mt-1">${data.description}</p>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Time Elapsed</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.diff_for_humans}</p>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(() => {
                    modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load log details.</div>';
                });
        });
    });

    const searchInput = document.getElementById('systemLogSearch');
    const timeFilterSelect = document.getElementById('systemLogTimeFilter');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(systemLogFilterDebounce);
            systemLogFilterDebounce = setTimeout(() => {
                updateClearFiltersVisibility();
                applySystemLogFilters(1);
            }, 300);
        });
    }

    if (timeFilterSelect) {
        timeFilterSelect.addEventListener('change', function() {
            updateClearFiltersVisibility();
            applySystemLogFilters(1);
        });
    }

    updateClearFiltersVisibility();

    const paginationContainer = document.getElementById('systemLogsPagination');
    if (paginationContainer) {
        paginationContainer.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            e.preventDefault();
            const url = new URL(link.href);
            const query = url.searchParams.toString();

            fetch(`${systemLogFilterUrl}?${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('systemLogsTableContainer').innerHTML = data.table_html;
                        document.getElementById('systemLogsPagination').innerHTML = data.pagination;
                    }
                })
                .catch(error => {
                    console.error('Error loading system logs page:', error);
                });
        });
    }
});
</script>
@endpush
@endsection
