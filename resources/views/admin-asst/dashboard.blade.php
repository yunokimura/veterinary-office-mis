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
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border border-gray-100 flex flex-col">
        <div class="flex items-center justify-between gap-3 md:gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] md:text-[11px] font-medium text-gray-500 whitespace-nowrap">Registered Pets</p>
                <p class="text-xl md:text-3xl font-bold text-emerald-600 mt-1">{{ $totalPets }}</p>
            </div>
            <div class="w-7 h-7 md:w-14 md:h-14 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-paw text-emerald-600 text-sm md:text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border border-gray-100 flex flex-col">
        <div class="flex items-center justify-between gap-3 md:gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] md:text-[11px] font-medium text-gray-500 whitespace-nowrap">Missing Pets</p>
                <p class="text-xl md:text-3xl font-bold text-orange-600 mt-1">{{ $totalMissingPets }}</p>
            </div>
            <div class="w-7 h-7 md:w-14 md:h-14 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-search text-orange-600 text-sm md:text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border border-gray-100 flex flex-col">
        <div class="flex items-center justify-between gap-3 md:gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] md:text-[11px] font-medium text-gray-500 whitespace-nowrap">Adoption Applications</p>
                <p class="text-xl md:text-3xl font-bold text-pink-600 mt-1">{{ $totalAdoptions }}</p>
            </div>
            <div class="w-7 h-7 md:w-14 md:h-14 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-heart text-pink-600 text-sm md:text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-5 border border-gray-100 flex flex-col">
        <div class="flex items-center justify-between gap-3 md:gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-[10px] md:text-[11px] font-medium text-gray-500 whitespace-nowrap">Pet Owners</p>
                <p class="text-xl md:text-3xl font-bold text-blue-600 mt-1">{{ $totalOwners }}</p>
            </div>
            <div class="w-7 h-7 md:w-14 md:h-14 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-people text-blue-600 text-sm md:text-2xl"></i>
            </div>
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
                            <i class="bi bi-paw text-emerald-600"></i>
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
@endsection