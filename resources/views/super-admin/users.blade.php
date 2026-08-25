@extends('layouts.admin')

@section('title', 'User Management')
@section('header', 'User Management')
@section('subheader', 'Manage system users and roles')

@section('content')
@php
    $roleLabels = [
        'super_admin'           => 'Super Admin',
        'city_vet'              => 'City Veterinary (Admin)',
        'assistant_vet'         => 'Assistant Veterinarian',
        'admin_asst'            => 'Administrative Assistant',
        'meat_inspector'        => 'Meat Inspector',
        'pet_owner'             => 'Pet Owner',
    ];

    // Hierarchical role order (used to sort $roles)
    $roleOrder = [
        'super_admin',
        'city_vet',
        'assistant_vet',
        'admin_asst',
        'meat_inspector',
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Roles</label>
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
                            <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openEditModal({{ $user->id }}, '{{ $user->name }}')">Edit</button>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editModalBody">
                <!-- Form loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<style>
.section-disabled {
    opacity: 0.6;
    background-color: #f9fafb;
    border-radius: 0.5rem;
    padding: 1rem;
}
.section-fields-disabled {
    pointer-events: none;
    opacity: 0.5;
}
.section-fields-disabled input,
.section-fields-disabled select,
.section-fields-disabled textarea {
    background-color: #f3f4f6 !important;
    cursor: not-allowed;
}
</style>

<script>
let editModal;
let currentUserId = null;
const sectionOriginalValues = {};
let activeSectionId = null;

document.addEventListener('DOMContentLoaded', function() {
    editModal = new bootstrap.Modal(document.getElementById('editUserModal'));

    document.getElementById('editModalBody').addEventListener('click', function(e) {
        const cancelBtn = e.target.closest('.cancel-edit-btn');
        if (cancelBtn) {
            e.preventDefault();
            closeEditModal();
            return;
        }

        const editBtn = e.target.closest('.edit-section-btn');
        if (editBtn) {
            const section = editBtn.closest('[data-section]');
            if (section) {
                const sectionId = section.id;
                if (activeSectionId === sectionId) {
                    disableSection(sectionId);
                } else {
                    enableSection(sectionId);
                }
            }
        }
    });
});

function openEditModal(userId, userName) {
    currentUserId = userId;
    const modalBody = document.getElementById('editModalBody');
    const modalTitle = document.getElementById('editUserModalLabel');

    modalTitle.textContent = 'Edit User - ' + userName;
    modalBody.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-blue-600"></div>
            <p class="mt-4 text-gray-600">Loading form...</p>
        </div>
    `;

    const url = `{{ route('super-admin.users.edit', ':id') }}`.replace(':id', userId);

    fetch(url, {
        headers: {
            'Accept': 'text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        modalBody.innerHTML = html;
        initSections();
        editModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
    });
}

function closeEditModal() {
    if (editModal) {
        editModal.hide();
    }
}

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function updateUserRow(userData) {
    const row = document.querySelector(`tr[data-user-id="${userData.id}"]`);
    if (row) {
        const nameCell = row.querySelector('td:first-child .text-sm.font-medium.text-gray-900');
        if (nameCell) {
            nameCell.textContent = userData.name;
        }
        const emailCell = row.querySelector('td:first-child .text-sm.text-gray-500');
        if (emailCell) {
            emailCell.textContent = userData.email;
        }
        const roleCell = row.querySelector('td:nth-child(2) span');
        if (roleCell) {
            roleCell.textContent = userData.role_label;
        }
    }
}

function showFormErrors(errors) {
    const modalBody = document.getElementById('editModalBody');
    modalBody.querySelectorAll('.text-red-600').forEach(el => el.remove());
    modalBody.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

    let erroredSectionId = null;

    for (const [field, messages] of Object.entries(errors)) {
        const input = document.getElementById(field);
        if (input) {
            input.classList.add('border-red-500');
            const errorEl = document.createElement('p');
            errorEl.className = 'mt-1 text-sm text-red-600';
            errorEl.textContent = messages[0];
            input.parentNode.appendChild(errorEl);

            const section = input.closest('[data-section]');
            if (section) {
                erroredSectionId = section.id;
            }
        }
    }

    if (erroredSectionId) {
        const sections = document.querySelectorAll('[data-section]');
        sections.forEach(section => {
            if (section.id !== erroredSectionId) {
                disableSection(section.id);
            }
        });
        enableSection(erroredSectionId);
    } else {
        disableAllSections();
    }
}

document.addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'editUserForm') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

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
                updateUserRow(data.user);
                disableAllSections();
                closeEditModal();
                showToast('success', data.message);
            }
        })
        .catch(error => {
            if (error.errors) {
                showFormErrors(error.errors);
                showToast('error', error.message || 'Please check the form for errors.');
            } else if (error.message) {
                showToast('error', error.message);
            } else {
                showToast('error', 'An error occurred. Please try again.');
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    }
});

function initSections() {
    const sections = document.querySelectorAll('[data-section]');
    sections.forEach(section => {
        const sectionId = section.id;
        storeOriginalValues(sectionId);
        disableSection(sectionId);
    });
    activeSectionId = null;
}

function storeOriginalValues(sectionId) {
    const section = document.getElementById(sectionId);
    if (!section) return;
    
    const inputs = section.querySelectorAll('input:not([type="hidden"]):not(.section-hidden-input), select, textarea');
    sectionOriginalValues[sectionId] = {};
    inputs.forEach(input => {
        const key = input.name || input.id;
        sectionOriginalValues[sectionId][key] = input.value;
    });
}

function disableSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (!section) return;

    const container = section.querySelector('.fields-container');
    const inputs = section.querySelectorAll('input:not([type="hidden"]):not(.section-hidden-input), select, textarea');
    const editBtn = section.querySelector('.edit-section-btn');

    if (sectionOriginalValues[sectionId]) {
        inputs.forEach(input => {
            const key = input.name || input.id;
            if (sectionOriginalValues[sectionId][key] !== undefined) {
                input.value = sectionOriginalValues[sectionId][key];
            }
        });
    }

    inputs.forEach(input => {
        if (input.tagName === 'SELECT') {
            input.setAttribute('disabled', 'disabled');
            addHiddenInput(section, input);
        } else {
            input.setAttribute('readonly', 'readonly');
        }
    });

    if (container) {
        container.classList.add('section-fields-disabled');
    }
    section.classList.add('section-disabled');

    if (editBtn) {
        editBtn.innerHTML = '<i class="bi bi-pencil-square"></i> Edit';
        editBtn.classList.remove('btn-outline-danger');
        editBtn.classList.add('btn-outline-primary');
    }

    if (activeSectionId === sectionId) {
        activeSectionId = null;
    }
}

function enableSection(sectionId) {
    if (activeSectionId && activeSectionId !== sectionId) {
        disableSection(activeSectionId);
    }

    const section = document.getElementById(sectionId);
    if (!section) return;

    const container = section.querySelector('.fields-container');
    const inputs = section.querySelectorAll('input:not([type="hidden"]):not(.section-hidden-input), select, textarea');
    const editBtn = section.querySelector('.edit-section-btn');

    inputs.forEach(input => {
        if (input.tagName === 'SELECT') {
            input.removeAttribute('disabled');
            removeHiddenInput(section, input);
        } else {
            input.removeAttribute('readonly');
        }
    });

    if (container) {
        container.classList.remove('section-fields-disabled');
    }
    section.classList.remove('section-disabled');

    if (editBtn) {
        editBtn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel';
        editBtn.classList.remove('btn-outline-primary');
        editBtn.classList.add('btn-outline-danger');
    }

    activeSectionId = sectionId;
}

function addHiddenInput(section, select) {
    const existing = section.querySelector(`input.section-hidden-input[name="${select.name}"]`);
    if (existing) {
        existing.value = select.value;
        return;
    }
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = select.name;
    hidden.value = select.value;
    hidden.classList.add('section-hidden-input');
    select.parentNode.insertBefore(hidden, select);
}

function removeHiddenInput(section, select) {
    const hidden = section.querySelector(`input.section-hidden-input[name="${select.name}"]`);
    if (hidden) {
        hidden.remove();
    }
}

function disableAllSections() {
    const sections = document.querySelectorAll('[data-section]');
    sections.forEach(section => {
        disableSection(section.id);
    });
    activeSectionId = null;
}
</script>
@endsection
