<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasmariñas City Veterinary Services - Caring for Animals, Protecting Public Health</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 4px;
        }
        .hero-gradient {
            background: linear-gradient(135deg, rgba(6, 109, 51, 0.80) 0%, rgba(5, 42, 28, 0.70) 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
        .service-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(6, 109, 51, 0.25);
        }
        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .service-icon {
            transition: transform 0.3s ease;
        }
        .missing-pet-card {
            cursor: pointer;
        }
        .missing-pet-card:hover .pet-image {
            transform: scale(1.05);
        }
        .pet-image {
            transition: transform 0.3s ease;
        }
        .btn-primary-hover {
            transition: all 0.2s ease;
        }
        .btn-primary-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(6, 109, 51, 0.2);
        }
        .btn-primary-hover:active {
            transform: translateY(0);
        }
        .campaign-card {
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .campaign-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #066D33 0%, #07A13F 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        .campaign-card.campaign-category::before {
            background: linear-gradient(90deg, #066D33 0%, #07A13F 100%);
        }
        .campaign-card.program-category::before {
            background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
        }
        .campaign-card:hover::before {
            transform: scaleX(1);
        }
        .campaign-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(6, 109, 51, 0.25);
        }
        .campaign-card .card-image {
            transition: transform 0.5s ease;
        }
        .campaign-card:hover .card-image {
            transform: scale(1.08);
        }
        .campaign-card .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .campaign-card:hover .image-overlay {
            opacity: 1;
        }
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
        .event-detail-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-left: 3px solid #066D33;
            transition: all 0.3s ease;
        }
        .event-detail-card:hover {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left-color: #07A13F;
            transform: translateX(4px);
        }
        .content-fade {
            position: relative;
        }
        .content-fade::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(180deg, transparent 0%, white 100%);
            pointer-events: none;
        }
        .category-icon {
            transition: transform 0.3s ease;
        }
        .campaign-card:hover .category-icon {
            transform: rotate(10deg) scale(1.1);
        }
        .featured-campaign-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .featured-campaign-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(6, 109, 51, 0.3);
        }
        .featured-image {
            transition: transform 0.6s ease;
        }
        .featured-campaign-card:hover .featured-image {
            transform: scale(1.05);
        }
        .featured-campaign-card .group:hover .group-hover\:bg-primary\/20 {
            background-color: rgba(6, 109, 51, 0.2);
        }
        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        .featured-campaign-card > div:first-child {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        .featured-badge {
            animation: badge-glow 2s ease-in-out infinite;
        }
        @keyframes badge-glow {
            0%, 100% {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            50% {
                box-shadow: 0 10px 15px -3px rgba(234, 179, 8, 0.3);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800">

    <!-- Emergency Alert Bar -->
    <div class="bg-amber-500 text-slate-900 px-4 py-2 text-xs md:text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="bg-amber-900 text-amber-100 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full animate-pulse">Alert</span>
                <span>Free Citywide Anti-Rabies Vaccination Drive active across Dasmariñas Barangays this week!</span>
            </div>
            <a href="#services" class="hidden md:inline-flex items-center underline hover:text-white transition-colors">
                View Schedule <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Main Header / Navigation -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('public.home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white shadow-lg shadow-primary/30 group-hover:scale-105 transition-transform overflow-hidden">
                        <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="block font-extrabold text-lg tracking-tight text-slate-900 group-hover:text-primary transition-colors">Dasmariñas City Vet</span>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Veterinary Services</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8 font-medium text-slate-600 text-sm">
                    <a href="{{ route('public.home') }}" class="text-primary font-semibold hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="hover:text-primary transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="hover:text-primary transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="hover:text-primary transition-colors">Missing Pets</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    <a href="{{ url('/pet-registration') }}" class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-primary/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </a>
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
            <a href="{{ route('public.home') }}" class="block py-2 px-3 rounded-lg bg-primary/10 text-primary font-semibold">Home</a>
            <a href="{{ url('/about-us') }}" class="block py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">About Us</a>
            <a href="{{ url('/services') }}" class="block py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Services</a>
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

    <!-- Hero Section -->
    <section id="home" class="relative bg-slate-900 min-h-[560px] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/herobg2.jpg') }}" alt="Veterinary Care Services" class="w-full h-full object-cover object-center scale-105" onerror="this.src='https://placehold.co/1920x1080/166534/ffffff?text=Dasmariñas+Veterinary+Services'">
            <div class="absolute inset-0 hero-gradient"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 lg:col-span-7 space-y-6">
                    <!-- Status Badge -->
                    <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-1.5 rounded-full text-xs font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>Dasmariñas Mobile Veterinary Clinic Active Today</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Caring for Animals, <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-secondary">Protecting Public Health</span>
                    </h1>

                    <p class="text-slate-200 text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                        Dasmariñas City Veterinary Services is committed to responsible pet ownership, public health protection, and animal welfare. Register your pets, access vaccination programs, and join our community initiatives.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                        <a href="{{ url('/pet-registration') }}" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <span>Book Veterinary Services</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                        <a href="#services" class="w-full sm:w-auto border border-white/30 hover:bg-white/10 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-xl transition-all text-center">
                            Explore Services
                        </a>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10 max-w-lg">
                        <div>
                            <span class="block text-2xl font-bold text-white">{{ number_format($petsRegisteredCount) }}{{ $petsRegisteredCount >= 10 ? '+' : '' }}</span>
                            <span class="text-xs text-slate-300">Pets Registered</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-white">{{ number_format($vaccinationReportsCount) }}{{ $vaccinationReportsCount >= 10 ? '+' : '' }}</span>
                            <span class="text-xs text-slate-300">Pets Vaccinated</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-white">{{ number_format($barangayCount) }}</span>
                            <span class="text-xs text-slate-300">Barangay Outreach</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Services Section -->
    <section id="services" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Core Services</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">Our Veterinary Services</h2>
                <p class="text-slate-600 mt-2">Access convenient veterinary care and municipal programs for your household pets.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Register Pet -->
                <div class="service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Register Pet</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Register your pet with the city to ensure proper identification and access to services.
                        </p>
                    </div>
                    <a href="{{ url('/pet-registration') }}" class="w-full bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Register Now</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 2: Neuter/Spay -->
                <div class="service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-truck-medical"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Spay/Neuter (Kapon)</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Free spay & neuter (Kapon), general consultation, and minor medical treatment in barangays.
                        </p>
                    </div>
                    <a href="{{ url('/kapon') }}" class="w-full bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Book Spay/Neuter</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 3: Anti-Rabies Vaccination -->
                <div class="service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-syringe"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Anti-Rabies Vaccination</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Protect your pets with comprehensive anti-rabies vaccination services. Required annually for pet registration.
                        </p>
                    </div>
                    <a href="{{ url('/vaccination') }}" class="w-full bg-slate-100 hover:bg-teal-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Learn More</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 4: Missing Pets -->
                <div class="service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Missing Pets</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Report a missing pet or browse our database to help reunite lost pets with their owners.
                        </p>
                    </div>
                    <a href="{{ url('/missing-pets') }}" class="w-full bg-slate-100 hover:bg-rose-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Report Missing Pet</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Updates & Programs Section -->
    <section id="updates" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Community News</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">Latest Updates & Programs</h2>
                </div>
                <a href="#" class="mt-4 md:mt-0 font-semibold text-primary hover:text-primary-dark flex items-center space-x-1">
                    <span>View all news</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            @include('components.announcement-modal')

            @if($announcements && $announcements->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($announcements->take(3) as $announcement)
                        @include('components.campaign-card', ['announcement' => $announcement])
                    @endforeach
                </div>
            @else
                <div class="flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover max-w-2xl">
                        <div class="md:flex">
                            <div class="md:w-2/3 p-8">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-primary">Announcement</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-3">No Recent Updates</h3>
                                <p class="text-slate-600">Check back soon for new programs, events, and announcements from the veterinary office.</p>
                            </div>
                            <div class="md:w-1/3 bg-slate-100">
                                <img src="{{ asset('images/default-announcement.jpg') }}" alt="Default announcement" class="w-full h-48 md:h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Campaign Section -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-primary via-primary-dark to-slate-900 text-white shadow-2xl">
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#22c55e_1px,transparent_1px)] [background-size:16px_16px]"></div>

                <div class="relative z-10 grid lg:grid-cols-12 gap-8 p-8 sm:p-12 items-center">
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center space-x-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                            <i class="fa-solid fa-star"></i>
                            <span>Featured Annual Campaign</span>
                        </div>
                        @php
                            $featuredAnnouncement = $announcements->first();
                        @endphp
                        @if($featuredAnnouncement)
                            <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                                {{ $featuredAnnouncement->title }}
                            </h2>
                            <p class="text-slate-300 text-base leading-relaxed">
                                {{ \Illuminate\Support\Str::limit(strip_tags($featuredAnnouncement->content), 180) }}
                            </p>
                            <div class="flex flex-wrap gap-4 pt-2">
                                <a href="#" class="bg-primary hover:bg-primary-light text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all flex items-center space-x-2">
                                    <span>See Program Details</span>
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        @else
                            <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                                Barangay Veterinary Outreach Program
                            </h2>
                            <p class="text-slate-300 text-base leading-relaxed">
                                Our team visited multiple barangays to provide free veterinary services, including pet check-ups, vaccinations, and health education for pet owners.
                            </p>
                            <div class="flex flex-wrap gap-4 pt-2">
                                <a href="#" class="bg-primary hover:bg-primary-light text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all flex items-center space-x-2">
                                    <span>See Program Details</span>
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-5">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 group">
                            @if($featuredAnnouncement && $featuredAnnouncement->photo_path)
                                <img src="{{ asset('storage/' . $featuredAnnouncement->photo_path) }}" alt="Campaign Feature" class="w-full h-64 sm:h-80 object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="{{ asset('images/recentcamp.jpg') }}" alt="Campaign Feature" class="w-full h-64 sm:h-80 object-cover transform group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/800x600/166534/ffffff?text=Dasmariñas+Pet+Clinic'">
                            @endif
                            <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur-md px-4 py-2 rounded-xl text-xs font-semibold text-emerald-400 border border-emerald-500/30">
                                Registration Open
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Missing Pets / Lost & Found Radar -->
    <section id="missing-pets" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center space-x-2 bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Community Alert</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" id="missingPetsTitle">Missing Pets</h2>
                <p class="text-slate-600 mt-2 tab-description" data-tab="missing">Help reunite lost pets with their families. If you have seen any of these pets, please contact us immediately.</p>
                <p class="text-slate-600 mt-2 tab-description hidden" data-tab="adoption">Give these adorable pets a loving forever home. Browse our available pets for adoption and visit the shelter.</p>
            </div>

            <!-- Header Controls & Filters -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                <!-- Filter Tabs -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl w-full sm:w-auto">
                    <button class="filter-tab flex-1 sm:flex-none px-5 py-2 rounded-lg text-sm font-semibold bg-white text-slate-900 shadow-sm" data-filter="missing">Missing Pets</button>
                    <button class="filter-tab flex-1 sm:flex-none px-5 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900" data-filter="adoption">Pets for Adoption</button>
                </div>

                <!-- Report Missing Pet CTA -->
                <button onclick="openModal('reportPetModal')" class="w-full sm:w-auto bg-rose-600 hover:bg-rose-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-rose-600/20 transition-all flex items-center justify-center space-x-2 tab-cta" data-tab="missing">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Report Missing Pet</span>
                </button>
                <a href="{{ url('/adoption') ?? '#' }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center space-x-2 tab-cta hidden" data-tab="adoption">
                    <i class="fa-solid fa-heart"></i>
                    <span>Adopt a Pet</span>
                </a>
            </div>

            <!-- Pet Cards Grid -->
            <!-- Missing Pets Tab -->
            <div class="tab-content" data-tab="missing">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    @forelse($missingPets as $pet)
                    <div class="missing-pet-card bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-shadow group" data-status="{{ strtolower($pet->pet_status) }}" onclick="showPetModal({{ $pet->pet_id }})">
                        <div class="relative h-44 bg-slate-200 overflow-hidden">
                            <img src="{{ $pet->pet_image ? asset('storage/'.$pet->pet_image) : 'https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo' }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo'">
                            <span class="absolute top-2 right-2 bg-rose-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">{{ strtoupper($pet->pet_status) }}</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-slate-900 text-lg">{{ $pet->pet_name }}</h4>
                            <p class="text-xs text-slate-500 font-medium">{{ $pet->breed ?? $pet->species }} • {{ $pet->age }} yrs</p>
                            <div class="mt-3 text-xs text-slate-600 space-y-1">
                                <p class="flex items-center">
                                    <i class="fa-solid fa-location-dot text-rose-500 mr-1.5 w-3"></i>
                                    @if($pet->missingReport->first())
                                        {{ $pet->missingReport->first()->barangay->barangay_name ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p class="flex items-center">
                                    <i class="fa-regular fa-clock text-slate-400 mr-1.5 w-3"></i>
                                    @if($pet->missingReport->first() && $pet->missingReport->first()->last_seen_at)
                                        {{ $pet->missingReport->first()->last_seen_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-5 text-center text-slate-500">No missing pets found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Adoption Pets Tab -->
            <div class="tab-content hidden" data-tab="adoption">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    @forelse($adoptionPets as $pet)
                    <div class="missing-pet-card bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-shadow group" onclick="showPetModal({{ $pet->pet_id }})">
                        <div class="relative h-44 bg-slate-200 overflow-hidden">
                            <img src="{{ $pet->pet_image ? asset('storage/'.$pet->pet_image) : 'https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo' }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo'">
                            <span class="absolute top-2 right-2 bg-emerald-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">For Adoption</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-slate-900 text-lg">{{ $pet->pet_name }}</h4>
                            <p class="text-xs text-slate-500 font-medium">{{ $pet->breed ?? $pet->species }} • {{ $pet->age }} yrs</p>
                            <div class="mt-3 text-xs text-slate-600 space-y-1">
                                <p class="flex items-center">
                                    <i class="fa-solid fa-location-dot text-emerald-500 mr-1.5 w-3"></i>
                                    {{ $pet->barangay->barangay_name ?? 'N/A' }}
                                </p>
                                <p class="flex items-center">
                                    <i class="fa-regular fa-clock text-slate-400 mr-1.5 w-3"></i>
                                    {{ $pet->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-5 text-center text-slate-500">No pets currently available for adoption.</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="{{ url('/missing-pets') }}" class="inline-flex items-center bg-primary hover:bg-primary-light text-white px-6 py-3 rounded-xl font-semibold transition-colors shadow-md tab-link" data-tab="missing">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    View All Missing Pets
                </a>
                <a href="{{ url('/adoption') ?? '#' }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors shadow-md tab-link hidden" data-tab="adoption">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    View All Adoption Pets
                </a>
            </div>
        </div>
    </section>

    <!-- Interactive Map & Location Section -->
    <section id="location" class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-10 items-center">
                <!-- Contact Details -->
                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Visit Us</span>
                        <h2 class="text-3xl font-extrabold text-slate-900 mt-3">Where to Find Us</h2>
                        <p class="text-slate-600 mt-2">Visit the Dasmariñas City Veterinary Office for all your pet care needs.</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Office Address -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200 text-primary flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Office Address</h4>
                                <p class="text-slate-600 text-sm mt-0.5">Brgy. Langkaan 2, Sitio Buwisan, Dasmariñas City, Cavite</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200 text-primary flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Contact Number</h4>
                                <p class="text-slate-600 text-sm mt-0.5">0966-881-2010</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200 text-primary flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Email Address</h4>
                                <p class="text-slate-600 text-sm mt-0.5">vetdasma@yahoo.com</p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200 text-primary flex items-center justify-center text-xl shrink-0">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Office Hours</h4>
                                <p class="text-slate-600 text-sm mt-0.5">Monday – Friday: 8:00 AM – 5:00 PM</p>
                                <span class="inline-block mt-1 text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium">Closed on Weekends & Holidays</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mock Map Container -->
                <div class="lg:col-span-7">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-200 min-h-[400px]">
                        <iframe
                            class="w-full h-[420px] border-0"
                            src="https://maps.google.com/maps?q=14.2514524,120.948638&z=17&output=embed"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
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
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white">
                            <i class="fa-solid fa-paw"></i>
                        </div>
                        <span class="font-extrabold text-xl text-white">Dasmariñas City Vet</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Promoting responsible pet ownership and protecting public health since 2010. Serving the Dasmariñas community with dedication and compassion.
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
                        <li><a href="{{ url('/missing-pets') }}" class="hover:text-white transition-colors">Missing Pets Radar</a></li>
                        <li><a href="#location" class="hover:text-white transition-colors">Clinic Locations</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Services</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ url('/pet-registration') }}" class="hover:text-white transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="hover:text-white transition-colors">Anti-Rabies Drive</a></li>
                        <li><a href="{{ url('/kapon') }}" class="hover:text-white transition-colors">Mobile Clinic Schedule</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Shelter Adoption</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bite Incident Reporting</a></li>
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
                <p>&copy; 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-slate-400">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400">Terms of Service</a>
                    <a href="#" class="hover:text-slate-400">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal 1: Appointment Booking Modal -->
    <div id="appointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative transform transition-all">
            <button onclick="closeModal('appointmentModal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Book Appointment</h3>
                <p class="text-sm text-slate-500 mt-1">Schedule a veterinary visit or pet service</p>
            </div>

            <form onsubmit="handleFormSubmit(event, 'Appointment booked successfully!')" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Owner's Full Name</label>
                    <input type="text" required placeholder="Juan Dela Cruz" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Contact Number</label>
                    <input type="tel" required placeholder="0917 123 4567" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Service Type</label>
                    <select required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                        <option value="">Select Service</option>
                        <option value="registration">Pet Registration & QC Tag ID</option>
                        <option value="vaccine">Anti-Rabies Vaccination</option>
                        <option value="kapon">Spay / Neuter Clinic</option>
                        <option value="checkup">General Health Consultation</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Preferred Date</label>
                    <input type="date" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-light text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/30 transition-all mt-2">
                    Confirm Appointment
                </button>
            </form>
        </div>
    </div>

    <!-- Modal 2: Report Missing Pet Modal -->
    <div id="reportPetModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative transform transition-all">
            <button onclick="closeModal('reportPetModal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Report Missing Pet</h3>
                <p class="text-sm text-slate-500 mt-1">Submit lost pet details to publish on QC Radar</p>
            </div>

            <form onsubmit="handleFormSubmit(event, 'Pet report published to Radar!')" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Pet Name</label>
                    <input type="text" required placeholder="e.g. Buddy" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Breed & Description</label>
                    <input type="text" required placeholder="e.g. Golden Retriever / Brown collar" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Last Seen Location</label>
                    <input type="text" required placeholder="e.g. Brgy. Langkaan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Contact Phone</label>
                    <input type="tel" required placeholder="0917 000 0000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500 text-sm">
                </div>
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-rose-600/30 transition-all mt-2">
                    Submit Radar Notice
                </button>
            </form>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast" class="fixed bottom-6 right-6 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 hidden flex items-center space-x-3 border border-slate-800">
        <i class="fa-solid fa-circle-check text-emerald-400 text-xl"></i>
        <span id="toastMsg" class="text-sm font-semibold">Action completed successfully!</span>
    </div>

    <!-- Client-side Interactive Logic -->
    <script>
        // Toggle mobile menu
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Modal triggers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Form Submit Handler
        function handleFormSubmit(e, message) {
            e.preventDefault();
            const modals = ['appointmentModal', 'reportPetModal'];
            modals.forEach(id => closeModal(id));

            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.innerText = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3500);
        }

        // Filter tabs visual toggle
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');

                // Update tab styles
                document.querySelectorAll('.filter-tab').forEach(t => {
                    t.classList.remove('bg-white', 'text-slate-900', 'shadow-sm', 'font-semibold');
                    t.classList.add('text-slate-600', 'font-medium');
                });
                this.classList.remove('text-slate-600', 'font-medium');
                this.classList.add('bg-white', 'text-slate-900', 'shadow-sm', 'font-semibold');

                // Show/hide content based on tab
                if (filter === 'missing' || filter === 'adoption') {
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                        if (content.getAttribute('data-tab') === filter) {
                            content.classList.remove('hidden');
                        }
                    });

                    document.querySelectorAll('.tab-description').forEach(desc => {
                        desc.classList.add('hidden');
                        if (desc.getAttribute('data-tab') === filter) {
                            desc.classList.remove('hidden');
                        }
                    });

                    document.querySelectorAll('.tab-cta').forEach(cta => {
                        cta.classList.add('hidden');
                        if (cta.getAttribute('data-tab') === filter) {
                            cta.classList.remove('hidden');
                        }
                    });

                    document.querySelectorAll('.tab-link').forEach(link => {
                        link.classList.add('hidden');
                        if (link.getAttribute('data-tab') === filter) {
                            link.classList.remove('hidden');
                        }
                    });

                    // Update section title
                    const titleEl = document.getElementById('missingPetsTitle');
                    if (titleEl) {
                        titleEl.textContent = filter === 'adoption' ? 'Adoption' : 'Missing Pets';
                    }
                }
            });
        });
    </script>

    <!-- Existing Scripts -->
    <script>
        function showLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function hideLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        document.addEventListener('click', function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                hideLoginModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideLoginModal();
            }
        });

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (dropdown && !button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Missing Pet Detail Modal -->
    <div id="petDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hidePetModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-red-500 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Missing Pet Details
                    </h3>
                    <button onclick="hidePetModal()" class="text-white hover:text-red-100 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-6">
                    <div class="flex justify-center mb-6">
                        <div class="relative w-48 h-48 rounded-xl overflow-hidden shadow-lg">
                            <img id="modalPetImage" src="" alt="Pet Image" class="w-full h-full object-cover">
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">MISSING</span>
                        </div>
                    </div>
                    <h2 id="modalPetName" class="text-2xl font-bold text-gray-900 text-center mb-6"></h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Species</p>
                            <p id="modalPetSpecies" class="text-gray-900 font-semibold"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Breed</p>
                            <p id="modalPetBreed" class="text-gray-900 font-semibold"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Age</p>
                            <p id="modalPetAge" class="text-gray-900 font-semibold"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Weight</p>
                            <p id="modalPetWeight" class="text-gray-900 font-semibold"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Color</p>
                            <p id="modalPetColor" class="text-gray-900 font-semibold"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500 mb-1">Gender</p>
                            <p id="modalPetGender" class="text-gray-900 font-semibold"></p>
                        </div>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Last Seen Information
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-red-700">Date & Time:</span>
                                <span id="modalLastSeen" class="text-gray-900 font-medium"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-700">Location:</span>
                                <span id="modalLocation" class="text-gray-900 font-medium"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-2">Description</h4>
                        <p id="modalDescription" class="text-gray-600 text-sm"></p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="contactOwner()" class="flex-1 bg-primary text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact CVO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const missingPetsData = {!! json_encode($missingPets->map(function($pet) {
            $report = $pet->missingReport->first();
            return [
                'pet_id' => $pet->pet_id,
                'pet_name' => $pet->pet_name,
                'species' => $pet->species,
                'breed' => $pet->breed,
                'gender' => $pet->gender,
                'age' => $pet->age,
                'weight' => $pet->weight,
                'color' => $pet->color,
                'description' => $pet->notes,
                'location_barangay' => $report && $report->barangay ? $report->barangay->barangay_name : null,
                'location_description' => $report ? $report->location_description : null,
                'last_seen_at' => $report ? $report->last_seen_at : null,
                'pet_image' => $pet->pet_image,
                'pet_status' => $pet->pet_status,
            ];
        })->toArray()) !!};

        const adoptionPetsData = {!! json_encode($adoptionPets->map(function($pet) {
            return [
                'pet_id' => $pet->pet_id,
                'pet_name' => $pet->pet_name,
                'species' => $pet->species,
                'breed' => $pet->breed,
                'gender' => $pet->gender,
                'age' => $pet->age,
                'weight' => $pet->weight,
                'color' => $pet->color,
                'description' => $pet->notes,
                'location_barangay' => $pet->barangay ? $pet->barangay->barangay_name : null,
                'location_description' => null,
                'last_seen_at' => $pet->created_at,
                'pet_image' => $pet->pet_image,
                'pet_status' => $pet->pet_status,
            ];
        })->toArray()) !!};

        const allPetsData = [...missingPetsData, ...adoptionPetsData];

        function showPetModal(petId) {
            const pet = allPetsData.find(p => p.pet_id === petId);
            if (!pet) return;

            const imageUrl = pet.pet_image
                ? "{{ asset('storage') }}/" + pet.pet_image
                : "https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image";

            document.getElementById('modalPetImage').src = imageUrl;
            document.getElementById('modalPetName').textContent = pet.pet_name;
            document.getElementById('modalPetSpecies').textContent = pet.species;
            document.getElementById('modalPetBreed').textContent = pet.breed || 'Unknown';
            document.getElementById('modalPetAge').textContent = pet.age + ' years';
            document.getElementById('modalPetWeight').textContent = pet.weight;
            document.getElementById('modalPetColor').textContent = pet.color || 'Unknown';
            document.getElementById('modalPetGender').textContent = pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1);
            document.getElementById('modalLastSeen').textContent = pet.last_seen_at ? new Date(pet.last_seen_at).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true }) : 'N/A';
            document.getElementById('modalLocation').textContent = pet.location_barangay ? (pet.location_barangay + (pet.location_description ? ' - ' + pet.location_description : '')) : 'N/A';
            document.getElementById('modalDescription').textContent = pet.description || 'No description available.';

            document.getElementById('petDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hidePetModal() {
            document.getElementById('petDetailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function contactOwner() {
            const petName = document.getElementById('modalPetName').textContent;
            const subject = 'Inquiry about missing pet: ' + petName;
            const encodedSubject = encodeURIComponent(subject);
            window.open('https://mail.google.com/mail/u/0/?view=cm&fs=1&to=vetdasma@yahoo.com&su=' + encodedSubject + '&tf=ui', '_blank');
        }

        document.addEventListener('click', function(event) {
            const modal = document.getElementById('petDetailModal');
            if (modal) {
                const overlay = modal.querySelector('.fixed.inset-0');
                if (overlay && event.target === overlay) {
                    hidePetModal();
                }
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hidePetModal();
            }
        });
    </script>
</body>
</html>
