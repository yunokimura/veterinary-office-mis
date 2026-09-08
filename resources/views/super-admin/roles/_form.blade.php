@php
    $isCreate = (!isset($viewMode) || !$viewMode) && (!isset($role->id) || empty($role->id));
    $formAction = $isCreate ? route('super-admin.roles.store') : route('super-admin.roles.update', $role);
    $rolePermissions = $role->permissions()->pluck('name')->toArray();
    $totalPermissions = \Spatie\Permission\Models\Permission::count();

    $permissionGroups = [
        'Dashboard' => [
            'dashboard.access' => 'Access Dashboard',
        ],
        'User Management' => [
            'users.view' => 'View Users',
            'users.create' => 'Create Users',
            'users.edit' => 'Edit Users',
            'users.delete' => 'Delete Users',
            'users.toggle-status' => 'Toggle User Status',
            'users.change-role' => 'Change User Role',
        ],
        'Announcements' => [
            'announcements.view' => 'View Announcements',
            'announcements.create' => 'Create Announcements',
            'announcements.edit' => 'Edit Announcements',
            'announcements.delete' => 'Delete Announcements',
        ],
        'System' => [
            'system-logs.view' => 'View System Logs',
            'system-logs.export' => 'Export System Logs',
            'settings.view' => 'View Settings',
            'settings.edit' => 'Edit Settings',
        ],
        'Rabies Cases' => [
            'rabies-cases.view' => 'View Rabies Cases',
            'rabies-cases.create' => 'Create Rabies Cases',
            'rabies-cases.edit' => 'Edit Rabies Cases',
            'rabies-cases.delete' => 'Delete Rabies Cases',
        ],
        'Spay-Neuter' => [
            'spay-neuter.view' => 'View Spay-Neuter',
            'spay-neuter.create' => 'Create Spay-Neuter',
            'spay-neuter.edit' => 'Edit Spay-Neuter',
            'spay-neuter.delete' => 'Delete Spay-Neuter',
        ],
        'Inventory' => [
            'inventory.view' => 'View Inventory',
            'inventory.create' => 'Create Inventory',
            'inventory.edit' => 'Edit Inventory',
            'inventory.delete' => 'Delete Inventory',
        ],
        'Livestock Census' => [
            'livestock-census.view' => 'View Livestock Census',
            'livestock-census.create' => 'Create Livestock Census',
            'livestock-census.edit' => 'Edit Livestock Census',
            'livestock-census.delete' => 'Delete Livestock Census',
        ],
        'Reports' => [
            'reports.view' => 'View Reports',
            'reports.export' => 'Export Reports',
            'vaccination-reports.view' => 'View Vaccination Reports',
            'vaccination-reports.create' => 'Create Vaccination Reports',
            'bite-reports.view' => 'View Bite Reports',
            'bite-reports.create' => 'Create Bite Reports',
            'missing-pet-reports.view' => 'View Missing Pet Reports',
            'adoption-reports.view' => 'View Adoption Reports',
            'owner-reports.view' => 'View Owner Reports',
        ],
        'Meat Inspection' => [
            'meat-inspection-reports.view' => 'View Inspection Reports',
            'meat-inspection-reports.create' => 'Create Inspection Reports',
            'meat-inspection-reports.edit' => 'Edit Inspection Reports',
            'meat-shop-inspections.view' => 'View Meat Shop Inspections',
            'meat-shop-inspections.create' => 'Create Meat Shop Inspections',
            'meat-shop-inspections.edit' => 'Edit Meat Shop Inspections',
            'establishments.view' => 'View Establishments',
            'establishments.create' => 'Create Establishments',
            'establishments.edit' => 'Edit Establishments',
        ],
        'Pet Management' => [
            'pet-registrations.view' => 'View Pet Registrations',
            'pet-registrations.create' => 'Create Pet Registrations',
            'pet-registrations.edit' => 'Edit Pet Registrations',
            'pet-registrations.delete' => 'Delete Pet Registrations',
            'missing-pets.view' => 'View Missing Pets',
            'missing-pets.create' => 'Create Missing Pets',
            'missing-pets.edit' => 'Edit Missing Pets',
        ],
        'Appointments' => [
            'appointments.view' => 'View Appointments',
            'appointments.approve' => 'Approve Appointments',
            'appointments.reject' => 'Reject Appointments',
            'appointments.complete' => 'Complete Appointments',
            'appointments.reset' => 'Reset Appointments',
        ],
        'Medical Records' => [
            'medical-records.view' => 'View Medical Records',
            'medical-records.create' => 'Create Medical Records',
            'medical-records.edit' => 'Edit Medical Records',
            'medical-records.delete' => 'Delete Medical Records',
            'vaccination-records.view' => 'View Vaccination Records',
            'vaccination-records.create' => 'Create Vaccination Records',
        ],
        'Pet Owner' => [
            'pets.view' => 'View Pets',
            'pets.edit' => 'Edit Pets',
            'pets.delete' => 'Delete Pets',
            'profile.view' => 'View Profile',
            'profile.edit' => 'Edit Profile',
            'profile.delete' => 'Delete Profile',
        ],
    ];

    $hierarchyLabels = [
        10 => 'Super Admin',
        8 => 'City Veterinarian',
        7 => 'Senior Veterinarian',
        6 => 'Staff Veterinarian',
        5 => 'Assistant Veterinarian',
        4 => 'Meat Inspector',
        3 => 'Admin Staff',
        2 => 'Clinic Staff',
        1 => 'Pet Owner',
        0 => 'No Access',
    ];
@endphp

<form id="editRoleForm" action="{{ $formAction }}" method="POST">
    @csrf
    @if(!$isCreate)
        @method('PUT')
    @endif

    @if($isCreate)
        <div class="mb-4">
            <label for="copy_from" class="block text-sm font-medium text-gray-700 mb-1">Copy Permissions From</label>
            <select name="copy_from" id="copyFromRole" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">— None (start from scratch) —</option>
                @foreach($allRoles as $existingRole)
                    <option value="{{ $existingRole->id }}">{{ $existingRole->display_name ?? $existingRole->name }} (Level {{ $existingRole->hierarchy_level }})</option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">Clone the permission set of an existing role as a baseline.</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="display_name" class="block text-sm font-medium text-gray-700 mb-1">Display Name <span class="text-red-500">*</span></label>
                <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Key <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono">
                <p class="mt-1 text-xs text-gray-500">Auto-generated from Display Name. Editable.</p>
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description') }}</textarea>
            <div class="flex justify-between mt-1">
                <p class="text-xs text-gray-500">Briefly describe this role's purpose.</p>
                <span id="descriptionCounter" class="text-xs text-gray-400">0 / 1000</span>
            </div>
        </div>

        <div class="mb-6">
            <label for="hierarchy_level" class="block text-sm font-medium text-gray-700 mb-1">Hierarchy Level <span class="text-red-500">*</span></label>
            <div class="flex items-center gap-4">
                <input type="range" name="hierarchy_level" id="hierarchyRange" value="{{ old('hierarchy_level', 0) }}" min="0" max="10" step="1"
                       class="flex-1 h-2 bg-gray-200 rounded-lg cursor-pointer accent-green-600">
                <input type="number" name="hierarchy_level_number" id="hierarchyNumber" value="{{ old('hierarchy_level', 0) }}" min="0" max="10" step="1"
                       class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <p id="hierarchyHelper" class="mt-1 text-xs text-gray-500">Level 0 — No Access</p>
        </div>

        <div class="mb-6">
            <h5 class="text-lg font-semibold text-gray-800 mb-1">Permissions</h5>
            <p class="text-sm text-gray-500 mb-3">Assign permissions for this new role</p>
            <div class="permission-groups max-h-80 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                @foreach($permissionGroups as $groupName => $permissions)
                    @php
                        $groupTotal = count($permissions);
                        $groupAssigned = 0;
                        foreach ($permissions as $permissionName => $permissionLabel) {
                            if (in_array($permissionName, $rolePermissions)) {
                                $groupAssigned++;
                            }
                        }
                    @endphp
                    <div class="mb-5 last:mb-0 permission-group" data-group="{{ $groupName }}">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">{{ $groupName }}</h6>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 group-counter">{{ $groupAssigned }} / {{ $groupTotal }}</span>
                                <button type="button" class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 hover:bg-green-200 transition select-all-btn" data-group="{{ $groupName }}">Select All</button>
                                <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 transition clear-all-btn" data-group="{{ $groupName }}">Clear All</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($permissions as $permissionName => $permissionLabel)
                                <label class="flex items-center gap-2 p-2 bg-white rounded border border-gray-200 hover:border-green-400 cursor-pointer transition permission-row" data-permission-name="{{ $permissionName }}" data-permission-label="{{ $permissionLabel }}">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permissionName }}"
                                           class="permission-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                           data-permission="{{ $permissionName }}"
                                           data-group="{{ $groupName }}"
                                           {{ in_array($permissionName, $rolePermissions) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">{{ $permissionLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6">
            <button type="button" data-bs-dismiss="modal" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                Cancel
            </button>
            <button type="submit" id="saveRoleBtn" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                <i class="bi bi-check-lg mr-2"></i>
                <span>Create Role</span>
            </button>
        </div>
    @else
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role Key</label>
                <input type="text" value="{{ $role->name }}" disabled class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 font-mono">
                <p class="mt-1 text-xs text-gray-500">Role key cannot be changed</p>
            </div>

            <div>
                <label for="display_name" class="block text-sm font-medium text-gray-700 mb-1">Display Name <span class="text-red-500">*</span></label>
                <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $role->display_name ?? '') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="hierarchy_level" class="block text-sm font-medium text-gray-700 mb-1">Hierarchy Level</label>
                <input type="number" name="hierarchy_level" id="hierarchy_level" value="{{ old('hierarchy_level', $role->hierarchy_level ?? 0) }}" required min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <p class="mt-1 text-xs text-gray-500">Higher number = more permissions. Super admin should have the highest level.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description', $role->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6">
            <button type="button" data-bs-dismiss="modal" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                Cancel
            </button>
            <button type="submit" id="saveRoleBtn" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                <i class="bi bi-check-lg mr-2"></i>
                <span>Save Role</span>
            </button>
        </div>
    @endif
</form>

@if(!$isCreate)
<hr class="my-6 border-gray-200">
@endif

@if(!$isCreate)
<div class="mb-4 flex items-center justify-between">
    <div>
        <h5 class="text-lg font-semibold text-gray-800 mb-1">Permissions</h5>
        <p class="text-sm text-gray-500">Manage permissions for this role</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800" id="permissionCounter">
        {{ count($rolePermissions) }} of {{ $totalPermissions }} permissions assigned
    </span>
</div>

<div class="mb-4">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
        </span>
        <input type="text" id="permissionSearch" placeholder="Search permissions..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
    </div>
</div>

<div class="permission-groups max-h-96 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
    @foreach($permissionGroups as $groupName => $permissions)
        @php
            $groupTotal = count($permissions);
            $groupAssigned = 0;
            foreach ($permissions as $permissionName => $permissionLabel) {
                if (in_array($permissionName, $rolePermissions)) {
                    $groupAssigned++;
                }
            }
        @endphp
        <div class="mb-6 last:mb-0 permission-group" data-group="{{ $groupName }}">
            <div class="flex items-center justify-between mb-3">
                <h6 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">{{ $groupName }}</h6>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 group-counter">{{ $groupAssigned }} / {{ $groupTotal }}</span>
                    <button type="button" class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 hover:bg-green-200 transition select-all-btn" data-group="{{ $groupName }}">Select All</button>
                    <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 transition clear-all-btn" data-group="{{ $groupName }}">Clear All</button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permissionName => $permissionLabel)
                    <label class="flex items-center gap-2 p-2 bg-white rounded border border-gray-200 hover:border-green-400 cursor-pointer transition permission-row" data-permission-name="{{ $permissionName }}" data-permission-label="{{ $permissionLabel }}">
                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permissionName }}"
                               class="permission-checkbox w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                               data-permission="{{ $permissionName }}"
                               data-group="{{ $groupName }}"
                               {{ in_array($permissionName, $rolePermissions) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">{{ $permissionLabel }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endif

@if(!$isCreate)
<div class="flex items-center justify-end gap-3 mt-6">
    <button type="button" data-bs-dismiss="modal" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
        Cancel
    </button>
    <button type="button" id="savePermissionsBtn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
        <i class="bi bi-shield-check mr-2"></i>
        <span>Save Permissions</span>
    </button>
</div>
@endif

<script>
(function() {
    const isCreate = @json($isCreate);
    const saveBtn = document.getElementById('saveRoleBtn');

    if (saveBtn && isCreate) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = document.getElementById('editRoleForm');
            const formData = new FormData(form);
            const btn = this;
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Creating...';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw data;
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') {
                        showToast('success', data.message);
                    } else {
                        alert(data.message);
                    }
                    location.reload();
                }
            })
            .catch(error => {
                if (error.errors) {
                    const modalBody = document.getElementById('createRoleModalBody');
                    modalBody.querySelectorAll('.text-red-600').forEach(el => el.remove());
                    modalBody.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                    for (const [field, messages] of Object.entries(error.errors)) {
                        const input = document.getElementById(field);
                        if (input) {
                            input.classList.add('border-red-500');
                            const errorEl = document.createElement('p');
                            errorEl.className = 'mt-1 text-sm text-red-600';
                            errorEl.textContent = messages[0];
                            input.parentNode.appendChild(errorEl);
                        }
                    }
                }
                if (typeof showToast === 'function') {
                    showToast('error', error.message || 'Please check the form for errors.');
                } else {
                    alert(error.message || 'Please check the form for errors.');
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }

    const savePermissionsBtn = document.getElementById('savePermissionsBtn');
    if (savePermissionsBtn && !isCreate) {
        savePermissionsBtn.addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Saving...';

            const permissions = [];
            document.querySelectorAll('.permission-checkbox:checked').forEach(function(checkbox) {
                permissions.push(checkbox.value);
            });

            fetch('/super-admin/roles/{{ $role->id }}/permissions', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ permissions: permissions })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw data;
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') {
                        showToast('success', data.message);
                    } else {
                        alert(data.message);
                    }
                    location.reload();
                }
            })
            .catch(error => {
                if (typeof showToast === 'function') {
                    showToast('error', error.message || 'Error saving permissions');
                } else {
                    alert(error.message || 'Error saving permissions');
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }
})();
</script>
