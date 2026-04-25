@extends('layouts.admin')

@section('title', 'Edit User')

@section('header', 'Edit User')
@section('subheader', 'Update user information')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">User Information</h3>
            <p class="text-sm text-gray-500">Update the information below</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Personal Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('first_name') border-red-500 @enderror"
                            placeholder="Enter first name" required>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('middle_name') border-red-500 @enderror"
                            placeholder="Enter middle name">
                        @error('middle_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('last_name') border-red-500 @enderror"
                            placeholder="Enter last name" required>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Suffix -->
                    <div>
                        <label for="suffix" class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                        <input type="text" name="suffix" id="suffix" value="{{ old('suffix', $user->suffix) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('suffix') border-red-500 @enderror"
                            placeholder="Jr., Sr., III, etc.">
                        @error('suffix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                            placeholder="Enter email address" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('phone') border-red-500 @enderror"
                            placeholder="Enter phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('dob') border-red-500 @enderror">
                        @error('dob')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Update (Optional) -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-key text-blue-600"></i> Change Password (Optional)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                            placeholder="Leave blank to keep current password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <!-- Role & Permissions -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield text-blue-600"></i> Role & Permissions
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Primary Role <span class="text-red-500">*</span></label>
                        @if($user->hasRole('super_admin') && $user->isSelf())
                            <div class="w-full px-4 py-3 rounded-lg border bg-gray-100 text-gray-600">
                                <i class="bi bi-lock-fill mr-2"></i>
                                {{ $user->getRoleDisplayName() }}
                            </div>
                            <input type="hidden" name="role" value="{{ $user->getRoleAttribute() }}">
                            <p class="mt-1 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> Super Admin cannot change their own role.</p>
                        @else
                            <select name="role" id="role" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('role') border-red-500 @enderror" required>
                                <option value="">Select role</option>
                                @foreach($assignableRoles as $role => $label)
                                    <option value="{{ $role }}" {{ old('role', $user->getRoleAttribute()) == $role ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Only roles within your permission level are available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Barangay Assignment -->
            @if(auth()->user()->hasAnyRole(['super_admin', 'city_vet']))
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-600"></i> Barangay Assignment
                </h4>
                <div>
                    <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-2">Assigned Barangay</label>
                    <select name="barangay_id" id="barangay_id" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">None</option>
                        @foreach(\App\Models\Barangay::orderBy('barangay_name')->get() as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id', $user->adminProfile?->barangay_id) == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <!-- Facility Assignment (Super Admin Only) -->
            @if(auth()->user()->hasRole('super_admin') && $facilities->count() > 0)
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-hospital text-blue-600"></i> Facility Assignment
                </h4>
                <div>
                    <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">Assigned Facility</label>
                    <select name="facility_id" id="facility_id" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">None</option>
                        <optgroup label="Animal Bite Centers (ABC)">
                            @foreach($facilities->where('type', 'abc') as $facility)
                                <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id) == $facility->id ? 'selected' : '' }}>
                                    {{ $facility->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Veterinary Clinics">
                            @foreach($facilities->where('type', 'clinic') as $facility)
                                <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id) == $facility->id ? 'selected' : '' }}>
                                    {{ $facility->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Hospitals">
                            @foreach($facilities->where('type', 'hospital') as $facility)
                                <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id) == $facility->id ? 'selected' : '' }}>
                                    {{ $facility->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Only Super Admin can modify facility assignment.</p>
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
