<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application - Dasmariñas City Veterinary Services</title>
    
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
                        },
                        primary: {
                            DEFAULT: '#059669',
                            light: '#065f46',
                            dark: '#047857',
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
    @php
    $isEdit = isset($application) && $application instanceof \App\Models\AdoptionApplication;
    $isView = isset($isView) && $isView === true;
    $formAction = $isEdit && ! $isView ? route('adoption.form.update', $application) : '#';
    $formMethod = $isEdit && ! $isView ? 'PUT' : 'POST';
    $submitLabel = $isEdit && ! $isView ? 'Update Application' : ($isView ? 'View Mode' : 'Submit Application');
    $pageTitle = $isView ? 'View Adoption Application' : ($isEdit ? 'Edit Adoption Application' : 'Adoption Application');
    $appAltContact = $isEdit ? ($application->alternate_contact ?? []) : [];
    $appQuestionnaire = $isEdit ? ($application->questionnaire ?? []) : [];
    $appHomePhotos = $appQuestionnaire['home_photos'] ?? [];
    $readonlyClass = $isView ? ' bg-gray-100' : '';
    $readonlyAttr = $isView ? ' readonly' : '';
    $disabledAttr = $isView ? ' disabled' : '';

    $backwardCompatibilityMapping = [
        'building_type' => 'housing_type',
        'rent' => 'housing_ownership',
        'live_with' => 'household_members',
    ];

    foreach ($backwardCompatibilityMapping as $oldKey => $newKey) {
        if (isset($appQuestionnaire[$oldKey]) && empty($appQuestionnaire[$newKey])) {
            $appQuestionnaire[$newKey] = $appQuestionnaire[$oldKey];
        }
    }
    @endphp

    <!-- Page Title -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">{{ $pageTitle }}</h2>
        <p class="text-gray-700 text-xs mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-8 space-y-6">

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

        <!-- Form Card with Progress Steps -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
            <!-- Progress Header -->
            <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h4 class="text-sm font-semibold text-white">ADOPTION PROGRESS</h4>
                </div>
                <span id="stepIndicatorText" class="text-sm text-emerald-300 font-medium">Step 1 of 5 — Alternate Contact</span>
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between gap-2">
                    <button type="button" onclick="goToStep(1)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="1">
                        <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 border-emerald-600 bg-emerald-600 text-white transition-colors flex-shrink-0" data-step="1">1</span>
                        <span class="hidden sm:block min-w-0">
                            <span class="step-title block text-sm font-semibold truncate">Alternate Contact</span>
                            <span class="step-subtitle block text-xs text-gray-700 truncate">Emergency contact person</span>
                        </span>
                    </button>
                    <div class="flex-1 hidden sm:flex items-center pt-4">
                        <div class="w-full h-0.5 bg-slate-200"></div>
                    </div>
                    <button type="button" onclick="goToStep(2)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="2">
                        <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-300 text-gray-400 transition-colors flex-shrink-0" data-step="2">2</span>
                        <span class="hidden sm:block min-w-0">
                            <span class="step-title block text-sm font-semibold truncate">Adoption Questionnaire</span>
                            <span class="step-subtitle block text-xs text-gray-700 truncate">Household & readiness</span>
                        </span>
                    </button>
                    <div class="flex-1 hidden sm:flex items-center pt-4">
                        <div class="w-full h-0.5 bg-slate-200"></div>
                    </div>
                    <button type="button" onclick="goToStep(3)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="3">
                        <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-300 text-gray-400 transition-colors flex-shrink-0" data-step="3">3</span>
                        <span class="hidden sm:block min-w-0">
                            <span class="step-title block text-sm font-semibold truncate">Home Photos</span>
                            <span class="step-subtitle block text-xs text-gray-700 truncate">Property images</span>
                        </span>
                    </button>
                    <div class="flex-1 hidden sm:flex items-center pt-4">
                        <div class="w-full h-0.5 bg-slate-200"></div>
                    </div>
                    <button type="button" onclick="goToStep(4)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="4">
                        <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-300 text-gray-400 transition-colors flex-shrink-0" data-step="4">4</span>
                        <span class="hidden sm:block min-w-0">
                            <span class="step-title block text-sm font-semibold truncate">Upload Valid ID</span>
                            <span class="step-subtitle block text-xs text-gray-700 truncate">Identification document</span>
                        </span>
                    </button>
                    <div class="flex-1 hidden sm:flex items-center pt-4">
                        <div class="w-full h-0.5 bg-slate-200"></div>
                    </div>
                    <button type="button" onclick="goToStep(5)" class="step-item flex-1 flex items-center gap-3 text-left" data-step="5">
                        <span class="step-circle w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 border-gray-300 text-gray-400 transition-colors flex-shrink-0" data-step="5">5</span>
                        <span class="hidden sm:block min-w-0">
                            <span class="step-title block text-sm font-semibold truncate">Appointment Setup</span>
                            <span class="step-subtitle block text-xs text-gray-700 truncate">Schedule appointment</span>
                        </span>
                    </button>
                </div>
                <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div id="progressBar" class="h-full bg-emerald-600 transition-all duration-300" style="width: 20%"></div>
                </div>
            </div>
        </div>

            <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" id="adoptionForm" @if($isView) onsubmit="return false;" @endif>
                @csrf
                @if($isEdit && ! $isView)
                    @method('PUT')
                @endif

                <!-- PART 1: ALTERNATE CONTACT -->
                <div id="part1" class="form-part">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Alternate Contact Person</h4>
                            </div>
                            <span class="text-xs text-emerald-300 font-medium">Optional</span>
                        </div>
                        <div class="p-6 space-y-6">

                            @if($isView && empty($appAltContact))
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                                    <p class="text-sm text-gray-600">No alternate contact provided.</p>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" id="noAlternateContact" onchange="toggleAlternateContact(this)" {{ $disabledAttr }}
                                           class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">I do not have an alternate contact person</span>
                                </label>
                            </div>

                            <div id="alternateContactFields">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <!-- Name -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Name <span class="text-gray-500 text-xs">(First name and Last name)</span></label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <input type="text" name="alt_first_name" placeholder="First Name"
                                                   value="{{ old('alt_first_name', $appAltContact['first_name'] ?? '') }}"
                                                   {{ $disabledAttr }}
                                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all{{ $readonlyClass }}">
                                            <input type="text" name="alt_last_name" placeholder="Last Name"
                                                   value="{{ old('alt_last_name', $appAltContact['last_name'] ?? '') }}"
                                                   {{ $disabledAttr }}
                                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all{{ $readonlyClass }}">
                                        </div>
                                    </div>

                                    <!-- Relationship -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Relationship</label>
                                        <input type="text" name="alt_relationship" placeholder="Relationship to you"
                                               value="{{ old('alt_relationship', $appAltContact['relationship'] ?? '') }}"
                                               {{ $disabledAttr }}
                                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all{{ $readonlyClass }}">
                                    </div>

                                    <!-- Mobile Number -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Mobile Number</label>
                                        <div class="flex">
                                            <span class="inline-flex items-center px-3.5 py-2.5 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-gray-600 text-sm">
                                                +63
                                            </span>
                                            <input type="tel" name="alt_phone" placeholder="943 210 2012" maxlength="14" oninput="formatPhone(this)"
                                                   value="{{ old('alt_phone', $appAltContact['phone'] ?? '') }}"
                                                   {{ $disabledAttr }}
                                                   class="flex-1 px-3.5 py-2.5 rounded-r-lg border border-slate-300 bg-slate-50 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all{{ $readonlyClass }}">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Email</label>
                                        <input type="email" name="alt_email" placeholder="name@example.com"
                                               value="{{ old('alt_email', $appAltContact['email'] ?? '') }}"
                                               {{ $disabledAttr }}
                                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all{{ $readonlyClass }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8 pt-6 border-t border-slate-200">
                                <button type="button" onclick="goToStep(1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                <button type="button" onclick="goToStep(2)" class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                    Next: Adoption Questionnaire
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PART 2: ADOPTION QUESTIONNAIRE -->
                <div id="part2" class="form-part hidden">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Adoption Questionnaire</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <p class="text-sm text-gray-600 italic mb-6">
                                Please answer the questions below to help us understand your household and readiness for adoption.
                            </p>

                            <!-- Have you adopted before? (Moved from Applicant Information) -->
                    <div class="border border-emerald-200 rounded-lg p-4 bg-emerald-50/60 mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium">
                                Have you adopted before? <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="flex gap-4 mt-2 max-w-md">
                            <label class="inline-flex items-center">
                                <input type="radio" name="adopted_before" value="yes" class="text-emerald-600" {{ old('adopted_before', $appQuestionnaire['adopted_before'] ?? $application->adopted_before ?? '') === 'yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="adopted_before" value="no" class="text-emerald-600" {{ old('adopted_before', $appQuestionnaire['adopted_before'] ?? $application->adopted_before ?? '') === 'no' ? 'checked' : '' }} {{ $disabledAttr }}>
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Pet Selector Highlight -->
                        <div class="border border-emerald-200 rounded-lg p-4 bg-emerald-50/60">
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium">
                                    Select Pet to Adopt <span class="text-red-500">*</span>
                                </label>
                                <button type="button" onclick="openAdoptionPetModal()" 
                                        class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Select Pet
                                </button>
                            </div>
                            
                            <!-- Display selected pet cards here -->
                            <div id="selectedAdoptionPetsList" class="grid md:grid-cols-2 gap-4">
                                <!-- Empty state -->
                                <div id="noAdoptionPetsSelected" class="col-span-2 bg-white border border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-sm">No pets selected yet. Click "Select Pet" to choose a pet for adoption.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 1: Housing & Living Arrangement -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-gray-50/50">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Housing & Living Arrangement</h4>
                            <div class="space-y-4">
                                <!-- Type of Housing -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Type of Housing <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_type" value="House" class="text-emerald-600" {{ old('housing_type', $appQuestionnaire['housing_type'] ?? '') === 'House' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">House</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_type" value="Apartment" class="text-emerald-600" {{ old('housing_type', $appQuestionnaire['housing_type'] ?? '') === 'Apartment' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Apartment</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_type" value="Condo" class="text-emerald-600" {{ old('housing_type', $appQuestionnaire['housing_type'] ?? '') === 'Condo' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Condo</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_type" value="Townhouse" class="text-emerald-600" {{ old('housing_type', $appQuestionnaire['housing_type'] ?? '') === 'Townhouse' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Townhouse</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_type" value="Other" class="text-emerald-600" {{ old('housing_type', $appQuestionnaire['housing_type'] ?? '') === 'Other' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Other</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Housing Ownership -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Housing Ownership <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_ownership" value="Own" class="text-emerald-600" {{ old('housing_ownership', $appQuestionnaire['housing_ownership'] ?? '') === 'Own' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Own</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_ownership" value="Rent (Landlord allows pets)" class="text-emerald-600" {{ old('housing_ownership', $appQuestionnaire['housing_ownership'] ?? '') === 'Rent (Landlord allows pets)' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Rent (Landlord allows pets)</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="housing_ownership" value="Rent (Written permission pending)" class="text-emerald-600" {{ old('housing_ownership', $appQuestionnaire['housing_ownership'] ?? '') === 'Rent (Written permission pending)' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Rent (Written permission pending)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Household Members -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Who lives in your household? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        @php
                                            $householdMembers = old('household_members', $appQuestionnaire['household_members'] ?? []);
                                            if (!is_array($householdMembers)) $householdMembers = [];
                                        @endphp
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="household_members[]" value="Living alone" class="text-emerald-600" {{ in_array('Living alone', $householdMembers) ? 'checked' : '' }} {{ $disabledAttr }} onchange="toggleHouseholdMembers(this)">
                                            <span class="ml-2">Living alone</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="household_members[]" value="Spouse or Partner" class="text-emerald-600" {{ in_array('Spouse or Partner', $householdMembers) ? 'checked' : '' }} {{ $disabledAttr }} onchange="toggleHouseholdMembers(this)">
                                            <span class="ml-2">Spouse or Partner</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="household_members[]" value="Children under 18" class="text-emerald-600" {{ in_array('Children under 18', $householdMembers) ? 'checked' : '' }} {{ $disabledAttr }} onchange="toggleHouseholdMembers(this)">
                                            <span class="ml-2">Children under 18</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="household_members[]" value="Adults or Relatives" class="text-emerald-600" {{ in_array('Adults or Relatives', $householdMembers) ? 'checked' : '' }} {{ $disabledAttr }} onchange="toggleHouseholdMembers(this)">
                                            <span class="ml-2">Adults or Relatives</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pet Allergies -->
                                <div id="petAllergiesSection">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Are any household members allergic to animals? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-w-2xl">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="pet_allergies" value="Yes" class="text-emerald-600" {{ old('pet_allergies', $appQuestionnaire['pet_allergies'] ?? '') === 'Yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="pet_allergies" value="No" class="text-emerald-600" {{ old('pet_allergies', $appQuestionnaire['pet_allergies'] ?? '') === 'No' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="pet_allergies" value="Unknown" class="text-emerald-600" {{ old('pet_allergies', $appQuestionnaire['pet_allergies'] ?? '') === 'Unknown' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Unknown</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Household Support & Care Plan -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-gray-50/50">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Household Support & Care Plan</h4>
                            <div class="space-y-4">
                                <!-- Household Agreement -->
                                <div id="householdAgreementSection">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Does everyone in your household agree to adopt this pet? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 max-w-md">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="household_agreement" value="Yes" class="text-emerald-600" {{ old('household_agreement', $appQuestionnaire['household_agreement'] ?? '') === 'Yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="household_agreement" value="No" class="text-emerald-600" {{ old('household_agreement', $appQuestionnaire['household_agreement'] ?? '') === 'No' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Primary Caregiver -->
                                <div id="primaryCaregiverSection">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Who will be primarily responsible for feeding, care, and vet expenses? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="primary_caregiver" value="Myself" class="text-emerald-600" {{ old('primary_caregiver', $appQuestionnaire['primary_caregiver'] ?? '') === 'Myself' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Myself</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="primary_caregiver" value="Myself & Spouse/Partner" class="text-emerald-600" {{ old('primary_caregiver', $appQuestionnaire['primary_caregiver'] ?? '') === 'Myself & Spouse/Partner' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Myself & Spouse/Partner</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="primary_caregiver" value="Parents / Family" class="text-emerald-600" {{ old('primary_caregiver', $appQuestionnaire['primary_caregiver'] ?? '') === 'Parents / Family' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Parents / Family</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Time Alone -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        How many hours will the pet be left alone on a typical workday? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="time_alone" value="Less than 4 hours" class="text-emerald-600" {{ old('time_alone', $appQuestionnaire['time_alone'] ?? '') === 'Less than 4 hours' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Less than 4 hours</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="time_alone" value="4 – 8 hours" class="text-emerald-600" {{ old('time_alone', $appQuestionnaire['time_alone'] ?? '') === '4 – 8 hours' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">4 – 8 hours</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="time_alone" value="More than 8 hours" class="text-emerald-600" {{ old('time_alone', $appQuestionnaire['time_alone'] ?? '') === 'More than 8 hours' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">More than 8 hours</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Relocation Plan -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        What will happen to the pet if you move to a new residence? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 max-w-md">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="relocation_plan" value="Bring the pet with me" class="text-emerald-600" {{ old('relocation_plan', $appQuestionnaire['relocation_plan'] ?? '') === 'Bring the pet with me' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Bring the pet with me</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="relocation_plan" value="Leave under care of family" class="text-emerald-600" {{ old('relocation_plan', $appQuestionnaire['relocation_plan'] ?? '') === 'Leave under care of family' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2 whitespace-nowrap">Leave under care of family</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="relocation_plan" value="Return to clinic" class="text-emerald-600" {{ old('relocation_plan', $appQuestionnaire['relocation_plan'] ?? '') === 'Return to clinic' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Return to clinic</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="relocation_plan" value="Rehome responsibly" class="text-emerald-600" {{ old('relocation_plan', $appQuestionnaire['relocation_plan'] ?? '') === 'Rehome responsibly' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Rehome responsibly</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Pet Experience & Commitment -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-gray-50/50">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Pet Experience & Commitment</h4>
                            <div class="space-y-4">
                                <!-- Current Pets -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Do you currently have other pets in your home? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 max-w-md">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="current_pets" value="Yes" class="text-emerald-600" {{ old('current_pets', $appQuestionnaire['current_pets'] ?? '') === 'Yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="current_pets" value="No" class="text-emerald-600" {{ old('current_pets', $appQuestionnaire['current_pets'] ?? '') === 'No' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Past Pet Experience -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Have you owned pets in the past 5 years? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 max-w-md">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="past_pet_experience" value="Yes" class="text-emerald-600" {{ old('past_pet_experience', $appQuestionnaire['past_pet_experience'] ?? '') === 'Yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="past_pet_experience" value="No" class="text-emerald-600" {{ old('past_pet_experience', $appQuestionnaire['past_pet_experience'] ?? '') === 'No' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Vaccination & Spay/Neuter Stance -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Are you willing to keep this pet updated on vaccines and spay/neuter (kapon)?
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 max-w-md">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vaccination_stance" value="Yes" class="text-emerald-600" {{ old('vaccination_stance', $appQuestionnaire['vaccination_stance'] ?? '') === 'Yes' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vaccination_stance" value="No" class="text-emerald-600" {{ old('vaccination_stance', $appQuestionnaire['vaccination_stance'] ?? '') === 'No' ? 'checked' : '' }} {{ $disabledAttr }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8 pt-6 border-t border-slate-200">
                                <button type="button" onclick="goToStep(1)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                <button type="button" onclick="goToStep(3)" class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                    Next: Home Photos
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Pet Selection Modal -->
                <div id="adoptionPetModal" class="fixed inset-0 z-50 hidden">
                    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeAdoptionPetModal()"></div>
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Select Pet for Adoption</h3>
                                <button type="button" onclick="closeAdoptionPetModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-6 py-4 overflow-y-auto max-h-[60vh]">
                                @if($adoptionPets->isEmpty())
                                    <div class="text-center py-8">
                                        <p class="text-gray-500 mb-4">No pets available for adoption at the moment.</p>
                                        <a href="{{ url('/adoption') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                            Go back to adoption page
                                        </a>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 mb-4">Select up to 2 pets for adoption:</p>
                                    <div class="space-y-3" id="adoptionPetSelectionList">
                                        @foreach($adoptionPets as $pet)
                                            <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 transition-colors pet-selection-card" data-pet-id="{{ $pet->pet_id }}">
                                                <input type="checkbox" name="selected_adoption_pets[]" value="{{ $pet->pet_id }}" 
                                                       class="mt-1 w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 adoption-pet-checkbox"
                                                       onchange="toggleAdoptionPetSelection(this)">
                                                <div class="ml-3 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <span class="font-semibold text-gray-900 pet-name">{{ $pet->pet_name }}</span>
                                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">{{ ucfirst($pet->species) }}</span>
                                                    </div>
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <div>Breed: {{ $pet->breed ?? 'Unknown' }}</div>
                                                        <div class="text-gray-600">Gender: {{ ucfirst($pet->gender) }}</div>
                                                        <div class="text-gray-600">Age: {{ $pet->age }}</div>
                                                    </div>
                                                </div>
                                                @if(!empty($pet->image))
                                                <div class="ml-2 flex-shrink-0">
                                                    <img src="{{ asset($pet->image) }}" alt="{{ $pet->pet_name }}" class="w-12 h-12 rounded-full object-cover">
                                                </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Selected: <span id="adoptionSelectedCount">0</span> pet(s) (Max: 2)</span>
                                    <button type="button" onclick="confirmAdoptionPetSelection()" 
                                            class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                        Confirm Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Pet data from server
                    const adoptionPetsData = @json($adoptionPets);
                    const assetBaseUrl = "{{ asset('') }}";
                    
                    let selectedAdoptionPets = [];

                    function openAdoptionPetModal() {
                        // Check if no pets available
                        if (adoptionPetsData.length === 0) {
                            document.getElementById('adoptionPetModal').classList.remove('hidden');
                            document.getElementById('adoptionPetSelectionList').innerHTML = `
                                <div class="text-center py-8 px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-600 mb-4">No pets available for adoption at the moment.</p>
                                    <a href="{{ url('/adoption') }}" class="inline-block bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                        Go back to adoption page
                                    </a>
                                </div>
                            `;
                            // Hide the footer with confirm button when no pets
                            document.querySelector('#adoptionPetModal .bg-gray-50').classList.add('hidden');
                            document.body.style.overflow = 'hidden';
                            return;
                        }
                        
                        // Show normal modal with pets
                        document.getElementById('adoptionPetModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeAdoptionPetModal() {
                        document.getElementById('adoptionPetModal').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    function toggleAdoptionPetSelection(checkbox) {
                        const petId = String(checkbox.value);
                        if (checkbox.checked) {
                            // Check if max limit reached (2 pets)
                            if (selectedAdoptionPets.length >= 2) {
                                checkbox.checked = false;
                                showAdoptionPetLimitModal();
                                return;
                            }
                            if (!selectedAdoptionPets.includes(petId)) {
                                selectedAdoptionPets.push(petId);
                            }
                        } else {
                            selectedAdoptionPets = selectedAdoptionPets.filter(id => String(id) !== petId);
                        }
                        updateAdoptionSelectedCount();
                    }

                    function showAdoptionPetLimitModal() {
                        const modalHtml = `
                            <div id="adoptionPetLimitModal" class="fixed inset-0 z-50">
                                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                                <div class="fixed inset-0 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pet Limit Reached</h3>
                                            <p class="text-gray-600 mb-6">You can select up to 2 pets for adoption per application.</p>
                                            <button type="button" onclick="closeAdoptionPetLimitModal()" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
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

                    function closeAdoptionPetLimitModal() {
                        const modal = document.getElementById('adoptionPetLimitModal');
                        if (modal) {
                            modal.remove();
                        }
                        document.body.style.overflow = 'auto';
                    }

                    function updateAdoptionSelectedCount() {
                        document.getElementById('adoptionSelectedCount').textContent = selectedAdoptionPets.length;
                    }

                    function confirmAdoptionPetSelection() {
                        const container = document.getElementById('selectedAdoptionPetsList');
                        const noPetsMessage = document.getElementById('noAdoptionPetsSelected');
                        const modalFooter = document.querySelector('#adoptionPetModal .bg-gray-50');

                        // Restore footer if it was hidden
                        if (modalFooter) {
                            modalFooter.classList.remove('hidden');
                        }

                        if (selectedAdoptionPets.length > 0) {
                            if (noPetsMessage) {
                                noPetsMessage.remove();
                            }
                        }

                        // Clear current selections and rebuild
                        container.innerHTML = '';

                        if (selectedAdoptionPets.length === 0) {
                            container.innerHTML = `
                                <div id="noAdoptionPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500">No pets selected yet. Click "Select Pet" to choose a pet for adoption.</p>
                                </div>
                            `;
                            closeAdoptionPetModal();
                            return;
                        }

                        selectedAdoptionPets.forEach(petId => {
                            const pet = adoptionPetsData.find(p => String(p.pet_id) === String(petId));
                            if (pet) {
                                // Determine image source
                                let imageHtml = '';
                                if (pet.image) {
                                    const imageSrc = pet.image.startsWith('http') ? pet.image : assetBaseUrl + pet.image;
                                    imageHtml = `<img src="${imageSrc}" alt="${pet.pet_name}" class="w-12 h-12 rounded-full object-cover">`;
                                } else {
                                    imageHtml = `<div class="w-12 h-12 rounded-full bg-emerald-600/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                            <p class="font-semibold text-gray-900">${pet.pet_name || 'Unknown'}</p>
                                            <p class="text-xs text-gray-500">${speciesDisplay} • ${pet.breed || 'Unknown'}</p>
                                            <p class="text-xs text-gray-600 mt-1">Gender: ${pet.gender || 'Unknown'} • Age: ${pet.age || 'Unknown'}</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeAdoptionPet(${pet.pet_id})" class="text-red-500 hover:text-red-700 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                `;
                                container.appendChild(petCard);
                            }
                        });

                        closeAdoptionPetModal();
                    }

                    function removeAdoptionPet(petId) {
                        // Remove from selectedAdoptionPets array (convert to string for comparison)
                        selectedAdoptionPets = selectedAdoptionPets.filter(id => String(id) !== String(petId));
                        
                        // Uncheck the checkbox in modal
                        const checkbox = document.querySelector(`#adoptionPetSelectionList input[value="${petId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                        
                        // Rebuild the display
                        confirmAdoptionPetSelection();
                        updateAdoptionSelectedCount();
                    }

                    const homePhotoState = {
                        primaryLivingArea: [],
                        outdoorYardGate: []
                    };

                    let validIdState = {
                        file: null,
                        existingPath: null
                    };

                    function getPhotoItem(file, existingPath) {
                        return { file, existingPath };
                    }

                    function renderPhotoPreview(containerId, items, label) {
                        const container = document.getElementById(containerId);
                        if (!container) return;

                        container.innerHTML = '';

                        if (!items.length) {
                            container.innerHTML = '<p class="text-xs text-gray-500 mt-1">No photos selected</p>';
                            return;
                        }

                        items.forEach((item, index) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const card = document.createElement('div');
                                card.className = 'relative';
                                card.innerHTML = `
                                    <img src="${item.existingPath ? '{{ asset('storage/') }}/' + item.existingPath : e.target.result}" 
                                         alt="${label}" 
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                    <button type="button" 
                                            onclick="removePhoto('${containerId}', ${index})" 
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition-colors">
                                        ×
                                    </button>
                                    <p class="text-xs text-gray-500 mt-1">${item.existingPath ? 'Current photo' : 'Selected photo'}</p>
                                `;
                                container.appendChild(card);
                            };
                            reader.readAsDataURL(item.file);
                        });
                    }

                    function removePhoto(containerId, index) {
                        const stateKey = containerId === 'primaryLivingAreaPreview' ? 'primaryLivingArea' : 'outdoorYardGate';
                        const items = homePhotoState[stateKey];
                        
                        if (index >= 0 && index < items.length) {
                            items.splice(index, 1);
                            renderPhotoPreview(containerId, items, stateKey === 'primaryLivingArea' ? 'Primary living area' : 'Outdoor yard gate');
                            syncPhotoInput(containerId, items);
                        }
                    }

                    function syncPhotoInput(containerId, items) {
                        const inputName = containerId === 'primaryLivingAreaPreview' ? 'primary_living_area[]' : 'outdoor_yard_gate[]';
                        const input = document.querySelector(`input[name="${inputName}"]`);
                        if (!input) return;

                        const dataTransfer = new DataTransfer();
                        items.forEach(item => {
                            if (item.file) {
                                dataTransfer.items.add(item.file);
                            }
                        });

                        const freshInput = document.createElement('input');
                        freshInput.type = 'file';
                        freshInput.name = input.name;
                        freshInput.accept = 'image/*';
                        freshInput.multiple = true;
                        freshInput.className = input.className;
                        freshInput.files = dataTransfer.files;
                        freshInput.onchange = function() {
                            handlePhotoSelect(this, containerId, 3);
                        };
                        input.parentNode.replaceChild(freshInput, input);
                    }

                    function handlePhotoSelect(input, containerId, maxCount) {
                        const stateKey = containerId === 'primaryLivingAreaPreview' ? 'primaryLivingArea' : 'outdoorYardGate';
                        const newFiles = Array.from(input.files);
                        const totalCount = homePhotoState[stateKey].length + newFiles.length;

                        if (totalCount > maxCount) {
                            alert(`Only ${maxCount} photos are allowed`);
                            input.value = '';
                            return;
                        }

                        newFiles.forEach(file => {
                            homePhotoState[stateKey].push(getPhotoItem(file, null));
                        });

                        renderPhotoPreview(containerId, homePhotoState[stateKey], stateKey === 'primaryLivingArea' ? 'Primary living area' : 'Outdoor yard gate');
                        
                        const dataTransfer = new DataTransfer();
                        homePhotoState[stateKey].forEach(item => {
                            if (item.file) {
                                dataTransfer.items.add(item.file);
                            }
                        });

                        const freshInput = document.createElement('input');
                        freshInput.type = 'file';
                        freshInput.name = input.name;
                        freshInput.accept = 'image/*';
                        freshInput.multiple = true;
                        freshInput.className = input.className;
                        freshInput.files = dataTransfer.files;
                        freshInput.onchange = function() {
                            handlePhotoSelect(this, containerId, maxCount);
                        };
                        input.parentNode.replaceChild(freshInput, input);
                    }

                    function handleValidIdSelect(input) {
                        const container = document.getElementById('validIdPreview');
                        if (!container || !input.files.length) return;

                        const file = input.files[0];
                        validIdState.file = file;
                        validIdState.existingPath = null;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            container.innerHTML = `
                                <div class="relative inline-block">
                                    <img src="${e.target.result}" alt="Valid ID" class="max-w-xs max-h-48 object-contain border border-gray-200 rounded-lg">
                                    <button type="button" 
                                            onclick="removeValidId()" 
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition-colors">
                                        ×
                                    </button>
                                    <p class="text-xs text-gray-500 mt-1">Selected valid ID</p>
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        const freshInput = document.createElement('input');
                        freshInput.type = 'file';
                        freshInput.name = input.name;
                        freshInput.accept = 'image/*';
                        freshInput.className = input.className;
                        freshInput.files = dataTransfer.files;
                        freshInput.onchange = function() {
                            handleValidIdSelect(this);
                        };
                        input.parentNode.replaceChild(freshInput, input);
                    }

                    function removeValidId() {
                        validIdState = { file: null, existingPath: null };
                        const container = document.getElementById('validIdPreview');
                        if (container) {
                            container.innerHTML = '';
                        }
                    }

                    // Close modal on escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeAdoptionPetModal();
                        }
                    });
                </script>

                <!-- PART 3: HOME PHOTOS -->
                <div id="part3" class="form-part hidden">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Home Photos</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <p class="text-sm text-gray-600 italic mb-4">
                                Please attach 2–3 photos showing where the pet will sleep, play, and live (e.g., living room, yard, or balcony).
                            </p>

                            <div class="space-y-6">
                        <!-- Primary Living Area -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-gray-50/50">
                            <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                Primary Living Area <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-2">Upload 1–3 photos of living room, indoor area, or sleeping area</p>
                            <input type="file" name="primary_living_area[]" accept="image/*" multiple
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   onchange="handlePhotoSelect(this, 'primaryLivingAreaPreview', 3)">
                            <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb per photo</p>

                            <div id="primaryLivingAreaPreview" class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3">
                            </div>
                        </div>

                        <!-- Outdoor / Yard / Gate Area -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-gray-50/50">
                            <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                Outdoor / Yard / Gate Area <span class="text-gray-500">(Optional)</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-2">Photos of yard, balcony, or front gate if applicable</p>
                            <input type="file" name="outdoor_yard_gate[]" accept="image/*" multiple
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   onchange="handlePhotoSelect(this, 'outdoorYardGatePreview', 3)">
                            <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb per photo</p>

                            <div id="outdoorYardGatePreview" class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3">
                            </div>
                        </div>
                    </div>

                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8 pt-6 border-t border-slate-200">
                                <button type="button" onclick="goToStep(2)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                <button type="button" onclick="goToStep(4)" class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                    Next: Upload Valid ID
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PART 4: UPLOAD VALID ID -->
                <div id="part4" class="form-part hidden">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Upload Valid ID</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Upload a valid ID <span class="text-red-500">*</span></label>
                                <input type="file" id="validIdInput" name="valid_id" accept="image/*"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                       onchange="handleValidIdSelect(this)">
                                <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb</p>

                                <div id="validIdPreview" class="mt-3">
                                    @if($isEdit && !empty($application->valid_id_path))
                                        @php
                                            $validIdPath = $application->valid_id_path;
                                            $isPdf = str_contains(strtolower($validIdPath), '.pdf');
                                        @endphp
                                        <div class="relative inline-block" data-existing-path="{{ $validIdPath }}">
                                            @if($isPdf)
                                                <a href="{{ asset('storage/' . $validIdPath) }}" target="_blank" class="block">
                                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex items-center gap-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0014.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-700">Valid ID Document</p>
                                                            <p class="text-xs text-gray-500">PDF - Click to view</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $validIdPath) }}" alt="Valid ID" class="max-w-xs max-h-48 object-contain border border-gray-200 rounded-lg">
                                                <p class="text-xs text-gray-500 mt-1">Current valid ID</p>
                                            @endif
                                            <button type="button" 
                                                    onclick="removeValidId()" 
                                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition-colors">
                                                ×
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8 pt-6 border-t border-slate-200">
                                <button type="button" onclick="goToStep(3)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                <button type="button" onclick="goToStep(5)" class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                    Next: Appointment Setup
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PART 5: APPOINTMENT SETUP -->
                <div id="part5" class="form-part hidden">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Appointment Setup</h4>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <div class="space-y-6">
                                <!-- Appointment Slot Picker -->
                                <div id="scheduleInterviewField" class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Schedule Appointment</h4>
                            <p class="text-sm text-gray-500 mb-4">
                                Select a date and time for your adoption appointment.
                            </p>
                            @if($isView)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-600">
                                        <strong>Selected Date:</strong> {{ $application->appointment_date ? \Carbon\Carbon::parse($application->appointment_date)->format('F d, Y') : 'Not set' }}<br>
                                        <strong>Selected Time:</strong> {{ $application->appointment_time ? \Carbon\Carbon::createFromFormat('H:i:s', $application->appointment_time)->format('h:i A') : 'Not set' }}
                                    </p>
                                </div>
                            @else
                                @include('components.appointment-slot-picker', [
                                    'serviceType' => 'adoption_interview',
                                    'fieldName' => 'interview'
                                ])
                            @endif
                        </div>
                    </div>

                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8 pt-6 border-t border-slate-200">
                                <button type="button" onclick="goToStep(4)" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors w-full sm:w-auto justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Previous
                                </button>
                                @if($isView)
                                    <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                        Back to Dashboard
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </a>
                                @else
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-2 px-10 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg w-full sm:w-auto">
                                        {{ $submitLabel }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            
                            <!-- Back to Adoption Page Link -->
                            <div class="text-center mt-6">
                                <a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-emerald-600 transition-colors">
                                    ← Back to Adoption Page
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <div class="lg:sticky lg:top-20 space-y-6">
                <!-- Applicant Information Card -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">APPLICANT INFORMATION</h4>
                        </div>
                        <span class="text-sm text-emerald-300">Read-Only</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm text-gray-700 mb-1">Name</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $petOwner->first_name ?? '' }} {{ $petOwner->last_name ?? '' }}</p>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm text-gray-700">Email</p>
                                    <p class="text-sm text-gray-900 truncate">{{ $user->email ?? '' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 00-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 011.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm text-gray-700">Mobile Number</p>
                                    <p class="text-sm text-gray-900">+63 {{ $petOwner->phone_number ?? '' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 002 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm text-gray-700">Alternate Mobile Number</p>
                                    <p class="text-sm text-gray-900">+63 {{ $petOwner->alternate_phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-sm text-gray-700">Address</p>
                                    <p class="text-sm text-gray-900">{{ $petOwner->address->block_lot_phase ?? '' }}, {{ $petOwner->address->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? '' }}, Dasmariñas City</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Format phone number with automatic spacing (3 3 4)
    function formatPhone(input) {
        let value = input.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 0) {
            // Format as XXX XXX XXXX
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.substring(0, 3) + ' ' + value.substring(3);
            } else {
                value = value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
            }
        }
        input.value = value;
    }

    function toggleAlternateContact(checkbox) {
        const fieldsContainer = document.getElementById('alternateContactFields');
        const inputs = fieldsContainer ? fieldsContainer.querySelectorAll('input') : [];
        
        if (checkbox.checked) {
            inputs.forEach(input => {
                input.value = '';
                input.disabled = true;
            });
            if (fieldsContainer) {
                fieldsContainer.classList.add('opacity-50', 'pointer-events-none');
            }
        } else {
            inputs.forEach(input => {
                input.disabled = false;
            });
            if (fieldsContainer) {
                fieldsContainer.classList.remove('opacity-50', 'pointer-events-none');
            }
        }
    }

    function toggleHouseholdMembers(checkbox) {
        const container = checkbox.closest('.flex');
        if (!container) return;
        
        const livingAlone = container.querySelector('input[type="checkbox"][value="Living alone"]');
        const otherCheckboxes = container.querySelectorAll('input[type="checkbox"]:not([value="Living alone"])');
        const caregiverSection = document.getElementById('primaryCaregiverSection');
        const caregiverRadios = caregiverSection ? caregiverSection.querySelectorAll('input[type="radio"]') : [];
        const agreementSection = document.getElementById('householdAgreementSection');
        const agreementRadios = agreementSection ? agreementSection.querySelectorAll('input[type="radio"]') : [];
        const allergiesSection = document.getElementById('petAllergiesSection');
        const allergiesRadios = allergiesSection ? allergiesSection.querySelectorAll('input[type="radio"]') : [];
        
        if (checkbox.value === 'Living alone') {
            if (checkbox.checked) {
                otherCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                    cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                });
                
                const myselfRadio = caregiverSection ? caregiverSection.querySelector('input[type="radio"][value="Myself"]') : null;
                if (myselfRadio) {
                    myselfRadio.checked = true;
                }
                
                caregiverRadios.forEach(radio => {
                    if (radio.value !== 'Myself') {
                        radio.disabled = true;
                        radio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
                
                const yesAgreementRadio = agreementSection ? agreementSection.querySelector('input[type="radio"][value="Yes"]') : null;
                if (yesAgreementRadio) {
                    yesAgreementRadio.checked = true;
                }
                
                agreementRadios.forEach(radio => {
                    if (radio.value !== 'Yes') {
                        radio.disabled = true;
                        radio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
                
                const unknownAllergyRadio = allergiesSection ? allergiesSection.querySelector('input[type="radio"][value="Unknown"]') : null;
                if (unknownAllergyRadio) {
                    unknownAllergyRadio.disabled = true;
                    unknownAllergyRadio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                otherCheckboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                
                caregiverRadios.forEach(radio => {
                    radio.disabled = false;
                    radio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                
                agreementRadios.forEach(radio => {
                    radio.disabled = false;
                    radio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                
                const unknownAllergyRadio = allergiesSection ? allergiesSection.querySelector('input[type="radio"][value="Unknown"]') : null;
                if (unknownAllergyRadio) {
                    unknownAllergyRadio.disabled = false;
                    unknownAllergyRadio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        } else {
            if (checkbox.checked) {
                if (livingAlone) {
                    livingAlone.checked = false;
                }
                
                caregiverRadios.forEach(radio => {
                    radio.disabled = false;
                    radio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                
                agreementRadios.forEach(radio => {
                    radio.disabled = false;
                    radio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                
                const unknownAllergyRadio = allergiesSection ? allergiesSection.querySelector('input[type="radio"][value="Unknown"]') : null;
                if (unknownAllergyRadio) {
                    unknownAllergyRadio.disabled = false;
                    unknownAllergyRadio.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }
    }

    function showPetSelectedToast(petName) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-slide-in';
        toast.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span><strong>${petName}</strong> has been selected for adoption</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Apply formatPhone to all phone fields on load
    document.addEventListener('DOMContentLoaded', function() {
        const phoneFields = document.querySelectorAll('input[name="mobile_number"], input[name="alt_phone"]');
        phoneFields.forEach(field => {
            field.addEventListener('input', function() {
                formatPhone(this);
            });
        });

        const livingAloneCheckbox = document.querySelector('input[name="household_members[]"][value="Living alone"]');
        if (livingAloneCheckbox) {
            const householdContainer = livingAloneCheckbox.closest('.flex');
            if (householdContainer) {
                const otherCheckboxes = householdContainer.querySelectorAll('input[type="checkbox"]:not([value="Living alone"])');
                const hasOtherMembers = Array.from(otherCheckboxes).some(cb => cb.checked);
                
                if (livingAloneCheckbox.checked && hasOtherMembers) {
                    livingAloneCheckbox.checked = false;
                }
                
                if (livingAloneCheckbox.checked) {
                    otherCheckboxes.forEach(cb => {
                        cb.checked = false;
                        cb.disabled = true;
                        cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    });
                    
                    const caregiverSection = document.getElementById('primaryCaregiverSection');
                    const caregiverRadios = caregiverSection ? caregiverSection.querySelectorAll('input[type="radio"]') : [];
                    const myselfRadio = caregiverSection ? caregiverSection.querySelector('input[type="radio"][value="Myself"]') : null;
                    
                    if (myselfRadio) {
                        myselfRadio.checked = true;
                    }
                    
                    caregiverRadios.forEach(radio => {
                        if (radio.value !== 'Myself') {
                            radio.disabled = true;
                            radio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    });
                    
                    const agreementSection = document.getElementById('householdAgreementSection');
                    const agreementRadios = agreementSection ? agreementSection.querySelectorAll('input[type="radio"]') : [];
                    const yesAgreementRadio = agreementSection ? agreementSection.querySelector('input[type="radio"][value="Yes"]') : null;
                    
                    if (yesAgreementRadio) {
                        yesAgreementRadio.checked = true;
                    }
                    
                    agreementRadios.forEach(radio => {
                        if (radio.value !== 'Yes') {
                            radio.disabled = true;
                            radio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    });
                    
                    const allergiesSection = document.getElementById('petAllergiesSection');
                    const allergiesRadios = allergiesSection ? allergiesSection.querySelectorAll('input[type="radio"]') : [];
                    const unknownAllergyRadio = allergiesSection ? allergiesSection.querySelector('input[type="radio"][value="Unknown"]') : null;
                    
                    if (unknownAllergyRadio) {
                        unknownAllergyRadio.disabled = true;
                        unknownAllergyRadio.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }
            }
        }

        // Check for pre-selected pet from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const preselectedPetId = urlParams.get('pet_id');
        if (preselectedPetId) {
            // Find the pet in adoptionPetsData
            const pet = adoptionPetsData.find(p => String(p.pet_id) === String(preselectedPetId));
            if (pet) {
                // Auto-select the pet
                selectedAdoptionPets.push(String(preselectedPetId));
                
                // Render the selected pet in the form
                const container = document.getElementById('selectedAdoptionPetsList');
                const noPetsMessage = document.getElementById('noAdoptionPetsSelected');
                
                if (noPetsMessage) {
                    noPetsMessage.remove();
                }
                
                container.innerHTML = '';
                
                selectedAdoptionPets.forEach(petId => {
                    const petData = adoptionPetsData.find(p => String(p.pet_id) === String(petId));
                    if (petData) {
                        const imageHtml = petData.image 
                            ? `<img src="${assetBaseUrl}${petData.image}" alt="${petData.pet_name}" class="w-16 h-16 rounded-lg object-cover">`
                            : `<div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                               </div>`;
                        
                        const petCard = `
                            <div class="flex items-center p-4 border border-emerald-200 rounded-lg bg-emerald-50">
                                ${imageHtml}
                                <div class="ml-4 flex-1">
                                    <div class="font-semibold text-gray-900">${petData.pet_name}</div>
                                    <div class="text-xs text-gray-500">
                                        <span class="capitalize">${petData.species}</span> · ${petData.gender} · ${petData.age}
                                    </div>
                                </div>
                                <button type="button" onclick="removeAdoptionPet('${petId}')" class="text-red-500 hover:text-red-700 p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <input type="hidden" name="selected_adoption_pets[]" value="${petData.pet_id}">
                            </div>
                        `;
                        container.innerHTML += petCard;
                    }
                });
                
                // Show confirmation toast
                showPetSelectedToast(pet.pet_name);
            }
        }

        // Initialize home photo state with existing photos
        @if($isEdit && !empty($appHomePhotos['primary_living_area']))
            homePhotoState.primaryLivingArea = @json($appHomePhotos['primary_living_area']).map(path => ({ file: null, existingPath: path }));
            renderPhotoPreview('primaryLivingAreaPreview', homePhotoState.primaryLivingArea, 'Primary living area');
        @endif

        @if($isEdit && !empty($appHomePhotos['outdoor_yard_gate']))
            homePhotoState.outdoorYardGate = @json($appHomePhotos['outdoor_yard_gate']).map(path => ({ file: null, existingPath: path }));
            renderPhotoPreview('outdoorYardGatePreview', homePhotoState.outdoorYardGate, 'Outdoor yard gate');
        @endif

        @if($isEdit && !empty($application->valid_id_path))
            validIdState.existingPath = @json($application->valid_id_path);
            const validIdContainer = document.getElementById('validIdPreview');
            if (validIdContainer) {
                const validIdPath = validIdState.existingPath;
                const isPdf = validIdPath && validIdPath.toLowerCase().includes('.pdf');
                validIdContainer.innerHTML = `
                    <div class="relative inline-block" data-existing-path="${validIdPath}">
                        ${isPdf 
                            ? `<a href="{{ asset('storage/') }}/${validIdPath}" target="_blank" class="block">
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0014.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Valid ID Document</p>
                                        <p class="text-xs text-gray-500">PDF - Click to view</p>
                                    </div>
                                </div>
                            </a>`
                            : `<img src="{{ asset('storage/') }}/${validIdPath}" alt="Valid ID" class="max-w-xs max-h-48 object-contain border border-gray-200 rounded-lg">
                               <p class="text-xs text-gray-500 mt-1">Current valid ID</p>`
                        }
                        <button type="button" 
                                onclick="removeValidId()" 
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition-colors">
                            ×
                        </button>
                    </div>
                `;
            }
        @endif
    });

    // Step navigation
    function goToStep(step) {
        // Validate current step before moving forward
        if (!validateStep(step - 1) && step > 1) {
            return;
        }

        // Hide all parts
        document.querySelectorAll('.form-part').forEach(part => {
            part.classList.add('hidden');
        });

        // Show the target part
        document.getElementById('part' + step).classList.remove('hidden');
        
        // Update progress bar
        const progress = (step / 5) * 100;
        document.getElementById('progressBar').style.width = progress + '%';

        // Update step indicator text
        const stepLabels = [
            '',
            'Step 1 of 5 — Alternate Contact',
            'Step 2 of 5 — Adoption Questionnaire',
            'Step 3 of 5 — Home Photos',
            'Step 4 of 5 — Upload Valid ID',
            'Step 5 of 5 — Appointment Setup'
        ];
        document.getElementById('stepIndicatorText').textContent = stepLabels[step];

        // Update step circles
        for (let i = 1; i <= 5; i++) {
            const circle = document.querySelector('[data-step="' + i + '"]');
            if (i <= step) {
                circle.classList.remove('border-gray-300', 'text-gray-400');
                circle.classList.add('border-emerald-600', 'bg-emerald-600', 'text-white');
            } else {
                circle.classList.remove('border-emerald-600', 'bg-emerald-600', 'text-white');
                circle.classList.add('border-gray-300', 'text-gray-400');
            }
        }

        // Scroll to top of form
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Validation function for each step
    function validateStep(step) {
        const part = document.getElementById('part' + step);
        const requiredFields = part.querySelectorAll('[name]');
        let isValid = true;
        let firstError = null;

        // Clear previous error styles
        part.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });

        // Check required fields for this step
        requiredFields.forEach(field => {
            const name = field.name;
            
            // Skip disabled fields
            if (field.disabled) {
                return;
            }
            
            // Skip checkbox arrays and non-required fields
            if (name.includes('[]') || 
                name === 'family_support_explain' || 
                name === 'alt_mobile_number' ||
                name === 'alt_first_name' ||
                name === 'alt_last_name' ||
                name === 'alt_relationship' ||
                name === 'alt_phone' ||
                name === 'alt_email') {
                return;
            }

            // Check if required field is empty
            if (!field.value.trim() && field.type !== 'radio' && field.type !== 'checkbox') {
                isValid = false;
                field.classList.add('border-red-500');
                if (!firstError) firstError = field;
            }

            // Check radio buttons
            if (field.type === 'radio') {
                const radioGroup = part.querySelectorAll('input[name="' + name + '"]');
                const checked = Array.from(radioGroup).some(r => r.checked);
                if (!checked) {
                    isValid = false;
                    if (!firstError) firstError = radioGroup[0];
                }
            }

            // Check checkboxes
            if (field.type === 'checkbox' && field.name.includes('[]')) {
                const checkboxGroup = part.querySelectorAll('input[name="' + name + '"]');
                const checked = Array.from(checkboxGroup).some(c => c.checked);
                if (!checked) {
                    isValid = false;
                    if (!firstError) firstError = checkboxGroup[0];
                }
            }
        });

        if (!isValid) {
            // Show error message
            alert('Please fill in all required fields before proceeding.');
            if (firstError) {
                firstError.focus();
            }
            return false;
        }

        return true;
    }
</script>

    @include('Client.partials.footer')

</body>
</html>

