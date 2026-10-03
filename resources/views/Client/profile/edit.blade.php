 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#066D33',
                            light: '#077a40',
                            dark: '#055a29',
                        },
                        secondary: {
                            DEFAULT: '#07A13F',
                            light: '#08b148',
                            dark: '#068c35',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #066D33 0%, #07A13F 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .hidden-field {
            display: none;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    @include('Client.partials.navbar')

    <!-- Success Alert -->
    @if(session('success') || session('status') === 'profile-updated')
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="successAlert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') ?? 'Profile updated successfully!' }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('successAlert')?.remove();
            }, 3000);
        </script>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center text-primary hover:text-primary-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-6">My Profile</h1>

        <!-- Card 1: Account Security -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-secondary px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-white">Account Security</h2>
                    <p class="text-green-100 text-sm">Manage your account credentials</p>
                </div>
            </div>
            <div class="p-6">
                <!-- Display Mode -->
                <div id="card1-display">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                                <button type="button" onclick="openModal('emailModal')" class="text-primary hover:text-primary-light text-sm font-medium">Change Email</button>
                            </div>
                        </div>
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Password</label>
                            <div class="flex items-center gap-20">
                                <span class="text-gray-900 font-medium">••••••••</span>
                                <button type="button" onclick="openModal('passwordModal')" class="text-primary hover:text-primary-light text-sm font-medium">Update Password</button>
                            </div>
                        </div>
                        <!-- Account Status -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Account Status</label>
                            <span class="text-gray-900 font-medium">Member since {{ $user->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Personal Information -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-secondary px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-white">Personal Information</h2>
                    <p class="text-green-100 text-sm">Your personal details</p>
                </div>
                <button type="button" onclick="toggleEdit('card2')" id="card2-edit-btn" class="bg-white text-primary px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">Edit</button>
            </div>
            <div class="p-6">
                <!-- Display Mode -->
                <div id="card2-display">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->first_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Middle Name</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->middle_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->last_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                            <p class="text-gray-900 font-medium">
                                @if($user->petOwner && $user->petOwner->date_of_birth)
                                    {{ \Carbon\Carbon::parse($user->petOwner->date_of_birth)->format('F d, Y') }}
                                @else
                                    Not set
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->phone_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alternate Phone Number</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->alternate_phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <!-- Edit Mode -->
                <form method="POST" action="{{ route('profile.update') }}" id="card2-edit-form" class="hidden-field">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="edit_section" value="personal">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" name="first_name" value="{{ $user->petOwner->first_name ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ $user->petOwner->middle_name ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ $user->petOwner->last_name ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            @php
                                $dob = $user->petOwner && $user->petOwner->date_of_birth ? \Carbon\Carbon::parse($user->petOwner->date_of_birth) : null;
                            @endphp
                            <div class="grid grid-cols-3 gap-2">
                                <select name="dob_year" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                    <option value="">Year</option>
                                    @for($year = date('Y'); $year >= 1900; $year--)
                                        <option value="{{ $year }}" {{ $dob && $dob->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <select name="dob_month" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                    <option value="">Month</option>
                                    @for($month = 1; $month <= 12; $month++)
                                        <option value="{{ $month }}" {{ $dob && $dob->month == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                    @endfor
                                </select>
                                <select name="dob_day" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                    <option value="">Day</option>
                                    @for($day = 1; $day <= 31; $day++)
                                        <option value="{{ $day }}" {{ $dob && $dob->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ $user->petOwner->phone_number ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone Number</label>
                            <input type="text" name="alternate_phone_number" value="{{ $user->petOwner->alternate_phone_number ?? '' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-light">Save Changes</button>
                        <button type="button" onclick="toggleEdit('card2')" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">Discard</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card 3: Residential Address -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-secondary px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-white">Residential Address</h2>
                    <p class="text-green-100 text-sm">Your registered address</p>
                </div>
                <button type="button" onclick="toggleEdit('card3')" id="card3-edit-btn" class="bg-white text-primary px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">Edit</button>
            </div>
            <div class="p-6">
                <!-- Display Mode -->
                <div id="card3-display">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Block/Lot/Phase/House No.</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->block_lot_phase ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Street Name</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->street ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Subdivision</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->subdivision ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Barangay</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->barangay->barangay_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">City</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->city ?? 'Dasmariñas City' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Province</label>
                            <p class="text-gray-900 font-medium">{{ $user->petOwner->address->province ?? 'Cavite' }}</p>
                        </div>
                    </div>
                </div>
                <!-- Edit Mode -->
                <form method="POST" action="{{ route('profile.update') }}" id="card3-edit-form" class="hidden-field">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="edit_section" value="address">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Block/Lot/Phase/House No.</label>
                            <input type="text" name="blk_lot_ph" value="{{ old('blk_lot_ph', $user->petOwner->address->block_lot_phase ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Street Name</label>
                            <input type="text" name="street" value="{{ old('street', $user->petOwner->address->street ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subdivision</label>
                            <input type="text" name="subdivision" value="{{ old('subdivision', $user->petOwner->address->subdivision ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                            <select name="barangay" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                <option value="">Select Barangay</option>
                                <option value="Burol I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Burol I' ? 'selected' : '' }}>Burol I</option>
                                <option value="Burol II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Burol II' ? 'selected' : '' }}>Burol II</option>
                                <option value="Burol III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Burol III' ? 'selected' : '' }}>Burol III</option>
                                <option value="Burol Main" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Burol Main' ? 'selected' : '' }}>Burol Main</option>
                                <option value="Datu Esmael (Bago-A-Ingud)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Datu Esmael (Bago-A-Ingud)' ? 'selected' : '' }}>Datu Esmael (Bago-A-Ingud)</option>
                                <option value="Emmanuel Bergaod I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Emmanuel Bergaod I' ? 'selected' : '' }}>Emmanuel Bergaod I</option>
                                <option value="Emmanuel Bergaod II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Emmanuel Bergaod II' ? 'selected' : '' }}>Emmanuel Bergaod II</option>
                                <option value="Fatima I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Fatima I' ? 'selected' : '' }}>Fatima I</option>
                                <option value="Fatima II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Fatima II' ? 'selected' : '' }}>Fatima II</option>
                                <option value="Fatima III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Fatima III' ? 'selected' : '' }}>Fatima III</option>
                                <option value="H-2 (Sta. Veronica)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'H-2 (Sta. Veronica)' ? 'selected' : '' }}>H-2 (Sta. Veronica)</option>
                                <option value="Langkaan I (Humayao)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Langkaan I (Humayao)' ? 'selected' : '' }}>Langkaan I (Humayao)</option>
                                <option value="Langkaan II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Langkaan II' ? 'selected' : '' }}>Langkaan II</option>
                                <option value="Luzviminda I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Luzviminda I' ? 'selected' : '' }}>Luzviminda I</option>
                                <option value="Luzviminda II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Luzviminda II' ? 'selected' : '' }}>Luzviminda II</option>
                                <option value="Paliparan I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Paliparan I' ? 'selected' : '' }}>Paliparan I</option>
                                <option value="Paliparan II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Paliparan II' ? 'selected' : '' }}>Paliparan II</option>
                                <option value="Paliparan III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Paliparan III' ? 'selected' : '' }}>Paliparan III</option>
                                <option value="Sabang" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                                <option value="Saint Peter I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Saint Peter I' ? 'selected' : '' }}>Saint Peter I</option>
                                <option value="Saint Peter II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Saint Peter II' ? 'selected' : '' }}>Saint Peter II</option>
                                <option value="Salawag" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Salawag' ? 'selected' : '' }}>Salawag</option>
                                <option value="Salitran I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Salitran I' ? 'selected' : '' }}>Salitran I</option>
                                <option value="Salitran II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Salitran II' ? 'selected' : '' }}>Salitran II</option>
                                <option value="Salitran III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Salitran III' ? 'selected' : '' }}>Salitran III</option>
                                <option value="Salitran IV" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Salitran IV' ? 'selected' : '' }}>Salitran IV</option>
                                <option value="Sampaloc I (Pala-Pala)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sampaloc I (Pala-Pala)' ? 'selected' : '' }}>Sampaloc I (Pala-Pala)</option>
                                <option value="Sampaloc II (Bucal/Malinta)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sampaloc II (Bucal/Malinta)' ? 'selected' : '' }}>Sampaloc II (Bucal/Malinta)</option>
                                <option value="Sampaloc III (Piela)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sampaloc III (Piela)' ? 'selected' : '' }}>Sampaloc III (Piela)</option>
                                <option value="Sampaloc IV (Talisayan/Bautista)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sampaloc IV (Talisayan/Bautista)' ? 'selected' : '' }}>Sampaloc IV (Talisayan/Bautista)</option>
                                <option value="Sampaloc V (New Era)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Sampaloc V (New Era)' ? 'selected' : '' }}>Sampaloc V (New Era)</option>
                                <option value="San Augustin I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Augustin I' ? 'selected' : '' }}>San Augustin I</option>
                                <option value="San Augustin II (R. Tirona)" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Augustin II (R. Tirona)' ? 'selected' : '' }}>San Augustin II (R. Tirona)</option>
                                <option value="San Augustin III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Augustin III' ? 'selected' : '' }}>San Augustin III</option>
                                <option value="San Andres I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Andres I' ? 'selected' : '' }}>San Andres I</option>
                                <option value="San Andres II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Andres II' ? 'selected' : '' }}>San Andres II</option>
                                <option value="San Antonio De Padua I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Antonio De Padua I' ? 'selected' : '' }}>San Antonio De Padua I</option>
                                <option value="San Antonio De Padua II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Antonio De Padua II' ? 'selected' : '' }}>San Antonio De Padua II</option>
                                <option value="San Dionisio" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Dionisio' ? 'selected' : '' }}>San Dionisio</option>
                                <option value="San Esteban" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Esteban' ? 'selected' : '' }}>San Esteban</option>
                                <option value="San Fransisco I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Fransisco I' ? 'selected' : '' }}>San Fransisco I</option>
                                <option value="San Fransisco II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Fransisco II' ? 'selected' : '' }}>San Fransisco II</option>
                                <option value="San Isidro Labrador I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Isidro Labrador I' ? 'selected' : '' }}>San Isidro Labrador I</option>
                                <option value="San Isidro Labrador II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Isidro Labrador II' ? 'selected' : '' }}>San Isidro Labrador II</option>
                                <option value="San Jose" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Jose' ? 'selected' : '' }}>San Jose</option>
                                <option value="San Juan" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Juan' ? 'selected' : '' }}>San Juan</option>
                                <option value="San Lorenzo Ruiz I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Lorenzo Ruiz I' ? 'selected' : '' }}>San Lorenzo Ruiz I</option>
                                <option value="San Lorenzo Ruiz II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Lorenzo Ruiz II' ? 'selected' : '' }}>San Lorenzo Ruiz II</option>
                                <option value="San Luis I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Luis I' ? 'selected' : '' }}>San Luis I</option>
                                <option value="San Luis II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Luis II' ? 'selected' : '' }}>San Luis II</option>
                                <option value="San Manuel I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Manuel I' ? 'selected' : '' }}>San Manuel I</option>
                                <option value="San Manuel II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Manuel II' ? 'selected' : '' }}>San Manuel II</option>
                                <option value="San Mateo" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Mateo' ? 'selected' : '' }}>San Mateo</option>
                                <option value="San Miguel I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Miguel I' ? 'selected' : '' }}>San Miguel I</option>
                                <option value="San Miguel II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Miguel II' ? 'selected' : '' }}>San Miguel II</option>
                                <option value="San Nicolas I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Nicolas I' ? 'selected' : '' }}>San Nicolas I</option>
                                <option value="San Nicolas II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Nicolas II' ? 'selected' : '' }}>San Nicolas II</option>
                                <option value="San Roque" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Roque' ? 'selected' : '' }}>San Roque</option>
                                <option value="San Simon" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'San Simon' ? 'selected' : '' }}>San Simon</option>
                                <option value="Santa Cristina I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Cristina I' ? 'selected' : '' }}>Santa Cristina I</option>
                                <option value="Santa Cristina II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Cristina II' ? 'selected' : '' }}>Santa Cristina II</option>
                                <option value="Santa Cruz I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Cruz I' ? 'selected' : '' }}>Santa Cruz I</option>
                                <option value="Santa Cruz II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Cruz II' ? 'selected' : '' }}>Santa Cruz II</option>
                                <option value="Santa Fe" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Fe' ? 'selected' : '' }}>Santa Fe</option>
                                <option value="Santa Lucia" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Lucia' ? 'selected' : '' }}>Santa Lucia</option>
                                <option value="Santa Maria" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santa Maria' ? 'selected' : '' }}>Santa Maria</option>
                                <option value="Santo Cristo" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santo Cristo' ? 'selected' : '' }}>Santo Cristo</option>
                                <option value="Santo Niño I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santo Niño I' ? 'selected' : '' }}>Santo Niño I</option>
                                <option value="Santo Niño II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Santo Niño II' ? 'selected' : '' }}>Santo Niño II</option>
                                <option value="Victoria Reyes" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Victoria Reyes' ? 'selected' : '' }}>Victoria Reyes</option>
                                <option value="Zone I" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Zone I' ? 'selected' : '' }}>Zone I</option>
                                <option value="Zone I-A" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Zone I-A' ? 'selected' : '' }}>Zone I-A</option>
                                <option value="Zone II" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Zone II' ? 'selected' : '' }}>Zone II</option>
                                <option value="Zone III" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Zone III' ? 'selected' : '' }}>Zone III</option>
                                <option value="Zone IV" {{ (old('barangay', $user->petOwner->address->barangay->barangay_name ?? '')) == 'Zone IV' ? 'selected' : '' }}>Zone IV</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" value="{{ old('city', $user->petOwner->address->city ?? 'Dasmariñas City') }}" disabled class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-gray-500 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                            <input type="text" value="{{ old('province', $user->petOwner->address->province ?? 'Cavite') }}" disabled class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-gray-500 rounded-lg">
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-light">Save Changes</button>
                        <button type="button" onclick="toggleEdit('card3')" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">Discard</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card 4: Pet Summary -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-secondary px-6 py-4">
                <h2 class="text-xl font-bold text-white">Pet Summary</h2>
                <p class="text-green-100 text-sm">Your registered pets</p>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Total Pets Registered</label>
                        <p class="text-3xl font-bold text-primary">{{ $user->petOwner->pets->count() ?? 0 }}</p>
                    </div>
                    <a href="{{ route('owner.pets') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        View/Manage My Pets
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Change Email Modal -->
    <div id="emailModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('emailModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Change Email Address</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="edit_section" value="email">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-gray-500 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="submit" class="flex-1 px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-light">Save Changes</button>
                        <button type="button" onclick="closeModal('emailModal')" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Password Modal -->
    <div id="passwordModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('passwordModal')"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Update Password</h3>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('current_password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('password', 'updatePassword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="submit" class="flex-1 px-6 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-light">Update Password</button>
                        <button type="button" onclick="closeModal('passwordModal')" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleEdit(cardId) {
            const displayDiv = document.getElementById(cardId + '-display');
            const editForm = document.getElementById(cardId + '-edit-form');
            const editBtn = document.getElementById(cardId + '-edit-btn');
            
            if (displayDiv.classList.contains('hidden-field')) {
                // Show display, hide edit
                displayDiv.classList.remove('hidden-field');
                editForm.classList.add('hidden-field');
                editBtn.classList.remove('hidden-field');
            } else {
                // Show edit, hide display
                displayDiv.classList.add('hidden-field');
                editForm.classList.remove('hidden-field');
                editBtn.classList.add('hidden-field');
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const button = document.querySelector('button[onclick="toggleUserMenu()"]');
            const menu = document.getElementById('userMenu');
            if (button && !button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @include('Client.partials.footer')
</body>
</html>
