<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Pet Report - Dasmariñas City Veterinary Services</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <script src="{{ asset('js/breeds.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

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

    <script>
        const barangaysData = @json($barangays);
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
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans bg-gray-50 min-h-screen">

<!-- Header -->
@include('Client.partials.navbar')

<!-- Main -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Title and Required Fields Notice -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Found Pet Report</h2>
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
        <div class="lg:col-span-8">
            <form method="POST" action="{{ route('found-pets.report.store') }}" enctype="multipart/form-data" id="foundPetForm">
                @csrf

                <!-- Section 1: Found Pet Description -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">FOUND PET DESCRIPTION</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Species -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Species <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="species" value="Dog" class="sr-only peer" required {{ old('species') === 'Dog' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Dog</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="species" value="Cat" class="sr-only peer" required {{ old('species') === 'Cat' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Cat</span>
                                </label>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="gender" value="Male" class="sr-only peer" required {{ old('gender') === 'Male' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Male</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="gender" value="Female" class="sr-only peer" required {{ old('gender') === 'Female' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Female</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="gender" value="Unknown" class="sr-only peer" required {{ old('gender') === 'Unknown' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Unknown</span>
                                </label>
                            </div>
                        </div>

                        <!-- Estimated Age -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Estimated Age <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="estimated_age" value="Puppy/Kitten" class="sr-only peer" required {{ old('estimated_age') === 'Puppy/Kitten' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Puppy/Kitten</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="estimated_age" value="Adult" class="sr-only peer" required {{ old('estimated_age') === 'Adult' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Adult</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="estimated_age" value="Senior" class="sr-only peer" required {{ old('estimated_age') === 'Senior' ? 'checked' : '' }} onclick="togglePill(this)">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 bg-white cursor-pointer hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Senior</span>
                                </label>
                            </div>
                        </div>

                        <!-- Breed -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Breed <span class="text-red-500">*</span>
                                <span id="breedLimitText" class="text-xs text-gray-700 font-normal ml-1">(select one)</span>
                            </label>

                            <!-- Breed display / modal trigger -->
                            <div class="relative">
                                <button type="button" id="breedDisplay" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg cursor-pointer hover:border-slate-400 transition-colors text-left flex items-center focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" onclick="openBreedModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span id="selectedBreedText" class="text-gray-700 truncate">Select Breed</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Hidden input for breed -->
                            <input type="hidden" id="breedInput" name="breed" value="" required>
                        </div>

                        <!-- Pet Photo Upload (Required) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Pet Photo <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-2">A clear photo is essential for community identification.</p>
                            <div class="relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[144px] w-36 md:w-48 cursor-pointer" onclick="document.getElementById('pet_photo').click()">
                                <img id="petPhotoPreview" src="" class="w-full h-full object-cover rounded-lg hidden">
                                <input type="file" name="pet_photo" id="pet_photo" accept="image/*" class="hidden" required onchange="previewPetPhoto(event)">
                                <button type="button" onclick="removePetPhoto()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-sm hover:bg-red-600 z-10 hidden" id="petPhotoRemoveBtn" aria-label="Remove pet photo">×</button>
                                <button type="button" onclick="document.getElementById('pet_photo').click()" id="petPhotoUploadBtn" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 hover:text-emerald-600 text-sm font-medium bg-white bg-opacity-80 rounded-lg">
                                    <i class="fi fi-br-picture text-4xl mb-2"></i>
                                    Click to upload
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Section 2: Distinguishing Marks & Condition -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">DISTINGUISHING MARKS &amp; CONDITION</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Eye Color -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Eye Color
                            </label>
                            <div class="flex flex-wrap gap-2" id="eyeColorOptions">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Brown" class="peer sr-only" required {{ old('eye_color') === 'Brown' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Brown</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Blue" class="peer sr-only" required {{ old('eye_color') === 'Blue' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Blue</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Amber / Yellow" class="peer sr-only" required {{ old('eye_color') === 'Amber / Yellow' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Amber / Yellow</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Green" class="peer sr-only" required {{ old('eye_color') === 'Green' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Green</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Heterochromia (Two different colors)" class="peer sr-only" required {{ old('eye_color') === 'Heterochromia (Two different colors)' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Heterochromia</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="eye_color" value="Other" class="peer sr-only" required {{ old('eye_color') === 'Other' ? 'checked' : '' }} onclick="togglePill(this)" onchange="handleEyeColorChange()">
                                    <span class="px-3 py-1.5 text-sm rounded-full border border-slate-300 text-gray-700 hover:border-emerald-500 transition-colors peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">Other</span>
                                </label>
                            </div>
                            <!-- Left / Right Eye Color (shown for heterochromia) -->
                            <div id="eyeColorHeterochromiaWrap" class="mt-2 p-4 bg-emerald-50/60 border border-emerald-200 rounded-xl hidden {{ old('eye_color') === 'Heterochromia (Two different colors)' ? '' : 'hidden' }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Left Eye -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Left Eye Color</label>
                                        <select id="eyeColorLeft" name="eye_color_left"
                                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                            <option value="">Select left eye color</option>
                                            <option value="Brown" {{ old('eye_color_left') === 'Brown' ? 'selected' : '' }}>Brown</option>
                                            <option value="Blue" {{ old('eye_color_left') === 'Blue' ? 'selected' : '' }}>Blue</option>
                                            <option value="Amber / Yellow" {{ old('eye_color_left') === 'Amber / Yellow' ? 'selected' : '' }}>Amber / Yellow</option>
                                            <option value="Green" {{ old('eye_color_left') === 'Green' ? 'selected' : '' }}>Green</option>
                                            <option value="Hazel" {{ old('eye_color_left') === 'Hazel' ? 'selected' : '' }}>Hazel</option>
                                            <option value="Parti-Colored / Marbled" {{ old('eye_color_left') === 'Parti-Colored / Marbled' ? 'selected' : '' }}>Parti-Colored / Marbled</option>
                                            <option value="Other" {{ old('eye_color_left') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <div id="eyeColorLeftOtherWrap" class="mt-2 hidden {{ old('eye_color_left') === 'Other' ? '' : 'hidden' }}">
                                            <input type="text" id="eyeColorLeftOther" name="eye_color_left_other" value="{{ old('eye_color_left_other') }}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify left eye color">
                                        </div>
                                    </div>
                                    <!-- Right Eye -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Right Eye Color</label>
                                        <select id="eyeColorRight" name="eye_color_right"
                                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                            <option value="">Select right eye color</option>
                                            <option value="Brown" {{ old('eye_color_right') === 'Brown' ? 'selected' : '' }}>Brown</option>
                                            <option value="Blue" {{ old('eye_color_right') === 'Blue' ? 'selected' : '' }}>Blue</option>
                                            <option value="Amber / Yellow" {{ old('eye_color_right') === 'Amber / Yellow' ? 'selected' : '' }}>Amber / Yellow</option>
                                            <option value="Green" {{ old('eye_color_right') === 'Green' ? 'selected' : '' }}>Green</option>
                                            <option value="Hazel" {{ old('eye_color_right') === 'Hazel' ? 'selected' : '' }}>Hazel</option>
                                            <option value="Parti-Colored / Marbled" {{ old('eye_color_right') === 'Parti-Colored / Marbled' ? 'selected' : '' }}>Parti-Colored / Marbled</option>
                                            <option value="Other" {{ old('eye_color_right') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <div id="eyeColorRightOtherWrap" class="mt-2 hidden {{ old('eye_color_right') === 'Other' ? '' : 'hidden' }}">
                                            <input type="text" id="eyeColorRightOther" name="eye_color_right_other" value="{{ old('eye_color_right_other') }}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify right eye color">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="eyeColorOtherWrap" class="mt-3 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Please specify eye color</label>
                                <input type="text" id="eyeColorOther" name="eye_color_other" value="{{ old('eye_color_other') }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all" placeholder="Specify eye color">
                            </div>
                        </div>

                        <!-- Collar / Harness -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Collar / Harness Description
                            </label>
                            <input type="text" name="collar_harness" id="collar_harness"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., Red collar with bell, Blue harness">
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" id="noCollarHarness" class="form-checkbox h-5 w-5 text-emerald-600 rounded" onchange="toggleNoCollarHarness()">
                                <span class="ml-3 text-[14px] text-gray-700 font-medium">Pet doesn't wear any collar/harness</span>
                            </label>
                        </div>

                        <!-- Fur Colors -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Fur Colors
                            </label>
                            <input type="text" name="fur_colors" id="fur_colors"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., White with brown patches, Black and tan">
                        </div>

                        <!-- Condition -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Condition
                            </label>
                            <input type="text" name="condition" id="condition"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., Injured, Friendly, Wearing blue collar, Scared">
                        </div>

                    </div>
                </div>

                <!-- Section 3: Time & Found Location -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">TIME &amp; FOUND LOCATION</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Date & Time Found -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Date &amp; Time Found <span class="text-red-500">*</span>
                            </label>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="date" name="date_found" id="date_found"
                                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                           required>
                                </div>
                                <div>
                                    <input type="time" name="time_found" id="time_found"
                                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Location - Barangay Modal -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Barangay <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" id="barangayDisplay" class="w-1/2 px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg cursor-pointer hover:border-slate-400 transition-colors text-left flex items-center focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" onclick="openBarangayModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span id="selectedBarangayText" class="text-sm text-gray-700 truncate">Select Barangay</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 ml-auto pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Hidden input for barangay -->
                            <input type="hidden" id="barangayIdInput" name="barangay_id" value="" required>
                        </div>

                        <!-- Specific Location Notes -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Specific Location Notes
                            </label>
                            <textarea name="location_notes" rows="3"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                      placeholder="Describe the specific location where the pet was found (e.g., near the church, at the park, street corner, etc.)"></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-center mt-6">
                            <!-- Reporter fields (hidden, populated from user profile) -->
                            <input type="hidden" name="reported_by_name" value="{{ old('reported_by_name', trim(($petOwner->first_name ?? '') . ' ' . ($petOwner->last_name ?? ''))) }}">
                            <input type="hidden" name="reporter_contact" value="{{ old('reporter_contact', $petOwner->phone_number ?? '') }}">
                            <input type="hidden" name="reporter_email" value="{{ old('reporter_email', $user->email ?? '') }}">
                            <button type="submit" class="bg-primary text-white px-12 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center gap-2 w-full md:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Submit Found Pet Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Back Link -->
                <div class="mt-6">
                    <a href="/missing-pets" class="text-sm text-gray-500 hover:text-primary transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Lost &amp; Found Pets
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <div class="lg:sticky lg:top-20 space-y-6">
                <!-- Reporter's Contact Info Card -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">REPORTER'S CONTACT INFO</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Reporter Name</p>
                            <p class="text-sm font-semibold text-gray-900">{{ trim(($petOwner->first_name ?? '') . ' ' . ($petOwner->last_name ?? '')) }}</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm text-gray-900 truncate">{{ $user->email ?? '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">Primary Number</p>
                                    <p class="text-sm text-gray-900">+63 {{ $petOwner->phone_number ?? '' }}</p>
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

                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">Address</p>
                                    <p class="text-sm text-gray-900">
                                        {{ $petOwner->address->block_lot_phase ?? '' }}, {{ $petOwner->address->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? '' }}, Dasmariñas City
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
@include('Client.partials.footer')

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
                <!-- Search bar -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="breedModalSearch" placeholder="Search breed..." onkeyup="filterBreedModal()"
                           class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" autocomplete="off">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto">
                <div class="px-5 pt-4 pb-4">
                    <!-- Quick Selections -->
                    <div id="breedModalQuick" class="mb-5 hidden">
                        <p class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Popular Breeds</p>
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
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-4 border-t border-slate-200 bg-white">
                <button type="button" onclick="closeBreedModal()" class="w-full px-4 py-2.5 border border-slate-300 text-gray-700 rounded-lg font-medium hover:bg-white transition-colors">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Breed selector state
    let currentSpecies = null;
    let selectedBreed = '';

    // Open the breed selector modal
    function openBreedModal() {
        const species = document.querySelector('input[name="species"]:checked');
        if (!species) {
            alert('Please select Dog or Cat first.');
            return;
        }
        currentSpecies = species.value;
        document.getElementById('breedModalSearch').value = '';
        renderBreedModal();
        const modal = document.getElementById('breedModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            const searchInput = document.getElementById('breedModalSearch');
            if (searchInput) searchInput.focus();
        }, 50);
    }

    // Close the breed selector modal
    function closeBreedModal() {
        document.getElementById('breedModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Render breed list for the current species
    function renderBreedModal(filter = '') {
        if (!currentSpecies) return;
        const breeds = currentSpecies === 'Cat' ? catBreeds : dogBreeds;
        const quickBreeds = currentSpecies === 'Cat' ? quickCatBreeds : quickDogBreeds;
        const search = filter.trim().toLowerCase();

        const quickWrap = document.getElementById('breedModalQuick');
        const quickChips = document.getElementById('breedModalQuickChips');

        if (search) {
            quickWrap.classList.add('hidden');
        } else {
            quickWrap.classList.remove('hidden');
            const availableQuick = quickBreeds.filter(b => breeds.includes(b));
            quickChips.innerHTML = availableQuick.map(breed => {
                const selected = selectedBreed === breed;
                return `
                    <button type="button" onclick="selectBreed('${breed.replace(/'/g, "\\'")}')"
                            class="px-3 py-1.5 text-sm rounded-full border transition-colors ${selected
                                ? 'bg-emerald-600 text-white border-emerald-600'
                                : 'border-slate-300 text-gray-700 hover:bg-emerald-50 hover:border-emerald-400'}">
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
            html += `<div class="mb-4"><div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 py-1.5"><span class="text-sm font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 border border-emerald-200 rounded-md px-2 py-0.5">${letter}</span></div><div class="space-y-1 mt-1">`;
            groups[letter].forEach((breed) => {
                const selected = selectedBreed === breed;
                html += `
                    <label class="flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors ${selected ? 'bg-emerald-50' : 'hover:bg-white'}" onclick="selectBreed('${breed.replace(/'/g, "\\'")}')">
                        <input type="radio" name="breed_option" value="${breed}" class="sr-only peer" ${selected ? 'checked' : ''}>
                        <span class="ml-3 text-sm pet-breed-label ${selected ? 'text-emerald-800 font-semibold' : 'text-gray-700'}">${breed}</span>
                        ${selected ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>' : ''}
                    </label>`;
            });
            html += `</div></div>`;
        });
        list.innerHTML = html;
    }

    // Filter breed list as user types
    function filterBreedModal() {
        renderBreedModal(document.getElementById('breedModalSearch').value);
    }

    // Select a breed and update the display
    function selectBreed(breed) {
        selectedBreed = breed;
        document.getElementById('selectedBreedText').textContent = breed;
        document.getElementById('breedInput').value = breed;
        document.getElementById('breedInput').dispatchEvent(new Event('change', { bubbles: true }));
        closeBreedModal();
        renderBreedModal();
    }

    // Close modal on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const breedModal = document.getElementById('breedModal');
            if (breedModal && !breedModal.classList.contains('hidden')) {
                closeBreedModal();
            }
        }
    });

    // Preview pet photo on file selection
    function previewPetPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('petPhotoPreview').src = e.target.result;
                document.getElementById('petPhotoPreview').classList.remove('hidden');
                document.getElementById('petPhotoRemoveBtn').classList.remove('hidden');
                document.getElementById('petPhotoUploadBtn').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    // Remove pet photo and reset upload UI
    function removePetPhoto() {
        document.getElementById('pet_photo').value = '';
        document.getElementById('petPhotoPreview').src = '';
        document.getElementById('petPhotoPreview').classList.add('hidden');
        document.getElementById('petPhotoRemoveBtn').classList.add('hidden');
        document.getElementById('petPhotoUploadBtn').classList.remove('hidden');
    }

    // Handle Eye Color "Other" and Heterochromia visibility
    function handleEyeColorChange() {
        const otherWrap = document.getElementById('eyeColorOtherWrap');
        const heteroWrap = document.getElementById('eyeColorHeterochromiaWrap');
        const selected = document.querySelector('input[name="eye_color"]:checked');
        if (!selected) {
            otherWrap.classList.add('hidden');
            heteroWrap.classList.add('hidden');
            return;
        }
        if (selected.value === 'Other') {
            otherWrap.classList.remove('hidden');
        } else {
            otherWrap.classList.add('hidden');
        }
        if (selected.value === 'Heterochromia (Two different colors)') {
            heteroWrap.classList.remove('hidden');
        } else {
            heteroWrap.classList.add('hidden');
        }
    }

    // Toggle pill selection (click again to deselect)
    const pillLastSelected = {};

    function togglePill(radio) {
        const group = radio.name;
        const wasAlreadySelected = pillLastSelected[group] === radio;

        if (wasAlreadySelected) {
            // Deselect the previously selected pill
            radio.checked = false;
            pillLastSelected[group] = null;
            radio.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            // Normal selection — remember which radio is now selected
            pillLastSelected[group] = radio;
        }
    }

    // Initialize pill state from any pre-checked radios (old() Blade values)
    document.querySelectorAll('input[type="radio"][onclick="togglePill(this)"]').forEach(radio => {
        if (radio.checked) {
            pillLastSelected[radio.name] = radio;
        }
    });

    // Handle Left/Right Eye Color "Other" toggle
    function handleEyeSideChange(side) {
        const otherWrap = document.getElementById(`eyeColor${side}OtherWrap`);
        const select = document.getElementById(`eyeColor${side}`);
        if (select.value === 'Other') {
            otherWrap.classList.remove('hidden');
        } else {
            otherWrap.classList.add('hidden');
        }
    }

    // Open the barangay selector modal
    function openBarangayModal() {
        const modal = document.getElementById('barangayModal');
        modal.classList.remove('hidden');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('role', 'dialog');
        document.body.classList.add('overflow-hidden');

        document.getElementById('barangayModalSearch').value = '';
        renderBarangayModal();

        setTimeout(() => {
            const searchInput = document.getElementById('barangayModalSearch');
            if (searchInput) searchInput.focus();
        }, 50);
    }

    // Close the barangay selector modal
    function closeBarangayModal() {
        const modal = document.getElementById('barangayModal');
        modal.classList.add('hidden');
        modal.removeAttribute('aria-modal');
        modal.removeAttribute('role');
        document.body.classList.remove('overflow-hidden');
    }

    // Render the barangay list grouped alphabetically
    function renderBarangayModal(filter = '') {
        const search = filter.trim().toLowerCase();
        const filtered = barangaysData.filter(b => String(b.barangay_name).toLowerCase().includes(search));
        const list = document.getElementById('barangayModalList');
        const empty = document.getElementById('barangayModalEmpty');

        if (filtered.length === 0) {
            list.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');

        // Group by first letter
        const groups = {};
        filtered.forEach(b => {
            const letter = String(b.barangay_name).charAt(0).toUpperCase();
            if (!groups[letter]) groups[letter] = [];
            groups[letter].push(b);
        });

        let html = '';
        Object.keys(groups).sort().forEach(letter => {
            html += `
                <div class="mb-4">
                    <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 py-1.5">
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 border border-emerald-200 rounded-md px-2 py-0.5">${letter}</span>
                    </div>
                    <div class="space-y-1 mt-1">`;
            groups[letter].forEach(b => {
                const selected = document.getElementById('barangayIdInput').value == b.barangay_id;
                html += `
                    <button type="button" onclick="handleBarangaySelect(${b.barangay_id}, '${String(b.barangay_name).replace(/'/g, "\\'")}')"
                            class="w-full flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors text-left ${selected ? 'bg-emerald-50 text-emerald-800 font-semibold' : 'text-gray-700 hover:bg-white'}">
                        ${b.barangay_name}
                    </button>`;
            });
            html += `</div></div>`;
        });

        list.innerHTML = html;
    }

    // Filter the barangay list as the user types
    function filterBarangayModal() {
        renderBarangayModal(document.getElementById('barangayModalSearch').value);
    }

    // Handle barangay selection
    function handleBarangaySelect(id, name) {
        document.getElementById('barangayIdInput').value = id;
        document.getElementById('selectedBarangayText').textContent = name;
        closeBarangayModal();
    }

    // Toggle "Pet doesn't wear any collar/harness" checkbox
    function toggleNoCollarHarness() {
        const checkbox = document.getElementById('noCollarHarness');
        const input = document.getElementById('collar_harness');
        if (!checkbox || !input) return;

        if (checkbox.checked) {
            input.value = 'None';
            input.disabled = true;
            input.classList.add('opacity-50', 'pointer-events-none');
            input.classList.remove('focus:border-primary', 'focus:ring-2', 'focus:ring-primary/20');
        } else {
            input.value = '';
            input.disabled = false;
            input.classList.remove('opacity-50', 'pointer-events-none');
            input.classList.add('focus:border-primary', 'focus:ring-2', 'focus:ring-primary/20');
        }
    }
</script>

<!-- Barangay Selection Modal -->
<div id="barangayModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="barangayModalTitle">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeBarangayModal()"></div>
    <div class="fixed inset-0 flex items-end sm:items-center sm:justify-center p-0 sm:p-4">
        <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="px-5 pt-5 pb-4 border-b border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 18h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                        </svg>
                        <h3 id="barangayModalTitle" class="text-lg font-semibold text-gray-900">Select Barangay</h3>
                    </div>
                    <button type="button" onclick="closeBarangayModal()" class="text-gray-400 hover:text-gray-600 hover:bg-slate-100 rounded-lg p-1.5 transition-colors" aria-label="Close barangay selector">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Search bar -->
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="barangayModalSearch" placeholder="Search barangay..." onkeyup="filterBarangayModal()"
                           class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" autocomplete="off">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto min-h-[360px]">
                <div class="px-5 pt-4 pb-4">
                    <!-- Alphabetical List -->
                    <div id="barangayModalList"></div>

                    <!-- Empty search state -->
                    <div id="barangayModalEmpty" class="hidden text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-xs text-gray-700">No barangays match your search.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-4 border-t border-slate-200 bg-white">
                <button type="button" onclick="closeBarangayModal()" class="w-full px-4 py-2.5 border border-slate-300 text-gray-700 rounded-lg font-medium hover:bg-white transition-colors">Cancel</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
