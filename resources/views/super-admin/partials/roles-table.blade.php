<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hierarchy</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($roles as $role)
            <tr class="hover:bg-gray-50 role-row" data-role-name="{{ $role->name }}" data-display-name="{{ $role->display_name ?? '' }}" data-hierarchy="{{ $role->hierarchy_level }}" data-permissions="{{ $role->permissions()->count() }}" data-role-id="{{ $role->id }}">
                <td class="px-6 py-4">
                    <div>
                        <span class="text-sm font-medium text-gray-900">{{ $role->display_name ?? '-' }}</span>
                        <span class="block text-xs text-gray-400 font-mono">{{ $role->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700" title="Higher number = more permissions. Super admin should have the highest level.">
                        Level {{ $role->hierarchy_level }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm font-medium text-gray-900">{{ $roleUserCounts[$role->name] ?? 0 }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs leading-5 font-semibold bg-green-100 text-green-800">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        {{ $role->permissions()->count() }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <button type="button" class="p-1.5 text-green-700 hover:bg-gray-100 rounded-full transition" title="View" onclick="openViewRoleModal({{ $role->id }}, '{{ $role->name }}')">
                            <i class="bi bi-eye text-lg"></i>
                        </button>
                        <button type="button" class="p-1.5 text-green-700 hover:bg-gray-100 rounded-full transition" title="Edit" onclick="openEditRoleModal({{ $role->id }}, '{{ $role->name }}')">
                            <i class="bi bi-pencil text-lg"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No roles found</td>
            </tr>
        @endforelse
    </tbody>
</table>
