@extends('layouts.admin')

@section('title', 'Adoption Applications')
@section('header', 'Adoption Applications')
@section('subheader', 'Manage and review adoption applications')

@section('content')
<!-- Page Header with Action Button -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 md:p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                <i class="bi bi-heart text-emerald-600 me-2"></i>Adoption Applications
            </h2>
            <p class="text-sm text-gray-600 mt-1">View and manage all adoption applications</p>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Pending</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $pendingReviewCount }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-emerald-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Approved</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $approvedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Adopted -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Adopted</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $adoptedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-heart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-500 mb-1">Rejected</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $rejectedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-x-circle text-red-600 text-xl"></i>
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
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                <option value="">All Status</option>
                <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="adopted" {{ request('status') == 'adopted' ? 'selected' : '' }}>Adopted</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1.5">Search</label>
            <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Name, email, or mobile..." value="{{ request('search') }}">
        </div>
        <div class="lg:col-span-2 flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium whitespace-nowrap">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            <a href="{{ route('admin-asst.adoption-applications.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium whitespace-nowrap">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Applications List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Applicant</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Address</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rejection Reason</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Submitted</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $application)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="font-medium text-gray-900">{{ $application->first_name }} {{ $application->last_name }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm text-gray-700">{{ $application->email }}</div>
                        <div class="text-xs text-gray-500">{{ $application->mobile_number }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <small class="text-sm text-gray-600">{{ $application->blk_lot_ph }}, {{ $application->street }}, {{ $application->barangay }}</small>
                    </td>
                    <td class="px-4 py-3">
                        @switch($application->status)
                            @case('pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    <i class="bi bi-clock me-1"></i>Pending
                                </span>
                                @break
                            @case('approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="bi bi-check-circle me-1"></i>Approved
                                </span>
                                @break
                            @case('rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                </span>
                                @break
                            @case('adopted')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class="bi bi-heart me-1"></i>Adopted
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($application->status) }}
                                </span>
                        @endswitch
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @if($application->status == 'rejected' && $application->rejection_reason)
                            <span title="{{ $application->rejection_reason }}" class="text-danger cursor-help">
                                <i class="bi bi-info-circle me-1"></i>Provided
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $application->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin-asst.adoption-applications.show', $application) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition"
                               title="View">
                                <i class="bi bi-eye text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12">
                        <div class="text-center">
                            <i class="bi bi-inbox text-gray-300 text-4xl mb-3 block"></i>
                            <p class="text-gray-500 font-medium">No adoption applications found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your filters</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($applications->hasPages())
    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-center">
            {{ $applications->withQueryString()->links() }}
        </div>
    </div>
    @endif
</div>
@endsection