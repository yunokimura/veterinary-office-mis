@extends('layouts.admin')

@section('title', 'Pet Owners')
@section('header', 'Pet Owner Records')
@section('subheader', 'Manage pet owners')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <!-- Total Owners -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Total Owners
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $totalOwners }}</span>
                    <span class="text-xs font-medium text-slate-500">Owners</span>
                </div>
            </div>
        </div>

        <!-- With Pets -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    With Pets
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $ownersWithPets }}</span>
                    <span class="text-xs font-medium text-slate-500">With Pets</span>
                </div>
            </div>
        </div>

        <!-- Without Pets -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Without Pets
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $ownersWithoutPets }}</span>
                    <span class="text-xs font-medium text-slate-500">Without Pets</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Owners List Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Pet Owner Records</h3>
                    <p class="text-sm text-gray-500">View and manage pet owners</p>
                </div>
                <a href="{{ route('admin-asst.owners.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span class="font-medium">New Owner</span>
                </a>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="ownerSearchInput" value="{{ $search }}" placeholder="Search name, email, or contact..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <button type="button" id="clearOwnerFiltersBtn" onclick="clearOwnerFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap {{ !$search ? 'hidden' : '' }}">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="ownerTableContainer">
            @include('records.owners._table', ['owners' => $owners])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="ownerPagination">
            <div class="flex items-center justify-center">
                {{ $owners->withQueryString()->links() }}
            </div>
        </div>
        <div id="ownerLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-emerald-600 mr-2"></span>
            Loading...
        </div>
        <div id="ownerEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Pet Owners Found</h3>
            <p class="text-gray-500">Try adjusting your search criteria.</p>
        </div>
    </div>
</div>

<script>
let ownerSearchDebounce;
const ownerFilterUrl = '{{ route('admin-asst.owners.index') }}';

function getOwnerFilterParams() {
    return {
        search: document.getElementById('ownerSearchInput').value,
    };
}

function applyOwnerFilters() {
    const params = getOwnerFilterParams();
    const tableContainer = document.getElementById('ownerTableContainer');
    const paginationContainer = document.getElementById('ownerPagination');
    const loadingEl = document.getElementById('ownerLoading');
    const emptyState = document.getElementById('ownerEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${ownerFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering owners:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearOwnerFilters() {
    document.getElementById('ownerSearchInput').value = '';
    updateClearOwnerFiltersVisibility();
    applyOwnerFilters();
}

function updateClearOwnerFiltersVisibility() {
    const searchInput = document.getElementById('ownerSearchInput');
    const clearBtn = document.getElementById('clearOwnerFiltersBtn');

    const hasFilters = (searchInput && searchInput.value.trim() !== '');

    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.getElementById('ownerSearchInput').addEventListener('input', () => {
    clearTimeout(ownerSearchDebounce);
    ownerSearchDebounce = setTimeout(() => {
        updateClearOwnerFiltersVisibility();
        applyOwnerFilters();
    }, 300);
});

document.getElementById('ownerPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${ownerFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('ownerTableContainer').innerHTML = data.html;
            document.getElementById('ownerPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading owners page:', error);
    });
});

updateClearOwnerFiltersVisibility();
</script>
@endsection
