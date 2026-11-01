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

              <!-- Block/Lot/Phase/House No. -->
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                  Block/Lot/Phase/House No. <span class="text-red-500">*</span>
                </label>
                <div class="flex rounded-xl border border-gray-200 overflow-hidden focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                  <div class="flex items-center px-3 py-3 bg-gray-50/50 border-r border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Blk</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_1" value="{{ old('block_lot_phase_house_no_1') }}"
                         class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="2" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-3 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Lot</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_2" value="{{ old('block_lot_phase_house_no_2') }}"
                         class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="2" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-3 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">Ph</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_3" value="{{ old('block_lot_phase_house_no_3') }}"
                         class="w-full px-2 py-3 outline-none bg-white text-center" placeholder="" maxlength="1" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <div class="flex items-center px-3 py-3 bg-gray-50/50 border-r border-l border-gray-200">
                    <span class="text-xs text-gray-600 whitespace-nowrap">House No.</span>
                  </div>
                  <input type="text" name="block_lot_phase_house_no_4" value="{{ old('block_lot_phase_house_no_4') }}"
                         class="w-full px-2 py-3 outline-none bg-white text-center rounded-r-xl" placeholder="" maxlength="2" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
                <select name="barangay" class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition appearance-none pr-10 @error('barangay') border-red-500 @enderror"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px 12px;">
                  <option value="">Select Barangay</option>
                  <option value="Burol I" {{ old('barangay') == 'Burol I' ? 'selected' : '' }}>Burol I</option>
                  <option value="Burol II" {{ old('barangay') == 'Burol II' ? 'selected' : '' }}>Burol II</option>
                  <option value="Burol III" {{ old('barangay') == 'Burol III' ? 'selected' : '' }}>Burol III</option>
                  <option value="Burol Main" {{ old('barangay') == 'Burol Main' ? 'selected' : '' }}>Burol Main</option>
                  <option value="Datu Esmael (Bago-A-Ingud)" {{ old('barangay') == 'Datu Esmael (Bago-A-Ingud)' ? 'selected' : '' }}>Datu Esmael (Bago-A-Ingud)</option>
                  <option value="Emmanuel Bergaod I" {{ old('barangay') == 'Emmanuel Bergaod I' ? 'selected' : '' }}>Emmanuel Bergaod I</option>
                  <option value="Emmanuel Bergaod II" {{ old('barangay') == 'Emmanuel Bergaod II' ? 'selected' : '' }}>Emmanuel Bergaod II</option>
                  <option value="Fatima I" {{ old('barangay') == 'Fatima I' ? 'selected' : '' }}>Fatima I</option>
                  <option value="Fatima II" {{ old('barangay') == 'Fatima II' ? 'selected' : '' }}>Fatima II</option>
                  <option value="Fatima III" {{ old('barangay') == 'Fatima III' ? 'selected' : '' }}>Fatima III</option>
                  <option value="H-2 (Sta. Veronica)" {{ old('barangay') == 'H-2 (Sta. Veronica)' ? 'selected' : '' }}>H-2 (Sta. Veronica)</option>
                  <option value="Langkaan I (Humayao)" {{ old('barangay') == 'Langkaan I (Humayao)' ? 'selected' : '' }}>Langkaan I (Humayao)</option>
                  <option value="Langkaan II" {{ old('barangay') == 'Langkaan II' ? 'selected' : '' }}>Langkaan II</option>
                  <option value="Luzviminda I" {{ old('barangay') == 'Luzviminda I' ? 'selected' : '' }}>Luzviminda I</option>
                  <option value="Luzviminda II" {{ old('barangay') == 'Luzviminda II' ? 'selected' : '' }}>Luzviminda II</option>
                  <option value="Paliparan I" {{ old('barangay') == 'Paliparan I' ? 'selected' : '' }}>Paliparan I</option>
                  <option value="Paliparan II" {{ old('barangay') == 'Paliparan II' ? 'selected' : '' }}>Paliparan II</option>
                  <option value="Paliparan III" {{ old('barangay') == 'Paliparan III' ? 'selected' : '' }}>Paliparan III</option>
                  <option value="Sabang" {{ old('barangay') == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                  <option value="Saint Peter I" {{ old('barangay') == 'Saint Peter I' ? 'selected' : '' }}>Saint Peter I</option>
                  <option value="Saint Peter II" {{ old('barangay') == 'Saint Peter II' ? 'selected' : '' }}>Saint Peter II</option>
                  <option value="Salawag" {{ old('barangay') == 'Salawag' ? 'selected' : '' }}>Salawag</option>
                  <option value="Salitran I" {{ old('barangay') == 'Salitran I' ? 'selected' : '' }}>Salitran I</option>
                  <option value="Salitran II" {{ old('barangay') == 'Salitran II' ? 'selected' : '' }}>Salitran II</option>
                  <option value="Salitran III" {{ old('barangay') == 'Salitran III' ? 'selected' : '' }}>Salitran III</option>
                  <option value="Salitran IV" {{ old('barangay') == 'Salitran IV' ? 'selected' : '' }}>Salitran IV</option>
                  <option value="Sampaloc I (Pala-Pala)" {{ old('barangay') == 'Sampaloc I (Pala-Pala)' ? 'selected' : '' }}>Sampaloc I (Pala-Pala)</option>
                  <option value="Sampaloc II (Bucal/Malinta)" {{ old('barangay') == 'Sampaloc II (Bucal/Malinta)' ? 'selected' : '' }}>Sampaloc II (Bucal/Malinta)</option>
                  <option value="Sampaloc III (Piela)" {{ old('barangay') == 'Sampaloc III (Piela)' ? 'selected' : '' }}>Sampaloc III (Piela)</option>
                  <option value="Sampaloc IV (Talisayan/Bautista)" {{ old('barangay') == 'Sampaloc IV (Talisayan/Bautista)' ? 'selected' : '' }}>Sampaloc IV (Talisayan/Bautista)</option>
                  <option value="Sampaloc V (New Era)" {{ old('barangay') == 'Sampaloc V (New Era)' ? 'selected' : '' }}>Sampaloc V (New Era)</option>
                  <option value="San Augustin I" {{ old('barangay') == 'San Augustin I' ? 'selected' : '' }}>San Augustin I</option>
                  <option value="San Augustin II (R. Tirona)" {{ old('barangay') == 'San Augustin II (R. Tirona)' ? 'selected' : '' }}>San Augustin II (R. Tirona)</option>
                  <option value="San Augustin III" {{ old('barangay') == 'San Augustin III' ? 'selected' : '' }}>San Augustin III</option>
                  <option value="San Andres I" {{ old('barangay') == 'San Andres I' ? 'selected' : '' }}>San Andres I</option>
                  <option value="San Andres II" {{ old('barangay') == 'San Andres II' ? 'selected' : '' }}>San Andres II</option>
                  <option value="San Antonio De Padua I" {{ old('barangay') == 'San Antonio De Padua I' ? 'selected' : '' }}>San Antonio De Padua I</option>
                  <option value="San Antonio De Padua II" {{ old('barangay') == 'San Antonio De Padua II' ? 'selected' : '' }}>San Antonio De Padua II</option>
                  <option value="San Dionisio" {{ old('barangay') == 'San Dionisio' ? 'selected' : '' }}>San Dionisio</option>
                  <option value="San Esteban" {{ old('barangay') == 'San Esteban' ? 'selected' : '' }}>San Esteban</option>
                  <option value="San Fransisco I" {{ old('barangay') == 'San Fransisco I' ? 'selected' : '' }}>San Fransisco I</option>
                  <option value="San Fransisco II" {{ old('barangay') == 'San Fransisco II' ? 'selected' : '' }}>San Fransisco II</option>
                  <option value="San Isidro Labrador I" {{ old('barangay') == 'San Isidro Labrador I' ? 'selected' : '' }}>San Isidro Labrador I</option>
                  <option value="San Isidro Labrador II" {{ old('barangay') == 'San Isidro Labrador II' ? 'selected' : '' }}>San Isidro Labrador II</option>
                  <option value="San Jose" {{ old('barangay') == 'San Jose' ? 'selected' : '' }}>San Jose</option>
                  <option value="San Juan" {{ old('barangay') == 'San Juan' ? 'selected' : '' }}>San Juan</option>
                  <option value="San Lorenzo Ruiz I" {{ old('barangay') == 'San Lorenzo Ruiz I' ? 'selected' : '' }}>San Lorenzo Ruiz I</option>
                  <option value="San Lorenzo Ruiz II" {{ old('barangay') == 'San Lorenzo Ruiz II' ? 'selected' : '' }}>San Lorenzo Ruiz II</option>
                  <option value="San Luis I" {{ old('barangay') == 'San Luis I' ? 'selected' : '' }}>San Luis I</option>
                  <option value="San Luis II" {{ old('barangay') == 'San Luis II' ? 'selected' : '' }}>San Luis II</option>
                  <option value="San Manuel I" {{ old('barangay') == 'San Manuel I' ? 'selected' : '' }}>San Manuel I</option>
                  <option value="San Manuel II" {{ old('barangay') == 'San Manuel II' ? 'selected' : '' }}>San Manuel II</option>
                  <option value="San Mateo" {{ old('barangay') == 'San Mateo' ? 'selected' : '' }}>San Mateo</option>
                  <option value="San Miguel I" {{ old('barangay') == 'San Miguel I' ? 'selected' : '' }}>San Miguel I</option>
                  <option value="San Miguel II" {{ old('barangay') == 'San Miguel II' ? 'selected' : '' }}>San Miguel II</option>
                  <option value="San Nicolas I" {{ old('barangay') == 'San Nicolas I' ? 'selected' : '' }}>San Nicolas I</option>
                  <option value="San Nicolas II" {{ old('barangay') == 'San Nicolas II' ? 'selected' : '' }}>San Nicolas II</option>
                  <option value="San Roque" {{ old('barangay') == 'San Roque' ? 'selected' : '' }}>San Roque</option>
                  <option value="San Simon" {{ old('barangay') == 'San Simon' ? 'selected' : '' }}>San Simon</option>
                  <option value="Santa Cristina I" {{ old('barangay') == 'Santa Cristina I' ? 'selected' : '' }}>Santa Cristina I</option>
                  <option value="Santa Cristina II" {{ old('barangay') == 'Santa Cristina II' ? 'selected' : '' }}>Santa Cristina II</option>
                  <option value="Santa Cruz I" {{ old('barangay') == 'Santa Cruz I' ? 'selected' : '' }}>Santa Cruz I</option>
                  <option value="Santa Cruz II" {{ old('barangay') == 'Santa Cruz II' ? 'selected' : '' }}>Santa Cruz II</option>
                  <option value="Santa Fe" {{ old('barangay') == 'Santa Fe' ? 'selected' : '' }}>Santa Fe</option>
                  <option value="Santa Lucia" {{ old('barangay') == 'Santa Lucia' ? 'selected' : '' }}>Santa Lucia</option>
                  <option value="Santa Maria" {{ old('barangay') == 'Santa Maria' ? 'selected' : '' }}>Santa Maria</option>
                  <option value="Santo Cristo" {{ old('barangay') == 'Santo Cristo' ? 'selected' : '' }}>Santo Cristo</option>
                  <option value="Santo Niño I" {{ old('barangay') == 'Santo Niño I' ? 'selected' : '' }}>Santo Niño I</option>
                  <option value="Santo Niño II" {{ old('barangay') == 'Santo Niño II' ? 'selected' : '' }}>Santo Niño II</option>
                  <option value="Victoria Reyes" {{ old('barangay') == 'Victoria Reyes' ? 'selected' : '' }}>Victoria Reyes</option>
                  <option value="Zone I" {{ old('barangay') == 'Zone I' ? 'selected' : '' }}>Zone I</option>
                  <option value="Zone I-A" {{ old('barangay') == 'Zone I-A' ? 'selected' : '' }}>Zone I-A</option>
                  <option value="Zone II" {{ old('barangay') == 'Zone II' ? 'selected' : '' }}>Zone II</option>
                  <option value="Zone III" {{ old('barangay') == 'Zone III' ? 'selected' : '' }}>Zone III</option>
                  <option value="Zone IV" {{ old('barangay') == 'Zone IV' ? 'selected' : '' }}>Zone IV</option>
                </select>
                @error('barangay')
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
  </script>

</body>
</html>
