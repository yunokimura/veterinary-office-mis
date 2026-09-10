@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('header', 'Roles & Permissions')
@section('subheader', 'Manage system roles, access levels, and permissions')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Roles</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $roles->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Permissions</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPermissions }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Active Users</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $activeUsers }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Inactive Users</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inactiveUsers }}</p>
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">System Roles</h3>
                <p class="text-sm text-gray-500">Manage role display names, hierarchy levels, and permissions</p>
            </div>
            <button type="button" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition shadow-sm" onclick="openCreateRoleModal()">
                <i class="bi bi-plus-lg mr-1"></i> Create New Role
            </button>
        </div>

        <!-- Search & Filters -->
        <form method="GET" action="{{ route('super-admin.roles.index') }}" class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Search by role name or display name..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
            <div class="flex gap-2 items-center">
                <select name="hierarchy_level" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <option value="">All Hierarchy Levels</option>
                    @foreach($allRoles->sortByDesc('hierarchy_level')->unique('hierarchy_level') as $role)
                        <option value="{{ $role->hierarchy_level }}" {{ ($hierarchyLevel ?? request('hierarchy_level')) == $role->hierarchy_level ? 'selected' : '' }}>Level {{ $role->hierarchy_level }}</option>
                    @endforeach
                </select>
                <select name="permission_range" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <option value="">All Permission Counts</option>
                    <option value="0" {{ ($permissionRange ?? request('permission_range')) == '0' ? 'selected' : '' }}>No Permissions</option>
                    <option value="1-10" {{ ($permissionRange ?? request('permission_range')) == '1-10' ? 'selected' : '' }}>1 - 10 Permissions</option>
                    <option value="11-50" {{ ($permissionRange ?? request('permission_range')) == '11-50' ? 'selected' : '' }}>11 - 50 Permissions</option>
                    <option value="51+" {{ ($permissionRange ?? request('permission_range')) == '51+' ? 'selected' : '' }}>51+ Permissions</option>
                </select>
                @if(request()->filled('search') || request()->filled('hierarchy_level') || request()->filled('permission_range'))
                    <a href="{{ route('super-admin.roles.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap">
                        <i class="bi bi-x-circle mr-1"></i>Clear Filters
                    </a>
                @endif
            </div>
            <button type="submit" class="hidden">Apply</button>
        </form>

        <div class="overflow-x-auto" id="rolesTableContainer">
            @include('super-admin.partials.roles-table', ['roles' => $roles, 'roleUserCounts' => $roleUserCounts])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="rolesPagination">
            {{ $roles->links() }}
        </div>
        <div id="rolesLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="createRoleModalBody">
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
                    <p class="mt-4 text-gray-600">Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Role Modal -->
<div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRoleModalLabel">View Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewRoleModalBody">
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
                    <p class="mt-4 text-gray-600">Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editRoleModalBody">
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
                    <p class="mt-4 text-gray-600">Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let editRoleModal;
let viewRoleModal;
let createRoleModal;
let currentRoleId = null;

const hierarchyLabels = {
    10: 'Super Admin',
    8: 'City Veterinarian',
    7: 'Senior Veterinarian',
    6: 'Staff Veterinarian',
    5: 'Assistant Veterinarian',
    4: 'Meat Inspector',
    3: 'Admin Staff',
    2: 'Clinic Staff',
    1: 'Pet Owner',
    0: 'No Access'
};

