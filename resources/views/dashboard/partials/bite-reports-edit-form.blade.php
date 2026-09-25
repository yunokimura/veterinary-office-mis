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
                    <label class="block text-xs font-medium text-gray-600 mb-1">Animal Gender</label>
                    <input type="text" name="animal_gender" value="{{ $report->animal_gender }}" readonly
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