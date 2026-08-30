<form action="{{ $formAction ?? route('admin.users.store') }}" method="POST" id="{{ $formId ?? 'createUserForm' }}" class="p-6">
    @csrf
    @if(isset($user) && $user)
        @method('PUT')
    @endif

    <!-- Personal Information -->
    <div class="mb-8" id="section-personal-info" data-section="personal-info">
        <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
            <i class="bi bi-person text-blue-600"></i> Personal Information
            @if(isset($user) && $user)
                <button type="button" class="edit-section-btn btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-pencil-square"></i> Edit</button>
            @endif
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fields-container">
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('first_name') border-red-500 @enderror"
                    placeholder="Enter first name" required>
                @error('first_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Middle Name -->
            <div>
                <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('middle_name') border-red-500 @enderror"
                    placeholder="Enter middle name">
                @error('middle_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('last_name') border-red-500 @enderror"
                    placeholder="Enter last name" required>
                @error('last_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Suffix -->
            <div>
                <label for="suffix" class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                <input type="text" name="suffix" id="suffix" value="{{ old('suffix', $user->suffix ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('suffix') border-red-500 @enderror"
                    placeholder="Jr., Sr., III, etc.">
                @error('suffix')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                    placeholder="Enter email address" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $user->contact_number ?? $user->adminProfile?->contact_number ?? $user->petOwnerProfile?->phone_number ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('contact_number') border-red-500 @enderror"
                    placeholder="Enter phone number">
                @error('contact_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alternate Phone (Pet Owner only) -->
            <div id="alternate_phone_number_container" @if(!(isset($user) && $user && $user->hasRole('pet_owner'))) style="display: none;" @endif>
                <label for="alternate_phone_number" class="block text-sm font-medium text-gray-700 mb-2">Alternate Phone Number</label>
                <input type="text" name="alternate_phone_number" id="alternate_phone_number" value="{{ old('alternate_phone_number', $user->petOwner?->alternate_phone_number ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('alternate_phone_number') border-red-500 @enderror"
                    placeholder="Enter alternate phone number">
                @error('alternate_phone_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                <input type="date" name="dob" id="dob" value="{{ old('dob', $user->adminProfile?->date_of_birth ?? $user->petOwnerProfile?->date_of_birth ?? $user->date_of_birth ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('dob') border-red-500 @enderror">
                @error('dob')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Address Subsection -->
        <h5 class="text-sm font-medium text-gray-600 mt-6 mb-3 flex items-center gap-2">
            <i class="bi bi-geo-alt text-blue-600"></i> Address
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fields-container">
            <!-- Block/Lot/Phase -->
            <div>
                <label for="address_block_lot_phase" class="block text-sm font-medium text-gray-700 mb-2">Block/Lot/Phase</label>
                <input type="text" name="address_block_lot_phase" id="address_block_lot_phase" value="{{ old('address_block_lot_phase', $user->adminProfile?->address?->block_lot_phase ?? $user->petOwnerProfile?->address?->block_lot_phase ?? $user->organizationProfile?->address?->block_lot_phase ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_block_lot_phase') border-red-500 @enderror"
                    placeholder="e.g., Block 5 Lot 12 Phase 1">
                @error('address_block_lot_phase')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Street -->
            <div>
                <label for="address_street" class="block text-sm font-medium text-gray-700 mb-2">Street</label>
                <input type="text" name="address_street" id="address_street" value="{{ old('address_street', $user->adminProfile?->address?->street ?? $user->petOwnerProfile?->address?->street ?? $user->organizationProfile?->address?->street ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_street') border-red-500 @enderror"
                    placeholder="Enter street name">
                @error('address_street')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subdivision -->
            <div>
                <label for="address_subdivision" class="block text-sm font-medium text-gray-700 mb-2">Subdivision</label>
                <input type="text" name="address_subdivision" id="address_subdivision" value="{{ old('address_subdivision', $user->adminProfile?->address?->subdivision ?? $user->petOwnerProfile?->address?->subdivision ?? $user->organizationProfile?->address?->subdivision ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_subdivision') border-red-500 @enderror"
                    placeholder="Enter subdivision (optional)">
                @error('address_subdivision')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Barangay -->
            <div>
                <label for="address_barangay_id" class="block text-sm font-medium text-gray-700 mb-2">Barangay</label>
                <select name="address_barangay_id" id="address_barangay_id"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_barangay_id') border-red-500 @enderror">
                    <option value="">Select barangay</option>
                    @foreach(\App\Models\Barangay::orderBy('barangay_name')->get() as $barangay)
                        <option value="{{ $barangay->barangay_id }}" {{ old('address_barangay_id', $user->adminProfile?->address?->barangay_id ?? $user->petOwnerProfile?->address?->barangay_id ?? $user->organizationProfile?->address?->barangay_id ?? '') == $barangay->barangay_id ? 'selected' : '' }}>
                            {{ $barangay->barangay_name }}
                        </option>
                    @endforeach
                </select>
                @error('address_barangay_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- City -->
            <div>
                <label for="address_city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                <input type="text" name="address_city" id="address_city" value="{{ old('address_city', $user->adminProfile?->address?->city ?? $user->petOwnerProfile?->address?->city ?? $user->organizationProfile?->address?->city ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_city') border-red-500 @enderror"
                    placeholder="Enter city">
                @error('address_city')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Province -->
            <div>
                <label for="address_province" class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                <input type="text" name="address_province" id="address_province" value="{{ old('address_province', $user->adminProfile?->address?->province ?? $user->petOwnerProfile?->address?->province ?? $user->organizationProfile?->address?->province ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('address_province') border-red-500 @enderror"
                    placeholder="Enter province">
                @error('address_province')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Password Update -->
    <div class="mb-8" id="section-password" data-section="password">
        <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
            <i class="bi bi-key text-blue-600"></i> Password
            @if(isset($user) && $user)
                <button type="button" class="edit-section-btn btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-pencil-square"></i> Edit</button>
            @endif
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fields-container">
            @if(!isset($user) || !$user)
                <!-- Create: Password + Confirm Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                        placeholder="Enter password" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Confirm password" required>
                </div>
            @else
                <!-- Edit: Password only -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        </div>
    </div>

    <!-- Role & Permissions -->
    <div class="mb-8" id="section-role" data-section="role">
        <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
            <i class="bi bi-shield text-blue-600"></i> Role & Permissions
            @if(isset($user) && $user && !$user->hasRole('pet_owner'))
                <button type="button" class="edit-section-btn btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-pencil-square"></i> Edit</button>
            @endif
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fields-container">
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Primary Role <span class="text-red-500">*</span></label>
                @if(isset($user) && $user)
                    @if($user->hasRole('super_admin') && $user->isSelf())
                        <div class="w-full px-4 py-3 rounded-lg border bg-gray-100 text-gray-600">
                            <i class="bi bi-lock-fill mr-2"></i>
                            {{ $user->getRoleDisplayName() }}
                        </div>
                        <input type="hidden" name="role" value="{{ $user->getRoleAttribute() }}">
                        <p class="mt-1 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> Super Admin cannot change their own role.</p>
                    @elseif($user->hasRole('pet_owner'))
                        <div class="w-full px-4 py-3 rounded-lg border bg-gray-100 text-gray-600">
                            {{ $user->getRoleDisplayName() }}
                        </div>
                        <input type="hidden" name="role" value="{{ $user->getRoleAttribute() }}">
                        <p class="mt-1 text-xs text-gray-500">Pet owner role cannot be changed.</p>
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
                @else
                    <select name="role" id="role"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('role') border-red-500 @enderror" required>
                        <option value="">Select role</option>
                        @foreach($assignableRoles as $role => $label)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $label }}</option>
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

    <!-- Facility Assignment -->
    @if(auth()->user()->hasRole('super_admin') && $facilities->count() > 0)
    <div class="mb-8" id="section-facility" data-section="facility" @if(isset($user) && $user && $user->hasRole('pet_owner')) style="display: none;" @endif>
        <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
            <i class="bi bi-hospital text-blue-600"></i> Facility Assignment
            @if(isset($user) && $user)
                <button type="button" class="edit-section-btn btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-pencil-square"></i> Edit</button>
            @endif
        </h4>
        <div class="fields-container">
            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">Assigned Facility</label>
            <select name="facility_id" id="facility_id"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">None</option>
                <optgroup label="Animal Bite Centers (ABC)">
                    @foreach($facilities->where('type', 'abc') as $facility)
                        <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id ?? '') == $facility->id ? 'selected' : '' }}>
                            {{ $facility->name }}
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Veterinary Clinics">
                    @foreach($facilities->where('type', 'clinic') as $facility)
                        <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id ?? '') == $facility->id ? 'selected' : '' }}>
                            {{ $facility->name }}
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Hospitals">
                    @foreach($facilities->where('type', 'hospital') as $facility)
                        <option value="{{ $facility->id }}" {{ old('facility_id', $user->adminProfile?->facility_id ?? '') == $facility->id ? 'selected' : '' }}>
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
        @if($modal ?? false)
            <button type="button" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition" data-bs-dismiss="modal">
                Cancel
            </button>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                <i class="bi bi-check-lg mr-2"></i>
                <span>{{ isset($user) && $user ? 'Update User' : 'Create User' }}</span>
            </button>
        @else
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                <i class="bi bi-check-lg mr-2"></i>
                <span>{{ isset($user) && $user ? 'Update User' : 'Create User' }}</span>
            </button>
        @endif
    </div>
</form>