@extends('layouts.admin')

@section('title', 'Bite Report Details')

@section('header', 'Bite Report Details')
@section('subheader', 'View bite incident report')

@php
$rolePrefix = 'clinic';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('clinic.bite-reports.index') }}" class="text-green-600 hover:text-green-800 inline-flex items-center">
            <i class="bi bi-arrow-left mr-2"></i>Back to Bite Reports
        </a>
    </div>

    <!-- Report Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Report #{{ $report->report_number }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Status -->
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">{{ $report->status }}</p>
            </div>

            <!-- Date Reported -->
            <div>
                <p class="text-sm text-gray-500">Date Reported</p>
                <p class="font-medium text-gray-800">{{ $report->date_reported ? (is_string($report->date_reported) ? \Carbon\Carbon::parse($report->date_reported)->format('M d, Y') : $report->date_reported->format('M d, Y')) : 'N/A' }}</p>
            </div>

            <!-- Patient Name -->
            <div>
                <p class="text-sm text-gray-500">Patient Name</p>
                <p class="font-medium text-gray-800">{{ $report->patient->full_name ?? 'N/A' }}</p>
            </div>

            <!-- Patient Age -->
            <div>
                <p class="text-sm text-gray-500">Patient Age</p>
                <p class="font-medium text-gray-800">{{ $report->patient->age ?? 'N/A' }}</p>
            </div>

            <!-- Patient Gender -->
            <div>
                <p class="text-sm text-gray-500">Gender</p>
                <p class="font-medium text-gray-800">{{ ucfirst($report->patient->gender) ?? 'N/A' }}</p>
            </div>

            <!-- Patient Contact -->
            <div>
                <p class="text-sm text-gray-500">Contact</p>
                <p class="font-medium text-gray-800">{{ $report->patient->contact_number ?? 'N/A' }}</p>
            </div>

            <!-- Patient Barangay -->
            <div>
                <p class="text-sm text-gray-500">Address (Barangay)</p>
                <p class="font-medium text-gray-800">{{ $report->barangay->barangay_name ?? ($report->patient->barangay->barangay_name ?? 'N/A') }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Incident Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Incident Date -->
                <div>
                    <p class="text-sm text-gray-500">Incident Date</p>
                    <p class="font-medium text-gray-800">{{ $report->incident_date ? (is_string($report->incident_date) ? \Carbon\Carbon::parse($report->incident_date)->format('M d, Y') : $report->incident_date->format('M d, Y')) : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Animal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Animal Species -->
                <div>
                    <p class="text-sm text-gray-500">Animal Species</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->animal_type) ?? 'N/A' }}</p>
                </div>

                <!-- Animal Gender -->
                <div>
                    <p class="text-sm text-gray-500">Animal Gender</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->animal_gender) ?? 'N/A' }}</p>
                </div>

                <!-- Animal Status -->
                <div>
                    <p class="text-sm text-gray-500">Animal Status</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->animal_status) ?? 'N/A' }}</p>
                </div>

                <!-- Animal Owner Name -->
                <div>
                    <p class="text-sm text-gray-500">Owner Name</p>
                    <p class="font-medium text-gray-800">{{ $report->animal_owner_name ?? 'N/A' }}</p>
                </div>

                <!-- Animal Vaccination Status -->
                <div>
                    <p class="text-sm text-gray-500">Vaccination Status</p>
                    <p class="font-medium text-gray-800">{{ ucfirst($report->vaccination_status) ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        @if($report->notes)
        <div class="border-t border-gray-200 mt-6 pt-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Notes</h3>
            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $report->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection