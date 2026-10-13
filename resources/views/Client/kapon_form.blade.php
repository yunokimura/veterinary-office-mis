<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapon Application - Dasmariñas City Veterinary Services</title>
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
        input[type="checkbox"], input[type="radio"] {
            accent-color: #066D33;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('Client.partials.navbar')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Title and Required Fields Notice -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">SPAY/NEUTER (KAPON)</h2>
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
                <form method="POST" action="{{ url('/kapon/form') }}" id="kaponForm" onsubmit="return validateKaponForm(event)">
                @csrf
                <input type="hidden" name="pets_data" id="petsDataJson" value="">
                <input type="hidden" name="appointment_date" id="appointment_date" value="">
                <input type="hidden" name="appointment_time" id="appointment_time" value="">
                <div id="selectedPetsArrayContainer"></div>
                <input type="hidden" name="first_name" value="{{ $petOwner->first_name ?? '' }}">
                <input type="hidden" name="last_name" value="{{ $petOwner->last_name ?? '' }}">
                <input type="hidden" name="email" value="{{ $user->email ?? '' }}">
                <input type="hidden" name="mobile_number" value="{{ $petOwner->phone_number ?? '' }}">
                <input type="hidden" name="alt_mobile_number" value="{{ $petOwner->alternate_phone_number ?? '' }}">
                <input type="hidden" name="blk_lot_ph" value="{{ $petOwner->address->block_lot_phase ?? '' }}">
                <input type="hidden" name="street" value="{{ $petOwner->address->street ?? '' }}">
                <input type="hidden" name="barangay" value="{{ $petOwner->address->barangay->barangay_name ?? '' }}">

                <!-- Card 1: PET'S INFORMATION -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">PET'S INFORMATION</h4>
                        </div>
                        <div class="flex items-center gap-3">
                            <span id="headerSelectedCount" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-900 text-white text-xs font-semibold">
                                0 Pets Selected
                            </span>
                            <button type="button" onclick="openPetModal()" 
                                    class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Select Pet
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- IMPORTANT NOTES Box -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                            <p class="font-semibold text-yellow-700 mb-2">IMPORTANT NOTES:</p>
                            <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                                <li><strong>Post-Cesarean/Major Surgery Cases:</strong> If your pet has undergone cesarean or major surgery related to reproductive organs, please book at another veterinary clinic.</li>
                                <li><strong>Vaccinations and Kapon Surgery:</strong> If your pet has been recently vaccinated or is scheduled for vaccination, we recommend scheduling 2 weeks before or after.</li>
                            </ul>
                        </div>

                        <!-- Selected Pets List with Empty State -->
                        <div id="selectedPetsContainer" class="mb-6">
                            <div id="selectedPetsList" class="grid md:grid-cols-1 gap-4">
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
                </div>

                <!-- Card 2: APPOINTMENT SCHEDULING -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">APPOINTMENT SCHEDULING</h4>
                        </div>
                        <span id="slotPetCountBadge" class="text-xs bg-emerald-800 text-emerald-200 font-medium px-2.5 py-1 rounded-full border border-emerald-700">
                            0 Pets Selected
                        </span>
                    </div>
                    <div class="p-6">
                        <div id="globalSchedulerContainer">
                            <!-- Date Picker -->
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Select Appointment Date <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-3 flex-wrap">
                                    <input type="date"
                                           id="globalAppointmentDate"
                                           min="{{ date('Y-m-d') }}"
                                           onchange="loadKaponGlobalSlots()"
                                           class="w-full sm:w-64 px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                    <span id="globalDailyCapacity" class="hidden inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-medium"></span>
                                </div>
                                <p id="selectedDateText" class="text-xs text-emerald-700 mt-1.5 font-medium flex items-center gap-1 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Selected Date: <span id="globalSelectedDate">-</span>
                                </p>
                            </div>

                            <!-- Group Booking Banner -->
                            <div id="groupBookingBanner" class="mb-4 bg-emerald-50 border border-emerald-200 rounded-lg p-3 flex items-start gap-2.5 text-xs text-emerald-900 hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <span class="font-bold">Group Booking Policy:</span> Selecting <span id="bannerSelectedTime" class="font-bold">-</span> will reserve slot capacity for all <span id="bannerPetCount" class="font-bold">-</span> selected pets (<span id="bannerPetNames" class="font-bold">-</span>) during this same 1-hour clinic block.
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div id="globalTimeSlots" class="mb-3 hidden">
                                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">
                                    Select Preferred Time Slot <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" id="globalSlotsGrid">
                                    <!-- Slots will be loaded dynamically -->
                                </div>
                            </div>

                            <!-- Selected Summary -->
                            <div id="globalSelectedSummary" class="hidden bg-emerald-50 border border-emerald-200 rounded-lg p-3">
                                <p class="text-sm text-emerald-700 font-medium">
                                    Selected: <span id="globalSelectedDateSummary">-</span>
                                </p>
                                <div id="selectedSlotsList" class="mt-1 space-y-1"></div>
                            </div>

                            <!-- Schedule Required Warning (inline) -->
                            <div id="alreadyScheduledWarning" class="hidden mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-red-700">Schedule Required</h4>
                                        <p id="alreadyScheduledText" class="text-sm text-red-600 mt-1"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: AGREEMENT -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">AGREEMENT</h4>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="petAgreementsContainer" class="space-y-6">
                            <!-- Per-pet agreement cards will be dynamically generated here -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                                <p class="text-sm text-yellow-700">Please select pets first to see the agreement forms.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: GENERAL AGREEMENT -->
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-emerald-950 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h4 class="text-sm font-semibold text-white">GENERAL AGREEMENT</h4>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Secure cage/leash -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[secure_cage]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">I understand that I must place my pet/s inside a secure cage or leash. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Keep indoors -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[keep_indoors]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">I will keep my pet/s indoors until they are fully healed. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Keep incision dry -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[keep_dry]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">I will keep their incision dry and refrain from bathing this animal for the next 2 weeks. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Full authority -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[full_authority]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">I hereby give the Dasmariñas City Veterinary Office (CVO) and its attending veterinarians and staff full authority to perform the procedure. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Valid ID -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[valid_id]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">I will bring and present a valid primary ID before entering the premises of the CVO for security purposes. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Confirmation of Location -->
                        <div>
                            <label class="inline-flex items-start cursor-pointer">
                                <input type="checkbox" name="general_agreement[location]" value="yes" class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 focus:ring-primary/20" required>
                                <span class="ml-3 text-sm text-gray-700">Confirmation of location: I am aware that the spay/neuter surgery will be performed at the veterinary office located in Dasmariñas City. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Disclaimer -->
                        <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="text-sm text-red-700">*** Dasmariñas City Veterinary Office (CVO) and its licensed veterinarians will not be held liable in the event of complications, including injury or death, during surgery. These may result due to undiagnosed illnesses that may be detected and treated if a blood test is performed.</p>
                            <p class="text-sm text-red-700 mt-2">*** Pure and half-breed pets or brachycephalic (short-nosed) breeds are required to submit the results of blood tests prior to surgery. It is highly recommended that aspins and puspins with preexisting conditions be tested as well.</p>
                        </div>

                        <!-- Submit Button (vaccination-style, centered) -->
                        <div class="flex justify-center mt-8">
                            <button type="submit" class="bg-primary text-white px-12 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Submit Application
                            </button>
                        </div>
</div>
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
                                    <p class="text-sm text-gray-600 mb-4">Select one or more pets for Kapon (Spay/Neuter) surgery:</p>
                                    <div class="space-y-3" id="petSelectionList">
                                        @foreach($petsArray as $pet)
                                            @php
                                                $speciesDisplay = isset($pet['species']) ? ucfirst($pet['species']) : 'Unknown';
                                                $isNeutered = isset($pet['is_neutered']) && strtolower((string) $pet['is_neutered']) === 'yes';
                                                $petGender = strtolower((string) ($pet['sex'] ?? $pet['gender'] ?? ''));
                                                $surgeryLabel = ($petGender === 'female') ? 'Spayed' : 'Neutered';
                                                $cardClasses = 'flex items-start p-4 border rounded-lg cursor-pointer pet-selection-card';
                                                if ($isNeutered) {
                                                    $cardClasses .= ' opacity-60 grayscale cursor-not-allowed bg-gray-100 border-gray-200';
                                                } else {
                                                    $cardClasses .= ' border-gray-200 hover:bg-green-50 hover:border-primary transition-colors';
                                                }
                                            @endphp
                                            <label class="{{ $cardClasses }}" data-pet-id="{{ $pet['id'] }}">
                                                <input type="checkbox" name="selected_pets[]" value="{{ $pet['id'] }}" 
                                                       class="mt-1 w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary pet-checkbox"
                                                       onchange="togglePetSelection(this)"
                                                       @if($isNeutered) disabled @endif>
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
                                                @if($isNeutered)
                                                <div class="ml-2 flex-shrink-0">
                                                    <span class="text-xs px-2 py-1 bg-gray-200 text-gray-600 rounded font-medium">{{ $surgeryLabel }}</span>
                                                </div>
                                                @endif
                                                @if(!empty($pet['image']) && !$isNeutered)
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

                <script>
                    // Pet data from server
                    const petsData = @json($petsArray);
                    const currentUserId = @json($userId ?? null);
                    
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
                    
                    // Global kapon appointment scheduling (shared by all selected pets)
                    let globalKaponSlotsData = [];
                    let selectedKaponSlotTime = null;

                    function getKaponPetNamesString() {
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
                        bannerNames.textContent = getKaponPetNamesString();
                    }

                    async function loadKaponGlobalSlots() {
                        const dateInput = document.getElementById('globalAppointmentDate');
                        const selectedDate = dateInput.value;
                        if (!selectedDate) return;

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
                            slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-medium';
                        }
                        
                        if (selectedDateText && globalSelectedDate) {
                            selectedDateText.classList.remove('hidden');
                            const dateObj = new Date(selectedDate + 'T00:00:00');
                            globalSelectedDate.textContent = dateObj.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                        }

                        try {
                            const response = await fetch(`/api/appointments/slots?date=${selectedDate}&service_type=kapon`);
                            const data = await response.json();
                            
                            if (data.success) {
                                globalKaponSlotsData = data.slots;
                                const dailyRemaining = data.daily_remaining || 0;
                                
                                if (slotStatus) {
                                    if (dailyRemaining <= 0) {
                                        slotStatus.textContent = 'Fully Booked';
                                        slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium';
                                    } else if (dailyRemaining === 1) {
                                        slotStatus.textContent = '1 slot left';
                                        slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium';
                                    } else {
                                        slotStatus.textContent = 'Available';
                                        slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium';
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
                                        const isSelected = selectedKaponSlotTime === slot.time;
                                        
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
                                            slotBtn.onclick = () => selectGlobalKaponSlot(slot);
                                        }
                                        
                                        slotsGrid.appendChild(slotBtn);
                                    });
                                    
                                    slotsGrid.classList.remove('hidden');
                                    globalTimeSlots.classList.remove('hidden');
                                }
                            }
                        } catch (error) {
                            console.error('Failed to load kapon slots:', error);
                            if (slotStatus) {
                                slotStatus.textContent = 'Error loading slots';
                                slotStatus.className = 'inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium';
                            }
                        }
                    }

                    function selectGlobalKaponSlot(slot) {
                        const date = document.getElementById('globalAppointmentDate').value;
                        selectedKaponSlotTime = slot.time;
                        
                        document.getElementById('appointment_date').value = date;
                        document.getElementById('appointment_time').value = slot.time;
                        
                        const dateObj = new Date(date + 'T00:00:00');
                        const dateText = dateObj.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                        const timeText = slot.display_time || slot.time;
                        
                        const summary = document.getElementById('globalSelectedSummary');
                        const globalSelectedDateSummary = document.getElementById('globalSelectedDateSummary');
                        const selectedSlotsList = document.getElementById('selectedSlotsList');
                        
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
                        
                        // Hide schedule-required warning once valid
                        const warning = document.getElementById('alreadyScheduledWarning');
                        if (warning) warning.classList.add('hidden');
                        
                        updateGroupBookingBanner(timeText);
                        loadKaponGlobalSlots();
                    }

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

                        // Re-check already selected pets and refresh the modal count
                        selectedPets.forEach(petId => {
                            const checkbox = document.querySelector(`#petSelectionList input[value="${petId}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                        updateModalSelectedCount();
                    }

                    function closePetModal() {
                        document.getElementById('petModal').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    function togglePetSelection(checkbox) {
                        // Ignore if checkbox is disabled (neutered pet)
                        if (checkbox.disabled) {
                            return;
                        }
                        const petId = String(checkbox.value);

                        if (checkbox.checked) {
                            // Check if max limit reached
                            if (selectedPets.length >= 2) {
                                checkbox.checked = false;
                                showPetLimitModal();
                                return;
                            }
                            
                            // Check if pet already has a kapon appointment
                            checkPetBooking(petId, checkbox);
                        } else {
                            selectedPets = selectedPets.filter(id => String(id) !== petId);
                            updateModalSelectedCount();
                        }
                    }
                    
                    async function checkPetBooking(petId, checkbox) {
                        try {
                            const url = currentUserId 
                                ? `/api/appointments/check-pet/${encodeURIComponent(petId)}/${currentUserId}`
                                : `/api/appointments/check-pet/${encodeURIComponent(petId)}`;
                            const response = await fetch(url);
                            const data = await response.json();
                            
                            if (data.already_booked) {
                                // Uncheck the checkbox
                                checkbox.checked = false;
                                
                                // Show warning modal
                                showAlreadyBookedModal(data);
                                return;
                            }
                            
                            // If not booked, add to selection (rendering happens on Confirm)
                            if (!selectedPets.includes(petId)) {
                                selectedPets.push(petId);
                            }
                            updateModalSelectedCount();
                        } catch (error) {
                            console.error('Failed to check pet booking:', error);
                            // On error, allow selection but log for debugging
                            if (!selectedPets.includes(petId)) {
                                selectedPets.push(petId);
                            }
                            updateModalSelectedCount();
                        }
                    }
                    
                    function showAlreadyBookedModal(data) {
                        const modalHtml = `
                            <div id="alreadyBookedModal" class="fixed inset-0 z-50">
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
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Already Booked</h3>
                                        <p class="text-gray-600 mb-2">${data.pet_name} already has a kapon appointment scheduled.</p>
                                        <p class="text-gray-800 font-medium mb-4">Date: ${data.scheduled_date}<br>Time: ${data.scheduled_time}</p>
                                        <p class="text-gray-500 text-sm mb-6">Please complete this appointment first before booking a new one.</p>
                                        <button type="button" onclick="closeAlreadyBookedModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">
                                            I understand
                                        </button>
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
                        const modalHtml = `
                            <div id="petLimitModal" class="fixed inset-0 z-50">
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
                                        <p class="text-gray-600 mb-6">To ensure fair slot distribution and smooth form submission, a maximum of 2 pets is allowed per transaction. Please complete this form first and submit a new application for additional pets.</p>
                                        <button type="button" onclick="closePetLimitModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">
                                            I understand
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.insertAdjacentHTML('beforeend', modalHtml);
                        document.body.style.overflow = 'hidden';
                    }

                    function closePetLimitModal() {
                        const modal = document.getElementById('petLimitModal');
                        if (modal) {
                            modal.remove();
                        }
                        document.body.style.overflow = 'auto';
                    }

                    // 9.4: Submit guard - ensure a global appointment date/time is chosen
                    function validateKaponForm(event) {
                        const dateValue = document.getElementById('appointment_date')?.value;
                        const timeValue = document.getElementById('appointment_time')?.value;
                        const hasSchedule = !!(dateValue && timeValue);
                        
                        if (!hasSchedule && selectedPets.length > 0) {
                            event.preventDefault();
                            const schedulingCard = document.getElementById('globalSchedulerContainer');
                            if (schedulingCard) {
                                schedulingCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            // Show a brief warning
                            const warning = document.getElementById('alreadyScheduledWarning');
                            if (warning) {
                                warning.classList.remove('hidden');
                                document.getElementById('alreadyScheduledText').textContent = 'Please select an appointment date and time slot before submitting.';
                            }
                            return false;
                        }
                        return true;
                    }

                    function updateModalSelectedCount() {
                        const modalCountEl = document.getElementById('selectedCount');
                        if (modalCountEl) modalCountEl.textContent = selectedPets.length;
                    }

                    function updateSelectedCount() {
                        updateModalSelectedCount();
                        updateHeaderCountBadges();
                        updateSidebarSelectedPets();
                        // Keep the selected-slot summary and group banner in sync with the pet list
                        if (selectedKaponSlotTime) {
                            updateGroupBookingBanner(selectedKaponSlotTime);
                            const selectedSlotsList = document.getElementById('selectedSlotsList');
                            if (selectedSlotsList) {
                                selectedSlotsList.innerHTML = '';
                                selectedPets.forEach(pid => {
                                    const pet = petsData.find(p => String(p.id) === String(pid));
                                    const petName = pet ? pet.name : 'Pet ' + pid;
                                    const item = document.createElement('div');
                                    item.className = 'text-xs text-emerald-700';
                                    item.textContent = petName + ': ' + selectedKaponSlotTime;
                                    selectedSlotsList.appendChild(item);
                                });
                            }
                        }
                    }

                    // 9.2: Update sidebar selected pets list with remove buttons
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

                            const petEl = document.createElement('div');
                            petEl.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
                            petEl.innerHTML = `
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-medium text-gray-900">${pet.name}</p>
                                        <p class="text-xs text-gray-500">${pet.species || 'Unknown'} • ${pet.breed || 'Unknown'}</p>
                                    </div>
                                </div>
                                <button type="button" onclick="removePet(${pet.id})" class="text-red-500 hover:text-red-700 p-1" aria-label="Remove ${pet.name}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            `;
                            sidebarContainer.appendChild(petEl);
                        });
                    }

                    // 9.3: Update header count badges (following vaccination pattern)
                    function updateHeaderCountBadges() {
                        const count = selectedPets.length;
                        const headerBadge = document.getElementById('headerSelectedCount');
                        const slotBadge = document.getElementById('slotPetCountBadge');
                        const sidebarBadge = document.getElementById('selectedPetCount');
                        const modalBadge = document.getElementById('selectedCount');

                        if (headerBadge) headerBadge.textContent = count + ' Pet' + (count === 1 ? ' Selected' : 's Selected');
                        if (slotBadge) slotBadge.textContent = count + ' Pet' + (count === 1 ? ' Selected' : 's Selected');
                        if (sidebarBadge) sidebarBadge.textContent = count;
                        if (modalBadge) modalBadge.textContent = count;
                    }

                    function updatePetsData() {
                        // Get full pet details for all selected pets
                        const selectedPetsData = selectedPets.map(petId => {
                            return petsData.find(p => String(p.id) === String(petId));
                        }).filter(p => p !== undefined);
                        
                        document.getElementById('petsDataJson').value = JSON.stringify(selectedPetsData);
                    }

                    function confirmPetSelection() {
                        const container = document.getElementById('selectedPetsList');
                        const noPetsMessage = document.getElementById('noPetsSelected');
                        const modalFooter = document.querySelector('#petModal .bg-gray-50');

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
                                    imageHtml = `<img src="${imageSrc}" alt="${pet.name}" class="w-20 h-20 rounded-full object-cover">`;
                                } else {
                                    imageHtml = `<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>`;
                                }

                                // Add pet info card (read-only display, matching missing-pets form)
                                const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
                                const genderValue = pet.sex ?? pet.gender;
                                const genderDisplay = genderValue ? String(genderValue).charAt(0).toUpperCase() + String(genderValue).slice(1) : 'Unknown';
                                const isNeutered = String(pet.is_neutered ?? '').toLowerCase() === 'yes';
                                const neuteredDisplay = isNeutered ? 'Yes' : 'No';
                                const surgeryLabel = String(genderValue ?? '').toLowerCase() === 'female' ? 'Spayed' : 'Neutered';

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
                                                <div><span class="text-gray-500">${surgeryLabel}:</span> <span class="text-gray-900">${neuteredDisplay}</span></div>
                                                <div><span class="text-gray-500">Weight:</span> <span class="text-gray-900">${formatWeight(pet.weight)}</span></div>
                                                <div><span class="text-gray-500">Age:</span> <span class="text-gray-900">${formatAge(pet.age)}</span></div>
                                            </div>
                                        </div>
                                        <button type="button" onclick="removePet(${pet.id})" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                `;
                                container.appendChild(petCard);
                            }
                        });

                        // Update hidden pets_data field with current pet selection
                        updatePetsData();
                        // Render sidebar list, header badges, and refresh slot summary
                        updateSelectedCount();
                        // Generate agreement cards immediately so browser required validation works
                        generatePetAgreementCards();
                        // Reset modal checkboxes so reopening the modal starts fresh
                        document.querySelectorAll('#petSelectionList input[type="checkbox"]').forEach(cb => cb.checked = false);
                        closePetModal();
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
                        updatePetsData();
                    }

                    // Close modal on escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closePetModal();
                        }
                    });
                </script>

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

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ url('/kapon') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                ← Back to Kapon Page
            </a>
        </div>
</main>

    @include('Client.partials.footer')

<script>
    // Generate per-pet agreement cards for Part 3
    function generatePetAgreementCards() {
        const container = document.getElementById('petAgreementsContainer');
        
        if (selectedPets.length === 0) {
            container.innerHTML = `
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <p class="text-sm text-yellow-700">Please select pets in Part 2 first to see the agreement forms.</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        
        selectedPets.forEach(petId => {
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (pet) {
                // Determine if pet is over 4 years old
                let isOver4Years = false;
                const ageStr = String(pet.age).toLowerCase();
                
                const yearMatch = ageStr.match(/(\d+)\s*year/);
                if (yearMatch) {
                    const years = parseInt(yearMatch[1]);
                    isOver4Years = years > 4;
                } else if (ageStr.includes('over')) {
                    isOver4Years = true;
                }
                
                // Determine pet type for blood test logic
                const species = String(pet.species || '').toLowerCase();
                const breed = String(pet.breed || '').toLowerCase();
                
                // Check if it's a cat
                const isCat = species === 'cat';
                
                // Check if it's an Aspin (local dog)
                const isAspin = species === 'dog' && (breed.includes('aspin') || breed === 'mixed breed (aspin)');
                
                // Check if it's a purebred or mixed dog (not Aspin)
                const isOtherDog = species === 'dog' && !isAspin;
                
                const petCard = document.createElement('div');
                petCard.className = 'bg-white border border-gray-200 rounded-lg p-6 mb-6';
                petCard.id = 'pet-agreement-' + petId;
                
                let bloodTestSection = '';
                
                if (isOver4Years) {
                    // Over 4 years old - single checkbox option
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For those with mixed or purebred dogs and/or over 4 years old:</p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                } else if (isCat || isAspin) {
                    // Under 4 years old, Cat or Aspin - two radio button options
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="radio" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="pet_agreement[${pet.id}][blood_test]" value="waive" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">I understand the risk of not getting the blood test for my pet so I am waiving the option as I am sure that my pet is/are healthy ASPIN or CAT under 4 years old. <strong class="text-red-600 font-medium">The Dasmariñas City Veterinary Office (CVO) will not be held liable in the event of complications, injury, or death that may result from the surgery due to undiagnosed illnesses that could have been treated if a blood test was performed.</strong></span>
                                </label>
                            </div>
                        </div>
                    `;
                } else if (isOtherDog) {
                    // Under 4 years old, Purebred or Mixed Dog (not Aspin) - single checkbox option
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                } else {
                    // Fallback - default to requiring blood test
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                }
                
                petCard.innerHTML = `
                    <div class="flex items-center mb-4 pb-3 border-b">
                        ${pet.image ? (function() {
                            let imgPath = pet.image;
                            if (!imgPath.includes('images/pets') && !imgPath.includes('http')) {
                                imgPath = 'images/pets/' + pet.image.split('/').pop();
                            }
                            const imageSrc = imgPath.startsWith('http') ? imgPath : "{{ asset('') }}" + imgPath;
                            return `<img src="${imageSrc}" alt="${pet.name}" class="w-10 h-10 rounded-full object-cover">`;
                        })() : `
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>`}
                        <div class="ml-3">
                            <h4 class="font-semibold text-gray-900">${pet.name}</h4>
                            <p class="text-xs text-gray-500">${pet.species || 'Unknown'} • ${pet.breed || 'Unknown'} • Age: ${formatAge(pet.age)}</p>
                        </div>
                        ${isOver4Years ? '<span class="ml-auto text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded">Over 4 years - Blood test required</span>' : ''}
                    </div>
                    
                    ${bloodTestSection}
                    
                    <!-- Previous Surgery -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet had undergone previous surgery <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][previous_surgery]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][previous_surgery]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Health Condition -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Health Condition (Has the pet been healthy for the past 3 weeks or longer?) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][health_condition]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][health_condition]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Other health information -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1.5">
                            Other health information about your pet
                        </label>
                        <p class="text-xs text-gray-500 italic mb-2">If your pet has any existing or previously treated health condition that was not disclosed to us prior to the procedure, CVO cannot be held liable for any health issues that may arise afterward.</p>
                        <textarea name="pet_agreement[${pet.id}][health_info]" rows="3"
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                  placeholder="Please share any relevant medical information..."></textarea>
                    </div>
                    
                    <!-- Physical Assessment -->
                    <div class="mb-4">
                        <label class="inline-flex items-start">
                            <input type="checkbox" name="pet_agreement[${pet.id}][physical_assessment]" value="yes" class="mt-1 text-primary">
                            <span class="ml-2 text-sm text-gray-600"><strong>Physical Assessment: <span class="text-red-500">*</span> </strong> Your pet's safety is our priority. Please understand that as an LGU with limited facilities and no confinement area; we may not be equipped to handle certain medical conditions. By checking the box, you acknowledged that a veterinary assessment is required before surgery, and that the procedure may be declined based on the results of the evaluation.</span>
                        </label>
                    </div>
                    
                    <!-- Pyometra -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet has pyometra <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][pyometra]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][pyometra]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- In Heat -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet is/are in heat <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][in_heat]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][in_heat]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Food Restriction -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Food Restriction (Has the pet not eaten any food or liquids for the past 12 hours prior to surgery?) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][food_restriction]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][food_restriction]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                `;
                
                container.appendChild(petCard);
            }
        });
    }
</script>

    @include('Client.partials.footer')

</body>
</html>



