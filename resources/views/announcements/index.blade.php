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
    $archivedCount = Announcement::where('status', 'Archived')->count();
@endphp
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                <p class="text-xs font-medium text-gray-500">Drafts</p>
                <p class="text-2xl font-bold text-yellow-500 mt-1">{{ $draftCount }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-pencil text-yellow-600 text-xl"></i>
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

<!-- Filter & Search Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="GET" action="{{ route($rolePrefix . '.announcements.index') }}" class="flex flex-wrap gap-4 items-center">
        <!-- Search Input -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="flex items-center relative">
                <input
                    type="text"
                    name="search"
                    value="{{ $currentSearch }}"
                    placeholder="Search announcements..."
                    class="flex-1 pl-3 pr-8 py-2 border border-gray-300 rounded-lg rounded-r-none outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 h-10"
                >
                <button type="submit" class="px-3 py-2 border border-gray-300 border-l-0 rounded-lg rounded-l-none bg-gray-50 text-gray-500 hover:text-green-600 hover:bg-green-50 transition-colors h-10 flex items-center justify-center">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="relative w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" class="w-full px-3 py-2 pr-10 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 6px center; background-size: 12px 12px;">
                <option value="">All Categories</option>
                <option value="campaign" {{ $currentCategory === 'campaign' ? 'selected' : '' }}>Campaign</option>
                <option value="event" {{ $currentCategory === 'event' ? 'selected' : '' }}>Event</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="relative w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 pr-10 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 6px center; background-size: 12px 12px;">
                <option value="">All Status</option>
                <option value="Published" {{ $currentStatus === 'Published' ? 'selected' : '' }}>Published</option>
                <option value="Draft" {{ $currentStatus === 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Archived" {{ $currentStatus === 'Archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <!-- Sort -->
        <div class="relative w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
            <select name="sort" class="w-full px-3 py-2 pr-10 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 h-10 text-sm"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 6px center; background-size: 12px 12px;">
                <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ $currentSort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="title_asc" {{ $currentSort === 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                <option value="title_desc" {{ $currentSort === 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
            </select>
        </div>

        @if($currentSearch || $currentCategory || $currentStatus)
            <a href="{{ route($rolePrefix . '.announcements.index') }}" class="inline-flex items-center gap-1 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition h-10">
                <i class="bi bi-x-circle"></i>
                Clear Filters
            </a>
        @endif
    </form>
</div>

<div class="mt-2 pt-3 border-t border-gray-100 mb-4">
    <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition shadow-sm">
        <i class="bi bi-plus-circle"></i>
        Add Announcement
    </a>
</div>

<!-- Active Filter Tags -->
@if($currentSearch || $currentCategory || $currentStatus)
    <div class="mt-4 pt-4 border-t border-gray-100">
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

<!-- Bulk Actions Toolbar (Hidden by default) -->
<div id="bulkActionsToolbar" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-blue-900">
                <span id="selectedCount">0</span> item(s) selected
            </span>
            <button onclick="clearSelection()" class="text-sm text-blue-600 hover:text-blue-800 underline">
                Clear selection
            </button>
        </div>
        <div class="flex items-center gap-2">
            <div class="relative">
                <select id="bulkStatusChange" class="px-4 py-3 pr-10 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 appearance-none">
                    <option value="">Change Status To...</option>
                    <option value="Published">Published</option>
                    <option value="Draft">Draft</option>
                    <option value="Archived">Archived</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="bi bi-chevron-down text-gray-400 text-sm"></i>
                </div>
            </div>
            <button onclick="executeBulkStatusChange()" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Apply
            </button>
            <button onclick="confirmBulkDelete()" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
        </div>
    </div>
</div>

<!-- Announcements Grid -->
@if($announcements->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($announcements as $announcement)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group" data-id="{{ $announcement->id }}">
                <!-- Card Header with Image -->
                <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    @if($announcement->photo_path)
                        <img src="{{ $announcement->photo_url }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="bi bi-image text-3xl text-gray-400"></i>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @php
                            $statusColors = [
                                'Published' => 'bg-green-500',
                                'Draft' => 'bg-yellow-500',
                                'Archived' => 'bg-gray-500'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-lg {{ $statusColors[$announcement->status] ?? 'bg-gray-500' }}">
                            {{ $announcement->status }}
                        </span>
                    </div>

                    <!-- Checkbox for Bulk Actions -->
                    <div class="absolute top-3 left-3">
                        <input 
                            type="checkbox" 
                            class="announcement-checkbox w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" 
                            value="{{ $announcement->id }}"
                            onchange="updateBulkActions()"
                        >
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Category Badge -->
                    <div class="mb-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                            <i class="bi bi-tag mr-1"></i>
                            {{ ucfirst($announcement->category) }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors line-clamp-2">{{ $announcement->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 text-sm">{{ $announcement->content }}</p>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-4">
                        @if($announcement->organized_by)
                            <span class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 rounded-lg">
                                <i class="bi bi-person mr-1.5 text-blue-500"></i>
                                {{ $announcement->organized_by }}
                            </span>
                        @endif
                        <span class="inline-flex items-center px-2.5 py-1.5 bg-green-50 rounded-lg">
                            <i class="bi bi-calendar mr-1.5 text-green-500"></i>
                            {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                        </span>
                        @if($announcement->updated_at != $announcement->created_at)
                            <span class="inline-flex items-center px-2.5 py-1.5 bg-gray-50 rounded-lg">
                                <i class="bi bi-pencil mr-1.5 text-gray-500"></i>
                                Updated {{ \Carbon\Carbon::parse($announcement->updated_at)->diffForHumans() }}
                            </span>
                        @endif
                    </div>

                    <!-- Quick Status Toggle -->
                    <div class="mb-4">
                        <label class="text-xs font-medium text-gray-600 mb-1.5 block">Quick Status Change:</label>
                        <div class="relative">
                            <select 
                                onchange="quickStatusChange({{ $announcement->id }}, this.value)" 
                                class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none"
                            >
                                <option value="">-- Select Status --</option>
                                <option value="Published" {{ $announcement->status === 'Published' ? 'selected' : '' }}>Published</option>
                                <option value="Draft" {{ $announcement->status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Archived" {{ $announcement->status === 'Archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="bi bi-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                        <button 
                            onclick="previewAnnouncement({{ $announcement->id }})" 
                            class="flex items-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg transition text-sm"
                            title="Preview"
                        >
                            <i class="bi bi-eye"></i>
                            <span class="font-medium">Preview</span>
                        </button>
                        <a 
                            href="{{ route($rolePrefix . '.announcements.edit', $announcement) }}" 
                            class="flex items-center gap-1.5 px-3 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition text-sm"
                            title="Edit"
                        >
                            <i class="bi bi-pencil"></i>
                            <span class="font-medium">Edit</span>
                        </a>
                        <button 
                            onclick="duplicateAnnouncement({{ $announcement->id }})" 
                            class="flex items-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition text-sm"
                            title="Duplicate"
                        >
                            <i class="bi bi-copy"></i>
                            <span class="font-medium">Duplicate</span>
                        </button>
                        <form action="{{ route($rolePrefix . '.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition text-sm" title="Delete">
                                <i class="bi bi-trash"></i>
                                <span class="font-medium">Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600">
            Showing <span class="font-semibold">{{ $announcements->count() }}</span> of <span class="font-semibold">{{ $announcements->total() }}</span> announcements
        </div>
        <div class="flex gap-2">
            {{ $announcements->links() }}
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="bi bi-megaphone text-5xl text-gray-300"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">No Announcements Found</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">
            @if($currentSearch || $currentCategory || $currentStatus)
                No announcements match your current filters. Try adjusting your search criteria.
            @else
                Create your first announcement to keep the public informed about campaigns, events, and important updates.
            @endif
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            @if($currentSearch || $currentCategory || $currentStatus)
                <a href="{{ route($rolePrefix . '.announcements.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                    <i class="bi bi-x-circle"></i>
                    Clear Filters
                </a>
            @endif
            <a href="{{ route($rolePrefix . '.announcements.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-lg hover:bg-green-700 transition">
                <i class="bi bi-plus-circle text-lg"></i>
                Create Announcement
            </a>
        </div>
    </div>
@endif

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
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.announcement-checkbox {
    cursor: pointer;
    accent-color: #16a34a;
}

/* Smooth transitions */
.group {
    transition: all 0.3s ease;
}

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
// Bulk Actions
let selectedAnnouncements = new Set();

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.announcement-checkbox:checked');
    selectedAnnouncements = new Set(Array.from(checkboxes).map(cb => cb.value));
    
    const toolbar = document.getElementById('bulkActionsToolbar');
    const countSpan = document.getElementById('selectedCount');
    
    if (selectedAnnouncements.size > 0) {
        toolbar.classList.remove('hidden');
        countSpan.textContent = selectedAnnouncements.size;
    } else {
        toolbar.classList.add('hidden');
    }
}

function clearSelection() {
    document.querySelectorAll('.announcement-checkbox').forEach(cb => cb.checked = false);
    selectedAnnouncements.clear();
    updateBulkActions();
}

function confirmBulkDelete() {
    if (selectedAnnouncements.size === 0) return;
    
    const message = `Are you sure you want to delete ${selectedAnnouncements.size} announcement(s)? This action cannot be undone.`;
    showConfirmModal(message, () => executeBulkDelete());
}

function executeBulkDelete() {
    // This would need backend implementation
    alert('Bulk delete requires backend implementation. Selected IDs: ' + Array.from(selectedAnnouncements).join(', '));
    closeConfirmModal();
}

function executeBulkStatusChange() {
    const newStatus = document.getElementById('bulkStatusChange').value;
    if (!newStatus || selectedAnnouncements.size === 0) {
        alert('Please select a status and at least one announcement.');
        return;
    }
    
    // This would need backend implementation
    alert(`Bulk status change to "${newStatus}" requires backend implementation. Selected IDs: ` + Array.from(selectedAnnouncements).join(', '));
}

// Quick Status Change
function quickStatusChange(id, newStatus) {
    if (!newStatus) return;
    
    // This would need backend implementation
    alert(`Quick status change to "${newStatus}" for announcement ${id} requires backend implementation.`);
}

// Preview Modal
function previewAnnouncement(id) {
    // This would need backend implementation to fetch announcement data
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('previewContent');
    const editLink = document.getElementById('previewEditLink');
    
    // Placeholder content - would be replaced with actual data from backend
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
    // This would need backend implementation
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
    // Stay on the current page (announcements index)
    // No redirect needed since we're already on the index page
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
    }, 15000); // 15 seconds
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
    const search = document.querySelector('input[name="search"]').value;
    const category = document.querySelector('select[name="category"]').value;
    const status = document.querySelector('select[name="status"]').value;
    const sort = document.querySelector('select[name="sort"]').value;

    const params = new URLSearchParams({
        search: search,
        category: category,
        status: status,
        sort: sort,
        page: page
    });

    // Show loading state
    const grid = document.querySelector('.grid.grid-cols-1.lg\\:grid-cols-2');
    if (grid) {
        grid.style.opacity = '0.5';
        grid.style.pointerEvents = 'none';
    }

    fetch(`${filterUrl}?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            updateAnnouncementsGrid(data.announcements);
            updatePagination(data.pagination);
            
            // Restore grid state
            if (grid) {
                grid.style.opacity = '1';
                grid.style.pointerEvents = 'auto';
            }

            // Update URL without reload
            const newUrl = new URL(window.location);
            if (search) newUrl.searchParams.set('search', search);
            else newUrl.searchParams.delete('search');
            if (category) newUrl.searchParams.set('category', category);
            else newUrl.searchParams.delete('category');
            if (status) newUrl.searchParams.set('status', status);
            else newUrl.searchParams.delete('status');
            if (sort && sort !== 'newest') newUrl.searchParams.set('sort', sort);
            else newUrl.searchParams.delete('sort');
            window.history.pushState({}, '', newUrl);
        })
        .catch(error => {
            console.error('Error filtering announcements:', error);
            if (grid) {
                grid.style.opacity = '1';
                grid.style.pointerEvents = 'auto';
            }
        });
}

function updateAnnouncementsGrid(announcements) {
    const grid = document.querySelector('.grid.grid-cols-1.lg\\:grid-cols-2');
    const emptyState = document.querySelector('.bg-gradient-to-br.from-gray-50');
    
    if (announcements.length === 0) {
        // Show empty state
        if (grid) grid.style.display = 'none';
        if (emptyState) emptyState.style.display = 'block';
        return;
    }

    // Hide empty state
    if (emptyState) emptyState.style.display = 'none';
    
    // Update grid
    if (grid) {
        grid.style.display = 'grid';
        grid.innerHTML = announcements.map(announcement => `
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group" data-id="${announcement.id}">
                <!-- Card Header with Image -->
                <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    ${announcement.photo_path ? 
                        `<img src="${announcement.photo_url}" alt="${announcement.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">` :
                        `<div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="bi bi-image text-3xl text-gray-400"></i>
                            </div>
                        </div>`
                    }
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        ${getStatusBadge(announcement.status)}
                    </div>

                    <!-- Checkbox for Bulk Actions -->
                    <div class="absolute top-3 left-3">
                        <input 
                            type="checkbox" 
                            class="announcement-checkbox w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" 
                            value="${announcement.id}"
                            onchange="updateBulkActions()"
                        >
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Category Badge -->
                    <div class="mb-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                            <i class="bi bi-tag mr-1"></i>
                            ${announcement.category.charAt(0).toUpperCase() + announcement.category.slice(1)}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors line-clamp-2">${announcement.title}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 text-sm">${announcement.content}</p>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-4">
                        ${announcement.organized_by ? `
                            <span class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 rounded-lg">
                                <i class="bi bi-person mr-1.5 text-blue-500"></i>
                                ${announcement.organized_by}
                            </span>
                        ` : ''}
                        <span class="inline-flex items-center px-2.5 py-1.5 bg-green-50 rounded-lg">
                            <i class="bi bi-calendar mr-1.5 text-green-500"></i>
                            ${new Date(announcement.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                        </span>
                        ${announcement.updated_at != announcement.created_at ? `
                            <span class="inline-flex items-center px-2.5 py-1.5 bg-gray-50 rounded-lg">
                                <i class="bi bi-pencil mr-1.5 text-gray-500"></i>
                                Updated ${timeAgo(announcement.updated_at)}
                            </span>
                        ` : ''}
                    </div>

                    <!-- Quick Status Toggle -->
                    <div class="mb-4">
                        <label class="text-xs font-medium text-gray-600 mb-1.5 block">Quick Status Change:</label>
                        <div class="relative">
                            <select 
                                onchange="quickStatusChange(${announcement.id}, this.value)" 
                                class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none"
                            >
                                <option value="">-- Select Status --</option>
                                <option value="Published" ${announcement.status === 'Published' ? 'selected' : ''}>Published</option>
                                <option value="Draft" ${announcement.status === 'Draft' ? 'selected' : ''}>Draft</option>
                                <option value="Archived" ${announcement.status === 'Archived' ? 'selected' : ''}>Archived</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="bi bi-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                        <button 
                            onclick="previewAnnouncement(${announcement.id})" 
                            class="flex items-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg transition text-sm"
                            title="Preview"
                        >
                            <i class="bi bi-eye"></i>
                            <span class="font-medium">Preview</span>
                        </button>
                        <a 
                            href="{{ route($rolePrefix . '.announcements.edit', ':id') }}".replace(':id', ${announcement.id}) 
                            class="flex items-center gap-1.5 px-3 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition text-sm"
                            title="Edit"
                        >
                            <i class="bi bi-pencil"></i>
                            <span class="font-medium">Edit</span>
                        </a>
                        <button 
                            onclick="duplicateAnnouncement(${announcement.id})" 
                            class="flex items-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition text-sm"
                            title="Duplicate"
                        >
                            <i class="bi bi-copy"></i>
                            <span class="font-medium">Duplicate</span>
                        </button>
                        <form action="{{ route($rolePrefix . '.announcements.destroy', ':id') }}".replace(':id', ${announcement.id}) method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition text-sm" title="Delete">
                                <i class="bi bi-trash"></i>
                                <span class="font-medium">Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function getStatusBadge(status) {
    const colors = {
        'Published': 'bg-green-500',
        'Draft': 'bg-yellow-500',
        'Archived': 'bg-gray-500'
    };
    return `<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-lg ${colors[status] || 'bg-gray-500'}">
        ${status}
    </span>`;
}

function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    const intervals = {
        'year': 31536000,
        'month': 2592000,
        'week': 604800,
        'day': 86400,
        'hour': 3600,
        'minute': 60
    };
    
    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / secondsInUnit);
        if (interval >= 1) {
            return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
        }
    }
    return 'Just now';
}

function updatePagination(pagination) {
    const paginationContainer = document.querySelector('.mt-8.flex.flex-col.sm\\:flex-row');
    if (!paginationContainer) return;

    const showingText = paginationContainer.querySelector('.text-sm.text-gray-600');
    const linksContainer = paginationContainer.querySelector('.flex.gap-2');

    if (showingText) {
        showingText.innerHTML = `Showing <span class="font-semibold">${pagination.from || 0}</span> to <span class="font-semibold">${pagination.to || 0}</span> of <span class="font-semibold">${pagination.total}</span> announcements`;
    }

    if (linksContainer && pagination.last_page > 1) {
        let paginationHTML = '';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHTML += `<button onclick="applyFilters(${pagination.current_page - 1})" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">
                <i class="bi bi-chevron-left"></i> Previous
            </button>`;
        }
        
        // Page numbers
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                paginationHTML += `<button class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm">${i}</button>`;
            } else {
                paginationHTML += `<button onclick="applyFilters(${i})" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">${i}</button>`;
            }
        }
        
        // Next button
        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `<button onclick="applyFilters(${pagination.current_page + 1})" class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">
                Next <i class="bi bi-chevron-right"></i>
            </button>`;
        }
        
        linksContainer.innerHTML = paginationHTML;
    }
}

// Event Listeners for Real-time Filtering
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const categorySelect = document.querySelector('select[name="category"]');
    const statusSelect = document.querySelector('select[name="status"]');
    const sortSelect = document.querySelector('select[name="sort"]');

    // Search input with debounce
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters(1);
            }, 500); // 500ms debounce
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
</script>
@endsection
