<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Dasmariñas City Veterinary Services</title>
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
    @include('Client.partials.navbar')

     <!-- Page Banner -->
     <section class="py-16" style="background: linear-gradient(135deg, #066D33 0%, #077a40 100%);">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                   <!-- Left Column: Text Content -->
                   <div class="max-w-2xl">
                       <h1 class="text-4xl md:text-5xl font-bold mb-6 text-white pb-5">Leading the way in animal welfare and public health.</h1>
    <p class="text-lg text-gray-100 leading-relaxed">
    Discover how the Dasmariñas City Veterinary Office serves our community by bridging the gap between animal care and 
    human well-being under the One Health initiative.
    </p>
<div class="flex flex-col sm:flex-row gap-4 pt-10">
    <a href="{{ url('/services') }}" class="bg-white text-primary px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-all shadow-lg text-center border border-primary">
        View Our Services
    </a>
</div>
</div>
                   

                 <!-- Right Column: Carousel -->
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
     </section>

     <!-- Main Content -->
     <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <!-- I. Office Background -->
             <div class="mb-16">
                 <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                     <span class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-4">
                         <span class="text-white font-bold">I</span>
                     </span>
                     Office Background
                 </h2>
                  <div class="flex flex-col lg:flex-row gap-8">
                    <div class="flex-1">
                        <p class="text-gray-700 text-lg leading-relaxed">
                            The Dasmariñas City Veterinary Office (CVO) serves as the primary local government unit
                            responsible for implementing animal health, animal welfare, veterinary public health, and food
                            safety programs within the jurisdiction of Dasmariñas City, Cavite. Operating under national laws
                            such as the Local Government Code of 1991 (RA 7160), the Animal Welfare Act (RA 8485 as
                            amended), and the Anti-Rabies Act of 2007 (RA 9482), the office acts as the frontline regulatory
                            and service arm for zoonotic disease control, responsible pet ownership, and public health
                            protection under the One Health framework.
                        </p>
                    </div>
                     <div class="lg:w-1/3">
                         <div class="rounded-2xl h-80 overflow-hidden shadow-lg -mt-20">
                             <img src="{{ asset('images/about_us1.jpg') }}" alt="About Us - Dasmariñas City Veterinary Services" class="w-full h-full object-cover">
                         </div>
                     </div>
                </div>
            </div>

            <!-- II. Demographic & Service Coverage -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-4">
                        <span class="text-white font-bold">II</span>
                    </span>
                    Demographic & Service Coverage
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                     <div class="bg-red-50 rounded-xl p-5 flex items-start space-x-3">
                         <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                             </svg>
                         </div>
                         <span class="text-red-700">Urban and suburban pet-owning households</span>
                     </div>
                     <div class="bg-purple-100 rounded-xl p-5 flex items-start space-x-3">
                         <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                             </svg>
                         </div>
                         <span class="text-purple-700">Livestock and poultry raisers</span>
                     </div>
                     <div class="bg-blue-50 rounded-xl p-5 flex items-start space-x-3">
                         <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                             </svg>
                         </div>
                         <span class="text-blue-700">Meat vendors and food business operators</span>
                     </div>
                     <div class="bg-amber-50 rounded-xl p-5 flex items-start space-x-3">
                         <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                             </svg>
                         </div>
                         <span class="text-amber-700">Barangay officials and designated animal welfare officers</span>
                     </div>
                     <div class="bg-green-50 rounded-xl p-5 flex items-start space-x-3">
                         <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                             </svg>
                         </div>
                         <span class="text-green-700">General public at risk of zoonotic diseases</span>
                     </div>
                </div>
            </div>

            <!-- Mission & Vision Section -->
            <section class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-7">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Mission & Vision</h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Guiding principles that drive our commitment to animal welfare and public health</p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Mission Card -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-8">
                            <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">
                                To uphold the principles of One Health by protecting human health, promoting animal welfare, and
                                safeguarding the environment through accessible veterinary services, disease prevention and
                                control, responsible pet ownership advocacy, food safety regulation, and strong community
                                partnerships.
                            </p>
                        </div>
                        
                        <!-- Vision Card -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-8">
                            <div class="w-16 h-16 bg-secondary/10 rounded-xl flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">
                                A model One Health city where human health, animal welfare, food safety, and environmental protection are fully integrated through proactive disease prevention, responsible stewardship, and sustainable veterinary governance.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- V. Core Functional Areas -->
            <div class="mb-8 pt-20">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-10 h-10 rounded-full bg-primary flex items-center justify-center mr-4">
                        <span class="text-white font-bold">III</span>
                    </span>
                    Core Functional Areas
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Zoonotic Disease Control -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                        <div class="h-16 bg-gradient-to-r from-red-500 to-red-600 p-4 flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white ml-4">Zoonotic Disease Control</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600">Rabies elimination, surveillance, and outbreak preparedness.</p>
                        </div>
                    </div>

                    <!-- Animal Welfare & Population Management -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                        <div class="h-16 bg-gradient-to-r from-purple-500 to-purple-600 p-4 flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white ml-4">Animal Welfare & Population Management</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600">High-volume spay/neuter programs, rescue operations, and humane enforcement.</p>
                        </div>
                    </div>

                    <!-- Veterinary Public Health & Food Safety -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                        <div class="h-16 bg-gradient-to-r from-blue-500 to-blue-600 p-4 flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white ml-4">Veterinary Public Health & Food Safety</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600">Meat inspection coordination and food-borne disease prevention.</p>
                        </div>
                    </div>

                    <!-- Community Education & Advocacy -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                        <div class="h-16 bg-gradient-to-r from-amber-500 to-amber-600 p-4 flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white ml-4">Community Education & Advocacy</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600">Responsible pet ownership campaigns and barangay-level engagement.</p>
                        </div>
                    </div>
                </div>
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
         }

         // Auto-advance carousel every 5 seconds
         setInterval(nextSlide, 5000);

         // Initialize carousel
         showSlide(0);
     </script>
</body>
</html>
