@extends('layouts.admin')

@section('title', 'Edit Missing Pet')

@section('header', 'Edit Missing Pet')
@section('subheader', 'Update missing pet details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-asst.missing-pets.show', $missingPet->report_id) }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Missing Pet: {{ $missingPet->pet->pet_name ?? 'Unknown Pet' }}</h1>
            <p class="text-gray-500 mt-1">Update the missing pet information below</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('admin-asst.missing-pets.update', $missingPet->report_id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Name -->
                <div>
                    <label for="pet_name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name', $missingPet->pet->pet_name ?? '') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('pet_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Species -->
                <div>
                    <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species <span class="text-red-500">*</span></label>
                    <select name="species" id="species" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="dog" {{ old('species', $missingPet->pet->species ?? '') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ old('species', $missingPet->pet->species ?? '') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ old('species', $missingPet->pet->species ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('species')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Breed -->
                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed', $missingPet->pet->breed ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color/Markings</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $missingPet->pet->color ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" id="gender"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Unknown</option>
                        <option value="male" {{ old('gender', $missingPet->pet->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $missingPet->pet->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Last Seen At -->
                <div>
                    <label for="last_seen_at" class="block text-sm font-medium text-gray-700 mb-1">Last Seen At <span class="text-red-500">*</span></label>
                    <input type="date" name="last_seen_at" id="last_seen_at" value="{{ old('last_seen_at', $missingPet->last_seen_at ? $missingPet->last_seen_at->format('Y-m-d') : '') }}" required
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
                                <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id', $missingPet->barangay_id) == $barangay->barangay_id ? 'selected' : '' }}>
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
                        placeholder="Describe the specific location">{{ old('location_description', $missingPet->location_description) }}</textarea>
                </div>

                <!-- Emergency Contact -->
                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                    <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $missingPet->emergency_contact) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Phone number or contact details">
                </div>

                <!-- Reporter Name -->
                <div>
                    <label for="reported_by_name" class="block text-sm font-medium text-gray-700 mb-1">Reporter Name</label>
                    <input type="text" name="reported_by_name" id="reported_by_name" value="{{ old('reported_by_name', $missingPet->reported_by_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Full name of the person reporting">
                </div>

                <!-- Reporter Contact -->
                <div>
                    <label for="reporter_contact" class="block text-sm font-medium text-gray-700 mb-1">Reporter Contact <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_contact" id="reporter_contact" value="{{ old('reporter_contact', $missingPet->reporter_contact) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Phone number">
                </div>

                <!-- Reporter Email -->
                <div>
                    <label for="reporter_email" class="block text-sm font-medium text-gray-700 mb-1">Reporter Email</label>
                    <input type="email" name="reporter_email" id="reporter_email" value="{{ old('reporter_email', $missingPet->reporter_email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Email address (optional)">
                </div>

                <!-- Eye Color -->
                <div>
                    <label for="eye_color" class="block text-sm font-medium text-gray-700 mb-1">Eye Color <span class="text-red-500">*</span></label>
                    <input type="text" name="eye_color" id="eye_color" value="{{ old('eye_color', $missingPet->pet?->petInfo?->eye_color) }}" required
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
                        placeholder="Describe any distinctive physical marks">{{ old('body_marks', $missingPet->body_marks) }}</textarea>
                </div>

                <!-- Collar/Harness -->
                <div>
                    <label for="collar_harness" class="block text-sm font-medium text-gray-700 mb-1">Collar/Harness</label>
                    <input type="text" name="collar_harness" id="collar_harness" value="{{ old('collar_harness', $missingPet->collar_harness) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., Red collar with bells, Blue harness, None">
                </div>

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @if($missingPet->pet && $missingPet->pet->pet_image)
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Current photo:</p>
                            <img src="{{ asset('storage/' . $missingPet->pet->pet_image) }}" alt="Current photo" class="h-32 w-32 object-cover rounded mt-1">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update Missing Pet
                </button>
                <a href="{{ route('admin-asst.missing-pets.show', $missingPet->report_id) }}" class="px-6 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection