@extends('layouts.admin')

@section('title', 'Submit Bite Report')

@section('header', 'Submit Bite Incident Report')
@section('subheader', 'Report animal bite cases for disease surveillance')

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

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('clinic.bite-reports.store') }}" class="space-y-6">
            @csrf

            <!-- Incident Details -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Incident Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Incident *</label>
                        <input type="date" name="incident_date" value="{{ old('incident_date') }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    </div>

                </div>
            </div>

            <!-- Animal Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Animal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Species *</label>
                        <select name="animal_type" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Species</option>
                            <option value="dog" {{ old('animal_type') === 'dog' ? 'selected' : '' }}>Dog</option>
                            <option value="cat" {{ old('animal_type') === 'cat' ? 'selected' : '' }}>Cat</option>
                            <option value="others" {{ old('animal_type') === 'others' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Status *</label>
                        <select name="animal_status" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Status</option>
                            <option value="owned" {{ old('animal_status') === 'owned' ? 'selected' : '' }}>Owned</option>
                            <option value="stray" {{ old('animal_status') === 'stray' ? 'selected' : '' }}>Stray</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Gender</label>
                        <select name="animal_gender"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('animal_gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('animal_gender') === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Animal Owner Name</label>
                        <input type="text" name="animal_owner_name" value="{{ old('animal_owner_name') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vaccination Status</label>
                        <select name="vaccination_status"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Status</option>
                            <option value="vaccinated" {{ old('vaccination_status') === 'vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                            <option value="unvaccinated" {{ old('vaccination_status') === 'unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                            <option value="unknown" {{ old('vaccination_status') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                <textarea name="notes" rows="3"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="Any additional information...">{{ old('notes') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-check-circle mr-2"></i>Submit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection