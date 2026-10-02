<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('public.home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white shadow-lg shadow-primary/30 group-hover:scale-105 transition-transform overflow-hidden">
                        <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="block font-extrabold text-lg tracking-tight text-slate-900 group-hover:text-primary transition-colors">City of Dasmariñas</span>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Veterinary Services</span>
                    </div>
                </a>
                
                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8 font-medium text-slate-600 text-sm">
                    <a href="{{ route('public.home') }}" class="hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="hover:text-primary transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-primary font-semibold transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="hover:text-primary transition-colors">Missing Pets</a>
                </nav>
                
                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                    <a href="{{ url('/pet-registration') }}" class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-primary/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </a>
                    @endauth
                    @auth
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">Register</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button id="mobileMenuBtn" class="text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('public.home') }}" class="block py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Home</a>
            <a href="{{ url('/about-us') }}" class="block py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">About Us</a>
            <a href="{{ url('/services') }}" class="block py-2 px-3 rounded-lg text-primary font-semibold">Services</a>
            <a href="{{ url('/missing-pets') }}" class="block py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Missing Pets</a>
            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 text-red-700 py-3 rounded-xl font-semibold text-center border border-red-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center text-primary font-semibold py-3 rounded-xl border border-primary/20 hover:bg-primary/5">Login</a>
                    <a href="{{ route('register') }}" class="block w-full text-center bg-primary text-white py-3 rounded-xl font-semibold shadow-md">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Banner -->
    <section class="hero-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Services</h1>
            <p class="text-lg max-w-2xl mx-auto">Comprehensive veterinary services to keep your pets healthy and happy</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Card 1: Pet Registration -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-primary to-primary-light p-6 flex items-center justify-center">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Pet Registration</h3>
                        <p class="text-gray-600 mb-4">Register your pet with the city to ensure proper tracking and compliance with local regulations.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Official pet registration certificate</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Vaccination tracking & reminders</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Lost pet recovery assistance</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Community safety benefits</span>
                            </li>
                        </ul>
                        <a href="{{ url('/pet-registration') }}" class="w-full block text-center bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-light transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Card 2: Kapon (Spay/Neuter) -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 p-6 flex items-center justify-center">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kapon (Spay/Neuter)</h3>
                        <p class="text-gray-600 mb-4">Help control the pet population and give your furry friends a healthier life with our spay and neuter services.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Safe and professional surgery</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Low-cost program available</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Pre and post-surgery care</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Reduces stray animal population</span>
                            </li>
                        </ul>
                        <a href="{{ url('/kapon') }}" class="w-full block text-center bg-purple-500 text-white py-3 rounded-xl font-semibold hover:bg-purple-600 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Card 3: Vaccination -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-sky-600 p-6 flex items-center justify-center">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Anti-Rabies Vaccination</h3>
                        <p class="text-gray-600 mb-4">Keep your pets protected with our comprehensive vaccination programs for dogs and cats.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Rabies vaccination</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Core vaccines (DHPP, FVRCP)</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Vaccination records</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Reminder notifications</span>
                            </li>
                        </ul>
                        <a href="{{ url('/vaccination') }}" class="w-full block text-center bg-sky-600 text-white py-3 rounded-xl font-semibold hover:bg-sky-700 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Card 4: Adoption -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-amber-500 p-6 flex items-center justify-center">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Adoption</h3>
                        <p class="text-gray-600 mb-4">Give a loving home to a furry friend in need. Browse our available pets waiting for their forever families.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Browse available pets</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Health checked & vaccinated</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">Adoption support & guidance</span>
                            </li>
                            <li class="flex items-center space-x-2 invisible">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 text-sm">&nbsp;</span>
                            </li>
                        </ul>
                        <a href="{{ url('/adoption') }}" class="w-full block text-center bg-amber-500 text-white py-3 rounded-xl font-semibold hover:bg-amber-600 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white overflow-hidden">
                            <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="block font-extrabold text-xl text-white">City of Dasmariñas</span>
                            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Veterinary Services</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Supporting the "Zero by 2030" goal by delivering accessible anti-rabies vaccinations, spay/neuter (kapon) services, and pet registration across all 75 barangays for a rabies-free community.
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">Home Page</a></li>
                        <li><a href="{{ url('/about-us') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ url('/services') }}" class="hover:text-white transition-colors">Services Overview</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Services</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ url('/pet-registration') }}" class="hover:text-white transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="hover:text-white transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="{{ url('/kapon') }}" class="hover:text-white transition-colors">Spay/Neuter (Kapon)</a></li>
                        <li><a href="{{ url('/missing-pets') }}" class="hover:text-white transition-colors">Missing Pets</a></li>
                        <li><a href="{{ url('/adoption') ?? '#' }}" class="hover:text-white transition-colors">Adoption</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Emergency Contact</h4>
                    <div class="space-y-3 text-sm text-slate-400">
                        <p class="flex items-center"><i class="fa-solid fa-phone text-primary mr-2"></i> 0966-881-2010</p>
                        <p class="flex items-center"><i class="fa-solid fa-envelope text-primary mr-2"></i> vetdasma@yahoo.com</p>
                        <p class="flex items-start"><i class="fa-solid fa-location-dot text-primary mr-2 mt-1"></i> Brgy. Langkaan 2, Sitio Buwisan, Dasmariñas City, Cavite</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2025 City of Dasmariñas Veterinary Services. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-slate-400">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400">Terms of Service</a>
                    <a href="#" class="hover:text-slate-400">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
