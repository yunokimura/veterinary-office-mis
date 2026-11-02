@php $rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'city-vet'); @endphp

@extends('layouts.admin')

@section('title', 'Edit Announcement - VetMIS')

@section('header', 'Announcement')
@section('subheader', 'Update System announcement')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route($rolePrefix . '.announcements.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Announcements</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="m-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle text-green-600"></i>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="bi bi-pencil-square me-2"></i>Edit Announcement
            </h3>
            <p class="text-sm text-gray-500">Update the announcement details below</p>
        </div>

        <form action="{{ route($rolePrefix . '.announcements.update', $announcement) }}" method="POST"
              enctype="multipart/form-data"
              id="announcementForm">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="px-6 pt-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-card-heading me-1 text-green-600"></i>Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('title') border-red-500 @enderror"
                       id="title"
                       name="title"
                       value="{{ old('title', $announcement->title) }}"
                       placeholder="Enter announcement title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category & Status Row -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-tag me-1 text-green-600"></i>Category <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 @error('category') border-red-500 @enderror"
                            id="category"
                            name="category"
                            required
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                        <option value="">Select category</option>
                        <option value="campaign" {{ old('category', $announcement->category) == 'campaign' ? 'selected' : '' }}>Campaign</option>
                        <option value="event" {{ old('category', $announcement->category) == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="announcement" {{ old('category', $announcement->category) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-toggle-on me-1 text-green-600"></i>Status <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror"
                            id="status"
                            name="status"
                            required
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                         <option value="">Select status</option>
                         <option value="Draft" {{ old('status', $announcement->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                         <option value="Scheduled" {{ old('status', $announcement->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                         <option value="Published" {{ old('status', $announcement->status) == 'Published' ? 'selected' : '' }}>Published</option>
                         <option value="Archived" {{ old('status', $announcement->status) == 'Archived' ? 'selected' : '' }}>Archived</option>
                     </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

             <!-- Event Date & Time & Barangay & Location Row -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Event Date (conditional on Event category) -->
                <div class="event-fields @if(old('category', $announcement->category) != 'event') hidden @endif">
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-calendar-event me-1 text-green-600"></i>Event Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_date') border-red-500 @enderror"
                           id="event_date"
                           name="event_date"
                           value="{{ old('event_date', $announcement->event_date) }}"
                           required>
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Time (conditional on Event category) -->
                <div class="event-fields @if(old('category', $announcement->category) != 'event') hidden @endif">
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock me-1 text-green-600"></i>Event Time
                    </label>
                    <input type="time"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_time') border-red-500 @enderror"
                           id="event_time"
                           name="event_time"
                           value="{{ old('event_time', $announcement->event_time) }}">
                    @error('event_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Barangay -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt me-1 text-green-600"></i>Barangay
                    </label>
                    <div class="relative">
                        <button type="button" id="barangayDisplay" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors text-left flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" onclick="openBarangayModal()">
                            <span id="selectedBarangayText" class="text-sm text-gray-700 truncate">Select Barangay</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 ml-auto pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    <!-- Hidden input for barangay -->
                    <input type="hidden" id="barangayIdInput" name="barangay_id" value="{{ old('barangay_id', $announcement->barangay_id ?? '') }}">
                    @error('barangay_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location (conditional on Event category) -->
                <div class="event-fields @if(old('category', $announcement->category) != 'event') hidden @endif">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt me-1 text-green-600"></i>Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('location') border-red-500 @enderror"
                           id="location"
                           name="location"
                           value="{{ old('location', $announcement->location) }}"
                           placeholder="Enter event location"
                           required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-text-paragraph me-1 text-green-600"></i>Content <span class="text-red-500">*</span>
                </label>
                <textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('content') border-red-500 @enderror"
                          id="content"
                          name="content"
                          rows="8"
                          placeholder="Enter full description"
                          required>{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-image me-1 text-green-600"></i>
                    {{ $announcement->photo_path ? 'Replace Photo (Optional)' : 'Photo (Optional)' }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition">
                    <input type="file"
                           class="hidden"
                           id="photo_path"
                           name="photo_path"
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(event)">
                    <label for="photo_path" class="cursor-pointer">
                        <i class="bi bi-cloud-upload text-3xl text-gray-400 mb-2 block"></i>
                        <p class="text-sm text-gray-600">Click to upload photo</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                    </label>
                </div>
                @error('photo_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Current Photo Preview -->
                @if($announcement->photo_path)
                    <div class="mt-4" id="currentPhoto">
                        <div class="flex items-center gap-4">
                            <img src="{{ $announcement->photo_url }}"
                                 alt="Current photo"
                                 class="rounded-lg object-cover"
                                 style="max-height: 100px;">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       id="remove_photo"
                                       name="remove_photo"
                                       value="1"
                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                <span class="text-sm text-red-600">Remove current photo</span>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- New Image Preview -->
                <div class="mt-4 hidden" id="imagePreview">
                    <div class="relative inline-block">
                        <img id="previewImg" src="" alt="Preview"
                             class="rounded-lg object-cover"
                             style="max-height: 200px; max-width: 100%;">
                        <button type="button" class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700 transition"
                                onclick="removeImage()" title="Remove image">
                            <i class="bi bi-x-lg text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attachment Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-paperclip me-1 text-green-600"></i>
                    {{ $announcement->attachment_path ? 'Replace Attachment (Optional)' : 'Attachment (Optional - PDF only)' }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition">
                    <input type="file"
                           class="hidden"
                           id="attachment_path"
                           name="attachment_path"
                           accept="application/pdf"
                           onchange="previewAttachment(event)">
                    <label for="attachment_path" class="cursor-pointer">
                        <i class="bi bi-file-earmark-text text-3xl text-gray-400 mb-2 block"></i>
                        <p class="text-sm text-gray-600">Click to upload PDF</p>
                        <p class="text-xs text-gray-400 mt-1">PDF up to 5MB</p>
                    </label>
                </div>
                @error('attachment_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Current Attachment -->
                @if($announcement->attachment_path)
                    <div class="mt-4" id="currentAttachment">
                        <div class="flex items-center gap-4">
                            <a href="{{ $announcement->attachment_url }}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                <i class="bi bi-file-earmark-pdf"></i>
                                <span>View Current Attachment</span>
                            </a>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       id="remove_attachment"
                                       name="remove_attachment"
                                       value="1"
                                       class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                <span class="text-sm text-red-600">Remove</span>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- New Attachment Preview -->
                <div class="mt-4 hidden" id="attachmentPreview">
                    <div class="flex items-center gap-4">
                        <span id="attachmentName" class="text-sm text-green-600 font-medium"></span>
                        <button type="button" class="text-red-600 hover:text-red-800 text-sm"
                                onclick="removeAttachment()">
                            <i class="bi bi-x-lg me-1"></i>Remove
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="px-6 py-6 mt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-end gap-3">
                <a href="{{ route($rolePrefix . '.announcements.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                    <i class="bi bi-check-circle me-2"></i>Update Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Barangay Selection Modal -->
<div id="barangayModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="barangayModalTitle">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeBarangayModal()"></div>
    <div class="fixed inset-0 flex items-end sm:items-center sm:justify-center p-0 sm:p-4">
        <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="px-5 pt-5 pb-4 border-b border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 18h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                        </svg>
                        <h3 id="barangayModalTitle" class="text-lg font-semibold text-gray-900">Select Barangay</h3>
                    </div>
                    <button type="button" onclick="closeBarangayModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors" aria-label="Close barangay selector">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Search bar -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="barangayModalSearch" placeholder="Search barangay..." onkeyup="filterBarangayModal()"
                           class="w-full pl-9 pr-3 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all" autocomplete="off">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto min-h-[360px]">
                <div class="px-5 pt-4 pb-4">
                    <!-- Alphabetical List -->
                    <div id="barangayModalList"></div>

                    <!-- Empty search state -->
                    <div id="barangayModalEmpty" class="hidden text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-xs text-gray-700">No barangays match your search.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-4 border-t border-gray-200 bg-white">
                <button type="button" onclick="closeBarangayModal()" class="w-full px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const barangaysData = @json($barangays);

    // Category change handler - toggle event fields
    document.getElementById('category').addEventListener('change', function() {
        const eventFields = document.querySelectorAll('.event-fields');
        const eventDateInput = document.getElementById('event_date');
        const eventTimeInput = document.getElementById('event_time');
        const locationInput = document.getElementById('location');
        if (this.value === 'event') {
            eventFields.forEach(el => el.classList.remove('hidden'));
            // Make event fields required
            if (eventDateInput) eventDateInput.setAttribute('required', 'required');
            if (locationInput) locationInput.setAttribute('required', 'required');
        } else {
            eventFields.forEach(el => el.classList.add('hidden'));
            // Remove required attributes
            if (eventDateInput) eventDateInput.removeAttribute('required');
            if (eventTimeInput) eventTimeInput.removeAttribute('required');
            if (locationInput) locationInput.removeAttribute('required');
        }
    });

    // Image preview
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const currentPhoto = document.getElementById('currentPhoto');

        if (input.files && input.files[0]) {
            if (currentPhoto) {
                currentPhoto.style.display = 'none';
            }
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
        const currentPhoto = document.getElementById('currentPhoto');

        input.value = '';
        preview.classList.add('hidden');
        if (currentPhoto) {
            currentPhoto.style.display = 'block';
        }
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

      // Initialize on page load
     document.addEventListener('DOMContentLoaded', function() {
         // Trigger category change to set initial state
         document.getElementById('category').dispatchEvent(new Event('change'));
     });

    // Open the barangay selector modal
    function openBarangayModal() {
        const modal = document.getElementById('barangayModal');
        modal.classList.remove('hidden');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('role', 'dialog');
        document.body.classList.add('overflow-hidden');

        document.getElementById('barangayModalSearch').value = '';
        renderBarangayModal();

        setTimeout(() => {
            const searchInput = document.getElementById('barangayModalSearch');
            if (searchInput) searchInput.focus();
        }, 50);
    }

    // Close the barangay selector modal
    function closeBarangayModal() {
        const modal = document.getElementById('barangayModal');
        modal.classList.add('hidden');
        modal.removeAttribute('aria-modal');
        modal.removeAttribute('role');
        document.body.classList.remove('overflow-hidden');
    }

    // Render the barangay list grouped alphabetically
    function renderBarangayModal(filter = '') {
        const search = filter.trim().toLowerCase();
        const filtered = barangaysData.filter(b => String(b.barangay_name).toLowerCase().includes(search));
        const list = document.getElementById('barangayModalList');
        const empty = document.getElementById('barangayModalEmpty');

        if (filtered.length === 0) {
            list.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');

        // Group by first letter
        const groups = {};
        filtered.forEach(b => {
            const letter = String(b.barangay_name).charAt(0).toUpperCase();
            if (!groups[letter]) groups[letter] = [];
            groups[letter].push(b);
        });

        let html = '';
        html += `
            <button type="button" onclick="handleBarangaySelect('', 'All Barangays')"
                    class="w-full flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors text-left text-gray-700 hover:bg-white mb-2 border-b border-gray-100 pb-2">
                All Barangays
            </button>`;
        Object.keys(groups).sort().forEach(letter => {
            html += `
                <div class="mb-4">
                    <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 py-1.5">
                        <span class="text-xs font-bold text-green-700 uppercase tracking-wider bg-green-50 border border-green-200 rounded-md px-2 py-0.5">${letter}</span>
                    </div>
                    <div class="space-y-1 mt-1">`;
            groups[letter].forEach(b => {
                const selected = document.getElementById('barangayIdInput').value == b.barangay_id;
                html += `
                    <button type="button" onclick="handleBarangaySelect(${b.barangay_id}, '${String(b.barangay_name).replace(/'/g, "\\'")}')"
                            class="w-full flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors text-left ${selected ? 'bg-green-50 text-green-800 font-semibold' : 'text-gray-700 hover:bg-white'}">
                        ${b.barangay_name}
                    </button>`;
            });
            html += `</div></div>`;
        });

        list.innerHTML = html;
    }

    // Filter the barangay list as the user types
    function filterBarangayModal() {
        renderBarangayModal(document.getElementById('barangayModalSearch').value);
    }

    // Handle barangay selection
    function handleBarangaySelect(id, name) {
        document.getElementById('barangayIdInput').value = id;
        document.getElementById('selectedBarangayText').textContent = name;
        closeBarangayModal();
    }
   </script>
@endsection
