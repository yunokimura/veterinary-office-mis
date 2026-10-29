@extends('layouts.admin')

@section('title', 'Spay/Neuter Appointments')
@section('header', 'Spay/Neuter Appointments')
@section('subheader', 'Manage Spay/Neuter appointment schedules')

@section('content')
<div class="space-y-6">
    <!-- KPI Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Appointments</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['pending']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Scheduled</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['scheduled']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Completed</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['completed']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Cancelled</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['cancelled']) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Today</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['today']) }}</p>
            </div>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Spay/Neuter Appointments</h3>
                <p class="text-sm text-gray-500">Search and filter spay/neuter appointments</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="spayNeuterSearchInput" value="{{ request('search') }}" placeholder="Search pet, owner, vet, status..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
            <div class="flex gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">From Date</label>
                    <input type="date" id="dateFrom" value="{{ request('date_from') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">To Date</label>
                    <input type="date" id="dateTo" value="{{ request('date_to') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
            </div>
            <button type="button" id="clearSpayNeuterFiltersBtn" onclick="clearSpayNeuterFilters()"
                    class="px-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm text-red-600 hover:bg-red-50 whitespace-nowrap hidden">
                <i class="bi bi-x-circle mr-1"></i>Clear Filters
            </button>
        </div>

        <div id="spayNeuterTableContainer">
            @include('reports.partials.spay-neuter-reports-table')
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="spayNeuterPagination">
            {{ $reports->links() }}
        </div>
        <div id="spayNeuterLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="spayNeuterEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-calendar-x text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Appointments Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Spay/Neuter Appointment Details Modal -->
