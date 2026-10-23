    <!-- Footer Section -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white overflow-hidden">
                            <img src="{{ asset('images/Dasmalogof.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="block font-extrabold text-xl text-white">City of Dasmariñas</span>
                            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Veterinary Services</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Supporting the "Zero by 2030" goal by delivering accessible anti-rabies vaccinations, spay/neuter (kapon) services, and pet registration across all 75 barangays for a rabies-free community.
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-primary text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">Home Page</a></li>
                        <li><a href="{{ url('/about-us') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ url('/services') }}" class="hover:text-white transition-colors">Services Overview</a></li>
                        <li><a href="{{ url('/adoption') ?? '#' }}" class="hover:text-white transition-colors">Adoption</a></li>
                        <li><a href="{{ url('/missing-pets') }}" class="hover:text-white transition-colors">Lost &amp; Found Pets</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Services</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ url('/pet-registration') }}" class="hover:text-white transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="hover:text-white transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="{{ url('/kapon') }}" class="hover:text-white transition-colors">Spay/Neuter (Kapon)</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Emergency Contact</h4>
                    <div class="space-y-3 text-sm text-slate-400">
                        <p class="flex items-center"><i class="fa-solid fa-phone text-primary mr-2"></i> 0966-881-2010</p>
                        <p class="flex items-center"><i class="fa-solid fa-envelope text-primary mr-2"></i> vetdasma@yahoo.com</p>
                        <p class="flex items-start"><i class="fa-solid fa-location-dot text-primary mr-2 mt-1"></i> Brgy. Langkaan 2, Sitio Buwisan, Dasmariñas City, Cavite</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 City of Dasmariñas Veterinary Services. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-slate-400">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400">Terms of Service</a>
                    <a href="#" class="hover:text-slate-400">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>
