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

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="GET" action="{{ route('admin.system-logs.index') }}" class="flex flex-wrap gap-4 items-end">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="flex items-center relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Description or IP..." class="flex-1 pl-3 pr-8 py-2 border border-gray-300 rounded-lg rounded-r-none text-sm outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 h-10">
                <button type="submit" class="px-3 py-2 border border-gray-300 border-l-0 rounded-lg rounded-l-none bg-gray-50 text-gray-500 hover:text-green-600 hover:bg-green-50 transition-colors h-10 flex items-center justify-center">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Module Filter -->
        <div class="relative min-w-max">
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
        <div class="relative min-w-max">
            <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
            <select name="action" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                <option value="">All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div class="relative min-w-max">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                <option value="">All Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <!-- Date Range -->
        <div class="flex gap-4">
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
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-funnel mr-1"></i> Filter
            </button>
            <a href="{{ route('admin.system-logs.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 transition">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">When</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->user_id ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="bi bi-person text-blue-600"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-800">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $log->action }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->module }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 truncate max-w-xs block">{{ Str::limit($log->description, 50) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $log->ip_address ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->status == 'success')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="bi bi-check-circle mr-1"></i> Success
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle mr-1"></i> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($log->log_id)
                            <a href="{{ route('admin.system-logs.show', $log->log_id) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
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
@endsection
