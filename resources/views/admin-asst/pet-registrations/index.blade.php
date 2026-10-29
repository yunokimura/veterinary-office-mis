@extends('layouts.admin')

@section('title', 'Pet Registrations')
@section('header', 'Pet Registrations')
@section('subheader', 'Manage and review pet registration records')

@section('content')
<!-- Page Header with Action Button -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                <i class="bi bi-paw text-emerald-600 me-2"></i>Pet Registrations
            </h2>
            <p class="text-sm text-gray-600 mt-1">View and manage all pet registration records</p>
        </div>
        <a href="{{ route('admin-asst.pet-registrations.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
            <i class="bi bi-plus-circle text-lg"></i>
            <span class="font-medium">New Registration</span>
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <!-- Total Pets -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Total Pets
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $totalCount }}</span>
                <span class="text-xs font-medium text-slate-500">Pets</span>
            </div>
        </div>
    </div>

    <!-- Owned -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                Registered
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $registeredCount }}</span>
                <span class="text-xs font-medium text-slate-500">Owned</span>
            </div>
        </div>
    </div>

    <!-- For Adoption -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
        <div class="h-10 flex items-center mb-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                For Adoption
            </span>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $forAdoptionCount }}</span>
                <span class="text-xs font-medium text-slate-500">Available</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="bi bi-funnel text-gray-600"></i>
        <h3 class="text-base font-semibold text-gray-800">Filters</h3>
    </div>
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Search</label>
            <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Pet name or owner..." value="{{ request('search') }}">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">All Status</option>
                <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>Registered</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Species</label>
            <select name="species" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">All Species</option>
                <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Bird</option>
                <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Barangay</label>
            <select name="barangay_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">All Barangays</option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->barangay_id }}" {{ request('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                        {{ $barangay->barangay_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="lg:col-span-4 flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium whitespace-nowrap">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            <a href="{{ route('admin-asst.pet-registrations.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium whitespace-nowrap">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Pet List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pet Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Species</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Gender</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Breed</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Owner</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registered</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pets as $pet)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <span class="font-medium text-gray-900">{{ $pet->name }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                            {{ ucfirst($pet->species) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($pet->gender == 'male')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="bi bi-gender-male me-1"></i>Male
                            </span>
                        @elseif($pet->gender == 'female')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                <i class="bi bi-gender-female me-1"></i>Female
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Unknown
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $pet->breed }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $pet->userOwner ? $pet->userOwner->name : 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            <i class="bi bi-check-circle me-1"></i>Registered
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $pet->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition"
                               title="View">
                                <i class="bi bi-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin-asst.pet-registrations.edit', $pet) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition"
                               title="Edit">
                                <i class="bi bi-pencil text-sm"></i>
                            </a>
                            <form action="{{ route('admin-asst.pet-registrations.destroy', $pet) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition"
                                        title="Delete">
                                    <i class="bi bi-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12">
                        <div class="text-center">
                            <i class="bi bi-inbox text-gray-300 text-4xl mb-3 block"></i>
                            <p class="text-gray-500 font-medium">No pet registrations found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your filters or add a new registration</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($pets->hasPages())
    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-center">
            {{ $pets->withQueryString()->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
