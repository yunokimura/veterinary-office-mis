<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration Form - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/breeds.js') }}" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
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
        .pet-breed-checkbox:checked + .pet-breed-label {
            background-color: #047857;
            color: white;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(100%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-up {
            animation: slide-up 0.3s ease-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('Client.partials.navbar')

     <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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

        <!-- Success/Info Messages -->
        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-blue-800">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Pet Registration</h2>
            <p class="text-gray-700 text-xs mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Multi-Step Progress Indicator -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">REGISTRATION PROGRESS</h4>
                        </div>
                        <span id="stepIndicatorText" class="text-sm text-emerald-300 font-medium">Step 1 of 4 — Pet Basics</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-2">
                            <button type="button" onclick="goToStep(1)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="1">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="1">1</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Pet Basics</span>
                                    <span class="step-subtitle block text-xs text-gray-700 truncate">Profile & breed</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(2)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="2">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="2">2</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Physical Details</span>
                                    <span class="step-subtitle block text-xs text-gray-700 truncate">Age & photos</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(3)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="3">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="3">3</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Health & Traits</span>
                                    <span class="step-subtitle block text-xs text-gray-700 truncate">Vaccines & behavior</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(4)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="4">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="4">4</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Review & Submit</span>
                                    <span class="step-subtitle block text-xs text-gray-700 truncate">Confirm details</span>
                                </span>
                            </button>
                        </div>
                        <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div id="progressBar" class="h-full bg-emerald-600 transition-all duration-300" style="width: 25%"></div>
                        </div>
                    </div>
                </div>

                <form id="petRegistrationForm" method="POST" action="{{ url('/pet-registration/form') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="book_booster" id="bookBoosterInput" value="0">

                    <!-- STEP 1: Pet Basics -->
                    <div id="step-1" class="step-pane space-y-6">
<!-- Card 1: Pet Profile & Basic Info -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Pet Profile & Basic Information</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Profile Picture Section -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Profile Picture</label>
                                <div class="flex items-center space-x-6">
                                    <!-- Camera icon placeholder until a photo is uploaded -->
                                    <div class="shrink-0">
                                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-emerald-300 relative bg-emerald-50 cursor-pointer" onclick="document.getElementById('petImage').click()">
                                            <div id="petImagePlaceholder" class="absolute inset-0 flex items-center justify-center">
                                                <i class="fi fi-rr-camera text-3xl sm:text-4xl text-emerald-500"></i>
                                            </div>
                                            <img id="petImagePreview" src="" alt="Pet Profile" class="w-full h-full object-cover hidden">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white opacity-0 hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" id="petImage" name="pet_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                                    <div>
                                        <p class="text-sm text-gray-600">Upload a photo of your pet</p>
                                        <p class="text-sm text-gray-400">Click the image to upload</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pet Name -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Your Pet's Name <span class="text-red-500">*</span></label>
                                <input type="text" name="pet_name" value="{{ old('pet_name') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Enter your pet's name" required>
                            </div>

                            <!-- Pet Type -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">What kind of pet do you have? <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_type" value="dog" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required {{ old('pet_type') === 'dog' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Dog</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_type" value="cat" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required {{ old('pet_type') === 'cat' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Cat</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Gender & Spayed / Neutered -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Gender <span class="text-red-500">*</span></label>
                                    <div class="flex space-x-6">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender" value="male" class="form-radio h-5 w-5 text-emerald-600" required {{ old('gender') === 'male' ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700 font-medium">Male</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender" value="female" class="form-radio h-5 w-5 text-emerald-600" required {{ old('gender') === 'female' ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700 font-medium">Female</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Spayed / Neutered -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Spayed / Neutered <span class="text-red-500">*</span></label>
                                    <div class="flex space-x-6">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_neutered" value="yes" class="form-radio h-5 w-5 text-emerald-600" required {{ old('is_neutered') === 'yes' ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_neutered" value="no" class="form-radio h-5 w-5 text-emerald-600" required {{ old('is_neutered') === 'no' ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700 font-medium">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Card 2: Breed Information -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Breed Information</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Crossbreed -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Crossbreed <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="is_crossbreed" value="yes" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleCrossbreed()" required {{ old('is_crossbreed') === 'yes' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="is_crossbreed" value="no" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleCrossbreed()" required {{ old('is_crossbreed') === 'no' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Pet Breed -->
                            <div id="breedSection">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Pet Breed <span class="text-red-500">*</span>
                                    <span id="breedLimitText" class="text-xs text-gray-700 font-normal ml-1">(select one)</span>
                                </label>

                                <!-- Modal trigger -->
                                <div class="relative">
                                    <button type="button" id="breedDisplay" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg cursor-pointer hover:border-slate-400 transition-colors text-left flex items-center focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" onclick="openBreedModal()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span id="selectedBreedText" class="text-gray-700 truncate">Search or select a breed</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Hidden input for breed -->
                                <input type="hidden" id="petBreedInput" name="pet_breed" value="{{ old('pet_breed') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1 Navigation -->
                    <div class="flex items-center justify-between">
                        <a href="{{ url('/pet-registration') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancel
                        </a>
                        <button type="button" onclick="changeStep(1)" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors shadow-sm">
                            Next Step
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    </div>

                    <!-- STEP 2: Physical Details & Photos -->
                    <div id="step-2" class="step-pane space-y-6 hidden">
<!-- Card 3: Age & Physical Details -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Age & Physical Details</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Do you know your pet's birthdate -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Do you know your pet's birthdate? <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="know_birthdate" value="yes" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleBirthdate()" required {{ old('know_birthdate') === 'yes' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="know_birthdate" value="no" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleBirthdate()" required {{ old('know_birthdate') === 'no' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Pet's Birthdate / Pet Age (shown once an option above is chosen) -->
                            <div id="ageOrBirthdateWrap" class="hidden border-l-2 border-emerald-300 pl-4">

                                <!-- Pet's Birthdate (shown if "Yes" is selected) -->
                                <div id="birthdateSection" class="hidden">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Birthdate</label>
                                    <input type="date" id="petBirthdate" name="pet_birthdate" value="{{ old('pet_birthdate') }}" max="{{ now()->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                </div>

                                <!-- Pet Age (shown if "No" is selected) -->
                                <div id="ageSection" class="hidden">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet Age</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Years</label>
                                            <select id="petAgeYears" name="pet_age_years" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                                <option value="">Select years</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Months</label>
                                            <select id="petAgeMonths" name="pet_age_months" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                                <option value="">Select months</option>
                                            </select>
                                        </div>
                                    </div>
                                    <p id="ageHint" class="text-xs text-gray-700 mt-1 hidden">Please specify your pet's age in years or months.</p>
                                </div>
                            </div>

                            <!-- Pet Weight -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Weight (kg) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" id="petWeight" name="pet_weight" value="{{ old('pet_weight') }}" {!! old('weight_unknown') ? 'data-weight-unknown="true" readonly placeholder="Weight unknown" maxlength="6"' : 'placeholder="Enter weight in kg" maxlength="6"' !!} class="w-full px-3.5 py-2.5 pr-12 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all {{ old('weight_unknown') ? 'bg-slate-100 text-gray-400 cursor-not-allowed' : '' }}" oninput="updateWeightSuffix(); validateWeight(this)" required>
                                    <span id="weightSuffix" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-700 font-medium pointer-events-none hidden">kg</span>
                                </div>
                                <label class="inline-flex items-center cursor-pointer mt-2">
                                    <input type="checkbox" id="weightUnknown" name="weight_unknown" value="1" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleWeightUnknown()" {{ old('weight_unknown') ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium">Weight unknown</span>
                                </label>
                            </div>
                        </div>
                    </div>

<!-- Card 4: Unique Identifying Features -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Unique Identifying Features</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Eye Color -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Eye Color <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2" id="eyeColorOptions">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Brown" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Brown' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Brown</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Blue" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Blue' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Blue</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Amber / Yellow" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Amber / Yellow' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Amber / Yellow</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Green" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Green' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Green</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Heterochromia (Two different colors)" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Heterochromia (Two different colors)' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Heterochromia (Two different colors)</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Other" class="peer sr-only" required onchange="handleEyeColorChange()" {{ old('eye_color') === 'Other' ? 'checked' : '' }}>
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Other</span>
                                    </label>
                                </div>
                                <div id="eyeColorOtherWrap" class="mt-3 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Please specify eye color</label>
                                    <input type="text" id="eyeColorOther" name="eye_color_other" value="{{ old('eye_color_other') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify your pet's eye color">
                                </div>

                                <!-- Left / Right Eye Color (shown for heterochromia) -->
                                <div id="eyeColorHeterochromiaWrap" class="mt-2 p-4 bg-emerald-50/60 border border-emerald-200 rounded-xl rounded-tl-none hidden">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- Left Eye -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Left Eye Color</label>
                                            <select id="eyeColorLeft" name="eye_color_left" onchange="handleEyeSideChange('Left')" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                                <option value="">Select left eye color</option>
                                                <option value="Brown" {{ old('eye_color_left') === 'Brown' ? 'selected' : '' }}>Brown</option>
                                                <option value="Blue" {{ old('eye_color_left') === 'Blue' ? 'selected' : '' }}>Blue</option>
                                                <option value="Amber / Yellow" {{ old('eye_color_left') === 'Amber / Yellow' ? 'selected' : '' }}>Amber / Yellow</option>
                                                <option value="Green" {{ old('eye_color_left') === 'Green' ? 'selected' : '' }}>Green</option>
                                                <option value="Hazel" {{ old('eye_color_left') === 'Hazel' ? 'selected' : '' }}>Hazel</option>
                                                <option value="Parti-Colored / Marbled" {{ old('eye_color_left') === 'Parti-Colored / Marbled' ? 'selected' : '' }}>Parti-Colored / Marbled</option>
                                                <option value="Other" {{ old('eye_color_left') === 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <p class="text-xs text-gray-700 mt-1">Select the predominant color for each eye.</p>
                                            <div id="eyeColorLeftOtherWrap" class="mt-2 hidden">
                                                <input type="text" id="eyeColorLeftOther" name="eye_color_left_other" value="{{ old('eye_color_left_other') }}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify left eye color">
                                            </div>
                                        </div>

                                        <!-- Right Eye -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Right Eye Color</label>
                                            <select id="eyeColorRight" name="eye_color_right" onchange="handleEyeSideChange('Right')" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                                <option value="">Select right eye color</option>
                                                <option value="Brown" {{ old('eye_color_right') === 'Brown' ? 'selected' : '' }}>Brown</option>
                                                <option value="Blue" {{ old('eye_color_right') === 'Blue' ? 'selected' : '' }}>Blue</option>
                                                <option value="Amber / Yellow" {{ old('eye_color_right') === 'Amber / Yellow' ? 'selected' : '' }}>Amber / Yellow</option>
                                                <option value="Green" {{ old('eye_color_right') === 'Green' ? 'selected' : '' }}>Green</option>
                                                <option value="Hazel" {{ old('eye_color_right') === 'Hazel' ? 'selected' : '' }}>Hazel</option>
                                                <option value="Parti-Colored / Marbled" {{ old('eye_color_right') === 'Parti-Colored / Marbled' ? 'selected' : '' }}>Parti-Colored / Marbled</option>
                                                <option value="Other" {{ old('eye_color_right') === 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <div id="eyeColorRightOtherWrap" class="mt-2 hidden">
                                                <input type="text" id="eyeColorRightOther" name="eye_color_right_other" value="{{ old('eye_color_right_other') }}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify right eye color">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Front, Side, Top-down View -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Front, Side, Top-down View <span class="text-red-500">*</span></label>
                                <p class="text-xs text-gray-700 mb-4">Upload the front, side, and top-down views of your pet</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <!-- Front View -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Front View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[120px]">
                                            <img id="frontPreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                            <input type="file" id="frontImage" name="additional_photos[front]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'frontPreview')" required>
                                            <button type="button" onclick="removePhoto('front')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="frontRemoveBtn" aria-label="Remove front view photo">×</button>
                                            <button type="button" onclick="document.getElementById('frontImage').click()" id="frontUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                <i class="fi fi-br-picture text-4xl mb-2"></i>
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Side View -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Side View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[120px]">
                                            <img id="sidePreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                            <input type="file" id="sideImage" name="additional_photos[side]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'sidePreview')" required>
                                            <button type="button" onclick="removePhoto('side')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="sideRemoveBtn" aria-label="Remove side view photo">×</button>
                                            <button type="button" onclick="document.getElementById('sideImage').click()" id="sideUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                <i class="fi fi-br-picture text-4xl mb-2"></i>
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Top-Down View -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Top-Down View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[120px]">
                                            <img id="topPreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                            <input type="file" id="topImage" name="additional_photos[top]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'topPreview')" required>
                                            <button type="button" onclick="removePhoto('top')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="topRemoveBtn" aria-label="Remove top-down view photo">×</button>
                                            <button type="button" onclick="document.getElementById('topImage').click()" id="topUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                <i class="fi fi-br-picture text-4xl mb-2"></i>
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Unique Body Mark -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Unique Body Mark</label>
                                <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[144px] w-36 md:w-48">
                                    <img id="bodyMarkPreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                    <input type="file" id="bodyMarkImage" name="body_mark_image" accept="image/*" class="hidden" onchange="previewBodyMark(event)">
                                    <button type="button" onclick="removeBodyMark()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="bodyMarkRemoveBtn" aria-label="Remove body mark photo">×</button>
                                    <button type="button" onclick="document.getElementById('bodyMarkImage').click()" id="bodyMarkUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                        <i class="fi fi-br-picture text-4xl mb-2"></i>
                                        Click to upload
                                    </button>
                                </div>
                                <p class="text-xs text-gray-700 mt-2">Optional — upload a photo of a distinguishing mark if you have one.</p>
                            </div>

                            <!-- Body Mark Details -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Body Mark Details</label>
                                <textarea id="bodyMarkDetails" name="body_mark_details" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Describe any unique marks, scars, or distinguishing features...">{{ old('body_mark_details') }}</textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Step 2 Navigation -->
                    <div class="flex items-center justify-between">
                        <button type="button" onclick="changeStep(-1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="changeStep(1)" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors shadow-sm">
                            Next Step
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    </div>

                    <!-- STEP 3: Health & Traits -->
                    <div id="step-3" class="step-pane space-y-6 hidden">
<!-- Card 5: Vaccination History -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Vaccination History</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Not Vaccinated Checkbox (TOP) -->
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="not_vaccinated" value="1" id="notVaccinatedCheckbox" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleVaccinationFields(this); toggleNotVaccinated(this)" {{ old('not_vaccinated') ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium" id="notVaccinatedLabel">My pet is not yet vaccinated / records unavailable</span>
                                </label>
                            </div>

                            <!-- Core Vaccines Section -->
                            <div id="coreVaccinesSection" class="space-y-4">
                                <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Core Vaccines</h5>

                                <!-- Anti-Rabies (always present) with sub-fields -->
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="vaccination_core[]" value="Anti-Rabies" id="antiRabiesCheckbox" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleAntiRabiesFields(this)" {{ in_array('Anti-Rabies', old('vaccination_core', [])) ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium" id="antiRabiesLabel">Anti-Rabies Vaccination</span>
                                    </label>

                                    <!-- Anti-Rabies sub-fields (shown when checked) -->
                                    <div id="antiRabiesFields" class="hidden pl-8 grid grid-cols-1 md:grid-cols-3 gap-4 pt-3 border-t border-slate-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Administered <span class="text-red-500">*</span></label>
                                            <input type="date" name="anti_rabies[date_administered]" value="{{ old('anti_rabies.date_administered') }}" max="{{ now()->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Vaccine Lot No. (Optional)</label>
                                            <input type="text" name="anti_rabies[lot_no]" value="{{ old('anti_rabies.lot_no') }}" placeholder="G12345" maxlength="6" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '').slice(0, 6);">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tag / Sticker No.</label>
                                            <input type="text" name="anti_rabies[tag_no]" value="{{ old('anti_rabies.tag_no') }}" placeholder="DAS-2026-123" maxlength="30" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" oninput="this.value = this.value.replace(/[^A-Za-z0-9\-\s]/g, '').slice(0, 30);">
                                            <p class="text-xs text-gray-700 mt-1">Enter tag, sticker, or certificate number if available.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other core vaccines (species-dependent) -->
                                <div id="otherCoreVaccines" class="space-y-2">
                                    <!-- Populated by JS based on pet_type -->
                                </div>
                            </div>

                            <!-- Optional Vaccines Section -->
                            <div id="optionalVaccinesSection" class="space-y-4">
                                <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Optional Vaccines</h5>
                                <div id="optionalVaccineOptions" class="space-y-2">
                                    <!-- Populated by JS based on pet_type -->
                                </div>
                            </div>

                            <!-- Vaccination Card Upload -->
                            <div id="vaccinationCardUploadSection" class="pt-4 border-t border-slate-200">
                                <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Vaccination Booklet / Certificate (Optional)</h5>
                                <p class="text-xs text-gray-700 mb-3">Upload a photo of the pet's vaccination record card.</p>
                                <div class="relative w-full h-40 border-2 border-dashed border-slate-300 rounded-xl hover:border-emerald-400 transition-colors bg-white">
                                    <input type="file" id="vaccinationCard" name="vaccination_card" accept="image/*" class="hidden" onchange="previewVaccinationCard(event)">
                                    <img id="vaccinationCardPreview" class="hidden w-full h-full object-cover rounded-lg mx-auto">
                                    <button type="button" onclick="removeVaccinationCard()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="vaccinationCardRemoveBtn" aria-label="Remove vaccination card">×</button>
                                    <button type="button" onclick="document.getElementById('vaccinationCard').click()" id="vaccinationCardUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                        <i class="fi fi-br-picture text-4xl mb-2"></i>
                                        Click to upload vaccination booklet / certificate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Card 6: Pet Attributes -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6" id="petAttributesSection">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Pet Attributes</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Training -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Training</label>
                                <div class="flex flex-wrap gap-2" id="trainingOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <!-- Insurance -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Insurance</label>
                                <div class="flex flex-wrap gap-2" id="insuranceOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <!-- Behavior -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Behavior</label>
                                <div class="flex flex-wrap gap-2" id="behaviorOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <!-- Likes (max 5) -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Likes <span class="text-xs text-gray-700 font-normal">(You can pick up to 5)</span>
                                </label>
                                <div class="flex flex-wrap gap-2" id="likesOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <!-- Dislikes -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Dislikes</label>
                                <div class="flex flex-wrap gap-2" id="dislikesOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <!-- Diet (max 5) -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Diet <span class="text-xs text-gray-700 font-normal">(You can pick up to 5)</span>
                                </label>
                                <div class="flex flex-wrap gap-2" id="dietOptions">
                                    <!-- Populated by JS -->
                                </div>
                                <button type="button" id="dietShowMore" class="mt-2 text-sm text-emerald-600 hover:underline hidden" onclick="showMoreDiet()">Show More</button>
                            </div>

                            <!-- Allergy -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Allergy</label>
                                <div class="flex flex-wrap gap-2" id="allergyOptions">
                                    <!-- Populated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 Navigation -->
                    <div class="flex items-center justify-between">
                        <button type="button" onclick="changeStep(-1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="changeStep(1)" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors shadow-sm">
                            Review & Submit
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    </div>

                    <!-- STEP 4: Review & Submit -->
                    <div id="step-4" class="step-pane space-y-6 hidden">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                            <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="text-sm font-semibold text-white">Review & Submit</h4>
                                </div>
                                <span class="text-sm text-emerald-300">Final Verification</span>
                            </div>
                            <div class="p-6 space-y-6">

                                <!-- Review: Pet Basics -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Pet Basics
                                        <a href="#" onclick="event.preventDefault(); goToStep(1);" class="text-sm text-emerald-600 hover:underline ml-2">Edit</a>
                                    </h5>
                                    <div id="reviewBasics" class="bg-slate-50 border border-slate-200 rounded-xl p-4 divide-y divide-slate-100"></div>
                                </div>

                                <!-- Review: Physical Details & Photos -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Physical Details & Photos
                                        <a href="#" onclick="event.preventDefault(); goToStep(2);" class="text-sm text-emerald-600 hover:underline ml-2">Edit</a>
                                    </h5>
                                    <div id="reviewPhysical" class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-4">
                                        <div id="reviewPhysicalRows" class="divide-y divide-slate-100"></div>
                                        <div id="reviewPhysicalImages" class="flex flex-wrap gap-3"></div>
                                    </div>
                                </div>

<!-- Review: Health & Traits -->
                            <div>
                                <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Health & Traits
                                    <a href="#" onclick="event.preventDefault(); goToStep(3);" class="text-sm text-emerald-600 hover:underline ml-2">Edit</a>
                                </h5>
                                <div id="reviewHealth" class="bg-slate-50 border border-slate-200 rounded-xl p-4 grid grid-cols-[120px_1fr] gap-x-4 gap-y-3"></div>
                            </div>
                        </div>
                        </div>

                        <!-- Step 4 Navigation -->
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                            <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <button type="button" onclick="changeStep(-1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                <button type="button" onclick="showConfirmModal()" class="inline-flex items-center justify-center gap-2 px-10 py-3.5 bg-emerald-600 text-white rounded-xl font-semibold text-base hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Register
                                </button>
                            </div>
                            <div class="px-6 pb-6 text-center">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <div class="lg:sticky lg:top-20 space-y-6">
                    <!-- Owner Summary Card -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">OWNER'S INFORMATION</h4>
                            </div>
                            <span class="text-sm text-emerald-300">Read-Only</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-sm text-gray-700 mb-1">Pet Owner Name</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $petOwner->first_name ?? '' }} {{ $petOwner && $petOwner->middle_name ? $petOwner->middle_name . ' ' : '' }}{{ $petOwner->last_name ?? '' }}</p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-700">Email</p>
                                        <p class="text-sm text-gray-900 truncate">{{ $petOwner->email ?? $user->email ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-700">Primary</p>
                                        <p class="text-sm text-gray-900">+63 {{ $petOwner->phone_number ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-700">Address</p>
                                        <p class="text-sm text-gray-900">
                                            {{ $petOwner->address->block_lot_phase ?? $petOwner->blk_lot_ph ?? '' }}, {{ $petOwner->address->street ?? $petOwner->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? $petOwner->barangay ?? '' }}, Dasmariñas City
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-700">Alternate Mobile Number</p>
                                        <p class="text-sm text-gray-900">+63 {{ $petOwner->alternate_phone_number ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('Client.partials.footer')

    <script>
        // Breed data loaded from external file (public/js/breeds.js)
        // quickDogBreeds, quickCatBreeds, catBreeds, dogBreeds are globally available

        let selectedBreeds = [];
        let currentPetType = '';
        let lastFocusedElement = null;

        // Returns true only when the crossbreed answer is "Yes"
        function isCrossbreedSelected() {
            const selected = document.querySelector('input[name="is_crossbreed"]:checked');
            return selected ? selected.value === 'yes' : false;
        }

        // Focus trap utility
        function trapFocus(element) {
            const focusableElements = element.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            element.addEventListener('keydown', function handleTab(e) {
                if (e.key !== 'Tab') return;
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            });
        }

        // Open the breed selector modal
        function openBreedModal() {
            const petType = document.querySelector('input[name="pet_type"]:checked');

            if (!petType) {
                alert('Please select the type of pet (Dog or Cat) first.');
                return;
            }

            currentPetType = petType.value;

            const isCrossbreed = isCrossbreedSelected();
            document.getElementById('breedModalLimit').textContent = isCrossbreed ? '(maximum of 2)' : '(select one)';

            renderBreedModal();
            document.getElementById('breedModalSearch').value = '';

            const modal = document.getElementById('breedModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-modal', 'true');
            modal.setAttribute('role', 'dialog');
            document.body.classList.add('overflow-hidden');

            // Store last focused element for restoration
            lastFocusedElement = document.activeElement;

            // Auto-focus the search bar once the modal is visible
            setTimeout(() => {
                const searchInput = document.getElementById('breedModalSearch');
                if (searchInput) {
                    searchInput.focus();
                    trapFocus(modal);
                }
            }, 50);
        }

        // Close the breed selector modal
        function closeBreedModal() {
            const modal = document.getElementById('breedModal');
            modal.classList.add('hidden');
            modal.removeAttribute('aria-modal');
            modal.removeAttribute('role');
            document.body.classList.remove('overflow-hidden');

            // Restore focus to trigger element
            if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
                lastFocusedElement.focus();
            }
            lastFocusedElement = null;
        }

        // Render quick chips + alphabetical list for the current species
        function renderBreedModal(filter = '') {
            if (!currentPetType) return;

            const breeds = currentPetType === 'cat' ? catBreeds : dogBreeds;
            const quickBreeds = currentPetType === 'cat' ? quickCatBreeds : quickDogBreeds;
            const isCrossbreed = isCrossbreedSelected();
            const search = filter.trim().toLowerCase();

            // --- Quick selections (hidden while searching) ---
            const quickWrap = document.getElementById('breedModalQuick');
            const quickChips = document.getElementById('breedModalQuickChips');

            if (search) {
                quickWrap.classList.add('hidden');
            } else {
                quickWrap.classList.remove('hidden');
                const availableQuick = quickBreeds.filter(b => breeds.includes(b));
                quickChips.innerHTML = availableQuick.map(breed => {
                    const selected = selectedBreeds.includes(breed);
                    return `
                        <button type="button" onclick="toggleBreedFromModal('${breed.replace(/'/g, "\\'")}')"
                                class="px-3 py-1.5 text-sm rounded-full border transition-colors ${selected
                                    ? 'bg-emerald-600 text-white border-emerald-600'
                                    : 'border-slate-300 text-gray-700 hover:bg-emerald-50 hover:border-emerald-400'}"
                                aria-pressed="${selected}">
                            ${breed}
                            ${selected ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 inline ml-1 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>' : ''}
                        </button>`;
                }).join('');
            }

            // --- Alphabetical, grouped list ---
            const filtered = breeds.filter(b => b.toLowerCase().includes(search));
            const list = document.getElementById('breedModalList');
            const empty = document.getElementById('breedModalEmpty');

            if (filtered.length === 0) {
                list.innerHTML = '';
                empty.classList.remove('hidden');
                return;
            }

            empty.classList.add('hidden');

            // Group by first letter
            const groups = {};
            filtered.forEach(breed => {
                const letter = breed.charAt(0).toUpperCase();
                if (!groups[letter]) groups[letter] = [];
                groups[letter].push(breed);
            });

            let html = '';
            Object.keys(groups).sort().forEach(letter => {
                html += `
                    <div class="mb-4">
                        <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 py-1.5">
                            <span class="text-sm font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 border border-emerald-200 rounded-md px-2 py-0.5">${letter}</span>
                        </div>
                        <div class="space-y-1 mt-1">`;

groups[letter].forEach((breed, breedIndex) => {
                    const selected = selectedBreeds.includes(breed);
                    const breedSlug = breed.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                    const inputId = `breed-opt-${breedSlug}-${breedIndex}`;
                    if (isCrossbreed) {
                        html += `
                            <label class="flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors ${selected ? 'bg-emerald-50' : 'hover:bg-slate-50'}" for="${inputId}">
                                <input type="checkbox" id="${inputId}" value="${breed}" class="pet-breed-checkbox h-4 w-4 text-emerald-600 rounded border-slate-300" ${selected ? 'checked' : ''} onchange="handleBreedCheckbox(this)">
                                <span class="ml-3 text-sm pet-breed-label ${selected ? 'text-emerald-800 font-semibold' : 'text-gray-700'}">${breed}</span>
                                ${selected ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>' : ''}
                            </label>`;
                    } else {
                        html += `
                            <label class="flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors ${selected ? 'bg-emerald-50' : 'hover:bg-slate-50'}" for="${inputId}">
                                <input type="radio" id="${inputId}" name="breed_option" value="${breed}" class="pet-breed-radio h-4 w-4 text-emerald-600 border-slate-300" ${selected ? 'checked' : ''} onchange="handleSingleBreedSelect('${breed.replace(/'/g, "\\'")}')">
                                <span class="ml-3 text-sm pet-breed-label ${selected ? 'text-emerald-800 font-semibold' : 'text-gray-700'}">${breed}</span>
                                ${selected ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>' : ''}
                            </label>`;
                    }
                });

                html += `</div></div>`;
            });

            list.innerHTML = html;
        }

        // Filter the modal list as the user types
        function filterBreedModal() {
            renderBreedModal(document.getElementById('breedModalSearch').value);
        }

        // Toggle a quick-selection chip
        function toggleBreedFromModal(breed) {
            if (isCrossbreedSelected()) {
                // Crossbreed: checkbox style toggle with max 2
                const checkbox = document.querySelector(`.pet-breed-checkbox[value="${breed}"]`);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    handleBreedCheckbox(checkbox);
                }
            } else {
                handleSingleBreedSelect(breed);
            }
        }

        // Close modal with the Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Vaccination recommendation modal requires an explicit choice
                const vaccinationModal = document.getElementById('vaccinationModal');
                if (vaccinationModal && !vaccinationModal.classList.contains('hidden')) {
                    return;
                }
                const breedModal = document.getElementById('breedModal');
                if (breedModal && !breedModal.classList.contains('hidden')) {
                    closeBreedModal();
                    return;
                }
                const confirmModal = document.getElementById('confirmModal');
                if (confirmModal && !confirmModal.classList.contains('hidden')) {
                    closeConfirmModal();
                }
            }
        });

        // Update breed options when the species changes
        function updateBreedOptions() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            currentPetType = petType ? petType.value : '';

            const breedLimitText = document.getElementById('breedLimitText');

            // Clear previous selections
            selectedBreeds = [];
            updateSelectedBreedDisplay();

            if (!currentPetType) {
                return;
            }

            if (breedLimitText) {
                breedLimitText.textContent = isCrossbreedSelected() ? '(maximum of 2)' : '(select one)';
            }
        }

        // Toggle crossbreed mode
        function toggleCrossbreed() {
            const isCrossbreed = isCrossbreedSelected();

            // Clear selections when toggling
            selectedBreeds = [];
            updateSelectedBreedDisplay();
            
            updateBreedOptions();
        }

        // Handle breed checkbox selection (crossbreed mode)
        function handleBreedCheckbox(checkbox) {
            const breed = checkbox.value;

            if (checkbox.checked) {
                if (selectedBreeds.length >= 2) {
                    checkbox.checked = false;
                    alert('Maximum of 2 breeds allowed');
                    return;
                }
                selectedBreeds.push(breed);
            } else {
                selectedBreeds = selectedBreeds.filter(b => b !== breed);
            }

            updateSelectedBreedDisplay();
            // Keep the modal in sync with the selection state
            renderBreedModal(document.getElementById('breedModalSearch').value);
        }

        // Handle single breed selection (radio mode)
        function handleSingleBreedSelect(breed) {
            selectedBreeds = [breed];

            // Update hidden input
            document.getElementById('petBreedInput').value = breed;

            // Update display text
            const selectedText = document.getElementById('selectedBreedText');
            selectedText.textContent = breed;
            selectedText.classList.remove('text-gray-700');
            selectedText.classList.add('text-gray-900');

            updateSelectedBreedDisplay();

            // Close the modal after picking a single breed
            closeBreedModal();
        }

        // "Other / Breed Not Listed" fallback - shows inline input instead of prompt
        function showOtherBreedInput() {
            const btn = document.getElementById('otherBreedBtn');
            const wrap = document.getElementById('otherBreedInputWrap');
            const input = document.getElementById('otherBreedInput');
            
            if (btn) btn.classList.add('hidden');
            if (wrap) wrap.classList.remove('hidden');
            if (input) {
                input.value = '';
                setTimeout(() => input.focus(), 50);
            }
        }

        function hideOtherBreedInput() {
            const btn = document.getElementById('otherBreedBtn');
            const wrap = document.getElementById('otherBreedInputWrap');
            const input = document.getElementById('otherBreedInput');
            
            if (btn) btn.classList.remove('hidden');
            if (wrap) wrap.classList.add('hidden');
            if (input) input.value = '';
        }

        function submitOtherBreed() {
            const input = document.getElementById('otherBreedInput');
            if (!input) return;
            
            const otherBreed = input.value.trim();
            if (!otherBreed) {
                input.focus();
                return;
            }
            
            const isCrossbreed = isCrossbreedSelected();
            
            if (isCrossbreed) {
                if (selectedBreeds.length >= 2) {
                    alert('Maximum of 2 breeds allowed');
                    return;
                }
                selectedBreeds.push(otherBreed);
            } else {
                selectedBreeds = [otherBreed];
            }
            
            document.getElementById('petBreedInput').value = selectedBreeds.join(', ');
            
            const selectedText = document.getElementById('selectedBreedText');
            selectedText.textContent = selectedBreeds.join(', ');
            selectedText.classList.remove('text-gray-700');
            selectedText.classList.add('text-gray-900');
            
            updateSelectedBreedDisplay();
            hideOtherBreedInput();
            closeBreedModal();
        }

        // Handle Enter/Escape in other breed input
        document.addEventListener('keydown', function(e) {
            const wrap = document.getElementById('otherBreedInputWrap');
            if (!wrap || wrap.classList.contains('hidden')) return;
            
            if (e.key === 'Enter') {
                e.preventDefault();
                submitOtherBreed();
            } else if (e.key === 'Escape') {
                hideOtherBreedInput();
            }
        });

        // Update the breed trigger text and hidden input
        function updateSelectedBreedDisplay() {
            const selectedText = document.getElementById('selectedBreedText');
            const breedDisplay = document.getElementById('breedDisplay');
            const petBreedInput = document.getElementById('petBreedInput');

            if (breedDisplay) {
                breedDisplay.classList.remove('ring-2', 'ring-red-400', 'border-red-400');
            }

            if (selectedBreeds.length === 0) {
                petBreedInput.value = '';
                if (selectedText) {
                    selectedText.textContent = 'Search or select a breed';
                    selectedText.classList.remove('text-gray-900');
                    selectedText.classList.add('text-gray-700');
                }
                return;
            }

            // The trigger field shows the selected breed(s)
            selectedText.textContent = selectedBreeds.join(', ');
            selectedText.classList.remove('text-gray-700');
            selectedText.classList.add('text-gray-900');

            petBreedInput.value = selectedBreeds.join(', ');
        }

        // Preview body mark image
        function previewBodyMark(event) {
            const file = event.target.files[0];
            if (!file) return;

            try {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('bodyMarkPreview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    const removeBtn = document.getElementById('bodyMarkRemoveBtn');
                    if (removeBtn) removeBtn.classList.remove('hidden');
                    const uploadBtn = document.getElementById('bodyMarkUploadBtn');
                    if (uploadBtn) uploadBtn.classList.add('hidden');
                };
                reader.onerror = function() {
                    showErrorToast('Failed to read image file. Please try another file.');
                };
                reader.readAsDataURL(file);
            } catch (err) {
                showErrorToast('Failed to process image. Please try again.');
            }
        }

        // Remove body mark image
        function removeBodyMark() {
            const preview = document.getElementById('bodyMarkPreview');
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            document.getElementById('bodyMarkImage').value = '';
            const removeBtn = document.getElementById('bodyMarkRemoveBtn');
            if (removeBtn) removeBtn.classList.add('hidden');
            const uploadBtn = document.getElementById('bodyMarkUploadBtn');
            if (uploadBtn) uploadBtn.classList.remove('hidden');
        }

        // Cat attributes data
        const catTraining = ['Obedience-trained', 'Potty-trained'];
        const catInsurance = ['Insured'];
        const catBehavior = ['Independent', 'Curious', 'Territorial', 'Play-biter', 'Affectionate', 'Nocturnal', 'Skittish', 'Hunter', 'Catnip lover', 'Social', 'Shy', 'Friendly', 'Gentle', 'Perching'];
        const catLikes = ['Cuddle time', 'Playing with yarn', 'Sunbathing by the window', 'Treats', 'Puzzle toys', 'Cardboard boxes', 'Chasing mice toys', 'Feather wands', 'Catnip lover', 'Gentle Petting', 'Bunting', 'Climbing'];
        const catDislikes = ['Water/Baths', 'Car rides', 'Vacuum cleaners', 'Strong wind', 'Loud noises/Fireworks', 'Vet visits', 'Being trapped in a room', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        const catDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        const catDietMore = ['Venison', 'Lamb', 'Bison', 'Shrimp', 'Tuna', 'Salmon', 'Catnip', 'Sardines', 'Mackerel', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        const catAllergy = ['Corn', 'Dairy', 'Pork', 'Beef', 'Chicken', 'Lamb', 'Shrimp', 'Tuna', 'Salmon', 'Tailored treats preferred'];

        // Dog attributes data
        const dogTraining = ['Obedience-trained', 'Potty-trained'];
        const dogInsurance = ['Insured'];
        const dogBehavior = ['Friendly', 'Playful', 'Shy', 'Affectionate', 'Social', 'Reactive', 'Energetic', 'Gentle', 'Loyal', 'Protective', 'Anxious', 'Territorial', 'Play-biter', 'Grumpy'];
        const dogLikes = ['Playing fetch', 'Chew toys', 'Gentle petting', 'Long walks', 'Treats', 'Cuddle', 'Belly rub', 'Cuddle time', 'Splashing in water', 'Adventures/Outings', 'Puzzle toys', 'Socializing with other dogs', 'Sunbathing'];
        const dogDislikes = ['Baths', 'Vacuum cleaners', 'Thunderstorms', 'Car rides', 'Loud noises/Fireworks', 'Vet visits', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        const dogDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        const dogDietMore = ['Venison', 'Lamb', 'Duck', 'Tripe', 'Liver', 'Bison', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        const dogAllergy = ['Chicken', 'Beef', 'Lamb', 'Pork', 'Soy', 'Wheat', 'Eggs', 'Dairy', 'Tailored treats preferred'];

        // Selected attributes
        let selectedLikes = [];
        let selectedDiet = [];
        let dietExpanded = false;

        // Vaccination options by pet type

        // Create pill button
        function createPillButton(name, value, category, maxSelect = null) {
            const id = `${category}_${value.replace(/[^a-zA-Z0-9]/g, '')}`;
            return `
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="${id}" name="${name}[]" value="${value}" class="pill-checkbox hidden" data-category="${category}" data-value="${value}" ${maxSelect ? `data-max="${maxSelect}"` : ''} onchange="handlePillChange(this)">
                    <span id="${id}_label" class="px-3 py-1 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors">${value}</span>
                </label>
            `;
        }

        // Handle pill button change
        function handlePillChange(checkbox) {
            const category = checkbox.dataset.category;
            const value = checkbox.dataset.value;
            const label = document.getElementById(`${checkbox.id}_label`);
            const maxSelect = checkbox.dataset.max ? parseInt(checkbox.dataset.max) : null;

            if (checkbox.checked) {
                // Check if max reached
                if (maxSelect) {
                    const currentSelected = document.querySelectorAll(`input[data-category="${category}"]:checked`);
                    if (currentSelected.length > maxSelect) {
                        checkbox.checked = false;
                        alert(`You can only select up to ${maxSelect} options`);
                        return;
                    }
                }
                
                // Update styling
                label.classList.remove('border-slate-300', 'text-gray-700');
                label.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600');
                
                // Add to selected array
                if (category === 'likes') {
                    selectedLikes.push(value);
                } else if (category === 'diet') {
                    selectedDiet.push(value);
                }
            } else {
                // Remove styling
                label.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-600');
                label.classList.add('border-slate-300', 'text-gray-700');
                
                // Remove from selected array
                if (category === 'likes') {
                    selectedLikes = selectedLikes.filter(v => v !== value);
                } else if (category === 'diet') {
                    selectedDiet = selectedDiet.filter(v => v !== value);
                }
}

// Gray out remaining options if max reached
            if (maxSelect) {
                const allCheckboxes = document.querySelectorAll(`input[data-category="${category}"]`);
                const checkedCount = document.querySelectorAll(`input[data-category="${category}"]:checked`).length;
                
                allCheckboxes.forEach(cb => {
                    const cbLabel = document.getElementById(`${cb.id}_label`);
                    if (!cb.checked && checkedCount >= maxSelect) {
                        cbLabel.classList.add('opacity-50', 'cursor-not-allowed');
                    } else if (!cb.checked) {
                        cbLabel.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });

                // Also update Show More button state for diet category
                if (category === 'diet') {
                    updateDietShowMoreButton();
                }
            }
        }

        function createVaccineCheckbox(name, value, checked = false, onchange = '', showOtherInput = false, labelClass = 'inline-flex items-center cursor-pointer') {
            const otherInputId = showOtherInput ? `${name}_${value.replace(/[^a-zA-Z0-9]/g, '_')}_other` : '';
            const changeHandler = onchange || (showOtherInput ? `toggleOtherVaccineInput(this, '${otherInputId}')` : '');
            const otherInputHtml = showOtherInput ? `
                <input type="text" name="${name}_other" id="${otherInputId}" class="ml-3 w-48 px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all hidden" placeholder="Specify">
            ` : '';
            return `
                <label class="${labelClass}">
                    <input type="checkbox" name="${name}[]" value="${value}" class="form-checkbox h-5 w-5 text-emerald-600 rounded" ${checked ? 'checked' : ''} ${changeHandler ? `onchange="${changeHandler}"` : ''}>
                    <span class="ml-3 mr-4 text-gray-700">${value}</span>
                    ${otherInputHtml}
                </label>
            `;
        }

        // Toggle "Other" vaccine input visibility
        function toggleOtherVaccineInput(checkbox, inputId) {
            // Handle both old-style (separate div) and new-style (inline) inputs
            let inputDiv = document.getElementById(inputId);
            if (!inputDiv) {
                // Try to find inline input next to the checkbox
                const label = checkbox.closest('label');
                if (label) {
                    inputDiv = label.querySelector('input[type="text"]');
                }
            }
            if (!inputDiv) return;

            if (checkbox.checked) {
                inputDiv.classList.remove('hidden');
            } else {
                inputDiv.classList.add('hidden');
                // Clear the input value when hiding
                if (inputDiv.tagName === 'INPUT') {
                    inputDiv.value = '';
                } else {
                    const input = inputDiv.querySelector('input[type="text"]');
                    if (input) input.value = '';
                }
            }
        }

        function populateVaccinationHistory() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';

            // Anti-Rabies is hardcoded in HTML with its sub-fields
            // We only need to populate the other core vaccines and optional vaccines

            if (!type) {
                document.getElementById('otherCoreVaccines').innerHTML = '';
                document.getElementById('optionalVaccineOptions').innerHTML = createVaccineCheckbox('vaccination_optional', 'Other', false, '', true);
                return;
            }

            // Other core vaccines (species-specific, excluding Anti-Rabies which is hardcoded)
            const otherCoreVaccines = type === 'cat'
                ? ['4-in-1 / 3-in-1 (FVRCP - Rhinotracheitis, Calicivirus, Panleukopenia)', 'Other']
                : ['5-in-1 / 6-in-1 / 8-in-1 (DHPPi / Leptospirosis)', 'Other'];

            // Optional vaccines (species-specific)
            const optionalVaccines = type === 'cat'
                ? ['Feline Leukemia (FeLV)', 'Other']
                : ['Kennel Cough (Bordetella)', 'Canine Parvovirus (Booster)', 'Other'];

            document.getElementById('otherCoreVaccines').innerHTML = otherCoreVaccines.map(vaccine =>
                createVaccineCheckbox('vaccination_core', vaccine, false, '', vaccine === 'Other', 'flex items-center cursor-pointer')
            ).join('');

            document.getElementById('optionalVaccineOptions').innerHTML = optionalVaccines.map(vaccine => 
                createVaccineCheckbox('vaccination_optional', vaccine, false, '', vaccine === 'Other')
            ).join('');
        }function populatePetAttributes() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            
            // Reset selections
            selectedLikes = [];
            selectedDiet = [];
            dietExpanded = false;
            
            if (!type) {
                document.getElementById('trainingOptions').innerHTML = '';
                document.getElementById('insuranceOptions').innerHTML = '';
                document.getElementById('behaviorOptions').innerHTML = '';
                document.getElementById('likesOptions').innerHTML = '';
                document.getElementById('dislikesOptions').innerHTML = '';
                document.getElementById('dietOptions').innerHTML = '';
                document.getElementById('allergyOptions').innerHTML = '';
                document.getElementById('dietShowMore').classList.add('hidden');
                return;
            }
            
            const isCat = type === 'cat';
            const training = isCat ? catTraining : dogTraining;
            const insurance = isCat ? catInsurance : dogInsurance;
            const behavior = isCat ? catBehavior : dogBehavior;
            const likes = isCat ? catLikes : dogLikes;
            const dislikes = isCat ? catDislikes : dogDislikes;
            const diet = isCat ? catDiet : dogDiet;
            const dietMore = isCat ? catDietMore : dogDietMore;
            const allergy = isCat ? catAllergy : dogAllergy;
            
            // Training
            document.getElementById('trainingOptions').innerHTML = training.map(v => createPillButton('training', v, 'training')).join('');
            
            // Insurance
            document.getElementById('insuranceOptions').innerHTML = insurance.map(v => createPillButton('insurance', v, 'insurance')).join('');
            
            // Behavior
            document.getElementById('behaviorOptions').innerHTML = behavior.map(v => createPillButton('behavior', v, 'behavior')).join('');
            
            // Likes (max 5)
            document.getElementById('likesOptions').innerHTML = likes.map(v => createPillButton('likes', v, 'likes', 5)).join('');
            
            // Dislikes
            document.getElementById('dislikesOptions').innerHTML = dislikes.map(v => createPillButton('dislikes', v, 'dislikes')).join('');
            
            // Diet (max 5)
            document.getElementById('dietOptions').innerHTML = diet.map(v => createPillButton('diet', v, 'diet', 5)).join('');
            
            // Show More button for diet
            const showMoreBtn = document.getElementById('dietShowMore');
            showMoreBtn.classList.remove('hidden');
            showMoreBtn.textContent = 'Show More';
            showMoreBtn.onclick = showMoreDiet;
            
            // Allergy
            document.getElementById('allergyOptions').innerHTML = allergy.map(v => createPillButton('allergy', v, 'allergy')).join('');
}

        // Store extra diet selections (from "Show More" section) persistently
        let savedExtraDietSelections = [];

        // Show more diet options
        function showMoreDiet() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            const dietMore = type === 'cat' ? catDietMore : dogDietMore;
            
            const dietContainer = document.getElementById('dietOptions');
            const showMoreBtn = document.getElementById('dietShowMore');
            
            if (!dietExpanded) {
                // Save currently selected values before adding more options
                const currentlySelected = Array.from(dietContainer.querySelectorAll('.pill-checkbox:checked')).map(cb => cb.dataset.value || cb.value);
                
                // Add more options
                dietContainer.innerHTML += dietMore.map(v => createPillButton('diet', v, 'diet', 5)).join('');
                
                // Restore previously selected values in the new options (including saved extra selections)
                const allSelected = [...currentlySelected, ...savedExtraDietSelections];
                const newCheckboxes = dietContainer.querySelectorAll('.pill-checkbox');
                newCheckboxes.forEach(cb => {
                    if (currentlySelected.includes(cb.dataset.value) || savedExtraDietSelections.includes(cb.dataset.value)) {
                        cb.checked = true;
                        const label = document.getElementById(`${cb.id}_label`);
                        if (label) {
                            label.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600');
                            label.classList.remove('border-gray-300', 'text-gray-700');
                        }
                    }
                });
                
                // Update Show More button state based on selection count
                updateDietShowMoreButton();
                
                showMoreBtn.textContent = 'Show Less';
                dietExpanded = true;
            } else {
                // Save extra selections (from "more" section) before collapsing
                const originalDiet = type === 'cat' ? catDiet : dogDiet;
                savedExtraDietSelections = Array.from(dietContainer.querySelectorAll('.pill-checkbox:checked'))
                    .map(cb => cb.dataset.value || cb.value)
                    .filter(val => !originalDiet.includes(val));
                
                // Uncheck and remove options not in original
                document.querySelectorAll('#dietOptions .pill-checkbox').forEach(cb => {
                    if (!originalDiet.includes(cb.dataset.value)) {
                        const label = document.getElementById(`${cb.id}_label`);
                        label.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-600', 'opacity-50', 'cursor-not-allowed');
                        label.classList.add('border-gray-300', 'text-gray-700');
                        cb.checked = false;
                        cb.parentElement.remove();
                    }
                });
                
                // Re-enable Show More button when collapsed (since user can change selections)
                showMoreBtn.disabled = false;
                showMoreBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                showMoreBtn.textContent = 'Show More';
                dietExpanded = false;
            }
}

        
// Update Show More button state based on current diet selection count
        function updateDietShowMoreButton() {
            const showMoreBtn = document.getElementById('dietShowMore');
            if (!showMoreBtn) return;
            
            const checkedCount = document.querySelectorAll('#dietOptions .pill-checkbox:checked').length;
            
            if (checkedCount >= 5) {
                showMoreBtn.disabled = true;
                showMoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                showMoreBtn.disabled = false;
                showMoreBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        document.querySelectorAll('input[name="pet_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                updateBreedOptions();
                populateVaccinationHistory();
                populatePetAttributes();
            });
        });

        populateVaccinationHistory();

        // Sync vaccination mutual-exclusion state (also restores old() state on load)
        syncVaccinationUI();

        // Initialise the structured age selectors (years / months)
        initAgeSelectors();

        // Populate the structured age selectors (years / months)
        function initAgeSelectors() {
            const years = document.getElementById('petAgeYears');
            const months = document.getElementById('petAgeMonths');
            if (!years || !months) return;

            let yearsHtml = '<option value="">Select years</option>';
            for (let i = 0; i <= 30; i++) {
                yearsHtml += `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`;
            }
            years.innerHTML = yearsHtml;

            let monthsHtml = '<option value="">Select months</option>';
            for (let i = 0; i <= 11; i++) {
                monthsHtml += `<option value="${i}">${i} ${i === 1 ? 'month' : 'months'}</option>`;
            }
            months.innerHTML = monthsHtml;

            years.addEventListener('change', validateAgeRealTime);
            months.addEventListener('change', validateAgeRealTime);
            
            // Set initial months dropdown label
            updateMonthsDropdownLabel();
        }

        // Hide the age hint once the user picks a value
        function clearAgeHint() {
            validateAgeRealTime();
        }

        // Build the readable age string from the two selectors
        function readAgeSelection() {
            const years = document.getElementById('petAgeYears');
            const months = document.getElementById('petAgeMonths');
            const parts = [];

            if (years && years.value !== '') {
                const y = parseInt(years.value, 10);
                parts.push(`${y} ${y === 1 ? 'year' : 'years'}`);
            }
            if (months && months.value !== '') {
                const m = parseInt(months.value, 10);
                parts.push(`${m} ${m === 1 ? 'month' : 'months'}`);
            }

            return parts.join(' ');
}

// True when neither age selector has a meaningful value (both empty or both zero)
        function isAgeEmpty() {
            const years = document.getElementById('petAgeYears');
            const months = document.getElementById('petAgeMonths');
            const yearsVal = years ? years.value : '';
            const monthsVal = months ? months.value : '';

            const emptyYears = !yearsVal || yearsVal === '' || yearsVal === '0';
            const emptyMonths = !monthsVal || monthsVal === '' || monthsVal === '0';

            return emptyYears && emptyMonths;
        }

        // Validate age in real-time and show/hide hint instantly
        function validateAgeRealTime() {
            if (isAgeEmpty()) {
                showAgeHint();
            } else {
                document.getElementById('ageHint').classList.add('hidden');
            }

            // Update months dropdown label based on years selection
            updateMonthsDropdownLabel();
        }

        // Update months dropdown label based on selected years
        function updateMonthsDropdownLabel() {
            const years = document.getElementById('petAgeYears');
            const months = document.getElementById('petAgeMonths');
            if (!years || !months) return;

            const yearsVal = years.value;
            const firstOption = months.querySelector('option[value="0"]');
            if (firstOption) {
                if (yearsVal === '0') {
                    firstOption.textContent = '< 1 Month';
                } else {
                    firstOption.textContent = '0 months';
                }
            }
        }

        // Show the age hint (used by step validation)
        function showAgeHint() {
            document.getElementById('ageHint').classList.remove('hidden');
        }

        // Reset the age selectors back to their placeholder state
        function resetAgeSelectors() {
            const years = document.getElementById('petAgeYears');
            const months = document.getElementById('petAgeMonths');
            if (years) years.value = '';
            if (months) months.value = '';
            document.getElementById('ageHint').classList.add('hidden');
        }

        // Toggle the birthdate / age block based on the Yes / No answer
        function toggleBirthdate() {
            const selected = document.querySelector('input[name="know_birthdate"]:checked');
            const wrap = document.getElementById('ageOrBirthdateWrap');
            const birthdateSection = document.getElementById('birthdateSection');
            const ageSection = document.getElementById('ageSection');
            const birthdateInput = document.getElementById('petBirthdate');

            // Nothing selected yet -> hide the whole block
            if (!selected) {
                wrap.classList.add('hidden');
                birthdateSection.classList.add('hidden');
                ageSection.classList.add('hidden');
                if (birthdateInput) {
                    birthdateInput.value = '';
                    birthdateInput.removeAttribute('required');
                }
                resetAgeSelectors();
                return;
            }

            wrap.classList.remove('hidden');
            resetAgeSelectors();

            if (selected.value === 'yes') {
                // Birthdate mode
                birthdateSection.classList.remove('hidden');
                ageSection.classList.add('hidden');
                if (birthdateInput) birthdateInput.setAttribute('required', 'required');
            } else {
                // Age mode
                birthdateSection.classList.add('hidden');
                ageSection.classList.remove('hidden');
                if (birthdateInput) {
                    birthdateInput.value = '';
                    birthdateInput.removeAttribute('required');
                }
            }
        }

        // Enable / disable the weight field via the "Weight unknown" checkbox
        function toggleWeightUnknown() {
            const checkbox = document.getElementById('weightUnknown');
            const input = document.getElementById('petWeight');
            if (!checkbox || !input) return;

            if (checkbox.checked) {
                input.value = '';
                input.dataset.weightUnknown = 'true';
                input.setAttribute('readonly', 'readonly');
                input.removeAttribute('required');
                input.classList.add('bg-slate-100', 'text-gray-400', 'cursor-not-allowed');
                input.placeholder = 'Weight unknown';
            } else {
                input.value = '';
                delete input.dataset.weightUnknown;
                input.removeAttribute('readonly');
                input.setAttribute('required', 'required');
                input.classList.remove('bg-slate-100', 'text-gray-400', 'cursor-not-allowed');
                input.placeholder = 'Enter weight in kilograms';
            }

            updateWeightSuffix();
        }

        // Update weight suffix based on input
        function updateWeightSuffix() {
            const input = document.getElementById('petWeight');
            const suffix = document.getElementById('weightSuffix');
            const isUnknown = input.dataset.weightUnknown === 'true';
            const value = input.value.trim();

            // Show kg suffix if there's a valid number, hide if empty or unknown
            if (value === '' || isUnknown) {
                suffix.classList.add('hidden');
            } else {
                suffix.classList.remove('hidden');
            }
        }
        
        // Validate weight input - numbers and decimals, max 6 characters
        function validateWeight(input) {
            // Skip validation if weight is marked as unknown
            if (input.dataset.weightUnknown === 'true') {
                return;
            }
            input.value = input.value.replace(/[^0-9.]/g, '');
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
        }

        // Show error toast
        function showErrorToast(message) {
            // Remove existing toast if any
            const existing = document.getElementById('errorToast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'errorToast';
            toast.className = 'fixed bottom-4 right-4 bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-slide-up';
            toast.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        // Preview uploaded profile image
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            try {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('petImagePreview');
                    const placeholder = document.getElementById('petImagePlaceholder');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.onerror = function() {
                    showErrorToast('Failed to read image file. Please try another file.');
                };
                reader.readAsDataURL(file);
            } catch (err) {
                showErrorToast('Failed to process image. Please try again.');
            }
        }

        // Preview uploaded additional photo
        function previewImageForAdditional(input, previewId) {
            const file = input.files[0];
            if (!file) return;

            try {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    const removeBtn = document.getElementById(previewId.replace('Preview', 'RemoveBtn'));
                    if (removeBtn) removeBtn.classList.remove('hidden');
                    const uploadBtn = document.getElementById(previewId.replace('Preview', 'UploadBtn'));
                    if (uploadBtn) uploadBtn.classList.add('hidden');
                };
                reader.onerror = function() {
                    showErrorToast('Failed to read image file. Please try another file.');
                };
                reader.readAsDataURL(file);
            } catch (err) {
                showErrorToast('Failed to process image. Please try again.');
            }
        }

        // Remove uploaded photo
        function removePhoto(view) {
            const previewId = view + 'Preview';
            const inputId = view + 'Image';
            const removeBtnId = view + 'RemoveBtn';
            const uploadBtnId = view + 'UploadBtn';

            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            document.getElementById(inputId).value = '';
            const removeBtn = document.getElementById(removeBtnId);
            if (removeBtn) removeBtn.classList.add('hidden');
            const uploadBtn = document.getElementById(uploadBtnId);
            if (uploadBtn) uploadBtn.classList.remove('hidden');
        }

        // ============================================
        // MULTI-STEP FORM LOGIC
        // ============================================
        const stepTitles = ['Pet Basics', 'Physical Details & Photos', 'Health & Traits', 'Review & Submit'];
        const totalSteps = 4;
        let currentStep = 1;

        // Eye color "Other" text box toggle + heterochromia dropdowns
        function handleEyeColorChange() {
            const selected = document.querySelector('input[name="eye_color"]:checked');
            const wrap = document.getElementById('eyeColorOtherWrap');
            const input = document.getElementById('eyeColorOther');
            const heteroWrap = document.getElementById('eyeColorHeterochromiaWrap');

            if (!wrap || !input) return;

            const selectedValue = selected ? selected.value : '';

            // "Other" custom text field
            if (selectedValue === 'Other') {
                wrap.classList.remove('hidden');
                input.setAttribute('required', 'required');
            } else {
                wrap.classList.add('hidden');
                input.removeAttribute('required');
                input.value = '';
            }

            // "Heterochromia" -> left / right eye color dropdowns
            if (heteroWrap) {
                if (selectedValue === 'Heterochromia (Two different colors)') {
                    heteroWrap.classList.remove('hidden');
                    setEyeSideRequired('Left', true);
                    setEyeSideRequired('Right', true);
                } else {
                    heteroWrap.classList.add('hidden');
                    resetEyeSide('Left');
                    resetEyeSide('Right');
                }
            }
        }

        // Toggle the custom text field for one eye side
        function handleEyeSideChange(side) {
            const select = document.getElementById('eyeColor' + side);
            const wrap = document.getElementById('eyeColor' + side + 'OtherWrap');
            const input = document.getElementById('eyeColor' + side + 'Other');
            if (!select || !wrap || !input) return;

            if (select.value === 'Other') {
                wrap.classList.remove('hidden');
                input.setAttribute('required', 'required');
            } else {
                wrap.classList.add('hidden');
                input.removeAttribute('required');
                input.value = '';
            }
        }

        // Require / unrequire one eye side dropdown
        function setEyeSideRequired(side, required) {
            const select = document.getElementById('eyeColor' + side);
            if (!select) return;

            if (required) {
                select.setAttribute('required', 'required');
            } else {
                select.removeAttribute('required');
                resetEyeSide(side);
            }
        }

        // Clear one eye side back to its default state
        function resetEyeSide(side) {
            const select = document.getElementById('eyeColor' + side);
            const wrap = document.getElementById('eyeColor' + side + 'OtherWrap');
            const input = document.getElementById('eyeColor' + side + 'Other');

            if (select) {
                select.value = '';
                select.removeAttribute('required');
            }
            if (wrap) wrap.classList.add('hidden');
            if (input) {
                input.removeAttribute('required');
                input.value = '';
            }
        }

        // Read back one eye side value for the review summary
        function readEyeSide(side) {
            const select = document.getElementById('eyeColor' + side);
            const input = document.getElementById('eyeColor' + side + 'Other');

            if (!select || select.value === '') return '';
            if (select.value === 'Other' && input && input.value.trim() !== '') {
                return input.value.trim();
            }
            return select.value;
        }

        // Update the step indicator + progress bar
        const checkIcon = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`;

        function updateStepIndicator() {
            const stateClasses = ['bg-emerald-600', 'border-emerald-600', 'text-white', 'ring-2', 'ring-emerald-300', 'ring-offset-1', 'bg-emerald-100', 'text-emerald-700', 'bg-white', 'border-slate-300', 'text-slate-400'];
            const titleClasses = ['text-emerald-700', 'text-slate-500', 'font-bold', 'text-emerald-900'];

            document.querySelectorAll('.step-item').forEach(item => {
                const circle = item.querySelector('.step-circle');
                const title = item.querySelector('.step-title');
                const subtitle = item.querySelector('.step-subtitle');
                const step = parseInt((circle && circle.dataset.step) || item.dataset.step, 10);

                circle.classList.remove(...stateClasses);
                title.classList.remove(...titleClasses);
                if (subtitle) subtitle.classList.remove('text-emerald-600', 'text-slate-400');

                if (step === currentStep) {
                    // CURRENT STEP — strongly highlighted
                    circle.classList.add('bg-emerald-600', 'border-emerald-600', 'text-white', 'ring-2', 'ring-emerald-300', 'ring-offset-1');
                    circle.innerHTML = String(step);
                    title.classList.add('text-emerald-900', 'font-bold');
                    if (subtitle) subtitle.classList.add('text-emerald-600');
                } else if (step < currentStep) {
                    // COMPLETED STEP — light green with check mark
                    circle.classList.add('bg-emerald-100', 'border-emerald-600', 'text-emerald-700');
                    circle.innerHTML = checkIcon;
                    title.classList.add('text-emerald-700');
                    if (subtitle) subtitle.classList.add('text-slate-400');
                } else {
                    // UPCOMING STEP — muted outline
                    circle.classList.add('bg-white', 'border-slate-300', 'text-slate-400');
                    circle.innerHTML = String(step);
                    title.classList.add('text-slate-500');
                    if (subtitle) subtitle.classList.add('text-slate-400');
                }
            });

            const bar = document.getElementById('progressBar');
            if (bar) {
                bar.style.width = ((currentStep / totalSteps) * 100) + '%';
            }

            const indicatorText = document.getElementById('stepIndicatorText');
            if (indicatorText) {
                indicatorText.textContent = `Step ${currentStep} of ${totalSteps} — ${stepTitles[currentStep - 1]}`;
            }
        }

        // Show a specific step pane
        function showStep(step) {
            for (let i = 1; i <= totalSteps; i++) {
                const pane = document.getElementById('step-' + i);
                if (!pane) continue;
                if (i === step) {
                    pane.classList.remove('hidden');
                } else {
                    pane.classList.add('hidden');
                }
            }

            currentStep = step;
            updateStepIndicator();

            if (step === totalSteps) {
                populateReview();
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Validate required fields that live inside the visible step pane
        function validateStep(step) {
            const pane = document.getElementById('step-' + step);
            if (!pane) return true;

            let isValid = true;
            let firstInvalid = null;

            pane.querySelectorAll('input, textarea, select').forEach(el => {
                if (!el.required) return;
                if (el.type === 'hidden') return;

                let valid = true;

                if (el.type === 'radio') {
                    const group = pane.querySelectorAll(`input[name="${el.name}"]`);
                    valid = Array.from(group).some(r => r.checked);
                } else if (el.type === 'checkbox') {
                    valid = true;
                } else if (el.type === 'file') {
                    valid = el.files && el.files.length > 0;
                } else {
                    valid = el.value.trim() !== '';
                }

                if (!valid) {
                    isValid = false;
                    if (!firstInvalid) firstInvalid = el;
                }
            });

            // Breed is stored in a hidden input, so validate it separately
            if (step === 1) {
                const breedInput = document.getElementById('petBreedInput');
                if (breedInput && breedInput.value.trim() === '') {
                    isValid = false;
                    if (!firstInvalid) firstInvalid = null;
                    const breedDisplay = document.getElementById('breedDisplay');
                    if (breedDisplay) breedDisplay.classList.add('ring-2', 'ring-red-400', 'border-red-400');
                }
            }

            // Age requires at least one of years / months when "No" is chosen
            if (step === 2) {
                const knowBirthdateNo = document.querySelector('input[name="know_birthdate"][value="no"]:checked');
                if (knowBirthdateNo && isAgeEmpty()) {
                    const wrap = document.getElementById('ageOrBirthdateWrap');
                    if (wrap && !wrap.classList.contains('hidden')) {
                        isValid = false;
                        showAgeHint();
                    }
                }
            }

            if (!isValid) {
                alert('Please fill in all required fields marked with * before continuing.');
                if (firstInvalid && firstInvalid.type !== 'hidden') {
                    try { firstInvalid.focus(); } catch (e) {}
                }
            }

            return isValid;
        }

        // Navigate relative to the current step
        function changeStep(delta) {
            const target = currentStep + delta;
            if (target < 1 || target > totalSteps) return;
            if (delta > 0 && !validateStep(currentStep)) return;
            showStep(target);
        }

        // Jump to a specific step (used by the progress indicator)
        function goToStep(step) {
            if (step < 1 || step > totalSteps) return;
            if (step === currentStep) return;
            if (step > currentStep) {
                // Only allow jumping forward after every intervening step validates
                for (let i = currentStep; i < step; i++) {
                    if (!validateStep(i)) return;
                }
            }
            showStep(step);
        }

        // Helper: Check if Anti-Rabies booster is needed (more than 1 year since last vaccination)
        function getAntiRabiesBoosterStatus(dateString) {
            if (!dateString) return null;
            const adminDate = new Date(dateString + 'T00:00:00');
            const oneYearAgo = new Date();
            oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
            return adminDate < oneYearAgo
                ? '<div class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm"><strong>⚠ Needs an Anti-Rabies Booster Shot</strong> (more than 1 year since last vaccination)</div>'
                : null;
        }

        // Build the Step 4 review summary
        function populateReview() {
            const form = document.getElementById('petRegistrationForm');
            if (!form) return;

            const esc = (value) => String(value ?? '').replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));

            const row = (label, value) => `
                <div class="grid grid-cols-[120px_1fr] gap-4 py-2">
                    <span class="text-sm text-gray-700">${label}</span>
                    <span class="text-sm font-semibold text-gray-900">${esc(value || '—')}</span>
                </div>`;

            const rowHtml = (label, value) => `
                <span class="text-sm text-gray-700 py-2">${label}</span>
                <span class="text-sm font-semibold text-gray-900 py-2">${value || '—'}</span>`;

            const traitRow = (label, containerId) => {
                const container = document.getElementById(containerId);
                if (!container) return `
                    <span class="text-sm text-gray-700 py-2">${label}</span>
                    <span class="text-sm font-semibold text-gray-900 py-2">—</span>`;
                const selected = Array.from(container.querySelectorAll('input.pill-checkbox:checked')).map(cb => cb.dataset.value || cb.value);
                return `
                <span class="text-sm text-gray-700 py-2">${label}</span>
                <span class="text-sm font-semibold text-gray-900 py-2">${selected.length ? selected.join(', ') : '—'}</span>`;
            };

            const asText = (value) => {
                if (value === undefined || value === null || value === '') return '';
                if (Array.isArray(value)) return value.length ? value.join(', ') : '';
                if (typeof value === 'object') return Object.values(value).filter(v => v !== '' && v !== null && v !== undefined);
                return String(value);
            };

            const selectedPills = (containerId) => {
                const container = document.getElementById(containerId);
                if (!container) return [];
                return Array.from(container.querySelectorAll('input.pill-checkbox:checked')).map(cb => cb.dataset.value || cb.value);
            };

            // --- Pet Basics ---
            const petTypeInput = form.querySelector('input[name="pet_type"]:checked');
            const genderInput = form.querySelector('input[name="gender"]:checked');
            const neuteredInput = form.querySelector('input[name="is_neutered"]:checked');
            const crossbreedInput = form.querySelector('input[name="is_crossbreed"]:checked');
            const species = petTypeInput ? petTypeInput.value : '';
            const breed = document.getElementById('petBreedInput') ? document.getElementById('petBreedInput').value : '';

            document.getElementById('reviewBasics').innerHTML =
                row('Pet Name', form.pet_name ? form.pet_name.value : '') +
                row('Species', species ? species.charAt(0).toUpperCase() + species.slice(1) : '') +
                row('Gender', genderInput ? genderInput.value.charAt(0).toUpperCase() + genderInput.value.slice(1) : '') +
                row('Spayed / Neutered', neuteredInput ? (neuteredInput.value === 'yes' ? 'Yes' : 'No') : '') +
                row('Breed', breed) +
                row('Crossbreed', crossbreedInput ? (crossbreedInput.value === 'yes' ? 'Yes' : 'No') : '');

            // --- Physical Details & Photos ---
            const knowBirthdateInput = form.querySelector('input[name="know_birthdate"]:checked');
            const birthdate = document.getElementById('petBirthdate');
            const weight = document.getElementById('petWeight');
            const weightUnknown = document.getElementById('weightUnknown');
            const eyeColorInput = form.querySelector('input[name="eye_color"]:checked');
            const eyeColorOther = document.getElementById('eyeColorOther');
            const bodyMarkDetails = document.getElementById('bodyMarkDetails');

            let eyeColor = eyeColorInput ? eyeColorInput.value : '';
            if (eyeColor === 'Other' && eyeColorOther && eyeColorOther.value.trim() !== '') {
                eyeColor = eyeColorOther.value.trim();
            } else if (eyeColor === 'Heterochromia (Two different colors)') {
                const leftEye = readEyeSide('Left');
                const rightEye = readEyeSide('Right');
                eyeColor = 'Heterochromia — Left: ' + (leftEye || 'N/A') + ', Right: ' + (rightEye || 'N/A');
            }

            let ageOrBirthdate = '';
            if (knowBirthdateInput && knowBirthdateInput.value === 'yes' && birthdate && birthdate.value) {
                const parsed = new Date(birthdate.value + 'T00:00:00');
                ageOrBirthdate = parsed.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            } else {
                const ageSelection = readAgeSelection();
                if (ageSelection !== '') ageOrBirthdate = ageSelection;
            }

            let weightDisplay = '';
            if (weightUnknown && weightUnknown.checked) {
                weightDisplay = 'Unknown';
            } else if (weight && weight.value.trim() !== '') {
                weightDisplay = weight.value.trim() + ' kg';
            }

            document.getElementById('reviewPhysicalRows').innerHTML =
                row('Birthdate / Age', ageOrBirthdate) +
                row('Weight', weightDisplay) +
                row('Eye Color', eyeColor) +
                row('Body Mark Details', bodyMarkDetails ? bodyMarkDetails.value : '');

            const images = [
                { id: 'petImagePreview', label: 'Profile' },
                { id: 'bodyMarkPreview', label: 'Body Mark' },
                { id: 'frontPreview', label: 'Front View' },
                { id: 'sidePreview', label: 'Side View' },
                { id: 'topPreview', label: 'Top-Down' }
            ];

            const imagesHtml = images.map(img => {
                const el = document.getElementById(img.id);
                const src = el ? (el.getAttribute('src') || '') : '';
                const hasUpload = !!src;

                if (!hasUpload) return '';

                return `
                <div class="text-center">
                    <img src="${esc(src)}" alt="${img.label}" class="w-20 h-20 ${img.id === 'petImagePreview' ? 'rounded-full' : 'rounded-xl'} object-cover border-2 border-emerald-400 mx-auto">
                    <span class="block text-xs text-gray-700 mt-1">${img.label}</span>
                    <span class="block text-xs text-emerald-600">Uploaded</span>
                </div>`;
            }).join('');

            document.getElementById('reviewPhysicalImages').innerHTML = imagesHtml;

            // --- Health & Traits ---
            const notVaccinatedCheckbox = document.querySelector('input[name="not_vaccinated"]');
            const notVaccinated = notVaccinatedCheckbox && notVaccinatedCheckbox.checked;

            let vaccinesHtml = '';
            const vaccineItems = [];

            const bullet = (text, color = 'emerald') =>
                `<span class="inline-flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-${color}-600"></span>${text}</span>`;

            // Anti-Rabies is hardcoded in HTML (outside #otherCoreVaccines)
            const antiRabiesChecked = document.querySelector('input[name="vaccination_core[]"][value="Anti-Rabies"]');

            if (notVaccinated) {
                vaccinesHtml = '<span class="text-gray-700 italic">Not vaccinated / records unavailable</span>';
            } else {
                // Only the JS-rendered core options (Anti-Rabies lives outside this container)
                const coreVaccines = Array.from(document.querySelectorAll('#otherCoreVaccines input[type="checkbox"]:checked')).map(cb => cb.value);
                const optionalVaccines = Array.from(document.querySelectorAll('#optionalVaccineOptions input[type="checkbox"]:checked')).map(cb => cb.value);

                // Flat "Other" text inputs wired to the vaccination checkboxes
                const coreOtherInput = document.querySelector('input[name="vaccination_core_other"]');
                const optionalOtherInput = document.querySelector('input[name="vaccination_optional_other"]');

                const otherText = (input) => {
                    const typed = input && input.value.trim() !== '' ? input.value.trim() : 'Other';
                    return esc(typed);
                };

                if (antiRabiesChecked && antiRabiesChecked.checked) {
                    vaccineItems.push(bullet('Anti-Rabies Vaccination'));
                }
                coreVaccines.forEach(v => vaccineItems.push(bullet(v === 'Other' ? otherText(coreOtherInput) : v)));
                optionalVaccines.forEach(v => vaccineItems.push(bullet(v === 'Other' ? otherText(optionalOtherInput) : v, 'amber')));

                vaccinesHtml = vaccineItems.length > 0
                    ? `<div class="flex flex-wrap gap-2">${vaccineItems.join('')}</div>`
                    : '<span class="text-gray-700 italic">No vaccines selected</span>';
            }

            const dateInput = document.querySelector('input[name="anti_rabies[date_administered]"]');
            const lotInput = document.querySelector('input[name="anti_rabies[lot_no]"]');
            const tagInput = document.querySelector('input[name="anti_rabies[tag_no]"]');

            let antiRabiesHtml = '';
            let boosterHtml = '';

            if (antiRabiesChecked && antiRabiesChecked.checked) {
                const dateVal = dateInput && dateInput.value ? new Date(dateInput.value + 'T00:00:00').toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '—';
                const lotVal = lotInput && lotInput.value.trim() !== '' ? lotInput.value.trim() : '—';
                const tagVal = tagInput && tagInput.value.trim() !== '' ? tagInput.value.trim() : '—';

                antiRabiesHtml = `
                    <div class="mt-2 space-y-1 text-sm">
                        <div><span class="text-gray-700">Date Administered:</span> <span class="font-semibold text-gray-900">${dateVal}</span></div>
                        <div><span class="text-gray-700">Vaccine Lot No.:</span> <span class="font-semibold text-gray-900">${lotVal}</span></div>
                        <div><span class="text-gray-700">Tag / Sticker No.:</span> <span class="font-semibold text-gray-900">${tagVal}</span></div>
                    </div>
                `;

                // Check if Anti-Rabies booster is needed using helper
                boosterHtml = getAntiRabiesBoosterStatus(dateInput?.value) || '';
            }

            let vaccinationCardHtml = '';
            const vaccinationCardPreview = document.getElementById('vaccinationCardPreview');
            const hasVaccinationCard = !!(vaccinationCardPreview && vaccinationCardPreview.getAttribute('src'));
            if (hasVaccinationCard) {
                vaccinationCardHtml = `<div class="mt-2"><img src="${vaccinationCardPreview.src}" alt="Vaccination Card" class="w-32 h-24 object-cover rounded-lg border border-slate-200"></div>`;
            }

            const notVaccinatedHtml = notVaccinated ? '<span style="color: #111827; font-weight: 600;">My pet is not yet vaccinated / records unavailable</span>' : '';

            // Determine vaccination status (date-aware) and booster warning
            let vaccinationStatusHtml;
            if (notVaccinated) {
                vaccinationStatusHtml = notVaccinatedHtml;
            } else if (boosterHtml) {
                vaccinationStatusHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold bg-amber-100 text-amber-800">Vaccinated (Needs a Booster Shot)</span>' + boosterHtml;
            } else if (antiRabiesChecked && antiRabiesChecked.checked && dateInput && dateInput.value) {
                vaccinationStatusHtml = '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">Vaccinated (Up to Date)</span>';
            } else {
                vaccinationStatusHtml = 'Vaccinated';
            }

            document.getElementById('reviewHealth').innerHTML =
                rowHtml('Vaccination Status', vaccinationStatusHtml) +
                (!notVaccinated ? rowHtml('Anti-Rabies Vaccination Details', antiRabiesHtml) : '') +
                (!notVaccinated ? rowHtml('Core & Optional Vaccines', vaccinesHtml) : '') +
                (vaccinationCardHtml ? rowHtml('Vaccination Booklet / Certificate', vaccinationCardHtml) : '') +
                '<hr class="col-span-2 my-4 border-slate-200">' +
                '<div class="col-span-2 text-sm font-bold text-gray-800 uppercase tracking-wider">Traits</div>' +
                traitRow('Training', 'trainingOptions') +
                traitRow('Insurance', 'insuranceOptions') +
                traitRow('Behavior', 'behaviorOptions') +
                traitRow('Likes', 'likesOptions') +
                traitRow('Dislikes', 'dislikesOptions') +
                traitRow('Diet', 'dietOptions') +
                traitRow('Allergy', 'allergyOptions');
        }

        // Toggle vaccination fields when "not vaccinated" is checked
        function toggleVaccinationFields(checkbox) {
            const notVaccinated = checkbox.checked;
            const fieldsToToggle = [
                'coreVaccinesSection',
                'optionalVaccinesSection',
                'vaccinationCardPreview',
                'vaccinationCardUploadSection'
            ];

            fieldsToToggle.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (notVaccinated) {
                        el.classList.add('hidden');
                        // Clear inputs
                        el.querySelectorAll('input, select').forEach(input => {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                input.checked = false;
                            } else {
                                input.value = '';
                            }
                        });
                        // Remove required attributes
                        el.querySelectorAll('[required]').forEach(input => {
                            input.removeAttribute('required');
                        });
                    } else {
                        el.classList.remove('hidden');
                    }
                }
            });

            // Use single source of truth for mutual exclusion
            syncVaccinationUI();
        }

// Single source of truth for vaccination mutual exclusion state
        function syncVaccinationUI() {
            const notVaccinatedCheckbox = document.getElementById('notVaccinatedCheckbox');
            const antiRabiesCheckbox = document.getElementById('antiRabiesCheckbox');
            const antiRabiesFields = document.getElementById('antiRabiesFields');
            const dateInput = document.querySelector('input[name="anti_rabies[date_administered]"]');
            
            if (!notVaccinatedCheckbox || !antiRabiesCheckbox || !antiRabiesFields) return;

            const notVaccinated = notVaccinatedCheckbox.checked;
            const antiRabiesChecked = antiRabiesCheckbox.checked;

            // Gray out the label text of whichever option is mutually excluded
            const setDisabledLabel = (labelId, disabled) => {
                const label = document.getElementById(labelId);
                if (!label) return;
                label.classList.toggle('text-gray-400', disabled);
                label.classList.toggle('text-gray-700', !disabled);
            };

            if (notVaccinated) {
                // Not vaccinated is checked - disable Anti-Rabies
                antiRabiesCheckbox.checked = false;
                antiRabiesCheckbox.disabled = true;
                antiRabiesFields.classList.add('hidden');
                antiRabiesFields.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    input.removeAttribute('required');
                });
                if (dateInput) dateInput.removeAttribute('required');
                setDisabledLabel('antiRabiesLabel', true);
                setDisabledLabel('notVaccinatedLabel', false);
            } else if (antiRabiesChecked) {
                // Anti-Rabies is checked - disable Not Vaccinated
                notVaccinatedCheckbox.disabled = true;
                notVaccinatedCheckbox.checked = false;
                antiRabiesFields.classList.remove('hidden');
                if (dateInput) dateInput.setAttribute('required', 'required');
                setDisabledLabel('notVaccinatedLabel', true);
                setDisabledLabel('antiRabiesLabel', false);
            } else {
                // Neither checked - enable both
                notVaccinatedCheckbox.disabled = false;
                antiRabiesCheckbox.disabled = false;
                antiRabiesFields.classList.add('hidden');
                antiRabiesFields.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    input.removeAttribute('required');
                });
                if (dateInput) dateInput.removeAttribute('required');
                setDisabledLabel('notVaccinatedLabel', false);
                setDisabledLabel('antiRabiesLabel', false);
            }
        }

        // Toggle "Not Vaccinated" checkbox - mutual exclusion with Anti-Rabies
        function toggleNotVaccinated(checkbox) {
            syncVaccinationUI();
        }

        // Toggle Anti-Rabies sub-fields when checkbox is checked/unchecked
        function toggleAntiRabiesFields(checkbox) {
            syncVaccinationUI();
        }

            // Preview vaccination card
            function previewVaccinationCard(event) {
                const file = event.target.files[0];
                if (!file) return;

                try {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Show preview image
                        const preview = document.getElementById('vaccinationCardPreview');
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        // Show remove button
                        document.getElementById('vaccinationCardRemoveBtn').classList.remove('hidden');

                        // Hide the click-to-upload overlay
                        const uploadBtn = document.getElementById('vaccinationCardUploadBtn');
                        if (uploadBtn) uploadBtn.classList.add('hidden');
                    };
                    reader.onerror = function() {
                        showErrorToast('Failed to read image file. Please try another file.');
                    };
                    reader.readAsDataURL(file);
                } catch (err) {
                    showErrorToast('Failed to process image. Please try again.');
                }
            }

            // Remove vaccination card
            function removeVaccinationCard() {
                const input = document.getElementById('vaccinationCard');
                const removeBtn = document.getElementById('vaccinationCardRemoveBtn');

                input.value = '';

                // Hide preview image
                const preview = document.getElementById('vaccinationCardPreview');
                if (preview) {
                    preview.src = '';
                    preview.classList.add('hidden');
                }

                document.getElementById('vaccinationCardRemoveBtn').classList.add('hidden');

                // Show the click-to-upload overlay again
                const uploadBtn = document.getElementById('vaccinationCardUploadBtn');
                if (uploadBtn) uploadBtn.classList.remove('hidden');
            }

            // Initialise the stepper on page load
        updateStepIndicator();

        // Restore conditional UI state after a validation error round-trip (old() data)
        (function restoreOldInputState() {
            // Breed trigger text + internal selection state
            const breedInput = document.getElementById('petBreedInput');
            if (breedInput && breedInput.value.trim() !== '') {
                selectedBreeds = breedInput.value.split(',').map(b => b.trim()).filter(Boolean);
                updateSelectedBreedDisplay();
            }

            // Birthdate / age block
            toggleBirthdate();

            // Eye colour "Other" field + heterochromia sub-fields
            handleEyeColorChange();
            handleEyeSideChange('Left');
            handleEyeSideChange('Right');

            // Weight suffix
            updateWeightSuffix();
        })();
    </script>
    
    <!-- Breed Selector Modal -->
    <div id="breedModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="breedModalTitle">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeBreedModal()"></div>
        <div class="fixed inset-0 flex items-end sm:items-center sm:justify-center p-0 sm:p-4">
            <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
                <!-- Modal Header -->
                <div class="px-5 pt-5 pb-4 border-b border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <h3 id="breedModalTitle" class="text-lg font-semibold text-gray-900">Select Breed</h3>
                            <span id="breedModalLimit" class="text-sm text-slate-500 font-normal">(select one)</span>
                        </div>
                        <button type="button" onclick="closeBreedModal()" class="text-gray-400 hover:text-gray-600 hover:bg-slate-100 rounded-lg p-1.5 transition-colors" aria-label="Close breed selector">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Search bar (auto-focused on open) -->
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="breedModalSearch" placeholder="Search breed..." onkeyup="filterBreedModal()"
                               class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" autocomplete="off">
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto">
                    <div class="px-5 pt-4 pb-4">
                        <!-- Quick Selections -->
                        <div id="breedModalQuick" class="mb-5 hidden">
                            <p class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Popular / Quick Selections</p>
                            <div class="flex flex-wrap gap-2" id="breedModalQuickChips"></div>
                        </div>

                        <!-- Alphabetical List -->
                        <div id="breedModalList"></div>

                        <!-- Empty search state -->
                        <div id="breedModalEmpty" class="hidden text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-xs text-gray-700">No breeds match your search.</p>
                            <p class="text-sm text-gray-400 mt-1">Try "Other / Breed Not Listed" below.</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-5 py-4 border-t border-slate-200 bg-slate-50">
                    <button type="button" onclick="showOtherBreedInput()" class="w-full px-4 py-2.5 border-2 border-dashed border-emerald-300 text-emerald-700 rounded-lg font-medium hover:bg-emerald-50 hover:border-emerald-400 transition-colors flex items-center justify-center gap-2 text-sm" id="otherBreedBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Other / Breed Not Listed
                    </button>
                    <div id="otherBreedInputWrap" class="mt-3 hidden">
                        <div class="flex gap-2">
                            <input type="text" id="otherBreedInput" placeholder="Enter breed name" class="flex-1 px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all">
                            <button type="button" onclick="submitOtherBreed()" class="px-4 py-2.5 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition-colors">Add</button>
                            <button type="button" onclick="hideOtherBreedInput()" class="px-4 py-2.5 border border-slate-300 text-gray-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">Cancel</button>
                        </div>
                        <p class="text-xs text-gray-700 mt-1">Press Enter to add, Escape to cancel</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 id="confirmModalTitle" class="text-xl font-bold text-gray-900 mb-2">Confirm Registration</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to register this pet? Please review all information before submitting.</p>
                <div class="flex gap-4 justify-center">
                    <button onclick="closeConfirmModal()" class="px-6 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitPetForm()" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        Confirm & Register
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Anti-Rabies Vaccination Recommendation Modal (booster shot or first dose) -->
    <div id="vaccinationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="vaccinationModalTitle">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <h3 id="vaccinationModalTitle" class="text-xl font-bold text-gray-900 mb-2">Anti-Rabies Booster Shot Recommended</h3>
                <p id="vaccinationModalMessage" class="text-gray-600 mb-6"></p>
                <div class="flex flex-col gap-3">
                    <button type="button" id="vaccinationModalPrimaryBtn" onclick="bookVaccinationAppointment()" class="w-full px-6 py-2.5 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-colors">
                        Yes, Book Booster Appointment
                    </button>
                    <button type="button" onclick="submitPetForm(true)" class="w-full px-6 py-2.5 border border-slate-300 text-gray-700 rounded-lg font-semibold hover:bg-slate-50 transition-colors">
                        No, Just Submit Registration
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let confirmLastFocusedElement = null;
        let vaccinationLastFocusedElement = null;

        function showConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-modal', 'true');
            modal.setAttribute('role', 'dialog');
            
            // Store last focused element
            confirmLastFocusedElement = document.activeElement;
            
            // Focus first button
            setTimeout(() => {
                const firstBtn = modal.querySelector('button');
                if (firstBtn) firstBtn.focus();
                trapFocus(modal);
            }, 50);
        }
        
        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.removeAttribute('aria-modal');
            modal.removeAttribute('role');
            
            // Restore focus
            if (confirmLastFocusedElement && typeof confirmLastFocusedElement.focus === 'function') {
                confirmLastFocusedElement.focus();
            }
            confirmLastFocusedElement = null;
        }
        
        // Copy for both recommendation modes: overdue booster vs no vaccination on record
        const VACCINATION_MODAL_COPY = {
            booster: {
                title: 'Anti-Rabies Booster Shot Recommended',
                message: (petName) => `We noticed ${petName}'s Anti-Rabies vaccination is over 1 year old and due for a booster shot. Would you like to schedule a booster shot appointment with Veterinary Services now?`,
                primary: 'Yes, Book Booster Appointment'
            },
            firstDose: {
                title: 'Anti-Rabies Vaccination Recommended',
                message: (petName) => `We noticed ${petName} has no Anti-Rabies vaccination on record yet. Would you like to schedule a first Anti-Rabies vaccination appointment with Veterinary Services now?`,
                primary: 'Yes, Book Vaccination Appointment'
            }
        };

        // 'booster' (Anti-Rabies over 1 year), 'firstDose' (not yet vaccinated), or null
        function getVaccinationRecommendation() {
            const notVaccinated = document.querySelector('input[name="not_vaccinated"]');
            if (notVaccinated && notVaccinated.checked) return 'firstDose';

            const antiRabies = document.getElementById('antiRabiesCheckbox');
            if (antiRabies && antiRabies.checked) {
                const dateInput = document.querySelector('input[name="anti_rabies[date_administered]"]');
                // Same source of truth as the Step 4 review badge
                if (getAntiRabiesBoosterStatus(dateInput ? dateInput.value : null) !== null) return 'booster';
            }
            return null;
        }

        function submitPetForm(skipVaccinationPrompt = false) {
            const recommendation = skipVaccinationPrompt ? null : getVaccinationRecommendation();
            if (recommendation) {
                closeConfirmModal();
                openVaccinationModal(recommendation);
                return;
            }
            document.getElementById('petRegistrationForm').submit();
        }

        function openVaccinationModal(mode) {
            const modal = document.getElementById('vaccinationModal');
            if (!modal) return;

            const copy = VACCINATION_MODAL_COPY[mode] || VACCINATION_MODAL_COPY.booster;
            const petNameInput = document.getElementById('petRegistrationForm').pet_name;
            const petName = `<span class="font-semibold text-gray-900">${(petNameInput && petNameInput.value.trim()) || 'your pet'}</span>`;

            const titleEl = document.getElementById('vaccinationModalTitle');
            const messageEl = document.getElementById('vaccinationModalMessage');
            const primaryBtn = document.getElementById('vaccinationModalPrimaryBtn');
            if (titleEl) titleEl.textContent = copy.title;
            if (messageEl) messageEl.innerHTML = copy.message(petName);
            if (primaryBtn) primaryBtn.textContent = copy.primary;

            modal.classList.remove('hidden');
            modal.setAttribute('aria-modal', 'true');
            modal.setAttribute('role', 'dialog');

            vaccinationLastFocusedElement = document.activeElement;
            setTimeout(() => {
                const firstBtn = modal.querySelector('button');
                if (firstBtn) firstBtn.focus();
                trapFocus(modal);
            }, 50);
        }

        function closeVaccinationModal() {
            const modal = document.getElementById('vaccinationModal');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.removeAttribute('aria-modal');
            modal.removeAttribute('role');

            if (vaccinationLastFocusedElement && typeof vaccinationLastFocusedElement.focus === 'function') {
                vaccinationLastFocusedElement.focus();
            }
            vaccinationLastFocusedElement = null;
        }

        function bookVaccinationAppointment() {
            document.getElementById('bookBoosterInput').value = '1';
            document.getElementById('petRegistrationForm').submit();
        }
    </script>
</body>
</html>

