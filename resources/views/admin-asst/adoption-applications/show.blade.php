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

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">{{ $application->first_name }} {{ $application->last_name }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 200px;">Email</td>
                            <td>{{ $application->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Mobile Number</td>
                            <td>{{ $application->mobile_number }}</td>
                        </tr>
                        @if($application->alt_mobile_number)
                        <tr>
                            <td class="text-muted">Alt Mobile</td>
                            <td>{{ $application->alt_mobile_number }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Address</td>
                            <td>
                                {{ $application->blk_lot_ph }} {{ $application->street }}<br>
                                {{ $application->barangay }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Birth Date</td>
                            <td>{{ $application->birth_date ? $application->birth_date->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Occupation</td>
                            <td>{{ $application->occupation ?? 'N/A' }}</td>
                        </tr>
                        @if($application->company)
                        <tr>
                            <td class="text-muted">Company</td>
                            <td>{{ $application->company }}</td>
                        </tr>
                        @endif
                        @if($application->social_media)
                        <tr>
                            <td class="text-muted">Social Media</td>
                            <td>{{ $application->social_media }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Adopted Before</td>
                            <td>{{ $application->adopted_before ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Submitted</td>
                            <td>{{ $application->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($application->questionnaire)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Questionnaire Responses</h5>
                </div>
                <div class="card-body">
                    @foreach($application->questionnaire as $question => $answer)
                    <div class="mb-3">
                        <strong class="text-muted d-block small">{{ $question }}</strong>
                        <p class="mb-0">{{ $answer }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body text-center">
                    @switch($application->status)
                        @case('pending_review')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending Review</span>
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
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Rejection Reason</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-danger">{{ $application->rejection_reason }}</p>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
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
        </div>
    </div>
</div>
@endsection