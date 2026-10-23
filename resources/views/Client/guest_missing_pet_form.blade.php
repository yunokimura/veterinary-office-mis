<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Pet Report - Dasmariñas City Veterinary Services</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/breeds.js') }}" defer></script>

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
        <h2 class="text-3xl font-bold text-gray-900">Lost Pet Report</h2>
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

                <!-- Card 1: Pet Basics -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PET BASICS</h4>
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
                                    <input type="radio" name="species" value="dog" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required {{ old('species') === 'dog' ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium">Dog</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="species" value="cat" class="form-radio h-5 w-5 text-emerald-600" onchange="updateBreedOptions()" required {{ old('species') === 'cat' ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium">Cat</span>
                                </label>
                            </div>
                        </div>

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

                <!-- Card 2: Physical Details -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PHYSICAL DETAILS</h4>
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
                        <div id="ageOrBirthdateWrap" class="hidden border-l-2 border-emerald-300 pl-4 space-y-4">
                            <!-- Pet's Birthdate -->
                            <div id="birthdateSection" class="hidden space-y-2">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-1">Pet's Birthdate</label>
                                <input type="date" id="petBirthdate" name="pet_birthdate" value="{{ old('pet_birthdate') }}" max="{{ now()->format('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            </div>

                            <!-- Pet Age -->
                            <div id="ageSection" class="hidden space-y-2">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-1">Pet Age</label>
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
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-1">Collar / Harness</label>
                                <input type="text" id="collarHarnessInput" name="collar_harness" value="{{ old('collar_harness') }}" placeholder="e.g., Red collar with bells, None" class="w-[350px] px-3.5 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="noCollarHarness" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleNoCollarHarness()">
                                    <span class="ml-3 text-gray-700 font-medium">Pet doesn't wear any collar/harness</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Time and Place -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">TIME AND PLACE</h4>
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

                <!-- Submit -->
                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-emerald-600 text-white px-12 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition-colors flex items-center gap-2 w-full md:w-auto shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Submit Lost Pet Report
                    </button>
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

<!-- Breed Selector Modal -->
<div id="breedModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="breedModalTitle">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeBreedModal()"></div>
    <div class="fixed inset-0 flex items-end sm:items-center sm:justify-center p-0 sm:p-4">
        <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md min-h-[64vh] sm:min-h-[72vh] max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
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
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="breedModalSearch" placeholder="Search breed..." onkeyup="filterBreedModal()"
                           class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" autocomplete="off">
                </div>
            </div>
			<div class="flex-1 overflow-y-auto">
				<div class="px-5 pt-4 pb-4">
					<div id="breedModalQuick" class="mb-5 hidden">
						<p class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Popular / Quick Selections</p>
						<div class="flex flex-wrap gap-2" id="breedModalQuickChips"></div>
					</div>

					<div id="breedModalListWrap" class="max-h-[60vh] overflow-y-auto pr-2">
						<div id="breedModalList"></div>
						<div id="breedModalEmpty" class="hidden text-center py-8">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
							</svg>
							<p class="text-xs text-gray-700">No breeds match your search.</p>
							<p class="text-sm text-gray-400 mt-1">Try "Other / Breed Not Listed" below.</p>
						</div>
					</div>
				</div>
			</div>
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

<script>
        // Breed data loaded from external file (public/js/breeds.js)
        // catBreeds, dogBreeds, quickCatBreeds, quickDogBreeds are globally available

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
            const petType = document.querySelector('input[name="species"]:checked');

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

            lastFocusedElement = document.activeElement;

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

            const filtered = breeds.filter(b => b.toLowerCase().includes(search));
            const list = document.getElementById('breedModalList');
            const empty = document.getElementById('breedModalEmpty');

            if (filtered.length === 0) {
                list.innerHTML = '';
                empty.classList.remove('hidden');
                return;
            }

            empty.classList.add('hidden');

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
                const checkbox = document.querySelector(`.pet-breed-checkbox[value="${breed}"]`);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    handleBreedCheckbox(checkbox);
                }
            } else {
                handleSingleBreedSelect(breed);
            }
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
            renderBreedModal(document.getElementById('breedModalSearch').value);
        }

        // Handle single breed selection (radio mode)
        function handleSingleBreedSelect(breed) {
            selectedBreeds = [breed];

            document.getElementById('petBreedInput').value = breed;

            const selectedText = document.getElementById('selectedBreedText');
            selectedText.textContent = breed;
            selectedText.classList.remove('text-gray-700');
            selectedText.classList.add('text-gray-900');

            updateSelectedBreedDisplay();
            closeBreedModal();
        }

        // "Other / Breed Not Listed" fallback
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

            selectedText.textContent = selectedBreeds.join(', ');
            selectedText.classList.remove('text-gray-700');
            selectedText.classList.add('text-gray-900');

            petBreedInput.value = selectedBreeds.join(', ');
        }

        // Update breed options when the species changes
        function updateBreedOptions() {
            const petType = document.querySelector('input[name="species"]:checked');
            currentPetType = petType ? petType.value : '';

            const breedLimitText = document.getElementById('breedLimitText');

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

            selectedBreeds = [];
            updateSelectedBreedDisplay();

            updateBreedOptions();
        }

        // Close modal with the Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const breedModal = document.getElementById('breedModal');
                if (breedModal && !breedModal.classList.contains('hidden')) {
                    closeBreedModal();
                }
            }
        });

        // --- Image preview ---
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

    // --- Birthdate / Age toggles ---
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

    // --- Eye color ---
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

    // --- Body mark photo ---
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
        handleEyeColorChange();
        toggleBirthdate();
        toggleWeightUnknown();
        toggleNoCollarHarness();
        document.getElementById('petWeight').addEventListener('input', updateWeightSuffix);
    });
</script>

</body>
</html>
