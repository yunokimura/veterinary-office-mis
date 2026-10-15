<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missing Pet Report - Dasmariñas City Veterinary Services</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/formPersistence.js') }}"></script>

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
        <div class="lg:col-span-8">
            <form method="POST" action="{{ route('missing-pets.report.store') }}" enctype="multipart/form-data" id="missingPetForm" onsubmit="syncReporterFields()">
                @csrf
                <input type="hidden" name="selected_pets" id="selectedPetsData" value="">
                <div id="selectedPetsArrayContainer"></div>

                <!-- Card 2: Pet's Information -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PET'S INFORMATION</h4>
                        </div>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-900 text-white text-xs font-semibold">
                            <span id="petInfoSelectedCount">0 Pets Selected</span>
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium">
                                Select Your Pet <span class="text-red-500">*</span>
                            </label>
                            <button type="button" onclick="openPetModal()" 
                                    class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Select Pet
                            </button>
                        </div>
                        
                        <!-- Display selected pet info here -->
                        <div id="selectedPetsList" class="grid md:grid-cols-1 gap-4">
                            <!-- Empty state -->
                            <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">No pet selected yet. Click "Select Pet" to choose from your registered pets.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Pet's Physical Distinguishing Marks -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PHYSICAL DISTINGUISHING MARKS</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Notched ear, docked tail, spot pattern -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Does the pet have a notched ear, a docked tail, or a specific spot pattern? <span class="text-red-500">*</span>
                                </label>
                                <textarea name="physical_marks[body_marks]" rows="3"
                                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                          placeholder="Describe any distinctive physical marks (notched ears, docked tail, spot patterns, etc.)"></textarea>
                                
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1.5 text-gray-600">
                                        Photo (optional)
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                        <input type="file" name="physical_marks[body_marks_photo]" id="body_marks_photo" accept="image/*" class="hidden">
                                        <label for="body_marks_photo" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-600 text-sm">Click to upload photo of physical marks</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Eye Color -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Eye Color <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="physical_marks[eye_color]" placeholder="e.g., Brown, Black, Hazel, Blue, etc."
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1.5 text-gray-600">
                                        Photo (optional)
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                        <input type="file" name="physical_marks[eye_color_photo]" id="eye_color_photo" accept="image/*" class="hidden">
                                        <label for="eye_color_photo" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-600 text-sm">Click to upload photo showing eye color</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Collar/Harness -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Collar/Harness <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="physical_marks[collar_harness]" placeholder="e.g., Red collar with bells, Blue harness, None, etc."
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                
                                <div class="mt-3">
                                    <label class="block text-sm font-medium mb-1.5 text-gray-600">
                                        Photo (optional)
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors">
                                        <input type="file" name="physical_marks[collar_harness_photo]" id="collar_harness_photo" accept="image/*" class="hidden">
                                        <label for="collar_harness_photo" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-600 text-sm">Click to upload photo showing collar/harness</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Time and Place -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">TIME AND PLACE</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Last Seen Date and Time -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Last Seen Date and Time <span class="text-red-500">*</span>
                                </label>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="date" name="last_seen_date" id="last_seen_date"
                                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                    </div>
                                    <div>
                                        <input type="time" name="last_seen_time" id="last_seen_time"
                                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Location - Barangay Dropdown -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Location (Barangay) <span class="text-red-500">*</span>
                                </label>
                                <select name="barangay_id" id="barangay_id"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
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
                                <label class="block text-sm font-medium mb-1.5">
                                    Specific Location Description
                                </label>
                                <textarea name="location_description" rows="3"
                                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                          placeholder="Describe the specific location where the pet was last seen (e.g., near the church, at the park, etc.)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Photo & Contact -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PHOTO & CONTACT</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Photo Upload -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Photo Upload <span class="text-red-500">*</span>
                                </label>
                                <p class="text-sm text-gray-500 mb-3">Provide a clear, recent, full-body photo of your pet.</p>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                                    <input type="file" name="pet_photo" id="pet_photo" accept="image/*" class="hidden">
                                    <label for="pet_photo" class="cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-600 font-medium">Click to upload a clear, recent, full-body photo</p>
                                        <p class="text-gray-400 text-sm mt-1">Max. file size: 8MB</p>
                                    </label>
                                </div>
                            </div>

                            <!-- Additional Contact Info -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Additional Contact Information
                                </label>
                                <textarea name="additional_contact" rows="2"
                                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                          placeholder="Any additional contact details or information that might help"></textarea>
                            </div>

                            <!-- Reporter fields (hidden, populated from Part 1) -->
                            <input type="hidden" name="reported_by_name" id="reported_by_name" value="{{ old('reported_by_name', trim(($petOwner->first_name ?? '') . ' ' . ($petOwner->last_name ?? ''))) }}">
                            <input type="hidden" name="reporter_contact" id="reporter_contact" value="{{ old('reporter_contact', $petOwner->phone_number ?? '') }}">
                            <input type="hidden" name="reporter_email" id="reporter_email" value="{{ old('reporter_email', $user->email ?? '') }}">
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-primary text-white px-12 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Submit Missing Pet Report
                    </button>
                </div>
            </form>

            <!-- Back Link -->
            <div class="text-center mt-6">
                <a href="{{ url('/missing-pets') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                    ← Back to Missing Pets
                </a>
            </div>
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
                            <p class="text-sm font-semibold text-gray-900">{{ $petOwner->first_name ?? '' }} {{ $petOwner->last_name ?? '' }}</p>
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
                                        {{ $petOwner->address->block_lot_phase ?? '' }}, {{ $petOwner->address->street ?? '' }}, {{ $petOwner->address->barangay->barangay_name ?? '' }}, Dasmariñas City
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

                <!-- Selected Pets Mini Summary -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">SELECTED PETS (<span id="selectedPetCount">0</span>)</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="sidebarSelectedPets" class="space-y-3">
                            <p class="text-sm text-gray-500">No pets selected yet.</p>
                        </div>
                        <button type="button" onclick="openPetModal()" class="mt-4 w-full py-2.5 border-2 border-dashed border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium hover:border-emerald-400 hover:text-emerald-800 transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            + Add Another Pet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Pet Selection Modal (outside form) -->
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
                    <p class="text-sm text-gray-600 mb-4">Select your pet that is missing:</p>
                    <div class="space-y-3" id="petSelectionList">
                        @foreach($petsArray as $pet)
                            @php
                                $speciesDisplay = isset($pet['species']) ? ucfirst($pet['species']) : 'Unknown';
                            @endphp
                            <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-primary transition-colors pet-selection-card" data-pet-id="{{ $pet['id'] }}">
                                <input type="checkbox" name="selected_pets[]" value="{{ $pet['id'] }}" 
                                       class="mt-1 w-4 h-4 text-primary border-gray-300 focus:ring-primary pet-checkbox"
                                       onchange="togglePetSelection(this)">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-900 pet-name">{{ $pet['name'] }}</span>
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">{{ $speciesDisplay }}</span>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500 grid grid-cols-2 gap-x-4">
                                        <div>Breed: {{ $pet['breed'] ?? 'Unknown' }}</div>
                                        <div>Weight: {{ isset($pet['weight']) ? (str_contains(strtolower($pet['weight']), 'kg') || strtolower($pet['weight']) == 'n/a' ? $pet['weight'] : $pet['weight'] . ' kg') : 'Unknown' }}</div>
                                        <div class="col-span-2">Age: {{ isset($pet['age']) ? str_replace('_', ' ', $pet['age']) : 'Unknown' }}</div>
                                    </div>
                                </div>
                                @if(!empty($pet['image']))
                                @php
                                    $petImagePath = $pet['image'];
                                    if (!str_contains($petImagePath, 'images/pets') && !str_contains($petImagePath, 'http')) {
                                        $petImagePath = 'images/pets/' . basename($petImagePath);
                                    }
                                @endphp
                                <div class="ml-2 flex-shrink-0">
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
                    <button type="button" onclick="confirmPetSelection()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Confirm Selection
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Client.partials.footer')

