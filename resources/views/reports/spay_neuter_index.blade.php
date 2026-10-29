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

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush

@endsection
