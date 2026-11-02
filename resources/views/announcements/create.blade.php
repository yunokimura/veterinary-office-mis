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

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">New Announcement Details</h3>
            <p class="text-sm text-gray-500">Fill in the information below to create a new announcement</p>
        </div>

        @include('announcements._form')
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

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center h-full w-full z-50">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                <i class="bi bi-exclamation-triangle text-yellow-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Save this post as a draft?</h3>
            <p class="text-sm text-gray-500 mt-2">If you discard now, you'll lost this post</p>
            <div class="mt-6 flex gap-3 justify-center">
                <button onclick="discardChanges()" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                    Delete Draft
                </button>
                <button onclick="saveAsDraft()" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    Save as a draft
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const barangaysData = @json($barangays);

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
            if (eventTimeInput) eventTimeInput.removeAttribute('required');
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
         const categoryElement = document.getElementById('category');
         if (categoryElement) {
             categoryElement.dispatchEvent(new Event('change'));
         }
         
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
     });
     
     function closeSuccessModal() {
         const successModal = document.getElementById('successModal');
         if (successModal) {
             successModal.classList.add('hidden');
         }
         // Redirect to the announcements index page
         window.location.href = "{{ route($rolePrefix . '.announcements.index') }}";
        }

       // Check if form has changes
      function checkFormChanges() {
          // Check only user-editable fields by ID (completely bypasses hidden fields)
          const title = document.getElementById('title');
          const category = document.getElementById('category');
          const eventDate = document.getElementById('event_date');
          const eventTime = document.getElementById('event_time');
          const content = document.getElementById('content');
          
          const fields = [title, category, eventDate, eventTime, content];
          let hasChanges = false;
          
          for (let field of fields) {
              if (field && field.value && field.value.trim() !== '') {
                  hasChanges = true;
                  break;
              }
          }

          // Also check file inputs
          if (!hasChanges) {
              const photoInput = document.getElementById('photo_path');
              const attachmentInput = document.getElementById('attachment_path');
              if ((photoInput && photoInput.files && photoInput.files.length > 0) ||
                  (attachmentInput && attachmentInput.files && attachmentInput.files.length > 0)) {
                  hasChanges = true;
              }
          }

          if (hasChanges) {
              document.getElementById('cancelModal').classList.remove('hidden');
          } else {
              window.location.href = "{{ route($rolePrefix . '.announcements.index') }}";
          }
      }

     function discardChanges() {
         window.location.href = "{{ route($rolePrefix . '.announcements.index') }}";
     }

     function saveAsDraft() {
         document.getElementById('status').value = 'Draft';
         document.getElementById('announcementForm').submit();
     }

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
@endpush
