@extends('layouts.admin')

@section('title', 'Inventory Control')
@section('header', 'Inventory Control')
@section('subheader', 'Track and manage inventory items and stock levels')

@section('content')
<div class="space-y-6">
    <!-- KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">

        <!-- Card 1: Total Tracked Items -->
        <div class="bg-white rounded-xl shadow-sm p-3 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-8 flex items-center mb-2">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider leading-tight">
                    Total Tracked Items
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-2 border-b border-slate-100">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalItems }}</span>
                    <span class="text-[10px] font-medium text-slate-500">Items tracked</span>
                </div>
                <div class="pt-2 grid grid-cols-2 gap-1">
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-semibold bg-slate-50 text-slate-700 border border-slate-200/60 flex items-center justify-between">
                        <span>Categories:</span> <span class="font-bold">{{ $categoryCount }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2: Low Stock Items -->
        <div class="bg-white rounded-xl shadow-sm p-3 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-8 flex items-center mb-2">
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider leading-tight">
                    Low Stock Items
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-2 border-b border-slate-100">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $lowStockCount }}</span>
                    <span class="text-[10px] font-medium text-slate-500">Below minimum</span>
                </div>
                <div class="pt-2 grid grid-cols-2 gap-1">
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-semibold bg-red-50 text-red-700 border border-red-200/60 flex items-center justify-between">
                        <span>Out of Stock:</span> <span class="font-bold">{{ $outOfStockCount }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Inventory Value -->
        <div class="bg-white rounded-xl shadow-sm p-3 border border-gray-100 flex flex-col justify-between h-full">
            <div class="h-8 flex items-center mb-2">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider leading-tight">
                    Total Inventory Value
                </span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex items-baseline space-x-2 pb-2 border-b border-slate-100">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">₱{{ number_format($totalValue, 2) }}</span>
                    <span class="text-[10px] font-medium text-slate-500">Updated today</span>
                </div>
                <div class="pt-2 grid grid-cols-2 gap-1">
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 flex items-center justify-between">
                        <span>Avg Cost:</span> <span class="font-bold">₱{{ number_format($avgCost, 2) }}</span>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Header + Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Inventory Control</h3>
                    <p class="text-sm text-gray-500">Track and manage inventory items and stock levels</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin-asst.inventory.low-stock') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm hover:shadow-md">
                        <i class="bi bi-exclamation-triangle text-base"></i>
                        <span class="text-sm font-medium">Low Stock ({{ $lowStockCount }})</span>
                    </a>
                    <a href="{{ route('admin-asst.inventory.create') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
                        <i class="bi bi-plus-circle text-base"></i>
                        <span class="text-sm font-medium">Add Item</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="inventorySearchInput" value="{{ request('search') }}" placeholder="Search item name..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                    <select name="category" id="inventoryCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">All Categories</option>
                        <option value="vaccines" {{ request('category') == 'vaccines' ? 'selected' : '' }}>Vaccines</option>
                        <option value="medicines" {{ request('category') == 'medicines' ? 'selected' : '' }}>Medicines</option>
                        <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                    </select>
                </div>
            </div>
            <button type="button" id="clearInventoryFiltersBtn" onclick="clearInventoryFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="inventoryTableContainer">
            @include('admin-asst.inventory._table', ['items' => $items])
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="inventoryPagination">
            <div class="flex items-center justify-center">
                {{ $items->withQueryString()->links() }}
            </div>
        </div>
        <div id="inventoryLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-emerald-600 mr-2"></span>
            Loading...
        </div>
        <div id="inventoryEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-box text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Inventory Items Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<script>
let inventorySearchDebounce;
const inventoryFilterUrl = '{{ route('admin-asst.inventory.index') }}';

function getInventoryFilterParams() {
    return {
        search: document.getElementById('inventorySearchInput').value,
        category: document.getElementById('inventoryCategory').value,
    };
}

function applyInventoryFilters() {
    const params = getInventoryFilterParams();
    const tableContainer = document.getElementById('inventoryTableContainer');
    const paginationContainer = document.getElementById('inventoryPagination');
    const loadingEl = document.getElementById('inventoryLoading');
    const emptyState = document.getElementById('inventoryEmptyState');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (tableContainer) tableContainer.style.opacity = '0.3';
    if (paginationContainer) paginationContainer.style.opacity = '0.3';

    const query = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
        if (value) query.append(key, value);
    });

    fetch(`${inventoryFilterUrl}?${query.toString()}`, {
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
        console.error('Error filtering inventory:', error);
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    })
    .finally(() => {
        if (loadingEl) loadingEl.classList.add('hidden');
    });
}

function clearInventoryFilters() {
    document.getElementById('inventorySearchInput').value = '';
    document.getElementById('inventoryCategory').value = '';
    updateClearInventoryFiltersVisibility();
    applyInventoryFilters();
}

function updateClearInventoryFiltersVisibility() {
    const searchInput = document.getElementById('inventorySearchInput');
    const categorySelect = document.getElementById('inventoryCategory');
    const clearBtn = document.getElementById('clearInventoryFiltersBtn');

    const hasFilters = (searchInput && searchInput.value.trim() !== '') ||
                       (categorySelect && categorySelect.value !== '');

    if (clearBtn) {
        if (hasFilters) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }
}

document.getElementById('inventorySearchInput').addEventListener('input', () => {
    clearTimeout(inventorySearchDebounce);
    inventorySearchDebounce = setTimeout(() => {
        updateClearInventoryFiltersVisibility();
        applyInventoryFilters();
    }, 300);
});

document.getElementById('inventoryCategory').addEventListener('change', () => {
    updateClearInventoryFiltersVisibility();
    applyInventoryFilters();
});

document.getElementById('inventoryPagination').addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    e.preventDefault();
    const url = new URL(link.href);
    const query = url.searchParams.toString();

    fetch(`${inventoryFilterUrl}?${query}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('inventoryTableContainer').innerHTML = data.html;
            document.getElementById('inventoryPagination').innerHTML = data.pagination;
        }
    })
    .catch(error => {
        console.error('Error loading inventory page:', error);
    });
});

updateClearInventoryFiltersVisibility();
</script>
@endsection
