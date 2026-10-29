@extends('layouts.admin')

@section('title', 'Inventory Control')
@section('header', 'Inventory Control')
@section('subheader', 'Track and manage inventory items and stock levels')

@section('content')
<div class="space-y-6">
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
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm hover:shadow-md">
                        <i class="bi bi-exclamation-triangle text-lg"></i>
                        <span class="font-medium">Low Stock ({{ $lowStockCount }})</span>
                    </a>
                    <a href="{{ route('admin-asst.inventory.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow-md">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span class="font-medium">Add Item</span>
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
