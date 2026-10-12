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

                      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                          <h2 class="text-xl font-semibold text-white mb-4">Why Register Your Pet?</h2>
                          <div class="space-y-3">
                              <div class="flex items-start space-x-3">
                                  <span class="bg-white text-primary rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                  <p class="text-white">Official identification and documentation</p>
                              </div>
                              <div class="flex items-start space-x-3">
                                  <span class="bg-white text-primary rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                  <p class="text-white">Access to veterinary services and programs</p>
                              </div>
                              <div class="flex items-start space-x-3">
                                  <span class="bg-white text-primary rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                  <p class="text-white">Lost pet recovery assistance</p>
                              </div>
                          </div>
                      </div>
                      <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                          @auth
                              <a href="{{ url('/pet-registration/form') }}" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                   <span>Register Now</span>
                                  <i class="fa-solid fa-arrow-right text-sm"></i>
                              </a>
                          @else
                              <button onclick="showLoginPrompt()" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                   <span>Register Now</span>
                                  <i class="fa-solid fa-arrow-right text-sm"></i>
                              </button>
                          @endauth
                          <a href="#requirements" class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all flex items-center justify-center">
                              Requirements
                          </a>
                      </div>
                  </div>

                  <div class="md:col-span-5 lg:col-span-6">
                     <div class="relative">
                         <div class="rounded-2xl overflow-hidden shadow-xl bg-white/10 backdrop-blur-sm">
                             <!-- Placeholder Image -->
                             <div class="aspect-square">
                                 <div class="w-full h-full flex items-center justify-center">
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
                 </div>
             </div>
         </div>
     </section>

    <!-- Why Register Your Pet -->
    <section class="py-16 sm:py-24 bg-teal-50/50 border-b border-slate-200/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="text-primary font-extrabold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Benefits</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Why Register Your Pet?</h2>
                <p class="text-slate-600 mt-3 text-base">Official registration provides essential benefits for you, your pet, and our community. Join thousands of responsible pet owners in Dasmariñas City.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-white rounded-3xl p-8 border border-primary/10 shadow-lg shadow-primary/5 relative overflow-hidden group hover:border-primary/30 transition-all card-hover">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-2xl shadow-md shadow-primary/30">
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
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Process</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3">The Registration Process</h2>
                <p class="text-slate-600 mt-2">Simple, streamlined steps to get your pet officially registered with the city veterinary services.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <!-- Step 1 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-bold text-lg z-10">1</div>
                    <div class="pt-4">
                        <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-2xl mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Complete Online Form</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Fill out comprehensive pet information including breed, age, characteristics, and health details. Takes 10-15 minutes.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">2</div>
                    <div class="pt-4">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Verification Review</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Our veterinary team verifies submitted information. May request additional documentation if needed.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">3</div>
                    <div class="pt-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Certificate Issuance</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Receive your official registration certificate. Digital copy available immediately, physical copy mailed within 7 days.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">4</div>
                    <div class="pt-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Access Services</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Book appointments, update records, access vaccination history, and participate in community programs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What Information We Collect -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Information</span>
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
                    <div class="h-16 bg-gradient-to-r from-amber-500 to-amber-600 p-4 flex items-center">
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
        </div>
    </section>

    <!-- Privacy & Security -->
    <section class="py-16 sm:py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Privacy & Security</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Your Data is Protected</h2>
                <p class="text-slate-600 mt-3">Your data is protected with industry-leading security measures and strict privacy controls.</p>
            </div>

            <div class="relative px-2 md:px-8 overflow-hidden">
                <!-- Carousel Container -->
                <div id="privacyCarousel">
                    <div id="privacyCarouselTrack" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Card 1: Encrypted Storage -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                <div class="aspect-[4/3] relative bg-primary/5 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <h3 class="text-base font-bold text-slate-900">Encrypted Storage</h3>
                                    <p class="text-slate-600 text-xs mt-1">All pet and owner data is encrypted and securely stored in our protected database.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Access Control -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                <div class="aspect-[4/3] relative bg-green-50 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <h3 class="text-base font-bold text-slate-900">Access Control</h3>
                                    <p class="text-slate-600 text-xs mt-1">Information accessible only to authorized veterinary staff and pet owners via secure login.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Purpose Limited -->
                        <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden h-full">
                                <div class="aspect-[4/3] relative bg-blue-50 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <h3 class="text-base font-bold text-slate-900">Purpose Limited</h3>
                                    <p class="text-slate-600 text-xs mt-1">Data collected solely for pet health management, public safety, and veterinary service delivery.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button onclick="prevPrivacySlide()" class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110 z-10" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button onclick="nextPrivacySlide()" class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110 z-10" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
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
                <div class="gap-3 bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a href="{{ route('register') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-light focus:outline-none sm:w-auto sm:text-sm">
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

        // Privacy Carousel
        let privacyCurrentIndex = 0;
        const privacyTotalSlides = 3;
        const privacyTrack = document.getElementById('privacyCarouselTrack');
        let privacyInterval;

        function resetPrivacyTimer() {
            clearInterval(privacyInterval);
            privacyInterval = setInterval(nextPrivacySlide, 5000);
        }

        function updatePrivacyCarousel() {
            if (!privacyTrack) return;
            
            const isMobile = window.innerWidth < 768;
            const cardWidth = privacyTrack.children[0].getBoundingClientRect().width;
            const visibleCards = isMobile ? 1 : 3;
            const offset = -privacyCurrentIndex * cardWidth + (visibleCards === 3 ? cardWidth : 0);
            
            privacyTrack.style.transform = `translateX(${offset}px)`;
            
            // Style cards
            Array.from(privacyTrack.children).forEach((card, i) => {
                const isActive = i === privacyCurrentIndex;
                
                if (isActive) {
                    card.classList.add('scale-105', 'opacity-100');
                    card.classList.remove('scale-95', 'opacity-60');
                } else {
                    card.classList.add('scale-95', 'opacity-60');
                    card.classList.remove('scale-105', 'opacity-100');
                }
            });
        }

        function nextPrivacySlide() {
            privacyCurrentIndex = (privacyCurrentIndex + 1) % privacyTotalSlides;
            updatePrivacyCarousel();
        }

        function prevPrivacySlide() {
            privacyCurrentIndex = (privacyCurrentIndex - 1 + privacyTotalSlides) % privacyTotalSlides;
            updatePrivacyCarousel();
        }

        // Auto-advance every 5 seconds
        privacyInterval = setInterval(nextPrivacySlide, 5000);

        // Reset timer on navigation
        document.querySelectorAll('button[onclick="prevPrivacySlide()"], button[onclick="nextPrivacySlide()"]').forEach(button => {
            button.addEventListener('click', resetPrivacyTimer);
        });

        // Initialize
        updatePrivacyCarousel();

        // Update on resize
        window.addEventListener('resize', updatePrivacyCarousel);

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
