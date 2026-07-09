@extends('layouts.admin')

@section('title', isset($report) ? 'Edit Spay/Neuter Appointment' : 'New Spay/Neuter Appointment')
@section('header', isset($report) ? 'Edit Spay/Neuter Appointment' : 'New Spay/Neuter Appointment')
@section('subheader', isset($report) ? 'Update appointment details' : 'Create a new spay/neuter appointment')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('spay-neuter.reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Appointments</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">
                {{ isset($report) ? 'Update Appointment' : 'New Appointment Details' }}
            </h3>
            <p class="text-sm text-gray-500">Fill in the required information below</p>
        </div>

        <div class="p-6">
            <form action="{{ isset($report) ? route('spay-neuter.reports.update', $report->id) : route('spay-neuter.reports.store') }}" method="POST">
                @csrf
                @if(isset($report))
                @method('PUT')
                @endif

                <!-- Pet Information Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-2">
                        <i class="bi bi-paw"></i>
                        <span>Pet Information</span>
                    </h4>
                    <div class="bg-gray-50 rounded-lg p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="pet_id" class="block text-sm font-medium text-gray-700 mb-1">Pet <span class="text-red-500">*</span></label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('pet_id') border-red-500 @enderror" id="pet_id" name="pet_id" required>
                                    <option value="">Select Pet</option>
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->pet_id }}" {{ old('pet_id', isset($report) ? $report->pet_id : '') == $pet->pet_id ? 'selected' : '' }}>
                                            {{ $pet->pet_name }} ({{ $pet->owner->full_name ?? 'No Owner' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pet_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(isset($report) && $report->owner)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Owner (derived)</label>
                                <p class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg">{{ $report->owner->full_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Barangay (derived)</label>
                                <p class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg">{{ $report->barangay?->barangay_name ?? 'N/A' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Procedure Information Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-2">
                        <i class="bi bi-file-medical"></i>
                        <span>Procedure Information</span>
                    </h4>
                    <div class="bg-gray-50 rounded-lg p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="procedure_type" class="block text-sm font-medium text-gray-700 mb-1">Procedure Type <span class="text-red-500">*</span></label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('procedure_type') border-red-500 @enderror" id="procedure_type" name="procedure_type" required>
                                    <option value="">Select Procedure</option>
                                    <option value="spay" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'spay' ? 'selected' : '' }}>Spay (Female)</option>
                                    <option value="neuter" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'neuter' ? 'selected' : '' }}>Neuter (Male)</option>
                                    <option value="both" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                                @error('procedure_type')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">Procedure Date & Time <span class="text-red-500">*</span></label>
                                <input type="datetime-local" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('scheduled_at') border-red-500 @enderror" 
                                       id="scheduled_at" name="scheduled_at" required
                                       value="{{ old('scheduled_at', isset($report) ? $report->scheduled_at?->format('Y-m-d\TH:i') : '') }}">
                                @error('scheduled_at')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="veterinarian" class="block text-sm font-medium text-gray-700 mb-1">Veterinarian</label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('veterinarian') border-red-500 @enderror" id="veterinarian" name="veterinarian">
                                    <option value="">Auto-assign</option>
                                    <option value="City Veterinarian" {{ old('veterinarian', isset($report) ? $report->veterinarian : '') == 'City Veterinarian' ? 'selected' : '' }}>City Veterinarian</option>
                                    <option value="Assistant Veterinarian" {{ old('veterinarian', isset($report) ? $report->veterinarian : '') == 'Assistant Veterinarian' ? 'selected' : '' }}>Assistant Veterinarian</option>
                                </select>
                                @error('veterinarian')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('weight') border-red-500 @enderror" 
                                       id="weight" name="weight" min="0" value="{{ old('weight', isset($report) ? $report->weight : '') }}" required>
                                @error('weight')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status & Remarks Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle"></i>
                        <span>Status & Remarks</span>
                    </h4>
                    <div class="bg-gray-50 rounded-lg p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('status') border-red-500 @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', isset($report) ? $report->status : 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="scheduled" {{ old('status', isset($report) ? $report->status : '') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ old('status', isset($report) ? $report->status : '') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', isset($report) ? $report->status : '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                                <textarea class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('remarks') border-red-500 @enderror" 
                                          id="remarks" name="remarks" rows="4" placeholder="Optional notes...">{{ old('remarks', isset($report) ? $report->remarks : '') }}</textarea>
                                @error('remarks')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('spay-neuter.reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="bi bi-x"></i>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                        <i class="bi bi-check-lg"></i>
                        <span>{{ isset($report) ? 'Update Appointment' : 'Submit Appointment' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection