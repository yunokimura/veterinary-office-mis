<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Dasmariñas City Veterinary Services</title>
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
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800">
    @include('Client.partials.navbar')

     <!-- Hero Section -->
     <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.8) 0%, rgba(20, 83, 45, 0.8) 100%);">
         <!-- Hero Content -->
         <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
              <div class="grid md:grid-cols-12 gap-8 items-center">
                  <div class="md:col-span-7 lg:col-span-6 space-y-6">
                     <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                         Leading the way in animal welfare and public health.
                     </h1>

                      <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                         Discover how the Dasmariñas City Veterinary Office serves our community by bridging the gap between animal care and 
                         human well-being under the One Health initiative.
                     </p>

                     <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                         <a href="{{ url('/services') }}" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                              <span>Explore Our Services</span>
                             <i class="fa-solid fa-arrow-right text-sm"></i>
                         </a>
                     </div>
                 </div>

                  <div class="md:col-span-5 lg:col-span-6">
                     <div class="relative">
                         <div class="rounded-2xl overflow-hidden shadow-xl bg-white/10 backdrop-blur-sm">
                             <!-- Carousel Container -->
                             <div id="aboutCarousel" class="relative h-96 overflow-hidden">
                                 <!-- Carousel Slide 1 -->
                                 <div class="carousel-slide absolute w-full h-full">
                                     <img src="{{ asset('images/carousel pics/carousel_1.jpg') }}" alt="Dasmariñas City Veterinary Services 1" class="w-full h-full object-cover">
                                 </div>
                                 <!-- Carousel Slide 2 -->
                                 <div class="carousel-slide absolute w-full h-full">
                                     <img src="{{ asset('images/carousel pics/carousel_2.jpg') }}" alt="Dasmariñas City Veterinary Services 2" class="w-full h-full object-cover">
                                 </div>
                                 <!-- Carousel Slide 3 -->
                                 <div class="carousel-slide absolute w-full h-full">
                                     <img src="{{ asset('images/carousel pics/carousel_3.jpg') }}" alt="Dasmariñas City Veterinary Services 3" class="w-full h-full object-cover">
                                 </div>
                                 <!-- Carousel Slide 4 -->
                                 <div class="carousel-slide absolute w-full h-full">
                                     <img src="{{ asset('images/carousel pics/carousel_4.jpg') }}" alt="Dasmariñas City Veterinary Services 4" class="w-full h-full object-cover">
                                 </div>
                             </div>

                             <!-- Carousel Controls -->
                             <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110" aria-label="Previous slide">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                 </svg>
                             </button>
                             <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110" aria-label="Next slide">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                 </svg>
                             </button>

                             <!-- Carousel Indicators -->
                             <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                                 <button onclick="goToSlide(0)" class="carousel-indicator w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-colors" aria-label="Go to slide 1"></button>
                                 <button onclick="goToSlide(1)" class="carousel-indicator w-3 h-3 rounded-full bg-white/30 hover:bg-white/70 transition-colors" aria-label="Go to slide 2"></button>
                                 <button onclick="goToSlide(2)" class="carousel-indicator w-3 h-3 rounded-full bg-white/30 hover:bg-white/70 transition-colors" aria-label="Go to slide 3"></button>
                                 <button onclick="goToSlide(3)" class="carousel-indicator w-3 h-3 rounded-full bg-white/30 hover:bg-white/70 transition-colors" aria-label="Go to slide 4"></button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <!-- Our Core Pillars -->
     <section id="philosophy" class="py-16 sm:py-20 bg-slate-50 border-y border-slate-100">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="text-center max-w-2xl mx-auto mb-14">
                 <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Our Core Pillars</span>
                 <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">Anchored on Global & Municipal Health Goals</h2>
                 <p class="text-slate-600 mt-2">Strategic priorities guiding our work toward a rabies-free, healthier community.</p>
             </div>

             <div class="flex flex-wrap justify-center gap-6">
                 <!-- Card 1: Zero by 2030 -->
                 <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                     <div>
                         <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                             <i class="fa-solid fa-bullseye"></i>
                         </div>
                         <h3 class="text-xl font-bold text-slate-900 mb-2">"Zero by 2030" Global Goal</h3>
                         <p class="text-slate-600 text-sm leading-relaxed">
                             Aligning local municipal efforts with the global strategy to eliminate dog-mediated human rabies by 2030 through proactive surveillance, mass ant-rabies vaccination, and community engagement.
                         </p>
                     </div>
                 </div>

                 <!-- Card 2: 70% Herd Immunity -->
                 <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                     <div>
                         <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                             <i class="fa-solid fa-shield-virus"></i>
                         </div>
                         <h3 class="text-xl font-bold text-slate-900 mb-2">70% Herd Immunity Target</h3>
                         <p class="text-slate-600 text-sm leading-relaxed">
                             Utilizing geospatial mapping across all 75 barangays to monitor vaccination coverage, identify high-risk clusters, and ensure our pet population reaches the 70% herd immunity threshold.
                         </p>
                     </div>
                 </div>

                 <!-- Card 3: One Health Framework -->
                 <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                     <div>
                         <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                             <i class="fa-solid fa-handshake"></i>
                         </div>
                         <h3 class="text-xl font-bold text-slate-900 mb-2">The One Health Framework</h3>
                         <p class="text-slate-600 text-sm leading-relaxed">
                             Bridging the gap between animal care, human health, and environmental safety — recognizing that protecting pets directly safeguards human life.
                         </p>
                     </div>
                 </div>
             </div>
         </div>
      </section>

     <!-- Core Functional Areas -->
     <section class="py-16 bg-white">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <h2 class="text-3xl font-bold text-gray-900 mb-6">Core Functional Areas</h2>
             <div class="grid md:grid-cols-2 gap-6">
                 <!-- Zoonotic Disease Control -->
                 <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                     <div class="h-16 bg-gradient-to-r from-red-500 to-red-600 p-4 flex items-center">
                         <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                             </svg>
                         </div>
                         <h3 class="text-xl font-bold text-white ml-4">Zoonotic Disease Control</h3>
                     </div>
                     <div class="p-6">
                         <p class="text-gray-600 leading-relaxed">Rabies elimination under the "Zero by 2030" global target, geospatial map surveillance, and maintaining 70% herd immunity across 75 barangays.</p>
                     </div>
                 </div>

                 <!-- Animal Welfare & Population Management -->
                 <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                     <div class="h-16 bg-gradient-to-r from-purple-500 to-purple-600 p-4 flex items-center">
                         <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                             </svg>
                         </div>
                         <h3 class="text-xl font-bold text-white ml-4">Animal Welfare & Population Management</h3>
                     </div>
                     <div class="p-6">
                         <p class="text-gray-600 leading-relaxed">Mass anti-rabies vaccination and spay/neuter (kapon) programs, humane stray population control, pet adoption services, and missing pet monitoring.</p>
                     </div>
                 </div>

                 <!-- Veterinary Public Health & Food Safety -->
                 <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                     <div class="h-16 bg-gradient-to-r from-blue-500 to-blue-600 p-4 flex items-center">
                         <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                             </svg>
                         </div>
                         <h3 class="text-xl font-bold text-white ml-4">Veterinary Public Health & Food Safety</h3>
                     </div>
                     <div class="p-6">
                         <p class="text-gray-600 leading-relaxed">Meat inspections across slaughterhouses and markets to prevent food-borne pathogens and protect consumer health under national standards.</p>
                     </div>
                 </div>

                  <!-- Community Education & Advocacy -->
                  <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                      <div class="h-16 bg-gradient-to-r from-amber-500 to-amber-600 p-4 flex items-center">
                          <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                              <i class="fa-solid fa-users text-white text-xl"></i>
                          </div>
                          <h3 class="text-xl font-bold text-white ml-4">Community Education & Advocacy</h3>
                      </div>
                      <div class="p-6">
                          <p class="text-gray-600 leading-relaxed">Promoting responsible pet ownership and barangay-level engagement under the unified One Health Framework.</p>
                      </div>
                  </div>
             </div>
         </div>
     </section>

       <!-- Main Content -->
       <section class="pt-8 pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
               <!-- Demographic & Service Coverage -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Demographic & Service Coverage</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                     <div class="bg-red-50 rounded-xl p-5 border border-gray-100 card-hover">
                         <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                             </svg>
                         </div>
                         <span class="text-red-700">Urban and suburban pet-owning households</span>
                     </div>
                     <div class="bg-purple-100 rounded-xl p-5 border border-gray-100 card-hover">
                         <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center flex-shrink-0">
                             <i class="fa-solid fa-cow text-purple-600"></i>
                         </div>
                         <span class="text-purple-700">Livestock and poultry raisers</span>
                     </div>
                     <div class="bg-blue-50 rounded-xl p-5 border border-gray-100 card-hover">
                         <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                             </svg>
                         </div>
                         <span class="text-blue-700">Meat vendors and food business operators</span>
                     </div>
                     <div class="bg-amber-50 rounded-xl p-5 border border-gray-100 card-hover">
                         <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                             </svg>
                         </div>
                         <span class="text-amber-700">Barangay officials and designated animal welfare officers</span>
                     </div>
                      <div class="bg-green-50 rounded-xl p-5 border border-gray-100 card-hover">
                          <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                              </svg>
                          </div>
                          <span class="text-green-700">General public at risk of zoonotic diseases</span>
                      </div>
             </div>
         </div>
     </section>

     <!-- Mission & Vision Section -->
     <section class="py-16 sm:py-24 bg-teal-50/50 border-b border-slate-200/60 relative">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                 <span class="text-teal-600 font-extrabold text-xs uppercase tracking-widest block mb-2">Purpose & Future</span>
                 <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Our Mission & Vision</h2>
                 <p class="text-slate-600 mt-3 text-base">Guiding every diagnosis, treatment plan, and community initiative with clarity and heart.</p>
             </div>

             <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
                 <!-- Mission Card -->
                 <div class="bg-white rounded-3xl p-8 sm:p-10 border border-teal-100 shadow-lg shadow-teal-900/5 relative overflow-hidden flex flex-col justify-between group hover:border-teal-300 transition-all card-hover">
                     <div class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                     <div class="relative z-10">
                         <div class="flex items-center gap-4 mb-6">
                             <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-2xl shadow-md shadow-teal-600/30">
                                 <i class="fa-solid fa-bullseye"></i>
                             </div>
                             <div>
                                 <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Our Purpose</span>
                                 <h3 class="text-2xl font-extrabold text-slate-900">Our Mission</h3>
                             </div>
                         </div>
                         <p class="text-slate-600 text-base leading-relaxed mb-6">
                             To uphold the principles of One Health by protecting human health, promoting animal welfare, and
                             safeguarding the environment through accessible veterinary services, disease prevention and
                             control, responsible pet ownership advocacy, food safety regulation, and strong community
                             partnerships.
                         </p>
                     </div>
                 </div>

                 <!-- Vision Card -->
                 <div class="bg-slate-900 text-white rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-xl relative overflow-hidden flex flex-col justify-between group hover:border-amber-400/40 transition-all card-hover">
                     <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                     <div class="relative z-10">
                         <div class="flex items-center gap-4 mb-6">
                             <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shadow-md shadow-amber-500/30">
                                 <i class="fa-solid fa-compass"></i>
                             </div>
                             <div>
                                 <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Looking Ahead</span>
                                 <h3 class="text-2xl font-extrabold text-white">Our Vision</h3>
                             </div>
                         </div>
                         <p class="text-slate-300 text-base leading-relaxed mb-6">
                             A model One Health city where human health, animal welfare, food safety, and environmental protection are fully integrated through proactive disease prevention, responsible stewardship, and sustainable veterinary governance.
                         </p>
                     </div>
                  </div>
              </div>
          </div>
      </section>

      <!-- Community Spotlight Section -->
      <section class="py-16 sm:py-24 bg-white border-t border-slate-100">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="text-center max-w-2xl mx-auto mb-12">
                  <span class="text-primary font-bold text-xs uppercase tracking-widest">Community Spotlight</span>
                  <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Our Partners in Public Health</h2>
                  <p class="text-slate-600 mt-3">Protecting Dasmariñas starts with caring pet owners across our 75 barangays. Here are the real stories and moments from our community drives.</p>
              </div>

               <div class="relative px-2 md:px-8 overflow-hidden">
                   <!-- Carousel Container -->
                   <div id="communityCarousel">
                      <div id="communityCarouselTrack" class="flex transition-transform duration-500 ease-in-out">
                          <!-- Card 1: Responsible Pet Ownership -->
                          <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                              <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                  <div class="aspect-square relative">
                                      <img src="{{ asset('images/carousel2/responsible.jpg') }}" alt="Responsible Pet Ownership" class="w-full h-full object-cover">
                                  </div>
                                   <div class="p-5 text-center">
                                       <h3 class="text-lg font-bold text-slate-900 mt-1">Responsible Pet Ownership</h3>
                                   </div>
                               </div>
                           </div>

                           <!-- Card 2: Anti-Rabies Vaccination -->
                           <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                               <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                   <div class="aspect-square relative">
                                       <img src="{{ asset('images/carousel2/vaccine.jpg') }}" alt="Anti-Rabies Vaccination" class="w-full h-full object-cover">
                                   </div>
                                   <div class="p-5 text-center">
                                       <h3 class="text-lg font-bold text-slate-900 mt-1">Anti-Rabies Vaccination</h3>
                                   </div>
                               </div>
                           </div>

                           <!-- Card 3: Spay & Neuter (Kapon) -->
                           <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                               <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                   <div class="aspect-square relative">
                                       <img src="{{ asset('images/carousel2/spay-neuter.jpg') }}" alt="Spay & Neuter (Kapon)" class="w-full h-full object-cover">
                                   </div>
                                   <div class="p-5 text-center">
                                       <h3 class="text-lg font-bold text-slate-900 mt-1">Spay & Neuter (Kapon)</h3>
                                   </div>
                               </div>
                           </div>

                           <!-- Card 4: Pet Adoption -->
                           <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                               <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                   <div class="aspect-square relative">
                                       <img src="{{ asset('images/carousel2/adoption.jpg') }}" alt="Pet Adoption" class="w-full h-full object-cover">
                                   </div>
                                   <div class="p-5 text-center">
                                       <h3 class="text-lg font-bold text-slate-900 mt-1">Pet Adoption</h3>
                                   </div>
                               </div>
                           </div>

                           <!-- Card 5: Missing Pet Reporting -->
                           <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                               <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                   <div class="aspect-square relative">
                                       <img src="{{ asset('images/carousel2/missing.jpg') }}" alt="Missing Pet Reporting" class="w-full h-full object-cover">
                                   </div>
                                   <div class="p-5 text-center">
                                       <h3 class="text-lg font-bold text-slate-900 mt-1">Missing Pet Reporting</h3>
                                   </div>
                               </div>
                           </div>
                      </div>
                  </div>

                  <!-- Navigation Buttons -->
                  <button onclick="prevCommunitySlide()" class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110 z-10" aria-label="Previous slide">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                      </svg>
                  </button>
                  <button onclick="nextCommunitySlide()" class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110 z-10" aria-label="Next slide">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                      </svg>
                  </button>
              </div>
          </div>
      </section>

      @include('Client.partials.footer')

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

           // Carousel functionality
           let currentSlide = 0;
           const slides = document.querySelectorAll('.carousel-slide');
           const indicators = document.querySelectorAll('.carousel-indicator');
           let carouselInterval;

           function resetCarouselTimer() {
               clearInterval(carouselInterval);
               carouselInterval = setInterval(nextSlide, 5000);
           }

           function showSlide(index) {
               slides.forEach((slide, i) => {
                   slide.style.display = i === index ? 'block' : 'none';
               });
               indicators.forEach((indicator, i) => {
                   if (i === index) {
                       indicator.classList.remove('bg-white/30');
                       indicator.classList.add('bg-white/70');
                   } else {
                       indicator.classList.remove('bg-white/70');
                       indicator.classList.add('bg-white/30');
                   }
               });
           }

           function nextSlide() {
               currentSlide = (currentSlide + 1) % slides.length;
               showSlide(currentSlide);
           }

           function prevSlide() {
               currentSlide = (currentSlide - 1 + slides.length) % slides.length;
               showSlide(currentSlide);
           }

           function goToSlide(index) {
               currentSlide = index;
               showSlide(currentSlide);
               resetCarouselTimer();
           }

           // Auto-advance carousel every 5 seconds
           carouselInterval = setInterval(nextSlide, 5000);

           // Reset timer when navigation buttons are clicked
           document.querySelectorAll('#aboutCarousel button[onclick="prevSlide()"], #aboutCarousel button[onclick="nextSlide()"]').forEach(button => {
               button.addEventListener('click', resetCarouselTimer);
           });

           // Initialize carousel
           showSlide(0);

          // Community Spotlight Carousel
          let communityCurrentIndex = 0;
          const communityTotalSlides = 5;
          const communityTrack = document.getElementById('communityCarouselTrack');
          let communityInterval;

          function resetCommunityTimer() {
              clearInterval(communityInterval);
              communityInterval = setInterval(nextCommunitySlide, 5000);
          }

          function updateCommunityCarousel() {
              if (!communityTrack) return;
              
              const isMobile = window.innerWidth < 768;
              const cardWidth = communityTrack.children[0].getBoundingClientRect().width;
              const visibleCards = isMobile ? 1 : 3;
              const offset = -communityCurrentIndex * cardWidth + (visibleCards === 3 ? cardWidth : 0);
              
              communityTrack.style.transform = `translateX(${offset}px)`;
              
               // Style cards
               Array.from(communityTrack.children).forEach((card, i) => {
                   const isActive = i === communityCurrentIndex;
                   
                   if (isActive) {
                       card.classList.add('scale-105', 'opacity-100');
                       card.classList.remove('scale-95', 'opacity-60');
                   } else {
                       card.classList.add('scale-95', 'opacity-60');
                       card.classList.remove('scale-105', 'opacity-100');
                   }
               });
          }

          function nextCommunitySlide() {
              communityCurrentIndex = (communityCurrentIndex + 1) % communityTotalSlides;
              updateCommunityCarousel();
          }

          function prevCommunitySlide() {
              communityCurrentIndex = (communityCurrentIndex - 1 + communityTotalSlides) % communityTotalSlides;
              updateCommunityCarousel();
          }

          // Auto-advance every 5 seconds
          communityInterval = setInterval(nextCommunitySlide, 5000);

           // Reset timer on navigation
           document.querySelectorAll('button[onclick="prevCommunitySlide()"], button[onclick="nextCommunitySlide()"]').forEach(button => {
               button.addEventListener('click', resetCommunityTimer);
           });

          // Initialize
          updateCommunityCarousel();

          // Update on resize
          window.addEventListener('resize', updateCommunityCarousel);
      </script>
</body>
</html>