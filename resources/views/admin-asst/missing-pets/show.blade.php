@extends('layouts.admin')

@section('title', 'Missing Pet Details')

@section('header', 'Missing Pet Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-asst.missing-pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $missingPet->pet->pet_name ?? 'Unknown Pet' }}</h1>
            <p class="text-gray-500 mt-1">{{ ucfirst($missingPet->pet->species ?? 'Unknown') }} - {{ $missingPet->pet->breed ?? 'Unknown Breed' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin-asst.missing-pets.edit', $missingPet->report_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            @if($missingPet->status == 'pending review')
                <form action="{{ route('admin-asst.missing-pets.approve', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="return confirm('Approve this missing pet report?')">
                        <i class="bi bi-check-circle mr-1"></i> Approve
                    </button>
                </form>
                <form action="{{ route('admin-asst.missing-pets.reject', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Reject this missing pet report?')">
                        <i class="bi bi-x-circle mr-1"></i> Reject
                    </button>
                </form>
            @endif
            @if(in_array($missingPet->status, ['approved', 'pending review']))
                <form action="{{ route('admin-asst.missing-pets.mark-found', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="return confirm('Mark this pet as found/reunited?')">
                        <i class="bi bi-heart mr-1"></i> Found/Reunited
                    </button>
                </form>
                <form action="{{ route('admin-asst.missing-pets.shelter-intake', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" onclick="return confirm('Mark this pet as shelter intake?')">
                        <i class="bi bi-building mr-1"></i> Shelter Intake
                    </button>
                </form>
                <form action="{{ route('admin-asst.missing-pets.duplicate', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition" onclick="return confirm('Mark this report as duplicate?')">
                        <i class="bi bi-copy mr-1"></i> Duplicate
                    </button>
                </form>
                <form action="{{ route('admin-asst.missing-pets.cancel', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Cancel this missing pet report?')">
                        <i class="bi bi-x-circle mr-1"></i> Cancel
                    </button>
                </form>
            @endif
            @if($missingPet->status == 'approved')
                <form action="{{ route('admin-asst.missing-pets.close-expired', $missingPet->report_id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition" onclick="return confirm('Close this report as expired?')">
                        <i class="bi bi-calendar-x mr-1"></i> Expired
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Photo -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Photo</h3>
            <div class="relative h-80 bg-gray-200 rounded-lg overflow-hidden">
                @if($missingPet->pet && $missingPet->pet->pet_image)
                    <img src="{{ asset('storage/' . $missingPet->pet->pet_image) }}" alt="{{ $missingPet->pet->pet_name }}" class="w-full h-full object-cover">
                @elseif($missingPet->photo_path)
                    <img src="{{ asset('storage/' . $missingPet->photo_path) }}" alt="Report photo" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="bi bi-image text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pet Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Species</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($missingPet->pet->species ?? 'Unknown') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Breed</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->pet->breed ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($missingPet->pet->gender ?? 'Unknown') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Color/Markings</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->pet->color ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>

        <!-- Missing Info -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Missing Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Last Seen At</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->last_seen_at ? $missingPet->last_seen_at->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->barangay->barangay_name ?? 'Unknown' }}</p>
                    @if($missingPet->location_description)
                        <p class="text-sm text-gray-600 mt-1">{{ $missingPet->location_description }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Emergency Contact</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->emergency_contact ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Body Marks</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->body_marks ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Eye Color</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->pet?->petInfo?->eye_color ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Collar/Harness</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->collar_harness ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($missingPet->status == 'approved') bg-green-100 text-green-800
                        @elseif($missingPet->status == 'pending review') bg-yellow-100 text-yellow-800
                        @elseif(str_starts_with($missingPet->status, 'resolved')) bg-blue-100 text-blue-800
                        @elseif(str_starts_with($missingPet->status, 'closed')) bg-gray-100 text-gray-800
                        @elseif($missingPet->status == 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($missingPet->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Reported On</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Reporter Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Reporter Information</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Reported By</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->reported_by_name ?? ($missingPet->user->name ?? 'Guest / Unknown') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Contact Number</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->reporter_contact ?? ($missingPet->user->contact_number ?? 'N/A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->reporter_email ?? ($missingPet->user->email ?? 'N/A') }}</p>
                </div>
                @if($missingPet->user)
                <div>
                    <p class="text-sm text-gray-500">Account</p>
                    <p class="font-medium text-gray-800">{{ $missingPet->user->name ?? 'N/A' }} (ID: {{ $missingPet->user->id }})</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection