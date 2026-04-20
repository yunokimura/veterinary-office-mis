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
                        @case('pending')
                            <span class="badge bg-warning fs-5">Pending</span>
                            @break
                        @case('approved')
                            <span class="badge bg-success fs-5">Approved</span>
                            @break
                        @case('rejected')
                            <span class="badge bg-danger fs-5">Rejected</span>
                            @break
                        @case('completed')
                            <span class="badge bg-info fs-5">Completed</span>
                            @break
                        @default
                            <span class="badge bg-secondary fs-5">{{ $application->status }}</span>
                    @endswitch
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($application->status == 'pending')
                    <form action="{{ route('admin-asst.adoption-applications.approve', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-1"></i> Approve
                        </button>
                    </form>
                    <form action="{{ route('admin-asst.adoption-applications.reject', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                    </form>
                    @elseif($application->status == 'approved')
                    <form action="{{ route('admin-asst.adoption-applications.complete', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-check-double me-1"></i> Mark Completed
                        </button>
                    </form>
                    <form action="{{ route('admin-asst.adoption-applications.reject', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-times me-1"></i> Reject
                        </button>
                    </form>
                    @elseif($application->status == 'rejected')
                    <form action="{{ route('admin-asst.adoption-applications.pending', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-undo me-1"></i> Reset to Pending
                        </button>
                    </form>
                    @elseif($application->status == 'completed')
                    <form action="{{ route('admin-asst.adoption-applications.pending', $application) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-undo me-1"></i> Reset to Pending
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($application->shelter_visit)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Shelter Visit</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $application->shelter_visit }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection