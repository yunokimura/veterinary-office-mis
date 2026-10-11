<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@if(session('success_pet'))
    @php
        $pet = session('success_pet');
        $petName = $pet['pet_name'] ?? 'Pet';
        $species = ucfirst($pet['species'] ?? 'Unknown');
        $breed = $pet['breed'] ?? 'Unknown';
        $refId = $pet['ref_id'] ?? 'N/A';
        $petImage = $pet['pet_image'] ?? 'images/pet.png';
    @endphp

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" onclick="closeSuccessModal(event)">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <!-- Success Icon -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Registration Successful!</h3>
                    <p class="text-gray-600 text-sm">{{ $petName }} has been successfully registered under your account.</p>
                </div>

                <!-- Pet Info Card -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <div class="flex items-start gap-4">
                        <!-- Pet Image -->
                        <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-slate-100">
                            <img src="{{ asset($petImage) }}" alt="{{ $petName }}" class="w-full h-full object-cover">
                        </div>
                        <!-- Pet Details -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $petName }}</h4>
                            <p class="text-sm text-gray-500 capitalize">{{ $species }} \u2022 {{ $breed }}</p>
                            <p class="text-xs text-gray-400 mt-1">Ref ID: <span class="font-mono text-gray-600">{{ $refId }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="p-6 pt-0 space-y-3">
                <button onclick="registerAnotherPet()" class="w-full py-3 px-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-colors">
                    + Register Another Pet
                </button>
                <button onclick="closeSuccessModal()" class="w-full py-3 px-4 border border-slate-300 text-gray-700 rounded-lg font-semibold hover:bg-slate-50 transition-colors">
                    Done
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeSuccessModal(event) {
            const modal = document.getElementById('successModal');
            if (event && event.target === modal) {
                modal.classList.add('hidden');
            } else if (!event) {
                modal.classList.add('hidden');
            }
        }

        function registerAnotherPet() {
            closeSuccessModal();
            window.location.href = '{{ url('/pet-registration/form') }}';
        }
    </script>
@endif
