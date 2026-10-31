<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentication - City of Dasmariñas</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
      <a href="{{ route('public.home') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700 transition flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Home
      </a>
    </div>
  </header>

  <!-- ================= AUTH CARD CONTAINER ================= -->
  <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
      
      <!-- CARD -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200/80 p-8">
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- SIGN IN FORM VIEW -->
        <div id="signin-view">
          <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-xs text-gray-500 mt-1">Sign in to your account to manage pet services</p>
          </div>

          <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                Email Address <span class="text-red-500">*</span>
              </label>
              <input 
                id="email"
                type="email" 
                name="email"
                placeholder="cityvet@vetmis.gov"
                value="{{ old('email') }}"
                class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('email') border-red-500 @else @if($errors->has('email') || $errors->has('password')) border-red-500 @endif @enderror"
                required
                autofocus
                autocomplete="username"
              >
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Password -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                Password <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input 
                  id="password"
                  type="password" 
                  name="password"
                  placeholder="••••••••••••"
                  class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition pr-10 @error('password') border-red-500 @else @if($errors->has('email') || $errors->has('password')) border-red-500 @endif @enderror"
                  required
                  autocomplete="current-password"
                >
                <button type="button" onclick="togglePassword('password', 'eye-icon-1')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                  <i id="eye-icon-1" class="fa-solid fa-eye text-xs"></i>
                </button>
              </div>
              @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Options Row -->
            <div class="flex items-center justify-between text-xs pt-1">
              <label class="flex items-center gap-2 cursor-pointer text-gray-600 font-medium">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-700 focus:ring-emerald-600 border-gray-300">
                Remember me
              </label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-semibold text-emerald-700 hover:text-emerald-800 transition">Forgot password?</a>
              @endif
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-emerald-700/20 transition duration-150 mt-2"
            >
              Sign In
            </button>
          </form>

          <!-- Toggle view -->
          <div class="mt-6 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:text-emerald-800 transition ml-1">Register here</a>
          </div>
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

  <!-- Toast Element -->
  <div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-2xl border border-gray-700 flex items-center space-x-3 text-xs font-medium">
    <i class="fa-solid fa-circle-info text-emerald-400 text-sm"></i>
    <span id="toast-message">Action triggered</span>
  </div>

  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function showToast(msg) {
      const toast = document.getElementById('toast');
      const toastMsg = document.getElementById('toast-message');
      toastMsg.innerText = msg;
      
      toast.classList.remove('translate-y-20', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
      
      setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
      }, 2500);
    }
  </script>

</body>
</html>
