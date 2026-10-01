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

        input[type="checkbox"], input[type="radio"] {
            accent-color: #066D33;
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
                    <a href="{{ route('public.home') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <form id="vaccinationForm" method="POST" action="{{ url('/vaccination/form') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="selected_pets" id="selectedPetsData" value="">
                    <div id="selectedPetsArrayContainer"></div>

                    <!-- Card 1: Pet Medical History & Screening -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Pet Medical History & Screening</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-900 text-white text-xs font-semibold">
                                        <span id="headerSelectedCount">0 Pets Selected</span>
                                    </span>
                                    <button type="button" onclick="openPetModal()" 
                                            class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Select Pet
                                    </button>
                                </div>

                                <!-- Medical History Per Pet -->
                                <div id="petMedicalHistoryContainer">
                                    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 text-sm">Select pets first to see medical history forms.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Appointment Scheduling -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Appointment Scheduling</h4>
                            </div>
                            <span id="slotPetCountBadge" class="text-xs bg-emerald-800 text-emerald-200 font-medium px-2.5 py-1 rounded-full border border-emerald-700">
                                0 Pets Selected
                            </span>
                        </div>
                        <div class="p-6">
                            <div id="globalSchedulerContainer">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Select Appointment Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative max-w-sm">
                                        <input type="date"
                                               id="globalAppointmentDate"
                                               min="{{ date('Y-m-d') }}"
                                               onchange="loadGlobalSlots()"
                                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                               required>
                                    </div>
                                    <p id="selectedDateText" class="text-xs text-emerald-700 mt-1.5 font-medium flex items-center gap-1 hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Selected Date: <span id="globalSelectedDate">-</span>
                                    </p>
                                </div>

                                <div id="groupBookingBanner" class="mb-4 bg-emerald-50 border border-emerald-200 rounded-lg p-3 flex items-start gap-2.5 text-xs text-emerald-900 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <span class="font-bold">Group Booking Policy:</span> Selecting <span id="bannerSelectedTime" class="font-bold">-</span> will reserve slot capacity for all <span id="bannerPetCount" class="font-bold">-</span> selected pets (<span id="bannerPetNames" class="font-bold">-</span>) during this same 1-hour clinic block.
                                    </div>
                                </div>

                                <div id="globalTimeSlots" class="mb-3 hidden">
                                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                        Select Preferred Time Slot <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" id="globalSlotsGrid">
                                        <!-- Slots will be loaded dynamically -->
                                    </div>
                                </div>

                                <div id="globalSelectedSummary" class="hidden bg-emerald-50 border border-emerald-200 rounded-lg p-3">
                                    <p class="text-sm text-emerald-700 font-medium">
                                        Selected: <span id="globalSelectedDateSummary">-</span>
                                    </p>
                                    <div id="selectedSlotsList" class="mt-1 space-y-1"></div>
                                </div>

                                <input type="hidden" name="appointment_date" id="appointment_date" value="">
                                <input type="hidden" name="appointment_time" id="globalAppointmentTime" value="">
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Terms & Condition -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-white">Terms & Condition</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Confirmation Checkbox -->
                            <div class="mt-6">
                                <label class="inline-flex items-start cursor-pointer">
                                     <input type="checkbox" name="confirmation" id="termsCheckbox" class="h-5 w-5 rounded mt-1">
                                    <span class="ml-3 text-gray-700 text-sm">
                                        By confirming, you acknowledge that the provided information is accurate and that your pet will be available for vaccination on the selected date(s). <span class="text-red-500">*</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center mt-8">
                                <button type="submit" id="submitBtn" disabled class="bg-gray-300 text-gray-500 px-12 py-3 rounded-lg font-semibold cursor-not-allowed transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Submit Vaccination Pre-Registration
                                </button>
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
                                            <input type="checkbox" value="{{ $pet['id'] }}" 
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

            <!-- Pet Info Modal -->
            <div id="petInfoModal" class="fixed inset-0 z-50 hidden">
                <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePetInfoModal()"></div>
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Pet Information</h3>
                            <button type="button" onclick="closePetInfoModal()" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4" id="petInfoModalContent">
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                            <button type="button" onclick="closePetInfoModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Submission Result Modal -->
    <div id="submissionModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 text-center">
                <div id="submissionModalIcon" class="mb-4"></div>
                <h3 id="submissionModalTitle" class="text-lg font-semibold text-gray-900 mb-2"></h3>
                <p id="submissionModalMessage" class="text-gray-600 mb-2"></p>
                <p id="submissionModalReason" class="text-sm text-gray-500 mb-6 hidden"></p>
                <div id="submissionModalActions" class="flex flex-col gap-2"></div>
            </div>
        </div>
    </div>

    <!-- Rabies Early Vaccination Warning Modal -->
    <div id="rabiesWarningModal" class="fixed inset-0 z-50 hidden">
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
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Notice</h3>
                <p id="rabiesWarningMessage" class="text-sm text-gray-700 text-left mb-6"></p>
                <button type="button" onclick="closeRabiesWarningModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">I Understand</button>
            </div>
        </div>
    </div>

    <!-- Surgery Warning Modal -->
    <div id="surgeryWarningModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 text-center">
                <div class="mb-4">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Vaccine Safety Warning</h3>
                <p id="surgeryWarningMessage" class="text-sm text-gray-700 text-left mb-6"></p>
                <button type="button" onclick="closeSurgeryWarningModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">I Understand</button>
            </div>
        </div>
    </div>

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
        
        const antiRabiesMaxDate = new Date().toISOString().split('T')[0];
        const antiRabiesMinDate = new Date();
        antiRabiesMinDate.setFullYear(antiRabiesMinDate.getFullYear() - 10);
        const antiRabiesMinDateStr = antiRabiesMinDate.toISOString().split('T')[0];
        
        // Format age - handle exact age strings from pet_info.pet_age
        function formatAge(age) {
            if (age === null || age === undefined || age === '') return 'Unknown';
            return String(age).replace(/_/g, ' ').trim();
        }
        
        // Format weight - append kg if not included
        function formatWeight(weight) {
            if (weight === null || weight === undefined || weight === '') return 'Unknown';
            const weightStr = String(weight).toLowerCase();
            if (weightStr.includes('kg') || weightStr === 'n/a' || weightStr === 'na') {
                return weight;
            }
            return weight + ' kg';
        }

        // Date formatting helper
        function formatDateDisplay(input, displayId) {
            const displays = document.querySelectorAll('#' + displayId);
            if (!displays.length) return;
            if (input.value) {
                displays.forEach(display => {
                    display.textContent = new Date(input.value).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                });
            } else {
                displays.forEach(display => {
                    display.textContent = '';
                });
            }
        }

        function validateRabiesVaccinationGap(petId, lastVaccinationDate, appointmentDate) {
            if (!lastVaccinationDate || !appointmentDate) {
                return { valid: true, protectionUntil: null, monthsRemaining: null };
            }

            const lastDate = new Date(lastVaccinationDate + 'T00:00:00');
            const appointment = new Date(appointmentDate + 'T00:00:00');
            const protectionUntil = new Date(lastDate);
            protectionUntil.setMonth(protectionUntil.getMonth() + 12);
            
            const diffTime = appointment - lastDate;
            const diffMonths = diffTime / (1000 * 60 * 60 * 24 * 30.44);
            
            return {
                valid: diffMonths >= 11,
                protectionUntil: protectionUntil.toISOString().split('T')[0],
                monthsRemaining: Math.max(0, 12 - Math.floor(diffMonths))
            };
        }

        function validateRabiesDateOnChange(petId) {
            const appointmentDateInput = document.getElementById('globalAppointmentDate');
            const appointmentDate = appointmentDateInput ? appointmentDateInput.value : null;
            
            const historyContainer = document.getElementById('petMedicalHistoryContainer');
            const dateInputEl = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][last_anti_rabies_date]"]`) : null;
            
            if (dateInputEl && dateInputEl.value && appointmentDate) {
                // Only validate if the date looks complete
                if (/^\d{4}-\d{2}-\d{2}$/.test(dateInputEl.value)) {
                    const pet = petsData.find(p => String(p.id) === String(petId));
                    const result = validateRabiesVaccinationGap(petId, dateInputEl.value, appointmentDate);
                    if (!result.valid && pet) {
                        rabiesWarningPetId = petId;
                        showRabiesWarningModal(pet.name, dateInputEl.value, result.protectionUntil);
                        return;
                    }
                }
            }
            
            updatePetEligibilityState(petId);
        }

        // Global appointment slot functions
        let globalSlotsData = [];
        let selectedSlotTime = null;

        function updateSlotPetCountBadge() {
            const badge = document.getElementById('slotPetCountBadge');
            if (!badge) return;
            const count = selectedPets.length;
            badge.textContent = count + ' Pet' + (count === 1 ? ' Selected' : 's Selected');
        }

        function getPetNamesString() {
            if (!selectedPets.length) return 'no pets';
            return selectedPets.map(pid => {
                const pet = petsData.find(p => String(p.id) === String(pid));
                return pet ? pet.name : 'Pet ' + pid;
            }).join(', ');
        }

        function updateGroupBookingBanner(timeText) {
            const banner = document.getElementById('groupBookingBanner');
            const bannerTime = document.getElementById('bannerSelectedTime');
            const bannerCount = document.getElementById('bannerPetCount');
            const bannerNames = document.getElementById('bannerPetNames');
            
            if (!banner || !bannerTime || !bannerCount || !bannerNames) return;
            
            if (!timeText) {
                banner.classList.add('hidden');
                return;
            }
            
            banner.classList.remove('hidden');
            bannerTime.textContent = timeText;
            bannerCount.textContent = selectedPets.length;
            bannerNames.textContent = getPetNamesString();
        }

        async function loadGlobalSlots() {
            const dateInput = document.getElementById('globalAppointmentDate');
            const selectedDate = dateInput.value;
            if (!selectedDate) return;

            // Validate rabies vaccination gaps for all selected pets
            let hasRabiesWarning = false;
            for (const petId of selectedPets) {
                const pet = petsData.find(p => String(p.id) === String(petId));
                if (!pet) continue;
                
                const historyContainer = document.getElementById('petMedicalHistoryContainer');
                const dateInputEl = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][last_anti_rabies_date]"]`) : null;
                
                if (dateInputEl && dateInputEl.value) {
                    const result = validateRabiesVaccinationGap(petId, dateInputEl.value, selectedDate);
                    if (!result.valid) {
                        hasRabiesWarning = true;
                        rabiesWarningPetId = petId;
                        showRabiesWarningModal(pet.name, dateInputEl.value, result.protectionUntil);
                        break;
                    }
                }
            }
            
            if (hasRabiesWarning) {
                return;
            }

            const slotStatus = document.getElementById('globalDailyCapacity');
            const slotsGrid = document.getElementById('globalSlotsGrid');
            const selectedDateText = document.getElementById('selectedDateText');
            const globalSelectedDate = document.getElementById('globalSelectedDate');
            const globalTimeSlots = document.getElementById('globalTimeSlots');
            
            slotsGrid.innerHTML = '';
            slotsGrid.classList.add('hidden');
            globalTimeSlots.classList.add('hidden');
            
            if (slotStatus) {
                slotStatus.classList.remove('hidden');
                slotStatus.textContent = 'Loading...';
                slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700';
            }
            
            if (selectedDateText && globalSelectedDate) {
                selectedDateText.classList.remove('hidden');
                const dateObj = new Date(selectedDate + 'T00:00:00');
                globalSelectedDate.textContent = dateObj.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            }

            try {
                const response = await fetch(`/api/appointments/slots?date=${selectedDate}&service_type=vaccination`);
                const data = await response.json();
                
                if (data.success) {
                    globalSlotsData = data.slots;
                    const dailyRemaining = data.daily_remaining || 0;
                    
                    if (slotStatus) {
                        if (dailyRemaining <= 0) {
                            slotStatus.textContent = 'Fully Booked';
                            slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700';
                        } else if (dailyRemaining === 1) {
                            slotStatus.textContent = '1 slot left';
                            slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700';
                        } else {
                            slotStatus.textContent = 'Available';
                            slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700';
                        }
                    }
                    
                    if (data.slots && data.slots.length > 0) {
                        const currentTime = new Date();
                        const todayStr = currentTime.toISOString().split('T')[0];
                        const isToday = selectedDate === todayStr;
                        const currentHour = currentTime.getHours();
                        const currentMinute = currentTime.getMinutes();
                        
                        const sortedSlots = [...data.slots].sort((a, b) => a.time.localeCompare(b.time));
                        
                        sortedSlots.forEach(slot => {
                            const [slotHour, slotMinute] = slot.time.split(':').map(Number);
                            const slotTimeInMinutes = slotHour * 60 + slotMinute;
                            const currentTimeInMinutes = currentHour * 60 + currentMinute;
                            const isPast = isToday && slotTimeInMinutes <= currentTimeInMinutes;
                            
                            const isDisabled = slot.status === 'blocked' || slot.status === 'full' || isPast || slot.is_past;
                            const isSelected = selectedSlotTime === slot.time;
                            
                            const slotBtn = document.createElement('button');
                            slotBtn.type = 'button';
                            slotBtn.className = 'p-3 rounded-xl border-2 text-center transition-all flex flex-col items-center justify-center relative ';
                            
                            if (isDisabled) {
                                slotBtn.className += 'bg-slate-100 border-slate-200 text-slate-400 cursor-not-allowed opacity-60';
                            } else if (isSelected) {
                                slotBtn.className += 'bg-emerald-700 border-emerald-800 text-white font-bold ring-2 ring-emerald-600 shadow-sm';
                            } else {
                                slotBtn.className += 'bg-white border-slate-200 text-slate-800 hover:border-emerald-400 hover:bg-emerald-50/50';
                            }
                            
                            slotBtn.disabled = isDisabled;
                            
                            const timeLabel = document.createElement('span');
                            timeLabel.className = 'text-sm font-bold';
                            timeLabel.textContent = slot.display_time || slot.time;
                            slotBtn.appendChild(timeLabel);
                            
                            const statusLabel = document.createElement('span');
                            statusLabel.className = 'text-[10px] mt-1 ';
                            if (isSelected) {
                                statusLabel.className += 'text-emerald-100';
                            } else if (isDisabled) {
                                statusLabel.className += 'text-slate-400';
                            } else {
                                statusLabel.className += 'text-slate-500';
                            }
                            
                            if (slot.status === 'full' || dailyRemaining <= 0) {
                                statusLabel.textContent = 'Fully Booked';
                            } else if (slot.status === 'limited') {
                                statusLabel.textContent = 'Limited';
                            } else {
                                const remaining = slot.capacity - slot.booked;
                                statusLabel.textContent = Number.isNaN(remaining) ? 'Available' : remaining + ' slots left';
                            }
                            slotBtn.appendChild(statusLabel);
                            
                            if (isSelected) {
                                const checkBadge = document.createElement('span');
                                checkBadge.className = 'absolute -top-2 -right-1 bg-emerald-500 text-white p-0.5 rounded-full shadow-xs';
                                checkBadge.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>';
                                slotBtn.appendChild(checkBadge);
                            }
                            
                            if (!isDisabled) {
                                slotBtn.onclick = () => selectGlobalSlot(slot);
                            }
                            
                            slotsGrid.appendChild(slotBtn);
                        });
                        
                        slotsGrid.classList.remove('hidden');
                        globalTimeSlots.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Failed to load global slots:', error);
                if (slotStatus) {
                    slotStatus.textContent = 'Error loading slots';
                    slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700';
                }
            }
        }

        function selectGlobalSlot(slot) {
            const date = document.getElementById('globalAppointmentDate').value;
            selectedSlotTime = slot.time;
            
            document.getElementById('appointment_date').value = date;
            document.getElementById('globalAppointmentTime').value = slot.time;
            
            const dateObj = new Date(date + 'T00:00:00');
            const dateText = dateObj.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            const timeText = slot.display_time || slot.time;
            
            const summary = document.getElementById('globalSelectedSummary');
            const selectedSlotsList = document.getElementById('selectedSlotsList');
            const globalSelectedDateSummary = document.getElementById('globalSelectedDateSummary');
            
            if (summary) summary.classList.remove('hidden');
            if (globalSelectedDateSummary) globalSelectedDateSummary.textContent = dateText + ' at ' + timeText;
            
            if (selectedSlotsList) {
                selectedSlotsList.innerHTML = '';
                selectedPets.forEach(pid => {
                    const pet = petsData.find(p => String(p.id) === String(pid));
                    const petName = pet ? pet.name : 'Pet ' + pid;
                    
                    const item = document.createElement('div');
                    item.className = 'text-xs text-emerald-700';
                    item.textContent = petName + ': ' + timeText;
                    selectedSlotsList.appendChild(item);
                });
            }
            
            updateGroupBookingBanner(timeText);
            loadGlobalSlots();
        }
        
        let selectedPets = [];
        let ineligiblePets = {};

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

            // Re-check already selected pets
            selectedPets.forEach(petId => {
                const checkbox = document.querySelector(`#petSelectionList input[value="${petId}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
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
            } catch (error) {
                console.error('Failed to check pet booking:', error);
                // On error, allow selection but log for debugging
                const petId = String(checkbox.value);
                if (!selectedPets.includes(petId)) {
                    selectedPets.push(petId);
                }
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
            const existingModal = document.getElementById('alreadyBookedModal');
            if (existingModal) {
                existingModal.remove();
            }
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

        function showPetInfoModal(petId) {
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (!pet) return;

            const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
            const genderDisplay = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1) : 'Unknown';
            const colorDisplay = pet.color || 'Unknown';
            const vaccinationStatusDisplay = pet.vaccination_status ? pet.vaccination_status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'Unknown';
            
            let imageHtml = '';
            if (pet.image) {
                let imgPath = pet.image;
                if (!imgPath.includes('images/pets') && !imgPath.includes('http')) {
                    imgPath = 'images/pets/' + imgPath.split('/').pop();
                }
                const imageSrc = imgPath.startsWith('http') ? imgPath : "{{ asset('') }}" + imgPath;
                imageHtml = `<img src="${imageSrc}" alt="${pet.name}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4">`;
            } else {
                imageHtml = `<div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>`;
            }

            const content = document.getElementById('petInfoModalContent');
            content.innerHTML = `
                <div class="text-center mb-4">
                    ${imageHtml}
                    <h4 class="text-xl font-semibold text-gray-900">${pet.name || 'Unknown'}</h4>
                    <p class="text-sm text-gray-500">${speciesDisplay} • ${pet.breed || 'Unknown'}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Gender</p>
                        <p class="text-gray-900 font-medium">${genderDisplay}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Color</p>
                        <p class="text-gray-900 font-medium">${colorDisplay}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Age</p>
                        <p class="text-gray-900 font-medium">${formatAge(pet.age)}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Weight</p>
                        <p class="text-gray-900 font-medium">${formatWeight(pet.weight)}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Vaccination Status</p>
                        <p class="text-gray-900 font-medium">${vaccinationStatusDisplay}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Last Vaccination</p>
                        <p class="text-gray-900 font-medium">${pet.vaccination_date || 'N/A'}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Next Vaccination</p>
                        <p class="text-gray-900 font-medium">${pet.next_vaccination_date || 'N/A'}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Birthdate</p>
                        <p class="text-gray-900 font-medium">${pet.birthdate || 'N/A'}</p>
                    </div>
                </div>
            `;

            document.getElementById('petInfoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePetInfoModal() {
            document.getElementById('petInfoModal').classList.add('hidden');
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
            const selectedCountEl = document.getElementById('selectedCount');
            if (selectedCountEl) {
                selectedCountEl.textContent = selectedPets.length;
            }
            const countEl = document.getElementById('selectedPetCount');
            if (countEl) {
                countEl.textContent = selectedPets.length;
            }
            const headerCountEl = document.getElementById('headerSelectedCount');
            if (headerCountEl) {
                const count = selectedPets.length;
                headerCountEl.textContent = count + ' Pet' + (count === 1 ? ' Selected' : 's Selected');
            }
            updateSlotPetCountBadge();
        }

        function updateSidebarSelectedPets() {
            const sidebarContainer = document.getElementById('sidebarSelectedPets');
            if (!sidebarContainer) return;

            if (selectedPets.length === 0) {
                sidebarContainer.innerHTML = '<p class="text-sm text-gray-500">No pets selected yet.</p>';
                return;
            }

            sidebarContainer.innerHTML = '';

            selectedPets.forEach(petId => {
                const pet = petsData.find(p => String(p.id) === String(petId));
                if (!pet) return;

                const petItem = document.createElement('div');
                const isIneligible = !!ineligiblePets[petId];
                const reason = ineligiblePets[petId] || '';

                if (isIneligible) {
                    petItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg opacity-50';
                    petItem.style.backgroundColor = '#f3f4f6';
                } else {
                    petItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
                }

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>`;
                }

                const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
                const breedDisplay = pet.breed || 'Unknown';

                petItem.innerHTML = `
                    <div class="flex items-center gap-3">
                        ${imageHtml}
                        <div>
                            <p class="text-sm font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                            <p class="text-xs text-gray-500">${speciesDisplay} • ${breedDisplay}</p>
                            ${isIneligible ? `<span class="eligibility-badge inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold mt-1" title="${reason}">Not Eligible for Rabies Shot</span>` : ''}
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

        function refreshPetUI() {
            const modalFooter = document.querySelector('#petModal .bg-gray-50');
            const medicalHistoryContainer = document.getElementById('petMedicalHistoryContainer');

            // Restore footer if it was hidden
            if (modalFooter) {
                modalFooter.classList.remove('hidden');
            }

            if (selectedPets.length === 0) {
                medicalHistoryContainer.innerHTML = `
                    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Select pets first to see medical history forms.</p>
                    </div>
                `;
            } else {
                generateMedicalHistoryCards();
            }

            // Update hidden selected_pets field for form submission
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

            updateSelectedCount();
            updateSidebarSelectedPets();
        }

        function confirmPetSelection() {
            document.querySelectorAll('#petSelectionList input[type="checkbox"]').forEach(cb => cb.checked = false);
            refreshPetUI();
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

                    const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
                    const breedDisplay = pet.breed || 'Unknown';
                    const ageDisplay = formatAge(pet.age);
                    const weightDisplay = formatWeight(pet.weight);

                    const medicalCard = document.createElement('div');
                    medicalCard.className = 'bg-white border border-gray-200 rounded-2xl mb-4';
                    medicalCard.style.position = 'relative';
                    medicalCard.id = 'medical-history-' + petId;
                    medicalCard.innerHTML = `
                        <div class="bg-green-50 px-5 py-4 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    ${imageHtml}
                                    <div>
                                        <p class="font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                                        <p class="text-xs text-gray-500">${speciesDisplay} • ${breedDisplay}</p>
                                        <p class="text-xs text-gray-600 mt-1">Age: ${ageDisplay} • Weight: ${weightDisplay}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="event.stopPropagation(); removePet(${pet.id})" class="text-gray-400 hover:text-red-500 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="toggleMedicalAccordion(${pet.id})" class="text-gray-500 hover:text-gray-700 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="medicalArrow_${pet.id}" class="w-5 h-5 transform transition-transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="medicalContent_${pet.id}" class="p-5">
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Has ${pet.name || 'this pet'} received an anti-rabies vaccine before? <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_medical_history[${pet.id}][has_previous_vaccine]" value="yes" 
                                               class="h-5 w-5" onchange="togglePreviousVaccineFields(this, ${pet.id})">
                                        <span class="ml-3 text-gray-700 font-medium">Yes, has received before</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_medical_history[${pet.id}][has_previous_vaccine]" value="no" 
                                               class="h-5 w-5" onchange="togglePreviousVaccineFields(this, ${pet.id})">
                                        <span class="ml-3 text-gray-700 font-medium">No history / First time</span>
                                    </label>
                                </div>

                                <div id="previousVaccineFields_${pet.id}" class="hidden mt-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Last Anti-Rabies Vaccination <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                            <input type="date" name="pet_medical_history[${pet.id}][last_anti_rabies_date]" 
                                                   max="${antiRabiesMaxDate}" min="${antiRabiesMinDateStr}"
                                                   onchange="formatDateDisplay(this, 'antiRabiesDateDisplay_${pet.id}'); validateRabiesDateOnChange('${pet.id}')"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                            </div>
                                            <p id="antiRabiesDateDisplay_${pet.id}" class="text-xs text-gray-500 mt-1"></p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Clinic/Facility Where Administered <span class="text-gray-400 font-normal">(Optional)</span></label>
                                            <input type="text" name="pet_medical_history[${pet.id}][clinic_name]" placeholder="Dasmariñas City Vet, Private Clinic, or Barangay Drive"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                            <p class="text-xs text-gray-500 mt-1">Leave blank if you don't remember the exact clinic name.</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Vaccination Certificate <span class="text-gray-400 font-normal">(Optional)</span></label>
                                            <div class="relative">
                                                <select name="pet_medical_history[${pet.id}][vaccination_certificate]" onchange="toggleVaccineLotUpload(this, ${pet.id})" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none appearance-none">
                                                    <option value="">Select status</option>
                                                    <option value="available">Available (Will bring to appointment)</option>
                                                    <option value="digital">Digital Photo / Copy Available</option>
                                                    <option value="unavailable">No card / Lost or Unavailable</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div id="vaccineLotUpload_${pet.id}" class="hidden mt-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Vaccination Card Photo / PDF</label>
                                                <input type="file" name="pet_medical_history[${pet.id}][vaccination_certificate_file]" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-light">
                                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, or PDF up to 5MB.</p>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Vaccine Lot / Batch Number <span class="text-gray-400 font-normal">(Optional)</span></label>
                                             <input type="text" name="pet_medical_history[${pet.id}][vaccine_lot_number]" placeholder="e.g., G64884"
                                                    maxlength="6"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                            <p class="text-xs text-gray-500 mt-1">Found in the Vaccination Certificate</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Did ${pet.name || 'this pet'} undergo any surgery in the last two (2) weeks? <span class="text-red-500">*</span></label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_medical_history[${pet.id}][recent_surgery]" value="yes" class="h-5 w-5" onchange="handleSurgeryRadioChange(this, '${pet.id}')">
                                        <span class="ml-3 text-gray-700 font-medium">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="pet_medical_history[${pet.id}][recent_surgery]" value="no" class="h-5 w-5" onchange="handleSurgeryRadioChange(this, '${pet.id}')">
                                        <span class="ml-3 text-gray-700 font-medium">No</span>
                                    </label>
                                </div>
                                
                                <!-- Surgery Date Input (shown when Yes is selected) -->
                                <div id="surgeryDateContainer_${pet.id}" class="mt-3 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Surgery <span class="text-red-500">*</span></label>
                                    <input type="date" name="pet_medical_history[${pet.id}][surgery_date]" 
                                           max="{{ date('Y-m-d') }}"
                                           onchange="updatePetEligibilityState('${pet.id}')"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <div class="border-t border-gray-100 mt-4 pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Special Health or Handling Notes for ${pet.name || 'this pet'} <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <textarea name="pet_medical_history[${pet.id}][special_notes]" rows="3" placeholder="E.g., Anxious near other dogs, mild skin allergy, preferred muzzle..."
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"></textarea>
                            </div>
                        </div>
                    `;
                     container.appendChild(medicalCard);
                 }
             });
             
             selectedPets.forEach(petId => {
                 const dateInput = container.querySelector(`input[name="pet_medical_history[${petId}][last_anti_rabies_date]"]`);
                 if (dateInput && dateInput.value) {
                     formatDateDisplay(dateInput, 'antiRabiesDateDisplay_' + petId);
                 }
             });
         }

        function toggleMedicalAccordion(petId) {
            const content = document.getElementById('medicalContent_' + petId);
            const arrow = document.getElementById('medicalArrow_' + petId);
            if (!content || !arrow) return;

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        function togglePreviousVaccineFields(radio, petId) {
            const fieldsContainer = document.getElementById('previousVaccineFields_' + petId);
            if (radio.value === 'yes') {
                fieldsContainer.classList.remove('hidden');
            } else {
                fieldsContainer.classList.add('hidden');
            }
        }

        function toggleVaccineLotUpload(select, petId) {
            const uploadContainer = document.getElementById('vaccineLotUpload_' + petId);
            if (!uploadContainer) return;
            if (select.value === 'digital') {
                uploadContainer.classList.remove('hidden');
            } else {
                uploadContainer.classList.add('hidden');
            }
        }

        function removePet(petId) {
            // Remove from selectedPets array (convert to string for comparison)
            selectedPets = selectedPets.filter(id => String(id) !== String(petId));
            
            // Uncheck the checkbox in modal
            const checkbox = document.querySelector(`#petSelectionList input[value="${petId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
            
            refreshPetUI();
        }

        // Phone number formatting removed - no matching inputs in form

        updateSelectedCount();
        updateSlotPetCountBadge();

        const termsCheckbox = document.getElementById('termsCheckbox');
        const submitBtn = document.getElementById('submitBtn');
        if (termsCheckbox && submitBtn) {
            function updateSubmitButton() {
                if (termsCheckbox.checked) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-primary', 'text-white', 'hover:bg-primary-light');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitBtn.classList.remove('bg-primary', 'text-white', 'hover:bg-primary-light');
                }
            }
            termsCheckbox.addEventListener('change', updateSubmitButton);
            updateSubmitButton();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePetModal();
                closePetInfoModal();
                closeAlreadyBookedModal();
                closePetLimitModal();
                closeSubmissionModal();
                closeRabiesWarningModal();
                closeSurgeryWarningModal();
            }
        });

        function closeSubmissionModal() {
            const modal = document.getElementById('submissionModal');
            if (modal) modal.classList.add('hidden');
        }

        let rabiesWarningPetId = null;

        function closeRabiesWarningModal() {
            const modal = document.getElementById('rabiesWarningModal');
            if (modal) modal.classList.add('hidden');
            
            if (rabiesWarningPetId) {
                updatePetEligibilityState(rabiesWarningPetId);
                rabiesWarningPetId = null;
            }
        }

        function showRabiesWarningModal(petName, lastVaccinationDate, protectionUntil) {
            const modal = document.getElementById('rabiesWarningModal');
            const message = document.getElementById('rabiesWarningMessage');
            
            const lastDate = new Date(lastVaccinationDate + 'T00:00:00');
            const lastDateText = lastDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            const protectionDate = new Date(protectionUntil + 'T00:00:00');
            const protectionText = protectionDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            
            message.innerHTML = `
                <strong>For the safety and health of your pet, anti-rabies vaccinations are administered annually (every 12 months).</strong><br><br>
                Based on the date provided (${lastDateText}), your pet <strong>${petName}</strong> is fully protected until <strong>${protectionText}</strong>. Early re-vaccination is <strong class="text-red-600">not recommended</strong>.<br><br>
                If you believe this date is an error or need special clearance from the City Veterinarian, please contact the office directly.
            `;
            
            modal.classList.remove('hidden');
        }

        let surgeryWarningPetId = null;

        function closeSurgeryWarningModal() {
            const modal = document.getElementById('surgeryWarningModal');
            if (modal) modal.classList.add('hidden');
            
            if (surgeryWarningPetId) {
                updatePetEligibilityState(surgeryWarningPetId);
                surgeryWarningPetId = null;
            }
        }

        function showSurgeryWarningModal(petName) {
            const modal = document.getElementById('surgeryWarningModal');
            const message = document.getElementById('surgeryWarningMessage');
            
            message.innerHTML = `
                For <strong>${petName}</strong>'s health and safety, pets undergoing surgery or general anesthesia within the last 14 days cannot receive an anti-rabies vaccination.<br><br>
                <strong>Why?</strong> Post-surgical stress suppresses the immune system, preventing the vaccine from creating full immunity and increasing the risk of side effects.<br><br>
                <strong>Recommendation:</strong> Please reschedule the vaccination appointment at least 14 days after ${petName}'s surgery date. If this is an urgent situation, please consult the City Veterinarian directly.
            `;
            
            modal.classList.remove('hidden');
        }

        function handleSurgeryRadioChange(radio, petId) {
            const surgeryDateContainer = document.getElementById('surgeryDateContainer_' + petId);
            if (radio.value === 'yes') {
                if (surgeryDateContainer) {
                    surgeryDateContainer.classList.remove('hidden');
                }
                const pet = petsData.find(p => String(p.id) === String(petId));
                const petName = pet ? pet.name : 'this pet';
                surgeryWarningPetId = petId;
                showSurgeryWarningModal(petName);
            } else {
                if (surgeryDateContainer) {
                    surgeryDateContainer.classList.add('hidden');
                }
                surgeryWarningPetId = null;
            }
            updatePetEligibilityState(petId);
        }

        function updatePetEligibilityState(petId) {
            const medicalCard = document.getElementById('medical-history-' + petId);
            if (!medicalCard) return;
            
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (!pet) return;
            
            const appointmentDateInput = document.getElementById('globalAppointmentDate');
            const appointmentDate = appointmentDateInput ? appointmentDateInput.value : null;
            
            const historyContainer = document.getElementById('petMedicalHistoryContainer');
            const rabiesDateInput = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][last_anti_rabies_date]"]`) : null;
            const surgeryRadio = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][recent_surgery]"]:checked`) : null;
            const surgeryDateInput = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][surgery_date]"]`) : null;
            
            let isEligible = true;
            let reason = '';
            
            // Check rabies vaccination gap
            if (rabiesDateInput && rabiesDateInput.value && appointmentDate) {
                const result = validateRabiesVaccinationGap(petId, rabiesDateInput.value, appointmentDate);
                if (!result.valid) {
                    isEligible = false;
                    const lastDate = new Date(rabiesDateInput.value + 'T00:00:00');
                    const lastDateText = lastDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    reason = `${pet.name}'s last rabies shot was ${lastDateText}. Early re-vaccination is not recommended.`;
                }
            }
            
            // Check surgery eligibility
            if (surgeryRadio && surgeryRadio.value === 'yes' && surgeryDateInput && surgeryDateInput.value) {
                const surgeryDate = new Date(surgeryDateInput.value + 'T00:00:00');
                const eligibleDate = new Date(surgeryDate);
                eligibleDate.setDate(eligibleDate.getDate() + 14);
                
                if (appointmentDate) {
                    const appointment = new Date(appointmentDate + 'T00:00:00');
                    if (appointment < eligibleDate) {
                        isEligible = false;
                        const surgeryDateText = surgeryDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const eligibleDateText = eligibleDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        reason = `${pet.name} underwent surgery on ${surgeryDateText}. Vaccinations must be scheduled at least 14 days post-surgery (Eligible after ${eligibleDateText}).`;
                    }
                }
            }
            
            // Apply eligibility state with inline styles to avoid CSS conflicts
            if (!isEligible) {
                medicalCard.style.opacity = '0.5';
                medicalCard.style.backgroundColor = '#f3f4f6';
                medicalCard.style.borderColor = '#fecaca';
                medicalCard.style.pointerEvents = 'none';
                
                // Disable all inputs in this card
                const inputs = medicalCard.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => input.disabled = true);
                
                // Add or update eligibility badge
                let badge = medicalCard.querySelector('.eligibility-badge');
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'eligibility-badge inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold ml-2';
                    badge.title = reason;
                    medicalCard.appendChild(badge);
                }
                if (badge) {
                    badge.textContent = 'Not Eligible for Rabies Shot';
                    badge.title = reason;
                    badge.style.position = 'absolute';
                    badge.style.top = '-8px';
                    badge.style.left = '50%';
                    badge.style.transform = 'translateX(-50%)';
                    badge.style.zIndex = '10';
                }
                
                ineligiblePets[petId] = reason;
            } else {
                medicalCard.style.opacity = '1';
                medicalCard.style.backgroundColor = '';
                medicalCard.style.borderColor = '';
                medicalCard.style.pointerEvents = '';
                
                // Enable all inputs in this card
                const inputs = medicalCard.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => input.disabled = false);
                
                const badge = medicalCard.querySelector('.eligibility-badge');
                if (badge) {
                    badge.remove();
                }
                
                delete ineligiblePets[petId];
            }
            
            updateSidebarSelectedPets();
        }

        function showSuccessModal() {
            const modal = document.getElementById('submissionModal');
            const icon = document.getElementById('submissionModalIcon');
            const title = document.getElementById('submissionModalTitle');
            const message = document.getElementById('submissionModalMessage');
            const reason = document.getElementById('submissionModalReason');
            const actions = document.getElementById('submissionModalActions');

            icon.innerHTML = '<div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></div>';
            title.textContent = 'Success';
            message.textContent = 'Your vaccination pre-registration has been submitted successfully.';
            reason.classList.add('hidden');
            actions.innerHTML = '<button type="button" onclick="window.location.href=\'/vaccination\'" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">Okay</button>';

            modal.classList.remove('hidden');
        }

        function showErrorModal(reason, detail) {
            const modal = document.getElementById('submissionModal');
            const icon = document.getElementById('submissionModalIcon');
            const title = document.getElementById('submissionModalTitle');
            const message = document.getElementById('submissionModalMessage');
            const reasonEl = document.getElementById('submissionModalReason');
            const actions = document.getElementById('submissionModalActions');

            const reasonMessages = {
                'slot_overbooked': 'The selected time slot just filled up while you were booking.',
                'network_timeout': 'Connection lost. Please check your internet connection and try again.',
                'file_upload_error': 'Uploaded image exceeds the 5MB limit or is an invalid file format.',
                'system_error': 'Our clinic system is experiencing temporary maintenance. Your form data is saved.',
            };

            const messageText = reasonMessages[reason] || 'We couldn\'t process your appointment booking.';
            const reasonText = detail ? `Reason: ${detail}` : `Reason: ${messageText}`;

            icon.innerHTML = '<div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></div>';
            title.textContent = 'Booking Failed';
            message.textContent = 'We couldn\'t process your appointment booking.';
            reasonEl.textContent = reasonText;
            reasonEl.classList.remove('hidden');
            actions.innerHTML = '<button type="button" onclick="closeSubmissionModal(); setSubmitLoading(false);" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">Try Again</button>';

            modal.classList.remove('hidden');
        }

        function setSubmitLoading(isLoading) {
            const submitBtn = document.getElementById('submitBtn');
            if (!submitBtn) return;

            if (isLoading) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Booking your appointment...';
                submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-primary', 'text-white', 'hover:bg-primary-light');
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Submit Vaccination Pre-Registration';
                submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.add('bg-primary', 'text-white', 'hover:bg-primary-light');
            }
        }

        function scrollToError(targetId) {
            if (!targetId) return;
            const element = document.getElementById(targetId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.classList.add('ring-2', 'ring-red-500', 'ring-offset-2');
                setTimeout(() => {
                    element.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
                }, 3000);
            }
        }

        @if(session('error'))
        window.addEventListener('DOMContentLoaded', function() {
            const errorReason = "{{ session('error_reason', 'system_error') }}";
            const errorMessage = "{{ session('error') }}";
            showErrorModal(errorReason, errorMessage);
        });
        @endif

        @if ($errors->any())
        window.addEventListener('DOMContentLoaded', function() {
            const firstErrorInput = document.querySelector('#vaccinationForm input:not([type="hidden"]):not([type="submit"]), #vaccinationForm select, #vaccinationForm textarea');
            if (firstErrorInput) {
                const targetId = firstErrorInput.id || '';
                if (targetId) {
                    scrollToError(targetId);
                } else {
                    firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorInput.classList.add('ring-2', 'ring-red-500', 'ring-offset-2');
                    setTimeout(() => {
                        firstErrorInput.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
                    }, 3000);
                }
            }
        });
        @endif

        // Form submission handler
        const vaccinationForm = document.getElementById('vaccinationForm');
        if (vaccinationForm) {
            vaccinationForm.addEventListener('submit', function(e) {
                const termsCheckbox = document.getElementById('termsCheckbox');
                if (!termsCheckbox || !termsCheckbox.checked) {
                    e.preventDefault();
                    showErrorModal('validation', 'Please accept the terms and conditions before submitting.');
                    return;
                }

                // Validate rabies vaccination gaps
                const appointmentDateInput = document.getElementById('globalAppointmentDate');
                const appointmentDate = appointmentDateInput ? appointmentDateInput.value : null;
                
                if (appointmentDate) {
                    selectedPets.forEach(petId => {
                        const pet = petsData.find(p => String(p.id) === String(petId));
                        if (!pet) return;
                        
                        const historyContainer = document.getElementById('petMedicalHistoryContainer');
                        const dateInputEl = historyContainer ? historyContainer.querySelector(`input[name="pet_medical_history[${petId}][last_anti_rabies_date]"]`) : null;
                        
                        if (dateInputEl && dateInputEl.value) {
                            const result = validateRabiesVaccinationGap(petId, dateInputEl.value, appointmentDate);
                            if (!result.valid) {
                                rabiesWarningPetId = petId;
                                e.preventDefault();
                                showRabiesWarningModal(pet.name, dateInputEl.value, result.protectionUntil);
                                return;
                            }
                        }
                    });
                }

                setSubmitLoading(true);
            });
        }
    </script>
</body>
</html>

