@extends('layouts.admin')

@section('title', 'Adoption Applications')
@section('header', 'Adoption Applications')
@section('subheader', 'Manage and review adoption applications')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Pending
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $pendingReviewCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Pending</span>
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

        <!-- Adopted -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Adopted
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $adoptedCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Adopted</span>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-10 flex items-center mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Rejected
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-3 border-b border-slate-100">
                    <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $rejectedCount }}</span>
                    <span class="text-xs font-medium text-slate-500">Rejected</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications List Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Adoption Applications</h3>
                    <p class="text-sm text-gray-500">View and manage all adoption applications</p>
                </div>
                <a href="{{ route('admin-asst.adoption-applications.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span class="font-medium">New Application</span>
                </a>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="adoptionApplicationSearchInput" value="{{ request('search') }}" placeholder="Search name, email, or mobile..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" id="adoptionApplicationStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">All Status</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="adopted" {{ request('status') == 'adopted' ? 'selected' : '' }}>Adopted</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
            <button type="button" id="clearAdoptionApplicationFiltersBtn" onclick="clearAdoptionApplicationFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="adoptionApplicationTableContainer">
            @include('admin-asst.adoption-applications._table', ['applications' => $applications])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="adoptionApplicationPagination">
            <div class="flex items-center justify-center">
                {{ $applications->withQueryString()->links() }}
            </div>
        </div>
        <div id="adoptionApplicationLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-emerald-600 mr-2"></span>
            Loading...
        </div>
        <div id="adoptionApplicationEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Adoption Applications Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<script>
let adoptionApplicationSearchDebounce;
const adoptionApplicationFilterUrl = '{{ route('admin-asst.adoption-applications.index') }}';

function getAdoptionApplicationFilterParams() {
    return {
        search: document.getElementById('adoptionApplicationSearchInput').value,
        status: document.getElementById('adoptionApplicationStatus').value,
    };
}

function applyAdoptionApplicationFilters() {
    const params = getAdoptionApplicationFilterParams();
    const tableContainer = document.getElementById('adoptionApplicationTableContainer');
    const paginationContainer = document.getElementById('adoptionApplicationPagination');
    const loadingEl = document.getElementById('adoptionApplicationLoading');
    const emptyState = document.getElementById('adoptionApplicationEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${adoptionApplicationFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering adoption applications:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearAdoptionApplicationFilters() {
    document.getElementById('adoptionApplicationSearchInput').value = '';
    document.getElementById('adoptionApplicationStatus').value = '';
    updateClearAdoptionApplicationFiltersVisibility();
    applyAdoptionApplicationFilters();
}

function updateClearAdoptionApplicationFiltersVisibility() {
    const searchInput = document.getElementById('adoptionApplicationSearchInput');
    const statusSelect = document.getElementById('adoptionApplicationStatus');
    const clearBtn = document.getElementById('clearAdoptionApplicationFiltersBtn');

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

document.getElementById('adoptionApplicationSearchInput').addEventListener('input', () => {
    clearTimeout(adoptionApplicationSearchDebounce);
    adoptionApplicationSearchDebounce = setTimeout(() => {
        updateClearAdoptionApplicationFiltersVisibility();
        applyAdoptionApplicationFilters();
    }, 300);
});

document.getElementById('adoptionApplicationStatus').addEventListener('change', () => {
    updateClearAdoptionApplicationFiltersVisibility();
    applyAdoptionApplicationFilters();
});

document.getElementById('adoptionApplicationPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${adoptionApplicationFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('adoptionApplicationTableContainer').innerHTML = data.html;
            document.getElementById('adoptionApplicationPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading adoption applications page:', error);
    });
});

updateClearAdoptionApplicationFiltersVisibility();
</script>
@endsection
