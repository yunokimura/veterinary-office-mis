<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dasmariñas City Veterinary Services</title>
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
        .hero-bg {
            background: linear-gradient(135deg, #066D33 0%, #07A13F 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Success Modal -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Success!</h3>
                    <p class="text-gray-600 mb-6">{{ session('success') }}</p>
                    <button onclick="closeSuccessModal()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
        <script>
            function closeSuccessModal() {
                document.getElementById('successModal').classList.add('hidden');
            }
        </script>
    @endif

    <!-- Flash Message Alert -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="successAlert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('successAlert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="errorAlert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('errorAlert').style.display = 'none';
            }, 5000);
        </script>
    @endif

     @include('Client.partials.emergency_alert')

    @include('Client.partials.navbar')

    <!-- Welcome Banner -->
    <section class="hero-bg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->first_name }}!</h1>
                <p class="text-lg text-gray-200">You're now logged in to your pet owner dashboard</p>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Register New Pet -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base">Register New Pet</h4>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Register your pet with the city</p>
                    </div>
                    <a href="{{ url('/pet-registration/form') }}" class="w-full bg-primary text-white text-center text-xs font-bold py-2.5 rounded-lg hover:bg-primary-light transition-colors">
                        Register Now
                    </a>
                </div>

                <!-- Appointments -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base">Appointments</h4>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Manage your anti-rabies vaccination or spay/neuter appointments</p>
                    </div>
                    <button class="w-full bg-secondary text-white text-center text-xs font-bold py-2.5 rounded-lg hover:bg-secondary-light transition-colors">
                        Schedule Now
                    </button>
                </div>

                <!-- View My Pets -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base">My Pets</h4>
                        <p class="text-xs text-gray-500 mt-1 mb-4">View and manage your registered pets</p>
                    </div>
                    <a href="{{ route('owner.pets') }}" class="w-full bg-primary text-white text-center text-xs font-bold py-2.5 rounded-lg hover:bg-primary-light transition-colors">
                        View Pets
                    </a>
                </div>

                <!-- Report Lost / Found -->
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 13l4 4m0 0l-4 4m4-4H15" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base">Report Lost / Found</h4>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Alert the City Veterinarian Office and local community if a pet is missing or found.</p>
                    </div>
                    <a href="{{ url('/lost-found/create') }}" class="w-full bg-red-600 text-white text-center text-xs font-bold py-2.5 rounded-lg hover:bg-red-700 transition-colors">
                        Create Notice
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- My Pets Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        My Pets
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Manage pet records, health histories, and vaccination tags</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="petSearch" placeholder="Filter pets..." class="pl-9 pr-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-36 sm:w-48">
                    </div>
                    <a href="{{ url('/pet-registration/form') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary bg-green-50 hover:bg-green-100 px-3.5 py-2 rounded-xl transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add New Pet</span>
                    </a>
                </div>
            </div>

            @php
                $pets = \App\Models\Pet::where('owner_id', auth()->user()->petOwner->owner_id ?? 0)->get();
            @endphp
            
            @if($pets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5" id="petGrid">
                    @php
                        $vaccinationReports = \App\Models\VaccinationReport::whereIn('pet_id', $pets->pluck('pet_id'))->get()->keyBy('pet_id');
                    @endphp
                    @foreach($pets as $pet)
                        @php
                            $imagePath = $pet->pet_image;
                            if ($pet->pet_image && !str_contains($imagePath, 'images/pets')) {
                                $imagePath = 'images/pets/' . basename($imagePath);
                            }
                        @endphp
                        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition overflow-hidden group flex flex-col justify-between" data-name="{{ strtolower($pet->pet_name) }} {{ strtolower($pet->species) }} {{ strtolower($pet->breed) }}">
                            <div class="p-5 pb-4 border-b border-gray-100 flex items-start gap-3.5">
                                <div class="relative">
                                    @if($pet->pet_image && file_exists(public_path($imagePath)))
                                        <img src="{{ asset($imagePath) }}" alt="{{ $pet->pet_name }}" class="w-14 h-14 rounded-2xl object-cover ring-2 ring-green-100 group-hover:ring-primary transition-all">
                                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-primary border-2 border-white rounded-full" title="Vaccinated"></span>
                                    @else
                                        <div class="w-14 h-14 rounded-2xl bg-primary text-white font-extrabold text-xl flex items-center justify-center ring-2 ring-green-100 group-hover:ring-primary transition-all">
                                            {{ substr($pet->pet_name, 0, 1) }}
                                        </div>
                                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-primary border-2 border-white rounded-full" title="Vaccinated"></span>
                                    @endif
                                </div>
    <div class="flex flex-col items-center gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <h4 class="font-bold text-gray-900 text-base">{{ $pet->pet_name }}</h4>
                                        <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">{{ ucfirst($pet->species) }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 font-medium">{{ $pet->breed }}</p>
                                        <p class="text-[11px] text-primary font-semibold mt-1 flex items-center gap-1">
ID: PET-{{ str_pad($pet->pet_id, 4, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>

                            <div class="p-5 grid grid-cols-2 gap-3 text-xs">
                                <div class="bg-gray-50 p-2.5 rounded-xl">
                                    <span class="text-gray-400 block text-[10px] font-semibold uppercase">Gender</span>
                                    <span class="font-semibold text-gray-700 flex items-center gap-1 mt-0.5">
                                        @if($pet->gender === 'male')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" class="text-blue-500 shrink-0">
                                                <path d="M0 0h16v16H0z" fill="none" />
                                                <path fill="#1e2099" fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8a4 4 0 0 0 0-8" />
                                            </svg>
                                        @elseif($pet->gender === 'female')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" class="text-pink-500 shrink-0">
                                                <path d="M0 0h16v16H0z" fill="none" />
                                                <path fill="#d42ec9" fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8a4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5" />
                                            </svg>
                                        @endif
                                        {{ ucfirst($pet->gender) }}
                                    </span>
                                </div>
                                <div class="bg-gray-50 p-2.5 rounded-xl">
                                    <span class="text-gray-400 block text-[10px] font-semibold uppercase">Age</span>
@php
    $ageDisplay = 'Unknown';
    if ($pet->birthdate) {
        $birthDate = strtotime($pet->birthdate);
        $today = time();
        $diffInMonths = floor(($today - $birthDate) / 86400 / 30.44);
        
        $years = floor($diffInMonths / 12);
        $months = $diffInMonths % 12;
        
        // If months are minimal (1-2 months), just display years for cleaner display
        if ($months <= 2 && $years > 0) {
            $yearStr = $years === 1 ? '1 yr' : $years . ' yrs';
            $ageDisplay = $yearStr;
        } else {
            $yearStr = $years === 1 ? '1 yr' : $years . ' yrs';
            $monthStr = $months === 1 ? '1 mos' : $months . ' mos';
            
            if ($years > 0 && $months > 0) {
                $ageDisplay = "$yearStr $monthStr";
            } elseif ($years > 0) {
                $ageDisplay = $yearStr;
            } else {
                $ageDisplay = $monthStr;
            }
        }
    } elseif ($pet->petInfo?->pet_age) {
        // Only display pet_age as-is if it's already in the new "X yrs X mos" format
        if (preg_match('/\d+\s+yrs\s+\d+\s+mos/', $pet->petInfo->pet_age) ||
            preg_match('/\d+\s+yr\s+\d+\s+mos/', $pet->petInfo->pet_age)) {
            $ageDisplay = $pet->petInfo->pet_age;
        }
    }
@endphp
                                    <span class="font-semibold text-gray-700 mt-0.5 block">{{ $ageDisplay }}</span>
                                </div>
                                <div class="bg-gray-50 p-2.5 rounded-xl">
                                    <span class="text-gray-400 block text-[10px] font-semibold uppercase">{{ $pet->gender === 'female' ? 'Spayed' : 'Neutered' }}</span>
                                    <span class="font-semibold {{ (($pet->petInfo?->is_neutered ?? '') === 'yes') ? 'text-primary' : 'text-amber-600' }} mt-0.5 block">{{ ($pet->petInfo?->is_neutered ?? '') === 'yes' ? 'Yes' : 'No' }}</span>
                                </div>
                                <div class="bg-gray-50 p-2.5 rounded-xl">
                                    <span class="text-gray-400 block text-[10px] font-semibold uppercase">Weight</span>
                                    @if($pet->petInfo?->pet_weight)
                                        <span class="font-semibold text-gray-700 mt-0.5 block">{{ $pet->petInfo->pet_weight }}</span>
                                    @else
                                        <span class="font-semibold text-gray-700 mt-0.5 block">-</span>
                                    @endif
                                </div>
@php
    $report = $vaccinationReports->get($pet->pet_id);
    $hasReport = $report !== null;
    $isVaccinated = $hasReport && !$report->not_vaccinated && $report->status === 'completed';
    $nextVaccinationDate = $report->next_vaccination_date ?? null;
    $needsBooster = $isVaccinated && $nextVaccinationDate !== null && $nextVaccinationDate->isPast();

    if ($needsBooster || !$isVaccinated) {
        $vaxColor = 'bg-red-50 border border-red-200';
        $vaxIconBg = 'bg-red-100';
        $vaxIconColor = 'text-red-500';
        $vaxTextColor = 'text-red-700';
        $vaxSubColor = 'text-red-600';
        $vaxHeading = 'Not Vaccinated / No Record';
        $vaxSub = 'Anti-rabies vaccination needed';
    } else {
        $vaxColor = 'bg-green-50 border border-green-200';
        $vaxIconBg = 'bg-green-100';
        $vaxIconColor = 'text-green-600';
        $vaxTextColor = 'text-green-700';
        $vaxSubColor = 'text-green-600';
        $vaxHeading = 'Vaccinated Active';
        $vaxSub = 'Lot #' . ($report->vaccine_batch_number ?? 'N/A');
    }
@endphp
<div class="col-span-2 flex flex-col gap-2 ml-3 px-3 py-2 rounded-full {{ $vaxIconBg }} inline-flex">
    <div class="flex items-center gap-2.5">
        <div class="w-5 h-5 rounded-full {{ $vaxIconColor }} flex items-center justify-center shrink-0">
            @if($isVaccinated && !$needsBooster)
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path fill-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1m4.768 9.14a1 1 0 1 0-1.536-1.28l-4.3 5.159l-2.225-2.226a1 1 0 0 0-1.414 1.414l3 3a1 1 0 0 0 1.475-.067z" clip-rule="evenodd" />
                </svg>
            @else
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h64v64H0z" fill="none" />
                    <path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30s30-13.432 30-30S48.568 2 32 2m5 49.75H27v-24h10zm-5-29.5a5 5 0 1 1 0-10a5 5 0 0 1 0 10" />
                </svg>
            @endif
        </div>
        <div class="flex flex-col gap-1">
            <div class="text-xs font-bold {{ $vaxTextColor }} leading-none whitespace-nowrap truncate">{{ $vaxHeading }}</div>
            <div class="text-xs {{ $vaxSubColor }} leading-none whitespace-nowrap truncate">{{ $vaxSub }}</div>
        </div>
    </div>
</div>
                            </div>

                            <div class="p-4 bg-gray-50/80 border-t border-gray-100 flex items-center gap-2">
                                <button class="flex-1 py-2 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 text-gray-700 hover:text-primary text-xs font-semibold rounded-xl transition text-center shadow-xs">
                                    View Profile
                                </button>
                                <button class="p-2 text-gray-500 hover:text-primary hover:bg-white rounded-xl border border-transparent hover:border-gray-200 transition" title="Download Vaccine Passport">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No pets registered yet</p>
                    <a href="{{ url('/pet-registration/form') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Register Your First Pet
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- My Appointments Section -->
    @php
        $vaccinationAppointments = \App\Models\VaccinationAppointment::where('user_id', auth()->id())
            ->with('pet')
            ->orderByDesc('scheduled_at')
            ->get();
        $spayNeuterAppointments = \App\Models\SpayNeuterAppointment::where('user_id', auth()->id())
            ->with('pet')
            ->orderByDesc('scheduled_at')
            ->get();

        $appointments = collect();
        foreach ($vaccinationAppointments as $a) {
            $appointments->push((object) [
                'id' => $a->id,
                'type' => 'vaccination',
                'pet_name' => optional($a->pet)->pet_name ?? 'N/A',
                'pet_breed' => optional($a->pet)->breed ?? '',
                'scheduled_at' => $a->scheduled_at,
                'status' => $a->status,
                'vet' => $a->assignedVet?->user?->name ?? $a->clinic_name ?? 'N/A',
            ]);
        }
        foreach ($spayNeuterAppointments as $a) {
            $appointments->push((object) [
                'id' => $a->id,
                'type' => 'spay_neuter',
                'pet_name' => optional($a->pet)->pet_name ?? 'N/A',
                'pet_breed' => optional($a->pet)->breed ?? '',
                'scheduled_at' => $a->scheduled_at,
                'status' => $a->status,
                'vet' => $a->assignedVet?->user?->name ?? $a->veterinarian ?? 'N/A',
            ]);
        }
        $appointments = $appointments->sortByDesc(function ($item) {
            return $item->scheduled_at ? $item->scheduled_at : \Carbon\Carbon::parse('1970-01-01');
        })->values();
    @endphp

    <!-- My Appointments Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        My Appointments
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Track and manage your scheduled vaccination, spay/neuter, and adoption appointments</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500">Type:</span>
                    <select class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>All Types</option>
                        <option>Vaccination</option>
                        <option>Spay & Neuter</option>
                    </select>
                </div>
            </div>

            @if($appointments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($appointments as $appointment)
                        @php
                            $typeLabel = $appointment->type === 'vaccination' ? 'Vaccination' : 'Spay & Neuter';
                            $typeColor = $appointment->type === 'vaccination' ? 'green' : ($appointment->type === 'spay_neuter' ? 'primary' : 'blue');
                            $statusLabel = ucfirst(str_replace('_', ' ', $appointment->status));
                            if (in_array($appointment->status, ['pending', 'pending_review'])) {
                                $statusColor = 'bg-amber-50 text-amber-700 border border-amber-200';
                            } elseif (in_array($appointment->status, ['approved', 'completed'])) {
                                $statusColor = 'bg-green-50 text-green-700 border border-green-200';
                            } elseif (in_array($appointment->status, ['rejected', 'cancelled'])) {
                                $statusColor = 'bg-red-50 text-red-700 border border-red-200';
                            } else {
                                $statusColor = 'bg-gray-50 text-gray-700 border border-gray-200';
                            }
                            $scheduled = $appointment->scheduled_at ? \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y \a\t h:i A') : 'TBA';
                            $typeChipClass = $appointment->type === 'vaccination' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-primary/10 text-primary border border-gray-200';
                            $accentClass = $appointment->type === 'vaccination' ? 'bg-green-500' : 'bg-primary';
                            $buttonClass = $appointment->type === 'vaccination' ? 'bg-green-500 hover:bg-green-600' : 'bg-primary hover:bg-primary-dark';
                        @endphp
                        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-2 h-full {{ $accentClass }}"></div>
                            <div class="p-5">
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="text-xs font-extrabold text-gray-900 tracking-wide uppercase">App #{{ $loop->iteration }}</span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full {{ $statusColor }} text-[11px] font-bold">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full {{ $typeChipClass }} text-[11px] font-bold">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    @if($appointment->type === 'vaccination')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    @endif
                                        </svg>
                                        {{ $typeLabel }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 font-medium mb-3 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $appointment->pet_name }}
                                    @if($appointment->pet_breed)
                                        <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded ml-1">{{ ucfirst($appointment->pet_breed) }}</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 font-medium mb-3 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $scheduled }}
                                </p>
                                <p class="text-xs text-gray-400 font-medium mb-4 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20a7.1 7.1 0 00-.612-.036M12.5 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $appointment->vet }}
                                </p>
                            </div>
                            <div class="p-4 bg-gray-50 border-t border-gray-100">
                                <a href="{{ url('/vaccination/form') }}" class="w-full py-2 {{ $buttonClass }} text-white text-center text-xs font-bold rounded-xl transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No appointments yet</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ url('/vaccination/form') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                            Schedule Vaccination
                        </a>
                        <a href="{{ url('/adoption') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                            Apply for Adoption
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- My Adoption Applications Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 002 2m0 0l2 2m-2-2v12m-6-6l2 2" />
                        </svg>
                        My Adoption Applications
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Track and manage your submitted city pet adoption requests</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500">Status:</span>
                    <select class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>All Statuses</option>
                        <option selected>Pending Review</option>
                        <option>Approved</option>
                        <option>Completed</option>
                    </select>
                </div>
            </div>

            @php
                $applications = \App\Models\AdoptionApplication::where('user_id', auth()->id())
                    ->orderByDesc('created_at')
                    ->get();
            @endphp
            
            @if($applications->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($applications as $application)
                        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-2 h-full bg-amber-400"></div>
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="text-xs font-extrabold text-gray-900 tracking-wide uppercase">App #{{ $application->id }}</span>
                                    @if($application->status === 'pending_review')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending Review
                                        </span>
                                    @elseif($application->status === 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Rejected
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-400 font-medium mb-4 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Submitted {{ $application->created_at->format('M d, Y') }}
                                </p>

                                <div class="space-y-2 text-xs border-t border-gray-100 pt-3 mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Target Pet:</span>
                                        <span class="font-bold text-gray-800">{{ $application->pet->pet_name ?? 'Unspecified (General)' }}</span>
                                    </div>
                                    @if($application->appointment_date)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Interview Date:</span>
                                            <span class="font-semibold text-primary">{{ $application->appointment_date->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                                <a href="{{ route('adoption.form.edit', $application) }}" class="flex-1 py-2 px-3 bg-primary hover:bg-primary-dark text-white font-semibold text-xs rounded-xl transition shadow-xs flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <g fill="none">
                                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.34 22.19h19.32" />
                                        <rect width="5.17" height="6.08" fill="#fff" opacity="0.2" rx="1" transform="rotate(135 7.642 8.558)scale(-1 1)" />
                                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.11 9.07l-4.16-4.16M6.27 21.24c.47-.14.71-.2.92-.33s.39-.3.74-.65L20.98 7.41a5 5 0 0 0 1.19-1.4a2 2 0 0 0 0-1.5A5 5 0 0 0 21 3.12a5 5 0 0 0-1.4-1.18a2 2 0 0 0-1.48 0c-.38.15-.72.49-1.4 1.17l-13 12.94c-.34.35-.52.53-.65.74c-.12.21-.2.45-.34.92l-.46 1.5c-.48 1.58-.73 2.37-.3 2.8c.42.42 1.2.18 2.79-.3z" />
                                    </g>
                                </svg>
                                    Edit Application
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No adoption applications yet</p>
                    <a href="{{ url('/adoption') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Browse Pets for Adoption
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('Client.partials.footer')
</body>
</html>
