@extends('layouts.admin')

@section('title', 'Admin Assistant Dashboard')
@section('header', 'Admin Assistant Dashboard')
@section('subheader', 'Admin Assistant operations and records management')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <!-- New Pet Registrations Today -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                New Pet Registrations Today
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $newPetRegistrationsToday }}</span>
                <span class="text-xs font-medium text-slate-500">Registrations</span>
            </div>
        </div>
    </div>

    <!-- Pending Adoption Applications -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Pending Adoption Applications
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $pendingAdoptions }}</span>
                <span class="text-xs font-medium text-slate-500">Pending</span>
            </div>
        </div>
    </div>

    <!-- Active Missing Pet Cases -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Active Missing Pet Cases
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $activeMissingPets }}</span>
                <span class="text-xs font-medium text-slate-500">Active Cases</span>
            </div>
        </div>
    </div>

    <!-- New Pet Owners This Week -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                New Pet Owners This Week
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $newPetOwnersThisWeek }}</span>
                <span class="text-xs font-medium text-slate-500">Owners</span>
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

<!-- Recent Items Requiring Action -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Items Requiring Action</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Pending Adoption Applications -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 bg-pink-50 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700">Pending Adoption Reviews</h4>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentPendingAdoptions as $application)
                    <a href="{{ route('admin-asst.adoption-applications.show', $application) }}" 
                       class="block p-3 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-2">
                            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bi bi-heart text-pink-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $application->owner ? $application->owner->first_name . ' ' . $application->owner->last_name : 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $application->created_at ? $application->created_at->diffForHumans() : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p class="text-xs">No pending adoptions</p>
                    </div>
                @endforelse
            </div>
            @if($pendingAdoptionReviews > 0)
                <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('admin-asst.adoption-applications.index') }}" 
                       class="text-xs text-pink-600 font-medium hover:underline">
                        View all {{ $pendingAdoptionReviews }} pending reviews →
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Missing Pet Reports Pending -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 bg-orange-50 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700">Missing Pet Reports Pending Verification</h4>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentMissingPetsPending as $report)
                    <a href="{{ route('admin-asst.missing-pets.show', $report) }}" 
                       class="block p-3 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-2">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bi bi-search text-orange-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $report->pet ? $report->pet->pet_name : 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $report->created_at ? $report->created_at->diffForHumans() : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p class="text-xs">No pending reports</p>
                    </div>
                @endforelse
            </div>
            @if($missingPetReportsPending > 0)
                <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('admin-asst.missing-pets.index') }}" 
                       class="text-xs text-orange-600 font-medium hover:underline">
                        View all {{ $missingPetReportsPending }} pending reports →
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Appointments Today -->
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 bg-purple-50 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700">Today's Appointments</h4>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentAppointments as $appointment)
                    <a href="{{ route('admin-asst.appointments.show', $appointment) }}" 
                       class="block p-3 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-2">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bi bi-calendar-event text-purple-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $appointment->form ? $appointment->form->title : 'Service Request' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $appointment->citizen_name ?? 'N/A' }} - {{ $appointment->submitted_at ? $appointment->submitted_at->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p class="text-xs">No appointments today</p>
                    </div>
                @endforelse
            </div>
            @if($todayAppointments > 0)
                <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('admin-asst.appointments.index') }}" 
                       class="text-xs text-purple-600 font-medium hover:underline">
                        View all {{ $todayAppointments }} appointments →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
