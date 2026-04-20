<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti-Rabies Vaccination Form - Dasmariñas City Veterinary Services</title>
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
        .dropdown-option {
            transition: all 0.2s ease;
        }
        .dropdown-option:hover {
            background-color: #f3f4f6;
        }
        .dropdown-option.selected {
            background-color: #e8f5e9;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Government Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Dasmariñas City Veterinary Services</h1>
                        <p class="text-sm text-gray-500">Official Veterinary Office of Dasmariñas City</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Missing Pets</a>
                </nav>
                
                <!-- Login/Register Buttons or User Dropdown -->
                @auth
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="text-primary font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="{{ route('owner.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <hr class="my-2 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-primary font-medium hover:bg-gray-100 rounded-lg transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-light transition-colors">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Title and Required Fields Notice -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Anti-Rabies Vaccination</h2>
            <p class="text-gray-500 text-sm mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form id="vaccinationForm" method="POST" action="{{ url('/vaccination/form') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="selected_pets" id="selectedPetsData" value="">

                <!-- OWNER'S INFORMATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Owner's Information</h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Pet Owner's Name <span class="text-red-500">*</span>
                                <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="owner_first_name" placeholder="First Name" value="{{ old('owner_first_name', $petOwner->first_name ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <input type="text" name="owner_last_name" placeholder="Last Name" value="{{ old('owner_last_name', $petOwner->last_name ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="owner_email" placeholder="Enter Email" value="{{ old('owner_email', $user->email ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="owner_contact" placeholder="943 210 2012" maxlength="12" value="{{ old('owner_contact', $petOwner->phone_number ?? '') }}"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Alternate Mobile Number -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Alternate Mobile Number
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="alt_mobile_number" placeholder="943 210 2012" maxlength="12" value="{{ old('alt_mobile_number', $petOwner->alternate_phone_number ?? '') }}"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- House No. / Unit No. -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                House No. / Unit No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="blk_lot_ph" placeholder="House No. / Unit No." value="{{ old('blk_lot_ph', $petOwner->blk_lot_ph ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Street -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Street <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="street" placeholder="Street" value="{{ old('street', $petOwner->street ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Barangay -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Barangay <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="barangay" placeholder="Barangay" value="{{ old('barangay', $petOwner->barangay ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>
                </div>

                <!-- PET'S INFORMATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Pet's Information</h3>

                    <!-- Selected Pets Display Area -->
                    <div id="selectedPetsContainer" class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium">
                                Selected Pets <span class="text-red-500">*</span>
                            </label>
                            <button type="button" onclick="openPetModal()" 
                                    class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Select Pet
                            </button>
                        </div>
                        
                        <!-- Display selected pet cards here -->
                        <div id="selectedPetsList" class="grid md:grid-cols-2 gap-4">
                            <!-- Empty state -->
                            <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">No pets selected yet. Click "Select Pet" to choose from your registered pets.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MEDICAL HISTORY & APPOINTMENTS (Per Pet) -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Medical History & Appointments</h3>

                    <div id="petMedicalHistoryContainer">
                        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 text-sm">Select pets first to see medical history forms.</p>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Checkbox -->
                <div class="mt-6">
                    <label class="inline-flex items-start cursor-pointer">
                        <input type="checkbox" name="confirmation" class="form-checkbox h-5 w-5 text-primary rounded mt-1">
                        <span class="ml-3 text-gray-700 text-sm">
                            By confirming, you acknowledge that the provided information is accurate and that your pet will be available for vaccination on the selected date(s). <span class="text-red-500">*</span>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-primary text-white px-12 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                        Submit
                    </button>
                </div>
            </form>

            <!-- Pet Selection Modal -->
            <div id="petModal" class="fixed inset-0 z-50 hidden">
                <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePetModal()"></div>
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Select Your Pet(s)</h3>
                            <button type="button" onclick="closePetModal()" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4 overflow-y-auto max-h-[60vh]">
                            @if(count($petsArray) === 0)
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">You haven't registered any pets yet.</p>
                                    <a href="{{ url('/pet-registration/form') }}" class="text-primary hover:text-primary-light font-medium">
                                        Register a Pet
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-600 mb-4">Select one or more pets for Anti-Rabies Vaccination:</p>
                                <div class="space-y-3" id="petSelectionList">
                                    @foreach($petsArray as $pet)
                                        @php
                                            $speciesDisplay = isset($pet['species']) ? ucfirst($pet['species']) : 'Unknown';
                                        @endphp
                                        <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 hover:border-primary transition-colors pet-selection-card" data-pet-id="{{ $pet['id'] }}">
                                            <input type="checkbox" name="selected_pets[]" value="{{ $pet['id'] }}" 
                                                   class="mt-1 w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary pet-checkbox"
                                                   onchange="togglePetSelection(this)">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-semibold text-gray-900 pet-name">{{ $pet['name'] }}</span>
                                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">{{ $speciesDisplay }}</span>
                                                </div>
                                                <div class="mt-1 text-xs text-gray-500">
                                                    <div>Breed: {{ $pet['breed'] ?? 'Unknown' }}</div>
                                                    <div class="text-gray-600">Age: {{ isset($pet['age']) ? str_replace('_', ' ', $pet['age']) : 'Unknown' }}</div>
                                                    <div class="text-gray-600">Weight: {{ isset($pet['weight']) ? (str_contains(strtolower($pet['weight']), 'kg') || strtolower($pet['weight']) == 'n/a' ? $pet['weight'] : $pet['weight'] . ' kg') : 'Unknown' }}</div>
                                                </div>
                                            </div>
                                            @if(!empty($pet['image']))
                                            <div class="ml-2 flex-shrink-0">
                                                @php
                                                    $petImagePath = $pet['image'];
                                                    if (!str_contains($petImagePath, 'images/pets') && !str_contains($petImagePath, 'http')) {
                                                        $petImagePath = 'images/pets/' . basename($petImagePath);
                                                    }
                                                @endphp
                                                <img src="{{ asset($petImagePath) }}" alt="{{ $pet['name'] }}" class="w-12 h-12 rounded-full object-cover">
                                            </div>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Selected: <span id="selectedCount">0</span> pet(s)</span>
                                <button type="button" onclick="confirmPetSelection()" 
                                        class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                    Confirm Selection
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pet Limit Modal -->
            <div id="petLimitModal" class="fixed inset-0 z-50 hidden">
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 text-center">
                        <div class="mb-4">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Pet Limit Reached</h3>
                        <p class="text-gray-600 mb-6">
                            To ensure fair slot distribution and smooth form submission, a maximum of 3 pets is allowed per transaction. Please complete this form first and submit a new application for additional pets.
                        </p>
                        <button type="button" onclick="closePetLimitModal()" 
                                class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">
                            I understand
                        </button>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <div class="text-center mt-6">
                <a href="{{ url('/vaccination') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                    ← Back to Vaccination
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">&copy; 2026 Dasmariñas City Veterinary Services. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Dropdown toggle for user menu
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');
            if (dropdown && button && !dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Pet data from server
        const petsData = @json($petsArray);
        const currentUserId = @json($userId ?? null);
        
        // Format age - remove underscores and format naturally
        function formatAge(age) {
            if (!age) return 'Unknown';
            return age.replace(/_/g, ' ').replace(/\b(\d)\b/g, '$1 ').trim();
        }
        
        // Format weight - append kg if not included
        function formatWeight(weight) {
            if (!weight) return 'Unknown';
            const weightStr = String(weight).toLowerCase();
            if (weightStr.includes('kg') || weightStr === 'n/a' || weightStr === 'na') {
                return weight;
            }
            return weight + ' kg';
        }

        // Toggle vaccine date field based on previous vaccine radio selection
        function toggleVaccineDate(radio, petId) {
            const dateContainer = document.getElementById('vaccineDateContainer_' + petId);
            if (radio.value === 'yes') {
                dateContainer.classList.remove('hidden');
            } else {
                dateContainer.classList.add('hidden');
            }
        }

        // Per-pet appointment scheduling functions
        const petAppointments = {};
        const petSlotsData = {};

        function toggleScheduleAccordion(petId) {
            const content = document.getElementById('scheduleContent_' + petId);
            const arrow = document.getElementById('scheduleArrow_' + petId);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        async function loadPetSlots(petId) {
            const dateInput = document.getElementById('appointmentDate_' + petId);
            const selectedDate = dateInput.value;
            if (!selectedDate) return;

            // Clear previous selection when date changes
            if (petAppointments[petId] && petAppointments[petId].date !== selectedDate) {
                delete petAppointments[petId];
                document.getElementById('hiddenDate_' + petId).value = '';
                document.getElementById('hiddenTime_' + petId).value = '';
                document.getElementById('selectedSummary_' + petId).classList.add('hidden');
                document.getElementById('scheduleStatus_' + petId).textContent = 'Not scheduled';
                document.getElementById('scheduleStatus_' + petId).className = 'text-xs text-gray-500 mr-2';
            }

            const slotStatus = document.getElementById('slotStatus_' + petId);
            const timeSlots = document.getElementById('timeSlots_' + petId);
            
            slotStatus.classList.remove('hidden');
            timeSlots.classList.add('hidden');
            
            const capacityBadge = document.getElementById('dailyCapacity_' + petId);
            capacityBadge.textContent = 'Loading...';
            capacityBadge.className = 'inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700';

            try {
                const response = await fetch(`/api/appointments/slots?date=${selectedDate}&service_type=vaccination`);
                const data = await response.json();
                
                if (data.success) {
                    petSlotsData[petId] = data.slots;
                    const dailyRemaining = data.daily_remaining || 0;
                    
                    // Update capacity badge
                    if (dailyRemaining <= 0) {
                        capacityBadge.textContent = 'Fully Booked';
                        capacityBadge.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700';
                    } else if (dailyRemaining === 1) {
                        capacityBadge.textContent = '1 slot left';
                        capacityBadge.className = 'inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700';
                    } else {
                        capacityBadge.textContent = 'Available';
                        capacityBadge.className = 'inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700';
                    }
                    
                    // Render time slots
                    if (data.slots && data.slots.length > 0) {
                        renderTimeSlots(petId, data.slots);
                    }
                }
            } catch (error) {
                console.error('Failed to load slots:', error);
                capacityBadge.textContent = 'Error loading slots';
                capacityBadge.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700';
            }
        }

        function renderTimeSlots(petId, slots) {
            const timeSlots = document.getElementById('timeSlots_' + petId);
            const slotsGrid = document.getElementById('slotsGrid_' + petId);
            
            // Sort slots by time
            const sortedSlots = [...slots].sort((a, b) => a.time.localeCompare(b.time));
            
            slotsGrid.innerHTML = '';
            
            const currentTime = new Date();
            const selectedDateInput = document.getElementById('appointmentDate_' + petId).value;
            const todayStr = currentTime.toISOString().split('T')[0];
            const isToday = selectedDateInput === todayStr;
            const currentHour = currentTime.getHours();
            const currentMinute = currentTime.getMinutes();
            
            sortedSlots.forEach(slot => {
                const [slotHour, slotMinute] = slot.time.split(':').map(Number);
                const slotTimeInMinutes = slotHour * 60 + slotMinute;
                const currentTimeInMinutes = currentHour * 60 + currentMinute;
                const isPast = isToday && slotTimeInMinutes <= currentTimeInMinutes;
                
                const isDisabled = slot.status === 'blocked' || slot.status === 'full' || isPast || slot.is_past;
                const isSelected = petAppointments[petId]?.time === slot.time;
                
                let btnClass = 'py-3 px-2 rounded-lg border-2 text-sm font-medium transition-all ';
                if (isDisabled) {
                    btnClass += 'border-gray-200 text-gray-400 cursor-not-allowed bg-gray-50';
                } else if (isSelected) {
                    btnClass += 'bg-primary border-primary text-white';
                } else if (slot.status === 'limited') {
                    btnClass += 'border-yellow-300 text-yellow-700 bg-yellow-50 hover:border-yellow-500';
                } else if (slot.status === 'full') {
                    btnClass += 'border-red-200 text-red-400 cursor-not-allowed bg-red-50';
                } else {
                    btnClass += 'border-green-300 text-green-700 bg-green-50 hover:border-green-500';
                }
                
                const slotBtn = document.createElement('button');
                slotBtn.type = 'button';
                slotBtn.className = btnClass;
                slotBtn.disabled = isDisabled;
                slotBtn.textContent = slot.display_time || slot.time;
                slotBtn.onclick = () => selectPetTime(petId, slot);
                
                slotsGrid.appendChild(slotBtn);
            });
            
            timeSlots.classList.remove('hidden');
        }

        function selectPetTime(petId, slot) {
            const date = document.getElementById('appointmentDate_' + petId).value;
            
            petAppointments[petId] = {
                date: date,
                time: slot.time,
                display_time: slot.display_time
            };
            
            // Update hidden inputs
            document.getElementById('hiddenDate_' + petId).value = date;
            document.getElementById('hiddenTime_' + petId).value = slot.time;
            
            // Update summary display
            const summary = document.getElementById('selectedSummary_' + petId);
            const selectedDateSpan = document.getElementById('selectedDate_' + petId);
            const selectedTimeSpan = document.getElementById('selectedTime_' + petId);
            
            const dateObj = new Date(date + 'T00:00:00');
            selectedDateSpan.textContent = dateObj.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            selectedTimeSpan.textContent = slot.display_time || slot.time;
            
            summary.classList.remove('hidden');
            
            // Update status badge
            const statusBadge = document.getElementById('scheduleStatus_' + petId);
            statusBadge.textContent = 'Scheduled';
            statusBadge.className = 'text-xs text-green-600 font-medium mr-2';
            
            // Re-render slots to show selection
            if (petSlotsData[petId]) {
                renderTimeSlots(petId, petSlotsData[petId]);
            }
        }
        
        let selectedPets = [];

        function openPetModal() {
            // Check if user has no pets registered
            if (petsData.length === 0) {
                document.getElementById('petModal').classList.remove('hidden');
                document.getElementById('petSelectionList').innerHTML = `
                    <div class="text-center py-8 px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-600 mb-4">It looks like you haven't registered your pets yet.</p>
                        <a href="{{ url('/pet-registration/form') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-light transition-colors">
                            Register Your Pet
                        </a>
                    </div>
                `;
                // Hide the footer with confirm button when no pets
                document.querySelector('#petModal .bg-gray-50').classList.add('hidden');
                document.body.style.overflow = 'hidden';
                return;
            }
            
            // Show normal modal with pets
            document.getElementById('petModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePetModal() {
            document.getElementById('petModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function togglePetSelection(checkbox) {
            const petId = String(checkbox.value);
            const petName = checkbox.closest('.pet-selection-card')?.querySelector('.pet-name')?.textContent || 'this pet';
            
            if (checkbox.checked) {
                // Check if limit of 3 is reached
                if (selectedPets.length >= 3) {
                    // Show limit modal and uncheck the checkbox
                    checkbox.checked = false;
                    showPetLimitModal();
                    return;
                }
                
                // Check if pet already has a vaccination appointment
                checkPetBooking(petName, checkbox);
            } else {
                selectedPets = selectedPets.filter(id => String(id) !== petId);
            }
            updateSelectedCount();
        }
        
        async function checkPetBooking(petName, checkbox) {
            try {
                const url = currentUserId 
                    ? `/api/appointments/check-vaccination-pet/${encodeURIComponent(petName)}/${currentUserId}`
                    : `/api/appointments/check-vaccination-pet/${encodeURIComponent(petName)}`;
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.already_booked) {
                    // Uncheck the checkbox
                    checkbox.checked = false;
                    
                    // Show warning modal
                    showAlreadyBookedModal(data);
                    return;
                }
                
                // If not booked, add to selection
                const petId = String(checkbox.value);
                if (!selectedPets.includes(petId)) {
                    selectedPets.push(petId);
                }
                updateSelectedCount();
            } catch (error) {
                console.error('Failed to check pet booking:', error);
                // On error, allow selection but log for debugging
                const petId = String(checkbox.value);
                if (!selectedPets.includes(petId)) {
                    selectedPets.push(petId);
                }
                updateSelectedCount();
            }
        }
        
        function showAlreadyBookedModal(data) {
            const modalHtml = `
                <div id="alreadyBookedModal" class="fixed inset-0 z-50">
                    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Already Booked</h3>
                                <p class="text-gray-600 mb-2">${data.pet_name} already has a vaccination appointment scheduled.</p>
                                <p class="text-gray-800 font-medium mb-4">Date: ${data.scheduled_date}<br>Time: ${data.scheduled_time}</p>
                                <p class="text-gray-500 text-sm mb-6">Please complete this appointment first before booking a new one.</p>
                                <button type="button" onclick="closeAlreadyBookedModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                    I understand
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            document.body.style.overflow = 'hidden';
        }
        
        function closeAlreadyBookedModal() {
            const modal = document.getElementById('alreadyBookedModal');
            if (modal) {
                modal.remove();
            }
            document.body.style.overflow = 'auto';
        }

        function showPetLimitModal() {
            document.getElementById('petLimitModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePetLimitModal() {
            document.getElementById('petLimitModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function updateSelectedCount() {
            document.getElementById('selectedCount').textContent = selectedPets.length;
        }

        function confirmPetSelection() {
            const container = document.getElementById('selectedPetsList');
            const noPetsMessage = document.getElementById('noPetsSelected');
            const modalFooter = document.querySelector('#petModal .bg-gray-50');
            const medicalHistoryContainer = document.getElementById('petMedicalHistoryContainer');

            // Restore footer if it was hidden
            if (modalFooter) {
                modalFooter.classList.remove('hidden');
            }

            if (selectedPets.length > 0) {
                if (noPetsMessage) {
                    noPetsMessage.remove();
                }
            }

            // Clear current selections and rebuild
            container.innerHTML = '';

            if (selectedPets.length === 0) {
                container.innerHTML = `
                    <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">No pets selected yet. Click "Select Pet" to choose from your registered pets.</p>
                    </div>
                `;
                // Reset medical history to empty state
                medicalHistoryContainer.innerHTML = `
                    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Select pets first to see medical history forms.</p>
                    </div>
                `;
                closePetModal();
                return;
            }

            selectedPets.forEach(petId => {
                const pet = petsData.find(p => String(p.id) === String(petId));
                if (pet) {
                    // Determine image source
                    let imageHtml = '';
                    if (pet.image) {
                        let imgPath = pet.image;
                        if (!imgPath.includes('images/pets') && !imgPath.includes('http')) {
                            imgPath = 'images/pets/' + pet.image.split('/').pop();
                        }
                        const imageSrc = imgPath.startsWith('http') ? imgPath : "{{ asset('') }}" + imgPath;
                        imageHtml = `<img src="${imageSrc}" alt="${pet.name}" class="w-12 h-12 rounded-full object-cover">`;
                    } else {
                        imageHtml = `<div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>`;
                    }
                    
                    // Add pet card
                    const petCard = document.createElement('div');
                    petCard.className = 'bg-white border border-gray-200 rounded-lg p-4 flex items-center justify-between';
                    const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
                    petCard.innerHTML = `
                        <div class="flex items-center">
                            ${imageHtml}
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                                <p class="text-xs text-gray-500">${speciesDisplay} • ${pet.breed || 'Unknown'}</p>
                                <p class="text-xs text-gray-600 mt-1">Age: ${formatAge(pet.age)} • Weight: ${formatWeight(pet.weight)}</p>
                            </div>
                        </div>
                        <button type="button" onclick="removePet(${pet.id})" class="text-red-500 hover:text-red-700 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    container.appendChild(petCard);
                }
            });

            // Generate medical history cards for each selected pet
            generateMedicalHistoryCards();

            // Update hidden selected_pets field for form submission
            const selectedPetsData = document.getElementById('selectedPetsData');
            if (selectedPetsData) {
                selectedPetsData.value = JSON.stringify(selectedPets);
            }

            closePetModal();
        }

        function generateMedicalHistoryCards() {
            const container = document.getElementById('petMedicalHistoryContainer');
            
            if (selectedPets.length === 0) {
                container.innerHTML = `
                    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Select pets first to see medical history forms.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = '';

            selectedPets.forEach(petId => {
                const pet = petsData.find(p => String(p.id) === String(petId));
                if (pet) {
                    // Determine image source for header
                    let imageHtml = '';
                    if (pet.image) {
                        let imgPath = pet.image;
                        if (!imgPath.includes('images/pets') && !imgPath.includes('http')) {
                            imgPath = 'images/pets/' + pet.image.split('/').pop();
                        }
                        const imageSrc = imgPath.startsWith('http') ? imgPath : "{{ asset('') }}" + imgPath;
                        imageHtml = `<img src="${imageSrc}" alt="${pet.name}" class="w-10 h-10 rounded-full object-cover">`;
                    } else {
                        imageHtml = `<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>`;
                    }

                    const medicalCard = document.createElement('div');
                    medicalCard.className = 'bg-white border border-gray-200 rounded-lg p-5 mb-4';
                    medicalCard.id = 'medical-history-' + petId;
                    medicalCard.innerHTML = `
                        <div class="flex items-center mb-4 pb-3 border-b">
                            ${imageHtml}
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                                <p class="text-xs text-gray-500">${pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown'} • ${pet.breed || 'Unknown'}</p>
                            </div>
                        </div>
                        
                        <!-- Appointment Scheduling (Collapsible) -->
                        <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                            <button type="button" onclick="toggleScheduleAccordion(${pet.id})" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-700">Schedule Appointment</span>
                                </div>
                                <div class="flex items-center">
                                    <span id="scheduleStatus_${pet.id}" class="text-xs text-gray-500 mr-2">Not scheduled</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" id="scheduleArrow_${pet.id}" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                            <div id="scheduleContent_${pet.id}" class="hidden px-4 py-4 border-t border-gray-200">
                                <!-- Date Picker -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Date <span class="text-red-500">*</span></label>
                                    <input type="date" 
                                           id="appointmentDate_${pet.id}" 
                                           min="${new Date().toISOString().split('T')[0]}"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                           onchange="loadPetSlots(${pet.id})">
                                </div>
                                
                                <!-- Availability Status -->
                                <div id="slotStatus_${pet.id}" class="mb-4 hidden">
                                    <div class="flex items-center gap-2 text-sm">
                                        <span id="dailyCapacity_${pet.id}" class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700">
                                            Loading...
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Time Slots Grid -->
                                <div id="timeSlots_${pet.id}" class="mb-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Time <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-3 gap-2" id="slotsGrid_${pet.id}">
                                        <!-- Slots will be loaded dynamically -->
                                    </div>
                                </div>
                                
                                <!-- Selected Summary -->
                                <div id="selectedSummary_${pet.id}" class="hidden bg-green-50 border border-green-200 rounded-lg p-3">
                                    <p class="text-sm text-green-700 font-medium">
                                        Selected: <span id="selectedDate_${pet.id}">-</span> at <span id="selectedTime_${pet.id}">-</span>
                                    </p>
                                </div>
                                
                                <!-- Hidden inputs for form submission -->
                                <input type="hidden" name="pet_appointments[${pet.id}][date]" id="hiddenDate_${pet.id}" value="">
                                <input type="hidden" name="pet_appointments[${pet.id}][time]" id="hiddenTime_${pet.id}" value="">
                            </div>
                        </div>

                        <!-- Vaccination History Toggle -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Has your pet received an anti-rabies vaccine before?</label>
                            <div class="flex space-x-6 mb-3">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="pet_medical_history[${pet.id}][has_previous_vaccine]" value="yes" 
                                           class="form-radio h-5 w-5 text-primary" onchange="toggleVaccineDate(this, ${pet.id})">
                                    <span class="ml-3 text-gray-700 font-medium">Yes, has received before</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="pet_medical_history[${pet.id}][has_previous_vaccine]" value="no" 
                                           class="form-radio h-5 w-5 text-primary" onchange="toggleVaccineDate(this, ${pet.id})">
                                    <span class="ml-3 text-gray-700 font-medium">No history / First time</span>
                                </label>
                            </div>
                            
                            <!-- Date picker (shown when "Yes" is selected) -->
                            <div id="vaccineDateContainer_${pet.id}" class="hidden mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Last Anti-Rabies</label>
                                <input type="date" name="pet_medical_history[${pet.id}][last_anti_rabies_date]" 
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Surgery Question -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Did your pet undergo any surgery in the last two (2) weeks? <span class="text-red-500">*</span></label>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="pet_medical_history[${pet.id}][recent_surgery]" value="yes" class="form-radio h-5 w-5 text-primary">
                                    <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="pet_medical_history[${pet.id}][recent_surgery]" value="no" class="form-radio h-5 w-5 text-primary">
                                    <span class="ml-3 text-gray-700 font-medium">No</span>
                                </label>
                            </div>
                        </div>
                    `;
                    container.appendChild(medicalCard);
                }
            });
        }

        function removePet(petId) {
            // Remove from selectedPets array (convert to string for comparison)
            selectedPets = selectedPets.filter(id => String(id) !== String(petId));
            
            // Uncheck the checkbox in modal
            const checkbox = document.querySelector(`#petSelectionList input[value="${petId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
            
            // Rebuild the display
            confirmPetSelection();
            updateSelectedCount();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePetModal();
            }
        });
    </script>
</body>
</html>
