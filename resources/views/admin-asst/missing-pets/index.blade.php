@extends('layouts.admin')

@section('title', 'Missing Pets')
@section('header', 'Missing Pets')
@section('subheader', 'Manage missing pet reports and help reunite them with owners')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <!-- Pending Review -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Pending Review
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $pendingReviewCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Pending Review</span>
                </div>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Approved
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $approvedCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Approved</span>
                </div>
            </div>
        </div>

        <!-- Reunited -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Reunited
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $reunitedCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Reunited</span>
                </div>
            </div>
        </div>

        <!-- Total Reports -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Total Reports
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $totalCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Reports</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Missing Pets List Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Missing Pets</h3>
                    <p class="text-sm text-gray-500">Manage missing pet reports and help reunite them with owners</p>
                </div>
                <a href="{{ route('admin-asst.missing-pets.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm hover:shadow-md">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span class="font-medium">Report Missing Pet</span>
                </a>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="missingPetSearchInput" value="{{ request('search') }}" placeholder="Search pet name, barangay..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" id="missingPetStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                        <option value="">All Status</option>
                        <option value="pending review" {{ request('status') == 'pending review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="resolved - reunited" {{ request('status') == 'resolved - reunited' ? 'selected' : '' }}>Resolved - Reunited</option>
                        <option value="resolved - shelter intake" {{ request('status') == 'resolved - shelter intake' ? 'selected' : '' }}>Resolved - Shelter Intake</option>
                        <option value="closed - expired" {{ request('status') == 'closed - expired' ? 'selected' : '' }}>Closed - Expired</option>
                        <option value="closed - cancelled" {{ request('status') == 'closed - cancelled' ? 'selected' : '' }}>Closed - Cancelled</option>
                        <option value="closed - duplicate" {{ request('status') == 'closed - duplicate' ? 'selected' : '' }}>Closed - Duplicate</option>
                    </select>
                </div>
            </div>
            <button type="button" id="clearMissingPetFiltersBtn" onclick="clearMissingPetFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="missingPetTableContainer">
            @include('admin-asst.missing-pets._table', ['missingPets' => $missingPets])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="missingPetPagination">
            <div class="flex items-center justify-center">
                {{ $missingPets->withQueryString()->links() }}
            </div>
        </div>
        <div id="missingPetLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-red-600 mr-2"></span>
            Loading...
        </div>
        <div id="missingPetEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Missing Pet Reports Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<script>
let missingPetSearchDebounce;
const missingPetFilterUrl = '{{ route('admin-asst.missing-pets.index') }}';

function getMissingPetFilterParams() {
    return {
        search: document.getElementById('missingPetSearchInput').value,
        status: document.getElementById('missingPetStatus').value,
    };
}

function applyMissingPetFilters() {
    const params = getMissingPetFilterParams();
    const tableContainer = document.getElementById('missingPetTableContainer');
    const paginationContainer = document.getElementById('missingPetPagination');
    const loadingEl = document.getElementById('missingPetLoading');
    const emptyState = document.getElementById('missingPetEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${missingPetFilterUrl}?${query.toString()}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (tableContainer) {
                tableContainer.innerHTML = data.html;
                tableContainer.style.opacity = '1';
            }
            if (paginationContainer) {
                paginationContainer.innerHTML = data.pagination;
                paginationContainer.style.opacity = '1';
            }
            if (emptyState) emptyState.style.display = data.has_results ? 'none' : 'block';
        }
    })
    .catch(error => {
        console.error('Error filtering missing pets:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearMissingPetFilters() {
    document.getElementById('missingPetSearchInput').value = '';
    document.getElementById('missingPetStatus').value = '';
    updateClearMissingPetFiltersVisibility();
    applyMissingPetFilters();
}

function updateClearMissingPetFiltersVisibility() {
    const searchInput = document.getElementById('missingPetSearchInput');
    const statusSelect = document.getElementById('missingPetStatus');
    const clearBtn = document.getElementById('clearMissingPetFiltersBtn');

    const hasFilters = (searchInput && searchInput.value.trim() !== '') ||
                       (statusSelect && statusSelect.value !== '');

    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.getElementById('missingPetSearchInput').addEventListener('input', () => {
    clearTimeout(missingPetSearchDebounce);
    missingPetSearchDebounce = setTimeout(() => {
        updateClearMissingPetFiltersVisibility();
        applyMissingPetFilters();
    }, 300);
});

document.getElementById('missingPetStatus').addEventListener('change', () => {
    updateClearMissingPetFiltersVisibility();
    applyMissingPetFilters();
});

document.getElementById('missingPetPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${missingPetFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('missingPetTableContainer').innerHTML = data.html;
            document.getElementById('missingPetPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading missing pets page:', error);
    });
});

updateClearMissingPetFiltersVisibility();
</script>
@endsection
