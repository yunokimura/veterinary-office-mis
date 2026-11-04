<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration - Dasmariñas City Veterinary Services</title>
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
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.80) 0%, rgba(20, 83, 45, 0.70) 100%);
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
    @include('Client.partials.emergency_alert')
    @include('Client.partials.navbar')

     <!-- Hero Section -->
     <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.8) 0%, rgba(20, 83, 45, 0.8) 100%);">
         <!-- Hero Content -->
         <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
              <div class="grid md:grid-cols-12 gap-8 items-center">
                  <div class="md:col-span-7 lg:col-span-6 space-y-6">
                     <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                         Pet Registration
                     </h1>

                      <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                         Register your beloved pets with Dasmariñas City Veterinary Services for official identification and access to our services.
                      </p>

                      <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                          <button onclick="handleCtaClick()" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                               <span>Register Now</span>
                              <i class="fa-solid fa-arrow-right text-sm text-white"></i>
                          </button>
                          <a href="#requirements" class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all flex items-center justify-center">
                              Requirements
                          </a>
                      </div>
                  </div>

                   <div class="md:col-span-5 lg:col-span-6">
                      <div class="relative">
                          <div class="rounded-2xl overflow-hidden shadow-xl">
                              <img src="{{ asset('images/herosection/pet%20registration.jpg') }}" alt="Pet Registration" class="w-full h-full aspect-square object-cover">
                          </div>
                      </div>
                  </div>
             </div>
         </div>
     </section>

    <!-- Why Register Your Pet -->
    <section class="py-16 sm:py-24 bg-teal-50/50 border-b border-slate-200/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="text-primary font-extrabold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Benefits</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">Why Register Your Pet?</h2>
                <p class="text-slate-600 mt-3 text-base">Official registration provides essential benefits for you, your pet, and our community. Join thousands of responsible pet owners in Dasmariñas City.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-white rounded-3xl p-8 border border-primary/10 shadow-lg shadow-primary/5 relative overflow-hidden group hover:border-primary/30 transition-all card-hover">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl shadow-md shadow-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-primary uppercase tracking-widest">Official Docs</span>
                                <h3 class="text-xl font-extrabold text-slate-900">Official Documentation</h3>
                            </div>
                        </div>
                        <p class="text-slate-600 text-base leading-relaxed mb-6">
                            Legal recognition of pet ownership with government-issued certificate. Proof of ownership for legal and administrative purposes.
                        </p>
                    </div>
                </div>

                <!-- Benefit 2 -->
                <div class="bg-white rounded-3xl p-8 border border-primary/10 shadow-lg shadow-primary/5 relative overflow-hidden group hover:border-primary/30 transition-all card-hover">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl shadow-md shadow-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-green-600 uppercase tracking-widest">Health</span>
                                <h3 class="text-xl font-extrabold text-slate-900">Health Management</h3>
                            </div>
                        </div>
                        <p class="text-slate-600 text-base leading-relaxed mb-6">
                            Keep your pet's vaccination records up-to-date with automated reminders. Never miss important health checkups or boosters.
                        </p>
                    </div>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-white rounded-3xl p-8 border border-primary/10 shadow-lg shadow-primary/5 relative overflow-hidden group hover:border-primary/30 transition-all card-hover">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-md shadow-blue-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Recovery</span>
                                <h3 class="text-xl font-extrabold text-slate-900">Lost Pet Recovery</h3>
                            </div>
                        </div>
                        <p class="text-slate-600 text-base leading-relaxed mb-6">
                            Registered pets in our database can be quickly matched and returned to their families. 24/7 recovery assistance service.
                        </p>
                    </div>
                </div>

                <!-- Benefit 4 -->
                <div class="bg-white rounded-3xl p-8 border border-primary/10 shadow-lg shadow-primary/5 relative overflow-hidden group hover:border-primary/30 transition-all card-hover">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-md shadow-purple-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-purple-600 uppercase tracking-widest">Safety</span>
                                <h3 class="text-xl font-extrabold text-slate-900">Community Safety</h3>
                            </div>
                        </div>
                        <p class="text-slate-600 text-base leading-relaxed mb-6">
                            Contribute to rabies control and public safety through responsible pet ownership. Protect your family and neighbors.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Process -->
    <section id="requirements" class="py-16 sm:py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Process</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">The Registration Process</h2>
                <p class="text-slate-600 mt-2">Simple, streamlined steps to get your pet officially registered with the city veterinary services.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <!-- Step 1 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">1</span>
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-xl group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Complete Online Form</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">
                        Fill out comprehensive pet information including breed, age, characteristics, and health details. Takes 10-15 minutes.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">2</span>
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Verification Review</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">
                        Our veterinary team verifies submitted information. May request additional documentation if needed.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">3</span>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Pet Profile Active</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">
                        Your pet is now registered in the Dasmariñas City Veterinary system. Profile is ready for appointment booking and record access.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">4</span>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Access Services</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">
                        Book appointments, update records, access vaccination history, and participate in community programs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- What Information We Collect -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Information</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">What Information We Collect</h2>
                <p class="text-slate-600 mt-2">Comprehensive profiling ensures better care and accurate record-keeping for your pet.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-primary to-secondary p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Basic Information</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-600 text-sm">
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
                </div>

                <!-- Health Profile -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-green-500 to-green-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Health Profile</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-600 text-sm">
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
                </div>

                <!-- Behavioral Profile -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-secondary to-primary p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Behavioral Profile</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-600 text-sm">
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-800 mt-2 mr-3 flex-shrink-0"></span>
                                Training status (obedience, potty-training)
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-800 mt-2 mr-3 flex-shrink-0"></span>
                                Behavior traits and temperament
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-800 mt-2 mr-3 flex-shrink-0"></span>
                                Likes, dislikes, and preferences
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-800 mt-2 mr-3 flex-shrink-0"></span>
                                Dietary needs and allergies
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy & Security -->
    <section class="pt-10 pb-16 sm:pt-16 sm:pb-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Privacy & Security</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Your Data is Protected</h2>
                <p class="text-slate-600 mt-3">Your data is protected with industry-leading security measures and strict privacy controls.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Card 1: Encrypted Storage -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-primary to-secondary p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Encrypted Storage</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 text-sm">All pet and owner data is encrypted and securely stored in our protected database.</p>
                    </div>
                </div>

                <!-- Card 2: Access Control -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-green-500 to-green-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Access Control</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 text-sm">Information accessible only to authorized veterinary staff and pet owners via secure login.</p>
                    </div>
                </div>

                <!-- Card 3: Purpose Limited -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-secondary to-primary p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Purpose Limited</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 text-sm">Data collected solely for pet health management, public safety, and veterinary service delivery.</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-slate-600 text-sm max-w-2xl mx-auto">
                    We comply with all applicable data protection regulations. Pet owners have full rights to access, update, or request deletion of their information. 
                    <a href="#" class="text-primary hover:text-primary-dark font-medium">Learn more about our privacy policy</a>.
                </p>
            </div>
        </div>
    </section>

    @include('Client.partials.footer')

    <!-- Modal: Account Required (Guest Modal) -->
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

            <button onclick="closeNotLoggedInModal();" class="w-full text-sm text-emerald-600 font-medium hover:text-emerald-700 py-2 mt-4 transition-colors underline underline-offset-4">
                Continue browsing services as Guest
            </button>
        </div>
    </div>

    <script>
        const isAuthenticated = @js(auth()->check());

        function handleCtaClick() {
            if (isAuthenticated) {
                window.location.href = '{{ route('pet.registration.form') }}';
            } else {
                openNotLoggedInModal();
            }
        }

        function openNotLoggedInModal() {
            document.getElementById('notLoggedInModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeNotLoggedInModal() {
            document.getElementById('notLoggedInModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNotLoggedInModal();
            }
        });

        document.getElementById('notLoggedInModal')?.addEventListener('click', function(event) {
            if (event.target === this) closeNotLoggedInModal();
        });
    </script>
</body>
</html>
