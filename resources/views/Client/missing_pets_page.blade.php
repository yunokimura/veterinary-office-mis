<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missing Pets - Dasmariñas City Veterinary Services</title>
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
        .missing-pet-card {
            cursor: pointer;
        }
        .missing-pet-card:hover .pet-image {
            transform: scale(1.05);
        }
        .pet-image {
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('Client.partials.emergency_alert')
    @include('Client.partials.navbar')

     <!-- Hero Section -->
     <section class="relative min-h-[560px] flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, rgba(250, 204, 21, 0.8) 0%, rgba(202, 138, 4, 0.8) 100%);">
         <!-- Hero Content -->
         <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center md:text-left">
             <div class="grid md:grid-cols-12 gap-8 items-center">
                 <div class="md:col-span-7 lg:col-span-6 space-y-6">
                     <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                         Report your Missing Pets
                     </h1>

                     <p class="text-white text-base sm:text-lg max-w-2xl font-light leading-relaxed">
                         Help reunite lost pets with their owners. Report missing pets quickly and reach out to the community for assistance.
                     </p>

                     <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                         @auth
                             <a href="{{ url('/missing-pets/form') }}" class="w-full sm:w-auto bg-white text-amber-600 font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                 <span>Report a Missing Pet</span>
                                 <i class="fa-solid fa-arrow-right text-sm"></i>
                             </a>
                         @else
                             <button onclick="showLoginPrompt()" class="w-full sm:w-auto bg-white text-amber-600 font-bold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                 <span>Report a Missing Pet</span>
                                 <i class="fa-solid fa-arrow-right text-sm"></i>
                             </button>
                         @endauth
                         <a href="#" class="w-full sm:w-auto bg-transparent border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white/20 transition-all flex items-center justify-center space-x-2">
                             <span>View Missing Pets</span>
                         </a>
                     </div>
                 </div>

                 <div class="md:col-span-5 lg:col-span-6">
                     <div class="relative">
                         <div class="rounded-2xl overflow-hidden shadow-xl bg-white/10 backdrop-blur-sm flex items-center justify-center" style="min-height: 24rem;">
                             <div class="text-center">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                 </svg>
                                 <p class="text-white/70 text-lg">Missing Pets</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>

    <!-- Section Title -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Missing Pets</h2>
                    <p class="text-sm text-gray-500 mt-1">Help reunite these pets with their owners</p>
                </div>
                <button onclick="toggleFilterPanel()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="font-medium">Filters</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Slide-out Filter Panel -->
    <div id="filterPanel" class="fixed inset-y-0 right-0 w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="h-full flex flex-col">
            <!-- Panel Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Filter Pets</h2>
                <button onclick="toggleFilterPanel()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Panel Content -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 mb-3">Filter by:</p>
                    
                    <button onclick="filterPets('filter', 'all')" class="filter-btn w-full px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-primary text-white text-left" data-filter="all" data-filter-type="filter">
                        All Pets
                    </button>
                    
                    <!-- Species filters side by side -->
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="filterPets('species', 'Dog')" class="filter-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Dog" data-filter-type="species">
                            🐕 Dogs
                        </button>
                        <button onclick="filterPets('species', 'Cat')" class="filter-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Cat" data-filter-type="species">
                            🐱 Cats
                        </button>
                    </div>
                    
                    <!-- Gender filters side by side -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-3">Gender:</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button onclick="filterPets('gender', 'Male')" class="filter-btn gender-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Male" data-filter-type="gender">
                                ♂ Male
                            </button>
                            <button onclick="filterPets('gender', 'Female')" class="filter-btn gender-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Female" data-filter-type="gender">
                                ♀ Female
                            </button>
                        </div>
                    </div>
                    
                    <!-- Breed filter -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Breed:</p>
                        <div class="relative">
                            <button onclick="toggleBreedDropdown()" type="button" class="w-full px-3 py-2 text-left text-sm bg-gray-100 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-between" id="breed-dropdown-button">
                                <span id="selected-breeds-display">Select breeds</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="breed-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                                @if(isset($availableBreeds) && count($availableBreeds) > 0)
                                    @foreach($availableBreeds as $breed)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" value="{{ $breed }}" class="breed-checkbox rounded text-primary focus:ring-primary" onchange="updateBreedSelection()">
                                        <span class="ml-2 text-sm text-gray-700">{{ $breed }}</span>
                                    </label>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2 text-sm text-gray-500">No breeds available</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location filter -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Last Seen Location:</p>
                        <div class="relative">
                            <button onclick="toggleLocationDropdown()" type="button" class="w-full px-3 py-2 text-left text-sm bg-gray-100 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-between" id="location-dropdown-button">
                                <span id="selected-locations-display">Select location</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="location-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                                @if(isset($availableLocations) && count($availableLocations) > 0)
                                    @foreach($availableLocations as $loc)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" value="{{ $loc }}" class="location-checkbox rounded text-primary focus:ring-primary" onchange="updateLocationSelection()">
                                        <span class="ml-2 text-sm text-gray-700">{{ $loc }}</span>
                                    </label>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2 text-sm text-gray-500">No locations available</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Current Filter Display -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Current filter:</span> 
                        <span id="currentFilterDisplay" class="text-primary font-bold">All Pets</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Showing <span id="pet-count">{{ $missingPets->total() }}</span> pets
                    </p>
                </div>
            </div>
            
            <!-- Panel Footer -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex gap-3">
                    <button onclick="clearFilters()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Clear Filter
                    </button>
                    <button onclick="applyFilters()" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="filterOverlay" onclick="toggleFilterPanel()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity"></div>

    <!-- Pets Grid -->
    <section id="pets-section" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="pets-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @forelse($missingPets as $pet)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-red-100 card-hover missing-pet-card" onclick="showPetModal({{ $pet->pet_id }})">
                        <div class="aspect-square bg-gray-200 relative overflow-hidden">
                            <img src="{{ $pet->pet_image ? asset('storage/'.$pet->pet_image) : 'https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image' }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover pet-image">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $pet->pet_name }}</h3>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $pet->species }}</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->gender == 'Male' ? 'bg-purple-100 text-purple-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $pet->gender == 'Male' ? '♂ Male' : '♀ Female' }}
                                </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Age:</span>
                                    <span class="text-gray-700 font-medium">{{ ($pet->age ?? null) > 50 ? 'N/A' : ($pet->age ?? 'N/A') }} years</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Weight:</span>
                                    <span class="text-gray-700 font-medium">{{ $pet->weight ?? 'N/A' }}</span>
                                </div>
                                <div class="border-t pt-2 mt-2">
                                    <p class="text-gray-500 text-xs mb-1">Last Seen:</p>
                                    <p class="text-gray-700 font-medium text-xs">
                                        @if($pet->missingReport->first() && $pet->missingReport->first()->last_seen_at)
                                            {{ $pet->missingReport->first()->last_seen_at->format('M d, Y - h:i A') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs mb-1">Location:</p>
                                    <p class="text-gray-700 font-medium text-xs">
                                        @if($pet->missingReport->first())
                                            {{ $pet->missingReport->first()->barangay->barangay_name ?? 'N/A' }}
                                            @if($pet->missingReport->first()->location_description)
                                                - {{ $pet->missingReport->first()->location_description }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No missing pets found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1" id="pagination-nav">
                    <!-- Previous Page -->
                    @if ($missingPets->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <button onclick="loadPage({{ $missingPets->currentPage() - 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $missingPets->lastPage(); $i++)
                        @if ($i == $missingPets->currentPage())
                            <span class="px-4 py-2 text-white bg-primary font-medium rounded-lg">{{ $i }}</span>
                        @else
                            <button onclick="loadPage({{ $i }})" class="px-4 py-2 text-gray-600 bg-white hover:bg-primary hover:text-white rounded-lg transition-colors">{{ $i }}</button>
                        @endif
                    @endfor

                    <!-- Next Page -->
                    @if ($missingPets->hasMorePages())
                        <button onclick="loadPage({{ $missingPets->currentPage() + 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </section>

    <!-- Pet Detail Modal -->
    <div id="petModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50" onclick="closePetModal()"></div>
        <!-- Modal Content -->
        <div class="flex items-stretch justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl relative z-10 overflow-hidden flex flex-col md:flex-row">
                <button onclick="closePetModal()" class="absolute top-4 right-4 text-white hover:text-gray-200 z-20 bg-black/30 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <!-- Left Side - Image -->
                <div class="w-[370px] h-full bg-gradient-to-br from-amber-400/20 to-amber-500/30 relative overflow-hidden flex-shrink-0">
                    <img id="modalPetImage" src="" alt="" class="w-full h-full object-cover hidden">
                    <div id="modalPetImagePlaceholder" class="w-full h-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-amber-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <!-- Right Side - Details -->
                <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-2">
                        <h2 id="modalPetName" class="text-2xl md:text-3xl font-bold text-gray-900"></h2>
                        <span id="modalPetSpecies" class="text-base text-gray-500"></span>
                    </div>
                    <p id="modalPetBreed" class="text-lg text-primary font-semibold mb-4"></p>
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Age</span>
                            <span id="modalPetAge" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Gender</span>
                            <span id="modalPetGender" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Weight</span>
                            <span id="modalPetWeight" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Color</span>
                            <span id="modalPetColor" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Last Seen</span>
                            <span id="modalPetLocation" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Last Seen Date</span>
                            <span id="modalPetLastSeen" class="font-medium text-gray-900"></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Description</h3>
                        <p id="modalPetDescription" class="text-gray-600 text-sm"></p>
                    </div>
                    <a href="mailto:vetdasma@yahoo.com" target="_blank" class="w-full bg-primary text-white text-center px-6 py-3 rounded-xl font-semibold hover:bg-primary-light transition-colors mt-auto block flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contact CVO
                    </a>
                </div>
            </div>
        </div>
    </div>

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
                                    You need to be logged in to report a missing pet. Please login or register an account to continue.
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
        let missingPetsData = {!! json_encode($missingPets->map(function($pet) { 
            $report = $pet->missingReport->first(); 
            return [ 
                'pet_id' => $pet->pet_id, 
                'pet_name' => $pet->pet_name, 
                'species' => $pet->species, 
                'breed' => $pet->breed, 
                'gender' => $pet->gender, 
                'age' => $pet->age, 
                'weight' => $pet->weight, 
                'color' => $pet->color, 
                'description' => $pet->notes, 
                'location_barangay' => $report && $report->barangay ? $report->barangay->barangay_name : null, 
                'location_description' => $report ? $report->location_description : null, 
                'last_seen_at' => $report ? $report->last_seen_at : null, 
                'pet_image' => $pet->pet_image ? asset('storage/'.$pet->pet_image) : null,
                'pet_status' => $pet->pet_status,
            ]; 
        })) !!};
        let currentPage = {{ $missingPets->currentPage() }};
        let lastPage = {{ $missingPets->lastPage() }};
        let currentSpecies = 'all';
        let currentGender = 'all';
        let currentBreeds = [];
        let currentLocations = [];
        let currentModalPetId = null;

        // Check for filter parameters in URL on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const speciesParam = urlParams.get('species');
            const genderParam = urlParams.get('gender');
            const breedsParam = urlParams.get('breeds');
            const locationParam = urlParams.get('location');
            
            if (speciesParam && ['Dog', 'Cat'].includes(speciesParam)) {
                currentSpecies = speciesParam;
            }
            if (genderParam && ['Male', 'Female'].includes(genderParam)) {
                currentGender = genderParam;
            }
            if (breedsParam) {
                currentBreeds = breedsParam.split(',');
                document.querySelectorAll('.breed-checkbox').forEach(checkbox => {
                    checkbox.checked = currentBreeds.includes(checkbox.value);
                });
                updateBreedSelection();
            }
            if (locationParam) {
                currentLocations = locationParam.split(',');
                document.querySelectorAll('.location-checkbox').forEach(checkbox => {
                    checkbox.checked = currentLocations.includes(checkbox.value);
                });
                updateLocationSelection();
            }
            updateFilterButtons();
        });
        
        function updateFilterButtons() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const filterType = btn.dataset.filterType || 'filter';
                const filterValue = btn.dataset.filter;
                
                let isActive = false;
                
                if (filterType === 'filter') {
                    // "All Pets" is active only when no species filter is selected
                    isActive = filterValue === 'all' && currentSpecies === 'all';
                } else if (filterType === 'species') {
                    isActive = currentSpecies !== 'all' && currentSpecies === filterValue;
                } else if (filterType === 'gender') {
                    isActive = currentGender !== 'all' && currentGender === filterValue;
                }
                
                if (isActive) {
                    btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                    
                    if (filterValue === 'Male') {
                        btn.classList.add('bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400');
                    } else if (filterValue === 'Female') {
                        btn.classList.add('bg-pink-200', 'text-pink-900', 'ring-2', 'ring-pink-300');
                    } else {
                        btn.classList.add('bg-primary', 'text-white', 'ring-2', 'ring-green-400');
                    }
                } else {
                    btn.classList.remove('bg-primary', 'text-white', 'bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400', 'bg-pink-200', 'text-pink-900', 'ring-pink-300', 'ring-green-400');
                    btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                }
            });
            
            // Update current filter display
            const filterNames = {
                'all': 'All Pets',
                'Dog': 'Dogs',
                'Cat': 'Cats',
                'Male': 'Male',
                'Female': 'Female',
            };
            
            let activeFilters = [];
            if (currentSpecies !== 'all') activeFilters.push(filterNames[currentSpecies] || currentSpecies);
            if (currentGender !== 'all') activeFilters.push(filterNames[currentGender] || currentGender);
            if (currentBreeds.length > 0) {
                activeFilters.push(currentBreeds.length === 1 ? currentBreeds[0] : currentBreeds.length + ' breeds');
            }
            if (currentLocations.length > 0) {
                activeFilters.push(currentLocations.length === 1 ? currentLocations[0] : currentLocations.length + ' locations');
            }
            
            const displayEl = document.getElementById('currentFilterDisplay');
            if (displayEl) {
                displayEl.textContent = activeFilters.length > 0 ? activeFilters.join(', ') : 'All Pets';
            }
        }
        
        function toggleFilterPanel() {
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            
            if (!panel || !overlay) return;
            
            if (panel.classList.contains('translate-x-full')) {
                panel.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                panel.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = 'auto';
            }
        }
        
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breed-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function toggleLocationDropdown() {
            const dropdown = document.getElementById('location-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function updateBreedSelection() {
            const checkboxes = document.querySelectorAll('.breed-checkbox:checked');
            currentBreeds = Array.from(checkboxes).map(cb => cb.value);
            const display = document.getElementById('selected-breeds-display');
            display.textContent = currentBreeds.length > 0 ? currentBreeds.join(', ') : 'Select breeds';
        }
        
        function updateLocationSelection() {
            const checkboxes = document.querySelectorAll('.location-checkbox:checked');
            currentLocations = Array.from(checkboxes).map(cb => cb.value);
            const display = document.getElementById('selected-locations-display');
            display.textContent = currentLocations.length > 0 ? currentLocations.join(', ') : 'Select location';
        }
        
        function filterPets(filterType, filterValue) {
            if (filterType === 'filter') {
                // Reset species filter when clicking "All Pets"
                if (filterValue === 'all') {
                    currentSpecies = 'all';
                }
            } else if (filterType === 'species') {
                if (currentSpecies !== 'all' && currentSpecies === filterValue) {
                    currentSpecies = 'all';
                } else {
                    currentSpecies = filterValue;
                }
            } else if (filterType === 'gender') {
                if (currentGender !== 'all' && currentGender === filterValue) {
                    currentGender = 'all';
                } else {
                    currentGender = filterValue;
                }
            }
            updateFilterButtons();
        }
        
        function clearFilters() {
            currentSpecies = 'all';
            currentGender = 'all';
            currentBreeds = [];
            currentLocations = [];
            
            document.querySelectorAll('.breed-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.location-checkbox').forEach(cb => cb.checked = false);
            
            document.getElementById('selected-breeds-display').textContent = 'Select breeds';
            document.getElementById('selected-locations-display').textContent = 'Select location';
            
            updateFilterButtons();
            window.location.href = '/missing-pets?page=1';
        }
        
        function applyFilters() {
            loadPage(1);
            
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            panel.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }
        
        function loadPage(page, species = null, gender = null, breeds = null, locations = null) {
            const speciesParam = species || currentSpecies;
            const genderParam = gender || currentGender;
            const breedsParam = breeds || (currentBreeds.length > 0 ? currentBreeds.join(',') : '');
            const locationsParam = locations || (currentLocations.length > 0 ? currentLocations.join(',') : '');
            
            let url = '/missing-pets/paginate?page=' + page;
            
            if (speciesParam && speciesParam !== 'all') {
                url += '&species=' + speciesParam;
            }
            if (genderParam && genderParam !== 'all') {
                url += '&gender=' + genderParam;
            }
            if (breedsParam) {
                url += '&breeds=' + breedsParam;
            }
            if (locationsParam) {
                url += '&location=' + locationsParam;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    missingPetsData = data.pets;
                    currentPage = data.currentPage;
                    lastPage = data.lastPage;
                    
                    document.getElementById('pet-count').textContent = data.total;
                    
                    renderPets(data.pets);
                    renderPagination();
                    
                    document.getElementById('pets-section').scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    alert('Error loading pets. Please try again.');
                });
        }
        
        function renderPets(pets) {
            const grid = document.getElementById('pets-grid');
            let html = '';
            
            if (pets.length === 0) {
                html = `
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No missing pets found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</p>
                </div>`;
            } else {
                 pets.forEach(pet => {
                      html += `
                      <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-red-100 card-hover missing-pet-card" onclick="showPetModal(${pet.pet_id})">
                          <div class="aspect-square bg-gray-200 relative overflow-hidden">
                                <img src="${pet.pet_image ? pet.pet_image : 'https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image'}" alt="${pet.pet_name}" class="w-full h-full object-cover pet-image">
                          </div>
                          <div class="p-4">
                               <h3 class="text-lg font-bold text-gray-900 mb-2">${pet.pet_name}</h3>
                               <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${pet.species}</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${pet.gender === 'Male' ? 'bg-purple-100 text-purple-800' : 'bg-pink-100 text-pink-800'}">${pet.gender === 'Male' ? '♂ Male' : '♀ Female'}</span>
                               </div>
                              <div class="space-y-2 text-sm">
                                  <div class="flex justify-between">
                                      <span class="text-gray-500">Age:</span>
                                      <span class="text-gray-700 font-medium">${pet.age || 'N/A'} years</span>
                                  </div>
                                  <div class="flex justify-between">
                                      <span class="text-gray-500">Weight:</span>
                                      <span class="text-gray-700 font-medium">${pet.weight || 'N/A'}</span>
                                  </div>
                                  <div class="border-t pt-2 mt-2">
                                      <p class="text-gray-500 text-xs mb-1">Last Seen:</p>
                                      <p class="text-gray-700 font-medium text-xs">${pet.last_seen_at ? (() => { const d = new Date(pet.last_seen_at); const datePart = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); const timePart = d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }); return datePart + ' - ' + timePart; })() : 'N/A'}</p>
                                  </div>
                                  <div>
                                      <p class="text-gray-500 text-xs mb-1">Location:</p>
                                      <p class="text-gray-700 font-medium text-xs">${pet.location_barangay ? (pet.location_barangay + (pet.location_description ? ' - ' + pet.location_description : '')) : 'N/A'}</p>
                                  </div>
                              </div>
                          </div>
                      </div>`;
                });
            }
            
            grid.innerHTML = html;
        }
        
        function renderPagination() {
            const nav = document.getElementById('pagination-nav');
            let html = '';
            
            // Previous button
            if (currentPage === 1) {
                html += `<span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>`;
            } else {
                html += `<button onclick="loadPage(${currentPage - 1})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= lastPage; i++) {
                if (i === currentPage) {
                    html += `<span class="px-4 py-2 text-white bg-primary font-medium rounded-lg">${i}</span>`;
                } else {
                    html += `<button onclick="loadPage(${i})" class="px-4 py-2 text-gray-600 bg-white hover:bg-primary hover:text-white rounded-lg transition-colors">${i}</button>`;
                }
            }
            
            // Next button
            if (currentPage === lastPage) {
                html += `<span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>`;
            } else {
                html += `<button onclick="loadPage(${currentPage + 1})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>`;
            }
            
            nav.innerHTML = html;
        }
        
        function showPetModal(petId) {
            const pet = missingPetsData.find(p => p.pet_id === petId);
            if (!pet) return;
            
            currentModalPetId = petId;
            
            document.getElementById('modalPetName').textContent = pet.pet_name;
            document.getElementById('modalPetSpecies').textContent = pet.species;
            document.getElementById('modalPetBreed').textContent = pet.breed || 'Breed not available';
            document.getElementById('modalPetAge').textContent = pet.age || 'Age not available';
            document.getElementById('modalPetGender').textContent = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : 'Not available';
             document.getElementById('modalPetWeight').textContent = pet.weight || 'Weight not available';
            document.getElementById('modalPetColor').textContent = pet.color || 'Color not available';
            document.getElementById('modalPetLocation').textContent = pet.location_barangay ? (pet.location_barangay + (pet.location_description ? ' - ' + pet.location_description : '')) : 'Location not available';
            document.getElementById('modalPetLastSeen').textContent = pet.last_seen_at ? new Date(pet.last_seen_at).toLocaleDateString() : 'Date not available';
            document.getElementById('modalPetDescription').textContent = pet.description || 'No description available';
            
            const img = document.getElementById('modalPetImage');
            const placeholder = document.getElementById('modalPetImagePlaceholder');
            
            if (pet.pet_image) {
                img.src = pet.pet_image;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
            
            document.getElementById('petModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closePetModal() {
            document.getElementById('petModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentModalPetId = null;
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const breedDropdown = document.getElementById('breed-dropdown');
            const breedButton = event.target.closest('#breed-dropdown-button');
            if (!breedButton && breedDropdown && !breedDropdown.contains(event.target)) {
                breedDropdown.classList.add('hidden');
            }
            
            const locationDropdown = document.getElementById('location-dropdown');
            const locationButton = event.target.closest('#location-dropdown-button');
            if (!locationButton && locationDropdown && !locationDropdown.contains(event.target)) {
                locationDropdown.classList.add('hidden');
            }
        });
    </script>

    @include('Client.partials.footer')

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function showLoginPrompt() {
            const modal = document.getElementById('loginPromptModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeLoginPrompt() {
            const modal = document.getElementById('loginPromptModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
