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
        /* Prevent scrollbar from clipping the modal's rounded corner */
        ::-webkit-scrollbar-corner {
            background: transparent;
        }
        /* Styled scrollbar for announcements slider */
        #announcementsSlider::-webkit-scrollbar {
            height: 6px;
        }
        #announcementsSlider::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        #announcementsSlider::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 3px;
        }
        #announcementsSlider::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800">

    @include('Client.partials.emergency_alert')
    @include('Client.partials.navbar')

    <!-- Hero Section -->
    <section id="home" class="relative bg-slate-900 min-h-[560px] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Veterinary Care Services" class="w-full h-full object-cover object-center scale-105" onerror="this.src='https://placehold.co/1920x1080/166534/ffffff?text=Dasmariñas+Veterinary+Services'">
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
                        One Health, <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-white">One Community</span>
                    </h1>

                    <p class="text-slate-200 text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                        Dasmariñas City Veterinary Services supports the "Zero by 2030" goal by offering pet registration, anti-rabies vaccinations, and spay/neuter (<em>kapon</em>) services across all 75 barangays for a rabies-free community.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                        <button onclick="openNotLoggedInModal()" class="w-full sm:w-auto bg-white text-primary font-bold px-8 py-4 rounded-xl shadow-lg hover:opacity-90 hover:shadow-xl hover:-translate-y-0.5 transition-all transform flex items-center justify-center space-x-2">
                            <span>Book Veterinary Services</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                        <a href="{{ url('/about-us') }}" class="w-full sm:w-auto border-2 border-white/50 hover:bg-white/10 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-xl transition-all text-center">
                            Learn More About Us
                        </a>
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

            <div class="flex flex-wrap justify-center gap-6">
                <!-- Card 1: Register Pet -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Pet Registration</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Register your pet with the city to ensure proper identification and access to services.
                        </p>
                    </div>
                    <a href="{{ url('/pet-registration') }}" class="w-full bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Learn More</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 2: Neuter/Spay -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
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
                        <span>Learn More</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 3: Anti-Rabies Vaccination -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
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

                <div class="w-full text-center mt-8 mb-10">
                    <span class="text-amber-600 font-bold text-xs uppercase tracking-widest bg-amber-50 px-3 py-1 rounded-full">Community Programs</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">Community Programs</h2>
                    <p class="text-slate-600 mt-2 max-w-2xl mx-auto">Compassionate community programs dedicated to pet adoption and reunited families.</p>
                </div>

                <!-- Card 4: Lost Pets -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Lost &amp; Found Pets</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Report a lost pet or a found pet to help reunite lost pets with their owners.
                        </p>
                    </div>
                    <a href="{{ url('/missing-pets') }}" class="w-full bg-slate-100 hover:bg-rose-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
<span>Report Lost Pet</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Card 5: Adoption -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Adoption</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Find your new best friend. Browse adoptable pets and give them a loving forever home.
                        </p>
                    </div>
                    <a href="{{ url('/adoption') }}" class="w-full bg-slate-100 hover:bg-amber-600 hover:text-white text-slate-800 font-semibold py-2.5 rounded-xl transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Adopt a Pet</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="hero-gradient py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-5 gap-8 text-center">
                <div>
                    <span class="block text-4xl font-extrabold text-white stat-counter" data-count="{{ $petsRegisteredCount }}" data-suffix="{{ $petsRegisteredCount >= 10 ? '+' : '' }}">0</span>
                    <span class="text-lg font-bold text-white">Registered Pets</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-white stat-counter" data-count="{{ $vaccinationReportsCount }}" data-suffix="{{ $vaccinationReportsCount >= 10 ? '+' : '' }}">0</span>
                    <span class="text-lg font-bold text-white">Vaccinated Pets</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-white stat-counter" data-count="{{ $spayedNeuteredCount }}" data-suffix="{{ $spayedNeuteredCount >= 10 ? '+' : '' }}">0</span>
                    <span class="text-lg font-bold text-white">Spayed/Neutered</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-white stat-counter" data-count="{{ $reunitedCount }}" data-suffix="{{ $reunitedCount >= 10 ? '+' : '' }}">0</span>
                    <span class="text-lg font-bold text-white">Reunited</span>
                </div>
                <div>
                    <span class="block text-4xl font-extrabold text-white stat-counter" data-count="{{ $rehomedCount }}" data-suffix="{{ $rehomedCount >= 10 ? '+' : '' }}">0</span>
                    <span class="text-lg font-bold text-white">Rehomed</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Updates & Programs Section -->
    <section id="updates" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="mb-8">
                <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                    Community News
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Latest Updates &amp; Programs
                </h2>
                <p class="text-gray-600 text-sm mt-1">
                    Stay informed about upcoming mobile clinic schedules, free rabies drives, and pet care events.
                </p>
            </div>

            @php
                $featuredAnnouncement = $announcements->first();
                $regularAnnouncements = $announcements->slice(1);
                $totalCount = $announcements->count();
            @endphp

            @if($announcements && $totalCount > 0)
                <!-- 1. FEATURED ANNOUNCEMENT -->
                <div class="mb-10 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                        <!-- Image -->
                        <div class="md:col-span-5 relative h-[397px] bg-gray-100">
                            <img
                                src="{{ $featuredAnnouncement->photo_path ? asset('storage/' . $featuredAnnouncement->photo_path) : 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?q=80&w=800&auto=format&fit=crop' }}"
                                alt="{{ $featuredAnnouncement->title }}"
                                class="w-full h-full object-cover"
                            />
                            <span class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                FEATURED
                            </span>
                        </div>
                        <!-- Content -->
                        <div class="md:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center text-xs text-gray-400 mb-2 font-medium">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($featuredAnnouncement->created_at)->format('M d, Y') }}
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 hover:text-emerald-600 transition leading-snug">
                                    {{ $featuredAnnouncement->title }}
                                </h3>
                                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($featuredAnnouncement->content), 150) }}
                                </p>
                            </div>
                            <div>
                                <a href="#" onclick="openNewsModal('{{ $featuredAnnouncement->title }}', '{{ \Carbon\Carbon::parse($featuredAnnouncement->created_at)->format('M d, Y') }}', '{{ strtoupper($featuredAnnouncement->category) }}', '{{ $featuredAnnouncement->photo_path ? asset('storage/' . $featuredAnnouncement->photo_path) : 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?q=80&w=800&auto=format&fit=crop' }}', '{!! \Illuminate\Support\Str::limit(strip_tags($featuredAnnouncement->content), 200) !!}')"
                                   class="inline-flex items-center font-semibold text-emerald-600 hover:text-emerald-700 text-sm group">
                                    Read Full Details
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. ANNOUNCEMENTS CAROUSEL SLIDER -->
                @if($regularAnnouncements->count() > 0)
                    <div class="relative">
                        <!-- Controls -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">More Recent Updates</h3>
                            <div class="flex gap-2">
                                <button
                                    onclick="scrollCarousel(-1)"
                                    class="p-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-100 hover:text-emerald-600 transition shadow-sm"
                                    aria-label="Previous Slide"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button
                                    onclick="scrollCarousel(1)"
                                    class="p-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-100 hover:text-emerald-600 transition shadow-sm"
                                    aria-label="Next Slide"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Carousel Cards Container -->
                        <div
                            id="announcementsCarousel"
                            class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-4 no-scrollbar"
                            style="scrollbar-width: none; -ms-overflow-style: none;"
                        >
                            @foreach($regularAnnouncements as $announcement)
                                <div class="min-w-[280px] sm:min-w-[320px] max-w-[360px] flex-shrink-0 snap-start bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                                    <div>
                                        <div class="relative h-44 bg-gray-100 overflow-hidden">
                                            <img src="{{ $announcement->photo_path ? asset('storage/' . $announcement->photo_path) : 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=600&auto=format&fit=crop' }}"
                                                 alt="{{ $announcement->title }}"
                                                 class="w-full h-full object-cover">
                                            <span class="absolute top-3 left-3 bg-emerald-600 text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                                {{ strtoupper($announcement->category) }}
                                            </span>
                                        </div>
                                        <div class="p-5">
                                            <div class="flex items-center text-xs text-gray-400 mb-2">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                                            </div>
                                            <h4 class="font-bold text-gray-900 text-base mb-2 line-clamp-2">
                                                {{ $announcement->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed mb-4">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 100) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-5">
                                        <a href="#" onclick="openNewsModal('{{ $announcement->title }}', '{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}', '{{ strtoupper($announcement->category) }}', '{{ $announcement->photo_path ? asset('storage/' . $announcement->photo_path) : 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=600&auto=format&fit=crop' }}', '{!! \Illuminate\Support\Str::limit(strip_tags($announcement->content), 150) !!}')"
                                           class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center group">
                                            Read More
                                            <span class="ml-1 group-hover:translate-x-1 transition">→</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
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

    <!-- ANNOUNCEMENT READ MORE MODAL -->
    <div id="newsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-gray-100 flex flex-col max-h-[90vh]">
            <!-- Modal Header Image -->
            <div class="relative h-48 bg-gray-100">
                <img id="newsModalImg" src="" alt="Announcement banner" class="w-full h-full object-cover">
                <button
                    onclick="closeNewsModal()"
                    class="absolute top-3 right-3 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 backdrop-blur transition shadow-md"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span id="newsModalCategory" class="absolute bottom-3 left-4 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                    CATEGORY
                </span>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1">
                <div class="flex items-center text-xs text-gray-400 mb-2 font-medium">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="newsModalDate">Date</span>
                </div>
                <h3 id="newsModalTitle" class="text-xl font-bold text-gray-900 mb-4 leading-snug">
                    Title
                </h3>
                <div id="newsModalBody" class="text-gray-600 text-sm leading-relaxed space-y-3">
                    Body content...
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button
                    onclick="closeNewsModal()"
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-medium text-xs transition"
                >
                    Close Announcement
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Carousel & Reader Modal -->
    <script>
        // Scroll Horizontal Carousel
        function scrollCarousel(direction) {
            const carousel = document.getElementById('announcementsCarousel');
            const scrollAmount = 340;
            carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        }

        // Open Announcement Modal
        function openNewsModal(title, date, category, imageSrc, bodyContent) {
            document.getElementById('newsModalTitle').innerText = title;
            document.getElementById('newsModalDate').innerText = date;
            document.getElementById('newsModalCategory').innerText = category;
            document.getElementById('newsModalCategory').className = 'absolute bottom-3 left-4 ' + (category === 'CAMPAIGN' ? 'bg-emerald-600' : 'bg-blue-600') + ' text-white text-xs font-bold px-3 py-1 rounded-full shadow';
            document.getElementById('newsModalImg').src = imageSrc;
            document.getElementById('newsModalBody').innerHTML = bodyContent;

            document.getElementById('newsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Announcement Modal
        function closeNewsModal() {
            document.getElementById('newsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on outside backdrop click
        document.getElementById('newsModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeNewsModal();
            }
        });
    </script>

    <!-- Lost Pets / Lost & Found Radar -->
    <section id="lost-pets" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center space-x-2 bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Community Alert</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900" id="missingPetsTitle">Lost Pets</h2>
                <p class="text-slate-600 mt-2 tab-description" data-tab="missing">Help reunite lost pets with their families. If you have seen any of these pets, please contact us immediately.</p>
                <p class="text-slate-600 mt-2 tab-description hidden" data-tab="adoption">Give these adorable pets a loving forever home. Browse our available pets for adoption and visit the shelter.</p>
            </div>

            <!-- Header Controls & Filters -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                <!-- Filter Tabs -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl w-full sm:w-auto">
                    <button class="filter-tab flex-1 sm:flex-none px-5 py-2 rounded-lg text-sm font-semibold bg-white text-slate-900 shadow-sm" data-filter="missing">Lost Pets</button>
                    <button class="filter-tab flex-1 sm:flex-none px-5 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900" data-filter="adoption">Pets for Adoption</button>
                </div>

                <!-- Report Missing Pet CTA -->
                <a href="{{ url('/missing-pets/form') }}" class="w-full sm:w-auto bg-rose-600 hover:bg-rose-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-rose-600/20 transition-all flex items-center justify-center space-x-2 tab-cta" data-tab="missing">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Report Lost Pet</span>
                </a>
                <a href="{{ url('/adoption') ?? '#' }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center space-x-2 tab-cta hidden" data-tab="adoption">
                    <i class="fa-solid fa-heart"></i>
                    <span>Adopt a Pet</span>
                </a>
            </div>

            <!-- Pet Cards Grid -->
            <!-- Lost Pets Tab -->
            <div class="tab-content" data-tab="missing">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    @forelse($missingPets as $pet)
                    <div class="missing-pet-card bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-shadow group" data-status="{{ strtolower($pet->pet_status) }}" onclick="showPetModal({{ $pet->pet_id }})">
                        <div class="relative h-44 bg-slate-200 overflow-hidden">
                            <img src="{{ $pet->image_url ?: 'https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo' }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo'">
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
                    <p class="col-span-5 text-center text-slate-500">No lost pets found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Adoption Pets Tab -->
            <div class="tab-content hidden" data-tab="adoption">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    @forelse($adoptionPets as $pet)
                    <div class="missing-pet-card bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-shadow group" onclick="showPetModal({{ $pet->pet_id }})">
                        <div class="relative h-44 bg-slate-200 overflow-hidden">
                            <img src="{{ $pet->image_url ?: 'https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo' }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://placehold.co/400x400/cbd5e1/475569?text=Pet+Photo'">
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
                <a href="{{ url('/missing-pets') }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors shadow-md tab-link" data-tab="missing">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    View All Lost Pets
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

    <!-- Confirmed Rabies Cases Geomap -->
    <section id="rabies-geomap" class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center space-x-2 bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-virus"></i>
                    <span>Public Health Advisory</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Confirmed Rabies Cases</h2>
                <p class="text-slate-600 mt-2">Geospatial distribution of confirmed rabies cases by barangay in the City of Dasmariñas.</p>
            </div>

            <!-- Geomap wrapper (City Vet style, adapted for landing page section) -->
            <div class="rabies-home-geomap-wrapper relative mt-20 min-h-[600px] lg:min-h-[700px] rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-200">

                <!-- Map container (fills wrapper) -->
                <div id="rabies-home-map" class="rabies-home-map-container absolute inset-0 z-10" role="application" aria-label="Confirmed rabies cases geomap">
                    <div class="rabies-home-loading absolute inset-0 z-[60] flex items-center justify-center bg-slate-50">
                        <div class="text-center">
                            <div class="inline-block animate-pulse w-10 h-10 bg-slate-200 rounded-full mb-3"></div>
                            <p class="text-sm text-slate-400">Initializing map...</p>
                        </div>
                    </div>
                </div>

                <!-- Floating: Left Column — Stats + Legend (top-left) -->
                <div class="rabies-home-left-column absolute top-4 left-4 z-[1000] flex flex-col gap-4 pointer-events-none">
                    <!-- Stats Pills -->
                    <div class="rabies-home-stats pointer-events-none">
                        <div class="rabies-home-stats-inner backdrop-blur bg-white/90 rounded-lg px-4 py-3 shadow-sm border border-gray-200/60 flex items-center gap-4 pointer-events-auto">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-red-500" id="rabiesHomeStatTotalIcon"></div>
                                <span class="text-[11px] text-slate-400 font-medium" id="rabiesHomeStatTotalLabel">Total Cases</span>
                                <span class="text-base font-bold text-slate-800" id="rabiesHomeStatTotal">0</span>
                            </div>
                            <div class="w-px h-4 bg-slate-200"></div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-amber-500" id="rabiesHomeStatAffectedIcon"></div>
                                <span class="text-[11px] text-slate-400 font-medium" id="rabiesHomeStatAffectedLabel">Affected</span>
                                <span class="text-base font-bold text-amber-600" id="rabiesHomeStatAffected">0</span>
                            </div>
                            <div class="w-px h-4 bg-slate-200"></div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-rose-500" id="rabiesHomeStatCriticalIcon"></div>
                                <span class="text-[11px] text-slate-400 font-medium" id="rabiesHomeStatCriticalLabel">Critical</span>
                                <span class="text-base font-bold text-rose-600" id="rabiesHomeStatCritical">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Legend Panel (below stats) -->
                    <div class="rabies-home-legend pointer-events-none">
                        <div class="simple-legend-card backdrop-blur bg-white/95 rounded-xl px-3 py-3 shadow-sm border border-gray-200 pointer-events-auto">
                            <p class="simple-legend-title text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-3">Severity Legend</p>
                            <div class="simple-legend-items flex flex-col gap-2">
                                <div class="simple-legend-item flex items-center gap-2 cursor-pointer" onclick="rabiesHomeSetSeverityFilter('critical')">
                                    <span class="simple-legend-dot w-3 h-3 rounded" style="background:#dc2626;"></span>
                                    <span class="simple-legend-text text-[11px] font-medium text-slate-700">Critical (20+)</span>
                                </div>
                                <div class="simple-legend-item flex items-center gap-2 cursor-pointer" onclick="rabiesHomeSetSeverityFilter('high')">
                                    <span class="simple-legend-dot w-3 h-3 rounded" style="background:#ea580c;"></span>
                                    <span class="simple-legend-text text-[11px] font-medium text-slate-700">High (11-19)</span>
                                </div>
                                <div class="simple-legend-item flex items-center gap-2 cursor-pointer" onclick="rabiesHomeSetSeverityFilter('moderate')">
                                    <span class="simple-legend-dot w-3 h-3 rounded" style="background:#eab308;"></span>
                                    <span class="simple-legend-text text-[11px] font-medium text-slate-700">Moderate (6-10)</span>
                                </div>
                                <div class="simple-legend-item flex items-center gap-2 cursor-pointer" onclick="rabiesHomeSetSeverityFilter('low')">
                                    <span class="simple-legend-dot w-3 h-3 rounded" style="background:#fde68a;"></span>
                                    <span class="simple-legend-text text-[11px] font-medium text-slate-700">Low (1-5)</span>
                                </div>
                                <div class="simple-legend-item flex items-center gap-2 cursor-pointer" onclick="rabiesHomeSetSeverityFilter('none')">
                                    <span class="simple-legend-dot w-3 h-3 rounded" style="background:#cbd5e1;"></span>
                                    <span class="simple-legend-text text-[11px] font-medium text-slate-700">No Cases</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating: View Changers + Filters (top-right column) -->
                <div class="rabies-home-view-changers absolute top-4 right-4 z-[1000] flex flex-col gap-3">
                    <button id="rabiesHomeBtnRabiesLayer" class="rabies-home-layer-toggle-btn bg-indigo-600 text-white border-indigo-600 shadow-[0_2px_8px_rgba(79,70,229,0.3)]" onclick="rabiesHomeSwitchLayer('rabies')">
                        <i class="fa-solid fa-virus"></i>
                        <span>Confirmed Rabies Cases</span>
                    </button>
                    <button id="rabiesHomeBtnVaccinationLayer" class="rabies-home-layer-toggle-btn" onclick="rabiesHomeSwitchLayer('vaccination')">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Anti-Rabies Vaccination</span>
                    </button>
                    <button id="rabiesHomeBtnTopBarangays" class="rabies-home-layer-toggle-btn" onclick="rabiesHomeOpenTopBarangaysModal()">
                        <i class="fa-solid fa-list-ol"></i>
                        <span>Top Barangays</span>
                    </button>

                    <!-- Filter Controls -->
                    <div class="rabies-home-filter-controls relative">
                        <button id="rabiesHomeFilterToggle" class="rabies-home-filter-toggle-btn flex items-center gap-2 px-3 py-2 bg-white/95 backdrop-blur border border-gray-200 rounded-lg shadow-sm text-slate-600 text-xs font-medium" onclick="rabiesHomeToggleFilter()">
                            <i class="fa-solid fa-funnel"></i>
                            <span>Filters</span>
                            <i class="fa-solid fa-chevron-down text-[8px] opacity-40"></i>
                        </button>

                        <!-- Filter Panel -->
                        <div id="rabiesHomeFilterPanel" class="rabies-home-filter-panel absolute right-0 mt-2 w-64 bg-white/97 backdrop-blur border border-gray-200 rounded-xl shadow-lg overflow-hidden hidden z-[1005]">
                            <div class="p-3 space-y-3">
                                <div>
                                    <label class="rabies-home-filter-label block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Year</label>
                                    <select id="rabiesHomeFilterYear" class="rabies-home-filter-select w-full px-2 py-1.5 bg-gray-50 border border-gray-200 rounded text-xs text-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                        <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                        <option value="{{ date('Y') - 2 }}">{{ date('Y') - 2 }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="rabies-home-filter-label block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Month</label>
                                    <select id="rabiesHomeFilterMonth" class="rabies-home-filter-select w-full px-2 py-1.5 bg-gray-50 border border-gray-200 rounded text-xs text-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                        <option value="">All Months</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="pt-2 border-t border-gray-100">
                                    <button id="rabiesHomeClearFilter" class="rabies-home-filter-clear-btn w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-red-50 border border-red-100 rounded text-red-600 text-xs font-medium" onclick="rabiesHomeClearFilters()">
                                        <i class="fa-solid fa-x-circle"></i>
                                        <span>Clear Filter</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Overlay -->
                <div id="rabiesHomeMapLoading" class="rabies-home-loading-overlay absolute inset-0 z-[1004] bg-white/90 flex items-center justify-center hidden">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-10 w-10 border-3 border-indigo-500 border-t-transparent mb-2"></div>
                        <p class="text-sm text-slate-500 font-medium">Loading map data...</p>
                    </div>
                </div>

                <!-- Error -->
                <div id="rabiesHomeMapError" class="rabies-home-error absolute top-4 left-1/2 -translate-x-1/2 z-[60] hidden">
                    <div class="rabies-home-error-inner backdrop-blur bg-red-50/95 border border-red-200 rounded-lg px-4 py-3 shadow-sm flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-800" id="rabiesHomeErrorTitle">Error loading map</p>
                            <p class="text-xs text-red-600" id="rabiesHomeErrorMessage">Please refresh the page.</p>
                        </div>
                        <button onclick="location.reload()" class="px-2.5 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition">Retry</button>
                    </div>
                </div>

            </div>

            <!-- Top Barangays Modal -->
            <div id="rabiesHomeTopBarangaysModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
                <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
                    <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                        <div class="flex items-center space-x-3">
                            <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-lg">
                                <i class="fa-solid fa-list-ol w-5 h-5"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-bold text-slate-800 text-lg leading-tight">Top Barangays</h5>
                                <p class="text-xs text-slate-500 leading-none" id="rabiesHomeTopBarangaysModalSubtitle">Confirmed Rabies Cases</p>
                            </div>
                        </div>
                        <button onclick="rabiesHomeCloseTopBarangaysModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
                        <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                            <button onclick="rabiesHomeSetTopBarangaysType('rabies')" id="rabiesHomeTopBarangaysTypeRabies" class="flex-1 py-2 px-3 text-xs font-medium rounded-md text-indigo-600 bg-white shadow-sm transition-colors">Rabies Cases</button>
                            <button onclick="rabiesHomeSetTopBarangaysType('vaccination')" id="rabiesHomeTopBarangaysTypeVaccination" class="flex-1 py-2 px-3 text-xs font-medium rounded-md text-slate-600 hover:text-slate-700 transition-colors">Vaccination Coverage</button>
                        </div>
                        <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                            <button onclick="rabiesHomeSetTopBarangaysLimit(5)" id="rabiesHomeTopBarangaysLimit5" class="flex-1 py-2 px-3 text-xs font-medium rounded-md text-indigo-600 bg-white shadow-sm transition-colors">Top 5</button>
                            <button onclick="rabiesHomeSetTopBarangaysLimit(10)" id="rabiesHomeTopBarangaysLimit10" class="flex-1 py-2 px-3 text-xs font-medium rounded-md text-slate-600 hover:text-slate-700 transition-colors">Top 10</button>
                        </div>

                        <div id="rabiesHomeTopBarangaysLoading" class="text-center py-8 hidden">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                            <p class="text-slate-500 text-sm">Loading top barangays...</p>
                        </div>

                        <div id="rabiesHomeTopBarangaysList" class="space-y-2"></div>
                        <div id="rabiesHomeTopBarangaysEmpty" class="hidden text-center py-8">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-geo-alt text-slate-400 text-xl"></i>
                            </div>
                            <p class="text-sm text-slate-500">No barangays found for the selected filters.</p>
                        </div>
                    </div>

                    <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                        <span class="text-xs text-slate-400" id="rabiesHomeTopBarangaysFilterLabel"></span>
                        <button onclick="rabiesHomeCloseTopBarangaysModal()" class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ========== Rabies Home Geomap (City Vet style, section-scoped) ========== */
        .rabies-home-geomap-wrapper { position: relative; width: 100%; flex: 1; margin-top: 5rem; height: auto; min-height: 600px; overflow: hidden; }
        @media (min-width: 1024px) { .rabies-home-geomap-wrapper { min-height: 700px; } }

        .rabies-home-map-container { position: absolute; inset: 0; z-index: 10; }

        .leaflet-container { height: 100% !important; width: 100% !important; font-family: 'Inter', system-ui, sans-serif; border-radius: 0; }
        .leaflet-control { z-index: 25 !important; }
        .leaflet-popup { z-index: 30 !important; }
        .leaflet-tooltip { z-index: 30 !important; }
        .leaflet-popup-content-wrapper { border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
        .leaflet-popup-content { margin: 14px; font-family: 'Inter', system-ui, sans-serif; }

        .rabies-home-loading { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: #f1f5f9; z-index: 0; }

        .rabies-home-left-column { position: absolute; top: 1rem; left: 1rem; z-index: 20; pointer-events: none; display: flex; flex-direction: column; gap: 12px; }
        .rabies-home-stats { pointer-events: none; }
        .rabies-home-stats-inner { backdrop-filter: blur(12px); background: rgba(255,255,255,0.9); border-radius: 0.5rem; padding: 0.5rem 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 0.75rem; pointer-events: auto; }
        .rabies-home-legend { pointer-events: none; }
        .simple-legend-card { width: 180px; backdrop-filter: blur(12px); background: rgba(255,255,255,0.95); border-radius: 0.75rem; padding: 0.75rem 1rem; box-shadow: 0 4px 16px rgba(0,0,0,0.10); border: 1px solid #e2e8f0; pointer-events: auto; }
        .simple-legend-items { display: flex; flex-direction: column; gap: 10px; }
        .simple-legend-item { display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all 0.15s ease; }
        .simple-legend-item.severity-active { background: #e0e7ff; border-radius: 6px; padding: 4px 8px; }
        .simple-legend-item:hover { background: #f8fafc; border-radius: 6px; padding: 4px 8px; }
        .simple-legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; box-shadow: inset 0 -1px 2px rgba(0,0,0,0.15); }
        .simple-legend-text { font-size: 12px; font-weight: 500; color: #475569; }

        .rabies-home-view-changers { position: absolute; top: 1rem; right: 1rem; z-index: 20; display: flex; flex-direction: column; gap: 8px; }
        .rabies-home-layer-toggle-btn { display: flex; align-items: center; gap: 6px; padding: 7px 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border: 1.5px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); cursor: pointer; color: #64748b; font-size: 12px; font-weight: 500; transition: all 0.2s; font-family: 'Inter', system-ui, sans-serif; white-space: nowrap; width: 100%; justify-content: flex-start; }
        .rabies-home-layer-toggle-btn:hover { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.12); border-color: #cbd5e1; }
        .rabies-home-layer-toggle-btn i { font-size: 12px; }

        .rabies-home-filter-controls { position: relative; }
        .rabies-home-filter-toggle-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); cursor: pointer; color: #475569; font-size: 12px; font-weight: 500; transition: all 0.15s; font-family: 'Inter', system-ui, sans-serif; }
        .rabies-home-filter-toggle-btn:hover { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .rabies-home-filter-panel { position: absolute; top: calc(100% + 8px); right: 0; background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 12px; width: 240px; max-height: calc(100vh - 200px); overflow-y: auto; z-index: 45; }
        .rabies-home-filter-label { display: block; font-size: 10px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
        .rabies-home-filter-select { width: 100%; padding: 5px 8px; font-size: 11px; font-weight: 500; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; outline: none; cursor: pointer; font-family: 'Inter', system-ui, sans-serif; }
        .rabies-home-filter-select:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.15); }
        .rabies-home-filter-clear-btn { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 12px; font-size: 11px; font-weight: 500; color: #dc2626; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer; transition: all 0.15s; font-family: 'Inter', system-ui, sans-serif; }
        .rabies-home-filter-clear-btn:hover { background: #fee2e2; border-color: #fca5a5; }

        .rabies-home-loading-overlay { position: absolute; inset: 0; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; z-index: 48; }
        .rabies-home-error { position: absolute; top: 4rem; left: 50%; transform: translateX(-50%); z-index: 55; }
        .rabies-home-error-inner { backdrop-filter: blur(12px); background: rgba(254,242,242,0.95); border: 1px solid #fecaca; border-radius: 0.5rem; padding: 0.75rem 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 0.75rem; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 0.8s linear infinite; }

        /* Reset view control */
        .rabies-home-reset-control { position: absolute; bottom: 1rem; right: 1rem; z-index: 20; }
        .rabies-home-reset-btn { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: white; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); border: 1px solid #e2e8f0; cursor: pointer; font-size: 16px; color: #334155; }
        .rabies-home-reset-btn:hover { background: #f8fafc; }

        @media (max-width: 768px) {
            .rabies-home-geomap-wrapper { min-height: 500px; }
            .rabies-home-left-column { top: 0.5rem; left: 0.5rem; }
            .rabies-home-view-changers { top: 0.5rem; right: 0.5rem; }
            .simple-legend-card { width: 160px; padding: 0.6rem 0.8rem; }
            .rabies-home-view-changers .rabies-home-layer-toggle-btn span { display: none; }
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    /* ========== Rabies Home Geomap JS (City Vet style, view-only, no report) ========== */
    document.addEventListener('DOMContentLoaded', function() {
        var map, barangayLayer, outsideMaskLayer, cityBounds, geojsonData;
        var filters = { year: new Date().getFullYear(), month: null, week: null, severity: null, date_from: null, date_to: null };
        var currentLayer = 'rabies';

        // --- Initialize Map ---
        map = L.map('rabies-home-map', {
            zoomControl: false,
            minZoom: 12,
            maxZoom: 18,
            zoomSnap: 0.5,
            worldCopyJump: false
        }).setView([14.3270, 120.9370], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Reset view control (bottom-right)
        var resetControl = L.control({ position: 'bottomright' });
        resetControl.onAdd = function() {
            var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.innerHTML = '<button class="rabies-home-reset-btn" title="Reset view" style="padding:0;margin:0;">⟲</button>';
            div.querySelector('button').onclick = function(e) {
                e.preventDefault();
                if (cityBounds) map.fitBounds(cityBounds);
                else map.setView([14.3270, 120.9370], 12);
            };
            return div;
        };
        resetControl.addTo(map);

        var loadingEl = document.querySelector('.rabies-home-loading');
        if (loadingEl) loadingEl.style.display = 'none';

        setTimeout(function() { map.invalidateSize(); }, 150);

        // --- Color helpers ---
        function getColor(cases) {
            if (currentLayer === 'vaccination') {
                return cases > 20 ? '#166534' : cases > 10 ? '#15803d' : cases > 5 ? '#22c55e' : cases > 0 ? '#86efac' : '#cbd5e1';
            } else {
                return cases > 20 ? '#dc2626' : cases > 10 ? '#ea580c' : cases > 5 ? '#eab308' : cases > 0 ? '#fde68a' : '#cbd5e1';
            }
        }
        function getBorderColor(cases) { return cases > 0 ? '#1e293b' : '#94a3b8'; }
        function style(feature) {
            var c = feature.properties.cases || 0;
            return { fillColor: getColor(c), weight: c > 0 ? 2.5 : 1.5, color: getBorderColor(c), fillOpacity: c > 0 ? 0.8 : 0.45, opacity: 1 };
        }
        function highlightFeature(e) {
            var layer = e.target;
            layer.setStyle({ weight: 4, color: '#4338ca', fillOpacity: 0.55 });
            layer.bringToFront();
        }
        function resetHighlight(e) {
            var c = e.target.feature.properties.cases || 0;
            e.target.setStyle({ weight: c > 0 ? 2.5 : 1.5, color: getBorderColor(c), fillOpacity: c > 0 ? 0.8 : 0.45 });
        }
        function onEachFeature(feature, layer) {
            var name = feature.properties.name || 'Unknown';
            var cases = feature.properties.cases || 0;
            var status, label;
            if (currentLayer === 'vaccination') {
                if (cases > 20) { status = 'Excellent'; label = 'High Coverage'; }
                else if (cases > 10) { status = 'Good'; label = 'Moderate Coverage'; }
                else if (cases > 5) { status = 'Fair'; label = 'Low Coverage'; }
                else if (cases > 0) { status = 'Low'; label = 'Minimal'; }
                else { status = 'None'; label = 'No Data'; }
            } else {
                if (cases > 20) { status = 'Critical'; label = 'Critical'; }
                else if (cases > 10) { status = 'High'; label = 'High'; }
                else if (cases > 5) { status = 'Moderate'; label = 'Moderate'; }
                else if (cases > 0) { status = 'Low'; label = 'Low'; }
                else { status = 'None'; label = 'No Cases'; }
            }
            layer.bindTooltip(
                '<div style="font-family:Inter,system-ui;min-width:110px;">' +
                '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;">' + name + '</div>' +
                '<div style="font-size:20px;font-weight:700;color:' + getColor(cases) + ';">' + cases + '</div>' +
                '<div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:1px;">' + label + '</div>' +
                '</div>', { direction: 'center', className: '', offset: [0, 0], pane: 'popupPane' }
            );
            layer.on({ mouseover: highlightFeature, mouseout: resetHighlight });
        }

        // --- Outside city mask ---
        function createOutsideMask(bounds) {
            var s = bounds.getSouth(), n = bounds.getNorth(), e = bounds.getEast(), w = bounds.getWest();
            return L.polygon([
                [[s-10, w-10], [s-10, e+10], [n+10, e+10], [n+10, w-10], [s-10, w-10]],
                [[s, e], [n, e], [n, w], [s, w], [s, e]]
            ], { fillColor: '#f1f5f9', fillOpacity: 0.7, color: 'transparent', weight: 0 });
        }

        // --- Normalize barangay name ---
        function normalizeBarangayName(name) {
            var n = name.toLowerCase().replace(/\s+/g, '').replace(/\(.*\)/, '');
            n = n.replace(/iii$/, '3').replace(/ii$/, '2').replace(/iv$/, '4').replace(/v$/, '5').replace(/i$/, '1');
            return n;
        }

        // --- Fetch boundary + barangays ---
        fetch('/geojson/dasmarinas-city-boundary.geojson')
            .then(function(r) { return r.json(); })
            .then(function(boundary) {
                var polys = { type: 'FeatureCollection', features: boundary.features.filter(function(f) { return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'; }) };
                L.geoJSON(polys, { fillColor: 'transparent', color: '#334155', weight: 2.5, opacity: 1 }).addTo(map);
                cityBounds = L.geoJSON(polys).getBounds();
                outsideMaskLayer = createOutsideMask(cityBounds).addTo(map);
                map.setMaxBounds(cityBounds);
                map.fitBounds(cityBounds);
                map.on('drag', function() { map.panInsideBounds(cityBounds, { animate: false }); });
            });

        fetch('/geojson/barangays/dasmarinas-barangays.geojson')
            .then(function(r) { return r.json(); })
            .then(function(geojson) {
                geojsonData = geojson;

                // Fetch heatmap data from public API endpoint (same pattern as city-vet /rabies-geomap/data)
                fetch('{{ route('public.rabies-heatmap-data') }}')
                    .then(function(r) { if (!r.ok) throw new Error('Failed to load rabies data'); return r.json(); })
                    .then(function(data) {
                        rabiesHomeUpdateMap(data.heatmapData);
                        rabiesHomeUpdateStats({ heatmapData: data.heatmapData });

                        // Hide loading overlays once data is rendered
                        var loadingOverlay = document.getElementById('rabiesHomeMapLoading');
                        if (loadingOverlay) {
                            loadingOverlay.classList.add('hidden');
                            loadingOverlay.style.display = 'none';
                        }
                        var loadingEl = document.querySelector('.rabies-home-loading');
                        if (loadingEl) loadingEl.style.display = 'none';
                    })
                    .catch(function(err) {
                        console.error('Data Error:', err);
                        document.getElementById('rabiesHomeMapError').classList.remove('hidden');
                        var loadingOverlay = document.getElementById('rabiesHomeMapLoading');
                        if (loadingOverlay) {
                            loadingOverlay.classList.add('hidden');
                            loadingOverlay.style.display = 'none';
                        }
                        var loadingEl = document.querySelector('.rabies-home-loading');
                        if (loadingEl) loadingEl.style.display = 'none';
                    });
            })
            .catch(function(err) {
                console.error('GeoJSON Error:', err);
                document.getElementById('rabiesHomeMapError').classList.remove('hidden');
                var loadingOverlay = document.getElementById('rabiesHomeMapLoading');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.style.display = 'none';
                }
                var loadingEl = document.querySelector('.rabies-home-loading');
                if (loadingEl) loadingEl.style.display = 'none';
            });

        // --- Layer switching ---
        window.rabiesHomeSwitchLayer = function(layerType) {
            currentLayer = layerType;
            document.getElementById('rabiesHomeBtnRabiesLayer').classList.toggle('bg-indigo-600', layerType === 'rabies');
            document.getElementById('rabiesHomeBtnRabiesLayer').classList.toggle('text-white', layerType === 'rabies');
            document.getElementById('rabiesHomeBtnRabiesLayer').classList.toggle('border-indigo-600', layerType === 'rabies');
            document.getElementById('rabiesHomeBtnRabiesLayer').classList.toggle('shadow-[0_2px_8px_rgba(79,70,229,0.3)]', layerType === 'rabies');
            document.getElementById('rabiesHomeBtnVaccinationLayer').classList.toggle('bg-indigo-600', layerType === 'vaccination');
            document.getElementById('rabiesHomeBtnVaccinationLayer').classList.toggle('text-white', layerType === 'vaccination');
            document.getElementById('rabiesHomeBtnVaccinationLayer').classList.toggle('border-indigo-600', layerType === 'vaccination');
            document.getElementById('rabiesHomeBtnVaccinationLayer').classList.toggle('shadow-[0_2px_8px_rgba(79,70,229,0.3)]', layerType === 'vaccination');
            rabiesHomeUpdateLegend();
            rabiesHomeUpdateStatsLabels();
            rabiesHomeFetchFilteredData();
        };

        function rabiesHomeUpdateLegend() {
            var items = document.querySelectorAll('.simple-legend-item');
            if (currentLayer === 'vaccination') {
                items[0].querySelector('.simple-legend-dot').style.background = '#166534';
                items[0].querySelector('.simple-legend-text').textContent = 'Excellent (20+)';
                items[1].querySelector('.simple-legend-dot').style.background = '#15803d';
                items[1].querySelector('.simple-legend-text').textContent = 'Good (11-19)';
                items[2].querySelector('.simple-legend-dot').style.background = '#22c55e';
                items[2].querySelector('.simple-legend-text').textContent = 'Fair (6-10)';
                items[3].querySelector('.simple-legend-dot').style.background = '#86efac';
                items[3].querySelector('.simple-legend-text').textContent = 'Low (1-5)';
                items[4].querySelector('.simple-legend-dot').style.background = '#cbd5e1';
                items[4].querySelector('.simple-legend-text').textContent = 'No Vaccinations';
            } else {
                items[0].querySelector('.simple-legend-dot').style.background = '#dc2626';
                items[0].querySelector('.simple-legend-text').textContent = 'Critical (20+)';
                items[1].querySelector('.simple-legend-dot').style.background = '#ea580c';
                items[1].querySelector('.simple-legend-text').textContent = 'High (11-19)';
                items[2].querySelector('.simple-legend-dot').style.background = '#eab308';
                items[2].querySelector('.simple-legend-text').textContent = 'Moderate (6-10)';
                items[3].querySelector('.simple-legend-dot').style.background = '#fde68a';
                items[3].querySelector('.simple-legend-text').textContent = 'Low (1-5)';
                items[4].querySelector('.simple-legend-dot').style.background = '#cbd5e1';
                items[4].querySelector('.simple-legend-text').textContent = 'No Cases';
            }
        }

        function rabiesHomeUpdateStatsLabels() {
            var totalLabel = document.getElementById('rabiesHomeStatTotalLabel');
            var totalIcon = document.getElementById('rabiesHomeStatTotalIcon');
            var affectedLabel = document.getElementById('rabiesHomeStatAffectedLabel');
            var affectedIcon = document.getElementById('rabiesHomeStatAffectedIcon');
            var criticalLabel = document.getElementById('rabiesHomeStatCriticalLabel');
            var criticalIcon = document.getElementById('rabiesHomeStatCriticalIcon');
            if (currentLayer === 'vaccination') {
                totalLabel.textContent = 'Total Vaccinations';
                totalIcon.className = 'w-2 h-2 rounded-full bg-green-600';
                affectedLabel.textContent = 'Coverage Areas';
                affectedIcon.className = 'w-2 h-2 rounded-full bg-emerald-500';
                criticalLabel.textContent = 'High Coverage';
                criticalIcon.className = 'w-2 h-2 rounded-full bg-emerald-700';
            } else {
                totalLabel.textContent = 'Total Cases';
                totalIcon.className = 'w-2 h-2 rounded-full bg-red-500';
                affectedLabel.textContent = 'Affected';
                affectedIcon.className = 'w-2 h-2 rounded-full bg-amber-500';
                criticalLabel.textContent = 'Critical';
                criticalIcon.className = 'w-2 h-2 rounded-full bg-rose-500';
            }
        }

        // --- Filters ---
        window.rabiesHomeToggleFilter = function() {
            var panel = document.getElementById('rabiesHomeFilterPanel');
            panel.classList.toggle('hidden');
        };
        window.rabiesHomeClearFilters = function() {
            filters.month = null; filters.week = null; filters.severity = null; filters.date_from = null; filters.date_to = null;
            document.getElementById('rabiesHomeFilterMonth').value = '';
            rabiesHomeUpdateSeverityLegendUI();
            rabiesHomeFetchFilteredData();
            document.getElementById('rabiesHomeFilterPanel').classList.add('hidden');
        };

        window.rabiesHomeSetSeverityFilter = function(severity) {
            if (filters.severity === severity) { filters.severity = null; }
            else { filters.severity = severity; }
            rabiesHomeUpdateSeverityLegendUI();
            rabiesHomeFetchFilteredData();
        };

        function rabiesHomeUpdateSeverityLegendUI() {
            document.querySelectorAll('.simple-legend-item').forEach(function(item) { item.classList.remove('severity-active'); });
            if (filters.severity) {
                var activeItem = document.querySelector('.simple-legend-item[onclick*="' + filters.severity + '"]');
                if (activeItem) activeItem.classList.add('severity-active');
            }
        }

        document.getElementById('rabiesHomeFilterYear')?.addEventListener('change', function() {
            filters.year = parseInt(this.value);
            rabiesHomeFetchFilteredData();
        });
        document.getElementById('rabiesHomeFilterMonth')?.addEventListener('change', function() {
            filters.month = this.value ? parseInt(this.value) : null;
            rabiesHomeFetchFilteredData();
        });

        // Date inputs (added dynamically if present)
        document.getElementById('rabiesHomeFilterDateFrom')?.addEventListener('change', function() {
            filters.date_from = this.value || null;
            rabiesHomeFetchFilteredData();
        });
        document.getElementById('rabiesHomeFilterDateTo')?.addEventListener('change', function() {
            filters.date_to = this.value || null;
            rabiesHomeFetchFilteredData();
        });

        // --- Fetch filtered data ---
        window.rabiesHomeFetchFilteredData = function() {
            var loadingOverlay = document.getElementById('rabiesHomeMapLoading');
            if (loadingOverlay) loadingOverlay.classList.remove('hidden');

            var params = new URLSearchParams();
            params.append('year', filters.year);
            params.append('type', currentLayer);
            if (filters.month) params.append('month', filters.month);
            if (filters.week) params.append('week', filters.week);
            if (filters.date_from) params.append('date_from', filters.date_from);
            if (filters.date_to) params.append('date_to', filters.date_to);
            if (filters.severity) params.append('severity', filters.severity);

            var baseUrl = '/public/rabies-heatmap-data';
            fetch(baseUrl + '?' + params.toString())
                .then(function(r) { if (!r.ok) throw new Error('Failed to load rabies data'); return r.json(); })
                .then(function(data) {
                    rabiesHomeUpdateMap(data.heatmapData);
                    rabiesHomeUpdateStats(data);
                    if (loadingOverlay) loadingOverlay.classList.add('hidden');
                })
                .catch(function(err) {
                    console.error('Data Error:', err);
                    document.getElementById('rabiesHomeMapError').classList.remove('hidden');
                    if (loadingOverlay) loadingOverlay.classList.add('hidden');
                });
        };

        function rabiesHomeUpdateMap(heatmapData) {
            var caseData = {};
            heatmapData.forEach(function(item) { caseData[normalizeBarangayName(item.name)] = item.count; });
            if (!geojsonData || !geojsonData.features) return;
            var copy = JSON.parse(JSON.stringify(geojsonData));
            copy.features.forEach(function(f) {
                var name = normalizeBarangayName(f.properties.name || '');
                f.properties.cases = caseData[name] || 0;
                f.properties.name = f.properties.name || 'Unknown';
            });
            var polygons = { type: 'FeatureCollection', features: copy.features.filter(function(f) { return f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'; }) };
            if (barangayLayer) map.removeLayer(barangayLayer);
            barangayLayer = L.geoJSON(polygons, { style: style, onEachFeature: onEachFeature, pointToLayer: function() { return null; } }).addTo(map);
            barangayLayer.bringToFront();
            map.eachLayer(function(l) { if (l instanceof L.TileLayer) l.bringToBack(); });
        }

        function rabiesHomeUpdateStats(data) {
            var total = 0, affected = 0, highCount = 0;
            data.heatmapData.forEach(function(item) {
                total += item.count;
                if (item.count > 0) affected++;
                if (currentLayer === 'vaccination') { if (item.count > 10) highCount++; }
                else { if (item.count > 20) highCount++; }
            });
            document.getElementById('rabiesHomeStatTotal').textContent = total;
            document.getElementById('rabiesHomeStatAffected').textContent = affected;
            document.getElementById('rabiesHomeStatCritical').textContent = highCount;
        }

        // --- Top Barangays Modal ---
        var rabiesHomeTopBarangaysCurrentType = 'rabies';
        var rabiesHomeTopBarangaysCurrentLimit = 5;

        window.rabiesHomeOpenTopBarangaysModal = function() {
            var backdrop = document.getElementById('rabiesHomeTopBarangaysModalBackdrop');
            var list = document.getElementById('rabiesHomeTopBarangaysList');
            var empty = document.getElementById('rabiesHomeTopBarangaysEmpty');
            var loading = document.getElementById('rabiesHomeTopBarangaysLoading');
            list.innerHTML = ''; list.classList.add('hidden'); empty.classList.add('hidden'); loading.classList.remove('hidden');
            backdrop.classList.remove('hidden');
            setTimeout(function() { backdrop.classList.remove('opacity-0'); }, 10);
            rabiesHomeLoadTopBarangays();
        };
        window.rabiesHomeCloseTopBarangaysModal = function() {
            var backdrop = document.getElementById('rabiesHomeTopBarangaysModalBackdrop');
            backdrop.classList.add('opacity-0');
            setTimeout(function() { backdrop.classList.add('hidden'); }, 200);
        };
        window.rabiesHomeSetTopBarangaysType = function(type) {
            rabiesHomeTopBarangaysCurrentType = type;
            document.getElementById('rabiesHomeTopBarangaysTypeRabies').classList.toggle('text-indigo-600', type === 'rabies');
            document.getElementById('rabiesHomeTopBarangaysTypeRabies').classList.toggle('bg-white', type === 'rabies');
            document.getElementById('rabiesHomeTopBarangaysTypeRabies').classList.toggle('shadow-sm', type === 'rabies');
            document.getElementById('rabiesHomeTopBarangaysTypeVaccination').classList.toggle('text-indigo-600', type === 'vaccination');
            document.getElementById('rabiesHomeTopBarangaysTypeVaccination').classList.toggle('bg-white', type === 'vaccination');
            document.getElementById('rabiesHomeTopBarangaysTypeVaccination').classList.toggle('shadow-sm', type === 'vaccination');
            document.getElementById('rabiesHomeTopBarangaysModalSubtitle').textContent = type === 'rabies' ? 'Confirmed Rabies Cases' : 'Vaccination Coverage';
            rabiesHomeLoadTopBarangays();
        };
        window.rabiesHomeSetTopBarangaysLimit = function(limit) {
            rabiesHomeTopBarangaysCurrentLimit = limit;
            document.getElementById('rabiesHomeTopBarangaysLimit5').classList.toggle('text-indigo-600', limit === 5);
            document.getElementById('rabiesHomeTopBarangaysLimit5').classList.toggle('bg-white', limit === 5);
            document.getElementById('rabiesHomeTopBarangaysLimit5').classList.toggle('shadow-sm', limit === 5);
            document.getElementById('rabiesHomeTopBarangaysLimit10').classList.toggle('text-indigo-600', limit === 10);
            document.getElementById('rabiesHomeTopBarangaysLimit10').classList.toggle('bg-white', limit === 10);
            document.getElementById('rabiesHomeTopBarangaysLimit10').classList.toggle('shadow-sm', limit === 10);
            rabiesHomeLoadTopBarangays();
        };

        function rabiesHomeLoadTopBarangays() {
            var params = new URLSearchParams();
            params.append('year', document.getElementById('rabiesHomeFilterYear')?.value || new Date().getFullYear());
            params.append('month', document.getElementById('rabiesHomeFilterMonth')?.value || '');
            params.append('type', rabiesHomeTopBarangaysCurrentType);
            params.append('limit', rabiesHomeTopBarangaysCurrentLimit);
            fetch('{{ route('public.rabies-heatmap-data') }}?' + params.toString())
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    rabiesHomeRenderTopBarangays(data.heatmapData || []);
                })
                .catch(function(err) {
                    console.error('Error loading top barangays:', err);
                    document.getElementById('rabiesHomeTopBarangaysLoading').classList.add('hidden');
                    document.getElementById('rabiesHomeTopBarangaysEmpty').classList.remove('hidden');
                });
        }

        function rabiesHomeRenderTopBarangays(data) {
            var loading = document.getElementById('rabiesHomeTopBarangaysLoading');
            var list = document.getElementById('rabiesHomeTopBarangaysList');
            var empty = document.getElementById('rabiesHomeTopBarangaysEmpty');
            loading.classList.add('hidden');
            if (!data || data.length === 0) { list.classList.add('hidden'); empty.classList.remove('hidden'); return; }
            var year = document.getElementById('rabiesHomeFilterYear')?.value || new Date().getFullYear();
            document.getElementById('rabiesHomeTopBarangaysFilterLabel').textContent = year;
            list.innerHTML = '';
            data.forEach(function(item, index) {
                var rank = index + 1;
                var rankColor = rank === 1 ? '#dc2626' : rank === 2 ? '#ea580c' : rank === 3 ? '#eab308' : '#64748b';
                var hasCoords = item.latitude && item.longitude;
                var row = document.createElement('div');
                row.className = 'flex items-center gap-3 px-3 py-2.5 border border-slate-200 rounded-xl bg-white hover:bg-indigo-50 hover:border-indigo-200 transition-colors cursor-pointer';
                row.onclick = function() { rabiesHomeCloseTopBarangaysModal(); if (hasCoords && map) { map.setView([item.latitude, item.longitude], 15); map.invalidateSize(); } };
                row.innerHTML = '<div class="flex items-center justify-center w-6"><span class="text-xs font-bold" style="color:' + rankColor + '">#' + rank + '</span></div>' +
                    '<div class="flex-1 min-w-0"><p class="text-sm font-semibold text-slate-800 truncate" title="' + item.name + '">' + item.name + '</p><p class="text-[10px] text-slate-500 truncate">Barangay ID: ' + item.barangay_id + '</p></div>' +
                    '<div class="text-right hidden sm:block"><p class="text-sm font-bold text-slate-800">' + item.count + '</p><p class="text-[10px] text-slate-400">' + (rabiesHomeTopBarangaysCurrentType === 'vaccination' ? 'doses' : 'cases') + '</p></div>' +
                    '<div class="w-8 flex items-center justify-end text-[10px] text-slate-400">' + (hasCoords ? '<i class="fa-solid fa-location-dot"></i>' : '<i class="fa-solid fa-slash opacity-30"></i>') + '</div>';
                list.appendChild(row);
            });
            list.classList.remove('hidden'); empty.classList.add('hidden');
        }
    });
    </script>

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

    @include('Client.partials.footer')

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
                        titleEl.textContent = filter === 'adoption' ? 'Adoption' : 'Lost Pets';
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
                'pet_image' => $pet->image_url,
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
                'pet_image' => $pet->image_url,
                'pet_status' => $pet->pet_status,
            ];
        })->toArray()) !!};

        const allPetsData = [...missingPetsData, ...adoptionPetsData];

        function showPetModal(petId) {
            const pet = allPetsData.find(p => p.pet_id === petId);
            if (!pet) return;

            const imageUrl = pet.pet_image
                ? pet.pet_image
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

    <!-- Modal: Account Required (Guest Modal 1) -->
    <div id="notLoggedInModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative transform transition-all">
            <button onclick="closeNotLoggedInModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-user-lock text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Account Required</h3>
                <p class="text-slate-600 text-sm mt-2 leading-relaxed">
                    To book mobile clinic appointments, track your pet's vaccination records, and manage schedules in Dasmariñas City, please log in or create an account.
                </p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50">
                    <i class="fa-solid fa-check-circle text-emerald-600 w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm text-slate-700">Access Pet Adoption, Spay/Neuter &amp; Vaccination services</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50">
                    <i class="fa-solid fa-check-circle text-emerald-600 w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm text-slate-700">Track &amp; manage your upcoming appointment schedule</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50">
                    <i class="fa-solid fa-check-circle text-emerald-600 w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm text-slate-700">Receive real-time updates on your booking status</span>
                </div>
            </div>

            <button onclick="window.location.href='{{ route('login') }}'" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-600/20 transition-all mt-2 flex items-center justify-center space-x-2">
                <span>Log In to Book</span>
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>

            <button onclick="window.location.href='{{ route('register') }}'" class="w-full bg-slate-50 text-slate-700 font-semibold py-3 rounded-xl border border-slate-200 hover:bg-slate-100 transition-colors mt-2">
                Create Account
            </button>

            <button onclick="openExploreServicesModal(); closeNotLoggedInModal();" class="w-full text-sm text-emerald-600 font-medium hover:text-emerald-700 py-2 mt-4 transition-colors underline underline-offset-4">
                Continue browsing services as Guest
            </button>
        </div>
    </div>

    <!-- Modal: Explore Veterinary Services (Guest Modal 2) -->
    <div id="exploreServicesModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6">
        <div class="bg-white rounded-3xl max-w-xl w-full max-h-[90vh] flex flex-col shadow-2xl relative transform transition-all">
            <button onclick="closeExploreServicesModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100 transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="p-6 sm:p-8 flex-1 overflow-y-auto">
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-0.5 rounded-full uppercase tracking-tighter">
                        <i class="fa-solid fa-user text-[10px]"></i> Guest View
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Explore Veterinary Services</h3>
                <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                    Select a service below to view details.
                </p>

                <div class="space-y-3">
                    <!-- Pet Registration -->
                    <a href="{{ url('/pet-registration') }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-emerald-200 transition-colors text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fa-solid fa-clipboard-list text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-800 text-sm block">Pet Registration</span>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Register your pet to get an digital pet ID and manage their appointments.</p>
                            </div>
                        </div>
                        <span class="text-emerald-600 text-xs font-semibold whitespace-nowrap">View Service <i class="fa-solid fa-arrow-right ml-0.5 text-[10px]"></i></span>
                    </a>

                    <!-- Spay & Neuter -->
                    <a href="{{ url('/kapon') }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-blue-200 transition-colors text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fa-solid fa-scissors text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-800 text-sm block">Spay &amp; Neuter (<i>Kapon</i>)</span>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Free or affordable surgery to keep your pet healthy and prevent unwanted litters.</p>
                            </div>
                        </div>
                        <span class="text-blue-600 text-xs font-semibold whitespace-nowrap">View Service <i class="fa-solid fa-arrow-right ml-0.5 text-[10px]"></i></span>
                    </a>

                    <!-- Anti-Rabies Vaccination -->
                    <a href="{{ url('/vaccination') }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-purple-200 transition-colors text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fa-solid fa-syringe text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-800 text-sm block">Anti-Rabies Vaccination</span>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Free anti-rabies shots to keep your pet protected and safe at local mobile clinic visits.</p>
                            </div>
                        </div>
                        <span class="text-purple-600 text-xs font-semibold whitespace-nowrap">View Service <i class="fa-solid fa-arrow-right ml-0.5 text-[10px]"></i></span>
                    </a>

                    <!-- Lost & Found Pets -->
                    <a href="{{ url('/missing-pets') }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-rose-200 transition-colors text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fa-solid fa-magnifying-glass text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-800 text-sm block">Lost &amp; Found Pets</span>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Report a missing pet or search city records to help bring lost pets back home.</p>
                            </div>
                        </div>
                        <span class="text-rose-600 text-xs font-semibold whitespace-nowrap">View Service <i class="fa-solid fa-arrow-right ml-0.5 text-[10px]"></i></span>
                    </a>

                    <!-- Pet Adoption -->
                    <a href="{{ url('/adoption') }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-amber-200 transition-colors text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fa-solid fa-heart text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-800 text-sm block">Pet Adoption</span>
                                <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Welcome a healthy, rescued dog or cat into your family through city adoption drives.</p>
                            </div>
                        </div>
                        <span class="text-amber-600 text-xs font-semibold whitespace-nowrap">View Service <i class="fa-solid fa-arrow-right ml-0.5 text-[10px]"></i></span>
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-100 flex items-center justify-between flex-shrink-0 px-6 sm:px-8 py-4">
                <p class="text-sm text-slate-600 mb-0">Ready to make an appointment?</p>
                <a href="#" onclick="closeExploreServicesModal(); openNotLoggedInModal();" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold py-2.5 px-6 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/20 transform hover:-translate-y-0.5 active:translate-y-0">
                    <span>Log In to Book Now</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Close modals on Escape or backdrop click -->
    <script>
        function openNotLoggedInModal() {
            document.getElementById('notLoggedInModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeNotLoggedInModal() {
            document.getElementById('notLoggedInModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openExploreServicesModal() {
            document.getElementById('exploreServicesModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeExploreServicesModal() {
            document.getElementById('exploreServicesModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNotLoggedInModal();
                closeExploreServicesModal();
            }
        });

        document.getElementById('notLoggedInModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeNotLoggedInModal();
        });

        document.getElementById('exploreServicesModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeExploreServicesModal();
        });

        // Stat counter animation - animate on first view only
        (function() {
            const counters = document.querySelectorAll('.stat-counter');
            if (!counters.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.dataset.animated) {
                        entry.target.dataset.animated = 'true';
                        const target = parseInt(entry.target.dataset.count);
                        const suffix = entry.target.dataset.suffix || '';
                        let current = 0;
                        const increment = target / 100;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                entry.target.textContent = target + suffix;
                                clearInterval(timer);
                            } else {
                                entry.target.textContent = Math.floor(current) + suffix;
                            }
                        }, 20);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => observer.observe(counter));
        })();

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNotLoggedInModal();
                closeExploreServicesModal();
                closeNewsModal();
            }
        });

        document.getElementById('notLoggedInModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeNotLoggedInModal();
        });

        document.getElementById('exploreServicesModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeExploreServicesModal();
        });

        document.getElementById('newsModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeNewsModal();
        });
    </script>
</body>
</html>
