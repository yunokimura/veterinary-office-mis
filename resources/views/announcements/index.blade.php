@php
    $rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'city-vet');
    $currentCategory = request('category');
    $currentStatus = request('status');
    $currentSearch = request('search');
    $currentSort = request('sort', 'newest');
@endphp

@extends('layouts.admin')

@section('title', 'Announcements')

@section('header', 'Announcements')
@section('subheader', 'Manage system announcements')

@section('content')

<!-- Success Message -->
@if(session('success'))
    <div class="m-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between" id="successMessage">
        <div class="flex items-center gap-2">
            <i class="bi bi-check-circle text-green-600"></i>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
        <button onclick="dismissSuccessMessage()" class="text-green-600 hover:text-green-800">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
@endif

<!-- Stats Cards -->
@php
    use App\Models\Announcement;

    $totalCount = Announcement::count();
    $publishedCount = Announcement::where('status', 'Published')->count();
    $draftCount = Announcement::where('status', 'Draft')->count();
    $scheduledCount = Announcement::where('status', 'Scheduled')->count();
    $archivedCount = Announcement::where('status', 'Archived')->count();
@endphp
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Total</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCount }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-megaphone text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Published</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $publishedCount }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Scheduled</p>
                <p class="text-2xl font-bold text-yellow-500 mt-1">{{ $scheduledCount }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-pencil text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Drafts</p>
                <p class="text-2xl font-bold text-gray-500 mt-1">{{ $draftCount }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-file-earmark-text text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Archived</p>
                <p class="text-2xl font-bold text-gray-500 mt-1">{{ $archivedCount }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-archive text-gray-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Announcements Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Announcements</h3>
            <p class="text-sm text-gray-500">Manage announcements, categories, and status</p>
        </div>
        <button type="button" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition shadow-sm"
                data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
            <i class="bi bi-plus-lg mr-1"></i> Create New Announcement
        </button>
    </div>

    <!-- Search & Filters -->
    <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="announcementSearchInput" name="search" value="{{ $currentSearch }}" placeholder="Search announcements..."
                   class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
        </div>
        <div class="flex gap-2">
            <select id="announcementCategorySelect" name="category" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Categories</option>
                <option value="campaign" {{ $currentCategory === 'campaign' ? 'selected' : '' }}>Campaign</option>
                <option value="event" {{ $currentCategory === 'event' ? 'selected' : '' }}>Event</option>
            </select>
            <select id="announcementStatusSelect" name="status" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">All Status</option>
                <option value="Published" {{ $currentStatus === 'Published' ? 'selected' : '' }}>Published</option>
                <option value="Scheduled" {{ $currentStatus === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="Draft" {{ $currentStatus === 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Archived" {{ $currentStatus === 'Archived' ? 'selected' : '' }}>Archived</option>
            </select>
            <select id="announcementSortSelect" name="sort" class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ $currentSort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="title_asc" {{ $currentSort === 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                <option value="title_desc" {{ $currentSort === 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
            </select>
        </div>
    </div>

    <!-- Active Filter Tags -->
    @if($currentSearch || $currentCategory || $currentStatus)
        <div class="px-6 py-3 border-b border-gray-100 bg-white">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-600">Active filters:</span>
                @if($currentSearch)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        Search: "{{ $currentSearch }}"
                        <a href="{{ route($rolePrefix . '.announcements.index', array_filter(request()->except('search'))) }}" class="ml-1 hover:text-blue-900">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif
                @if($currentCategory)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                        Category: {{ ucfirst($currentCategory) }}
                        <a href="{{ route($rolePrefix . '.announcements.index', array_filter(request()->except('category'))) }}" class="ml-1 hover:text-purple-900">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif
                @if($currentStatus)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                        Status: {{ $currentStatus }}
                        <a href="{{ route($rolePrefix . '.announcements.index', array_filter(request()->except('status'))) }}" class="ml-1 hover:text-green-900">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif
            </div>
        </div>
    @endif

    <!-- Table -->
    @if($announcements->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Announcement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organized By</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                        @php
                            $statusColors = [
                                'Published' => 'bg-green-100 text-green-800',
                                'Scheduled' => 'bg-yellow-100 text-yellow-800',
                                'Draft' => 'bg-gray-100 text-gray-800',
                                'Archived' => 'bg-gray-100 text-gray-800'
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50" data-id="{{ $announcement->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        @if($announcement->photo_path)
                                            <img src="{{ $announcement->photo_url }}" alt="{{ $announcement->title }}" class="h-10 w-10 rounded-lg object-cover">
                                        @else
                                            <i class="bi bi-image text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($announcement->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $statusColors[$announcement->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $announcement->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $announcement->organized_by ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="previewAnnouncement({{ $announcement->id }})" class="text-gray-600 hover:text-gray-900 p-1" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" class="text-green-600 hover:text-green-900 p-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="duplicateAnnouncement({{ $announcement->id }})" class="text-blue-600 hover:text-blue-900 p-1" title="Duplicate">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                    <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200" id="announcementsPagination">
            {{ $announcements->links() }}
        </div>
        <div id="announcementsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
    @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-megaphone text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Announcements Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    @endif
</div>

<!-- Preview Modal -->
<div id="previewModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">Announcement Preview</h3>
            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>
        <div id="previewContent" class="p-6 overflow-y-auto" style="max-height: calc(90vh - 140px);">
            <!-- Content loaded dynamically -->
        </div>
        <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-end gap-3">
            <button onclick="closePreviewModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                Close
            </button>
            <a id="previewEditLink" href="#" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>
</div>

<!-- Success Popup Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center h-full w-full z-50">
    <div class="relative p-8 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <i class="bi bi-check-circle text-green-600 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Success!</h3>
            <p class="text-sm text-gray-500 mt-2" id="successModalMessage">{{ session('success') }}</p>
            <div class="mt-6">
                <button onclick="closeSuccessModal()" class="px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="p-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-exclamation-triangle text-3xl text-red-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Confirm Action</h3>
            <p id="confirmMessage" class="text-gray-600 text-center mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    Cancel
                </button>
                <button id="confirmButton" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<style>

/* Custom scrollbar for modal */
#previewContent::-webkit-scrollbar {
    width: 8px;
}

#previewContent::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#previewContent::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

#previewContent::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
// Preview Modal
function previewAnnouncement(id) {
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('previewContent');
    const editLink = document.getElementById('previewEditLink');
    
    content.innerHTML = `
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-eye text-4xl text-gray-400"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Preview Mode</h4>
            <p class="text-gray-500">Preview functionality requires backend implementation to fetch announcement details.</p>
            <p class="text-sm text-gray-400 mt-2">Announcement ID: ${id}</p>
        </div>
    `;
    
    editLink.href = `{{ url($rolePrefix) }}/announcements/${id}/edit`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Duplicate Announcement
function duplicateAnnouncement(id) {
    alert(`Duplicate functionality for announcement ${id} requires backend implementation.`);
}

// Confirmation Modal
function showConfirmModal(message, onConfirm) {
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    document.getElementById('confirmButton').onclick = () => {
        onConfirm();
        closeConfirmModal();
    };
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function closeSuccessModal() {
    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.classList.add('hidden');
    }
}

// Close modals on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closePreviewModal();
        closeConfirmModal();
    }
});

// Close modals on backdrop click
document.getElementById('previewModal').addEventListener('click', (e) => {
    if (e.target.id === 'previewModal') {
        closePreviewModal();
    }
});

document.getElementById('confirmModal').addEventListener('click', (e) => {
    if (e.target.id === 'confirmModal') {
        closeConfirmModal();
    }
});

// Auto-dismiss success message after 15 seconds
@if(session('success'))
    setTimeout(function() {
        dismissSuccessMessage();
    }, 15000);
@endif

function dismissSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        successMessage.style.transition = 'opacity 0.5s ease-out';
        successMessage.style.opacity = '0';
        setTimeout(function() {
            successMessage.remove();
        }, 500);
    }
}

// Check if current user is super admin
const isSuperAdmin = @json(auth()->user()?->isSuperAdmin() ?? false);

// Show success modal only for super admin if there's a success message
@if(session('success'))
    setTimeout(function() {
        if (isSuperAdmin) {
            const successModal = document.getElementById('successModal');
            if (successModal) {
                successModal.classList.remove('hidden');
            }
        }
    }, 100);
@endif

// Real-time Filtering
let searchTimeout;
const filterUrl = '{{ route($rolePrefix . '.announcements.filter') }}';

function applyFilters(page = 1) {
    const search = document.getElementById('announcementSearchInput')?.value || '';
    const category = document.getElementById('announcementCategorySelect')?.value || '';
    const status = document.getElementById('announcementStatusSelect')?.value || '';
    const sort = document.getElementById('announcementSortSelect')?.value || '';

    const params = new URLSearchParams({
        search: search,
        category: category,
        status: status,
        sort: sort,
        page: page
    });

    const tableContainer = document.querySelector('.overflow-x-auto');
    const paginationContainer = document.getElementById('announcementsPagination');
    const loadingEl = document.getElementById('announcementsLoading');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    fetch(`${filterUrl}?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tableCard = document.querySelector('.bg-white.rounded-xl.shadow-sm.border.border-gray-100.overflow-hidden');
                if (tableCard) {
                    const newTable = document.createElement('div');
                    newTable.innerHTML = data.table_html;
                    const existingTable = tableCard.querySelector('.overflow-x-auto');
                    if (existingTable) {
                        existingTable.replaceWith(newTable.firstElementChild);
                    }
                }
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                    paginationContainer.style.opacity = '1';
                }
            }
        })
        .catch(error => {
            console.error('Error filtering announcements:', error);
            if (tableContainer) tableContainer.style.opacity = '1';
            if (paginationContainer) paginationContainer.style.opacity = '1';
        })
        .finally(() => {
            if (loadingEl) loadingEl.classList.add('hidden');
        });
}

function updateAnnouncementsTable(announcements) {
    const tableBody = document.querySelector('.bg-white.rounded-xl.shadow-sm.border.border-gray-100.overflow-hidden table tbody');
    if (!tableBody) return;
    
    if (announcements.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-megaphone text-3xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">No Announcements Found</h4>
                        <p class="text-gray-500">No announcements match your current filters.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tableBody.innerHTML = announcements.map(announcement => `
        <tr class="hover:bg-gray-50" data-id="${announcement.id}">
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        ${announcement.photo_path ? 
                            `<img src="${announcement.photo_url}" alt="${announcement.title}" class="h-10 w-10 rounded-lg object-cover">` :
                            `<i class="bi bi-image text-gray-400"></i>`
                        }
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${announcement.title}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                    ${announcement.category.charAt(0).toUpperCase() + announcement.category.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${getTableStatusBadge(announcement.status)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${new Date(announcement.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${announcement.organized_by || '-'}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                <div class="flex items-center justify-end gap-2">
                    <button onclick="previewAnnouncement(${announcement.id})" class="text-gray-600 hover:text-gray-900 p-1" title="Preview">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="{{ url($rolePrefix) }}/announcements/${announcement.id}/edit" class="text-green-600 hover:text-green-900 p-1" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button onclick="duplicateAnnouncement(${announcement.id})" class="text-blue-600 hover:text-blue-900 p-1" title="Duplicate">
                        <i class="bi bi-copy"></i>
                    </button>
                    <form action="{{ url($rolePrefix) }}/announcements/${announcement.id}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    `).join('');
}

function getTableStatusBadge(status) {
    const colors = {
        'Published': 'bg-green-100 text-green-800',
        'Scheduled': 'bg-yellow-100 text-yellow-800',
        'Draft': 'bg-gray-100 text-gray-800',
        'Archived': 'bg-gray-100 text-gray-800'
    };
    return `<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold ${colors[status] || 'bg-gray-100 text-gray-800'}">
        ${status}
    </span>`;
}

// Event Listeners for Real-time Filtering
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('announcementSearchInput');
    const categorySelect = document.getElementById('announcementCategorySelect');
    const statusSelect = document.getElementById('announcementStatusSelect');
    const sortSelect = document.getElementById('announcementSortSelect');

    // Search input with debounce
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters(1);
            }, 300);
        });
    }

    // Category filter
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            applyFilters(1);
        });
    }

    // Status filter
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            applyFilters(1);
        });
    }

    // Sort filter
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            applyFilters(1);
        });
    }
});

