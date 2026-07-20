@extends('layouts.admin')

@section('title', 'Pet Owners')
@section('header', 'Pet Owner Records')
@section('subheader', 'Manage pet owners')

@section('content')
<div>
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                    <i class="bi bi-people text-emerald-600 me-2"></i>Pet Owners
                </h2>
                <p class="text-sm text-gray-600 mt-1">View and manage registered pet owners</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <!-- Total Owners -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Total Owners</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalOwners }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-people text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- With Pets -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-emerald-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">With Pets</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $ownersWithPets }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-paw text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Without Pets -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Without Pets</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $ownersWithoutPets }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-person-x text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="bi bi-funnel text-gray-600"></i>
            <h3 class="text-base font-semibold text-gray-800">Search</h3>
        </div>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-3">
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Search Owners</label>
                <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Name, email, or contact..." value="{{ $search }}">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium whitespace-nowrap">
                    <i class="bi bi-search me-1"></i>Search
                </button>
                @if($search)
                <a href="{{ route('admin-asst.owners.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium whitespace-nowrap">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Owners Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Owner</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pets</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registered</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($owners as $owner)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-person-fill text-blue-600"></i>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">{{ $owner->name }}</span>
                                    <div class="text-xs text-gray-500">{{ $owner->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $owner->contact_number ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $owner->pets_count }} pet(s)
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $owner->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin-asst.owners.show', $owner) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition"
                                   title="View">
                                    <i class="bi bi-eye text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12">
                            <div class="text-center">
                                <i class="bi bi-inbox text-gray-300 text-4xl mb-3 block"></i>
                                <p class="text-gray-500 font-medium">No pet owners found</p>
                                <p class="text-xs text-gray-400 mt-1">Try adjusting your search</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($owners->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-center">
                {{ $owners->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
