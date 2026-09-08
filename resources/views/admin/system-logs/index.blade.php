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

    <form method="GET" action="{{ route('admin.system-logs.index') }}" class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user or IP..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
        </div>
        <div class="flex gap-2">
            <select name="module" onchange="this.closest('form').submit()" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Modules</option>
                @foreach($modules as $module)
                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>{{ $module }}</option>
                @endforeach
            </select>
            <select name="action" onchange="this.closest('form').submit()" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.closest('form').submit()" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full table-fixed">
            <colgroup>
                <col class="w-[4%]">
                <col class="w-[18%]">
                <col class="min-w-[220px]">
                <col class="w-[13%]">
                <col class="w-[25%]">
                <col class="w-[10%]">
                <col class="w-[10%]">
            </colgroup>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 z-20 bg-gray-50 border-r border-gray-200">ID</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">User</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[220px]">Action</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date & Time</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">IP Address</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="log-row hover:bg-gray-50 cursor-pointer" data-log-id="{{ $log->id }}">
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] sticky left-0 z-10 border-r border-gray-200 bg-white hover:bg-gray-50">{{ $log->user_id ?? '-' }}</td>
                        <td class="px-4 py-[18px] whitespace-nowrap hidden md:table-cell">
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <div class="inline-flex w-8 h-8 min-w-[32px] items-center justify-center rounded-full bg-[#e8f0fe]">
                                    <i class="bi bi-person text-blue-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800 leading-[1.5] whitespace-nowrap overflow-hidden text-ellipsis">{{ $log->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-700 leading-[1.5] min-w-[220px]">
                            <span class="inline-flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $log->module_display }}
                                </span>
                                <span>{{ $log->action_display }}</span>
                            </span>
                        </td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] hidden md:table-cell">{{ $log->created_at }}</td>
                        <td class="px-4 py-[18px] hidden md:table-cell">
                            <span class="text-sm text-gray-600 whitespace-nowrap overflow-hidden text-ellipsis block leading-[1.5]" title="{{ $log->description }}">{{ Str::limit($log->description, 50) }}</span>
                        </td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 font-mono leading-[1.5] hidden md:table-cell">{{ $log->ip_address ?? 'N/A' }}</td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm leading-[1.5]">
                            @if($log->status == 'success')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="bi bi-check-circle mr-1"></i> Success
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle mr-1"></i> Failed
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No system logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $logs->onEachSide(2)->appends(request()->query())->links('vendor.pagination.custom') }}
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
</script>
@endpush
@endsection
