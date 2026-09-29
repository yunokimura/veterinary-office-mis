@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-alt me-2"></i>Application Details</h2>
        <a href="{{ route('admin-asst.adoption-applications.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Applicant Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4 text-muted">Name</div>
                        <div class="col-sm-8">{{ $application->first_name }} {{ $application->last_name }}</div>

                        <div class="col-sm-4 text-muted">Email</div>
                        <div class="col-sm-8">{{ $application->email }}</div>

                        <div class="col-sm-4 text-muted">Mobile Number</div>
                        <div class="col-sm-8">{{ $application->mobile_number }}</div>

                        @if($application->alt_mobile_number)
                        <div class="col-sm-4 text-muted">Alt Mobile</div>
                        <div class="col-sm-8">{{ $application->alt_mobile_number }}</div>
                        @endif

                        <div class="col-sm-4 text-muted">Address</div>
                        <div class="col-sm-8">
                            {{ $application->blk_lot_ph }} {{ $application->street }}<br>
                            {{ $application->barangay }}
                        </div>

                        <div class="col-sm-4 text-muted">Birth Date</div>
                        <div class="col-sm-8">{{ $application->birth_date ? $application->birth_date->format('M d, Y') : 'N/A' }}</div>

                        <div class="col-sm-4 text-muted">Occupation</div>
                        <div class="col-sm-8">{{ $application->occupation ?? 'N/A' }}</div>

                        @if($application->company)
                        <div class="col-sm-4 text-muted">Company</div>
                        <div class="col-sm-8">{{ $application->company }}</div>
                        @endif

                        @if($application->social_media)
                        <div class="col-sm-4 text-muted">Social Media</div>
                        <div class="col-sm-8">{{ $application->social_media }}</div>
                        @endif

                        <div class="col-sm-4 text-muted">Marital Status</div>
                        <div class="col-sm-8">{{ $application->marital_status ?? 'N/A' }}</div>

                        <div class="col-sm-4 text-muted">Adopted Before</div>
                        <div class="col-sm-8">{{ $application->adopted_before ? 'Yes' : 'No' }}</div>

                        <div class="col-sm-4 text-muted">Submitted</div>
                        <div class="col-sm-8">{{ $application->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            @if($application->questionnaire)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Questionnaire Responses</h5>
                </div>
                <div class="card-body">
                    @php
                        $q = $application->questionnaire;
                        $items = [
                            'Housing Type' => $q['housing_type'] ?? null,
                            'Housing Ownership' => $q['housing_ownership'] ?? null,
                            'Household Members' => isset($q['household_members']) && is_array($q['household_members']) ? implode(', ', $q['household_members']) : null,
                            'Household Agreement' => $q['household_agreement'] ?? null,
                            'Pet Allergies' => $q['pet_allergies'] ?? null,
                            'Primary Caregiver' => $q['primary_caregiver'] ?? null,
                            'Time Alone' => $q['time_alone'] ?? null,
                            'Relocation Plan' => $q['relocation_plan'] ?? null,
                            'Current Pets' => $q['current_pets'] ?? null,
                            'Past Pet Experience' => $q['past_pet_experience'] ?? null,
                            'Vaccination Stance' => $q['vaccination_stance'] ?? null,
                        ];
                    @endphp

                    <div class="row g-2">
                        @foreach($items as $label => $value)
                            @if($value)
                                <div class="col-sm-4 text-muted">{{ $label }}</div>
                                <div class="col-sm-8 mb-2">{{ $value }}</div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($application->appointment_date || $application->appointment_time)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Adoption Appointment</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4 text-muted">Date</div>
                        <div class="col-sm-8">{{ $application->appointment_date ? \Carbon\Carbon::parse($application->appointment_date)->format('F d, Y') : 'Not set' }}</div>

                        <div class="col-sm-4 text-muted">Time</div>
                        <div class="col-sm-8">{{ $application->appointment_time ? \Carbon\Carbon::createFromFormat('H:i:s', $application->appointment_time)->format('h:i A') : 'Not set' }}</div>
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($application->questionnaire['home_photos']))
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Home Photos</h5>
                </div>
                <div class="card-body">
                    @php
                        $photos = collect($application->questionnaire['home_photos'])->flatten()->filter()->values();
                    @endphp

                    @if($photos->count())
                        <div class="row g-2">
                            @foreach($photos as $path)
                                @php
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                <div class="col-4 col-sm-3">
                                    @if($isImage)
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $path) }}" alt="Home photo" class="w-100 rounded border border-gray-200" style="height: 96px; object-fit: cover;">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="d-flex align-items-center justify-content-center border border-gray-200 rounded" style="height: 96px;">
                                            <span class="text-muted small">Document</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No home photos uploaded.</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body text-center">
                    @switch($application->status)
                        @case('pending_review')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending Review</span>
                            @break
                        @case('approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                            @break
                        @case('rejected')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            @break
                        @case('adopted')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Adopted</span>
                            @break
                        @default
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($application->status) }}</span>
                    @endswitch
                </div>
            </div>

            @if($application->status == 'rejected' && $application->rejection_reason)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Rejection Reason</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-danger">{{ $application->rejection_reason }}</p>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($application->status == 'pending_review')
                    <form action="{{ route('admin-asst.adoption-applications.approve', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-1"></i> Approve
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-1"></i> Reject
                    </button>

                    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin-asst.adoption-applications.reject', $application) }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                        <textarea name="rejection_reason" id="rejection_reason" rows="4" class="form-control" maxlength="1000" required placeholder="Enter reason for rejection..."></textarea>
                                        <div class="form-text">Max 1000 characters.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @elseif($application->status == 'rejected')
                    <form action="{{ route('admin-asst.adoption-applications.pending', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-undo me-1"></i> Reset to Pending Review
                        </button>
                    </form>
                    @elseif($application->status == 'approved')
                    <form action="{{ route('admin-asst.adoption-applications.adopt', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-heart me-1"></i> Mark as Adopted
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($application->valid_id_path)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Valid ID</h5>
                </div>
                <div class="card-body">
                    @php
                        $ext = strtolower(pathinfo($application->valid_id_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp

                    @if($isImage)
                        <a href="{{ asset('storage/' . $application->valid_id_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $application->valid_id_path) }}" alt="Valid ID" class="w-100 rounded border border-gray-200" style="max-height: 220px; object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ asset('storage/' . $application->valid_id_path) }}" target="_blank" class="d-flex align-items-center gap-2 text-decoration-none">
                            <i class="fas fa-file-alt text-secondary"></i>
                            <span>View document</span>
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
