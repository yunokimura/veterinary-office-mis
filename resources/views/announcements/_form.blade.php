<form action="{{ route($rolePrefix . '.announcements.store') }}" method="POST" enctype="multipart/form-data" id="announcementForm">
    @csrf

    <!-- General Error Banner -->


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

    <!-- Category & Barangay Row -->
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
                <option value="announcement" {{ old('category') == 'announcement' ? 'selected' : '' }}>Announcement</option>
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

        </div>

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
    </div>

    <!-- Event Details Row (conditional) -->
    <div class="px-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 event-fields @if(old('category') != 'event') hidden @endif">
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

    <!-- Photo Upload -->
    <div class="px-6 mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="bi bi-image me-1 text-green-600"></i>Photo
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
        @if($modal ?? false)
            <button type="button" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </button>
            <button type="button" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center" data-action="draft">
                <i class="bi bi-pencil me-2"></i>Save as Draft
            </button>
            <button type="button" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center" data-action="scheduled">
                <i class="bi bi-calendar-check me-2"></i>Save as Scheduled
            </button>
            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                <i class="bi bi-check-circle me-2"></i>
                <span>Create Announcement</span>
            </button>
        @else
            <button type="button" onclick="checkFormChanges()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center">
                <i class="bi bi-x-circle me-2"></i>Cancel
            </button>
            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                <i class="bi bi-check-circle me-2"></i>Create Announcement
            </button>
        @endif
    </div>

    <!-- Hidden status field for draft saving -->
    <input type="hidden" name="status" id="status" value="Published">
</form>