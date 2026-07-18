@extends('layouts.admin')

@section('title', 'Admin Assistant Dashboard')
@section('header', 'Admin Assistant Dashboard')
@section('subheader', 'Gatekeeper operations and records management')

@section('content')
@php
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good afternoon';
    } else {
        $greeting = 'Good evening';
    }
@endphp

<!-- Welcome Banner -->
<div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-6 border border-gray-200">
    <h2 class="text-xl md:text-2xl font-bold mb-2 text-gray-800">
        {{ $greeting }}, {{ auth()->user()->name ?? 'Admin Assistant' }}!
    </h2>
    <p class="text-sm md:text-base text-gray-600">
        Manage pet registrations, adoptions, missing pets, and pet owners.
    </p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-6">
    <!-- New Pet Registrations Today -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border-l-4 border-emerald-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-star text-emerald-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">New Pet Registrations Today</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $newPetRegistrationsToday }}</p>
            <p class="text-xs text-gray-500">
                @if($newPetRegistrationsTrend == 'up')
                    <span class="text-green-600 font-medium">↑ Up from yesterday</span>
                @elseif($newPetRegistrationsTrend == 'down')
                    <span class="text-red-600 font-medium">↓ Down from yesterday</span>
                @else
                    <span class="text-gray-600">→ Same as yesterday</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Pending Adoption Applications -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border-l-4 border-pink-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-heart text-pink-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Pending Adoption Applications</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $pendingAdoptions }}</p>
            <p class="text-xs text-gray-500">
                @if($pendingAdoptionsTrend == 'up')
                    <span class="text-green-600 font-medium">↑ Up from last week</span>
                @elseif($pendingAdoptionsTrend == 'down')
                    <span class="text-red-600 font-medium">↓ Down from last week</span>
                @else
                    <span class="text-gray-600">→ Same as last week</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Active Missing Pet Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border-l-4 border-orange-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-search text-orange-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">Active Missing Pet Cases</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $activeMissingPets }}</p>
            <p class="text-xs text-gray-500">
                @if($activeMissingPetsTrend == 'up')
                    <span class="text-red-600 font-medium">↑ Up from last week</span>
                @elseif($activeMissingPetsTrend == 'down')
                    <span class="text-green-600 font-medium">↓ Down from last week</span>
                @else
                    <span class="text-gray-600">→ Same as last week</span>
                @endif
            </p>
        </div>
    </div>

    <!-- New Pet Owners This Week -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border-l-4 border-blue-500 hover:shadow-md transition h-full flex flex-col justify-between">
        <div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                <i class="bi bi-people text-blue-600 text-lg md:text-xl"></i>
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-500 mb-2">New Pet Owners This Week</p>
        </div>
        <div>
            <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ $newPetOwnersThisWeek }}</p>
            <p class="text-xs text-gray-500">
                @if($newPetOwnersTrend == 'up')
                    <span class="text-green-600 font-medium">↑ Up from last week</span>
                @elseif($newPetOwnersTrend == 'down')
                    <span class="text-red-600 font-medium">↓ Down from last week</span>
                @else
                    <span class="text-gray-600">→ Same as last week</span>
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin-asst.pet-registrations.create') }}"
           class="flex flex-col items-center p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Register Pet</span>
        </a>

        <a href="{{ route('admin-asst.missing-pets.create') }}"
           class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-search text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Report Missing Pet</span>
        </a>

        <a href="{{ route('admin-asst.adoption-applications.index') }}"
           class="flex flex-col items-center p-4 bg-pink-50 hover:bg-pink-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-pink-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-heart text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Review Adoptions</span>
        </a>

        <a href="{{ route('admin-asst.owners.index') }}"
           class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-people text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">View Pet Owners</span>
        </a>
    </div>
</div>

