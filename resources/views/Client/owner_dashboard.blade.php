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
            ->with(['pet.owner.address.barangay', 'pet.petInfo', 'vaccinationReports'])
            ->orderByDesc('scheduled_at')
            ->get();
        $spayNeuterAppointments = \App\Models\SpayNeuterAppointment::where('user_id', auth()->id())
            ->with(['pet.owner.address.barangay', 'pet.petInfo'])
            ->orderByDesc('scheduled_at')
            ->get();

        $appointments = collect();
        foreach ($vaccinationAppointments as $a) {
            $pet = optional($a->pet);
            $owner = optional($pet)->owner;
            $petInfo = optional($pet)->petInfo;
            $address = optional($owner)->address;
            $barangay = optional($address)->barangay;
            $user = optional($owner)->user;
            $lastRabies = optional($a->vaccinationReports)->last();
            $appointments->push((object) [
                'id' => $a->id,
                'type' => 'vaccination',
                'pet_name' => optional($pet)->pet_name ?? 'N/A',
                'pet_breed' => optional($pet)->breed ?? '',
                'pet_id' => optional($pet)->pet_id ?? null,
                'scheduled_at' => $a->scheduled_at,
                'status' => $a->status,
                'vet' => $a->assignedVet?->user?->name ?? $a->clinic_name ?? 'N/A',
                'owner_name' => $owner ? ($owner->first_name . ' ' . $owner->last_name) : 'N/A',
                'owner_address' => $address ? trim((string) ($address->block_lot_phase ?? '') . ' ' . ($address->street ?? '') . ' ' . ($address->subdivision ?? '') . ', ' . ($barangay?->barangay_name ?? ($address?->barangay?->barangay_name ?? 'N/A')) . ', ' . ($address->city ?? '') . ', ' . ($address->province ?? '')) : 'N/A',
                'owner_barangay' => $barangay?->barangay_name ?? ($address?->barangay?->barangay_name ?? ($user?->barangay?->barangay_name ?? 'N/A')),
                'last_rabies_date' => $lastRabies?->vaccination_date ?? null,
                'recent_surgery' => $lastRabies?->notes ?? 'None',
            ]);
        }
        foreach ($spayNeuterAppointments as $a) {
            $pet = optional($a->pet);
            $owner = optional($pet)->owner;
            $petInfo = optional($pet)->petInfo;
            $address = optional($owner)->address;
            $barangay = optional($address)->barangay;
            $user = optional($owner)->user;
            $appointments->push((object) [
                'id' => $a->id,
                'type' => 'spay_neuter',
                'pet_name' => optional($pet)->pet_name ?? 'N/A',
                'pet_breed' => optional($pet)->breed ?? '',
                'pet_id' => optional($pet)->pet_id ?? null,
                'scheduled_at' => $a->scheduled_at,
                'status' => $a->status,
                'vet' => $a->assignedVet?->user?->name ?? $a->veterinarian ?? 'N/A',
                'owner_name' => $owner ? ($owner->first_name . ' ' . $owner->last_name) : 'N/A',
                'owner_address' => $address ? trim((string) ($address->block_lot_phase ?? '') . ' ' . ($address->street ?? '') . ' ' . ($address->subdivision ?? '') . ', ' . ($barangay?->barangay_name ?? ($address?->barangay?->barangay_name ?? 'N/A')) . ', ' . ($address->city ?? '') . ', ' . ($address->province ?? '')) : 'N/A',
                'owner_barangay' => $barangay?->barangay_name ?? ($address?->barangay?->barangay_name ?? ($user?->barangay?->barangay_name ?? 'N/A')),
                'procedure_type' => $a->procedure_type ?? 'N/A',
                'weight' => $petInfo?->pet_weight ?? 'N/A',
            ]);
        }
        $appointments = $appointments->sortByDesc(function ($item) {
            return $item->scheduled_at ? $item->scheduled_at : \Carbon\Carbon::parse('1970-01-01');
        })->values();
    @endphp

    @php
        $applications = \App\Models\AdoptionApplication::with(['pet', 'user.petOwner.address.barangay'])->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        $adoptionData = collect();
        foreach ($applications as $application) {
            $pet = optional($application->pet);
            $user = optional($application->user);
            $petOwner = optional($user)->petOwner;
            $address = optional($petOwner)->address;
            $barangay = optional($address)->barangay;
            $adoptionData->push((object) [
                'id' => $application->id,
                'pet_name' => $pet->pet_name ?? 'Unspecified (General)',
                'pet_species' => $pet->species ?? '-',
                'pet_breed' => $pet->breed ?? '-',
                'pet_id' => $pet->pet_id ?? null,
                'submitted_at' => $application->created_at,
                'appointment_date' => $application->appointment_date ?? null,
                'status' => $application->status ?? 'pending_review',
                'owner_name' => $user ? ($user->first_name . ' ' . $user->last_name) : 'N/A',
                'owner_address' => $address ? trim((string) ($address->block_lot_phase ?? '') . ' ' . ($address->street ?? '') . ' ' . ($address->subdivision ?? '') . ' ' . ($barangay?->name ?? '') . ', ' . ($address->city ?? '') . ', ' . ($address->province ?? '')) : 'N/A',
                'owner_barangay' => $barangay?->name ?? ($address?->barangay?->name ?? 'N/A'),
                'adopted_before' => $application->adopted_before ?? 'N/A',
                'alternate_contact' => $application->alternate_contact ?? 'N/A',
                'questionnaire' => $application->questionnaire ?? 'N/A',
                'valid_id' => $application->valid_id ?? 'N/A',
            ]);
        }
    @endphp

    <script>
        const allAppointments = @json($appointments);
        const allAdoptions = @json($adoptionData);
    </script>

    <!-- Section Grid: Appointments & Adoption Applications -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: My Appointments (7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Section Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-5 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-5 h-5 text-dasma-700"></i> My Appointments
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">Track vaccination, spay/neuter (Kapon), and checkups.</p>
                            </div>
                            
                            <!-- Filter dropdown -->
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-slate-400 font-medium">Type:</span>
                                <select id="apptFilterSelect" onchange="onApptFilterChange(this.value)" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-dasma-500">
                                    <option value="all">All Types</option>
                                    <option value="Vaccination">Vaccination</option>
                                    <option value="Spay & Neuter">Spay & Neuter</option>
                                </select>
                            </div>
                        </div>

                        <!-- Appointments Container (Dynamic via JS) -->
                        <div id="appointmentsContainer" class="space-y-3 mt-5 min-h-[280px]">
                            <!-- Rendered by JS -->
                        </div>
                    </div>

                    <!-- Appointments Pagination Controls -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
                        <span id="apptPaginationInfo" class="font-medium">Showing 1-3 of 0 appointments</span>
                        <div class="flex items-center gap-1.5">
                            <button id="apptPrevBtn" onclick="changeApptPage(-1)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1">
                                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i> Prev
                            </button>
                            <div id="apptPageNumbers" class="flex items-center gap-1">
                                <!-- Page numbers rendered by JS -->
                            </div>
                            <button id="apptNextBtn" onclick="changeApptPage(1)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1">
                                Next <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: My Adoption Applications (5 Cols) -->
                <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Section Header -->
                        <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                    <i data-lucide="heart" class="w-5 h-5 text-rose-500"></i> Adoption Requests
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">Track your city shelter pet adoption process.</p>
                            </div>
                            <span id="adoptionBadge" class="px-2.5 py-1 bg-amber-100 text-amber-800 font-bold text-[10px] rounded-full uppercase tracking-wide">0 Total</span>
                        </div>

                        <!-- Adoption Applications Container (Dynamic via JS) -->
                        <div id="adoptionContainer" class="space-y-3 mt-5 min-h-[280px]">
                            <!-- Rendered by JS -->
                        </div>
                    </div>

                    <!-- Adoption Pagination Controls -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
                        <span id="adoptionPaginationInfo" class="font-medium">Showing 1-2 of 0 applications</span>
                        <div class="flex items-center gap-1.5">
                            <button id="adoptionPrevBtn" onclick="changeAdoptionPage(-1)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1">
                                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i> Prev
                            </button>
                            <div id="adoptionPageNumbers" class="flex items-center gap-1">
                                <!-- Page numbers rendered by JS -->
                            </div>
                            <button id="adoptionNextBtn" onclick="changeAdoptionPage(1)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex items-center gap-1">
                                Next <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('Client.partials.footer')

    <!-- DESIGN 2: Centered Glassmorphic Modal (Appointments & Adoption) -->
    <div id="glassModal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white/95 rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-white/40 relative space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-dasma-600 to-dasma-800 text-white flex items-center justify-center font-bold shadow-md" id="glassIcon">
                        <i data-lucide="calendar"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-dasma-700 uppercase tracking-widest" id="glassSubhead">Centered Glass Modal</span>
                        <h3 class="text-xl font-bold text-slate-900" id="glassTitle">Appointment Details</h3>
                    </div>
                </div>

                <!-- Tab Pills -->
                <div class="flex bg-slate-100 p-1 rounded-xl">
                    <button id="glassTabNavView" onclick="switchGlassTab('view')" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-slate-800 shadow-sm transition-all flex items-center gap-1">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> View
                    </button>
                    <button id="glassTabNavEdit" onclick="switchGlassTab('edit')" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-slate-800 transition-all flex items-center gap-1">
                        <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div id="glassContent" class="space-y-4 max-h-[70vh] overflow-y-auto pr-1">
                <!-- Injected via JS -->
            </div>

            <!-- Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400 font-mono" id="glassIDTag">ID: #APP-000</span>
                <div id="glassFooterBtns" class="flex items-center gap-2">
                    <button onclick="closeModal('glassModal')" id="glassCancelBtn" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl">Cancel</button>
                    <button id="glassSaveBtn" onclick="saveGlassForm()" class="px-5 py-2 bg-dasma-700 hover:bg-dasma-800 text-white font-semibold rounded-xl shadow-sm">Save & Update</button>
                </div>
            </div>
    </div>
</div>

    <script>
        lucide.createIcons();
    </script>

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

        // Appointments Pagination State
        let currentApptPage = 1;
        const apptsPerPage = 3;
        let filteredAppointments = [...allAppointments];

        // Adoption Pagination State
        let currentAdoptionPage = 1;
        const adoptionsPerPage = 2;

        function renderAppointments() {
            const container = document.getElementById('appointmentsContainer');
            container.innerHTML = '';

            const total = filteredAppointments.length;
            const totalPages = Math.max(1, Math.ceil(total / apptsPerPage));
            if (currentApptPage > totalPages) currentApptPage = totalPages;

            const startIndex = (currentApptPage - 1) * apptsPerPage;
            const endIndex = Math.min(startIndex + apptsPerPage, total);
            const pageItems = filteredAppointments.slice(startIndex, endIndex);

            if (pageItems.length === 0) {
                container.innerHTML = '<div class="p-8 text-center text-slate-400 text-xs">No appointments found matching filter.</div>';
            } else {
                pageItems.forEach(item => {
                    const itemJson = JSON.stringify(item).replace(/"/g, '&quot;');
                    const typeLabel = item.type === 'vaccination' ? 'Vaccination' : 'Spay & Neuter';
                    const statusLabel = (item.status || 'pending').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                    let statusBadge, statusBorder;
                    if (['pending', 'pending_review'].includes(item.status)) {
                        statusBadge = 'bg-amber-100 text-amber-800';
                        statusBorder = 'border-l-amber-500';
                    } else if (['approved', 'completed'].includes(item.status)) {
                        statusBadge = 'bg-emerald-100 text-emerald-800';
                        statusBorder = 'border-l-emerald-500';
                    } else if (['rejected', 'cancelled'].includes(item.status)) {
                        statusBadge = 'bg-rose-100 text-rose-800';
                        statusBorder = 'border-l-rose-500';
                    } else {
                        statusBadge = 'bg-slate-100 text-slate-700';
                        statusBorder = 'border-l-slate-500';
                    }

                    const scheduled = item.scheduled_at ? new Date(item.scheduled_at).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' }) + ' at ' + new Date(item.scheduled_at).toLocaleTimeString(undefined, { hour: 'numeric', minute: '2-digit' }) : 'TBA';

                    const cardHtml = `
                        <div class="p-4 rounded-2xl bg-slate-50 ${statusBorder} border-t border-r border-b border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono text-slate-400 font-bold">APP #${item.id}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusBadge}">${statusLabel}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-200 text-slate-700">${typeLabel}</span>
                                </div>
                                <div class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                    <span>${item.pet_name}</span> ${item.pet_breed ? '<span class="text-xs font-normal text-slate-500">(' + item.pet_breed + ')</span>' : ''}
                                </div>
                                <div class="text-xs text-slate-500 flex flex-wrap items-center gap-x-4 gap-y-1">
                                    <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> ${scheduled}</span>
                                    <span class="flex items-center gap-1"><i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i> ${item.vet || 'N/A'}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-center">
                                <button onclick="openItemModal(${itemJson}, 'appointment', 'view')" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-sm transition-colors whitespace-nowrap">
                                    View Details
                                </button>
                                ${!['completed', 'rejected', 'cancelled'].includes(item.status) ? `
                                <button onclick="openItemModal(${itemJson}, 'appointment', 'edit')" class="px-2.5 py-1.5 bg-dasma-50 hover:bg-dasma-100 text-dasma-800 border border-dasma-200 rounded-xl text-xs font-semibold transition-colors">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                </button>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    container.innerHTML += cardHtml;
                });
            }

            document.getElementById('apptPaginationInfo').innerText = total > 0 ? `Showing ${startIndex + 1}-${endIndex} of ${total} appointments` : '0 appointments';
            document.getElementById('apptPrevBtn').disabled = currentApptPage === 1;
            document.getElementById('apptNextBtn').disabled = currentApptPage === totalPages || total === 0;

            const numContainer = document.getElementById('apptPageNumbers');
            numContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `w-7 h-7 rounded-lg text-xs font-semibold transition-colors ${i === currentApptPage ? 'bg-dasma-700 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'}`;
                btn.innerText = i;
                btn.onclick = () => { currentApptPage = i; renderAppointments(); };
                numContainer.appendChild(btn);
            }

            lucide.createIcons();
        }

        function changeApptPage(delta) {
            currentApptPage += delta;
            renderAppointments();
        }

        function onApptFilterChange(type) {
            if (type === 'all') {
                filteredAppointments = [...allAppointments];
            } else {
                filteredAppointments = allAppointments.filter(a => a.type === type);
            }
            currentApptPage = 1;
            renderAppointments();
        }

        function renderAdoptions() {
            const container = document.getElementById('adoptionContainer');
            container.innerHTML = '';

            const total = allAdoptions.length;
            const totalPages = Math.ceil(total / adoptionsPerPage);
            const startIndex = (currentAdoptionPage - 1) * adoptionsPerPage;
            const endIndex = Math.min(startIndex + adoptionsPerPage, total);
            const pageItems = allAdoptions.slice(startIndex, endIndex);

            pageItems.forEach(item => {
                const itemJson = JSON.stringify(item).replace(/"/g, '&quot;');
                const isApproved = item.status === 'approved' || item.status === 'completed';
                const statusLabel = (item.status || 'pending_review').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                let statusBadge, statusBg, statusBorder;
                if (item.status === 'pending_review') {
                    statusBadge = 'bg-amber-100 text-amber-800';
                    statusBg = 'bg-amber-50/50';
                    statusBorder = 'border-amber-200/70';
                } else if (isApproved) {
                    statusBadge = 'bg-emerald-100 text-emerald-800';
                    statusBg = 'bg-emerald-50/50';
                    statusBorder = 'border-emerald-200/70';
                } else {
                    statusBadge = 'bg-rose-100 text-rose-800';
                    statusBg = 'bg-rose-50/50';
                    statusBorder = 'border-rose-200/70';
                }

                const cardHtml = `
                    <div class="p-4 rounded-2xl ${statusBg} border ${statusBorder} space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-slate-900">ADPT-APP #${item.id}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusBadge}">${statusLabel}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-semibold">Target Pet</span>
                                <span class="font-bold text-slate-800 text-sm">${item.pet?.pet_name || 'Unspecified (General)'}</span>
                            </div>
                            ${item.appointment_date ? `
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 block uppercase font-semibold">Interview Date</span>
                                    <span class="font-semibold text-dasma-700">${new Date(item.appointment_date).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="openItemModal(${itemJson}, 'adoption', 'view')" class="flex-1 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Summary
                            </button>
                            ${!['approved', 'completed', 'rejected', 'cancelled'].includes(item.status) ? `
                            <button onclick="openItemModal(${itemJson}, 'adoption', 'edit')" class="flex-1 py-2 bg-dasma-50 hover:bg-dasma-100 border border-dasma-200 text-dasma-800 rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Edit
                            </button>
                            ` : ''}
                        </div>
                    </div>
                `;
                container.innerHTML += cardHtml;
            });

            document.getElementById('adoptionBadge').innerText = total + ' Total';
            document.getElementById('adoptionPaginationInfo').innerText = `Showing ${startIndex + 1}-${endIndex} of ${total} applications`;
            document.getElementById('adoptionPrevBtn').disabled = currentAdoptionPage === 1;
            document.getElementById('adoptionNextBtn').disabled = currentAdoptionPage === totalPages;

            const numContainer = document.getElementById('adoptionPageNumbers');
            numContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `w-7 h-7 rounded-lg text-xs font-semibold transition-colors ${i === currentAdoptionPage ? 'bg-dasma-700 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'}`;
                btn.innerText = i;
                btn.onclick = () => { currentAdoptionPage = i; renderAdoptions(); };
                numContainer.appendChild(btn);
            }

            lucide.createIcons();
        }

        function changeAdoptionPage(delta) {
            currentAdoptionPage += delta;
            renderAdoptions();
        }

        // Init on load
        renderAppointments();
        renderAdoptions();

        // --- Glass Modal State ---
        let activeItemData = null;
        let activeItemType = 'appointment';
        let activeTabMode = 'view';

        function openItemModal(item, type, mode = 'view') {
            activeItemData = item;
            activeItemType = type;
            activeTabMode = mode;
            renderGlassModal();
            document.getElementById('glassModal').classList.remove('hidden');
        }

        function closeGlassModal() {
            document.getElementById('glassModal').classList.add('hidden');
            activeItemData = null;
        }

        function renderGlassModal() {
            const isAppt = activeItemType === 'appointment';
            const item = activeItemData;
            const statusLabel = (item.status || 'pending_review').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

            let statusBadge, statusBorder;
            if (['pending', 'pending_review'].includes(item.status)) {
                statusBadge = 'bg-amber-100 text-amber-800';
                statusBorder = 'border-l-amber-500';
            } else if (['approved', 'completed'].includes(item.status)) {
                statusBadge = 'bg-emerald-100 text-emerald-800';
                statusBorder = 'border-l-emerald-500';
            } else if (['rejected', 'cancelled'].includes(item.status)) {
                statusBadge = 'bg-rose-100 text-rose-800';
                statusBorder = 'border-l-rose-500';
            } else {
                statusBadge = 'bg-slate-100 text-slate-700';
                statusBorder = 'border-l-slate-500';
            }

            const scheduled = item.scheduled_at ? new Date(item.scheduled_at).toLocaleString(undefined, { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' }) : 'TBA';
            const apptDate = item.appointment_date ? new Date(item.appointment_date).toLocaleString(undefined, { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' }) : 'TBA';

            const isCompleted = ['completed', 'rejected', 'cancelled'].includes(item.status);

            document.getElementById('glassIcon').innerHTML = isAppt ? '<i data-lucide="calendar" class="w-5 h-5"></i>' : '<i data-lucide="heart" class="w-5 h-5"></i>';
            document.getElementById('glassSubhead').innerText = `${isAppt ? 'My Appointments' : 'My Adoption Applications'} • ${activeTabMode === 'view' ? 'View' : 'Edit'}`;
            const idPrefix = activeItemType === 'appointment' ? 'APP #' : 'ADPT-APP #';
            document.getElementById('glassTitle').innerText = `${idPrefix}${item.id}: ${item.pet_name}`;
            document.getElementById('glassIDTag').innerText = `Record Reference: ${idPrefix}${item.id}`;

            // Force view mode when completed/rejected/cancelled and hide Edit tab
            if (isCompleted) {
                activeTabMode = 'view';
                document.getElementById('glassTabNavEdit').classList.add('hidden');
            } else {
                document.getElementById('glassTabNavEdit').classList.remove('hidden');
            }

            document.getElementById('glassTabNavView').className = `px-3 py-1.5 rounded-lg text-xs font-bold transition-all ${activeTabMode === 'view' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500'}`;
            document.getElementById('glassTabNavEdit').className = `px-3 py-1.5 rounded-lg text-xs font-bold transition-all ${activeTabMode === 'edit' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500'} ${!isCompleted ? '' : 'hidden'}`;

            const content = document.getElementById('glassContent');

            if (activeTabMode === 'view') {
                if (isAppt) {
                    const isVaccination = item.type === 'vaccination';
                    content.innerHTML = `
                        <div class="p-4 rounded-2xl ${statusBorder} border-t border-r border-b border-slate-200/80 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-200 text-slate-700">${isVaccination ? 'Anti-Rabies Vaccination' : 'Spay & Neuter'}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusBadge}">${statusLabel}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pet Details -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Pet Details</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Pet Name:</span><span class="font-semibold text-slate-800">${item.pet_name}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Breed:</span><span class="font-semibold text-slate-800">${item.pet_breed || '-'}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Pet ID:</span><span class="font-semibold text-slate-800 font-mono">PET-${String(item.pet_id ?? '-').padStart(4, '0')}</span></div>
                                    ${isVaccination ? `
                                        <div class="flex justify-between"><span class="text-slate-500">Last Anti-Rabies:</span><span class="font-semibold text-slate-800">${item.last_rabies_date ? new Date(item.last_rabies_date).toLocaleDateString() : '-'}</span></div>
                                        <div class="flex justify-between"><span class="text-slate-500">Recent Surgery:</span><span class="font-semibold text-slate-800">${item.recent_surgery || 'None'}</span></div>
                                    ` : `
                                        <div class="flex justify-between"><span class="text-slate-500">Procedure Type:</span><span class="font-semibold text-slate-800">${item.procedure_type || 'N/A'}</span></div>
                                        <div class="flex justify-between"><span class="text-slate-500">Weight:</span><span class="font-semibold text-slate-800">${item.weight || 'N/A'}</span></div>
                                    `}
                                </div>
                            </div>

                            <!-- Owner Details -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Owner Details</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Name:</span><span class="font-semibold text-slate-800">${item.owner_name}</span></div>
                                    <div class="flex justify-between items-start"><span class="text-slate-500">Address:</span><span class="font-semibold text-slate-800 text-right min-w-0 break-words max-w-[160px] leading-tight">${item.owner_address}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Barangay:</span><span class="font-semibold text-slate-800">${item.owner_barangay}</span></div>
                                </div>
                            </div>

                            <!-- Vet & Schedule -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 col-span-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Veterinarian & Schedule</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Assigned Vet:</span><span class="font-semibold text-slate-800">${item.vet}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Scheduled At:</span><span class="font-semibold text-slate-800">${scheduled}</span></div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Adoption view
                    content.innerHTML = `
                        <div class="p-4 rounded-2xl ${statusBorder} border-t border-r border-b border-slate-200/80 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${statusBadge}">${statusLabel}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Selected Pet Information -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Selected Pet Information</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Pet Name:</span><span class="font-semibold text-slate-800">${item.pet_name}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Species:</span><span class="font-semibold text-slate-800">${item.pet_species}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Breed:</span><span class="font-semibold text-slate-800">${item.pet_breed}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Pet ID:</span><span class="font-semibold text-slate-800 font-mono">PET-${String(item.pet_id ?? '-').padStart(4, '0')}</span></div>
                                </div>
                            </div>

                            <!-- Owner Details -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Owner Details</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Name:</span><span class="font-semibold text-slate-800">${item.owner_name}</span></div>
                                    <div class="flex justify-between items-start"><span class="text-slate-500">Address:</span><span class="font-semibold text-slate-800 text-right min-w-0 break-words max-w-[160px] leading-tight">${item.owner_address}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Barangay:</span><span class="font-semibold text-slate-800">${item.owner_barangay}</span></div>
                                </div>
                            </div>

                            <!-- Adoption Specific -->
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 col-span-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-2 block">Adoption Details</span>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span class="text-slate-500">Adopted Before:</span><span class="font-semibold text-slate-800">${item.adopted_before}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Alternate Contact:</span><span class="font-semibold text-slate-800">${item.alternate_contact}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Questionnaire:</span><span class="font-semibold text-slate-800">${item.questionnaire}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Valid ID:</span><span class="font-semibold text-slate-800">${item.valid_id}</span></div>
                                    <div class="flex justify-between"><span class="text-slate-500">Appointment Date & Time:</span><span class="font-semibold text-slate-800">${apptDate}</span></div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            } else {
                // Edit mode - simple form
                if (isAppt) {
                    content.innerHTML = `
                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Reschedule Date</label>
                                <input id="glassInputDate" type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Update Notes</label>
                                <textarea id="glassInputNotes" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium"></textarea>
                            </div>
                        </div>
                    `;
                } else {
                    content.innerHTML = `
                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Interview Date</label>
                                <input id="glassInputDate" type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Remarks</label>
                                <textarea id="glassInputNotes" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium"></textarea>
                            </div>
                        </div>
                    `;
                }
            }

            // Update footer buttons based on status
            const cancelBtn = document.getElementById('glassCancelBtn');
            const saveBtn = document.getElementById('glassSaveBtn');
            if (isCompleted) {
                cancelBtn.classList.add('hidden');
                saveBtn.textContent = 'Close';
                saveBtn.className = 'px-5 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl shadow-sm';
                saveBtn.onclick = () => closeModal('glassModal');
            } else {
                cancelBtn.classList.remove('hidden');
                saveBtn.textContent = 'Save & Update';
                saveBtn.className = 'px-5 py-2 bg-dasma-700 hover:bg-dasma-800 text-white font-semibold rounded-xl shadow-sm';
                saveBtn.onclick = saveGlassForm;
            }

            lucide.createIcons();
        }

        function switchGlassTab(mode) {
            activeTabMode = mode;
            renderGlassModal();
        }

        function saveGlassForm() {
            if (activeItemData && ['completed', 'rejected', 'cancelled'].includes(activeItemData.status)) {
                showToast('Cannot edit a completed or cancelled record.');
                closeGlassModal();
                return;
            }
            if (activeTabMode === 'edit') {
                const dateVal = document.getElementById('glassInputDate')?.value;
                if (dateVal) {
                    showToast(`Updated record ${activeItemData.id}`);
                }
            }
            closeGlassModal();
            renderAppointments();
            renderAdoptions();
        }

        function showToast(msg) {
            let toast = document.getElementById('toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast';
                toast.className = 'fixed bottom-5 right-5 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl z-50 flex items-center gap-3 transition-all duration-300 transform translate-y-20 opacity-0 text-xs border border-slate-700';
                toast.innerHTML = '<div class="w-6 h-6 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center font-bold"><i data-lucide="check" class="w-4 h-4"></i></div><span id="toastMsg">Action completed</span>';
                document.body.appendChild(toast);
            }
            document.getElementById('toastMsg').innerText = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => { toast.classList.add('translate-y-20', 'opacity-0'); }, 3000);
            lucide.createIcons();
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
</body>
</html>
