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

        <!-- Barangay (modal selector) -->
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
            <input type="hidden" id="barangayIdInput" name="barangay_id" value="{{ old('barangay_id') }}">
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