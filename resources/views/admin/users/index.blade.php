@extends('layouts.admin')

@section('title', 'User Management')

@section('header', 'User Management')
@section('subheader', 'Manage system users and permissions')

@section('content')
@php
    // Get all roles for dropdown
    $roles = \Spatie\Permission\Models\Role::where('guard_name', 'web')->orderBy('name')->pluck('name')->toArray();

    // Stats based on actual Spatie role assignments
    $stats = [
        'total_users' => \App\Models\User::count(),
        'admins' => \App\Models\User::role(['super_admin', 'city_vet'])->count(),
        'staff' => \App\Models\User::role(['admin_staff', 'assistant_vet', 'livestock_inspector', 'meat_inspector'])->count(),
        'pet_owners' => \App\Models\User::role('pet_owner')->count(),
        'active' => \App\Models\User::where('status', 'active')->count(),
        'deactivated' => \App\Models\User::where('status', 'deactivated')->count(),
    ];
@endphp

<!-- Quick Actions -->
@can('create-users')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <i class="bi bi-person-plus"></i> Add User
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Add User</span>
        </a>

        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list-ul text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">View All</span>
        </a>
    </div>
</div>
@endcan

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-people text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Admins</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['admins'] }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-shield-check text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Staff</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['staff'] }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-person-badge text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pet Owners</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['pet_owners'] }}</p>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-person text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Add User</span>
        </a>

        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list-ul text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">View All</span>
        </a>
    </div>
</div>
@endcan

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-4">
            <!-- Search -->
            <div class="relative">
                <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <!-- Filter by Role -->
            <div class="relative min-w-max">
                <select name="role" onchange="this.form.submit()" class="px-4 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $r)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                @switch($user->getRoleAttribute())
                                    @case('super_admin') bg-red-100 text-red-800 @break
                                    @case('city_vet') bg-blue-100 text-blue-800 @break
                                    @case('admin_staff') bg-green-100 text-green-800 @break
                                    @case('assistant_vet') bg-purple-100 text-purple-800 @break
                                    @case('livestock_inspector') bg-yellow-100 text-yellow-800 @break
                                    @case('meat_inspector') bg-orange-100 text-orange-800 @break
                                    @case('pet_owner') bg-pink-100 text-pink-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ str_replace('_', ' ', $user->getRoleAttribute()) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->barangay?->barangay_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Deactivated</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <!-- View Button - Everyone can view -->
                                <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <!-- Edit Button - Check permission -->
                                @can('update', $user)
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                
                                <!-- Delete Button - Check permission -->
                                @can('delete', $user)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                                
                                <!-- Toggle Status Button - Check permission -->
                                @can('toggleStatus', $user)
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi bi-{{ $user->status === 'active' ? 'person-dash' : 'person-check' }}"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="bi bi-people text-4xl mb-2 block"></i>
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
