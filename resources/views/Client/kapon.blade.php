<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapon (Spay/Neuter) - Dasmariñas City Veterinary Services</title>
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
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.9) 0%, rgba(76, 29, 149, 0.95) 100%);
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

     <!-- Session Status Alert (Floating) -->
    @if (session('status'))
        <div id="successAlert" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-white border border-slate-200 text-slate-800 px-4 py-3 rounded-2xl shadow-xl max-w-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm">{{ session('status') }}</span>
                </div>
                <button type="button" onclick="closeAlert()" class="ml-3 text-slate-400 hover:text-slate-600 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <script>
            function closeAlert() {
                document.getElementById('successAlert').style.display = 'none';
            }
            // Auto-close after 15 seconds
            setTimeout(function() {
                const alert = document.getElementById('successAlert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 15000);
        </script>
    @endif

    <!-- Hero Section -->
    <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(109, 40, 217, 0.9) 0%, rgba(76, 29, 149, 0.95) 100%);">
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <!-- Left Side: Title, Subtitle, and Instructions -->
                <div class="md:col-span-7 lg:col-span-6 space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">Kapon (Spay/Neuter)</h1>
                    <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                        Help control the pet population and give your furry friends a healthier life with our safe and affordable spay and neuter services.
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <h2 class="text-xl font-bold text-white mb-4">Why Kapon?</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-violet-800 rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Prevents unwanted litters and reduces stray animal population</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-violet-800 rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Reduces risk of certain cancers and reproductive health issues</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-violet-800 rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">Decreases aggressive behavior and roaming tendencies</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                        @auth
                            <a href="{{ url('/kapon/form') }}" class="w-full sm:w-auto bg-white text-violet-800 hover:bg-violet-50 font-bold px-8 py-4 rounded-xl shadow-lg shadow-black/20 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                <span>Book Your Pet</span>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                        @else
                            <button onclick="showLoginPrompt()" class="w-full sm:w-auto bg-white text-violet-800 hover:bg-violet-50 font-bold px-8 py-4 rounded-xl shadow-lg shadow-black/20 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                <span>Book Your Pet</span>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </button>
                        @endauth
                        <a href="#faq" class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all flex items-center justify-center">
                            Kapon FAQ
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="md:col-span-5 lg:col-span-6 flex justify-center">
                    <div class="w-full max-w-lg">
                        <div class="rounded-2xl overflow-hidden shadow-xl bg-white/10 backdrop-blur-sm">
                            <div class="aspect-square flex items-center justify-center">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <p class="text-white/70 text-lg">Kapon Services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-surgery Requirements Section -->
    <section class="py-16 bg-teal-50/50 border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Pre-Surgery</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">Pre-surgery Requirements</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Fasting Required -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-red-500 to-red-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Fasting Required</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">Do not feed food or water <strong>10 hours prior</strong> to surgery</p>
                    </div>
                </div>

                <!-- Good Health Required -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-green-500 to-green-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Good Health Required</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">Reschedule if there is coughing, sneezing, diarrhea, or other signs of illness</p>
                    </div>
                </div>

                <!-- Not in Heat -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-purple-500 to-purple-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Not in Heat</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">Ensure your dog is not in heat. Please reschedule if necessary. (Not applicable to cats)</p>
                    </div>
                </div>

                <!-- Bring Carrier or Leash -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-blue-500 to-blue-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Bring Carrier or Leash</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">Prepare a leash for your dog or a secure carrier for cats. Label it with your pet's name.</p>
                    </div>
                </div>

                <!-- Vaccination -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-emerald-500 to-emerald-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Vaccination</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">For cats below 1 year old, updated vaccination is highly recommended but not required. Vaccinations are also available in the clinic.</p>
                    </div>
                </div>

                <!-- Breed Restriction -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden card-hover">
                    <div class="h-16 bg-gradient-to-r from-amber-500 to-amber-600 p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white ml-4">Breed Restriction</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-600 leading-relaxed">❌ Short-snouted (snub-nosed) female pets are NOT recommended due to risk of breathing difficulty.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Book Section -->
    <section class="py-16 sm:py-20 bg-slate-50 border-y border-slate-100" id="book">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">Process</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">How to Book Your Pet</h2>
                <p class="text-slate-600 mt-2">Follow these simple steps to schedule your pet's spay/neuter appointment</p>
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
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Complete Owner Registration</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">Login or create an account, then fill out your personal information including name, contact details, and address.</p>
                </div>

                <!-- Step 2 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">2</span>
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Select Pet(s) and Schedule</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">Choose your pet(s) (max 2 per booking), select an available date/time slot, and upload required photos (head, body from top/side, genitals).</p>
                </div>

                <!-- Step 3 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">3</span>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Pet Agreements & Health Declaration</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">Answer per-pet health questions, complete the blood test agreement (if required), and acknowledge pre-surgery requirements.</p>
                </div>

                <!-- Step 4 -->
                <div class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.5rem)] service-card bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-sm flex-shrink-0">4</span>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Accept Terms and Submit</h3>
                    <p class="text-slate-600 text-sm leading-relaxed flex-1">Review and accept general conditions, acknowledge the liability disclaimer, and submit your application for confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements for Castration -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Requirements for Castration</h2>
            <p class="text-slate-600 mb-6">Please bring these items with you if you are visiting the Veterinary Office for the free castration (kapon) service.</p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 bottle of betadine</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 bottle of hydrogen peroxide</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">2 pieces of dental bib</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 piece of hemostan 500mg cap</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 piece of surgical blade 21 or 23</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">5 pieces of sterile gauze pad</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 piece of Polyglactin 3/0 (purple)</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 piece of Polyglactin 2/0 (purple)</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 pack of Cotton Balls</span>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex items-center gap-3 card-hover">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-slate-700">1 piece of doormat</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white border-t border-slate-100" id="faq">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-primary font-bold text-xs uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full mb-2">FAQ</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">Frequently Asked Questions</h2>
                <p class="text-slate-600 mt-2">Common questions about spay/neuter (Kapon) surgery</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Why should I spay/neuter my pet?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>In addition to avoiding unwanted litters, they will also avoid a number of illnesses and infections if they are neutered, therefore helping them live longer and happier lives.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Can my pet die from the surgery?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>Spay and neuter surgeries are safe procedures. The risks are not related to the surgery itself, but to pre-existing conditions that your pet may have. This is why we require a blood test to ensure that your pet is healthy before the surgery. Complications may arise during the procedure, but that is also the case with any other type of surgery, and it is relatively rare.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Is it true that I should wait until they have their first litter before spaying/neutering?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>There is no scientific basis for this. In fact, science tells us that it's better to spay/neuter your pet before their first heat. Waiting for a first litter is completely unnecessary — even risky, since complications may arise while giving birth and it could be fatal.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Do you offer free spay/neuter surgery?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>We offer free kapon at the shelter every February. Please follow our Facebook or Instagram for updates on when the next one is scheduled and how to register. You may also coordinate with your LGU and request to organize a kapon outreach in your area.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Can you spay/neuter the stray cats in our neighborhood?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>Yes, but it has to be under an organized TNVR (Trap-Neuter-Vaccinate-Return) program with your community. Proper TNVR is the ONLY sustainable solution to our stray population problems. Learn more about TNVR here.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Will my pet gain weight after being spayed/neutered?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>Physiological and hormonal changes may affect your pet's metabolism and appetite, making them prone to weight gain.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 card-hover overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-slate-900">Can spaying/neutering fix my pet's behavioral problems?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-slate-600">
                        <p>It can only reduce undesirable behavior that is caused by the heat cycle, such as aggressiveness, marking or spraying, or the tendency to run away to search for a mate. Proper training is still the best way to have a well-mannered pet.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('Client.partials.footer')

    <!-- Login Prompt Modal -->
    <div id="loginPromptModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                                    You need to be logged in to book a kapon appointment. Please login or register an account to continue.
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

        // FAQ Toggle
        function toggleFaq(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
</body>
</html>
