@extends('layouts.admin')

@section('title', 'Spay/Neuter (Kapon) Report')
@section('header', 'Spay/Neuter (Kapon) Report')
@section('subheader', 'Kapon Program Procedure Records')

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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Reports</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalReports) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($completed) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Scheduled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($scheduled) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Pending / Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($pending) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 md:p-6">
            <form method="GET" action="{{ route('spay-neuter.reports.all') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Procedure</label>
                    <select name="procedure_type" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">All Procedures</option>
                        <option value="spay" {{ request('procedure_type') == 'spay' ? 'selected' : '' }}>Spay</option>
                        <option value="neuter" {{ request('procedure_type') == 'neuter' ? 'selected' : '' }}>Neuter</option>
                        <option value="both" {{ request('procedure_type') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pet Type</label>
                    <select name="pet_type" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">All Pets</option>
                        <option value="dog" {{ request('pet_type') == 'dog' ? 'selected' : '' }}>Dog</option>
                        <option value="cat" {{ request('pet_type') == 'cat' ? 'selected' : '' }}>Cat</option>
                        <option value="other" {{ request('pet_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div class="flex items-end gap-2 lg:col-span-5">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                        <i class="bi bi-funnel"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('spay-neuter.reports.all') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="bi bi-x-circle"></i>
                        <span>Clear</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Owner Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pet</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Procedure</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-900 font-medium whitespace-nowrap">{{ $report->scheduled_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $report->owner_name ?? $report->owner->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 text-gray-700">
                                <i class="bi bi-paw text-gray-400"></i>
                                {{ $report->pet->pet_name ?? 'N/A' }}
                                <span class="text-xs text-gray-400 ml-1">({{ ucfirst($report->pet->species ?? 'other') }})</span>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($report->procedure_type == 'spay')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                Spay (F)
                            </span>
                            @elseif($report->procedure_type == 'neuter')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Neuter (M)
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Both
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($report->status == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                Completed
                            </span>
                            @elseif($report->status == 'scheduled')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                Scheduled
                            </span>
                            @elseif($report->status == 'cancelled')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                Cancelled
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('spay-neuter.reports.show', $report->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('spay-neuter.reports.edit', $report->id) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('spay-neuter.reports.destroy', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="bi bi-calendar-x text-4xl text-gray-300"></i>
                                <p class="text-gray-500 font-medium">No spay/neuter reports found</p>
                                <p class="text-gray-400 text-sm">Try adjusting your filters or create a new report.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $reports->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
