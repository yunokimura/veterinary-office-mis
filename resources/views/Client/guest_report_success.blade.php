<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Submitted - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#066D33',
                        'primary-light': '#088442',
                        secondary: '#6B21A8',
                        'secondary-light': '#7C3AED',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">

<!-- Header -->
@include('Client.partials.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Main Content -->
    <div class="text-center">

        @if ($saveInfo)
        <!-- Save Info Section -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-6">
            <h3 class="text-emerald-700 font-medium mb-4">Save Your Pet's Info for Later Registration</h3>
            <p class="text-gray-600 text-sm mb-4">Your pet's name, species, and crossbreed info will be saved for 7 days. 
            You can bookmark a link below or have it emailed to you to pre-fill the pet registration form.</p>
            
            <!-- Copy Link Section -->
            <div class="bg-white rounded-lg p-4 mb-4">
                <p class="text-emerald-600 text-sm font-medium mb-2">Bookmark this link:</p>
                <input type="text" class="bg-slate-50 border border-slate-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                       value="{{ url('return-to-register', $token) }}" readonly>
                <button class="bg-emerald-600 text-white px-4 py-2 rounded mt-2 copy-btn">
                    Copy Link
                </button>
            </div>
            
            <!-- Email Link Section (shown only if email on file) -->
            @if ($token && isset($token->reporter_email) && $token->reporter_email)
            <div class="bg-white rounded-lg p-4 mt-4">
                <p class="text-emerald-600 text-sm font-medium mb-2">Email me this link:</p>
                <button class="bg-emerald-600 text-white px-4 py-2 rounded mt-2 email-link-btn" 
                        data-email="{{ $token->reporter_email }}"
                        data-token="{{ $token }}">
                    Send Link to Email
                </button>
            </div>
            @endif
            
            <p class="text-emerald-500 text-xs mt-4">This link expires in 7 days. After 7 days, the info will be automatically deleted.</p>
            
            <form method="POST" action="{{ url('missing-pets.report.guest.store') }}" enctype="multipart/form-data" class="mt-6">
                @csrf
                <button type="submit" name="report_type" value="missing" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mt-4">
                    Submit Another Missing Pet Report
                </button>
                <a href="{{ url('missing-pets') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mt-2 ml-2">View Missing Pets Page</a>
            </form>
        </div>
        @else
        <!-- Standard Success Section -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <h3 class="text-green-700 font-medium mb-4">Your Missing Pet Report Has Been Submitted</h3>
            <p class="text-green-600 text-sm">Your report is now in the system and will be reviewed by the City Veterinary Services.</p>
            <a href="{{ url('missing-pets') }}" class="bg-green-100 text-green-700 px-4 py-2 rounded">View Missing Pets Page</a>
            <a href="{{ url('/client') }}" class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded">Return to Client Portal</a>
        </div>
        @endif
    </div>
</main>

@include('Client.partials.footer')

</body>
</html>