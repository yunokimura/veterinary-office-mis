@extends('layouts.admin')

@section('title', 'All Reports - City-wide View')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-1">
            <i class="bi bi-file-earmark-text me-2"></i>City-wide Reports
        </h2>
        <p class="text-gray-500 text-sm">View all reports submitted across all barangays, clinics, and inspection units.</p>
    </div>

    <!-- Report Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-red-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-exclamation-triangle text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ $stats['total_bite_reports'] }}</h4>
                <small class="text-red-100">Animal Bite Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-red-600">
                        <i class="bi bi-geo-alt me-1"></i> Barangay
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-green-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-shield-check text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ $stats['total_vaccinations'] }}</h4>
                <small class="text-green-100">Vaccination Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-green-600">
                        <i class="bi bi-hospital me-1"></i> Clinics
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-yellow-500 text-dark rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-search text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ $totalMeatEstablishments }}</h4>
                <small class="text-yellow-700">Meat Establishments</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-yellow-600">
                        <i class="bi bi-clipboard-check me-1"></i> Registered
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-purple-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-question-circle text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ $missingPetStats['total'] }}</h4>
                <small class="text-purple-100">Missing Pet Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-purple-600">
                        <i class="bi bi-search me-1"></i> Lost Pets
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-pink-500 text-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <i class="bi bi-heart text-4xl md:text-5xl mb-3 block"></i>
                <h4 class="text-3xl md:text-4xl font-bold mb-1">{{ $adoptionStats['total'] }}</h4>
                <small class="text-pink-100">Adoption Reports</small>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-pink-600">
                        <i class="bi bi-house-heart me-1"></i> Adoptions
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <div class="flex gap-4 -mb-px overflow-x-auto">
            <button onclick="switchTab('bite')" class="tab-btn active px-4 py-3 border-b-2 border-red-500 text-red-600 font-medium text-sm whitespace-nowrap" id="bite-tab-btn">
                <i class="bi bi-exclamation-triangle me-2"></i>Animal Bites
            </button>
            <button onclick="switchTab('vaccine')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="vaccine-tab-btn">
                <i class="bi bi-shield-check me-2"></i>Vaccinations
            </button>
            <button onclick="switchTab('inspection')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="inspection-tab-btn">
                <i class="bi bi-search me-2"></i>Meat Inspection
            </button>
            <button onclick="switchTab('missing')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="missing-tab-btn">
                <i class="bi bi-question-circle me-2"></i>Missing Pets
            </button>
            <button onclick="switchTab('adoption')" class="tab-btn px-4 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm whitespace-nowrap" id="adoption-tab-btn">
                <i class="bi bi-heart me-2"></i>Adoptions
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">
        <!-- Animal Bite Reports Tab -->
        <div id="bite-content" class="tab-pane">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-red-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-exclamation-triangle me-2"></i>Animal Bite Incident Reports
                    </h5>
                    <button class="inline-flex items-center px-3 py-2 bg-white text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reporter</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Victim</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($biteReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->reportedBy?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->barangay?->barangay_name ?? ($report->patient?->barangay?->barangay_name ?? 'N/A') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->patient?->full_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->animal_type) }}</td>
                                <td class="px-4 py-3">
                                    @if($report->category == 'I')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">Category I</span>
                                    @elseif($report->category == 'II')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 whitespace-nowrap">Category II</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap">Category III</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($report->status == 'Pending Review')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 whitespace-nowrap">Pending Review</span>
                                    @elseif($report->status == 'Under Investigation')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 whitespace-nowrap">Under Investigation</span>
                                    @elseif($report->status == 'Cleared')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">Cleared</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap">Confirmed Rabies</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No animal bite reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $biteReports->links() }}
                </div>
            </div>
        </div>

        <!-- Vaccination Reports Tab -->
        <div id="vaccine-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-shield-check me-2"></i>Anti-Rabies Vaccination Reports
                    </h5>
                    <button class="inline-flex items-center px-3 py-2 bg-white text-green-600 rounded-lg text-sm font-medium hover:bg-green-50 transition">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($vaccinationReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($report->vaccination_date)->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->clinic_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->patient_name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->pet_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->pet_species) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->vaccine_brand }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $report->vaccination_type == 'primary' ? 'bg-blue-100 text-blue-800' : 'bg-cyan-100 text-cyan-800' }}">
                                        {{ ucfirst($report->vaccination_type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No vaccination reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $vaccinationReports->links() }}
                </div>
            </div>
        </div>

        <!-- Meat Inspection / Establishments Tab -->
        <div id="inspection-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-yellow-500 text-dark px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-search me-2"></i>Meat Inspection / Establishments
                    </h5>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-yellow-600">
                        {{ $totalMeatEstablishments }} Registered
                    </span>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[700px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barangay</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($meatEstablishments as $est)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $est->establishment_id }}</td>
                                <td class="px-4 py-3 text-sm">{{ $est->establishment_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $est->establishment_type)) }}</td>
                                <td class="px-4 py-3 text-sm">{{ $est->owner_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $est->barangay->barangay_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($est->status == 'active' || $est->status == 'approved')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">Active</span>
                                    @elseif($est->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 whitespace-nowrap">Pending</span>
                                    @elseif($est->status == 'suspended')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 whitespace-nowrap">Suspended</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 whitespace-nowrap">{{ ucfirst(str_replace('_', ' ', $est->status)) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No meat establishments found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $meatEstablishments->links() }}
                </div>
            </div>
        </div>

        <!-- Missing Pet Reports Tab -->
        <div id="missing-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-purple-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-question-circle me-2"></i>Missing Pet Reports
                    </h5>
                    <div class="flex gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-purple-600">
                            {{ $missingPetStats['pending'] }} Pending
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-purple-600">
                            {{ $missingPetStats['approved'] }} Approved
                        </span>
                    </div>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Source</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Breed</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Seen</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($missingPetReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">Bulletin</span></td>
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->missing_id }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->pet_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($report->species ?? 'N/A') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->breed ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->last_seen_at ? \Carbon\Carbon::parse($report->last_seen_at)->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->location ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($report->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($report->status == 'approved')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-2 text-center text-gray-400 text-sm">No bulletin missing pets found.</td>
                            </tr>
                            @endforelse
                            @forelse($missingPetsReportRecords as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Report</span></td>
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->report_id }}</td>
                                <td class="px-4 py-3 text-sm">{{ $report->pet->pet_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->pet ? ucfirst($report->pet->species ?? 'N/A') : 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->pet->breed ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->last_seen_at ? \Carbon\Carbon::parse($report->last_seen_at)->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->location_barangay ?? ($report->location_description ?? 'N/A') }}</td>
                                <td class="px-4 py-3">
                                    @if($report->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($report->status == 'resolved')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Resolved</span>
                                    @elseif($report->status == 'missing')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Missing</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-2 text-center text-gray-400 text-sm">No report-based missing pets found.</td>
                            </tr>
                            @endforelse
                            @if($missingPetReports->isEmpty() && $missingPetsReportRecords->isEmpty())
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No missing pet reports found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-100">
                    <div class="mb-2">
                        <small class="text-gray-500">Bulletin Missing Pets</small>
                        {{ $missingPetReports->links() }}
                    </div>
                    <div>
                        <small class="text-gray-500">Report-based Missing Pets</small>
                        {{ $missingPetsReportRecords->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Adoption Reports Tab -->
        <div id="adoption-content" class="tab-pane hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-pink-500 text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h5 class="font-semibold text-lg">
                        <i class="bi bi-heart me-2"></i>Adoption Reports
                    </h5>
                    <div class="flex gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-pink-600">
                            {{ $adoptionStats['pending_review'] }} Pending Review
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-pink-600">
                            {{ $adoptionStats['approved'] }} Approved
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-pink-600">
                            {{ $adoptionStats['rejected'] }} Rejected
                        </span>
                    </div>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Species</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($adoptionReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">#{{ $report->id }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $report->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $report->user->email ?? 'N/A' }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $report->pet->pet_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->pet ? ucfirst($report->pet->species ?? 'N/A') : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($report->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($report->status == 'approved')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                                    @elseif($report->status == 'completed')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                    @elseif($report->status == 'rejected')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($report->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-3xl mb-2 block"></i>
                                    No adoption reports found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $adoptionReports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all tab content
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.add('hidden');
    });

    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-red-500', 'text-red-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById(tab + '-content').classList.remove('hidden');

    // Highlight selected tab button
    const activeBtn = document.getElementById(tab + '-tab-btn');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-red-500', 'text-red-600');
}
</script>
@endsection
