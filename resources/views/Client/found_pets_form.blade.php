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
                        <span class="text-xs text-emerald-300">Required</span>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Species -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Species <span class="text-red-500">*</span>
                            </label>
                            <div class="grid md:grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                                    <input type="radio" name="species" value="Dog" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500" required>
                                    <span class="text-sm font-medium text-gray-900">Dog</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                                    <input type="radio" name="species" value="Cat" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500" required>
                                    <span class="text-sm font-medium text-gray-900">Cat</span>
                                </label>
                            </div>
                        </div>

                        <!-- Breed / Mix -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Breed / Mix <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="breed_mix" id="breed_mix"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., Askal / Mixed Breed / Shih Tzu">
                        </div>

                        <!-- Pet Photo Upload (Required) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Pet Photo <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mb-2">A clear photo is essential for community identification.</p>
                            <input type="file" name="pet_photo" id="pet_photo" accept="image/*"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   required>
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
                        <span class="text-xs text-emerald-300">Optional</span>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Eye Color -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Eye Color
                            </label>
                            <input type="text" name="eye_color" id="eye_color"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., Brown, Blue, Heterochromia">
                        </div>

                        <!-- Collar / Harness -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Collar / Harness Description
                            </label>
                            <input type="text" name="collar_harness" id="collar_harness"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., Red collar with bell, Blue harness">
                        </div>

                        <!-- Fur Colors -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Fur Colors
                            </label>
                            <input type="text" name="fur_colors" id="fur_colors"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="e.g., White with brown patches, Black and tan">
                        </div>

                        <!-- Condition -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Condition
                            </label>
                            <input type="text" name="condition" id="condition"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
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
                        <span class="text-xs text-emerald-300">Required</span>
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
                                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                           required>
                                </div>
                                <div>
                                    <input type="time" name="time_found" id="time_found"
                                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Location - Barangay Dropdown -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Barangay <span class="text-red-500">*</span>
                            </label>
                            <select name="barangay_id" id="barangay_id"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                    required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}">{{ $barangay->barangay_name }}</option>
                                @endforeach
                            </select>
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
                        <span class="text-xs text-emerald-300">Read-Only</span>
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

</body>
</html>
