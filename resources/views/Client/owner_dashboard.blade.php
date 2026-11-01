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
    <script src="https://unpkg.com/lucide@latest"></script>
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
                        },
                        dasma: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
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
    <!-- Flash Message Alert -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-[9999] bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="successAlert">
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
        <div class="fixed top-4 right-4 z-[9999] bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="errorAlert">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Quick Actions</h2>
                <p class="text-sm text-gray-500 mt-1">Frequently used services and quick requests for your pets.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Action 1: Register New Pet -->
                <div class="group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">


                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center mb-4 shadow-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">Register New Pet</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Register your pet officially with the city for tracking and digital ID generation.</p>
                    </div>

                    <div class="relative z-10 mt-6 pt-4 border-t border-gray-50">
                        <a href="{{ url('/pet-registration/form') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-emerald-200 active:scale-95">
                            <span>Register Now</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Action 2: Appointments -->
                <div class="group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">


                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-teal-100 text-teal-700 rounded-xl flex items-center justify-center mb-4 shadow-sm group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-teal-700 transition-colors">Appointments</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Manage anti-rabies vaccination or spay/neuter clinic appointments.</p>
                    </div>

                    <div class="relative z-10 mt-6 pt-4 border-t border-gray-50">
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-teal-200 active:scale-95">
                            <span>Schedule Now</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Action 3: My Pets -->
                <div class="group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">


                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center mb-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">My Pets</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">View profiles, medical histories, and digital vaccination status tags.</p>
                    </div>

                    <div class="relative z-10 mt-6 pt-4 border-t border-gray-50">
                        <a href="{{ route('owner.pets') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-blue-200 active:scale-95">
                            <span>View Pets</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Action 4: Report Lost / Found -->
                <div class="group relative bg-white rounded-2xl p-6 border border-rose-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">


                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center mb-4 shadow-sm group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-rose-700 transition-colors">Report Lost / Found</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Alert the City Veterinarian Office and local community if a pet is missing.</p>
                    </div>

                    <div class="relative z-10 mt-6 pt-4 border-t border-rose-50">
                        <a href="{{ url('/lost-found/create') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-rose-200 active:scale-95">
                            <span>Create Notice</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- My Registered Pets Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
                <div>
                    <div class="flex items-center space-x-2">
                        <i data-lucide="paw-print" class="w-6 h-6 text-dasma-700"></i>
                        <h2 class="text-xl font-bold text-slate-900">My Registered Pets</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500">Manage health records, vaccination tags, and profiles.</p>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="relative flex-grow sm:w-64">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="petSearch" onkeyup="filterPets()" placeholder="Filter pets by name or ID..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-dasma-500 focus:border-transparent transition-all">
                    </div>
                    <a href="{{ url('/pet-registration/form') }}" class="bg-dasma-700 text-white hover:bg-dasma-800 text-xs sm:text-sm font-semibold px-3.5 py-2 rounded-xl transition-all flex items-center space-x-1.5 shrink-0 shadow-sm">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Add Pet</span>
                    </a>
                </div>
            </div>

            @php
                $pets = \App\Models\Pet::with(['petInfo', 'vaccinationReports', 'traits', 'owner'])->where('owner_id', auth()->user()->petOwner->owner_id ?? 0)->get();
            @endphp
            
            @if($pets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6" id="petsGrid">
                    @foreach($pets as $pet)
                        @php
                            $imagePath = $pet->pet_image;
                            if ($pet->pet_image && !str_contains($imagePath, 'images/pets')) {
                                $imagePath = 'images/pets/' . basename($imagePath);
                            }
                            $hoverBorderClass = $pet->gender === 'female' ? 'hover:border-pink-500' : 'hover:border-blue-500';
                        @endphp
                                <div class="pet-card bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all {{ $hoverBorderClass }} overflow-hidden flex flex-col justify-between" data-name="{{ strtolower($pet->pet_name) }}" data-species="{{ strtolower($pet->species) }}">
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center space-x-3">
                                        @if($pet->pet_image && file_exists(public_path($imagePath)))
                                            <img src="{{ asset($imagePath) }}" alt="{{ $pet->pet_name }}" class="w-14 h-14 rounded-xl object-cover ring-2 ring-slate-100">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-dasma-800 text-white font-bold flex items-center justify-center text-xl shadow-inner">
                                                {{ substr($pet->pet_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="flex items-center space-x-1.5">
                                                <h3 class="font-bold text-slate-900 text-lg">{{ $pet->pet_name }}</h3>
                                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">{{ ucfirst($pet->species) }}</span>
                                            </div>
                                            <p class="text-xs text-slate-500 font-mono">{{ ucfirst($pet->breed) }} • <span class="text-slate-400">PET-{{ str_pad($pet->pet_id, 4, '0', STR_PAD_LEFT) }}</span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats Grid -->
                                @php
                                    $ageDisplay = 'Unknown';
                                    if ($pet->birthdate) {
                                        $birthDate = strtotime($pet->birthdate);
                                        $today = time();
                                        $diffInMonths = floor(($today - $birthDate) / 86400 / 30.44);
                                        $years = floor($diffInMonths / 12);
                                        $months = $diffInMonths % 12;
                                        if ($months <= 2 && $years > 0) {
                                            $ageDisplay = $years === 1 ? '1 yr' : $years . ' yrs';
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
                                        if (preg_match('/\d+\s+yrs\s+\d+\s+mos/', $pet->petInfo->pet_age) ||
                                            preg_match('/\d+\s+yr\s+\d+\s+mos/', $pet->petInfo->pet_age)) {
                                            $ageDisplay = $pet->petInfo->pet_age;
                                        }
                                    }
                                    $petInfoNeutered = (($pet->petInfo?->is_neutered ?? '') === 'yes');
                                    $hasCompletedKapon = \App\Models\SpayNeuterAppointment::where('pet_id', $pet->pet_id)
                                        ->where('status', 'completed')
                                        ->exists();
                                    $isNeutered = $petInfoNeutered || $hasCompletedKapon;
                                @endphp
                                <div class="grid grid-cols-2 gap-2 my-4 p-2.5 bg-slate-50 rounded-xl text-xs">
                                    <!-- Gender & Age | Weight -->
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Gender & Age</span>
                                        <span class="font-semibold text-slate-700">{{ ucfirst($pet->gender) }}, {{ $ageDisplay }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Weight</span>
                                        <span class="font-semibold text-slate-700">{{ $pet->petInfo?->pet_weight ?? '-' }}</span>
                                    </div>
                                    <!-- Spayed / Neuter -->
                                    <div class="col-span-2">
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">{{ $pet->gender === 'female' ? 'Spayed' : 'Neuter' }}</span>
                                        <span class="font-semibold text-slate-700">{{ $isNeutered ? 'Yes' : 'No' }}</span>
                                    </div>
                                </div>

                                <!-- Anti-Rabies Badge -->
                                @php
                                    $report = $pet->vaccinationReports->first();
                                    $hasReport = $report !== null;
                                    $isVaccinated = $hasReport && !$report->not_vaccinated && $report->status === 'completed';
                                    $nextVaccinationDate = $report->next_vaccination_date ?? null;
                                    $needsBooster = $isVaccinated && $nextVaccinationDate !== null && $nextVaccinationDate->isPast();
                                    if ($needsBooster || !$isVaccinated) {
                                        $vaxColor = 'bg-red-50 border border-red-200';
                                        $vaxIconColor = 'text-red-500';
                                        $vaxTextColor = 'text-red-700';
                                        $vaxSubColor = 'text-red-600';
                                        $vaxHeading = 'Not Vaccinated / No Record';
                                        $vaxSub = 'Anti-rabies vaccination needed';
                                    } else {
                                        $vaxColor = 'bg-green-50 border border-green-200';
                                        $vaxIconColor = 'text-green-600';
                                        $vaxTextColor = 'text-green-700';
                                        $vaxSubColor = 'text-green-600';
                                        $vaxHeading = 'Vaccinated Active';
                                        $vaxSub = 'Lot #' . ($report->vaccine_batch_number ?? 'N/A');
                                    }
                                @endphp
                                <div class="p-3 {{ $vaxColor }} rounded-xl flex items-start space-x-2.5">
                                    <i data-lucide="{{ $isVaccinated && !$needsBooster ? 'check-circle-2' : 'alert-circle' }}" class="w-5 h-5 {{ $vaxIconColor }} shrink-0 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs font-bold {{ $vaxTextColor }}">{{ $vaxHeading }}</p>
                                        <p class="text-[11px] {{ $vaxSubColor }} leading-tight mt-0.5">{{ $vaxSub }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                                <button class="text-xs font-bold text-dasma-700 hover:text-dasma-800 flex items-center space-x-1" onclick="showPetProfile({{ $pet->pet_id }})">
                                    <span>View Profile</span>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="text-[10px] text-slate-400">Updated {{ $pet->updated_at?->format('F Y') ?? date('F Y') }}</span>
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

    <!-- View Profile Modal -->
    <div id="petProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 sm:p-6">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full h-[85vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-slate-200 flex-shrink-0">
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="paw-print" class="w-5 h-5 text-dasma-700"></i>
                    Pet Profile
                </h3>
                <button onclick="closePetProfile()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Tab Navigation -->
            <div class="flex border-b border-slate-200 flex-shrink-0">
                <button onclick="switchPetTab('overview')" id="petTabOverview" class="px-6 py-4 text-sm font-semibold text-dasma-700 border-b-2 border-dasma-700">Overview</button>
                <button onclick="switchPetTab('health')" id="petTabHealth" class="px-6 py-4 text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-slate-700 hover:border-slate-200">Health & Vaccination</button>
                <button onclick="switchPetTab('spay')" id="petTabSpay" class="px-6 py-4 text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-slate-700 hover:border-slate-200">Spay / Neuter</button>
                <button onclick="switchPetTab('details')" id="petTabDetails" class="px-6 py-4 text-sm font-semibold text-slate-500 border-b-2 border-transparent hover:text-slate-700 hover:border-slate-200">Details & Traits</button>
            </div>

            <!-- Tab Panels -->
            <div class="p-6 flex-1 min-h-[45vh] overflow-y-auto">
                <!-- Overview -->
                <div id="petPanelOverview" class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="relative w-32 h-32 rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex-shrink-0">
                            <img id="petProfileImage" src="" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="petProfilePetId" class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">PET-0000</p>
                            <h2 id="petProfileName" class="text-2xl font-bold text-slate-900 leading-tight">Pet Name</h2>
                            <p class="flex items-center gap-2 text-slate-500 text-sm mt-1">
                                <span id="petProfileBreed" class="font-medium">Breed</span> • <span id="petProfileSpecies" class="font-medium">Species</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Gender</p>
                            <p id="petProfileGender" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Age</p>
                            <p id="petProfileAge" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Weight</p>
                            <p id="petProfileWeight" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Status</p>
                            <p id="petProfileStatus" class="font-semibold text-slate-700">-</p>
                        </div>
                    </div>
                </div>

                <!-- Health & Vaccination -->
                <div id="petPanelHealth" class="hidden space-y-4">
                    <div class="flex items-center gap-3">
                        <div>
                            <h3 id="petProfileVaxStatus" class="text-lg font-bold text-slate-900">Not Vaccinated / No Record</h3>
                            <p class="text-slate-500 text-sm mt-0.5">Anti-rabies vaccination status</p>
                        </div>
                        <div id="petProfileVaxBadge" class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Vaccine Brand</p>
                            <p id="petProfileVaxBrand" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Batch / Lot</p>
                            <p id="petProfileVaxBatch" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Vaccination Date</p>
                            <p id="petProfileVaxDate" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Next Due</p>
                            <p id="petProfileVaxNext" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Type</p>
                            <p id="petProfileVaxType" class="font-semibold text-slate-700">-</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4">
                        <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Notes</p>
                        <p id="petProfileVaxNotes" class="text-sm text-slate-700">-</p>
                    </div>
                </div>

                <!-- Spay / Neuter -->
                <div id="petPanelSpay" class="hidden space-y-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Spayed / Neutered</h3>
                            <p class="text-slate-500 text-sm mt-0.5">Sterilization status</p>
                        </div>
                        <span id="petProfileSpayBadge" class="px-3 py-1 rounded-full bg-red-50 text-red-700 font-semibold text-[11px]">Intact</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Status</p>
                            <p id="petProfileSpayStatus" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Procedure</p>
                            <p id="petProfileSpayProc" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Date</p>
                            <p id="petProfileSpayDate" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Veterinarian</p>
                            <p id="petProfileSpayVet" class="font-semibold text-slate-700">-</p>
                        </div>
                    </div>
                </div>

                <!-- Details & Traits -->
                <div id="petPanelDetails" class="hidden space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Eye Color</p>
                            <p id="petProfileEyeColor" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Crossbreed</p>
                            <p id="petProfileCrossbreed" class="font-semibold text-slate-700">-</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 col-span-2 sm:col-span-2">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Body Mark Details</p>
                            <p id="petProfileBodyMark" class="font-semibold text-slate-700">-</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileTrainingSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Training</p>
                            <div id="petProfileTraining" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileInsuranceSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Insurance</p>
                            <div id="petProfileInsurance" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileBehaviorSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Behavior</p>
                            <div id="petProfileBehavior" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileLikesSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Likes</p>
                            <div id="petProfileLikes" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileDislikesSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Dislikes</p>
                            <div id="petProfileDislikes" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileDietSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Diet</p>
                            <div id="petProfileDiet" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileAllergySection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Allergy</p>
                            <div id="petProfileAllergy" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3" id="petProfileTraitsSection">
                            <p class="text-slate-400 text-[10px] uppercase font-bold mb-2">Traits</p>
                            <div id="petProfileTraits" class="flex flex-wrap gap-1.5"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex gap-3 p-6 border-t border-slate-200 bg-slate-50 flex-shrink-0">
                <button onclick="closePetProfile()" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-gray-200 active:scale-95">Close</button>
                <a id="petProfileEditLink" href="#" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-dasma-600 hover:bg-dasma-700 text-white text-sm font-medium rounded-xl transition-all shadow-md shadow-dasma-600/20 active:scale-95">Edit Pet</a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const petsData = @json($pets);

        function filterPets() {
            const input = document.getElementById('petSearch').value.toLowerCase();
            const cards = document.querySelectorAll('.pet-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                const species = card.getAttribute('data-species').toLowerCase();
                if (name.includes(input) || species.includes(input)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // View Profile Modal
        function showPetProfile(petId) {
            const pet = petsData.find(p => p.pet_id === petId);
            if (!pet) return;

            const petInfo = pet.pet_info || {};
            const vaccinationReports = pet.vaccination_reports || [];
            const report = vaccinationReports.length > 0 ? vaccinationReports[0] : null;

            // Compute age from birthdate (matches old PHP logic)
            function computeAge(birthdateStr) {
                if (!birthdateStr) return '-';
                const birth = new Date(birthdateStr);
                const today = new Date();
                let years = today.getFullYear() - birth.getFullYear();
                const m = today.getMonth() - birth.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) years--;
                return years <= 0 ? '< 1 yr' : (years === 1 ? '1 yr' : years + ' yrs');
            }

            // Overview tab
            document.getElementById('petProfileName').textContent = pet.pet_name;
            document.getElementById('petProfileBreed').textContent = pet.breed || '-';
            document.getElementById('petProfileSpecies').textContent = pet.species || '-';
            document.getElementById('petProfileGender').textContent = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1) : '-';
            document.getElementById('petProfileAge').textContent = petInfo.pet_age || computeAge(pet.birthdate) || '-';
            document.getElementById('petProfileWeight').textContent = petInfo.pet_weight || '-';
            document.getElementById('petProfilePetId').textContent = 'PET-' + String(pet.pet_id).padStart(4, '0');
            document.getElementById('petProfileStatus').textContent = pet.pet_status ? pet.pet_status.charAt(0).toUpperCase() + pet.pet_status.slice(1) : '-';

            const modalImg = document.getElementById('petProfileImage');
            if (pet.pet_image) {
                let imgPath = pet.pet_image;
                if (!imgPath.startsWith('http') && !imgPath.includes('images/pets')) {
                    imgPath = 'images/pets/' + imgPath.split('/').pop();
                }
                modalImg.src = '{{ asset('') }}' + imgPath;
            } else {
                modalImg.src = '{{ asset('images/pet.png') }}';
            }

            // Health & Vaccination tab
            const vaxStatusEl = document.getElementById('petProfileVaxStatus');
            const vaxBadge = document.getElementById('petProfileVaxBadge');
            const vaxBrandEl = document.getElementById('petProfileVaxBrand');
            const vaxBatchEl = document.getElementById('petProfileVaxBatch');
            const vaxDateEl = document.getElementById('petProfileVaxDate');
            const vaxNextEl = document.getElementById('petProfileVaxNext');
            const vaxTypeEl = document.getElementById('petProfileVaxType');
            const vaxNotesEl = document.getElementById('petProfileVaxNotes');

            if (report && report.status === 'completed' && !report.not_vaccinated) {
                vaxStatusEl.textContent = 'Vaccinated Active';
                vaxBadge.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-50 text-green-700 font-semibold text-[11px] border border-green-200';
                vaxBadge.innerHTML = '<i data-lucide="check-circle-2" class="w-3 h-3"></i> Vaccinated Active';
            } else {
                vaxStatusEl.textContent = 'Not Vaccinated / No Record';
                vaxBadge.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-700 font-semibold text-[11px] border border-red-200';
                vaxBadge.innerHTML = '<i data-lucide="alert-circle" class="w-3 h-3"></i> Vaccination Needed';
            }
            vaxBrandEl.textContent = report ? (report.vaccine_brand || '-') : '-';
            vaxBatchEl.textContent = report ? ('Lot #' + (report.vaccine_batch_number || 'N/A')) : '-';
            vaxDateEl.textContent = report && report.vaccination_date ? new Date(report.vaccination_date).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) : '-';
            vaxNextEl.textContent = report && report.next_vaccination_date ? new Date(report.next_vaccination_date).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) : '-';
            vaxTypeEl.textContent = report ? (report.vaccination_type || '-') : '-';
            vaxNotesEl.textContent = report ? (report.notes || '-') : '-';

            // Spay / Neuter tab
            const spayStatusEl = document.getElementById('petProfileSpayStatus');
            const spayBadge = document.getElementById('petProfileSpayBadge');
            const spayProcEl = document.getElementById('petProfileSpayProc');
            const spayDateEl = document.getElementById('petProfileSpayDate');
            const spayVetEl = document.getElementById('petProfileSpayVet');

            const kaponReports = pet.spay_neuter_reports || [];
            const completedKapon = kaponReports.find(r => r.status === 'completed');
            const petInfoNeutered = (petInfo.is_neutered === 'yes');
            const isNeutered = petInfoNeutered || !!completedKapon;

            spayStatusEl.textContent = isNeutered ? 'Yes' : 'Intact';
            spayBadge.className = isNeutered ? 'px-2 py-1 rounded-full bg-green-50 text-green-700 font-semibold text-[11px]' : 'px-2 py-1 rounded-full bg-red-50 text-red-700 font-semibold text-[11px]';
            spayBadge.textContent = isNeutered ? 'Yes' : 'Intact';
            spayProcEl.textContent = completedKapon ? (completedKapon.procedure_type ? completedKapon.procedure_type.charAt(0).toUpperCase() + completedKapon.procedure_type.slice(1) : '-') : '-';
            spayDateEl.textContent = completedKapon && completedKapon.scheduled_at ? new Date(completedKapon.scheduled_at).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) : '-';
            spayVetEl.textContent = completedKapon ? (completedKapon.veterinarian || '-') : '-';

            // Details & Traits tab
            document.getElementById('petProfileEyeColor').textContent = petInfo.eye_color || '-';            document.getElementById('petProfileCrossbreed').textContent = petInfo.is_crossbreed === 'yes' ? 'Yes' : 'No';
            document.getElementById('petProfileBodyMark').textContent = pet.body_mark_details || '-';

            // Array chips
            const renderChips = (containerId, items, colorClass) => {
                const container = document.getElementById(containerId);
                const section = container.parentElement;
                if (items && items.length > 0) {
                    const chips = items.map(i => '<span class="' + colorClass + ' px-2.5 py-1 rounded-full text-xs">' + i + '</span>').join('');
                    container.innerHTML = chips;
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            };

            const parseArray = (val) => {
                if (!val) return null;
                if (typeof val === 'string') {
                    try { return JSON.parse(val); } catch (e) { return null; }
                }
                return Array.isArray(val) ? val : null;
            };

            renderChips('petProfileTraining', parseArray(petInfo.training), 'bg-blue-100 text-blue-800 border border-blue-200');
            renderChips('petProfileInsurance', parseArray(petInfo.insurance), 'bg-purple-100 text-purple-800 border border-purple-200');
            renderChips('petProfileBehavior', parseArray(petInfo.behavior), 'bg-yellow-100 text-yellow-800 border border-yellow-200');
            renderChips('petProfileLikes', parseArray(petInfo.likes), 'bg-green-100 text-green-800 border border-green-200');
            renderChips('petProfileDislikes', parseArray(petInfo.dislikes), 'bg-red-100 text-red-800 border border-red-200');
            renderChips('petProfileDiet', parseArray(petInfo.diet), 'bg-orange-100 text-orange-800 border border-orange-200');
            renderChips('petProfileAllergy', parseArray(petInfo.allergy), 'bg-pink-100 text-pink-800 border border-pink-200');

            // Traits from pet_traits table
            renderChips('petProfileTraits', pet.traits ? pet.traits.map(t => t.name) : [], 'bg-indigo-100 text-indigo-800 border border-indigo-200');

            // Edit link
            document.getElementById('petProfileEditLink').href = '/owner/pets/' + pet.pet_id + '/edit';

            // Reset to Overview tab on every open
            switchPetTab('overview');

            // Show modal
            document.getElementById('petProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePetProfile() {
            document.getElementById('petProfileModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchPetTab(tabId) {
            document.querySelectorAll('[id^="petPanel"]').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('[id^="petTab"]').forEach(b => {
                b.classList.remove('text-dasma-700', 'border-dasma-700', 'border-b-2');
                b.classList.add('text-slate-500', 'border-transparent');
            });
            document.getElementById('petPanel' + tabId.charAt(0).toUpperCase() + tabId.slice(1)).classList.remove('hidden');
            const tabBtn = document.getElementById('petTab' + tabId.charAt(0).toUpperCase() + tabId.slice(1));
            tabBtn.classList.remove('text-slate-500', 'border-transparent');
            tabBtn.classList.add('text-dasma-700', 'border-dasma-700', 'border-b-2');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePetProfile();
        });

        document.getElementById('petProfileModal').addEventListener('click', function(e) {
            if (e.target === this) closePetProfile();
        });
    </script>
</body>
</html>
e.target === this) closePetProfile();
        });
    </script>
</body>
</html>
