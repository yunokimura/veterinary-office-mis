<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rabies Bite Incident Report - Dasmariñas City Veterinary Services</title>

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
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans bg-gray-50 min-h-screen">

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
            </nav>
        </div>
    </div>
</header>

<!-- Main -->
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Rabies Bite Incident Report</h2>
            <p class="mt-2 text-gray-600 text-sm text-left">
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

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form method="POST" action="{{ route('bite-rabies-report.store') }}">
                @csrf

                <!-- SECTION I: SOURCE OF REPORT -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        I. SOURCE OF REPORT
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Date Reported -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Date Reported <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_reported" value="{{ old('date_reported', date('Y-m-d')) }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('date_reported') border-red-500 @enderror">
                            @error('date_reported')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION III: INCIDENT DETAILS -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        III. INCIDENT DETAILS
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Date of Incident -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Date of Incident <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="incident_date" value="{{ old('incident_date') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('incident_date') border-red-500 @enderror">
                            @error('incident_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nature of Incident -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Nature of Incident <span class="text-red-500">*</span>
                            </label>
                            <select name="nature_of_incident" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('nature_of_incident') border-red-500 @enderror">
                                <option value="">Select Nature</option>
                                <option value="Bitten" {{ old('nature_of_incident') == 'Bitten' ? 'selected' : '' }}>Bitten</option>
                                <option value="Scratched" {{ old('nature_of_incident') == 'Scratched' ? 'selected' : '' }}>Scratched</option>
                                <option value="Licked (Open Wound)" {{ old('nature_of_incident') == 'Licked (Open Wound)' ? 'selected' : '' }}>Licked (Open Wound)</option>
                            </select>
                            @error('nature_of_incident')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Exposure Category -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Exposure Category <span class="text-red-500">*</span>
                            </label>
                            <select name="exposure_category" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('exposure_category') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                <option value="Category I (Lick)" {{ old('exposure_category') == 'Category I (Lick)' ? 'selected' : '' }}>Category I (Lick)</option>
                                <option value="Category II (Scratch)" {{ old('exposure_category') == 'Category II (Scratch)' ? 'selected' : '' }}>Category II (Scratch)</option>
                                <option value="Category III (Bite / Deep)" {{ old('exposure_category') == 'Category III (Bite / Deep)' ? 'selected' : '' }}>Category III (Bite / Deep)</option>
                            </select>
                            <div class="mt-1">
                                <button type="button" class="text-xs text-primary hover:underline" onclick="toggleTooltip('exposure-tooltip')">
                                    What does this mean?
                                </button>
                                <div id="exposure-tooltip" class="hidden mt-2 p-3 bg-gray-100 rounded-lg text-xs">
                                    <p><strong>Category I:</strong> Touching/feeding animals, licks on intact skin</p>
                                    <p><strong>Category II:</strong> Nibbling, scratches without bleeding, licks on broken skin</p>
                                    <p><strong>Category III:</strong> Bites, deep scratches, mucous membrane contact with saliva</p>
                                </div>
                            </div>
                            @error('exposure_category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Incident Location (Barangay) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Incident Location (Barangay) <span class="text-red-500">*</span>
                            </label>
                            <select name="barangay_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('barangay_id') border-red-500 @enderror" required>
                                <option value="">Select Incident Location</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                        {{ $barangay->barangay_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION IV: ANIMAL INFORMATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        IV. ANIMAL INFORMATION
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Animal Species -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Species <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_species" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_species') border-red-500 @enderror">
                                <option value="">Select Species</option>
                                <option value="Dog" {{ old('animal_species') == 'Dog' ? 'selected' : '' }}>Dog</option>
                                <option value="Cat" {{ old('animal_species') == 'Cat' ? 'selected' : '' }}>Cat</option>
                                <option value="Others" {{ old('animal_species') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('animal_species')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Animal Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Status <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="Stray" {{ old('animal_status') == 'Stray' ? 'selected' : '' }}>Stray</option>
                                <option value="Owned" {{ old('animal_status') == 'Owned' ? 'selected' : '' }}>Owned</option>
                            </select>
                            @error('animal_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Animal Gender -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Gender
                            </label>
                            <select name="animal_gender" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_gender') border-red-500 @enderror">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('animal_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('animal_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('animal_gender')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Animal Owner Name -->
                        <div id="animal_owner_container" class="{{ old('animal_status') == 'Owned' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Owner Name
                            </label>
                            <input type="text" name="animal_owner_name" value="{{ old('animal_owner_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                   placeholder="Enter owner's name">
                        </div>

                        <!-- Vaccination Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Vaccination Status <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_vaccination_status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_vaccination_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="Vaccinated" {{ old('animal_vaccination_status') == 'Vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                                <option value="Unvaccinated" {{ old('animal_vaccination_status') == 'Unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                                <option value="Unknown" {{ old('animal_vaccination_status') == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                            </select>
                            @error('animal_vaccination_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Condition -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Current Condition <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_current_condition" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_current_condition') border-red-500 @enderror">
                                <option value="">Select Condition</option>
                                <option value="Healthy / Alive" {{ old('animal_current_condition') == 'Healthy / Alive' ? 'selected' : '' }}>Healthy / Alive</option>
                                <option value="Dead" {{ old('animal_current_condition') == 'Dead' ? 'selected' : '' }}>Dead</option>
                                <option value="Missing / Escaped" {{ old('animal_current_condition') == 'Missing / Escaped' ? 'selected' : '' }}>Missing / Escaped</option>
                                <option value="Euthanized" {{ old('animal_current_condition') == 'Euthanized' ? 'selected' : '' }}>Euthanized</option>
                            </select>
                            @error('animal_current_condition')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Additional Notes
                            </label>
                            <textarea name="notes" rows="3"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                      placeholder="Enter any additional information...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center space-y-4">
                    <button type="submit" class="bg-primary text-white px-12 py-4 rounded-xl font-semibold text-lg hover:bg-primary-light transition-colors">
                        Submit Report
                    </button>
                    <div>
                        <a href="{{ route('public.home') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-white text-gray-900 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // Show/hide facility name field
    document.querySelector('select[name="reporting_facility"]').addEventListener('change', function() {
        const facilityNameContainer = document.getElementById('facility_name_container');
        if (this.value === 'Others') {
            facilityNameContainer.classList.remove('hidden');
        } else {
            facilityNameContainer.classList.add('hidden');
        }
    });

    // Show/hide animal owner field
    document.querySelector('select[name="animal_status"]').addEventListener('change', function() {
        const ownerContainer = document.getElementById('animal_owner_container');
        if (this.value === 'Owned') {
            ownerContainer.classList.remove('hidden');
        } else {
            ownerContainer.classList.add('hidden');
        }
    });

    // Toggle tooltip
    function toggleTooltip(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>

</body>
</html>
