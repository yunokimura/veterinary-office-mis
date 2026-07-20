@extends('layouts.admin')

@section('title', 'Owner Details')
@section('header', 'Owner Details')
@section('subheader', 'View pet owner information and registered pets')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin-asst.owners.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Owners
        </a>
    </div>

    <div class="row">
        <!-- Owner Information -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">{{ $owner->name }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 140px;">Email</td>
                            <td>{{ $owner->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Contact</td>
                            <td>{{ $owner->contact_number ?? 'N/A' }}</td>
                        </tr>
                        @if($petOwner && $petOwner->address)
                        <tr>
                            <td class="text-muted">Address</td>
                            <td>
                                {{ $petOwner->blk_lot_ph }}, {{ $petOwner->street }}<br>
                                {{ $petOwner->barangay }}, {{ $petOwner->city }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Registered</td>
                            <td>{{ $owner->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Pets</td>
                            <td>{{ $owner->pets->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Registered Pets -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Registered Pets</h5>
                    <a href="{{ route('admin-asst.pet-registrations.create') }}?owner_id={{ $owner->id }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-1"></i> Add Pet
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">Pet Name</th>
                                    <th class="px-4 py-3">Species</th>
                                    <th class="px-4 py-3">Breed</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($owner->pets as $pet)
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="fw-medium">{{ $pet->name }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ ucfirst($pet->species) }}</td>
                                    <td class="px-4 py-3">{{ $pet->breed ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($pet->vaccination_status === 'vaccinated')
                                            <span class="badge bg-success">Vaccinated</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin-asst.pet-registrations.show', $pet) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-muted">
                                        <i class="bi bi-inbox text-4xl mb-2 d-block"></i>
                                        <p>No pets registered yet</p>
                                        <a href="{{ route('admin-asst.pet-registrations.create') }}?owner_id={{ $owner->id }}" class="text-emerald-600 hover:text-emerald-700">
                                            Register a pet for this owner
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
