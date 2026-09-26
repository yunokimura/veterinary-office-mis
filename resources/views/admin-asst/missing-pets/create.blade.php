@extends('layouts.admin')

@section('title', 'Report Missing Pet')

@section('header', 'Report Missing Pet')
@section('subheader', 'Create a new missing pet report')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-asst.missing-pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Report Missing Pet</h1>
            <p class="text-gray-500 mt-1">Fill in the details to help locate the missing pet</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('admin-asst.missing-pets.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Name -->
                <div>
                    <label for="pet_name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('pet_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pet Owner -->
                <div>
                    <label for="owner_id" class="block text-sm font-medium text-gray-700 mb-1">Pet Owner</label>
                    <select name="owner_id" id="owner_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Owner (Optional)</option>
                        @if(isset($clients) && $clients->count() > 0)
                            @foreach($clients as $client)
                                <option value="{{ $client->owner_id }}" {{ old('owner_id') == $client->owner_id ? 'selected' : '' }}>
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Species -->
                <div>
                    <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species <span class="text-red-500">*</span></label>
                    <select name="species" id="species" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('species')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Breed -->
                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color/Markings</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" id="gender"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Unknown</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Last Seen At -->
                <div>
                    <label for="last_seen_at" class="block text-sm font-medium text-gray-700 mb-1">Last Seen At <span class="text-red-500">*</span></label>
                    <input type="date" name="last_seen_at" id="last_seen_at" value="{{ old('last_seen_at', date('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('last_seen_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Barangay -->
                <div>
                    <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-1">Location (Barangay) <span class="text-red-500">*</span></label>
                    <select name="barangay_id" id="barangay_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Barangay</option>
                        @if(isset($barangays) && $barangays->count() > 0)
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                    {{ $barangay->barangay_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('barangay_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Description -->
                <div>
                    <label for="location_description" class="block text-sm font-medium text-gray-700 mb-1">Specific Location Description</label>
                    <textarea name="location_description" id="location_description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                        placeholder="Describe the specific location where the pet was last seen">{{ old('location_description') }}</textarea>
                </div>

                <!-- Emergency Contact -->
                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                    <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Phone number or contact details">
                </div>

                <!-- Reporter Name -->
                <div>
                    <label for="reported_by_name" class="block text-sm font-medium text-gray-700 mb-1">Reporter Name</label>
                    <input type="text" name="reported_by_name" id="reported_by_name" value="{{ old('reported_by_name') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Full name of the person reporting">
                </div>

                <!-- Reporter Contact -->
                <div>
                    <label for="reporter_contact" class="block text-sm font-medium text-gray-700 mb-1">Reporter Contact <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_contact" id="reporter_contact" value="{{ old('reporter_contact') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Phone number">
                </div>

                <!-- Reporter Email -->
                <div>
                    <label for="reporter_email" class="block text-sm font-medium text-gray-700 mb-1">Reporter Email</label>
                    <input type="email" name="reporter_email" id="reporter_email" value="{{ old('reporter_email') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Email address (optional)">
                </div>

                <!-- Eye Color -->
                <div>
                    <label for="eye_color" class="block text-sm font-medium text-gray-700 mb-1">Eye Color <span class="text-red-500">*</span></label>
                    <input type="text" name="eye_color" id="eye_color" value="{{ old('eye_color') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., Brown, Black, Hazel, Blue">
                    @error('eye_color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body Marks -->
                <div>
                    <label for="body_marks" class="block text-sm font-medium text-gray-700 mb-1">Body Marks</label>
                    <textarea name="body_marks" id="body_marks" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y"
                        placeholder="Describe any distinctive physical marks">{{ old('body_marks') }}</textarea>
                </div>

                <!-- Collar/Harness -->
                <div>
                    <label for="collar_harness" class="block text-sm font-medium text-gray-700 mb-1">Collar/Harness</label>
                    <input type="text" name="collar_harness" id="collar_harness" value="{{ old('collar_harness') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., Red collar with bells, Blue harness, None">
                </div>

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Max 2MB. JPG, PNG, GIF</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin-asst.missing-pets.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="bi bi-exclamation-triangle mr-2"></i>Report Missing
                </button>
            </div>
        </form>
    </div>
</div>
@endsection