function initPermissionMatrix() {
    const totalPermissions = {{ $totalPermissions }};

    function updatePermissionCounter() {
        const counter = document.getElementById('permissionCounter');
        if (counter) {
            const modalBody = counter.closest('.modal-body');
            const scope = modalBody || document;
            const checked = scope.querySelectorAll('.permission-checkbox:checked').length;
            counter.textContent = checked + ' of ' + totalPermissions + ' permissions assigned';
        }
    }

    function updateGroupCounters() {
        document.querySelectorAll('.permission-group').forEach(function(group) {
            const checkboxes = group.querySelectorAll('.permission-checkbox');
            const checked = group.querySelectorAll('.permission-checkbox:checked').length;
            const total = checkboxes.length;
            const counter = group.querySelector('.group-counter');
            if (counter) {
                counter.textContent = checked + ' / ' + total;
            }
        });
    }

    document.querySelectorAll('.select-all-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const groupName = this.getAttribute('data-group');
            const group = document.querySelector(`.permission-group[data-group="${groupName}"]`);
            if (group) {
                group.querySelectorAll('.permission-checkbox').forEach(function(cb) {
                    cb.checked = true;
                });
                updatePermissionCounter();
                updateGroupCounters();
            }
        });
    });

    document.querySelectorAll('.clear-all-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const groupName = this.getAttribute('data-group');
            const group = document.querySelector(`.permission-group[data-group="${groupName}"]`);
            if (group) {
                group.querySelectorAll('.permission-checkbox').forEach(function(cb) {
                    cb.checked = false;
                });
                updatePermissionCounter();
                updateGroupCounters();
            }
        });
    });

    document.querySelectorAll('.permission-checkbox').forEach(function(cb) {
        cb.addEventListener('change', function() {
            updatePermissionCounter();
            updateGroupCounters();
        });
    });

    const searchInput = document.getElementById('permissionSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.permission-row').forEach(function(row) {
                const name = row.getAttribute('data-permission-name').toLowerCase();
                const label = row.getAttribute('data-permission-label').toLowerCase();
                if (query === '' || name.includes(query) || label.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    updatePermissionCounter();
    updateGroupCounters();
}
window.initPermissionMatrix = initPermissionMatrix;

function initCreateForm() {
    const hierarchyRange = document.getElementById('hierarchyRange');
    const hierarchyNumber = document.getElementById('hierarchyNumber');
    const hierarchyHelper = document.getElementById('hierarchyHelper');
    const displayNameInput = document.getElementById('display_name');
    const roleKeyInput = document.getElementById('name');
    const descriptionTextarea = document.getElementById('description');
    const descriptionCounter = document.getElementById('descriptionCounter');

    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '_')
            .replace(/^-+|-+$/g, '');
    }

    if (displayNameInput && roleKeyInput) {
        roleKeyInput.value = slugify(displayNameInput.value || '');
        displayNameInput.addEventListener('input', function() {
            const slug = slugify(this.value);
            roleKeyInput.value = slug;
        });
    }

    function updateHierarchyHelper(value) {
        const numVal = parseInt(value, 10) || 0;
        const label = hierarchyLabels[numVal] !== undefined ? hierarchyLabels[numVal] : 'Custom level';
        if (hierarchyHelper) {
            hierarchyHelper.textContent = 'Level ' + numVal + ' - ' + label;
        }
    }

    if (hierarchyRange && hierarchyNumber) {
        updateHierarchyHelper(hierarchyRange.value);
        hierarchyRange.addEventListener('input', function() {
            hierarchyNumber.value = this.value;
            updateHierarchyHelper(this.value);
        });
        hierarchyNumber.addEventListener('input', function() {
            let val = parseInt(this.value, 10) || 0;
            val = Math.max(0, Math.min(10, val));
            hierarchyRange.value = val;
            updateHierarchyHelper(val);
        });
    }

    if (descriptionTextarea && descriptionCounter) {
        descriptionCounter.textContent = descriptionTextarea.value.length + ' / 1000';
        descriptionTextarea.addEventListener('input', function() {
            const len = this.value.length;
            descriptionCounter.textContent = len + ' / 1000';
            if (len > 1000) {
                descriptionCounter.classList.add('text-red-600');
            } else {
                descriptionCounter.classList.remove('text-red-600');
            }
        });
    }

    const copyFromSelect = document.getElementById('copyFromRole');
    if (copyFromSelect) {
        copyFromSelect.addEventListener('change', function() {
            const roleId = this.value;
            if (!roleId) return;

            fetch('/super-admin/roles/' + roleId + '/edit', {
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const checkboxes = doc.querySelectorAll('.permission-checkbox');
                checkboxes.forEach(function(cb) {
                    const val = cb.value;
                    const localCb = document.querySelector(`.permission-checkbox[value="${val}"]`);
                    if (localCb) {
                        localCb.checked = cb.checked;
                    }
                });
                if (typeof updatePermissionCounter === 'function') {
                    updatePermissionCounter();
                }
                if (typeof updateGroupCounters === 'function') {
                    updateGroupCounters();
                }
            })
            .catch(error => {
                console.error('Error loading permissions:', error);
            });
        });
    }
}
window.initCreateForm = initCreateForm;

