<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - City of Dasmariñas</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0fdf4',
              100: '#dcfce7',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
            }
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

  <!-- ================= MAIN CONTENT ================= -->
  <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-3xl">

      <!-- Session Status -->
      @if (session('status'))
          <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
              {{ session('status') }}
          </div>
      @endif

      <!-- Validation Errors -->
      @if ($errors->any())
          <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
              <strong>Please fix the following errors:</strong>
              <ul class="list-disc ml-5 mt-2">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <!-- Form Card -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200/80 p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
          @csrf

          <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Create an Account</h2>
            <p class="text-xs text-gray-500 mt-1">Register as a pet owner to book clinic services</p>
          </div>

          <!-- PERSONAL INFO -->
          <div class="space-y-6">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Personal Information</h3>

            <div class="grid md:grid-cols-4 gap-4">
              <!-- First Name -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  First Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('first_name') border-red-500 @enderror">
                @error('first_name')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Last Name -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Last Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('last_name') border-red-500 @enderror">
                @error('last_name')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Middle Name -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Middle Name
                </label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition">
              </div>

              <!-- Suffix -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Suffix</label>
                <input type="text" name="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition">
              </div>

              <!-- Date of Birth -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Date of Birth <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                  <select name="dob_year" class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition appearance-none @error('dob_year') border-red-500 @enderror"
                          style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                    <option value="">Year</option>
                    @for($year = date('Y'); $year >= 1900; $year--)
                      <option value="{{ $year }}" {{ old('dob_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                  </select>
                  <select name="dob_month" class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition appearance-none @error('dob_month') border-red-500 @enderror"
                          style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                    <option value="">Month</option>
                    @for($month = 1; $month <= 12; $month++)
                      <option value="{{ $month }}" {{ old('dob_month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endfor
                  </select>
                  <select name="dob_day" class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition appearance-none @error('dob_day') border-red-500 @enderror"
                          style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                    <option value="">Day</option>
                    @for($day = 1; $day <= 31; $day++)
                      <option value="{{ $day }}" {{ old('dob_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endfor
                  </select>
                </div>
                @error('dob_year')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('dob_month')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('dob_day')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Phone Number -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Phone Number <span class="text-red-500">*</span>
                </label>
                <div class="flex">
                  <span class="inline-flex items-center px-4 py-3 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50/50 text-gray-600 text-xs sm:text-sm">
                    +63
                  </span>
                  <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="943 210 2012" maxlength="12"
                         inputmode="numeric" pattern="[0-9\s]{12}"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                         oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3').trim()"
                         class="flex-1 px-4 py-3 text-xs sm:text-sm rounded-r-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('phone_number') border-red-500 @enderror">
                </div>
                @error('phone_number')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Alternate Phone Number -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Alternate Phone Number
                </label>
                <div class="flex">
                  <span class="inline-flex items-center px-4 py-3 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50/50 text-gray-600 text-xs sm:text-sm">
                    +63
                  </span>
                  <input type="tel" name="alternate_phone_number" value="{{ old('alternate_phone_number') }}" placeholder="943 210 2012" maxlength="12"
                         inputmode="numeric" pattern="[0-9\s]{12}"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                         oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3').trim()"
                         class="flex-1 px-4 py-3 text-xs sm:text-sm rounded-r-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('alternate_phone_number') border-red-500 @enderror">
                </div>
                @error('alternate_phone_number')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email Address -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('email') border-red-500 @enderror">
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <hr class="my-6 border-gray-200">

          <!-- ADDRESS INFO -->
          <div class="space-y-6">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Address Information</h3>

            <div class="grid md:grid-cols-4 gap-4">
              <!-- Block/Lot/Phase/House No. -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Block/Lot/Phase/House No. <span class="text-red-500">*</span>
                </label>
                <div class="flex rounded-xl border border-gray-200 overflow-hidden focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                  <div class="flex items-center px-2 py-3 bg-gray-50/50 border-r border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Blk</span>
                  </div>
<input type="text" name="block_lot_phase_house_no_1" value="{{ old('block_lot_phase_house_no_1') }}"
                       class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="3" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-2 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Lot</span>
                  </div>
<input type="text" name="block_lot_phase_house_no_2" value="{{ old('block_lot_phase_house_no_2') }}"
                       class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="3" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-2 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Ph</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_3" value="{{ old('block_lot_phase_house_no_3') }}"
                       class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="2" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-2 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">House #</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_4" value="{{ old('block_lot_phase_house_no_4') }}"
                       class="w-full px-2 py-3 outline-none bg-white text-center rounded-r-xl" placeholder="" maxlength="3" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                @error('block_lot_phase_house_no')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Street Name -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Street Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="street_name" value="{{ old('street_name') }}"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('street_name') border-red-500 @enderror">
                @error('street_name')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Subdivision -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Subdivision <span class="text-red-500">*</span>
                </label>
                <input type="text" name="subdivision" value="{{ old('subdivision') }}"
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition @error('subdivision') border-red-500 @enderror">
                @error('subdivision')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Barangay -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Barangay <span class="text-red-500">*</span>
                </label>
                @php
                    $selectedBarangayName = old('barangay_id') && isset($barangays) ? (($b = $barangays->firstWhere('barangay_id', old('barangay_id'))) ? $b->barangay_name : null) : null;
                @endphp
                <div class="relative">
                    <button type="button" id="barangayDisplay" class="w-full px-4 py-3 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 transition-colors text-left flex items-center focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent" onclick="openBarangayModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span id="selectedBarangayText" class="text-sm text-gray-700 truncate">{{ $selectedBarangayName ?? 'Select Barangay' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 ml-auto pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                <!-- Hidden input for barangay -->
                <input type="hidden" id="barangayIdInput" name="barangay_id" value="{{ old('barangay_id') }}">
                @error('barangay_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- City -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">City</label>
                <input value="Dasmariñas City" disabled
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-500">
              </div>

              <!-- Province -->
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Province</label>
                <input value="Cavite" disabled
                       class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-500">
              </div>
            </div>
          </div>

          <hr class="my-6 border-gray-200">

          <!-- ACCOUNT SECURITY -->
          <div class="space-y-6">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Account Security</h3>

            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input type="password" id="password" name="password"
                         class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition pr-10 @error('password') border-red-500 @enderror"
                         oninput="updatePasswordStrength()">
                  <button type="button" onclick="togglePassword('password')"
                          class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                    <i id="eye-icon-password" class="fa-solid fa-eye text-xs"></i>
                  </button>
                </div>
                <div class="mt-2">
                  <div class="flex items-center gap-1 mb-1">
                    <div id="strength-bar-1" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                    <div id="strength-bar-2" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                    <div id="strength-bar-3" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                    <div id="strength-bar-4" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                  </div>
                  <p id="strength-text" class="text-xs text-gray-500">Enter a password</p>
                </div>
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Confirm Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input type="password" id="password_confirmation" name="password_confirmation"
                         class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition pr-10">
                  <button type="button" onclick="togglePassword('password_confirmation')"
                          class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                    <i id="eye-icon-password_confirmation" class="fa-solid fa-eye text-xs"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- TERMS -->
          <div class="space-y-2">
            <label class="inline-flex items-start text-xs text-gray-600">
              <input type="checkbox" name="terms" class="mt-1 mr-2 w-4 h-4 rounded text-emerald-700 focus:ring-emerald-600 border-gray-300" {{ old('terms') ? 'checked' : '' }}>
              I agree to the <span class="text-emerald-700 font-semibold ml-1 underline">Terms and Conditions</span>
            </label>
            @error('terms')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- SUBMIT -->
          <button 
            type="submit" 
            id="submitBtn"
            class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-emerald-700/20 transition duration-150 mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span id="btnText">Sign Up</span>
            <span id="btnLoading" class="hidden">Creating...</span>
          </button>
        </form>
      </div>

      <!-- Footer Links -->
      <div class="text-center mt-6 text-xs text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 transition ml-1">Sign in</a>
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
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById('eye-icon-' + fieldId);

      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function updatePasswordStrength() {
      const password = document.getElementById('password').value;
      const bars = [
        document.getElementById('strength-bar-1'),
        document.getElementById('strength-bar-2'),
        document.getElementById('strength-bar-3'),
        document.getElementById('strength-bar-4')
      ];
      const strengthText = document.getElementById('strength-text');

      bars.forEach(bar => bar.className = 'h-1 flex-1 rounded-full bg-gray-200 transition-colors');

      if (password.length === 0) {
        strengthText.textContent = 'Enter a password';
        strengthText.className = 'text-xs text-gray-500';
        return;
      }

      let score = 0;
      if (password.length >= 8) score++;
      if (/[a-z]/.test(password)) score++;
      if (/[A-Z]/.test(password)) score++;
      if (/[0-9]/.test(password)) score++;
      if (/[^a-zA-Z0-9]/.test(password)) score++;

      const displayScore = Math.min(score, 4);

      const colors = {
        0: 'bg-red-500',
        1: 'bg-red-400',
        2: 'bg-yellow-400',
        3: 'bg-green-400',
        4: 'bg-green-600'
      };

      const texts = {
        0: 'Very weak - add more characters',
        1: 'Weak - add uppercase, numbers, or symbols',
        2: 'Fair - could be stronger',
        3: 'Good - secure enough',
        4: 'Strong - excellent password!'
      };

      for (let i = 0; i < displayScore; i++) {
        bars[i].className = `h-1 flex-1 rounded-full ${colors[displayScore]} transition-colors`;
      }

      strengthText.textContent = texts[displayScore];

      if (displayScore <= 1) {
        strengthText.className = 'text-xs text-red-500';
      } else if (displayScore === 2) {
        strengthText.className = 'text-xs text-yellow-600';
      } else {
        strengthText.className = 'text-xs text-green-600';
      }
    }

    // Barangay data from server
    const barangaysData = @json($barangays);
    let lastFocusedBarangayElement = null;

    // Focus trap utility
    function trapFocus(element) {
      const focusableElements = element.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      );
      const firstElement = focusableElements[0];
      const lastElement = focusableElements[focusableElements.length - 1];

      element.addEventListener('keydown', function handleTab(e) {
        if (e.key !== 'Tab') return;
        if (e.shiftKey) {
          if (document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
          }
        } else {
          if (document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
          }
        }
      });
    }

    // Open the barangay selector modal
    function openBarangayModal() {
      const modal = document.getElementById('barangayModal');
      modal.classList.remove('hidden');
      modal.setAttribute('aria-modal', 'true');
      modal.setAttribute('role', 'dialog');
      document.body.classList.add('overflow-hidden');

      lastFocusedBarangayElement = document.activeElement;

      document.getElementById('barangayModalSearch').value = '';
      renderBarangayModal();

      setTimeout(() => {
        const searchInput = document.getElementById('barangayModalSearch');
        if (searchInput) {
          searchInput.focus();
          trapFocus(modal);
        }
      }, 50);
    }

    // Close the barangay selector modal
    function closeBarangayModal() {
      const modal = document.getElementById('barangayModal');
      modal.classList.add('hidden');
      modal.removeAttribute('aria-modal');
      modal.removeAttribute('role');
      document.body.classList.remove('overflow-hidden');

      if (lastFocusedBarangayElement && typeof lastFocusedBarangayElement.focus === 'function') {
        lastFocusedBarangayElement.focus();
      }
      lastFocusedBarangayElement = null;
    }

    // Render the barangay list grouped alphabetically
    function renderBarangayModal(filter = '') {
      const search = filter.trim().toLowerCase();
      const filtered = barangaysData.filter(b => String(b.barangay_name).toLowerCase().includes(search));
      const list = document.getElementById('barangayModalList');
      const empty = document.getElementById('barangayModalEmpty');

      if (filtered.length === 0) {
        list.innerHTML = '';
        empty.classList.remove('hidden');
        return;
      }

      empty.classList.add('hidden');

      const groups = {};
      filtered.forEach(b => {
        const letter = String(b.barangay_name).charAt(0).toUpperCase();
        if (!groups[letter]) groups[letter] = [];
        groups[letter].push(b);
      });

      let html = '';
      Object.keys(groups).sort().forEach(letter => {
        html += `
          <div class="mb-4">
            <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 py-1.5">
              <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 border border-emerald-200 rounded-md px-2 py-0.5">${letter}</span>
            </div>
            <div class="space-y-1 mt-1">`;
        groups[letter].forEach(b => {
          const selected = document.getElementById('barangayIdInput').value == b.barangay_id;
          html += `
              <button type="button" onclick="handleBarangaySelect(${b.barangay_id}, '${String(b.barangay_name).replace(/'/g, "\\'")}')"
                      class="w-full flex items-center px-3 py-2 rounded-lg cursor-pointer transition-colors text-left ${selected ? 'bg-emerald-50 text-emerald-800 font-semibold' : 'text-gray-700 hover:bg-slate-50'}">
                ${b.barangay_name}
              </button>`;
        });
        html += `</div></div>`;
      });

      list.innerHTML = html;
    }

    // Filter the barangay list as the user types
    function filterBarangayModal() {
      renderBarangayModal(document.getElementById('barangayModalSearch').value);
    }

    // Handle barangay selection
    function handleBarangaySelect(id, name) {
      document.getElementById('barangayIdInput').value = id;
      document.getElementById('selectedBarangayText').textContent = name;
      closeBarangayModal();
    }
  </script>

  <!-- Barangay Selection Modal -->
  <div id="barangayModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="barangayModalTitle">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeBarangayModal()"></div>
    <div class="fixed inset-0 flex items-end sm:items-center sm:justify-center p-0 sm:p-4">
      <div class="bg-white rounded-t-2xl sm:rounded-2xl shadow-xl w-full sm:max-w-md max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="px-5 pt-5 pb-4 border-b border-gray-200">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 18h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
              </svg>
              <h3 id="barangayModalTitle" class="text-lg font-semibold text-gray-900">Select Barangay</h3>
            </div>
            <button type="button" onclick="closeBarangayModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors" aria-label="Close barangay selector">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <!-- Search bar (auto-focused on open) -->
          <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="barangayModalSearch" placeholder="Search barangay..." onkeyup="filterBarangayModal()"
                   class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" autocomplete="off">
          </div>
        </div>

        <!-- Modal Body -->
        <div class="flex-1 overflow-y-auto min-h-[360px]">
          <div class="px-5 pt-4 pb-4">
            <!-- Alphabetical List -->
            <div id="barangayModalList"></div>

            <!-- Empty search state -->
            <div id="barangayModalEmpty" class="hidden text-center py-8">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <p class="text-xs text-gray-700">No barangays match your search.</p>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
          <button type="button" onclick="closeBarangayModal()" class="w-full px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form persistence across page refreshes -->
  <script>
    (function() {
      var form = document.querySelector('form[action="{{ route('register') }}"]');
      if (!form) return;

      var key = 'register_form_v1';
      var SKIP = ['_token', 'password', 'password_confirmation'];

      function save() {
        var data = {};
        form.querySelectorAll('input, select, textarea').forEach(function(el) {
          var name = el.getAttribute('name');
          if (!name || SKIP.indexOf(name) !== -1) return;
          data[name] = el.type === 'checkbox' ? el.checked : el.value;
        });
        try { sessionStorage.setItem(key, JSON.stringify(data)); } catch(e) {}
      }

      function restore() {
        try {
          var data = JSON.parse(sessionStorage.getItem(key));
          if (!data) return;
          Object.keys(data).forEach(function(name) {
            var el = form.querySelector('[name="' + name + '"]');
            if (!el) return;
            if (el.type === 'checkbox') el.checked = data[name] === true;
            else el.value = data[name];
          });
        } catch(e) {}
      }

      function clear() {
        try { sessionStorage.removeItem(key); } catch(e) {}
      }

      form.addEventListener('input', save);
      form.addEventListener('change', save);
      form.addEventListener('submit', function(e) {
        if (!e.defaultPrevented) clear();
      });

      if (!{{ $errors->any() ? 'true' : 'false' }}) {
        restore();
      }
    })();
  </script>

</body>
</html>
