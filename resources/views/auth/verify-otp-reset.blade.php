<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Reset Code - City of Dasmariñas</title>
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
      <a href="{{ route('password.request') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700 transition flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Forgot Password
      </a>
    </div>
  </header>

  <!-- ================= AUTH CARD CONTAINER ================= -->
  <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
      
      <!-- CARD -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200/80 p-8">
        
        <!-- Session Messages -->
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center mb-8">
          <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Verify Reset Code</h2>
          <p class="text-xs text-gray-500 mt-1">We've sent a 6-digit verification code to</p>
          <p class="font-semibold text-emerald-700 mt-1">{{ $email }}</p>
        </div>

        <!-- OTP Form -->
        <form id="otpForm" class="space-y-6">
            @csrf

            <!-- OTP Inputs -->
            <div class="flex justify-center gap-3 mb-8">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp1" required autofocus autocomplete="one-time-code">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp2" required autocomplete="one-time-code">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp3" required autocomplete="one-time-code">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp4" required autocomplete="one-time-code">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp5" required autocomplete="one-time-code">
                <input type="text" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-200 bg-gray-50/50 text-gray-900 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all" maxlength="1" name="otp6" required autocomplete="one-time-code">
            </div>

            <input type="hidden" name="otp" id="fullOtp">

            <!-- Submit Button -->
            <button 
              type="submit" 
              id="submitBtn"
              class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-emerald-700/20 transition duration-150 mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span id="btnText">Verify Code</span>
              <span id="btnLoading" class="hidden">Verifying...</span>
            </button>
        </form>

        <!-- Resend Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">Didn't receive the code?</p>
            <a href="{{ route('password.otp.resend') }}" id="resendLink" class="font-bold text-emerald-700 hover:text-emerald-800 transition">Resend Code</a>
            <p class="text-xs text-gray-500 mt-2">Resend available in <span id="countdown">60</span> seconds</p>
        </div>

        <!-- Back to Forgot Password -->
        <div class="mt-6 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
          Return to 
          <a href="{{ route('password.request') }}" class="font-bold text-emerald-700 hover:text-emerald-800 transition ml-1">Forgot Password</a>
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

  <script>
    // Auto-focus and auto-advance inputs
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value === '') {
                if (index > 0) {
                    inputs[index - 1].focus();
                }
            }
        });

        // Only allow numbers
        input.addEventListener('keypress', (e) => {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    // Form submission - combine all 6 inputs into one
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let otp = '';
        inputs.forEach(input => {
            otp += input.value;
        });

        document.getElementById('fullOtp').value = otp;

        // Disable button and show loading
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');

        // Submit the form
        this.submit();
    });

    // Countdown timer for resend
    let countdown = 60;
    const countdownElement = document.getElementById('countdown');
    const resendLink = document.getElementById('resendLink');

    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(timer);
            resendLink.style.pointerEvents = 'auto';
            resendLink.style.opacity = '1';
        }
    }, 1000);
  </script>

</body>
</html>
