<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missing Pet Report - Dasmariñas City Veterinary Services</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { DEFAULT: '#066D33', light: '#077a40', dark: '#055a29' },
                    }
                }
            }
        }
        .dropdown-option { transition: all 0.2s ease; }
        .dropdown-option:hover { background-color: #f3f4f6; }
        .dropdown-option.selected { background-color: #e8f5e9; }
    </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen">

<!-- Header -->
@include('Client.partials.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Title and Required Fields Notice -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Missing Pet Report</h2>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-8 space-y-6">
            <form method="POST" action="{{ route('missing-pets.report.guest.store', ['type' => 'missing']) }}" enctype="multipart/form-data" id="guestMissingPetForm">
                @csrf
                <input type="hidden" name="report_type" value="missing">
                <input type="hidden" name="loaded_at" value="{{ $loadedAt ?? now()->timestamp }}">
                <input type="hidden" name="step" id="stepInput" value="1">

                <!-- Multi-Step Progress Indicator -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">REPORT PROGRESS</h4>
                        </div>
                        <span id="stepIndicatorText" class="text-sm text-emerald-300 font-medium">Step 1 of 3 — Pet Basics</span>
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
                                    <span class="step-title block text-sm font-semibold truncate">Time and Place</span>
                                    <span class="step-subtitle block text-xs text-gray-700 truncate">When & where</span>
                                </span>
                            </button>
                        </div>
                        <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div id="progressBar" class="h-full bg-emerald-600 transition-all duration-300" style="width: 33%"></div>
                        </div>
                    </div>
                </div>

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
                                    <input type="file" id="petImage" name="photo" accept="image/*" class="hidden" onchange="previewImage(event)">
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
                                        <input type="radio" name="species" value="dog" class="form-radio h-5 w-5 text-emerald-600" required {{ old('species') === 'dog' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Dog</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="species" value="cat" class="form-radio h-5 w-5 text-emerald-600" required {{ old('species') === 'cat' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Cat</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="species" value="other" class="form-radio h-5 w-5 text-emerald-600" required {{ old('species') === 'other' ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium">Other</span>
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

                                <!-- Crossbreed -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Crossbreed <span class="text-red-500">*</span></label>
                                    <div class="flex space-x-6">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_crossbreed" value="yes" class="form-radio h-5 w-5 text-emerald-600" required {{ old('is_crossbreed') === 'yes' ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_crossbreed" value="no" class="form-radio h-5 w-5 text-emerald-600" required {{ old('is_crossbreed') === 'no' ? 'checked' : '' }}>
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

                            <!-- Pet Breed -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Breed</label>
                                <input type="text" name="breed" value="{{ old('breed') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Breed (if known)">
                            </div>

                            <!-- Fur Colors -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Color / Markings</label>
                                <input type="text" name="color" value="{{ old('color') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="e.g., Brown, White with black spots">
                            </div>
                        </div>
                    </div>

                    <!-- Step 1 Navigation -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" onclick="handleCancelNavigation()" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
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

                            <!-- Pet's Birthdate / Pet Age -->
                            <div id="ageOrBirthdateWrap" class="hidden border-l-2 border-emerald-300 pl-4">

                                <!-- Pet's Birthdate -->
                                <div id="birthdateSection" class="hidden">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Birthdate</label>
                                    <input type="date" id="petBirthdate" name="pet_birthdate" value="{{ old('pet_birthdate') }}" max="{{ now()->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                </div>

                                <!-- Pet Age -->
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
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Pet's Weight (kg)</label>
                                <div class="relative">
                                    <input type="text" id="petWeight" name="pet_weight" value="{{ old('pet_weight') }}" placeholder="Enter weight in kg" maxlength="6" class="w-full px-3.5 py-2.5 pr-12 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
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
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Eye Color</label>
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
                                        <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Heterochromia</span>
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
                                <div id="eyeColorHeterochromiaWrap" class="mt-2 p-4 bg-emerald-50/60 border border-emerald-200 rounded-xl rounded-tl-none hidden">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                                        </div>
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Unique Body Mark -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Unique Body Mark</label>
                                <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[144px] w-36 md:w-48">
                                    <img id="bodyMarkPreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                    <input type="file" id="bodyMarkImage" name="photo" accept="image/*" class="hidden" onchange="previewBodyMark(event)">
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
                                <textarea id="bodyMarkDetails" name="body_marks" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Describe any unique marks, scars, or distinguishing features...">{{ old('body_marks') }}</textarea>
                            </div>

                            <!-- Collar / Harness -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-1">Collar / Harness</label>
                                    <input type="text" id="collarHarnessInput" name="collar_harness" value="{{ old('collar_harness') }}" placeholder="e.g., Red collar with bells, None" class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                                <div class="flex items-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="noCollarHarness" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleNoCollarHarness()">
                                        <span class="ml-3 text-gray-700 font-medium">Pet doesn't wear any collar/harness</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 Navigation -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" onclick="changeStep(-1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
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

                <!-- STEP 3: Time and Place -->
                <div id="step-3" class="step-pane space-y-6 hidden">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Time and Place</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Last Seen Date and Time -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Last Seen Date and Time <span class="text-red-500">*</span></label>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="date" name="last_seen_date" id="last_seen_date" max="{{ now()->format('Y-m-d') }}" value="{{ old('last_seen_date') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" required>
                                    </div>
                                    <div>
                                        <input type="time" name="last_seen_time" id="last_seen_time" value="{{ old('last_seen_time') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Location - Barangay -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Location (Barangay) <span class="text-red-500">*</span></label>
                                <select name="barangay_id" id="barangayIdInput" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" required>
                                    <option value="">Select Barangay</option>
                                    @if(isset($barangays) && $barangays->count() > 0)
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                                {{ $barangay->barangay_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Specific Location Description -->
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Specific Location Description</label>
                                <textarea name="location_description" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y" placeholder="Describe the specific location where the pet was last seen (e.g., near the church, at the park, etc.)">{{ old('location_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 Navigation -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" onclick="changeStep(-1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-light transition-colors shadow-sm">
                            Submit Missing Pet Report
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <div class="lg:sticky lg:top-20 space-y-6">
                <!-- Owner's Information (Editable for guests) -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">OWNER'S INFORMATION</h4>
                        </div>
                        <span class="text-xs text-emerald-300">Guest</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Reporter Name <span class="text-red-500">*</span></label>
                            <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Your full name">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Contact Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="reporter_contact" value="{{ old('reporter_contact') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="e.g., 09XXXXXXXXX" required>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Email Address</label>
                            <input type="email" name="reporter_email" value="{{ old('reporter_email') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="your@email.com">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('Client.partials.footer')

<script>
    // Step navigation
    let currentStep = 1;
    const totalSteps = 3;

    function updateStepUI() {
        // Show/hide step panes
        document.querySelectorAll('.step-pane').forEach(pane => pane.classList.add('hidden'));
        document.getElementById('step-' + currentStep).classList.remove('hidden');

        // Update progress circles
        document.querySelectorAll('.step-circle').forEach(circle => {
            const step = parseInt(circle.dataset.step);
            circle.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-600');
            circle.classList.add('bg-white', 'text-emerald-600', 'border-emerald-300');
            if (step === currentStep) {
                circle.classList.remove('bg-white', 'text-emerald-600', 'border-emerald-300');
                circle.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600');
            } else if (step < currentStep) {
                circle.classList.remove('bg-white', 'text-emerald-600', 'border-emerald-300');
                circle.classList.add('bg-emerald-100', 'text-emerald-600', 'border-emerald-300');
            }
        });

        // Update step indicator text
        const stepLabels = ['Pet Basics', 'Physical Details', 'Time and Place'];
        document.getElementById('stepIndicatorText').textContent = 'Step ' + currentStep + ' of ' + totalSteps + ' — ' + stepLabels[currentStep - 1];

        // Update progress bar
        const percent = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = percent + '%';

        // Store current step in hidden input
        document.getElementById('stepInput').value = currentStep;
    }

    function changeStep(delta) {
        currentStep += delta;
        if (currentStep < 1) currentStep = 1;
        if (currentStep > totalSteps) currentStep = totalSteps;
        updateStepUI();
    }

    function goToStep(step) {
        currentStep = step;
        updateStepUI();
    }

    function handleCancelNavigation() {
        if (confirm('Cancel and discard your report?')) {
            window.location.href = '/missing-pets';
        }
    }

    // --- Step 1: Image preview ---
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('petImagePreview').src = e.target.result;
            document.getElementById('petImagePreview').classList.remove('hidden');
            document.getElementById('petImagePlaceholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    // --- Step 2: Age / Birthdate toggles ---
    function toggleBirthdate() {
        const yes = document.querySelector('input[name="know_birthdate"]:checked').value === 'yes';
        const wrap = document.getElementById('ageOrBirthdateWrap');
        wrap.classList.remove('hidden');
        document.getElementById('birthdateSection').classList.add('hidden');
        document.getElementById('ageSection').classList.add('hidden');
        if (yes) {
            document.getElementById('birthdateSection').classList.remove('hidden');
        } else {
            document.getElementById('ageSection').classList.remove('hidden');
        }
    }

    function toggleWeightUnknown() {
        const cb = document.getElementById('weightUnknown');
        const input = document.getElementById('petWeight');
        const suffix = document.getElementById('weightSuffix');
        if (cb.checked) {
            input.readOnly = true;
            input.value = '';
            input.classList.add('bg-slate-100', 'text-gray-400', 'cursor-not-allowed');
            input.classList.remove('focus:border-emerald-500', 'focus:ring-2', 'focus:ring-emerald-500', 'focus:bg-white');
            suffix.classList.add('hidden');
        } else {
            input.readOnly = false;
            input.classList.remove('bg-slate-100', 'text-gray-400', 'cursor-not-allowed');
            input.classList.add('focus:border-emerald-500', 'focus:ring-2', 'focus:ring-emerald-500', 'focus:bg-white');
            suffix.classList.remove('hidden');
        }
    }

    function updateWeightSuffix() {
        const suffix = document.getElementById('weightSuffix');
        const input = document.getElementById('petWeight');
        if (input.value && !document.getElementById('weightUnknown').checked) {
            suffix.classList.remove('hidden');
        } else {
            suffix.classList.add('hidden');
        }
    }

    // --- Step 2: Eye color ---
    function handleEyeColorChange() {
        const val = document.querySelector('input[name="eye_color"]:checked');
        const otherWrap = document.getElementById('eyeColorOtherWrap');
        const heteroWrap = document.getElementById('eyeColorHeterochromiaWrap');
        otherWrap.classList.add('hidden');
        heteroWrap.classList.add('hidden');
        if (val && val.value === 'Other') {
            otherWrap.classList.remove('hidden');
        }
        if (val && val.value === 'Heterochromia (Two different colors)') {
            heteroWrap.classList.remove('hidden');
        }
    }

    function handleEyeSideChange(side) {
        const otherWrapId = 'eyeColor' + side + 'OtherWrap';
        const wrap = document.getElementById(otherWrapId);
        const select = document.getElementById('eyeColor' + side);
        if (wrap && select && select.value === 'Other') {
            wrap.classList.remove('hidden');
        } else if (wrap) {
            wrap.classList.add('hidden');
        }
    }

    // --- Step 2: Body mark photo ---
    function previewBodyMark(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bodyMarkPreview').src = e.target.result;
            document.getElementById('bodyMarkPreview').classList.remove('hidden');
            document.getElementById('bodyMarkRemoveBtn').classList.remove('hidden');
            document.getElementById('bodyMarkUploadBtn').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeBodyMark() {
        document.getElementById('bodyMarkImage').value = '';
        document.getElementById('bodyMarkPreview').classList.add('hidden');
        document.getElementById('bodyMarkRemoveBtn').classList.add('hidden');
        document.getElementById('bodyMarkUploadBtn').classList.remove('hidden');
    }

    function toggleNoCollarHarness() {
        const cb = document.getElementById('noCollarHarness');
        const input = document.getElementById('collarHarnessInput');
        if (cb.checked) {
            input.value = 'None';
            input.disabled = true;
            input.classList.add('opacity-50', 'pointer-events-none');
        } else {
            input.value = '';
            input.disabled = false;
            input.classList.remove('opacity-50', 'pointer-events-none');
        }
    }

    // Initialize age year/month options
    (function() {
        const yearsSel = document.getElementById('petAgeYears');
        const monthsSel = document.getElementById('petAgeMonths');
        for (let i = 0; i <= 40; i++) {
            const o = document.createElement('option');
            o.value = i;
            o.textContent = i + ' year' + (i !== 1 ? 's' : '');
            yearsSel.appendChild(o);
        }
        for (let i = 0; i <= 11; i++) {
            const o = document.createElement('option');
            o.value = i;
            o.textContent = i + ' month' + (i !== 1 ? 's' : '');
            monthsSel.appendChild(o);
        }
    })();

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateStepUI();
        // Restore radio states on load for eye color / birthdate
        handleEyeColorChange();
        toggleBirthdate();
        toggleWeightUnknown();
        toggleNoCollarHarness();
        document.getElementById('petWeight').addEventListener('input', updateWeightSuffix);
    });
</script>

</body>
</html>
