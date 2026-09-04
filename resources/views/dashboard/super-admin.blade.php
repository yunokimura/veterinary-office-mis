@extends('layouts.admin')

@section('title', 'Dashboard - Super Admin')

@section('header', 'Super Admin Dashboard')
@section('subheader', 'System Administrator - Full System Access')

@section('content')
@php
    $deactivatedUsers = \App\Models\User::where('status', 'deactivated')->count();
    $scheduledAnnouncements = \App\Models\Announcement::where('status', 'Scheduled')->count();
@endphp

<!-- Alert Banner for Deactivated Users -->
@if($deactivatedUsers > 0)
<div class="bg-white border border-yellow-200 rounded-xl p-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center shrink-0">
            <i class="bi bi-exclamation-triangle text-yellow-600"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-800">Attention Required</p>
            <p class="text-xs text-gray-600">
                <span class="font-semibold">{{ $deactivatedUsers }}</span> deactivated user(s) in the system.
            </p>
        </div>
        <a href="{{ route('super-admin.users.index', ['status' => 'deactivated']) }}" 
           class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded-lg transition whitespace-nowrap">
            Review
        </a>
    </div>
</div>
@endif


<!-- Quick Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 items-stretch">
    <!-- Active Users -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 h-full flex flex-col">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 bg-teal-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="bi bi-person-check text-teal-600 text-lg md:text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500">ACTIVE USERS</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('status', 'active')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Currently active accounts</p>
                </div>
            </div>
        </div>

    <!-- New Users -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 h-full flex flex-col">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="bi bi-person-plus text-blue-600 text-lg md:text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500">NEW USERS</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered this month</p>
                </div>
            </div>
        </div>

    <!-- Scheduled Announcements -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 h-full flex flex-col">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="bi bi-megaphone text-amber-600 text-lg md:text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-medium text-amber-700">SCHEDULED ANNOUNCEMENTS</p>
                    <p class="text-xl md:text-3xl font-bold text-amber-700 mt-1">{{ \App\Models\Announcement::where('status', 'Scheduled')->count() }}</p>
                    <p class="text-xs text-amber-600 mt-1">Awaiting publication</p>
                </div>
            </div>
        </div>

    <!-- Failed Activities -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100 h-full flex flex-col">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                    <i class="bi bi-journal-text text-red-500 text-lg md:text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-medium text-red-600">FAILED ACTIVITIES</p>
                    <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ \App\Models\SystemLog::where('status', 'failed')->count() }}</p>
                    <p class="text-xs text-red-500 mt-1">Requires review</p>
                </div>
            </div>
        </div>
</div>

<!-- Quick Actions
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        Create User
        <a href="{{ route('super-admin.users.create') }}"
           class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New User</span>
        </a>

        New Announcement
        <a href="{{ route('super-admin.announcements.create') }}"
           class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Announcement</span>
        </a>

        System Logs
        <a href="{{ route('super-admin.system-logs.index') }}"
           class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-journal-text text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">System Logs</span>
        </a>
    </div>
</div>
-->

<!-- Analytics Overview -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6">
    <!-- System Activity Overview -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">System Activity Overview</h3>
        </div>
        <div class="h-64">
            <canvas id="systemActivityChart"></canvas>
        </div>
    </div>

    <!-- User Accounts by Role -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800">User Accounts by Role</h3>
        </div>
        <div class="h-64">
            <canvas id="userRoleChart"></canvas>
        </div>
    </div>
</div>

