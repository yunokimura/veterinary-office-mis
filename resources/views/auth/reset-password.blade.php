<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - City of Dasmariñas</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f0fdf4',
              100: '#dcfce7',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-between text-gray-800 font-sans antialiased selection:bg-emerald-500 selection:text-white">

  <!-- ================= MINIMAL GLOBAL HEADER ================= -->
  <header class="w-full h-20 border-b border-gray-200/80 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-full">
      <a href="{{ route('public.home') }}" class="flex items-center space-x-3 group">
        <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0">
          <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
        </div>
        <div>
          <span class="block font-extrabold text-lg tracking-tight text-slate-900 group-hover:text-primary transition-colors">
            City of Dasmariñas
          </span>
          <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">
            Veterinary Services
          </span>
        </div>
      </a>
      <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700 transition flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Login
      </a>
    </div>
  </header>

  <!-- ================= AUTH CARD CONTAINER ================= -->
  <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
      
      <!-- CARD -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200/80 p-8">
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="text-center mb-8">
          <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Set New Password</h2>
          <p class="text-xs text-gray-500 mt-1">Enter your new password below.</p>
        </div>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-6">
              <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                Email Address
              </label>
              <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                  class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition">
            </div>

            <!-- New Password -->
            <div class="mb-6">
              <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                New Password <span class="text-red-500">*</span>
              </label>
              <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Enter new password"
                  class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('password') border-red-500 @enderror">
              @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
              <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                Confirm New Password <span class="text-red-500">*</span>
              </label>
              <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password"
                  class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('password_confirmation') border-red-500 @enderror">
              @error('password_confirmation')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              id="submitBtn"
              class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-emerald-700/20 transition duration-150 mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span id="btnText">Reset Password</span>
              <span id="btnLoading" class="hidden">Resetting...</span>
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
          Return to 
          <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 transition ml-1">Login</a>
        </div>

      </div>

      <!-- Quick Link Back to Home Below Card -->
      <div class="text-center mt-6">
        <a href="{{ route('public.home') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition inline-flex items-center gap-1.5">
          <i class="fa-solid fa-arrow-left text-[10px]"></i> Return to main page
        </a>
      </div>

    </div>
  </main>

  <!-- ================= MINIMAL GLOBAL FOOTER ================= -->
  <footer class="py-4 border-t border-gray-200/80 bg-white text-center text-xs text-gray-400">
    <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-2">
      <p>© 2026 City Government of Dasmariñas. All rights reserved.</p>
      <div class="flex gap-4">
        <a href="#" class="hover:text-gray-600 transition">Privacy Policy</a>
        <a href="#" class="text-gray-300">•</a>
        <a href="#" class="hover:text-gray-600 transition">Terms of Service</a>
      </div>
    </div>
  </footer>

</body>
</html>
