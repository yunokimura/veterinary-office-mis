@extends('layouts.admin')

@section('title', 'System Logs')
@section('header', 'System Logs')
@auth
@if(auth()->user()->hasRole('super_admin'))
@section('subheader', 'Track all user activities and system events')
@endif
@endauth

@section('content')
<!-- Export CSV Button -->
<div class="mb-6">
    <a href="{{ route('admin.system-logs.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
        <i class="bi bi-download mr-2"></i> Export CSV
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
            <i class="bi bi-journal-text text-blue-600 text-base"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Total Logs</p>
            <p class="text-xl font-semibold text-gray-800">{{ $totalLogs }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
            <i class="bi bi-check-circle text-green-600 text-base"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Successful Actions</p>
            <p class="text-xl font-semibold text-gray-800">{{ $successfulActions }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
            <i class="bi bi-x-circle text-red-600 text-base"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Failed Actions</p>
            <p class="text-xl font-semibold text-gray-800">{{ $failedActions }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
            <i class="bi bi-people text-purple-600 text-base"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Active Users Today</p>
            <p class="text-xl font-semibold text-gray-800">{{ $activeUsersToday }}</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="GET" action="{{ route('admin.system-logs.index') }}" class="flex flex-wrap gap-4 items-end">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="flex items-center relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="User or IP" class="flex-1 pl-3 pr-8 py-2 border border-gray-300 rounded-lg rounded-r-none text-sm outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 h-10">
                <button type="submit" class="px-3 py-2 border border-gray-300 border-l-0 rounded-lg rounded-l-none bg-gray-50 text-gray-500 hover:text-green-600 hover:bg-green-50 transition-colors h-10 flex items-center justify-center">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Module Filter -->
        <div class="relative min-w-max w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Module</label>
            <select name="module" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                <option value="">All Modules</option>
                @foreach($modules as $module)
                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>{{ $module }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Filter -->
        <div class="relative min-w-max w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
            <select name="action" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                <option value="">All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date Range -->
        <div class="flex gap-4">
            <div class="relative min-w-max w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                    <option value="">All Status</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex items-end">
            <a href="{{ route('admin.system-logs.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 transition">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-hidden">
        <table class="w-full table-fixed">
            <colgroup>
                <col class="w-[4%]">
                <col class="w-[18%]">
                <col class="w-[10%]">
                <col class="w-[13%]">
                <col class="w-[12%]">
                <col class="w-[23%]">
                <col class="w-[10%]">
                <col class="w-[10%]">
            </colgroup>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 z-20 bg-gray-50 border-r border-gray-200">ID</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">User</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date & Time</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Module</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">IP Address</th>
                    <th class="px-4 py-[18px] text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                    <tr class="log-row hover:bg-gray-50 cursor-pointer group" data-log-id="{{ $log->id }}">
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] sticky left-0 z-10 border-r border-gray-200 bg-white group-hover:bg-gray-50">{{ $log->user_id ?? '-' }}</td>
                        <td class="px-4 py-[18px] whitespace-nowrap hidden md:table-cell">
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <div class="inline-flex w-8 h-8 min-w-[32px] items-center justify-center rounded-full bg-[#e8f0fe]">
                                    <i class="bi bi-person text-blue-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800 leading-[1.5] whitespace-nowrap overflow-hidden text-ellipsis">{{ $log->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-700 leading-[1.5]">{{ $log->action }}</td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] hidden md:table-cell">{{ $log->created_at }}</td>
                        <td class="px-4 py-[18px] whitespace-nowrap text-sm text-gray-600 leading-[1.5] hidden md:table-cell" title="{{ $log->module }}">{{ $log->module }}</td>
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
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-3 block"></i>
                            No system logs found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $logs->appends(request()->query())->links() }}
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
                                    <p class="text-sm text-gray-500">Action</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.action}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Module</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.module}</p>
                                </div>
                            </div>
                            <hr class="border-gray-100">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Record ID</p>
                                    <p class="font-medium text-gray-800 mt-1">${data.record_id}</p>
                                </div>
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
