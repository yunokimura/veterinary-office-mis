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
            <tr class="hover:bg-gray-50" data-user-id="{{ $user->id }}">
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
                    <div class="flex items-center gap-2">
                        @can('update', $user)
                        <button type="button" class="p-1.5 text-green-700 hover:bg-gray-100 rounded-full transition" title="View / Edit" onclick="openEditModal({{ $user->id }}, '{{ $user->name }}')">
                            <i class="bi bi-eye text-lg"></i>
                        </button>
                        @else
                        <span class="text-gray-400 text-xs">Restricted</span>
                        @endcan
                        @can('toggleStatus', $user)
                        <form action="{{ route('super-admin.users.toggle-status', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')">
                            @csrf
                            <button type="submit" class="p-1.5 {{ $user->status === 'active' ? 'text-green-700 hover:bg-green-50' : 'text-gray-500 hover:bg-gray-100' }} rounded-full transition" title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                <i class="bi {{ $user->status === 'active' ? 'bi-toggle-on' : 'bi-toggle-off' }} text-lg"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-gray-400 text-xs">Restricted</span>
                        @endcan
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
            </tr>
        @endforelse
    </tbody>
</table>
