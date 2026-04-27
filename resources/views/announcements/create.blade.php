@php $rolePrefix = str_replace('_', '-', auth()->user()->getRoleAttribute() ?? 'city-vet'); @endphp

@extends('layouts.admin')

@section('title', 'Create Announcement')

@section('header', 'Create Announcement')
@section('subheader', 'Create a new system announcement')

@section('content')
<div class="max-w-4xl mx-auto">
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
            <h3 class="text-lg font-semibold text-gray-800">New Announcement Details</h3>
            <p class="text-sm text-gray-500">Fill in the information below to create a new announcement</p>
        </div>

        <form action="{{ route($rolePrefix . '.announcements.store') }}" method="POST" enctype="multipart/form-data" id="announcementForm">
            @csrf

            <!-- Title -->
            <div class="px-6 pt-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-card-heading me-1 text-green-600"></i>Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('title') border-red-500 @enderror"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
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
                        <option value="campaign" {{ old('category') == 'campaign' ? 'selected' : '' }}>Campaign</option>
                        <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
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
                        <option value="Draft" {{ old('status', 'Draft') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                        <option value="Archived" {{ old('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

             <!-- Event Details Row (conditional) -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 event-fields @if(old('category') != 'event') hidden @endif">
                <!-- Event Date -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-calendar-event me-1 text-green-600"></i>Event Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_date') border-red-500 @enderror"
                           id="event_date"
                           name="event_date"
                           value="{{ old('event_date') }}">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Time -->
                <div>
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock me-1 text-green-600"></i>Event Time
                    </label>
                    <input type="time"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('event_time') border-red-500 @enderror"
                           id="event_time"
                           name="event_time"
                           value="{{ old('event_time') }}">
                    @error('event_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt me-1 text-green-600"></i>Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('location') border-red-500 @enderror"
                           id="location"
                           name="location"
                           value="{{ old('location') }}"
                           placeholder="Enter event location"
                           required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Barangay & Contact Row -->
            <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barangay -->
                <div>
                    <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt me-1 text-green-600"></i>Barangay
                    </label>
                    <select name="barangay_id"
                            id="barangay_id"
                            class="w-full px-4 py-3 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 @error('barangay_id') border-red-500 @enderror"
                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                        <option value="">Select barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>{{ $barangay->barangay_name }}</option>
                        @endforeach
                    </select>
                    @error('barangay_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-telephone me-1 text-green-600"></i>Contact Number
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 py-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">+63</span>
                        <input type="tel"
                               class="w-full px-4 py-3 rounded-r-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('contact_number') border-red-500 @enderror"
                               id="contact_number"
                               name="contact_number"
                               value="{{ old('contact_number') }}"
                               placeholder="943 210 2012"
                               maxlength="12"
                               pattern="[0-9\s]{12}"
                               inputmode="numeric"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3').trim()">
                    </div>
                    @error('contact_number')
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
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Organized By -->
            <div class="px-6 mt-6">
                <label for="organized_by" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-person-badge me-1 text-green-600"></i>Organized By <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('organized_by') border-red-500 @enderror"
                       id="organized_by"
                       name="organized_by"
                       value="{{ old('organized_by') }}"
                       placeholder="Enter organizer name"
                       required>
                @error('organized_by')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div class="px-6 mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-image me-1 text-green-600"></i>Photo (Optional)
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

                <!-- Image Preview -->
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
                    <i class="bi bi-paperclip me-1 text-green-600"></i>Attachment (Optional - PDF only)
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

                <!-- Attachment Preview -->
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
                    <i class="bi bi-check-circle me-2"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Category change handler - toggle event fields
    document.getElementById('category').addEventListener('change', function() {
        const eventFields = document.querySelector('.event-fields');
        if (this.value === 'event') {
            eventFields.classList.remove('hidden');
            // Make event fields required
            document.getElementById('event_date').setAttribute('required', 'required');
            document.getElementById('location').setAttribute('required', 'required');
        } else {
            eventFields.classList.add('hidden');
            // Remove required attributes
            document.getElementById('event_date').removeAttribute('required');
            document.getElementById('location').removeAttribute('required');
        }
    });

    // Image preview
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

     // Initialize on page load
     document.addEventListener('DOMContentLoaded', function() {
         // Trigger category change to set initial state
         document.getElementById('category').dispatchEvent(new Event('change'));
     });

     // Strip spaces from contact_number before form submission
     document.getElementById('announcementForm').addEventListener('submit', function() {
         const contactInput = document.getElementById('contact_number');
         if (contactInput && contactInput.value) {
             contactInput.value = contactInput.value.replace(/\s/g, '');
         }
     });
 </script>
@endpush
@endsection
