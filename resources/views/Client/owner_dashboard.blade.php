<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dasmariñas City Veterinary Services</title>
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
        .hero-bg {
            background: linear-gradient(135deg, #066D33 0%, #07A13F 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Success Modal -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Success!</h3>
                    <p class="text-gray-600 mb-6">{{ session('success') }}</p>
                    <button onclick="closeSuccessModal()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
        <script>
            function closeSuccessModal() {
                document.getElementById('successModal').classList.add('hidden');
            }
        </script>
    @endif

    <!-- Flash Message Alert -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="successAlert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('successAlert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="errorAlert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('errorAlert').style.display = 'none';
            }, 5000);
        </script>
    @endif

     @include('Client.partials.emergency_alert')

    @include('Client.partials.navbar')

    <!-- Welcome Banner -->
    <section class="hero-bg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->first_name }}!</h1>
                <p class="text-lg text-gray-200">You're now logged in to your pet owner dashboard</p>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Register New Pet -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Register New Pet</h3>
                    <p class="text-gray-600 text-sm mb-4">Register your pet with the city</p>
                    <a href="{{ url('/pet-registration/form') }}" class="w-full block text-center bg-primary text-white py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Register Now
                    </a>
                </div>

                <!-- Schedule Vaccination -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Schedule Appointment</h3>
                    <p class="text-gray-600 text-sm mb-4">Book a vaccination or checkup</p>
                    <button class="w-full bg-secondary text-white py-2 rounded-lg font-medium hover:bg-secondary-light transition-colors">
                        Schedule Now
                    </button>
                </div>

                <!-- View My Pets -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">My Pets</h3>
                    <p class="text-gray-600 text-sm mb-4">View and manage your registered pets</p>
                    <a href="{{ route('owner.pets') }}" class="w-full block text-center bg-primary text-white py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        View Pets
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- My Pets Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Pets</h2>
                <a href="{{ url('/pet-registration/form') }}" class="text-primary font-medium hover:underline">Add New Pet</a>
            </div>
            
            @php
                $pets = \App\Models\Pet::where('owner_id', auth()->user()->petOwner->owner_id ?? 0)->get();
            @endphp
            
            @if($pets->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pets as $pet)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center space-x-4 mb-4">
                                @if($pet->pet_image)
                                    @php
                                        $imagePath = $pet->pet_image;
                                        if (!str_contains($imagePath, 'images/pets') && !str_contains($imagePath, 'http')) {
                                            $imagePath = 'images/pets/' . basename($imagePath);
                                        }
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="{{ $pet->pet_name }}" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center">
                                        <span class="text-white text-xl font-bold">{{ substr($pet->pet_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $pet->pet_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($pet->species) }} - {{ $pet->breed }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Gender:</strong> {{ ucfirst($pet->gender) }}</p>
                                @php
                                    $ageDisplay = 'Unknown';
                                    if ($pet->petInfo?->pet_age) {
                                        $ageDisplay = $pet->petInfo->pet_age;
                                    } elseif ($pet->birthdate) {
                                        $birthYear = date('Y', strtotime($pet->birthdate));
                                        $age = date('Y') - $birthYear;
                                        $ageDisplay = $age . ' year' . ($age != 1 ? 's' : '') . ' old';
                                    }
                                @endphp
                                <p><strong>Age:</strong> {{ $ageDisplay }}</p>
                                <p><strong>Neutered:</strong> {{ ($pet->petInfo?->is_neutered ?? '') === 'yes' ? 'Yes' : 'No' }}</p>
                                @if($pet->petInfo?->pet_weight)
                                    <p><strong>Weight:</strong> {{ $pet->petInfo?->pet_weight }} kg</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No pets registered yet</p>
                    <a href="{{ url('/pet-registration/form') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Register Your First Pet
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- My Adoption Applications Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">My Adoption Applications</h2>
            
            @php
                $applications = \App\Models\AdoptionApplication::where('user_id', auth()->id())
                    ->orderByDesc('created_at')
                    ->get();
            @endphp
            
            @if($applications->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($applications as $application)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Application #{{ $application->id }}</h3>
                                    <p class="text-sm text-gray-500">Submitted {{ $application->created_at->format('M d, Y') }}</p>
                                </div>
                                @if($application->status === 'pending_review')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Pending</span>
                                @elseif($application->status === 'approved')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Approved</span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Rejected</span>
                                @endif
                            </div>
                            
                            <div class="text-sm text-gray-600 space-y-1 mb-4">
                                @if($application->pet)
                                    <p><strong>Pet:</strong> {{ $application->pet->pet_name }}</p>
                                @endif
                                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $application->status)) }}</p>
                                @if($application->appointment_date)
                                    <p><strong>Appointment:</strong> {{ $application->appointment_date->format('M d, Y') }}</p>
                                @endif
                            </div>
                            
                            <div class="flex gap-2">
                                @if($application->status === 'pending_review')
                                    <a href="{{ route('adoption.form.edit', $application) }}" class="flex-1 text-center bg-primary text-white py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                        Edit Application
                                    </a>
                                @else
                                    <a href="{{ route('adoption.form.edit', $application) }}" class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                        View
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No adoption applications yet</p>
                    <a href="{{ url('/adoption') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Browse Pets for Adoption
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('Client.partials.footer')
</body>
</html>