<!-- Task Summary - Urgent Items Requiring Immediate Action -->
<div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl shadow-sm border border-amber-200 p-6 mb-8">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center">
            <i class="bi bi-exclamation-triangle text-white"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">Task Summary - Immediate Action Required</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pending Adoption Reviews -->
        <a href="{{ route('admin-asst.adoption-applications.index') }}" 
           class="bg-white rounded-lg shadow-sm border-l-4 border-pink-500 p-4 hover:shadow-md transition group flex flex-col h-full">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500">Pending Adoption Reviews</p>
                </div>
                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <i class="bi bi-heart text-pink-600"></i>
                </div>
            </div>
            <div class="mt-auto">
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $pendingAdoptionReviews }}</p>
                <p class="text-xs text-pink-600 font-medium group-hover:underline">Review Now →</p>
            </div>
        </a>

        <!-- Missing Pet Reports Waiting Verification -->
        <a href="{{ route('admin-asst.missing-pets.index') }}" 
           class="bg-white rounded-lg shadow-sm border-l-4 border-orange-500 p-4 hover:shadow-md transition group flex flex-col h-full">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500">Missing Pet Reports Waiting Verification</p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <i class="bi bi-search text-orange-600"></i>
                </div>
            </div>
            <div class="mt-auto">
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $missingPetReportsWaitingVerification }}</p>
                <p class="text-xs text-orange-600 font-medium group-hover:underline">Verify Reports →</p>
            </div>
        </a>

        <!-- New Pet Registrations -->
        <a href="{{ route('admin-asst.pet-registrations.index') }}" 
           class="bg-white rounded-lg shadow-sm border-l-4 border-emerald-500 p-4 hover:shadow-md transition group flex flex-col h-full">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500">New Pet Registrations</p>
                </div>
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <i class="bi bi-star text-emerald-600"></i>
                </div>
            </div>
            <div class="mt-auto">
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $newPetRegistrationsCount }}</p>
                <p class="text-xs text-emerald-600 font-medium group-hover:underline">View Registrations →</p>
            </div>
        </a>

        <!-- Owner Record Missing Contact Information -->
        <a href="{{ route('admin-asst.owners.index') }}" 
           class="bg-white rounded-lg shadow-sm border-l-4 border-red-500 p-4 hover:shadow-md transition group flex flex-col h-full">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500">Owner Record Missing Contact Information</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <i class="bi bi-telephone-x text-red-600"></i>
                </div>
            </div>
            <div class="mt-auto">
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $ownersMissingContactInfo }}</p>
                <p class="text-xs text-red-600 font-medium group-hover:underline">Update Records →</p>
            </div>
        </a>
    </div>

    <div class="mt-4 pt-3 border-t border-amber-200">
        <p class="text-xs text-gray-600 text-center">
            <i class="bi bi-info-circle me-1"></i>
            Click on any task above to navigate directly to the relevant section for immediate action.
        </p>
    </div>
</div>

