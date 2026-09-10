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

    $roleOrder = [
        'super_admin',
        'city_vet',
        'assistant_vet',
        'admin_asst',
        'meat_inspector',
        'pet_owner',
    ];

    usort($roles, fn($a, $b) => array_search($a, $roleOrder) - array_search($b, $roleOrder));

    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'deactivated' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Users</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Active Accounts</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeAccounts }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Admin Staff</p>
                <p class="text-2xl font-bold text-purple-600 mt-1">{{ $cityVetStaff }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Pet Owners</p>
                <p class="text-2xl font-bold text-pink-600 mt-1">{{ $petOwners }}</p>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">System Users</h3>
                <p class="text-sm text-gray-500">Manage user accounts, roles, and access status</p>
            </div>
        </div>

    <!-- Search & Filters -->
    <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
        <div class="relative w-96">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="userSearchInput" value="{{ $search }}" placeholder="Search by name, email, role, or status..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            <button type="button" id="searchHelpBtn"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                    data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus click"
                    data-bs-html="true"
                    data-bs-content="
                        <div class='text-sm text-gray-700 space-y-1'>
                            <div><strong>Examples:</strong></div>
                            <div>Juan <span class='text-gray-400'>(Name)</span></div>
                            <div>admin@vet.gov <span class='text-gray-400'>(Email)</span></div>
                            <div>Super Admin <span class='text-gray-400'>(Role)</span></div>
                            <div>Active <span class='text-gray-400'>(Status)</span></div>
                        </div>
                    ">
                <i class="bi bi-info-circle"></i>
            </button>
        </div>
        <button type="button" id="clearUserFiltersBtn" onclick="clearUserFilters()"
                class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
            <i class="bi bi-x-circle mr-1"></i>Clear Filters
        </button>
    </div>

        <div id="usersTableContainer">
            @include('super-admin.partials.users-table', ['users' => $users, 'roleLabels' => $roleLabels, 'statusColors' => $statusColors])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="usersPagination">
            {{ $users->links() }}
        </div>
        <div id="usersLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="usersEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-people text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Users Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
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
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 1rem;
        border: 1px solid #e5e7eb;
    }
    .section-fields-disabled {
        pointer-events: none;
    }
    .section-fields-disabled input,
    .section-fields-disabled select,
    .section-fields-disabled textarea {
        background-color: #f3f4f6 !important;
        border-color: #d1d5db !important;
        color: #111827 !important;
        opacity: 1 !important;
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

        const searchHelpBtn = document.getElementById('searchHelpBtn');
        if (searchHelpBtn) {
            new bootstrap.Popover(searchHelpBtn);
        }

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

    function showInlineSuccess(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-[60] bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2';
        toast.innerHTML = `<i class="bi bi-check-circle"></i><span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
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

    let searchDebounce;
    const userFilterUrl = `{{ route('super-admin.users.search') }}` || '/super-admin/users/search';

    function getUserFilterParams() {
        return {
            search: document.getElementById('userSearchInput')?.value || '',
        };
    }

    function applyUserFilters() {
        const params = getUserFilterParams();
        const tableContainer = document.getElementById('usersTableContainer');
        const paginationContainer = document.getElementById('usersPagination');
        const loadingEl = document.getElementById('usersLoading');
        const emptyState = document.getElementById('usersEmptyState');

        if (loadingEl) loadingEl.classList.remove('hidden');
        if (tableContainer) tableContainer.style.opacity = '0.3';
        if (paginationContainer) paginationContainer.style.opacity = '0.3';

        const query = new URLSearchParams();
        Object.entries(params).forEach(([key, value]) => {
            if (value) query.append(key, value);
        });

        fetch(`${userFilterUrl}?${query.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (tableContainer) {
                    tableContainer.innerHTML = data.html;
                    tableContainer.style.opacity = '1';
                }
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                    paginationContainer.style.opacity = '1';
                }
                if (emptyState) emptyState.style.display = data.has_results ? 'none' : 'block';
            }
        })
        .catch(error => {
            console.error('Error filtering users:', error);
            if (tableContainer) tableContainer.style.opacity = '1';
            if (paginationContainer) paginationContainer.style.opacity = '1';
        })
        .finally(() => {
            if (loadingEl) loadingEl.classList.add('hidden');
        });
    }

    function clearUserFilters() {
        const searchInput = document.getElementById('userSearchInput');
        if (searchInput) searchInput.value = '';
        updateClearFiltersVisibility();
        applyUserFilters();
    }

    function updateClearFiltersVisibility() {
        const searchInput = document.getElementById('userSearchInput');
        const clearBtn = document.getElementById('clearUserFiltersBtn');
        
        const hasFilters = searchInput && searchInput.value.trim() !== '';
        
        if (clearBtn) {
            if (hasFilters) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }
    }

    document.getElementById('userSearchInput').addEventListener('input', () => {
        clearTimeout(searchDebounce);
        searchDebounce = setTimeout(() => {
            updateClearFiltersVisibility();
            applyUserFilters();
        }, 300);
    });

    document.getElementById('usersPagination').addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        e.preventDefault();
        const url = new URL(link.href);
        const query = url.searchParams.toString();

        fetch(`${userFilterUrl}?${query}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('usersTableContainer').innerHTML = data.html;
                document.getElementById('usersPagination').innerHTML = data.pagination;
            }
        })
        .catch(error => {
            console.error('Error loading users page:', error);
        });
    });

    updateClearFiltersVisibility();
    </script>
@endsection
