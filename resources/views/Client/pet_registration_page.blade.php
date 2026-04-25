<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration - Dasmariñas City Veterinary Services</title>
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
        .step-card {
            transition: all 0.3s ease;
        }
        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
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
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Missing Pets</a>
                </nav>
                
                <!-- Login/Register Buttons or User Dropdown -->
                @auth
                    <!-- User Profile Dropdown for Logged In Users -->
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
                        
                        <!-- Dropdown Menu -->
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Show Login/Register for Guests -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-[#066D33] min-h-[500px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title and Subtitle -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Pet Registration</h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl mb-8">
                        Register your beloved pets with Dasmariñas City Veterinary Services for official identification and access to our services.
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4">Why Register Your Pet?</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Official identification and documentation</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Access to veterinary services and programs</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">Lost pet recovery assistance</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8">
                        @auth
                            <a href="{{ url('/pet-registration/form') }}" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                                Register Now
                            </a>
                        @else
                            <button onclick="showLoginPrompt()" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                                Register Now
                            </button>
                        @endauth
                        <a href="#requirements" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-colors">
                            Requirements
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-white/70 text-lg">Pet Registration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Register Your Pet -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Register Your Pet?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Official registration provides essential benefits for you, your pet, and our community. Join thousands of responsible pet owners in Dasmariñas City.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Official Documentation</h3>
                    <p class="text-gray-600 text-sm">Legal recognition of pet ownership with government-issued certificate. Proof of ownership for legal and administrative purposes.</p>
                </div>

                <!-- Benefit 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                    <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Health Management</h3>
                    <p class="text-gray-600 text-sm">Keep your pet's vaccination records up-to-date with automated reminders. Never miss important health checkups or boosters.</p>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Lost Pet Recovery</h3>
                    <p class="text-gray-600 text-sm">Registered pets in our database can be quickly matched and returned to their families. 24/7 recovery assistance service.</p>
                </div>

                <!-- Benefit 4 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border border-gray-100">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Community Safety</h3>
                    <p class="text-gray-600 text-sm">Contribute to rabies control and public safety through responsible pet ownership. Protect your family and neighbors.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Process -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">The Registration Process</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Simple, streamlined steps to get your pet officially registered with the city veterinary services.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-bold text-lg z-10">1</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Complete Online Form</h3>
                        <p class="text-gray-600 text-sm">Fill out comprehensive pet information including breed, age, characteristics, and health details. Takes 10-15 minutes.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">2</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Verification Review</h3>
                        <p class="text-gray-600 text-sm">Our veterinary team verifies submitted information. May request additional documentation if needed.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">3</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Certificate Issuance</h3>
                        <p class="text-gray-600 text-sm">Receive your official registration certificate. Digital copy available immediately, physical copy mailed within 7 days.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">4</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Access Services</h3>
                        <p class="text-gray-600 text-sm">Book appointments, update records, access vaccination history, and participate in community programs.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">Processing time: 3-5 business days after complete submission</p>
            </div>
        </div>
    </section>

    <!-- What We Collect -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Information We Collect</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Comprehensive profiling ensures better care and accurate record-keeping for your pet.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Basic Information -->
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        Basic Information
                    </h3>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                            Pet name, type (dog/cat), breed
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                            Gender, age (or birthdate), weight
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                            High-quality profile photo
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                            Neutered/spayed status
                        </li>
                    </ul>
                </div>

                <!-- Health Profile -->
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </span>
                        Health Profile
                    </h3>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 mt-2 mr-3 flex-shrink-0"></span>
                            Vaccination records and dates
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 mt-2 mr-3 flex-shrink-0"></span>
                            Unique body marks and distinguishing features
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 mt-2 mr-3 flex-shrink-0"></span>
                            Photos of physical marks or scars
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 mt-2 mr-3 flex-shrink-0"></span>
                            Medical history and special conditions
                        </li>
                    </ul>
                </div>

                <!-- Behavioral Profile -->
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </span>
                        Behavioral Profile
                    </h3>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 mr-3 flex-shrink-0"></span>
                            Training status (obedience, potty-training)
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 mr-3 flex-shrink-0"></span>
                            Behavior traits and temperament
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 mr-3 flex-shrink-0"></span>
                            Likes, dislikes, and preferences
                        </li>
                        <li class="flex items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2 mr-3 flex-shrink-0"></span>
                            Dietary needs and allergies
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy & Security -->
    <section class="py-16 bg-gradient-to-br from-primary/5 to-primary/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Privacy & Security</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Your data is protected with industry-leading security measures and strict privacy controls.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <!-- Security Badge 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Encrypted Storage</h3>
                    <p class="text-gray-600 text-sm">All pet and owner data is encrypted and securely stored in our protected database.</p>
                </div>

                <!-- Security Badge 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Access Control</h3>
                    <p class="text-gray-600 text-sm">Information accessible only to authorized veterinary staff and pet owners via secure login.</p>
                </div>

                <!-- Security Badge 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Purpose Limited</h3>
                    <p class="text-gray-600 text-sm">Data collected solely for pet health management, public safety, and veterinary service delivery.</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600 text-sm max-w-2xl mx-auto">
                    We comply with all applicable data protection regulations. Pet owners have full rights to access, update, or request deletion of their information. 
                    <a href="#" class="text-primary hover:text-primary-dark font-medium">Learn more about our privacy policy</a>.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Dasmariñas City</h3>
                            <p class="text-sm text-gray-500">Veterinary Services</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Promoting responsible pet ownership and protecting public health since 2010.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-primary transition-colors">Home</a></li>
                        <li><a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary transition-colors">Services</a></li>
                        <li><a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
                        <li><a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/kapon') }}" class="text-gray-600 hover:text-primary transition-colors">Kapon Program</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-600 text-sm">Brgy. Langkaan 2, Sitio Buwisan, Dasmariñas City, Cavite</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-600 text-sm">0966-881-2010</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600 text-sm">vetdasma@yahoo.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-12 pt-8 text-center text-gray-500 text-sm">
                © 2025 Dasmariñas City Veterinary Services. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Login Prompt Modal -->
    <div id="loginPromptModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeLoginPrompt()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Login Required
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    You need to be logged in to register your pet. Please login or register an account to continue.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-light focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Register
                    </a>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm" onclick="closeLoginPrompt()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function showLoginPrompt() {
            const loginPrompt = document.getElementById('loginPromptModal');
            if (loginPrompt) {
                loginPrompt.classList.remove('hidden');
            }
        }

        function closeLoginPrompt() {
            const loginPrompt = document.getElementById('loginPromptModal');
            if (loginPrompt) {
                loginPrompt.classList.add('hidden');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button || !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
