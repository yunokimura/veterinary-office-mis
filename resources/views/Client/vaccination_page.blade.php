<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti-Rabies Vaccination - Dasmariñas City Veterinary Services</title>
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
    @include('Client.partials.emergency_alert')
    @include('Client.partials.navbar')

     <!-- Hero Section -->
    <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.8) 0%, rgba(20, 83, 45, 0.8) 100%);">
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <!-- Left Side: Title, Subtitle, and Instructions -->
                <div class="md:col-span-7 lg:col-span-6 space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">Anti-Rabies Vaccination Services</h1>
                    <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                        Protect your beloved pets with comprehensive vaccination services provided by Dasmariñas City Veterinary Services.
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <h2 class="text-xl font-bold text-white mb-4">Why Vaccinate Your Pet?</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Protection against deadly diseases</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Required for travel and boarding</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-primary text-white rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">Community health and safety</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                        <button onclick="openNotLoggedInModal()" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <span>Book Anti-Rabies Vaccination</span>
                            <i class="fa-solid fa-arrow-right text-sm text-white"></i>
                        </button>
                        <a href="#requirements" class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all flex items-center justify-center">
                            Requirements
                        </a>
                    </div>
                </div>
                <!-- Right Side: Hero Image -->
                <div class="md:col-span-5 lg:col-span-6">
                    <div class="relative">
                        <div class="rounded-2xl overflow-hidden shadow-xl bg-white/10 backdrop-blur-sm">
                            <img src="{{ asset('images/herosection/vaccine.jpg') }}" alt="Anti-Rabies Vaccination Services" class="w-full h-full aspect-square object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Important Ways to Control / Prevent Rabies -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-2xl p-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 text-center">Important Ways to Control / Prevent Rabies</h2>
                
                <!-- What should I do if I was bitten by dog/cat? -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 underline">What should I do if I was bitten by dog/cat?</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Wash wound with soap and running water for 15 minutes. (Apply alcohol or iodine if available)</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Go to the nearest Animal Bite Treatment Centers. (Below)</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Make sure that the vaccination schedule is followed.</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">If you are bitten but did not go to the ABTC around the area. Please go to ABTC.</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Observe the animal for 14 days (if alive, the dog is not rabies)</p>
                        </div>
                    </div>
                </div>
                
                <!-- What should I do if I find rabies suspect dog? -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 underline">What should I do if I find rabies suspect dog?</h3>
                    <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-700">Please report to your local barangay or the municipal/city agriculture or veterinary office.</p>
                    </div>
                </div>
                
                <!-- How can I help in preventing rabies? -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 underline">How can I help in preventing rabies?</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Vaccinating dogs at 3 months then every year thereafter.</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Prevent dog/cat bites, do not approach dog/cat.</p>
                        </div>
                        <div class="flex items-start space-x-3 bg-white p-3 rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">Keep your pet inside house.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('Client.partials.footer')

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

        @if($showSuccessModal ?? false)
        window.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('successModal');
            if (modal) modal.classList.remove('hidden');
        });
        @endif
    </script>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 text-center">
                <div class="mb-4">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Success</h3>
                <p class="text-gray-600 mb-6">Your vaccination pre-registration has been submitted successfully.</p>
                <button type="button" onclick="document.getElementById('successModal').classList.add('hidden'); window.location.href='/vaccination';" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors w-full">
                    Okay
                </button>
            </div>
        </div>
    </div>
</body>
</html>
