<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti-Rabies Vaccination - Dasmariñas City Veterinary Services</title>
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
    @include('Client.partials.navbar')

     <!-- Hero Section -->
    <section class="bg-[#066D33] min-h-[500px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title and Subtitle -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Anti-Rabies Vaccination Services</h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl mb-8">
                        Protect your beloved pets with comprehensive vaccination services provided by Dasmariñas City Veterinary Services.
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4">Why Vaccinate Your Pet?</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Protection against deadly diseases</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Required for travel and boarding</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">Community health and safety</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8">
                        @auth
                            <a href="{{ url('/vaccination/form') }}" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                                Book Anti-Rabies Vaccination
                            </a>
                        @else
                            <button onclick="showLoginPrompt()" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                                Book Anti-Rabies Vaccination
                            </button>
                        @endauth
                        <a href="#requirements" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-colors">
                            Requirements
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-white/70 text-lg">Anti-Rabies Vaccination Services</p>
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
                                    You need to be logged in to book a vaccination. Please login or register an account to continue.
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

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button || !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
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
