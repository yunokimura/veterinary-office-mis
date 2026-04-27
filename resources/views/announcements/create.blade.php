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

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">New Announcement Details</h3>
            <p class="text-sm text-gray-500">Fill in the information below to create a new announcement</p>
        </div>

        <form action="{{ route($rolePrefix . '.announcements.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror"
                    placeholder="Enter announcement title" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="category" 
                        class="w-full px-4 py-3 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                        <option value="">Select category</option>
                        <option value="campaign" {{ old('category') == 'campaign' ? 'selected' : '' }}>Campaign</option>
                        <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Event Date (Optional)</label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('event_date') border-red-500 @enderror">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Time -->
                <div>
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-2">Event Time (Optional)</label>
                    <input type="time" name="event_time" id="event_time" value="{{ old('event_time') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('event_time') border-red-500 @enderror">
                    @error('event_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Barangay -->
                <div>
                    <label for="barangay" class="block text-sm font-medium text-gray-700 mb-2">Barangay <span class="text-red-500">*</span></label>
                    <select name="barangay" id="barangay" 
                        class="w-full px-4 py-3 pr-8 rounded-lg border border-gray-300 appearance-none bg-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('barangay') border-red-500 @enderror"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px 12px;">
                        <option value="">Select barangay</option>
                        <option value="poblacion" {{ old('barangay') == 'poblacion' ? 'selected' : '' }}>Poblacion</option>
                        <option value="san-antonio" {{ old('barangay') == 'san-antonio' ? 'selected' : '' }}>San Antonio</option>
                        <option value="san-jose" {{ old('barangay') == 'san-jose' ? 'selected' : '' }}>San Jose</option>
                        <option value="san-juan" {{ old('barangay') == 'san-juan' ? 'selected' : '' }}>San Juan</option>
                        <option value="san-nicolas" {{ old('barangay') == 'san-nicolas' ? 'selected' : '' }}>San Nicolas</option>
                    </select>
                    @error('barangay')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('location') border-red-500 @enderror"
                        placeholder="Enter event location" required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('contact_number') border-red-500 @enderror"
                        placeholder="Enter contact number" required maxlength="11" pattern="[0-9]*">
                    @error('contact_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="8"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('content') border-red-500 @enderror"
                    placeholder="Enter announcement content" required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo and Attachment Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Photo -->
                <div>
                    <label for="photo_path" class="block text-sm font-medium text-gray-700 mb-2">Photo (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="photo_path" id="photo_path" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <label for="photo_path" class="cursor-pointer">
                            <i class="bi bi-cloud-upload text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload photo</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                        </label>
                    </div>
                    @error('photo_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment_path" class="block text-sm font-medium text-gray-700 mb-2">Attachment (Optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="attachment_path" id="attachment_path" class="hidden" accept="application/pdf">
                        <label for="attachment_path" class="cursor-pointer">
                            <i class="bi bi-file-earmark-text text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload file</p>
                            <p class="text-xs text-gray-400 mt-1">PDF up to 5MB</p>
                        </label>
                    </div>
                    @error('attachment_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route($rolePrefix . '.announcements.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File upload preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Photo upload preview
        const photoInput = document.getElementById('photo_path');
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
                const photoLabel = this.nextElementSibling.querySelector('p:nth-child(2)');
                if (photoLabel) {
                    photoLabel.textContent = fileName;
                    // Change color if file is selected
                    if (fileName !== 'No file selected') {
                        photoLabel.style.color = '#059669'; // green-600
                    } else {
                        photoLabel.style.color = '#6b7280'; // gray-500
                    }
                }
            });
        }

        // Attachment upload preview
        const attachmentInput = document.getElementById('attachment_path');
        if (attachmentInput) {
            attachmentInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
                const attachmentLabel = this.nextElementSibling.querySelector('p:nth-child(2)');
                if (attachmentLabel) {
                    attachmentLabel.textContent = fileName;
                    // Change color if file is selected
                    if (fileName !== 'No file selected') {
                        attachmentLabel.style.color = '#059669'; // green-600
                    } else {
                        attachmentLabel.style.color = '#6b7280'; // gray-500
                    }
                }
            });
        }
    });
</script>
@endsection
