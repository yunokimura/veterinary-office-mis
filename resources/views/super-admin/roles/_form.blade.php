<form id="editRoleForm" action="{{ route('super-admin.roles.update', $role) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role Key</label>
            <input type="text" value="{{ $role->name }}" disabled class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500">
            <p class="mt-1 text-xs text-gray-500">Role key cannot be changed</p>
        </div>

        <div>
            <label for="display_name" class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
            <input type="text" name="display_name" id="display_name" value="{{ $role->display_name ?? '' }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label for="hierarchy_level" class="block text-sm font-medium text-gray-700 mb-1">Hierarchy Level</label>
            <input type="number" name="hierarchy_level" id="hierarchy_level" value="{{ $role->hierarchy_level }}" required min="0"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-xs text-gray-500">Higher number = more permissions. Super admin should have the highest level.</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ $role->description ?? '' }}</textarea>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 mt-6">
        <button type="button" data-bs-dismiss="modal" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
            Cancel
        </button>
        <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
            <i class="bi bi-check-lg mr-2"></i>
            <span>Save Changes</span>
        </button>
    </div>
</form>
