@extends('layouts.admin')

@section('title', 'Spay/Neuter (Kapon) Reports Management')
@section('header', 'Spay/Neuter (Kapon) Reports Management')
@section('subheader', 'View and manage all spay/neuter procedure reports')

@php
    $routePrefix = 'spay-neuter';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Page Header with Create Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">All Spay/Neuter Reports</h2>
            <p class="text-sm text-gray-500">Manage spay/neuter procedure records and KPI overview</p>
        </div>
        <a href="{{ route('spay-neuter.reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
            <i class="bi bi-plus-lg"></i>
            <span>New Report</span>
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Reports</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalReports) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Vaccinations</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($completed) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-medium text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($scheduled) }}</p>
            </div>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Spay/Neuter Reports</h3>
                <p class="text-sm text-gray-500">Search and filter spay/neuter procedure reports</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="px-6 py-3 border-b border-gray-100 bg-white flex flex-col sm:flex-row gap-3 items-end">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="spayNeuterSearchInput" value="{{ request('search') }}" placeholder="Search reports, pet..."
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

        <div id="reportsTableContainer">
            @include('reports.partials.spay-neuter-reports-table')
        </div>
        <div class="px-6 py-4 border-t border-gray-200" id="reportsPagination">
            {{ $reports->links() }}
        </div>
        <div id="reportsLoading" class="hidden px-6 py-4 border-t border-gray-200 text-center text-gray-500">
            <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-gray-300 border-t-green-600 mr-2"></span>
            Loading...
        </div>
        <div id="reportsEmptyState" class="hidden p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-shield-check text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No Reports Found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>
    </div>
</div>

<!-- Spay/Neuter Report Details Modal -->
<div id="spayNeuterDetailsModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-[1200] flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all scale-100 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-3 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight">Spay/Neuter Report Details</h5>
                        <span id="spayNeuterModalNumber" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-100 border border-emerald-200 whitespace-nowrap">#SN-00000</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-none" id="spayNeuterModalSubmitted">Submitted at: --</p>
                </div>
            </div>
            <button onclick="closeSpayNeuterModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Modal Content (Scrollable) -->
        <div class="p-4 space-y-4 overflow-y-auto flex-1 bg-white">
            <div id="spayNeuterDetailsModalContent">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                    <p class="text-slate-500 text-sm">Loading report details...</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
            <button onclick="window.print()" class="px-3 py-2 text-xs font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-xs transition-colors flex items-center justify-center space-x-1.5">
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm3 4v1h-5v-1a2 2 0 002-2h0a2 2 0 00-2-2V7a2 2 0 002-2h0a2 2 0 002 2v1h-5v1a2 2 0 002-2h0a2 2 0 00-2-2H9a2 2 0 00-2 2v1H6a2 2 0 00-2 2v1a2 2 0 002 2h12a2 2 0 002-2v-1a2 2 0 00-2-2z" /></svg>
                <span>Print</span>
            </button>
            <button onclick="closeSpayNeuterModal()" class="px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200/60 rounded-lg transition-colors">
                Done
            </button>
        </div>
    </div>
</div>

<script>
// Phase 5: Spay/Neuter report filter + modal JS will be injected here.
</script>
@endsection