// Image preview for create modal form
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('photo_path');
    const preview = document.getElementById('imagePreview');
    input.value = '';
    preview.classList.add('hidden');
}

// Attachment preview
function previewAttachment(event) {
    const input = event.target;
    const preview = document.getElementById('attachmentPreview');
    const nameSpan = document.getElementById('attachmentName');

    if (input.files && input.files[0]) {
        nameSpan.textContent = 'Selected: ' + input.files[0].name;
        preview.classList.remove('hidden');
    }
}

function removeAttachment() {
    const input = document.getElementById('attachment_path');
    const preview = document.getElementById('attachmentPreview');
    input.value = '';
    preview.classList.add('hidden');
}

// Inline Success Toast
function showInlineSuccess(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 z-[60] bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2';
    toast.innerHTML = `<i class="bi bi-check-circle"></i><span>${message}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Add Announcement Modal (Bootstrap)
let addAnnouncementModal;
let isDraft = false;
let isScheduled = false;

document.addEventListener('DOMContentLoaded', function() {
    const addAnnouncementModalEl = document.getElementById('addAnnouncementModal');
    addAnnouncementModal = new bootstrap.Modal(addAnnouncementModalEl);

    const form = document.getElementById('announcementForm');
    const draftBtn = document.querySelector('[data-action="draft"]');
    const scheduledBtn = document.querySelector('[data-action="scheduled"]');

    if (draftBtn) {
        draftBtn.addEventListener('click', function() {
            isDraft = true;
            isScheduled = false;
            form.dispatchEvent(new Event('submit', {cancelable: true}));
        });
    }

    if (scheduledBtn) {
        scheduledBtn.addEventListener('click', function() {
            isScheduled = true;
            isDraft = false;
            form.dispatchEvent(new Event('submit', {cancelable: true}));
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const statusField = document.getElementById('status');
            if (isDraft && statusField) {
                statusField.value = 'Draft';
            }
            if (isScheduled && statusField) {
                statusField.value = 'Scheduled';
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Creating...';

            const formData = new FormData(form);
            const contactInput = document.getElementById('contact_number');
            if (contactInput && contactInput.value) {
                contactInput.value = contactInput.value.replace(/\s/g, '');
            }

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
                body: formData,
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
                    addAnnouncementModal.hide();
                    showInlineSuccess(data.message || 'Announcement created successfully.');
                    applyFilters(1);
                }
            })
            .catch(error => {
                if (error.errors) {
                    showAnnouncementFormErrors(error.errors);
                } else if (error.message) {
                    showInlineError(error.message);
                } else {
                    showInlineError('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                if (statusField) {
                    statusField.value = 'Published';
                }
                isDraft = false;
                isScheduled = false;
            });
        });
    }

    if (addAnnouncementModalEl) {
        addAnnouncementModalEl.addEventListener('show.bs.modal', function () {
            if (form) {
                form.reset();
                form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                form.querySelectorAll('.text-red-600').forEach(el => el.remove());
            }
            const categoryElement = document.getElementById('category');
            if (categoryElement) {
                categoryElement.dispatchEvent(new Event('change'));
            }
        });

        addAnnouncementModalEl.addEventListener('hidden.bs.modal', function () {
            if (form) {
                form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
                form.querySelectorAll('.text-red-600').forEach(el => el.remove());
            }
        });
    }
});

function showAnnouncementFormErrors(errors) {
    const form = document.getElementById('announcementForm');
    form.querySelectorAll('.text-red-600').forEach(el => el.remove());
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

    for (const [field, messages] of Object.entries(errors)) {
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

function showInlineError(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 z-[60] bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2';
    toast.innerHTML = `<i class="bi bi-exclamation-circle"></i><span>${message}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}
</script>

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnnouncementModalLabel">New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('announcements._form', ['modal' => true])
            </div>
        </div>
    </div>
</div>

@endsection
