@extends('layouts.admin')

@section('title', 'User Management')
@section('header', 'User Management')
@section('subheader', 'Manage system users and roles')

@section('content')
@php
    $roleLabels = [
        'super_admin'           => 'Super Admin',
        'city_vet'              => 'City Veterinarian (Admin)',
        'assistant_vet'         => 'Assistant Veterinarian',
        'admin_asst'            => 'Administrative Assistant',
        'livestock_inspector'   => 'Livestock & Poultry Inspector',
        'meat_inspector'        => 'Meat Inspector',
        'clinic'                => 'Veterinary Clinic',
        'hospital'              => 'Hospital',
        'pet_owner'             => 'Pet Owner',
    ];

    // Hierarchical role order (used to sort $roles)
    $roleOrder = [
        'super_admin',
        'city_vet',
        'assistant_vet',
        'admin_asst',
        'livestock_inspector',
        'meat_inspector',
        'clinic',
        'hospital',
        'pet_owner',
    ];

    // Sort roles by hierarchical order
    usort($roles, fn($a, $b) => array_search($a, $roleOrder) - array_search($b, $roleOrder));

    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'deactivated' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<div class="space-y-6">
    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form method="GET" action="{{ route('super-admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="flex items-center relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..."
                        class="flex-1 pl-3 pr-8 py-2 border border-gray-300 rounded-lg rounded-r-none outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 h-10">
                    <button type="submit" class="px-3 py-2 border border-gray-300 border-l-0 rounded-lg rounded-l-none bg-gray-50 text-gray-500 hover:text-green-600 hover:bg-green-50 transition-colors h-10 flex items-center justify-center">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="relative min-w-max">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}" {{ $role == $r ? 'selected' : '' }}>
                            {{ $roleLabels[$r] ?? ucwords(str_replace('_', ' ', $r)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" onchange="this.closest('form').submit()" class="w-full px-3 py-2 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                     <option value="">All Status</option>
                     <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                     <option value="deactivated" {{ $status == 'deactivated' ? 'selected' : '' }}>Deactivated</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $roleLabels[$user->getRoleAttribute()] ?? ucwords(str_replace('_', ' ', $user->getRoleAttribute())) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @can('toggleStatus', $user)
                            <form action="{{ route('super-admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 mr-3" onclick="return confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')">
                                    {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400 text-xs">Restricted</span>
                            @endcan
                            @can('update', $user)
                            <a href="{{ route('super-admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            @else
                            <span class="text-gray-400 text-xs">Restricted</span>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
