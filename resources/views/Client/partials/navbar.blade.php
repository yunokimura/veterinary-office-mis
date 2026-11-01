    <!-- Main Header / Navigation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @php
        $servicesActive = request()->is('services*')
            || request()->is('pet-registration*')
            || request()->is('kapon*')
            || request()->is('vaccination*');
    @endphp

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm">
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
                <nav class="hidden lg:flex items-center space-x-8 font-medium text-slate-600 text-base">
                    <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'text-primary font-semibold underline underline-offset-4 decoration-2' : '' }} hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="{{ request()->is('about-us') ? 'text-primary font-semibold underline underline-offset-4 decoration-2' : '' }} hover:text-primary transition-colors">About Us</a>
                    <div class="relative">
                        <button id="servicesDropdownBtn" class="{{ $servicesActive ? 'text-primary font-semibold underline underline-offset-4 decoration-2' : '' }} hover:text-primary transition-colors inline-flex items-center space-x-1">
                            <span>Services</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="servicesDropdown" class="hidden absolute top-full mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
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
                    <a href="{{ url('/missing-pets') }}" class="{{ request()->is('missing-pets*') ? 'text-primary font-semibold underline underline-offset-4 decoration-2' : '' }} hover:text-primary transition-colors">Lost &amp; Found Pets</a>
                    <a href="{{ url('/adoption') }}" class="{{ request()->is('adoption*') ? 'text-primary font-semibold underline underline-offset-4 decoration-2' : '' }} hover:text-primary transition-colors">Adoption</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                    <button type="button" onclick="openAppointmentModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Book Appointment</span>
                    </button>
                    <div class="relative">
                        <button onclick="toggleNotificationDropdown()" class="relative p-2 rounded-lg hover:bg-emerald-50 transition text-emerald-600">
                            <i class="fa-solid fa-bell text-xl"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>
                        <div id="notificationDropdown" class="hidden absolute -left-[60px] mt-2 w-80 bg-white rounded-lg shadow-lg border border-slate-200 z-50">
                            <div class="p-3 border-b border-slate-100">
                                <h3 class="font-semibold text-slate-800">Notifications</h3>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ route('notifications.index') }}" class="block p-3 hover:bg-slate-50 border-b border-slate-50 last:border-0">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-100 text-blue-600">
                                                <i class="fa-solid fa-bell text-sm"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-800 truncate">{{ $notification->title }}</p>
                                                <p class="text-xs text-slate-500 truncate">{{ $notification->message }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-slate-500">
                                        <i class="fa-solid fa-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($unreadCount > 0)
                                <div class="p-2 border-t border-slate-100">
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-sm text-emerald-600 hover:text-emerald-800 py-1">
                                            Mark all as read
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endauth
                    @auth
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white">
                                    <svg xmlns="http://www.svgsvg.com/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-emerald-600 font-medium hidden lg:block">{{ Auth::user()->first_name }}@if (Auth::user()->middle_name) {{ mb_substr(Auth::user()->middle_name, 0, 1) }}.@endif {{ Auth::user()->last_name }}</span>
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
                         <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary transition-colors mr-3">Login</a>
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
            <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'bg-primary/10 text-primary font-semibold underline' : 'text-slate-600 hover:bg-slate-50 font-medium' }} text-base block py-2 px-3 rounded-lg">Home</a>
            <a href="{{ url('/about-us') }}" class="{{ request()->is('about-us') ? 'bg-primary/10 text-primary font-semibold underline' : 'text-slate-600 hover:bg-slate-50 font-medium' }} text-base block py-2 px-3 rounded-lg">About Us</a>
            <div>
                <button id="mobileServicesBtn" class="w-full text-left py-2 px-3 rounded-lg {{ $servicesActive ? 'text-primary font-semibold underline' : 'text-slate-600 hover:bg-slate-50 font-medium' }} text-base inline-flex items-center justify-between">
                    <span>Services</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobileServicesMenu" class="hidden pl-4 space-y-1">
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
            <a href="{{ url('/missing-pets') }}" class="{{ request()->is('missing-pets*') ? 'bg-primary/10 text-primary font-semibold underline' : 'text-slate-600 hover:bg-slate-50 font-medium' }} text-base block py-2 px-3 rounded-lg">Lost &amp; Found Pets</a>
            <a href="{{ url('/adoption') }}" class="{{ request()->is('adoption*') ? 'bg-primary/10 text-primary font-semibold underline' : 'text-slate-600 hover:bg-slate-50 font-medium' }} text-base block py-2 px-3 rounded-lg">Adoption</a>
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

    @auth
    <!-- Appointment Type Selection Modal -->
    <div id="appointmentTypeModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 flex items-center justify-center p-4 sm:p-6">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 sm:p-8 transform transition-all relative">
            <button type="button" onclick="closeAppointmentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">Select Appointment Type</h3>
                <p class="text-base text-gray-500 mt-1 max-w-lg mx-auto">
                    Please choose the service you would like to book an appointment for.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 my-6">
                <div onclick="selectAppointmentFlow('vaccination')" class="border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50/40 rounded-xl p-6 cursor-pointer transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-lg bg-purple-500 text-white flex items-center justify-center mb-3 shadow-sm group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-syringe"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Anti-Rabies Vaccination</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Book a rabies vaccination appointment for your pet.
                        </p>
                    </div>
                    <button type="button" class="mt-4 w-full bg-purple-500 group-hover:bg-purple-600 text-white text-sm font-bold py-2.5 px-4 rounded-lg transition shadow-sm flex items-center justify-center space-x-1">
                        <span>Book Vaccination</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <div onclick="selectAppointmentFlow('kapon')" class="border-2 border-gray-200 hover:border-pink-500 hover:bg-pink-50/40 rounded-xl p-6 cursor-pointer transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-lg bg-pink-500 text-white flex items-center justify-center mb-3 shadow-sm group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-scissors"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-lg mb-1">Spay/Neuter (Kapon)</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Book a spay or neuter (kapon) appointment for your pet.
                        </p>
                    </div>
                    <button type="button" class="mt-4 w-full bg-pink-500 group-hover:bg-pink-600 text-white text-sm font-bold py-2.5 px-4 rounded-lg transition shadow-sm flex items-center justify-center space-x-1">
                        <span>Book Kapon</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="button" onclick="closeAppointmentModal()" class="text-sm font-semibold text-gray-400 hover:text-gray-600">
                    Cancel and go back
                </button>
            </div>
        </div>
    </div>
    @endauth

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

        // User dropdown toggle
        function toggleDropdown() {
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                userDropdown.classList.toggle('hidden');
            }
        }

        // Notification dropdown toggle
        function toggleNotificationDropdown() {
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.classList.toggle('hidden');
            }
        }

        // Close notification dropdown when clicking outside
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationBtn = document.querySelector('button[onclick="toggleNotificationDropdown()"]');
        if (notificationDropdown && notificationBtn) {
            document.addEventListener('click', function(e) {
                if (!notificationDropdown.contains(e.target) && !notificationBtn.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        // Close user dropdown when clicking outside
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            document.addEventListener('click', function(e) {
                const userDropdownBtn = document.querySelector('button[onclick="toggleDropdown()"]');
                if (!userDropdownBtn?.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }

        // Appointment type modal
        function openAppointmentModal() {
            const modal = document.getElementById('appointmentTypeModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAppointmentModal() {
            const modal = document.getElementById('appointmentTypeModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function selectAppointmentFlow(appointmentType) {
            const targetUrl = appointmentType === 'kapon' ? '/kapon/form' : '/vaccination/form';
            closeAppointmentModal();
            window.location.href = targetUrl;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('appointmentTypeModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeAppointmentModal();
                }
            }
        });

        document.getElementById('appointmentTypeModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAppointmentModal();
            }
        });
    </script>
