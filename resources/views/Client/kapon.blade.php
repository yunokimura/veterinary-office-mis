<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapon (Spay/Neuter) - Dasmariñas City Veterinary Services</title>
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

    <!-- Session Status Alert (Floating) -->
    @if (session('status'))
        <div id="successAlert" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg max-w-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">{{ session('status') }}</span>
                </div>
                <button type="button" onclick="closeAlert()" class="ml-3 text-green-700 hover:text-green-900 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
    <section class="bg-[#066D33] min-h-[500px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title, Subtitle, and Instructions -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Kapon (Spay/Neuter)</h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl mb-8">
                        Help control the pet population and give your furry friends a healthier life with our safe and affordable spay and neuter services.
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4">Why Kapon?</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Prevents unwanted litters and reduces stray animal population</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Reduces risk of certain cancers and reproductive health issues</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">Decreases aggressive behavior and roaming tendencies</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ url('/kapon/form') }}" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                            Book Your Pet
                        </a>
                        <a href="#faq" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-colors">
                            Kapon FAQ
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
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
    </section>

    <!-- Pre-surgery Reminders Card -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Pre-surgery Requirements</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Fasting Required</h4>
                                <p class="text-gray-600 text-sm">Do not feed food or water <strong>10 hours prior</strong> to surgery</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-yellow-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Good Health Required</h4>
                                <p class="text-gray-600 text-sm">Reschedule if there is coughing, sneezing, diarrhea, or other signs of illness</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Not in Heat</h4>
                                <p class="text-gray-600 text-sm">Ensure your dog is not in heat. Please reschedule if necessary. (Not applicable to cats)</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Bring Carrier or Leash</h4>
                                <p class="text-gray-600 text-sm">Prepare a leash for your dog or a secure carrier for cats. Label it with your pet's name.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Vaccination</h4>
                                <p class="text-gray-600 text-sm">For cats below 1 year old, updated vaccination is highly recommended but not required. Vaccinations are also available in the clinic.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Breed Restriction</h4>
                                <p class="text-gray-600 text-sm">❌ Short-snouted (snub-nosed) female pets are NOT recommended due to risk of breathing difficulty.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Book Section -->
    <section class="py-16 bg-gray-50" id="book">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How to Book Your Pet</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Follow these simple steps to schedule your pet's spay/neuter appointment</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white font-bold text-lg z-10">1</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4 min-h-[200px] h-full">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Complete Owner Registration</h3>
                        <p class="text-gray-600 text-sm">Login or create an account, then fill out your personal information including name, contact details, and address.</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">2</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4 min-h-[200px] h-full">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Select Pet(s) and Schedule</h3>
                        <p class="text-gray-600 text-sm">Choose your pet(s) (max 2 per booking), select an available date/time slot, and upload required photos (head, body from top/side, genitals).</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">3</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4 min-h-[200px] h-full">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pet Agreements & Health Declaration</h3>
                        <p class="text-gray-600 text-sm">Answer per-pet health questions, complete the blood test agreement (if required), and acknowledge pre-surgery requirements.</p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="relative">
                    <div class="absolute -left-4 top-0 w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold text-lg z-10">4</div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 pt-16 mt-4 min-h-[200px] h-full">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Accept Terms and Submit</h3>
                        <p class="text-gray-600 text-sm">Review and accept general conditions, acknowledge the liability disclaimer, and submit your application for confirmation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

              

            <!-- Requirements for Castration -->
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Requirements for Castration</h3>
                <p class="text-gray-600 mb-6">Please bring these items with you if you are visiting the Veterinary Office for the free castration (kapon) service.</p>
                <div class="grid md:grid-cols-2 gap-3">
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 bottle of betadine</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 bottle of hydrogen peroxide</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">2 pieces of dental bib</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 piece of hemostan 500mg cap</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 piece of surgical blade 21 or 23</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">5 pieces of sterile gauze pad</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 piece of Polyglactin 3/0 (purple)</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 piece of Polyglactin 2/0 (purple)</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 pack of Cotton Balls</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl shadow-sm flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">1 piece of doormat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white" id="faq">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Common questions about spay/neuter (Kapon) surgery</p>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Why should I spay/neuter my pet?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>In addition to avoiding unwanted litters, they will also avoid a number of illnesses and infections if they are neutered, therefore helping them live longer and happier lives.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can my pet die from the surgery?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Spay and neuter surgeries are safe procedures. The risks are not related to the surgery itself, but to pre-existing conditions that your pet may have. This is why we require a blood test to ensure that your pet is healthy before the surgery. Complications may arise during the procedure, but that is also the case with any other type of surgery, and it is relatively rare.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Is it true that I should wait until they have their first litter before spaying/neutering?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>There is no scientific basis for this. In fact, science tells us that it's better to spay/neuter your pet before their first heat. Waiting for a first litter is completely unnecessary — even risky, since complications may arise while giving birth and it could be fatal.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Do you offer free spay/neuter surgery?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>We offer free kapon at the shelter every February. Please follow our Facebook or Instagram for updates on when the next one is scheduled and how to register. You may also coordinate with your LGU and request to organize a kapon outreach in your area.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can you spay/neuter the stray cats in our neighborhood?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Yes, but it has to be under an organized TNVR (Trap-Neuter-Vaccinate-Return) program with your community. Proper TNVR is the ONLY sustainable solution to our stray population problems. Learn more about TNVR here.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Will my pet gain weight after being spayed/neutered?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Physiological and hormonal changes may affect your pet's metabolism and appetite, making them prone to weight gain.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can spaying/neutering fix my pet's behavioral problems?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>It can only reduce undesirable behavior that is caused by the heat cycle, such as aggressiveness, marking or spraying, or the tendency to run away to search for a mate. Proper training is still the best way to have a well-mannered pet.</p>
                    </div>
                </div>
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
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
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