<!-- Analytics Section -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Analytics Overview</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pet Registration Trend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-semibold text-gray-700">Pet Registration Trend</h4>
                <div class="flex gap-2">
                    <button onclick="toggleRegistrationPeriod('7days')" id="btn-7days" class="text-xs px-3 py-1 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">7 Days</button>
                    <button onclick="toggleRegistrationPeriod('30days')" id="btn-30days" class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">30 Days</button>
                </div>
            </div>
            
            <div id="registration-chart-7days" class="space-y-2">
                @php
                    $maxReg7 = !empty($petRegistrationTrend7Days) ? max($petRegistrationTrend7Days) : 1;
                    $totalReg7 = array_sum($petRegistrationTrend7Days);
                @endphp
                @if($totalReg7 > 0)
                    @foreach($petRegistrationTrend7Days as $date => $count)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-600 w-20 truncate">{{ \Carbon\Carbon::parse($date)->format('M d') }}</span>
                            <div class="flex-1 bg-gray-100 rounded-full h-6 overflow-hidden">
                                <div class="bg-emerald-600 h-full rounded-full flex items-center justify-end pr-2 transition-all" style="width: {{ ($count / $maxReg7) * 100 }}%">
                                    <span class="text-xs text-white font-medium">{{ $count }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-calendar-x text-3xl mb-2 block"></i>
                        <p class="text-sm">No registrations in the last 7 days</p>
                    </div>
                @endif
            </div>

            <div id="registration-chart-30days" class="space-y-2 hidden">
                @php
                    $maxReg30 = !empty($petRegistrationTrend30Days) ? max($petRegistrationTrend30Days) : 1;
                    $totalReg30 = array_sum($petRegistrationTrend30Days);
                @endphp
                @if($totalReg30 > 0)
                    @foreach($petRegistrationTrend30Days as $date => $count)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-600 w-20 truncate">{{ \Carbon\Carbon::parse($date)->format('M d') }}</span>
                            <div class="flex-1 bg-gray-100 rounded-full h-6 overflow-hidden">
                                <div class="bg-emerald-600 h-full rounded-full flex items-center justify-end pr-2 transition-all" style="width: {{ ($count / $maxReg30) * 100 }}%">
                                    <span class="text-xs text-white font-medium">{{ $count }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-calendar-x text-3xl mb-2 block"></i>
                        <p class="text-sm">No registrations in the last 30 days</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Adoption Status Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Adoption Status Distribution</h4>
            
            @php
                $totalAdoptionApps = array_sum($adoptionStatusDistribution);
                $adoptionColors = [
                    'pending' => 'bg-yellow-500',
                    'approved' => 'bg-green-500',
                    'rejected' => 'bg-red-500',
                    'completed' => 'bg-blue-500',
                    'cancelled' => 'bg-gray-500'
                ];
                $adoptionIcons = [
                    'pending' => 'bi-clock',
                    'approved' => 'bi-check-circle',
                    'rejected' => 'bi-x-circle',
                    'completed' => 'bi-check-all',
                    'cancelled' => 'bi-x-octagon'
                ];
            @endphp
            
            @if($totalAdoptionApps > 0)
                <div class="space-y-3">
                    @foreach($adoptionStatusDistribution as $status => $count)
                        @php
                            $percentage = round(($count / $totalAdoptionApps) * 100, 1);
                            $color = $adoptionColors[$status] ?? 'bg-gray-500';
                            $icon = $adoptionIcons[$status] ?? 'bi-circle';
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $color }} rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi {{ $icon }} text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-gray-700 capitalize">{{ $status }}</span>
                                    <span class="text-xs font-semibold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="{{ $color }} h-full rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <p class="text-xs text-gray-600 text-center">Total Applications: <span class="font-semibold">{{ $totalAdoptionApps }}</span></p>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-heart text-3xl mb-2 block"></i>
                    <p class="text-sm">No adoption applications yet</p>
                </div>
            @endif
        </div>

        <!-- Missing Pet Status Breakdown -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Missing Pet Status Breakdown</h4>
            
            @php
                $totalMissing = array_sum($missingPetStatusBreakdown);
                $missingColors = [
                    'missing' => 'bg-red-500',
                    'found' => 'bg-green-500',
                    'reunited' => 'bg-blue-500',
                    'closed' => 'bg-gray-500'
                ];
                $missingIcons = [
                    'missing' => 'bi-exclamation-triangle',
                    'found' => 'bi-search',
                    'reunited' => 'bi-heart',
                    'closed' => 'bi-check-circle'
                ];
            @endphp
            
            @if($totalMissing > 0)
                <div class="space-y-3">
                    @foreach($missingPetStatusBreakdown as $status => $count)
                        @php
                            $percentage = round(($count / $totalMissing) * 100, 1);
                            $color = $missingColors[$status] ?? 'bg-gray-500';
                            $icon = $missingIcons[$status] ?? 'bi-circle';
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $color }} rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi {{ $icon }} text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-gray-700 capitalize">{{ $status }}</span>
                                    <span class="text-xs font-semibold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="{{ $color }} h-full rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <p class="text-xs text-gray-600 text-center">Total Reports: <span class="font-semibold">{{ $totalMissing }}</span></p>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-search text-3xl mb-2 block"></i>
                    <p class="text-sm">No missing pet reports yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Pet Registrations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Pet Registrations</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentPetRegistrations as $pet)
                <a href="{{ route('admin-asst.pet-registrations.show', $pet->pet_id) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-star text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $pet->pet_name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($pet->species) }} - {{ $pet->owner ? $pet->owner->first_name . ' ' . $pet->owner->last_name : 'No owner' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No recent registrations</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Missing Pets -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Missing Pets</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentMissingPets as $missing)
                <a href="{{ route('admin-asst.missing-pets.show', $missing) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-search text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $missing->pet ? $missing->pet->pet_name : 'N/A' }}</p>
                            <p class="text-xs text-gray-500">
                                <span class="badge bg-{{ $missing->status == 'missing' ? 'danger' : 'success' }}">{{ ucfirst($missing->status) }}</span>
                                <span class="ms-2">{{ $missing->created_at ? $missing->created_at->format('M d, Y') : 'N/A' }}</span>
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No missing pet reports</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Pet Owners -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Recent Pet Owners</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentOwners as $owner)
                <a href="{{ route('admin-asst.owners.show', $owner) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-people text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $owner->user ? $owner->user->name : 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $owner->contact_number ?? 'No contact' }} - {{ $owner->created_at ? $owner->created_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                    <p class="text-sm">No pet owners registered</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function toggleRegistrationPeriod(period) {
    const btn7Days = document.getElementById('btn-7days');
    const btn30Days = document.getElementById('btn-30days');
    const chart7Days = document.getElementById('registration-chart-7days');
    const chart30Days = document.getElementById('registration-chart-30days');
    
    if (period === '7days') {
        btn7Days.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        btn7Days.classList.add('bg-emerald-600', 'text-white', 'hover:bg-emerald-700');
        btn30Days.classList.remove('bg-emerald-600', 'text-white', 'hover:bg-emerald-700');
        btn30Days.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        chart7Days.classList.remove('hidden');
        chart30Days.classList.add('hidden');
    } else {
        btn30Days.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        btn30Days.classList.add('bg-emerald-600', 'text-white', 'hover:bg-emerald-700');
        btn7Days.classList.remove('bg-emerald-600', 'text-white', 'hover:bg-emerald-700');
        btn7Days.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        chart30Days.classList.remove('hidden');
        chart7Days.classList.add('hidden');
    }
}
</script>

@endsection
