<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($reportType) }} Pet Report - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
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
    </script>
</head>
<body class="font-sans bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Dasmariñas City Veterinary Services</h1>
                        <p class="text-sm text-gray-500">Official Veterinary Office of Dasmariñas City</p>
                    </div>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('public.home') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="text-primary font-medium transition-colors">Missing Pets</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/missing-pets/report') }}" class="text-primary font-medium hover:text-primary-light transition-colors">Back to Options</a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold">{{ ucfirst($reportType) }} PET REPORT</h2>
                <p class="mt-2 text-gray-600 text-sm text-center">
                    Fields marked with <span class="text-red-500">*</span> are required
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

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

            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <form method="POST" action="{{ route('missing-pets.report.guest.store', ['type' => $reportType]) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="loaded_at" value="{{ $loadedAt }}">
                    <input type="hidden" name="report_type" value="{{ $reportType }}">

                    <!-- Honeypot fields (hidden from users) -->
                    <div class="hidden" aria-hidden="true">
                        <label>Fax Number <input type="text" name="fax_number" tabindex="-1" autocomplete="off"></label>
                    </div>
                    <div class="hidden" aria-hidden="true" style="display:none;">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <!-- Reporter Contact Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Your Contact Information</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Reporter Name</label>
                                <input type="text" name="reporter_name" value="{{ old('reporter_name') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                       placeholder="Your full name (optional)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Contact Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="reporter_contact" value="{{ old('reporter_contact') }}" required
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                       placeholder="e.g., 09XXXXXXXXX">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Email Address</label>
                                <input type="email" name="reporter_email" value="{{ old('reporter_email') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                       placeholder="your@email.com (optional)">
                            </div>
                        </div>
                    </div>

                    @if($reportType === 'missing')
                    <!-- Pet Details Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Pet Details</h3>
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Pet Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="pet_name" value="{{ old('pet_name') }}" required
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                           placeholder="Pet's name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Species <span class="text-red-500">*</span></label>
                                    <select name="species" required
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                        <option value="">Select Species</option>
                                        <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                                        <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Breed</label>
                                    <input type="text" name="breed" value="{{ old('breed') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                           placeholder="Breed (if known)">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Color/Markings</label>
                                    <input type="text" name="color" value="{{ old('color') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                           placeholder="e.g., Brown, White with black spots">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Gender</label>
                                <select name="gender"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                    <option value="">Unknown</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Incident Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">
                            {{ $reportType === 'found' ? 'Found Pet Details' : 'Missing Pet Details' }}
                        </h3>
                        <div class="space-y-6">
                            @if($reportType === 'missing')
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Last Seen Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="last_seen_date" value="{{ old('last_seen_date') }}" required
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1.5">Approximate Time</label>
                                    <input type="time" name="last_seen_time" value="{{ old('last_seen_time') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>
                            @else
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Date Found <span class="text-red-500">*</span></label>
                                <input type="date" name="date_found" value="{{ old('date_found', date('Y-m-d')) }}" required
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium mb-1.5">Location (Barangay) <span class="text-red-500">*</span></label>
                                <select name="barangay_id" required
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
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Specific Location Description</label>
                                <textarea name="location_description" rows="3"
                                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                          placeholder="Describe where the pet was last seen or found">{{ old('location_description') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    {{ $reportType === 'found' ? 'Description of Found Pet' : 'Body Marks / Description' }}
                                </label>
                                <textarea name="{{ $reportType === 'found' ? 'found_description' : 'body_marks' }}" rows="3"
                                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                          placeholder="{{ $reportType === 'found' ? 'Describe the pet you found (color, size, behavior, etc.)' : 'Describe any distinctive marks, notches, scars, etc.' }}">{{ old($reportType === 'found' ? 'found_description' : 'body_marks') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5">Photo (optional)</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm">
                                <p class="text-xs text-gray-500 mt-1">Max 8MB. JPG, PNG, GIF</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('missing-pets.report-landing') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                            Back
                        </a>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <i class="bi bi-exclamation-triangle mr-2"></i>Submit {{ ucfirst($reportType) }} Pet Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-6xl mx-auto px-6 py-6 text-center text-gray-600 text-sm">
            <p>© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
