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
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">MISSING PET REPORT</h2>
            <p class="mt-2 text-gray-600 text-sm text-center">
                Fields marked with <span class="text-red-500">*</span> are required
            </p>
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

        <!-- Form Card with Progress Steps -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700" id="stepLabel">Step 1 of 5</span>
                    <span class="text-sm font-medium text-primary" id="stepTitle">Part 1: Owner's Information</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-primary h-2.5 rounded-full transition-all duration-300" style="width: 20%"></div>
                </div>
                <div class="flex justify-between mt-2">
                    <div class="text-xs text-center flex-1">
                        <div id="step1Indicator" class="font-semibold text-primary">1</div>
                        <div class="text-gray-500">Owner</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step2Indicator" class="font-semibold text-gray-400">2</div>
                        <div class="text-gray-400">Pet</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step3Indicator" class="font-semibold text-gray-400">3</div>
                        <div class="text-gray-400">Marks</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step4Indicator" class="font-semibold text-gray-400">4</div>
                        <div class="text-gray-400">Location</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step5Indicator" class="font-semibold text-gray-400">5</div>
                        <div class="text-gray-400">Photo</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('missing-pets.report.store') }}" enctype="multipart/form-data" onsubmit="syncReporterFields()">
                @csrf

                <!-- PART 1: OWNER'S INFO -->
                <div id="part1" class="form-part">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 1: Owner's Information</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1.5">
                                    Pet Owner's Name <span class="text-red-500">*</span>
                                    <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $petOwner->first_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                    <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name', $petOwner->last_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email', $user->email ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Mobile Number -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Mobile Number <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                        +63
                                    </span>
                                    <input type="tel" name="mobile_number" placeholder="943 210 2012" maxlength="12" value="{{ old('mobile_number', $petOwner->phone_number ?? '') }}"
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
                    
                    <!-- Navigation Buttons for Part 1 -->
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ url('/missing-pets') }}" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Missing Pets
                        </a>
                        <button type="button" onclick="goToStep(2)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Pet's Information
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 2: PET'S INFO -->
                <div id="part2" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 2: Pet's Information</h3>

                    <!-- Selected Pets Display Area -->
                    <div id="selectedPetsContainer" class="mb-6">
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
                    
                    <!-- Navigation Buttons for Part 2 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(1)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(3)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Physical Marks
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Pet Selection Modal -->
                <div id="petModal" class="fixed inset-0 z-50 hidden">
                    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePetModal()"></div>
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Select Your Pet</h3>
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
                                                $genderDisplay = isset($pet['gender']) ? ucfirst($pet['gender']) : 'Unknown';
                                                $neuteredDisplay = isset($pet['is_neutered']) ? ($pet['is_neutered'] ? 'Yes' : 'No') : 'Unknown';
                                            @endphp
                                            <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 hover:border-primary transition-colors pet-selection-card" data-pet-id="{{ $pet['id'] }}">
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
                                                        <div>Gender: {{ $genderDisplay }}</div>
                                                        <div>Neutered: {{ $neuteredDisplay }}</div>
                                                        <div>Weight: {{ isset($pet['weight']) ? (str_contains(strtolower($pet['weight']), 'kg') || strtolower($pet['weight']) == 'n/a' ? $pet['weight'] : $pet['weight'] . ' kg') : 'Unknown' }}</div>
                                                        <div class="col-span-2">Age: {{ isset($pet['age']) ? str_replace('_', ' ', $pet['age']) : 'Unknown' }}</div>
                                                    </div>
                                                </div>
                                                @if(!empty($pet['image']))
                                                <div class="ml-2 flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $pet['image']) }}" alt="{{ $pet['name'] }}" class="w-12 h-12 rounded-full object-cover">
                                                </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex justify-end items-center">
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
                    }

                    function confirmPetSelection() {
                        const container = document.getElementById('selectedPetsList');
                        const noPetsMessage = document.getElementById('noPetsSelected');

                        if (selectedPets.length === 0) {
                            alert('Please select at least one pet');
                            return;
                        }

                        container.innerHTML = '';
                        
                        if (noPetsMessage) {
                            noPetsMessage.remove();
                        }

                        selectedPets.forEach(petId => {
                            const pet = petsData.find(p => String(p.id) === String(petId));
                            if (pet) {
                                const genderDisplay = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1) : 'Unknown';
                                const neuteredDisplay = pet.is_neutered ? 'Yes' : 'No';
                                const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';

                                let imageHtml = '';
                                if (pet.image) {
                                    imageHtml = `<img src="{{ asset('storage/') }}/${pet.image}" alt="${pet.name}" class="w-20 h-20 rounded-full object-cover">`;
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
                            }
                        });

                        closePetModal();
                    }

                    function removePet(petId) {
                        selectedPets = selectedPets.filter(id => String(id) !== String(petId));
                        
                        const container = document.getElementById('selectedPetsList');
                        
                        if (selectedPets.length === 0) {
                            container.innerHTML = `
                                <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500">No pet selected yet. Click "Select Pet" to choose from your registered pets.</p>
                                </div>
                            `;
                        } else {
                            confirmPetSelection();
                        }
                    }

                    function changePetSelection() {
                        openPetModal();
                    }

                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closePetModal();
                        }
                    });
                </script>

                <!-- PART 3: PET'S PHYSICAL DISTINGUISHING MARKS -->
                <div id="part3" class="form-part hidden">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 3: Pet's Physical Distinguishing Marks</h3>
                    </div>

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

                    <!-- Navigation Buttons for Part 3 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(2)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(4)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Time and Place
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 4: TIME AND PLACE -->
                <div id="part4" class="form-part hidden">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 4: Time and Place</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Last Seen Date and Time -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Last Seen Date and Time <span class="text-red-500">*</span>
                            </label>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="date" name="last_seen_date" id="last_seen_date"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                                <div>
                                    <input type="time" name="last_seen_time" id="last_seen_time"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
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

                    <!-- Navigation Buttons for Part 4 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(3)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(5)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Photo Upload
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 5: CONTACT & MEDIA -->
                <div id="part5" class="form-part hidden">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 5: Contact & Media</h3>
                    </div>

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

                    <!-- Submit Button with Navigation -->
                    <div class="mt-12 pt-8 border-t">
                        <!-- Row 1: Previous and Submit buttons -->
                        <div class="flex justify-between items-center mb-6">
                            <button type="button" onclick="goToStep(4)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center w-40 justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>
                            
                            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors w-40">
                                Submit
                            </button>
                        </div>
                        
                        <!-- Row 2: Back to Missing Pets link (centered) -->
                        <div class="text-center">
                            <a href="{{ url('/missing-pets') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                                ← Back to Missing Pets
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

    @include('Client.partials.footer')

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

    // Multi-step form navigation
    function goToStep(step) {
        // Hide all parts
        document.querySelectorAll('.form-part').forEach(part => {
            part.classList.add('hidden');
        });
        
        // Show the selected part
        document.getElementById('part' + step).classList.remove('hidden');
        
        // Update progress bar
        const progressBar = document.getElementById('progressBar');
        const stepLabel = document.getElementById('stepLabel');
        const stepTitle = document.getElementById('stepTitle');
        const step1Indicator = document.getElementById('step1Indicator');
        const step2Indicator = document.getElementById('step2Indicator');
        const step3Indicator = document.getElementById('step3Indicator');
        const step4Indicator = document.getElementById('step4Indicator');
        const step5Indicator = document.getElementById('step5Indicator');
        
        // Update progress percentage
        progressBar.style.width = (step * 20) + '%';
        stepLabel.textContent = 'Step ' + step + ' of 5';
        
        // Update step titles
        if (step === 1) {
            stepTitle.textContent = 'Part 1: Owner\'s Information';
            step1Indicator.className = 'font-semibold text-primary';
            step2Indicator.className = 'font-semibold text-gray-400';
            step3Indicator.className = 'font-semibold text-gray-400';
            step4Indicator.className = 'font-semibold text-gray-400';
            step5Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 2) {
            stepTitle.textContent = 'Part 2: Pet\'s Information';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-primary';
            step3Indicator.className = 'font-semibold text-gray-400';
            step4Indicator.className = 'font-semibold text-gray-400';
            step5Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 3) {
            stepTitle.textContent = 'Part 3: Physical Marks';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-green-600';
            step3Indicator.className = 'font-semibold text-primary';
            step4Indicator.className = 'font-semibold text-gray-400';
            step5Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 4) {
            stepTitle.textContent = 'Part 4: Time and Place';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-green-600';
            step3Indicator.className = 'font-semibold text-green-600';
            step4Indicator.className = 'font-semibold text-primary';
            step5Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 5) {
            stepTitle.textContent = 'Part 5: Contact & Media';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-green-600';
            step3Indicator.className = 'font-semibold text-green-600';
            step4Indicator.className = 'font-semibold text-green-600';
            step5Indicator.className = 'font-semibold text-primary';
        }
        
        // Scroll to top of form
        document.getElementById('part' + step).scrollIntoView({ behavior: 'smooth' });
    }
</script>

</body>
</html>