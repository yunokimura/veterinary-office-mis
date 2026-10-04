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
                        <span class="block font-extrabold text-lg tracking-tight text-slate-900 group-hover:text-primary transition-colors">City of Dasmariñas</span>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Veterinary Services</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8 font-medium text-slate-600 text-sm">
                    <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'text-primary font-semibold' : '' }} hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="{{ request()->is('about-us') ? 'text-primary font-semibold' : '' }} hover:text-primary transition-colors">About Us</a>
                    <div class="relative">
                        <button id="servicesDropdownBtn" class="{{ request()->is('services*') ? 'text-primary font-semibold' : '' }} hover:text-primary transition-colors inline-flex items-center space-x-1">
                            <span>Services</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="servicesDropdown" class="hidden absolute top-full mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="{{ url('/services') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-circle-info text-blue-500 w-4"></i>
                                <span>Service Overview</span>
                            </a>
                            <a href="{{ url('/pet-registration') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-clipboard-list text-emerald-500 w-4"></i>
                                <span>Pet Registration</span>
                            </a>
                            <a href="{{ url('/kapon') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-scissors text-pink-500 w-4"></i>
                                <span>Spay/Neuter (<i>Kapon</i>)</span>
                            </a>
                            <a href="{{ url('/vaccination') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-syringe text-purple-500 w-4"></i>
                                <span>Anti-Rabies Vaccination</span>
                            </a>
                        </div>
                    </div>
                    <a href="{{ url('/missing-pets') }}" class="{{ request()->is('missing-pets*') ? 'text-primary font-semibold' : '' }} hover:text-primary transition-colors">Missing Pets</a>
                    <a href="{{ url('/adoption') }}" class="{{ request()->is('adoption*') ? 'text-primary font-semibold' : '' }} hover:text-primary transition-colors">Adoption</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                    <a href="{{ url('/pet-registration') }}" class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-primary/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </a>
                    @endauth
                    @auth
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white">
                                    <svg xmlns="http://www.svgsvg.com/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 001 1m-6 0h6" />
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
            <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 font-medium' }} block py-2 px-3 rounded-lg">Home</a>
            <a href="{{ url('/about-us') }}" class="{{ request()->is('about-us') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 font-medium' }} block py-2 px-3 rounded-lg">About Us</a>
            <div>
                <button id="mobileServicesBtn" class="w-full text-left py-2 px-3 rounded-lg {{ request()->is('services*') ? 'text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 font-medium' }} inline-flex items-center justify-between">
                    <span>Services</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobileServicesMenu" class="hidden pl-4 space-y-1">
                    <a href="{{ url('/services') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">
                        <i class="fa-solid fa-circle-info text-blue-500 w-4"></i>
                        <span>Service Overview</span>
                    </a>
                    <a href="{{ url('/pet-registration') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">
                        <i class="fa-solid fa-clipboard-list text-emerald-500 w-4"></i>
                        <span>Pet Registration</span>
                    </a>
                    <a href="{{ url('/kapon') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">
                        <i class="fa-solid fa-scissors text-pink-500 w-4"></i>
                        <span>Spay/Neuter (<i>Kapon</i>)</span>
                    </a>
                    <a href="{{ url('/vaccination') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">
                        <i class="fa-solid fa-syringe text-purple-500 w-4"></i>
                        <span>Anti-Rabies Vaccination</span>
                    </a>
                </div>
            </div>
            <a href="{{ url('/missing-pets') }}" class="{{ request()->is('missing-pets*') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 font-medium' }} block py-2 px-3 rounded-lg">Missing Pets</a>
            <a href="{{ url('/adoption') }}" class="{{ request()->is('adoption*') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 font-medium' }} block py-2 px-3 rounded-lg">Adoption</a>
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

    <script>
        // Services dropdown toggles
        const servicesDropdownBtn = document.getElementById('servicesDropdownBtn');
        const servicesDropdown = document.getElementById('servicesDropdown');
        const mobileServicesBtn = document.getElementById('mobileServicesBtn');
        const mobileServicesMenu = document.getElementById('mobileServicesMenu');

        if (servicesDropdownBtn && servicesDropdown) {
            servicesDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                servicesDropdown.classList.toggle('hidden');
            });
        }

        if (mobileServicesBtn && mobileServicesMenu) {
            mobileServicesBtn.addEventListener('click', function() {
                mobileServicesMenu.classList.toggle('hidden');
            });
        }

        document.addEventListener('click', function(e) {
            if (servicesDropdown && !servicesDropdownBtn.contains(e.target) && !servicesDropdown.contains(e.target)) {
                servicesDropdown.classList.add('hidden');
            }
        });
    </script>
