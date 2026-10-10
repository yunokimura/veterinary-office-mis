<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration Form - Dasmariñas City Veterinary Services</title>
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
            background-color: #066D33;
            color: white;
        }

        input[type="checkbox"], input[type="radio"] {
            accent-color: #066D33;
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
            <p class="text-gray-500 text-sm mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
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
                        <span id="stepIndicatorText" class="text-xs text-emerald-300 font-medium">Step 1 of 4 — Pet Basics</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-2">
                            <button type="button" onclick="goToStep(1)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="1">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="1">1</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Pet Basics</span>
                                    <span class="step-subtitle block text-xs text-gray-500 truncate">Profile & breed</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(2)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="2">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="2">2</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Physical Details</span>
                                    <span class="step-subtitle block text-xs text-gray-500 truncate">Age & photos</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(3)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="3">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="3">3</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Health & Traits</span>
                                    <span class="step-subtitle block text-xs text-gray-500 truncate">Vaccines & behavior</span>
                                </span>
                            </button>
                            <div class="flex-1 hidden sm:flex items-center pt-4">
                                <div class="w-full h-0.5 bg-slate-200"></div>
                            </div>
                            <button type="button" onclick="goToStep(4)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="4">
                                <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors flex-shrink-0" data-step="4">4</span>
                                <span class="hidden sm:block min-w-0">
                                    <span class="step-title block text-sm font-semibold truncate">Review & Submit</span>
                                    <span class="step-subtitle block text-xs text-gray-500 truncate">Confirm details</span>
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
                                    <!-- Placeholder Image (Dog with Cat) -->
                                    <div class="shrink-0">
                                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-300 relative">
                                            <img id="petImagePreview" src="{{ asset('images/pet.png') }}" alt="Pet Profile" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all flex items-center justify-center cursor-pointer" onclick="document.getElementById('petImage').click()">
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
                                        <p class="text-xs text-gray-400">Click the image to upload</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pet Name -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Your Pet's Name <span class="text-red-500">*</span></label>
                                <input type="text" name="pet_name" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Enter your pet's name" required>
                            </div>

                            <!-- Pet Type -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">What kind of pet do you have? <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_type" value="dog" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required>
                                        <span class="ml-3 text-gray-700 font-medium">Dog</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_type" value="cat" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required>
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
                                            <input type="radio" name="gender" value="male" class="form-radio h-5 w-5 text-emerald-600" required>
                                            <span class="ml-3 text-gray-700 font-medium">Male</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender" value="female" class="form-radio h-5 w-5 text-emerald-600" required>
                                            <span class="ml-3 text-gray-700 font-medium">Female</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Spayed / Neutered -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Spayed / Neutered <span class="text-red-500">*</span></label>
                                    <div class="flex space-x-6">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_neutered" value="yes" class="form-radio h-5 w-5 text-emerald-600" required>
                                            <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_neutered" value="no" class="form-radio h-5 w-5 text-emerald-600" required>
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
                                        <input type="radio" name="is_crossbreed" value="yes" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleCrossbreed()" required>
                                        <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="is_crossbreed" value="no" class="form-radio h-5 w-5 text-emerald-600" onchange="toggleCrossbreed()" required>
                                        <span class="ml-3 text-gray-700 font-medium">No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Pet Breed -->
                            <div id="breedSection">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Pet Breed <span class="text-red-500">*</span>
                                    <span id="breedLimitText" class="text-xs text-gray-500 font-normal ml-1">(select one)</span>
                                </label>

                                <!-- Dropdown trigger and container -->
                                <div class="relative">
                                    <!-- Display selected breed (click to open) -->
                                    <div id="breedDisplay" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg bg-white cursor-pointer hover:border-slate-400 transition-colors" onclick="toggleBreedDropdown()">
                                        <span id="selectedBreedText" class="text-gray-500">Select a breed</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>

                                    <!-- Dropdown menu -->
                                    <div id="breedDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                                        <!-- Search inside dropdown -->
                                        <div class="p-2 border-b border-gray-200">
                                            <input type="text" id="breedSearch" placeholder="Search breed..." class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-emerald-500 focus:bg-white" onkeyup="filterBreeds()" onclick="event.stopPropagation()">
                                        </div>

                                        <!-- Options -->
                                        <div id="breedOptions" class="max-h-48 overflow-y-auto py-1">
                                            <!-- Single breed mode - checkboxes -->
                                            <div id="singleBreedOptions">
                                                <!-- Options populated by JS -->
                                            </div>

                                            <!-- Crossbreed mode - checkboxes -->
                                            <div id="crossbreedOptions" class="hidden">
                                                <!-- Options populated by JS -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden input for breed -->
                                <input type="hidden" id="petBreedInput" name="pet_breed" value="" required>

                                <!-- Display selected breed tags -->
                                <div id="selectedBreedDisplay" class="mt-3 hidden">
                                    <div class="flex flex-wrap gap-2" id="selectedBreedTags"></div>
                                </div>
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

                            <!-- I know my pet's birthdate -->
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="knowBirthdate" name="know_birthdate" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleBirthdate()">
                                    <span class="ml-3 text-gray-700 font-medium">I know my pet's birthdate</span>
                                </label>
                            </div>

                            <!-- Pet's Birthdate (shown if checkbox is checked) -->
                            <div id="birthdateSection" class="hidden">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Birthdate</label>
                                <input type="date" id="petBirthdate" name="pet_birthdate" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            </div>

                            <!-- Exact Pet Age -->
                            <div id="ageSection">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet Age</label>
                                <input type="text" id="petAge" name="pet_age" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="e.g. 2 years 3 months">
                                <p class="text-xs text-gray-500 mt-1">Enter exact age, e.g. "3 months", "1 year", "2 years 6 months"</p>
                            </div>

                            <!-- Pet Weight -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Weight <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" id="petWeight" name="pet_weight" class="w-full px-3.5 py-2.5 pr-12 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Enter weight" maxlength="6" oninput="updateWeightSuffix(); validateWeight(this)" required>
                                    <span id="weightSuffix" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium pointer-events-none hidden">kg</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">If you do not know, type "N/A"</p>
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

                            <!-- Unique Body Mark -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Unique Body Mark <span class="text-red-500">*</span></label>
                                <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-2 hover:border-emerald-400 transition-colors inline-block">
                                    <img id="bodyMarkPreview" src="{{ asset('images/no-image.png') }}" class="w-48 h-48 object-cover rounded-lg">
                                    <input type="file" id="bodyMarkImage" name="body_mark_image" accept="image/*" class="hidden" onchange="previewBodyMark(event)" required>
                                    <button type="button" onclick="removeBodyMark()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 z-10 hidden" id="bodyMarkRemoveBtn">×</button>
                                    <button type="button" onclick="document.getElementById('bodyMarkImage').click()" class="absolute inset-0 flex items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                        Click to upload
                                    </button>
                                </div>
                            </div>

                            <!-- Body Mark Details -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Body Mark Details <span class="text-red-500">*</span></label>
                                <textarea id="bodyMarkDetails" name="body_mark_details" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Describe any unique marks, scars, or distinguishing features..." required></textarea>
                            </div>

                            <!-- Additional View Photos -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Additional Photos</label>
                                <p class="text-xs text-gray-500 mb-4">Upload front, side, and top-down views of your pet</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <!-- Front View -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-2">Front View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-2 hover:border-emerald-400 transition-colors">
                                            <img id="frontPreview" src="{{ asset('images/no-image.png') }}" class="w-full h-32 object-cover rounded-lg">
                                            <input type="file" id="frontImage" name="additional_photos[front]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'frontPreview')">
                                            <button type="button" onclick="removePhoto('front')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 z-10 hidden" id="frontRemoveBtn">×</button>
                                            <button type="button" onclick="document.getElementById('frontImage').click()" class="absolute inset-0 flex items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Side View -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-2">Side View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-2 hover:border-emerald-400 transition-colors">
                                            <img id="sidePreview" src="{{ asset('images/no-image.png') }}" class="w-full h-32 object-cover rounded-lg">
                                            <input type="file" id="sideImage" name="additional_photos[side]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'sidePreview')">
                                            <button type="button" onclick="removePhoto('side')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 z-10 hidden" id="sideRemoveBtn">×</button>
                                            <button type="button" onclick="document.getElementById('sideImage').click()" class="absolute inset-0 flex items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Top-Down View -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-2">Top-Down View</label>
                                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-2 hover:border-emerald-400 transition-colors">
                                            <img id="topPreview" src="{{ asset('images/no-image.png') }}" class="w-full h-32 object-cover rounded-lg">
                                            <input type="file" id="topImage" name="additional_photos[top]" accept="image/*" class="hidden" onchange="previewImageForAdditional(this, 'topPreview')">
                                            <button type="button" onclick="removePhoto('top')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 z-10 hidden" id="topRemoveBtn">×</button>
                                            <button type="button" onclick="document.getElementById('topImage').click()" class="absolute inset-0 flex items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                                Click to upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Eye Color -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Eye Color <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2" id="eyeColorOptions">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Brown" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Brown</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Blue" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Blue</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Amber / Yellow" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Amber / Yellow</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Green" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Green</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Heterochromia (Two different colors)" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Heterochromia (Two different colors)</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="eye_color" value="Other" class="peer sr-only" required onchange="handleEyeColorChange()">
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Other</span>
                                    </label>
                                </div>
                                <div id="eyeColorOtherWrap" class="mt-3 hidden">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Please specify eye color</label>
                                    <input type="text" id="eyeColorOther" name="eye_color_other" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify your pet's eye color">
                                </div>
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
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Core Vaccines -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Core Vaccines</label>
                                    <div id="coreVaccineOptions" class="space-y-2">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="vaccination_core[]" value="Anti-Rabies" class="form-checkbox h-5 w-5 text-emerald-600 rounded">
                                            <span class="ml-3 mr-4 text-gray-700">Anti-Rabies</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Optional Vaccines -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Optional Vaccines</label>
                                    <div id="optionalVaccineOptions" class="space-y-2">
                                        <!-- Populated by JS -->
                                    </div>
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
                                    Likes <span class="text-xs text-gray-500 font-normal">(You can pick up to 5)</span>
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
                                    Diet <span class="text-xs text-gray-500 font-normal">(You can pick up to 5)</span>
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
                                <span class="text-xs text-emerald-300">Final Verification</span>
                            </div>
                            <div class="p-6 space-y-6">

                                <!-- Review: Pet Basics -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Pet Basics
                                    </h5>
                                    <div id="reviewBasics" class="bg-slate-50 border border-slate-200 rounded-xl p-4 divide-y divide-slate-100"></div>
                                </div>

                                <!-- Review: Physical Details & Photos -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Physical Details & Photos
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
                                    </h5>
                                    <div id="reviewHealth" class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3"></div>
                                </div>

                                <!-- Review: Owner's Information -->
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Owner's Information
                                    </h5>
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 divide-y divide-slate-100">
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Pet Owner Name</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $petOwner->first_name ?? '' }} {{ $petOwner && $petOwner->middle_name ? $petOwner->middle_name . ' ' : '' }}{{ $petOwner->last_name ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Email</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right break-all">{{ $petOwner->email ?? $user->email ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Primary</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">+63 {{ $petOwner->phone_number ?? '' }}</span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Address</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                {{ $petOwner->address->block_lot_phase ?? $petOwner->blk_lot_ph ?? '' }}, {{ $petOwner->address->street ?? $petOwner->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? $petOwner->barangay ?? '' }}, Dasmariñas City
                                            </span>
                                        </div>
                                        <div class="flex items-start justify-between gap-4 py-2">
                                            <span class="text-xs text-gray-500">Alternate Mobile Number</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">+63 {{ $petOwner->alternate_phone_number ?? '' }}</span>
                                        </div>
                                    </div>
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
                                <a href="{{ url('/pet-registration') }}" class="inline-flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition-colors text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Back to Pet Registration
                                </a>
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
                            <span class="text-xs text-emerald-300">Read-Only</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Pet Owner Name</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $petOwner->first_name ?? '' }} {{ $petOwner && $petOwner->middle_name ? $petOwner->middle_name . ' ' : '' }}{{ $petOwner->last_name ?? '' }}</p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-500">Email</p>
                                        <p class="text-sm text-gray-900 truncate">{{ $petOwner->email ?? $user->email ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-500">Primary</p>
                                        <p class="text-sm text-gray-900">+63 {{ $petOwner->phone_number ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-500">Address</p>
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
                                        <p class="text-xs text-gray-500">Alternate Mobile Number</p>
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
        // Cat breeds list
        const catBreeds = [
            "Mixed Breed (Puspin)", "Abyssinian", "Aegean", "American Bobtail", "American Curl", 
            "American Shorthair", "American Wirehair", "Arabian Mau", "Australian Mist", "Balinese", 
            "Bambino", "Bengal", "Birman", "Bombay", "British Longhair", "British Shorthair", 
            "Burmese", "Burmilla", "California Spangled", "Chantilly-Tiffany", "Chartreux", 
            "Chausie", "Cheetoh", "Colorpoint Shorthair", "Cornish Rex", "Cymric", "Devon Rex", 
            "Donskoy", "Egyptian Mau", "Exotic Shorthair", "Havana Brown", "Highlander", 
            "Himalayan", "Japanese Bobtail", "Javanese", "Khao Manee", "Korat", "Kurilian Bobtail", 
            "LaPerm", "Lykoi", "Maine Coon", "Manx", "Mexican Hairless", "Minskin", "Minuet", 
            "Munchkin", "Nebelung", "Norwegian Forest Cat", "Ocicat", "Ojos Azules", 
            "Oriental Shorthair", "Persian", "Peterbald", "Pixiebob", "Ragamuffin", "Ragdoll", 
            "Russian Blue", "Savannah", "Scottish Fold", "Scottish Straight", "Selkirk Rex", 
            "Serengeti", "Siamese", "Siberian", "Singapura", "Snowshoe", "Somali", "Sphynx", 
            "Thai", "Tonkinese", "Toybob", "Toyger", "Turkish Angora", "Turkish Van", 
            "York Chocolate", "Unknown"
        ];

        // Dog breeds list (full list)
        const dogBreeds = [
            "Mixed Breed (Aspin)", "Akita", "Alaskan Klee Kai", "Alaskan Malamute", "American Eskimo", 
            "Appenzeller Sennenhund", "Australian Stumpy Tail Cattle Dog", "Azawakh", "Barbado da Terciera", "Barbet", "Basenji",
            "Basset Fauve de Bretagne", "Basset Hound", "Beagle", "Belgian Laekenois", "Belgian Tervuren", 
            "Berger Picard", "Bichon Frise", "Bloodhound", "Boerboel", "Bolognese", "Borzoi", "Boxer", 
            "Bracco Italiano", "Braque Francais Pyrenean", "Braques du Bourbonnais", "Broholmer", 
            "Brussels Griffon", "Bull Terrier", "Boston Bull Terrier", "Staffordshire Bull Terrier", 
            "Miniature Bull Terrier", "Bulldog", "French Bulldog", "Olde English Bulldogge", 
            "American Bulldog", "Continental Bulldog", "Ca de Bou", "Serrano Bulldog", "Campeiro Bulldog", 
            "Alano Español", "Canaan Dog", "Canadian Eskimo Dog", "Cane Corso", "Carolina Dog", 
            "Catahoula Leopard", "Cesky Fousek", "Chihuahua", "Chinese Crested", "Chinese Shar-Pei", 
            "Chinook", "Chow Chow", "Cirneco dell'Etna", "American English Coonhound", 
            "Black and Tan Coonhound", "Bluetick Coonhound", "Redbone Coonhound", "Treeing Walker Coonhound", 
            "Plott Hound", "Cardigan Welsh Corgi", "Pembroke Welsh Corgi", "Coton de Tulear", 
            "Czechoslovakian Vlcak", "Dachshund", "Dalmatian", "Danish-Swedish Farmdog", 
            "Deutscher Watchtelhund", "Dogo Argentino", "Dogue de Bordeaux", "Drever", "Dutch Partridge", 
            "Dutch Smoushond", "East Siberian Laika", "Eurasier", "Finnish Spitz", "American Foxhound", 
            "English Foxhound", "German Spitz", "Grand Basset Griffon Vendeen", "Grand Bleu de Gascogne", 
            "Great Dane", "Great Pyrenees", "Greenland Dog", "Hanoverian Scenthound", "Harrier", 
            "Havanese", "Hokkaido", "Afghan Hound", "American Leopard Hound", 
            "Bavarian Mountain Scent Hound", "Caravan (Mudhol) Hound", "Finnish Hound", 
            "French White & Black Hound", "German Hound", "Hamilton Hound", "Ibizan Hound", 
            "Pharaoh Hound", "Transylvanian Hound", "Hovawart", "Irish Wolfhound", "Italian Greyhound", 
            "Japanese Akitainu", "Japanese Chin", "Japanese Spitz", "Jindo", "Kai Ken", 
            "Karelian Bear Dog", "Keeshond", "Kishu Ken", "Komondor", "Kromfohrlander", "Kuvasz", 
            "Lagotto Romagnolo", "Lancashire Heeler", "Lapponian Herder", "Leonberger", "Lhasa Apso", 
            "Lowchen", "Maltese", "Standard Manchester Terrier", "Toy Manchester Terrier", "Mastiff", 
            "Bullmastiff", "Brazilian Mastiff", "Neapolitan Mastiff", "Pyrenean Mastiff", 
            "Spanish Mastiff", "Tibetan Mastiff", "Moscow Watchdog", "Mountain Cur", "Bernese Mountain Dog", 
            "Entlebucher Mountain Dog", "Estrela Mountain Dog", "Greater Swiss Mountain Dog", "Mudi", 
            "Newfoundland", "Norrbottenspets", "Norwegian Buhund", "Norwegian Elkhound", 
            "Norwegian Lundehund", "Otterhound", "Pekingese", "Perro de Presa Canario", "Peruvian Inca Orchid", 
            "Petit Basset Griffon Vendeen", "Affenpinscher Pinscher", "Doberman Pinscher", 
            "German Pinscher", "Miniature Pinscher", "German Longhaired Pointer", "German Shorthaired Pointer", 
            "German Wirehaired Pointer", "Portuguese Pointer", "Slovakian Wirehaired Pointer", 
            "Chart Polski Polish Greyhound", "Pomeranian", "Miniature Poodle", "Standard Poodle", 
            "Toy Poodle", "Porcelaine", "Portuguese Podengo", "Portuguese Podengo Pequeno", 
            "Pudelpointer", "Pug", "Puli", "Pumi", "Rafeiro do Alentejo", "Chesapeake Bay Retriever", 
            "Curly-coated Retriever", "Flat-Coated Retriever", "Golden Retriever", "Labrador Retriever", 
            "Nova Scotia Duck Tolling Retriever", "Rhodesian Ridgeback", "Rottweiler", "Russian Toy", 
            "Russian Tsvetnaya Bolonka", "Saint Bernard", "Saluki", "Samoyed", "Schapendoes", 
            "Schipperke", "Giant Schnauzer", "Miniature Schnauzer", "Standard Schnauzer", 
            "Scottish Deerhound", "Sealyham Terrier", "Segugio Italiano", "English Setter", 
            "Gordon Setter", "Irish Red and White Setter", "Irish Setter", "Anatolian Shepherd", 
            "Australian Cattle Dog", "American Miniature Shepherd", "Australian Kelpie Shepherd", 
            "Australian Shepherd", "Bearded Collie", "Beauceron", "Belgian Malinois", 
            "Belgian Sheepdog (Groenendael)", "Briard", "Border Collie", "Bouvier des Flandres", 
            "Collie", "Finnish Lapphund", "Miniature American Shepherd", "Bergamasco Shepherd", 
            "Bohemian Shepherd", "Catalan Shepherd", "Caucasian Shepherd", "Central Asian Shepherd", 
            "Croatian Shepherd", "Dutch Shepherd", "English Shepherd", "German Shepherd", 
            "Icelandic Shepherd", "Karst Shepherd", "Old English Shepherd", "Polish Lowland Shepherd", 
            "Portuguese Shepherd", "Pyrenean Shepherd", "Romanian Carpathian Shepherd Dog", 
            "Romanian Mioritic Shepherd Dog", "Shetland Sheepdog", "Shiba Inu", "Shih Tzu", "Shikoku", 
            "Siberian Husky", "Sloughi", "Slovensky Cubac", "Slovensky Kopov", "Small Munsterlander", 
            "American Water Spaniel", "Boykin Spaniel", "Brittany", "Cavalier King Charles Spaniel", 
            "Clumber Spaniel", "Cocker Spaniel", "English Cocker Spaniel", "English Springer Spaniel", 
            "English Toy Spaniel", "Field Spaniel", "French Spaniel", "Irish Water Spaniel", 
            "Nederlandse Kooikerhondje", "Papillon Spaniel", "Sussex Spaniel", "Tibetan Spaniel", 
            "Welsh Springer Spaniel", "Spinone Italiano", "Stabyhoun", "Swedish Vallhund", "Taiwan Dog", 
            "Airedale Terrier", "American Hairless Terrier", "American Staffordshire Terrier", 
            "Australian Terrier", "Bedlington Terrier", "Border Terrier", "Biewer Terrier", 
            "Black Russian Terrier", "Cairn Terrier", "Cesky Terrier", "Dandie Dinmont Terrier", 
            "Glen of Imaal Terrier", "Irish Terrier", "Jagdterrier", "Japanese Terrier", 
            "Kerry Blue Terrier", "Lakeland Terrier", "Norfolk Terrier", "Norwich Terrier", 
            "Parson Russell Terrier", "Rat Terrier", "Jack Russell Terrier", "Scottish Terrier", 
            "Silky Terrier", "Skye Terrier", "Smooth Fox Terrier", "Soft Coated Wheaten Terrier", 
            "Teddy Roosevelt Terrier", "Tibetan Terrier", "Toy Fox Terrier", "Welsh Terrier", 
            "West Highland White Terrier", "Wire Fox Terrier", "Thai Ridgeback", "Tornjak", "Tosa", 
            "Treeing Tennessee Brindle", "Vizsla", "Volpino Italiano", "Portuguese Water Dog", 
            "Spanish Water Dog", "Weimaraner", "Wetterhoun", "Whippet", "Wirehaired Pointing Griffon", 
            "Wirehaired Vizsla", "Working Kelpie", "Xoloitzcuintli", "Yakutian Laika", "Yorkshire Terrier", 
            "Unknown"
        ];

        let selectedBreeds = [];
        let currentPetType = '';

        // Returns true only when the crossbreed answer is "Yes"
        function isCrossbreedSelected() {
            const selected = document.querySelector('input[name="is_crossbreed"]:checked');
            return selected ? selected.value === 'yes' : false;
        }

        // Toggle breed dropdown
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breedDropdown');
            dropdown.classList.toggle('hidden');
            
            // Populate options if not already done
            if (!dropdown.classList.contains('hidden') && currentPetType) {
                updateBreedOptions();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('breedDropdown');
            const display = document.getElementById('breedDisplay');
            if (!dropdown.contains(e.target) && !display.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Update breed options based on pet type
        function updateBreedOptions() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            currentPetType = petType ? petType.value : '';

            const isCrossbreed = isCrossbreedSelected();
            const singleOptions = document.getElementById('singleBreedOptions');
            const crossOptions = document.getElementById('crossbreedOptions');
            const breedLimitText = document.getElementById('breedLimitText');

            // Clear previous selections
            selectedBreeds = [];
            updateSelectedBreedDisplay();

            if (!currentPetType) {
                singleOptions.innerHTML = '';
                crossOptions.innerHTML = '';
                return;
            }

            const breeds = currentPetType === 'cat' ? catBreeds : dogBreeds;

            if (isCrossbreed) {
                // Crossbreed mode - checkbox style, max 2
                breedLimitText.textContent = '(maximum of 2)';
                singleOptions.classList.add('hidden');
                crossOptions.classList.remove('hidden');
                
                // Populate checkboxes
                crossOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="checkbox" value="${breed}" class="pet-breed-checkbox h-4 w-4 text-emerald-600 rounded border-gray-300" onchange="handleBreedCheckbox(this)">
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
            } else {
                // Single breed mode - radio buttons
                breedLimitText.textContent = '(select one)';
                singleOptions.classList.remove('hidden');
                crossOptions.classList.add('hidden');
                
                // Populate radio options
                singleOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="radio" name="breed_option" value="${breed}" class="pet-breed-radio h-4 w-4 text-emerald-600 border-gray-300" onchange="handleSingleBreedSelect('${breed}')">
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
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

        // Handle breed checkbox selection
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
        }

        // Handle single breed selection
        function handleSingleBreedSelect(breed) {
            selectedBreeds = [breed];
            
            // Update hidden input
            document.getElementById('petBreedInput').value = breed;
            
            // Update display text
            document.getElementById('selectedBreedText').textContent = breed;
            document.getElementById('selectedBreedText').classList.remove('text-gray-500');
            document.getElementById('selectedBreedText').classList.add('text-gray-900');
            
            // Close dropdown
            document.getElementById('breedDropdown').classList.add('hidden');
            
            updateSelectedBreedDisplay();
        }

        // Update selected breed display
        function updateSelectedBreedDisplay() {
            const display = document.getElementById('selectedBreedDisplay');
            const tags = document.getElementById('selectedBreedTags');
            const breedDisplay = document.getElementById('breedDisplay');

            if (breedDisplay) {
                breedDisplay.classList.remove('ring-2', 'ring-red-400', 'border-red-400');
            }

            if (selectedBreeds.length === 0) {
                display.classList.add('hidden');
                document.getElementById('petBreedInput').value = '';
                return;
            }
            
            display.classList.remove('hidden');
            tags.innerHTML = selectedBreeds.map(breed => `
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-600 text-white">
                    ${breed}
                    <button type="button" onclick="removeBreed('${breed}')" class="ml-2 hover:text-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            `).join('');
            
            // Also update the display text
            document.getElementById('selectedBreedText').textContent = selectedBreeds.join(', ');
            document.getElementById('selectedBreedText').classList.remove('text-gray-500');
            document.getElementById('selectedBreedText').classList.add('text-gray-900');
            
            // Update hidden input
            document.getElementById('petBreedInput').value = selectedBreeds.join(', ');
        }

        // Remove breed from selection
        function removeBreed(breed) {
            const isCrossbreed = isCrossbreedSelected();

            selectedBreeds = selectedBreeds.filter(b => b !== breed);
            
            if (isCrossbreed) {
                // Uncheck the checkbox
                const checkboxes = document.querySelectorAll('.pet-breed-checkbox');
                checkboxes.forEach(cb => {
                    if (cb.value === breed) {
                        cb.checked = false;
                    }
                });
            } else {
                // Uncheck the radio
                const radios = document.querySelectorAll('.pet-breed-radio');
                radios.forEach(r => {
                    if (r.value === breed) {
                        r.checked = false;
                    }
                });
                
                // Update display text
                if (selectedBreeds.length === 0) {
                    document.getElementById('selectedBreedText').textContent = 'Select a breed';
                    document.getElementById('selectedBreedText').classList.remove('text-gray-900');
                    document.getElementById('selectedBreedText').classList.add('text-gray-500');
                }
            }
            
            updateSelectedBreedDisplay();
        }

        // Filter breeds based on search
        function filterBreeds() {
            const search = document.getElementById('breedSearch').value.toLowerCase();
            const isCrossbreed = isCrossbreedSelected();
            
            if (isCrossbreed) {
                const checkboxes = document.querySelectorAll('#crossbreedOptions label');
                checkboxes.forEach(label => {
                    const text = label.textContent.toLowerCase();
                    label.style.display = text.includes(search) ? 'flex' : 'none';
                });
            } else {
                const radios = document.querySelectorAll('#singleBreedOptions label');
                radios.forEach(label => {
                    const text = label.textContent.toLowerCase();
                    label.style.display = text.includes(search) ? 'flex' : 'none';
                });
            }
        }

        // Preview body mark image
        function previewBodyMark(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('bodyMarkPreview').src = e.target.result;
                    document.getElementById('bodyMarkRemoveBtn').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove body mark image
        function removeBodyMark() {
            const preview = document.getElementById('bodyMarkPreview');
            preview.src = "{{ asset('images/no-image.png') }}";
            document.getElementById('bodyMarkImage').value = '';
            document.getElementById('bodyMarkRemoveBtn').classList.add('hidden');
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
        const dogCoreVaccines = ['Anti-Rabies', '5-in-1 / 6-in-1 / 8-in-1'];
        const dogOptionalVaccines = ['Kennel Cough', 'Other'];
        const catCoreVaccines = ['Anti-Rabies', 'Tricat / FVRCP'];
        const catOptionalVaccines = ['FeLV', 'Other'];

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
            }
        }

        function createVaccineCheckbox(name, value, checked = false) {
            return `
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="${name}[]" value="${value}" class="form-checkbox h-5 w-5 text-emerald-600 rounded" ${checked ? 'checked' : ''}>
                    <span class="ml-3 mr-4 text-gray-700">${value}</span>
                </label>
            `;
        }

        function populateVaccinationHistory() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            const otherValue = document.querySelector('input[name="vaccination_other"]')?.value || '';

            if (!type) {
                document.getElementById('coreVaccineOptions').innerHTML = createVaccineCheckbox('vaccination_core', 'Anti-Rabies');
                document.getElementById('optionalVaccineOptions').innerHTML = createVaccineCheckbox('vaccination_optional', 'Other') + `
                    <div class="mt-3">
                        <input type="text" name="vaccination_other" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify other vaccine">
                    </div>
                `;
                return;
            }

            const coreVaccines = type === 'cat' ? catCoreVaccines : dogCoreVaccines;
            const optionalVaccines = type === 'cat' ? catOptionalVaccines : dogOptionalVaccines;

            document.getElementById('coreVaccineOptions').innerHTML = coreVaccines.map(vaccine => createVaccineCheckbox('vaccination_core', vaccine)).join('');
            document.getElementById('optionalVaccineOptions').innerHTML = optionalVaccines.map(vaccine => {
                if (vaccine === 'Other') {
                    return createVaccineCheckbox('vaccination_optional', vaccine) + `
                        <div class="mt-3">
                            <input type="text" name="vaccination_other" value="${otherValue}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify other vaccine">
                        </div>
                    `;
                }

                return createVaccineCheckbox('vaccination_optional', vaccine);
            }).join('');
        }

        // Populate pet attributes based on type
        function populatePetAttributes() {
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

        // Show more diet options
        function showMoreDiet() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            const dietMore = type === 'cat' ? catDietMore : dogDietMore;
            
            const dietContainer = document.getElementById('dietOptions');
            const showMoreBtn = document.getElementById('dietShowMore');
            
            if (!dietExpanded) {
                // Add more options
                dietContainer.innerHTML += dietMore.map(v => createPillButton('diet', v, 'diet', 5)).join('');
                showMoreBtn.textContent = 'Show Less';
                dietExpanded = true;
            } else {
                // Remove extra options and keep only original
                const originalDiet = type === 'cat' ? catDiet : dogDiet;
                
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
                
                showMoreBtn.textContent = 'Show More';
                dietExpanded = false;
            }
        }

        // Add event listener to pet type radio buttons
        document.querySelectorAll('input[name="pet_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                updateBreedOptions();
                populateVaccinationHistory();
                populatePetAttributes();
            });
        });

        populateVaccinationHistory();

        // Toggle birthdate section
        function toggleBirthdate() {
            const knowBirthdate = document.getElementById('knowBirthdate').checked;
            const birthdateSection = document.getElementById('birthdateSection');
            const ageSection = document.getElementById('ageSection');
            
            if (knowBirthdate) {
                birthdateSection.classList.remove('hidden');
                ageSection.classList.add('hidden');
            } else {
                birthdateSection.classList.add('hidden');
                ageSection.classList.remove('hidden');
            }
        }
        
        // Update weight suffix based on input
        function updateWeightSuffix() {
            const input = document.getElementById('petWeight');
            const suffix = document.getElementById('weightSuffix');
            const value = input.value.trim().toUpperCase();
            
            // Show kg suffix if there's a valid number, hide if empty or N/A
            if (value === '' || value === 'N/A') {
                suffix.classList.add('hidden');
            } else {
                suffix.classList.remove('hidden');
            }
        }
        
        // Validate weight input - numbers and decimals, max 6 characters
        function validateWeight(input) {
            input.value = input.value.replace(/[^0-9.]/g, '');
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
        }

        // Preview uploaded profile image
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('petImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Preview uploaded additional photo
        function previewImageForAdditional(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                    const removeBtn = document.getElementById(previewId.replace('Preview', 'RemoveBtn'));
                    removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove uploaded photo
        function removePhoto(view) {
            const previewId = view + 'Preview';
            const inputId = view + 'Image';
            const removeBtnId = view + 'RemoveBtn';
            
            document.getElementById(previewId).src = "{{ asset('images/no-image.png') }}";
            document.getElementById(inputId).value = '';
            document.getElementById(removeBtnId).classList.add('hidden');
        }

        // Toggle user dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button');
            if (!button || !button.onclick?.toString().includes('toggleDropdown')) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });

        // ============================================
        // MULTI-STEP FORM LOGIC
        // ============================================
        const stepTitles = ['Pet Basics', 'Physical Details & Photos', 'Health & Traits', 'Review & Submit'];
        const totalSteps = 4;
        let currentStep = 1;

        // Eye color "Other" text box toggle
        function handleEyeColorChange() {
            const selected = document.querySelector('input[name="eye_color"]:checked');
            const wrap = document.getElementById('eyeColorOtherWrap');
            const input = document.getElementById('eyeColorOther');

            if (!wrap || !input) return;

            if (selected && selected.value === 'Other') {
                wrap.classList.remove('hidden');
                input.setAttribute('required', 'required');
            } else {
                wrap.classList.add('hidden');
                input.removeAttribute('required');
                input.value = '';
            }
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

        // Build the Step 4 review summary
        function populateReview() {
            const form = document.getElementById('petRegistrationForm');
            if (!form) return;

            const esc = (value) => String(value ?? '').replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));

            const row = (label, value) => `
                <div class="flex items-start justify-between gap-4 py-2">
                    <span class="text-xs text-gray-500">${label}</span>
                    <span class="text-sm font-semibold text-gray-900 text-right">${esc(value || '—')}</span>
                </div>`;

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
            const knowBirthdate = document.getElementById('knowBirthdate');
            const birthdate = document.getElementById('petBirthdate');
            const age = document.getElementById('petAge');
            const weight = document.getElementById('petWeight');
            const eyeColorInput = form.querySelector('input[name="eye_color"]:checked');
            const eyeColorOther = document.getElementById('eyeColorOther');
            const bodyMarkDetails = document.getElementById('bodyMarkDetails');

            let eyeColor = eyeColorInput ? eyeColorInput.value : '';
            if (eyeColor === 'Other' && eyeColorOther && eyeColorOther.value.trim() !== '') {
                eyeColor = eyeColorOther.value.trim();
            }

            let ageOrBirthdate = '';
            if (knowBirthdate && knowBirthdate.checked && birthdate && birthdate.value) {
                const parsed = new Date(birthdate.value + 'T00:00:00');
                ageOrBirthdate = parsed.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            } else if (age && age.value.trim() !== '') {
                ageOrBirthdate = age.value.trim();
            }

            document.getElementById('reviewPhysicalRows').innerHTML =
                row('Birthdate / Age', ageOrBirthdate) +
                row('Weight', weight && weight.value.trim() !== '' ? weight.value.trim() + ' kg' : '') +
                row('Eye Color', eyeColor) +
                row('Body Mark Details', bodyMarkDetails ? bodyMarkDetails.value : '');

            const images = [
                { id: 'petImagePreview', label: 'Profile', fallback: '{{ asset('images/pet.png') }}' },
                { id: 'bodyMarkPreview', label: 'Body Mark', fallback: '{{ asset('images/no-image.png') }}' },
                { id: 'frontPreview', label: 'Front View', fallback: '{{ asset('images/no-image.png') }}' },
                { id: 'sidePreview', label: 'Side View', fallback: '{{ asset('images/no-image.png') }}' },
                { id: 'topPreview', label: 'Top-Down', fallback: '{{ asset('images/no-image.png') }}' }
            ];

            const imagesHtml = images.map(img => {
                const el = document.getElementById(img.id);
                const src = el ? el.getAttribute('src') : img.fallback;
                const hasUpload = img.id !== 'petImagePreview'
                    ? !!src && !src.endsWith('no-image.png')
                    : !!src && !src.endsWith('pet.png');
                return `
                <div class="text-center">
                    <img src="${esc(src)}" alt="${img.label}" class="w-20 h-20 ${img.id === 'petImagePreview' ? 'rounded-full' : 'rounded-xl'} object-cover border-2 ${hasUpload ? 'border-emerald-400' : 'border-slate-200'} mx-auto">
                    <span class="block text-[10px] text-gray-500 mt-1">${img.label}</span>
                    <span class="block text-[10px] ${hasUpload ? 'text-emerald-600' : 'text-slate-400'}">${hasUpload ? 'Uploaded' : 'Not uploaded'}</span>
                </div>`;
            }).join('');

            document.getElementById('reviewPhysicalImages').innerHTML = imagesHtml;

            // --- Health & Traits ---
            const coreVaccines = Array.from(document.querySelectorAll('#coreVaccineOptions input[type="checkbox"]:checked')).map(cb => cb.value);
            const optionalVaccines = Array.from(document.querySelectorAll('#optionalVaccineOptions input[type="checkbox"]:checked')).map(cb => cb.value);
            const otherVaccine = form.querySelector('input[name="vaccination_other"]');

            let vaccines = coreVaccines.concat(optionalVaccines);
            if (optionalVaccines.includes('Other') && otherVaccine && otherVaccine.value.trim() !== '') {
                vaccines.push(otherVaccine.value.trim());
            }

            const traitRow = (label, containerId) => row(label, asText(selectedPills(containerId)));

            document.getElementById('reviewHealth').innerHTML =
                row('Core & Optional Vaccines', vaccines.join(', ')) +
                traitRow('Training', 'trainingOptions') +
                traitRow('Insurance', 'insuranceOptions') +
                traitRow('Behavior', 'behaviorOptions') +
                traitRow('Likes', 'likesOptions') +
                traitRow('Dislikes', 'dislikesOptions') +
                traitRow('Diet', 'dietOptions') +
                traitRow('Allergy', 'allergyOptions');
        }

        // Initialise the stepper on page load
        updateStepIndicator();
    </script>
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Registration</h3>
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
    
    <script>
        function showConfirmModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        
        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
        
        function submitPetForm() {
            document.getElementById('petRegistrationForm').submit();
        }
    </script>
</body>
</html>
