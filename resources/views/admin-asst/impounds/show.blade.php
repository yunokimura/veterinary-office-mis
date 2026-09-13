@extends('layouts.admin')

@section('title', 'Impound Record Details')
@section('header', 'Impound Record Details')
@section('subheader', 'View and manage impound details')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><i class="bi bi-archive me-2"></i>Impound Record #{{ $impound->impound_id }}</h2>
            <p class="text-gray-500 text-sm">View and manage impound details</p>
        </div>
        <a href="{{ route('admin-asst.impounds.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Impound Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h4 class="font-semibold text-gray-800">Impound Details</h4>
                    @php
                        $badgeClass = match($impound->current_disposition) {
                            'impounded' => 'bg-yellow-100 text-yellow-800',
                            'adopted' => 'bg-green-100 text-green-800',
                            'claimed' => 'bg-blue-100 text-blue-800',
                            'euthanized' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                        {{ ucfirst($impound->current_disposition) }}
                    </span>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-gray-500 w-48">Impound ID:</td>
                            <td class="py-3 font-medium">#{{ $impound->impound_id }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-gray-500">Animal Tag Code:</td>
                            <td class="py-3">{{ $impound->animal_tag_code ?? 'Not assigned' }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-gray-500">Intake Condition:</td>
                            <td class="py-3">{{ ucfirst($impound->intake_condition ?? 'Unknown') }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-gray-500">Intake Location:</td>
                            <td class="py-3">{{ $impound->intake_location ?? 'Not specified' }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 text-gray-500">Intake Date:</td>
                            <td class="py-3">{{ $impound->intake_date ? $impound->intake_date->format('M d, Y h:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 text-gray-500">Current Disposition:</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($impound->current_disposition) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Status History -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800"><i class="bi bi-clock-history me-2"></i>Status History</h4>
                </div>
                <div class="p-6">
                    @if($impound->statusHistory && $impound->statusHistory->count() > 0)
                        <div class="space-y-4">
                            @foreach($impound->statusHistory->sortBy('change_date') as $history)
                                @php
                                    $markerClass = match($history->status) {
                                        'adopted' => 'bg-green-500',
                                        'claimed' => 'bg-blue-500',
                                        'euthanized' => 'bg-red-500',
                                        default => 'bg-yellow-500'
                                    };
                                @endphp
                                <div class="flex gap-4">
                                    <div class="w-3 h-3 rounded-full {{ $markerClass }} mt-1.5 flex-shrink-0"></div>
                                    <div class="flex-1">
                                        <h6 class="font-medium text-gray-800 mb-1 capitalize">{{ str_replace('_', ' ', $history->status) }}</h6>
                                        <p class="text-sm text-gray-500">{{ $history->change_date->format('M d, Y h:i A') }}</p>
                                        @if($history->notes)
                                            <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No status history available.</p>
                    @endif
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Update Disposition -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800"><i class="bi bi-arrow-repeat me-2"></i>Update Disposition</h4>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin-asst.impounds.update', $impound) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Disposition</label>
                            <select name="current_disposition" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="impounded" {{ $impound->current_disposition == 'impounded' ? 'selected' : '' }}>Impounded</option>
                                <option value="claimed" {{ $impound->current_disposition == 'claimed' ? 'selected' : '' }}>Claimed</option>
                                <option value="adopted" {{ $impound->current_disposition == 'adopted' ? 'selected' : '' }}>Adopted</option>
                                <option value="transferred" {{ $impound->current_disposition == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="euthanized" {{ $impound->current_disposition == 'euthanized' ? 'selected' : '' }}>Euthanized</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" rows="2" placeholder="Add notes..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="bi bi-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800"><i class="bi bi-info-circle me-2"></i>Summary</h4>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <tr class="border-b border-gray-100">
                            <td class="py-2 text-gray-500">Record Created:</td>
                            <td class="py-2 text-right">{{ $impound->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 text-gray-500">Days in Shelter:</td>
                            <td class="py-2 text-right">{{ $impound->intake_date ? $impound->intake_date->diffInDays(now()) : 'N/A' }} days</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection