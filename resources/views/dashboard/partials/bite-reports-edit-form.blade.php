<div id="editFormBody">
    <form id="editBiteReportForm" method="POST" action="{{ route($rolePrefix . '.bite-reports.update', $report->id) }}">
        @csrf
        @method('PUT')

        <!-- Report Information -->
        <div class="form-section bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Report Information</h4>
                <button type="button" class="edit-section-btn text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Report Number</label>
                    <input type="text" name="report_number" value="{{ $report->report_number }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                    <select name="status" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="Pending Review" {{ $report->status === 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="Under Review" {{ $report->status === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Resolved" {{ $report->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Closed" {{ $report->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Rabies Confirmed</label>
                    <select name="rabies_confirmed" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="1" {{ $report->rabies_confirmed ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$report->rabies_confirmed ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="form-section bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Patient Information</h4>
                <button type="button" class="edit-section-btn text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">First Name</label>
                    <input type="text" name="patient_first_name" value="{{ $report->patient_first_name }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Middle Name</label>
                    <input type="text" name="patient_middle_name" value="{{ $report->patient_middle_name }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Last Name</label>
                    <input type="text" name="patient_last_name" value="{{ $report->patient_last_name }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Suffix</label>
                    <input type="text" name="patient_suffix" value="{{ $report->patient_suffix }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Age</label>
                    <input type="number" name="age" value="{{ $report->age }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Gender</label>
                    <select name="gender" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="Male" {{ $report->gender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $report->gender === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Address</label>
                    <input type="text" name="patient_address" value="{{ $report->patient_address }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Barangay</label>
                    <select name="barangay_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="">Select Barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ $report->barangay_id == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Contact</label>
                    <input type="text" name="patient_contact" value="{{ $report->patient_contact }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
            </div>
        </div>

        <!-- Incident Information -->
        <div class="form-section bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Incident Information</h4>
                <button type="button" class="edit-section-btn text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Incident Date</label>
                    <input type="date" name="incident_date" value="{{ $report->incident_date }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Exposure Type</label>
                    <input type="text" name="exposure_type" value="{{ $report->exposure_type }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Bite Site</label>
                    <input type="text" name="bite_site" value="{{ $report->bite_site }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                    <select name="category" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="I" {{ $report->category === 'I' ? 'selected' : '' }}>Category I</option>
                        <option value="II" {{ $report->category === 'II' ? 'selected' : '' }}>Category II</option>
                        <option value="III" {{ $report->category === 'III' ? 'selected' : '' }}>Category III</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Exact Location</label>
                    <input type="text" name="exact_location" value="{{ $report->exact_location }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
            </div>
        </div>

        <!-- Animal Information -->
        <div class="form-section bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Animal Information</h4>
                <button type="button" class="edit-section-btn text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Animal Type</label>
                    <select name="animal_type" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                        <option value="dog" {{ $report->animal_type === 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ $report->animal_type === 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="others" {{ $report->animal_type === 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Animal Status</label>
                    <input type="text" name="animal_status" value="{{ $report->animal_status }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Vaccination Status</label>
                    <input type="text" name="vaccination_status" value="{{ $report->vaccination_status }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Owner Name</label>
                    <input type="text" name="animal_owner_name" value="{{ $report->animal_owner_name }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Owner Contact</label>
                    <input type="text" name="animal_owner_contact" value="{{ $report->animal_owner_contact }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Reporting Facility</label>
                    <input type="text" name="reporting_facility" value="{{ $report->reporting_facility }}" readonly
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                </div>
            </div>
        </div>

        <!-- Treatment Information -->
        <div class="form-section bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Treatment Information</h4>
                <button type="button" class="edit-section-btn text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</button>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Wound Management</label>
                    <textarea name="wound_management" rows="3" readonly
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">{{ $report->wound_management }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Post Exposure Prophylaxis</label>
                    <textarea name="post_exposure_prophylaxis" rows="3" readonly
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-sm">{{ $report->post_exposure_prophylaxis }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="button" onclick="closeEditModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                Cancel
            </button>
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                Save Changes
            </button>
        </div>
    </form>
</div>