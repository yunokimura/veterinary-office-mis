@extends('layouts.admin')

@section('title', 'Pet Registrations')
@section('header', 'Pet Registrations')
@section('subheader', 'Manage and review pet registration records')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
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

    <!-- Pet List Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Pet Registrations</h3>
                    <p class="text-sm text-gray-500">View and manage all pet registration records</p>
                </div>
                <a href="{{ route('admin-asst.pet-registrations.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span class="font-medium">New Registration</span>
                </a>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="petRegistrationSearchInput" value="{{ request('search') }}" placeholder="Search pet, owner..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" id="petRegistrationStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">All Status</option>
                        <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>Registered</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Species</label>
                    <select name="species" id="petRegistrationSpecies" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">All Species</option>
                        <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="bird" {{ request('species') == 'bird' ? 'selected' : '' }}>Bird</option>
                        <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Barangay</label>
                    <select name="barangay_id" id="petRegistrationBarangay" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ request('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="button" id="clearPetRegistrationFiltersBtn" onclick="clearPetRegistrationFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="petRegistrationTableContainer">
            @include('admin-asst.pet-registrations._table', ['pets' => $pets])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="petRegistrationPagination">
            <div class="flex items-center justify-center">
                {{ $pets->withQueryString()->links() }}
            </div>
        </div>
        <div id="petRegistrationLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-emerald-600 mr-2"></span>
            Loading...
        </div>
        <div id="petRegistrationEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Pet Registrations Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<script>
let petRegistrationSearchDebounce;
const petRegistrationFilterUrl = '{{ route('admin-asst.pet-registrations.index') }}';

function getPetRegistrationFilterParams() {
    return {
        search: document.getElementById('petRegistrationSearchInput').value,
        status: document.getElementById('petRegistrationStatus').value,
        species: document.getElementById('petRegistrationSpecies').value,
        barangay_id: document.getElementById('petRegistrationBarangay').value,
    };
}

function applyPetRegistrationFilters() {
    const params = getPetRegistrationFilterParams();
    const tableContainer = document.getElementById('petRegistrationTableContainer');
    const paginationContainer = document.getElementById('petRegistrationPagination');
    const loadingEl = document.getElementById('petRegistrationLoading');
    const emptyState = document.getElementById('petRegistrationEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${petRegistrationFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering pet registrations:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearPetRegistrationFilters() {
    document.getElementById('petRegistrationSearchInput').value = '';
    document.getElementById('petRegistrationStatus').value = '';
    document.getElementById('petRegistrationSpecies').value = '';
    document.getElementById('petRegistrationBarangay').value = '';
    updateClearPetRegistrationFiltersVisibility();
    applyPetRegistrationFilters();
}

function updateClearPetRegistrationFiltersVisibility() {
    const searchInput = document.getElementById('petRegistrationSearchInput');
    const statusSelect = document.getElementById('petRegistrationStatus');
    const speciesSelect = document.getElementById('petRegistrationSpecies');
    const barangaySelect = document.getElementById('petRegistrationBarangay');
    const clearBtn = document.getElementById('clearPetRegistrationFiltersBtn');

    const hasFilters = (searchInput && searchInput.value.trim() !== '') ||
                       (statusSelect && statusSelect.value !== '') ||
                       (speciesSelect && speciesSelect.value !== '') ||
                       (barangaySelect && barangaySelect.value !== '');

    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.getElementById('petRegistrationSearchInput').addEventListener('input', () => {
    clearTimeout(petRegistrationSearchDebounce);
    petRegistrationSearchDebounce = setTimeout(() => {
        updateClearPetRegistrationFiltersVisibility();
        applyPetRegistrationFilters();
    }, 300);
});

document.getElementById('petRegistrationStatus').addEventListener('change', () => {
    updateClearPetRegistrationFiltersVisibility();
    applyPetRegistrationFilters();
});

document.getElementById('petRegistrationSpecies').addEventListener('change', () => {
    updateClearPetRegistrationFiltersVisibility();
    applyPetRegistrationFilters();
});

document.getElementById('petRegistrationBarangay').addEventListener('change', () => {
    updateClearPetRegistrationFiltersVisibility();
    applyPetRegistrationFilters();
});

document.getElementById('petRegistrationPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${petRegistrationFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('petRegistrationTableContainer').innerHTML = data.html;
            document.getElementById('petRegistrationPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading pet registrations page:', error);
    });
});

updateClearPetRegistrationFiltersVisibility();
</script>
@endsection
