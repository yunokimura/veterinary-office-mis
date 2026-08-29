@extends('layouts.admin')

@section('title', 'Create User')

@section('header', 'Create User')
@section('subheader', 'Add a new system user')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">User Information</h3>
            <p class="text-sm text-gray-500">Fill in the information below to create a new user</p>
        </div>

        @include('admin.users._form')

    </div>
</div>
@endsection
