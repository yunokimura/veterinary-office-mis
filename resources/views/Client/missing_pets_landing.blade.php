<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Missing Pet - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { DEFAULT: '#066D33', light: '#077a40', dark: '#055a29' },
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
        .service-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(6, 109, 51, 0.25);
        }
    </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Dasmariñas City Veterinary Services</h1>
                        <p class="text-sm text-gray-500">Official Veterinary Office of Dasmariñas City</p>
                    </div>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('public.home') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="text-primary font-medium transition-colors">Missing Pets</a>
                </nav>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('missing-pets.form') }}" class="text-primary font-medium hover:text-primary-light transition-colors">My Report Form</a>
                    @else
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-primary-light transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(250, 204, 21, 0.8) 0%, rgba(202, 138, 4, 0.8) 100%);">
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
            <div class="grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7 lg:col-span-6 space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Report a Missing or Found Pet
                    </h1>

                    <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                        Choose the option that best describes your situation. We'll help you connect with the community to reunite pets with their owners.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                        <a href="{{ url('/missing-pets') }}" class="w-full sm:w-auto bg-primary hover:bg-primary-light text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <span>Report Missing Pet</span>
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

    <main class="py-16">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900">Report a Missing or Found Pet</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Choose the option that best describes your situation. We'll help you connect with the community to reunite pets with their owners.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm max-w-2xl mx-auto">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm max-w-2xl mx-auto">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Option A: Registered Pet Missing -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 flex flex-col hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">My Registered Pet is Missing</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-1">
                        You have a registered pet in our system and need to report them as missing. Your pet details will be pre-filled.
                    </p>
                    @auth
                        <a href="{{ route('missing-pets.form') }}" class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Go to My Form
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Login to Report
                        </a>
                        <p class="text-xs text-gray-500 text-center mt-3">You need an account to report a registered pet</p>
                    @endauth
                </div>

                <!-- Option B: Pet Missing (Not Registered) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 flex flex-col hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">My Pet is Missing (Not Registered)</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-1">
                        Your pet is not registered in our system. Fill in the details manually and we'll post the report to help find them.
                    </p>
                    <a href="{{ route('missing-pets.report.guest.create', ['type' => 'missing']) }}" class="block w-full text-center px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Report Missing Pet
                    </a>
                    <p class="text-xs text-gray-500 text-center mt-3">No account required</p>
                </div>

                <!-- Option C: Found a Pet -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 flex flex-col hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">I Found a Pet</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-1">
                        You found a pet that appears to be lost. Submit a found-pet report so the owner can find them.
                    </p>
                    <a href="{{ route('missing-pets.report.guest.create', ['type' => 'found']) }}" class="block w-full text-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Report Found Pet
                    </a>
                    <p class="text-xs text-gray-500 text-center mt-3">No account required</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/missing-pets') }}" class="inline-flex items-center text-gray-600 hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Missing Pets Gallery
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-6xl mx-auto px-6 py-6 text-center text-gray-600 text-sm">
            <p>© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
            resetCarouselTimer();
        }

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

        // Auto-advance carousel every 5 seconds
        carouselInterval = setInterval(nextSlide, 5000);

        // Reset timer when navigation buttons are clicked
        document.querySelectorAll('#aboutCarousel button[onclick="prevSlide()"], #aboutCarousel button[onclick="nextSlide()"]').forEach(button => {
            button.addEventListener('click', resetCarouselTimer);
        });

        // Initialize carousel
        showSlide(0);
    </script>
</body>
</html>