function openCreateRoleModal() {
    currentRoleId = null;
    const modalBody = document.getElementById('createRoleModalBody');
    const modalTitle = document.getElementById('createRoleModalLabel');

    modalTitle.textContent = 'Create New Role';
    modalBody.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
            <p class="mt-4 text-gray-600">Loading form...</p>
        </div>
    `;

    fetch('/super-admin/roles/create', {
        headers: {
            'Accept': 'text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        modalBody.innerHTML = html;
        createRoleModal.show();
        initCreateForm();
        initPermissionMatrix();
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
    });
}
window.openCreateRoleModal = openCreateRoleModal;

function openViewRoleModal(roleId, roleName) {
    currentRoleId = roleId;
    const modalBody = document.getElementById('viewRoleModalBody');
    const modalTitle = document.getElementById('viewRoleModalLabel');

    modalTitle.textContent = 'View Role - ' + roleName;
    modalBody.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
            <p class="mt-4 text-gray-600">Loading...</p>
        </div>
    `;

    fetch(`/super-admin/roles/${roleId}/edit?view=1`, {
        headers: {
            'Accept': 'text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        modalBody.innerHTML = html;
        viewRoleModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
    });
}
window.openViewRoleModal = openViewRoleModal;

function openEditRoleModal(roleId, roleName) {
    currentRoleId = roleId;
    const modalBody = document.getElementById('editRoleModalBody');
    const modalTitle = document.getElementById('editRoleModalLabel');

    modalTitle.textContent = 'Edit Role - ' + roleName;
    modalBody.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
            <p class="mt-4 text-gray-600">Loading form...</p>
        </div>
    `;

    fetch(`/super-admin/roles/${roleId}/edit`, {
        headers: {
            'Accept': 'text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        modalBody.innerHTML = html;
        editRoleModal.show();
        initPermissionMatrix();
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
    });
}
window.openEditRoleModal = openEditRoleModal;

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
window.showToast = showToast;

document.addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'editRoleForm') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        const isCreate = form.action.includes('/roles/create');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Saving...';

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
                if (isCreate) {
                    createRoleModal.hide();
                } else {
                    editRoleModal.hide();
                }
                showToast('success', data.message);
                location.reload();
            }
        })
        .catch(error => {
            if (error.errors) {
                const modalBody = isCreate ? document.getElementById('createRoleModalBody') : document.getElementById('editRoleModalBody');
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
            showToast('error', error.message || 'Please check the form for errors.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    editRoleModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
    viewRoleModal = new bootstrap.Modal(document.getElementById('viewRoleModal'));
    createRoleModal = new bootstrap.Modal(document.getElementById('createRoleModal'));

    const filterForm = document.querySelector('form[action="{{ route('super-admin.roles.index') }}"]');
    const rolesFilterUrl = '{{ route('super-admin.roles.filter') }}';
    let searchDebounce;
    let lastKnownTableHtml = null;
    let lastKnownPaginationHtml = null;
    let currentController = null;

    function applyRoleFilters(params) {
        const tableContainer = document.getElementById('rolesTableContainer');
        const paginationContainer = document.getElementById('rolesPagination');
        const loadingEl = document.getElementById('rolesLoading');

        if (loadingEl) loadingEl.classList.remove('hidden');
        if (tableContainer) tableContainer.style.opacity = '0.3';
        if (paginationContainer) paginationContainer.style.opacity = '0.3';

        if (currentController) {
            currentController.abort();
        }
        currentController = new AbortController();

        fetch(`${rolesFilterUrl}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: currentController.signal
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (tableContainer) {
                        lastKnownTableHtml = data.table_html;
                        tableContainer.innerHTML = data.table_html;
                        tableContainer.style.opacity = '1';
                    }
                    if (paginationContainer) {
                        lastKnownPaginationHtml = data.pagination;
                        paginationContainer.innerHTML = data.pagination;
                        paginationContainer.style.opacity = '1';
                    }
                }
            })
            .catch(error => {
                if (error.name === 'AbortError') {
                    return;
                }
                console.error('Error filtering roles:', error);
                if (tableContainer) {
                    if (lastKnownTableHtml) {
                        tableContainer.innerHTML = lastKnownTableHtml;
                    }
                    tableContainer.style.opacity = '1';
                }
                if (paginationContainer) {
                    if (lastKnownPaginationHtml) {
                        paginationContainer.innerHTML = lastKnownPaginationHtml;
                    }
                    paginationContainer.style.opacity = '1';
                }
            })
            .finally(() => {
                if (loadingEl) loadingEl.classList.add('hidden');
            });
    }

    if (filterForm) {
        const searchInput = filterForm.querySelector('input[name="search"]');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchDebounce);
                searchDebounce = setTimeout(() => {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams();
                    formData.forEach((value, key) => {
                        if (value) params.append(key, value);
                    });
                    applyRoleFilters(params);
                }, 300);
            });
        }

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(filterForm);
            const params = new URLSearchParams();
            formData.forEach((value, key) => {
                if (value) params.append(key, value);
            });

            applyRoleFilters(params);
        });
    }

    const paginationContainer = document.getElementById('rolesPagination');
    if (paginationContainer) {
        paginationContainer.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            e.preventDefault();
            const url = new URL(link.href);
            const query = url.searchParams.toString();

            fetch(`${rolesFilterUrl}?${query}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('rolesTableContainer').innerHTML = data.table_html;
                        document.getElementById('rolesPagination').innerHTML = data.pagination;
                    }
                })
                .catch(error => {
                    console.error('Error loading roles page:', error);
                });
        });
    }
});
</script>
@endsection
