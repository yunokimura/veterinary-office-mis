@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('header', 'Roles & Permissions')
@section('subheader', 'Manage system roles and hierarchy levels')

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
                <p class="text-xs font-medium text-gray-500">Total Users</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
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
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">System Roles</h3>
            <p class="text-sm text-gray-500">Manage role display names, hierarchy levels, and descriptions</p>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hierarchy Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($roles as $role)
                    <tr class="hover:bg-gray-50" data-role-id="{{ $role->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $role->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $role->display_name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $role->hierarchy_level }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $role->description ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $roleUserCounts[$role->name] ?? 0 }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openEditRoleModal({{ $role->id }}, '{{ $role->name }}')">Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No roles found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
let currentRoleId = null;

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
    })
    .catch(error => {
        console.error('Error:', error);
        modalBody.innerHTML = '<p class="text-red-600 text-center py-8">Error loading form. Please try again.</p>';
    });
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

document.addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'editRoleForm') {
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
                editRoleModal.hide();
                showToast('success', data.message);
                location.reload();
            }
        })
        .catch(error => {
            if (error.errors) {
                const modalBody = document.getElementById('editRoleModalBody');
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
});
</script>
@endsection