<div id="spayNeuterDetailsModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <i class="bi bi-heart-pulse w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Appointment Details</h2>
                    <p class="text-xs text-slate-400">ID: <span id="spayNeuterModalId" class="font-mono font-semibold text-slate-600">#SN-2026-0010</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span id="spayNeuterModalStatus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"></span>
                <button onclick="closeSpayNeuterModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="bi bi-x w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-6 space-y-5 overflow-y-auto bg-white max-h-[calc(90vh-140px)]">
            <div id="spayNeuterModalContent">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading appointment details...</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer / Actions -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button onclick="window.print()" class="w-full sm:w-auto px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                    <i class="bi bi-printer w-3.5 h-3.5"></i>
                    <span>Print</span>
                </button>
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <button onclick="closeSpayNeuterModal()" class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Spay/Neuter Appointment Modal -->
<div class="modal fade" id="editSpayNeuterModal" tabindex="-1" aria-labelledby="editSpayNeuterModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpayNeuterModalTitle">Edit Appointment</h5>
                <button type="button" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" data-bs-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body" id="editSpayNeuterModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-green-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    // --- Phase 4: Filter & Details Modal JS ---

    let spayNeuterSearchDebounce;
    const spayNeuterFilterUrl = `{{ route('spay-neuter.reports.filter') }}`;

    function escapeHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function getSpayNeuterFilterParams() {
        return {
            search: document.getElementById('spayNeuterSearchInput').value,
            date_from: document.getElementById('dateFrom').value,
            date_to: document.getElementById('dateTo').value,
        };
    }

    function applySpayNeuterFilters() {
        const params = getSpayNeuterFilterParams();
        const tableContainer = document.getElementById('spayNeuterTableContainer');
        const paginationContainer = document.getElementById('spayNeuterPagination');
        const loadingEl = document.getElementById('spayNeuterLoading');
        const emptyState = document.getElementById('spayNeuterEmptyState');

        if (loadingEl) loadingEl.classList.remove('hidden');
        if (tableContainer) tableContainer.style.opacity = '0.3';
        if (paginationContainer) paginationContainer.style.opacity = '0.3';

        const query = new URLSearchParams();
        Object.entries(params).forEach(([key, value]) => {
            if (value) query.append(key, value);
        });

        fetch(`${spayNeuterFilterUrl}?${query.toString()}`, {
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
            console.error('Error filtering spay/neuter reports:', error);
            if (tableContainer) tableContainer.style.opacity = '1';
            if (paginationContainer) paginationContainer.style.opacity = '1';
        })
        .finally(() => {
            if (loadingEl) loadingEl.classList.add('hidden');
        });
    }

    function clearSpayNeuterFilters() {
        document.getElementById('spayNeuterSearchInput').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        updateClearSpayNeuterFiltersVisibility();
        applySpayNeuterFilters();
    }

    function updateClearSpayNeuterFiltersVisibility() {
        const searchInput = document.getElementById('spayNeuterSearchInput');
        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');
        const clearBtn = document.getElementById('clearSpayNeuterFiltersBtn');

        const hasFilters = (searchInput && searchInput.value.trim() !== '') ||
                           (dateFrom && dateFrom.value.trim() !== '') ||
                           (dateTo && dateTo.value.trim() !== '');

        if (clearBtn) {
            if (hasFilters) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }
    }

    document.getElementById('spayNeuterSearchInput').addEventListener('input', () => {
        clearTimeout(spayNeuterSearchDebounce);
        spayNeuterSearchDebounce = setTimeout(() => {
            updateClearSpayNeuterFiltersVisibility();
            applySpayNeuterFilters();
        }, 300);
    });

    document.getElementById('dateFrom').addEventListener('change', () => {
        updateClearSpayNeuterFiltersVisibility();
        applySpayNeuterFilters();
    });

    document.getElementById('dateTo').addEventListener('change', () => {
        updateClearSpayNeuterFiltersVisibility();
        applySpayNeuterFilters();
    });

    document.getElementById('spayNeuterPagination').addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        e.preventDefault();
        const url = new URL(link.href);
        const query = url.searchParams.toString();

        fetch(`${spayNeuterFilterUrl}?${query}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('spayNeuterTableContainer').innerHTML = data.html;
                document.getElementById('spayNeuterPagination').innerHTML = data.pagination;
            }
        })
        .catch(error => {
            console.error('Error loading spay/neuter reports page:', error);
        });
    });

    function openSpayNeuterModal(reportId) {
        const backdrop = document.getElementById('spayNeuterDetailsModalBackdrop');
        const content = document.getElementById('spayNeuterModalContent');

        content.innerHTML = `
            <div class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                <p class="text-slate-500 text-sm">Loading appointment details...</p>
            </div>
        `;
        document.getElementById('spayNeuterModalId').textContent = '#SN-' + String(reportId).padStart(4, '0');
        document.getElementById('spayNeuterModalStatus').className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold';
        document.getElementById('spayNeuterModalStatus').innerHTML = '';
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
        }, 10);

        fetch(`{{ route('spay-neuter.reports.show-json', ':id') }}`.replace(':id', reportId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displaySpayNeuterDetails(data.report);
                } else {
                    content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
                }
            })
            .catch(() => {
                content.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment details.</div>';
            });
    }

    function closeSpayNeuterModal() {
        const backdrop = document.getElementById('spayNeuterDetailsModalBackdrop');
        backdrop.classList.add('opacity-0');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 200);
    }

    function displaySpayNeuterDetails(report) {
        const content = document.getElementById('spayNeuterModalContent');
        const numberEl = document.getElementById('spayNeuterModalId');
        if (numberEl) numberEl.textContent = '#SN-' + String(report.id).padStart(5, '0');

        const statusBadgeClass = getSpayNeuterStatusBadgeClasses(report.status);
        const statusLabel = report.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
        const statusEl = document.getElementById('spayNeuterModalStatus');
        if (statusEl) {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border ' + statusBadgeClass;
            statusEl.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5 animate-pulse"></span>${escapeHtml(statusLabel)}`;
        }

        content.innerHTML = `
            <div class="p-3 space-y-4">
                <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                    <div class="bg-emerald-600 px-4 py-2.5 flex items-center gap-2 border-b border-emerald-500/50">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Spay/Neuter Details</h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Procedure Date</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.scheduled_at || '--')}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M3 17.364l.707-.707M13 17.364l.707.707M17 12h-.707m0 0l-.707-.707M17 7l-.707-.707M13 7l.707.707M13 17l-.707.707" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Weight</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${report.weight ? report.weight + ' kg' : 'N/A'}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Procedure Type</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.procedure_type)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 11.969A5 5 0 0110.474 8H12a5 5 0 014.9 5.969L12 18l-4.9-5.969zM12 14a1 1 0 100-2 1 1 0 000 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Status</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5 capitalize">${escapeHtml(report.status)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Veterinarian</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.veterinarian)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0 border border-emerald-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21v-1a2 2 0 00-2-2v-3a2 2 0 012-2h6a2 2 0 012 2v3a2 2 0 00-2 2v1z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Remarks</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${escapeHtml(report.remarks || 'N/A')}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                    <div class="bg-yellow-600 px-4 py-2.5 flex items-center gap-2 border-b border-yellow-500/50">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2M11 15h2m0 0h2m0 0l2 2m-2-2v2h-2v-2m-2 2l-2-2m-2 2v2H7v-2m-2 2l-2-2M7 17a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2a2 2 0 012-2zm0-2v2a2 2 0 00-2 2H5a2 2 0 01-2-2v-2a2 2 0 012-2h2a2 2 0 002-2zM7 7v2l2 2m2-2l2-2m2 2l2 2m-2-2H7z" /></svg>
                        <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Pet Information</h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4l2 2m0 0l-2 2m-2 2l-2-2m2 2l2 2m0 0l-2 2m-2 2l2 2m0 0l2-2m-2-2l-2-2m-2 2l-2 2m0 0l2 2m0 0l-2-2m-2 2l-2-2m2 2l2-2m0 0l-2 2m-2 2l-2-2m2 2l2-2" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Pet Name</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.pet_name)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Species</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.pet_species)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v4m0 2m-4 3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Breed</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.pet_breed)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Age</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.pet_age)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg shrink-0 border border-yellow-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21v-1a2 2 0 00-2-2v-3a2 2 0 012-2h6a2 2 0 012 2v3a2 2 0 00-2 2v1z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Gender</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.pet_gender)}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white">
                    <div class="bg-purple-600 px-4 py-2.5 flex items-center gap-2 border-b border-purple-500/50">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <h3 class="text-[11px] font-semibold text-white uppercase tracking-wider">Owner Information</h3>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Owner Name</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.patient_name)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 011 1.726D7.848 9.648 5 11.618 5 13.25v2.5a1 1 0 01-1 1v3.5a1 1 0 001 1H6a1 1 0 011-1v-2.5a2 2 0 002-2h4a2 2 0 002 2v2.5a1 1 0 001 1V19a1 1 0 01-1-1h-2.318c.173.448.285.952.285 1.5v2.5a1 1 0 001 1h4a1 1 0 001-1v-3.5a1 1 0 01-1-1V13.25c0-.592-.235-1.156-.598-1.608L13 11.618C12.686 9.421 13 7.786 13 6h1.72c.553.229.894.762.997 1.336l.164 1.09c.043.286.07.576.078.866.006.21-.009.422-.048.629l-.075.412c-.045.242-.089.484-.147.721L12 18c-.184.72-.574 1.344-1.05 1.772a1 1 0 01-1.5.318L8 18.707A7 7 0 015 13c0-1.45.39-2.82 1.094-3.978l1.01-.999A1 1 0 017 9h4a1 1 0 011 1 .993.993 0 01-.293.707L11 11.414V13a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1.586z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Contact</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.patient_contact)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 col-span-2">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-2.828-2.828a1.998 1.998 0 010-2.828l4.244-4.243a9 9 0 111.414 1.414z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Address</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5 whitespace-pre-wrap">${escapeHtml(report.patient_address)}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg shrink-0 border border-purple-100">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Barangay</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">${escapeHtml(report.barangay)}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        lucide.createIcons();
    }

    function getSpayNeuterStatusBadgeClasses(status) {
        const map = {
            'pending': 'bg-yellow-100 text-yellow-700',
            'scheduled': 'bg-blue-100 text-blue-700',
            'completed': 'bg-green-100 text-green-700',
            'cancelled': 'bg-red-100 text-red-700',
        };
        return map[status.toLowerCase()] || 'bg-gray-100 text-gray-700';
    }

    // --- Phase 5: Edit Modal & Status Update JS ---

    function editSpayNeuter(reportId) {
        const modalEl = document.getElementById('editSpayNeuterModal');
        const modalBody = document.getElementById('editSpayNeuterModalBody');
        const modal = new bootstrap.Modal(modalEl);

        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-green-600" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modal.show();

        fetch(`{{ route('spay-neuter.reports.show-json', ':id') }}`.replace(':id', reportId), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment data.</div>';
                return;
            }

            const r = data.report;

            modalBody.innerHTML = `
                <form id="editSpayNeuterForm" onsubmit="submitEditSpayNeuterForm(event, ${escapeHtml(String(r.id))})">
                    <div class="space-y-5">
                        <div class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/40">
                            <h3 class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Schedule &amp; Status</h3>
                            <div class="flex gap-4">
                                <div class="flex-1 flex items-start space-x-3">
                                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-xs text-slate-400">Scheduled Date &amp; Time</p>
                                        <input type="datetime-local" name="scheduled_at" value="${escapeHtml(r.scheduled_at ? r.scheduled_at.slice(0, 16) : '')}" required
                                               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>
                                <div class="flex-1 flex items-start space-x-3">
                                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0 border border-indigo-100">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-xs text-slate-400">Appointment Status</p>
                                        <select name="status" required
                                                class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="pending" ${r.status === 'pending' ? 'selected' : ''}>Pending</option>
                                            <option value="scheduled" ${r.status === 'scheduled' ? 'selected' : ''}>Scheduled</option>
                                            <option value="completed" ${r.status === 'completed' ? 'selected' : ''}>Completed</option>
                                            <option value="cancelled" ${r.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border border-slate-200/80 rounded-xl p-4 bg-slate-50/40">
                            <h3 class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3">Remarks</h3>
                            <textarea name="remarks" rows="3"
                                      class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">${escapeHtml(r.remarks || '')}</textarea>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg shadow-sm transition-colors flex items-center gap-1.5 whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            `;
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="text-center text-red-600 py-4">Failed to load appointment data.</div>';
        });
    }

    function submitEditSpayNeuterForm(event, reportId) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const data = {
            scheduled_at: formData.get('scheduled_at'),
            status: formData.get('status'),
            remarks: formData.get('remarks'),
        };

        const url = `{{ route('spay-neuter.reports.update', ':id') }}`.replace(':id', reportId);

        fetch(url, {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modalEl = document.getElementById('editSpayNeuterModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                applySpayNeuterFilters();
            } else {
                alert('Failed to update appointment. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update appointment. Please try again.');
        });
    }

    function updateSpayNeuterStatus(reportId, newStatus) {
        if (!confirm(`Are you sure you want to change the status to "${newStatus.replace('_', ' ').toUpperCase()}"?`)) {
            return;
        }

        const url = `{{ route('spay-neuter.reports.update', ':id') }}`.replace(':id', reportId);

        fetch(url, {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                applySpayNeuterFilters();
            } else {
                alert('Failed to update status. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update status. Please try again.');
        });
    }
</script>
@endpush

@endsection