<script>
    // Pet data from server
    const petsData = @json($petsArray);
    
    // Format age - remove underscores and format naturally
    function formatAge(age) {
        if (!age && age !== 0) return 'Unknown';
        const ageStr = String(age);
        return ageStr.replace(/_/g, ' ').replace(/\b(\d)\b/g, '$1 ').trim();
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
    
    let selectedPets = [];

    function openPetModal() {
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
            document.body.style.overflow = 'hidden';
            return;
        }
        
        // Restore checkbox states from selectedPets
        document.querySelectorAll('.pet-checkbox').forEach(checkbox => {
            const petId = String(checkbox.value);
            checkbox.checked = selectedPets.includes(petId);
        });
        
        updateModalSelectedCount();
        document.getElementById('petModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePetModal() {
        document.getElementById('petModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function togglePetSelection(checkbox) {
        const petId = String(checkbox.value);
        if (checkbox.checked) {
            if (!selectedPets.includes(petId)) {
                selectedPets.push(petId);
            }
        } else {
            selectedPets = selectedPets.filter(id => String(id) !== petId);
        }
        updateModalSelectedCount();
    }

    function updateModalSelectedCount() {
        const countEl = document.getElementById('selectedCount');
        if (countEl) countEl.textContent = selectedPets.length;
    }

    function confirmPetSelection() {
        if (selectedPets.length === 0) {
            alert('Please select at least one pet');
            return;
        }

        // Clear modal checkboxes
        document.querySelectorAll('#petSelectionList input[type="checkbox"]').forEach(cb => cb.checked = false);

        // Update hidden inputs for form submission
        const selectedPetsData = document.getElementById('selectedPetsData');
        if (selectedPetsData) {
            selectedPetsData.value = JSON.stringify(selectedPets);
        }

        const arrayContainer = document.getElementById('selectedPetsArrayContainer');
        if (arrayContainer) {
            arrayContainer.innerHTML = '';
            selectedPets.forEach(petId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_pets[]';
                input.value = petId;
                arrayContainer.appendChild(input);
            });
        }

        updateSidebarSelectedPets();
        updateLeftPetInfoDisplay();
        closePetModal();
    }

    function updateLeftPetInfoDisplay() {
        const container = document.getElementById('selectedPetsList');
        if (!container) return;

        if (selectedPets.length === 0) {
            container.innerHTML = `
                <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500">No pet selected yet. Click "Select Pet" to choose from your registered pets.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = '';

        selectedPets.forEach(petId => {
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (!pet) return;

            const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
            const genderDisplay = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1) : 'Unknown';
            const neuteredDisplay = pet.is_neutered ? 'Yes' : 'No';

            let imageHtml = '';
            if (pet.image) {
                let imgPath = pet.image;
                if (!imgPath.includes('images/pets') && !imgPath.startsWith('http')) {
                    imgPath = 'images/pets/' + imgPath.split('/').pop();
                }
                const imageSrc = imgPath.startsWith('http') ? imgPath : "{{ asset('') }}" + imgPath;
                imageHtml = `<img src="${imageSrc}" alt="${pet.name}" class="w-20 h-20 rounded-full object-cover">`;
            } else {
                imageHtml = `<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>`;
            }

            const petCard = document.createElement('div');
            petCard.className = 'bg-white border border-gray-200 rounded-lg p-6';
            petCard.innerHTML = `
                <div class="flex items-start">
                    ${imageHtml}
                    <div class="ml-4 flex-1">
                        <h4 class="font-bold text-lg text-gray-900">${pet.name || 'Unknown'}</h4>
                        <div class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                            <div><span class="text-gray-500">Species:</span> <span class="text-gray-900">${speciesDisplay}</span></div>
                            <div><span class="text-gray-500">Breed:</span> <span class="text-gray-900">${pet.breed || 'Unknown'}</span></div>
                            <div><span class="text-gray-500">Gender:</span> <span class="text-gray-900">${genderDisplay}</span></div>
                            <div><span class="text-gray-500">Neutered:</span> <span class="text-gray-900">${neuteredDisplay}</span></div>
                            <div><span class="text-gray-500">Weight:</span> <span class="text-gray-900">${formatWeight(pet.weight)}</span></div>
                            <div><span class="text-gray-500">Age:</span> <span class="text-gray-900">${formatAge(pet.age)}</span></div>
                        </div>
                    </div>
                    <button type="button" onclick="removePet(${pet.id})" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(petCard);
        });
    }

    function updateSidebarSelectedPets() {
        const sidebarContainer = document.getElementById('sidebarSelectedPets');
        const countSpan = document.getElementById('selectedPetCount');
        const petInfoCountSpan = document.getElementById('petInfoSelectedCount');
        if (!sidebarContainer) return;

        const count = selectedPets.length;
        const label = count === 1 ? '1 Pet Selected' : count + ' Pets Selected';
        if (countSpan) countSpan.textContent = count;
        if (petInfoCountSpan) petInfoCountSpan.textContent = label;

        if (selectedPets.length === 0) {
            sidebarContainer.innerHTML = '<p class="text-sm text-gray-500">No pets selected yet.</p>';
            return;
        }

        sidebarContainer.innerHTML = '';

        selectedPets.forEach(petId => {
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (!pet) return;

            const petItem = document.createElement('div');
            petItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';

            const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
            const breedDisplay = pet.breed || 'Unknown';

            let imageHtml = '';
            if (pet.image) {
                let imgPath = pet.image;
                if (!imgPath.includes('images/pets') && !imgPath.startsWith('http')) {
                    imgPath = 'images/pets/' + imgPath.split('/').pop();
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

            petItem.innerHTML = `
                <div class="flex items-center gap-3">
                    ${imageHtml}
                    <div>
                        <p class="text-sm font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                        <p class="text-xs text-gray-500">${speciesDisplay} • ${breedDisplay}</p>
                    </div>
                </div>
                <button type="button" onclick="removePet(${pet.id})" class="text-gray-400 hover:text-red-500 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

            sidebarContainer.appendChild(petItem);
        });
    }

    function removePet(petId) {
        selectedPets = selectedPets.filter(id => String(id) !== String(petId));
        updateSidebarSelectedPets();
    }

    function changePetSelection() {
        openPetModal();
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePetModal();
        }
    });

    // ------------------------------------------------------------------
    // Draft persistence (sessionStorage, key: draft_missing_pets_form)
    // Saves the selected pets + all report fields on any input/change,
    // restores them on load.
    // ------------------------------------------------------------------
    const missingPetFormDraft = window.FormPersistence ? window.FormPersistence.init('missing_pets_form', {
        form: '#missingPetForm',
        userId: {{ auth()->id() ?? 'null' }},
        skipRestore: {{ $errors->any() ? 'true' : 'false' }},
        exclude: ['selected_pets[]'],
        custom: {
            save: function () {
                return {
                    selectedPets: selectedPets.slice()
                };
            },
            restore: function (state) {
                if (!state || !Array.isArray(state.selectedPets)) return;

                // Re-select pets (skip pets deleted since the draft was saved)
                selectedPets = state.selectedPets
                    .filter(function (id) {
                        return petsData.some(function (p) { return String(p.id) === String(id); });
                    })
                    .map(function (id) { return String(id); });

                if (selectedPets.length > 0) {
                    confirmPetSelection(); // rebuilds hidden fields + displays
                }
            }
        }
    }) : null;
</script>

<script>
function syncReporterFields() {
    const firstName = document.querySelector('input[name="first_name"]')?.value || '';
    const lastName = document.querySelector('input[name="last_name"]')?.value || '';
    const email = document.querySelector('input[name="email"]')?.value || '';
    const mobile = document.querySelector('input[name="mobile_number"]')?.value || '';

    const reportedByName = document.getElementById('reported_by_name');
    const reporterContact = document.getElementById('reporter_contact');
    const reporterEmail = document.getElementById('reporter_email');

    if (reportedByName) reportedByName.value = (firstName + ' ' + lastName).trim();
    if (reporterContact) reporterContact.value = mobile;
    if (reporterEmail) reporterEmail.value = email;
}
</script>

</body>
</html>