<!-- User Management Section
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="bi bi-people mr-2 text-blue-600"></i>User Management
        </h3>
        <a href="{{ route('super-admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
            View All <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>

    Stats Row
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
            <p class="text-xs text-blue-600 font-medium">Active Users</p>
            <p class="text-xl font-bold text-blue-700">{{ $stats['active_users'] ?? 0 }}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-3 border border-red-100">
            <p class="text-xs text-red-600 font-medium">Deactivated</p>
            <p class="text-xl font-bold text-red-700">{{ $stats['deactivated_users'] ?? 0 }}</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
            <p class="text-xs text-purple-600 font-medium">Admin Staff</p>
            <p class="text-xl font-bold text-purple-700">{{ $stats['admin_staff_total'] ?? 0 }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
            <p class="text-xs text-green-600 font-medium">Pet Owners</p>
            <p class="text-xl font-bold text-green-700">{{ $stats['total_clients'] ?? 0 }}</p>
        </div>
    </div>

    Recent Users Table
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('super-admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">No users yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
-->

<!-- Announcements Section
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="bi bi-megaphone mr-2 text-green-600"></i>Announcements
        </h3>
        <a href="{{ route('super-admin.announcements.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
            Manage All <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>

    Stats
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
            <p class="text-xs text-green-600 font-medium">Active</p>
            <p class="text-xl font-bold text-green-700">{{ \App\Models\Announcement::where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg p-3 border border-yellow-100">
            <p class="text-xs text-yellow-600 font-medium">Scheduled</p>
            <p class="text-xl font-bold text-yellow-700">{{ $scheduledAnnouncements }}</p>
        </div>
        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
            <p class="text-xs text-blue-600 font-medium">Total</p>
            <p class="text-xl font-bold text-blue-700">{{ \App\Models\Announcement::count() }}</p>
        </div>
    </div>

    Recent Announcements List
    <div class="divide-y divide-gray-100">
        @forelse(\App\Models\Announcement::latest()->take(5)->get() as $announcement)
            <div class="py-3 flex items-center justify-between hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-megaphone text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $announcement->title }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ $announcement->status }} - {{ $announcement->category }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400">{{ $announcement->created_at->format('M d, Y') }}</span>
                    <a href="{{ route('super-admin.announcements.edit', $announcement) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="py-8 text-center text-gray-500">
                <i class="bi bi-inbox text-3xl mb-2 block"></i>
                <p class="text-sm">No announcements yet</p>
            </div>
        @endforelse
    </div>
</div>
-->

<!-- System Health Section
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="bi bi-activity mr-2 text-gray-600"></i>System Health
        </h3>
        <a href="{{ route('super-admin.system-logs.index') }}" class="text-sm text-gray-600 hover:text-gray-800 font-medium">
            View Logs <i class="bi bi-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto -mx-4 md:mx-0">
        <table class="w-full min-w-[600px]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-3 md:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\SystemLog::with('user')->latest()->take(10)->get() as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm">{{ $log->user->name ?? 'System' }}</td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-700">{{ $log->action }}</td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-600">{{ $log->module }}</td>
                        <td class="px-3 md:px-4 py-3">
                            @if($log->status == 'success')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-3 text-xs md:text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-3 md:px-4 py-8 text-center text-gray-500 text-xs md:text-sm">No system logs yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
-->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // System Activity Overview Chart
    const systemActivityCtx = document.getElementById('systemActivityChart');
    if (systemActivityCtx) {
        const activityLabels = @json($systemActivityLabels ?? []);
        const successData = @json($systemActivitySuccess ?? []);
        const failedData = @json($systemActivityFailed ?? []);

        new Chart(systemActivityCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: activityLabels,
                datasets: [
                    {
                        label: 'Successful Activities',
                        data: successData,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Failed Activities',
                        data: failedData,
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, pointStyle: 'circle' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // User Accounts by Role Chart
    const userRoleCtx = document.getElementById('userRoleChart');
    if (userRoleCtx) {
        const roleLabels = @json($userRoleLabels ?? []);
        const roleData = @json($userRoleData ?? []);
        const roleColors = @json($userRoleColors ?? []);

        new Chart(userRoleCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: roleColors,
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.parsed;
                                const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                return ` ${context.label}: ${value} (${pct}%)`;
                            }
                        }
                    }
                },
                cutout: '60%',
            }
        });
    }
});
</script>
@endpush
@endsection
