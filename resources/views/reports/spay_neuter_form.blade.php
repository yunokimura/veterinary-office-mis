@extends('layouts.admin')

@section('title', isset($report) ? 'Edit Spay/Neuter Report' : 'New Spay/Neuter Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ isset($report) ? 'Edit Spay/Neuter Report' : 'New Spay/Neuter Report' }}
        </h1>
        <a href="{{ route('spay-neuter.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($report) ? route('spay-neuter.reports.update', $report->id) : route('spay-neuter.reports.store') }}" method="POST">
                @csrf
                @if(isset($report))
                @method('PUT')
                @endif

                <div class="row">
                    <!-- Pet Information -->
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Pet Information</h5>

                        <div class="mb-3">
                            <label for="pet_id" class="form-label">Pet *</label>
                            <select class="form-control @error('pet_id') is-invalid @enderror" id="pet_id" name="pet_id" required>
                                <option value="">Select Pet</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->pet_id }}" {{ old('pet_id', isset($report) ? $report->pet_id : '') == $pet->pet_id ? 'selected' : '' }}>
                                        {{ $pet->pet_name }} ({{ $pet->owner->full_name ?? 'No Owner' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pet_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(isset($report) && $report->owner)
                        <div class="mb-3">
                            <label class="form-label">Owner (derived)</label>
                            <p class="form-control-static">{{ $report->owner->full_name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Barangay (derived)</label>
                            <p class="form-control-static">{{ $report->barangay?->barangay_name ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Procedure Information -->
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Procedure Information</h5>

                        <div class="mb-3">
                            <label for="procedure_type" class="form-label">Procedure Type *</label>
                            <select class="form-control @error('procedure_type') is-invalid @enderror" id="procedure_type" name="procedure_type" required>
                                <option value="">Select Procedure</option>
                                <option value="spay" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'spay' ? 'selected' : '' }}>Spay (Female)</option>
                                <option value="neuter" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'neuter' ? 'selected' : '' }}>Neuter (Male)</option>
                                <option value="both" {{ old('procedure_type', isset($report) ? $report->procedure_type : '') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('procedure_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">Procedure Date & Time *</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                   id="scheduled_at" name="scheduled_at" required
                                   value="{{ old('scheduled_at', isset($report) ? $report->scheduled_at?->format('Y-m-d\TH:i') : '' }}">
                            @error('scheduled_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="veterinarian" class="form-label">Veterinarian</label>
                            <select class="form-control @error('veterinarian') is-invalid @enderror" id="veterinarian" name="veterinarian">
                                <option value="">Auto-assign</option>
                                <option value="City Veterinarian" {{ old('veterinarian', isset($report) ? $report->veterinarian : '') == 'City Veterinarian' ? 'selected' : '' }}>City Veterinarian</option>
                                <option value="Assistant Veterinarian" {{ old('veterinarian', isset($report) ? $report->veterinarian : '') == 'Assistant Veterinarian' ? 'selected' : '' }}>Assistant Veterinarian</option>
                            </select>
                            @error('veterinarian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg) *</label>
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" name="weight" min="0" value="{{ old('weight', isset($report) ? $report->weight : '') }}" required>
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Status & Remarks -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Status</h5>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', isset($report) ? $report->status : 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="scheduled" {{ old('status', isset($report) ? $report->status : '') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ old('status', isset($report) ? $report->status : '') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', isset($report) ? $report->status : '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary mb-3">Remarks</h5>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="4">{{ old('remarks', isset($report) ? $report->remarks : '') }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-end gap-2">
                    <a href="{{ route('spay-neuter.reports.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($report) ? 'Update Report' : 'Submit Report' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
