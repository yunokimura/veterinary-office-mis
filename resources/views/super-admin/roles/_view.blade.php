@php
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

    $rolePermissions = $role->permissions()->pluck('name')->toArray();
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-500 mb-1">Role Key</label>
        <p class="text-sm text-gray-900 font-mono bg-gray-100 px-3 py-2 rounded-lg border border-gray-200">{{ $role->name }}</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-500 mb-1">Display Name</label>
        <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">{{ $role->display_name ?? '—' }}</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-500 mb-1">Hierarchy Level</label>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
            {{ $role->hierarchy_level }}
        </span>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
        <p class="text-sm text-gray-700 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">{{ $role->description ?? '—' }}</p>
    </div>
</div>

<hr class="my-6 border-gray-200">

<div class="mb-4 flex items-center justify-between">
    <div>
        <h5 class="text-lg font-semibold text-gray-800 mb-1">Permissions</h5>
        <p class="text-sm text-gray-500">Read-only view of assigned permissions</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
        {{ count($rolePermissions) }} of {{ \Spatie\Permission\Models\Permission::count() }} permissions assigned
    </span>
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
            <h6 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">{{ $groupName }} <span class="text-gray-500 font-normal normal-case">{{ $groupAssigned }} / {{ $groupTotal }}</span></h6>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permissionName => $permissionLabel)
                    <label class="flex items-center gap-2 p-2 bg-white rounded border border-gray-200 cursor-default">
                        <input type="checkbox"
                               disabled
                               {{ in_array($permissionName, $rolePermissions) ? 'checked' : '' }}
                               class="permission-checkbox w-4 h-4 text-green-600 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">{{ $permissionLabel }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
