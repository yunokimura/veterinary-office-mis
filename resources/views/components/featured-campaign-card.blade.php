<!-- Featured Campaign Card -->
<div class="featured-campaign-card relative bg-gradient-to-br from-primary/5 via-white to-secondary/5 rounded-3xl overflow-hidden shadow-xl">
    <!-- Animated Top Border -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-secondary to-primary"></div>
    
    <!-- Featured Badge -->
    <div class="absolute top-4 right-4 z-10">
        <div class="flex items-center space-x-1 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-xs font-bold text-gray-700">FEATURED</span>
        </div>
    </div>

    <div class="md:flex">
        <!-- Left Content -->
        <div class="md:w-1/2 p-6 md:p-8 lg:p-10 flex flex-col justify-center">
            <!-- Category Badge with Icon -->
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm
                            {{ $announcement->category == 'campaign' 
                                ? 'bg-primary text-white' 
                                : 'bg-blue-600 text-white' }}">
                    @if($announcement->category == 'campaign')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    @endif
                </div>
                <span class="
                    {{ $announcement->category == 'campaign' 
                        ? 'bg-primary/10 text-primary border-primary/20' 
                        : 'bg-blue-50 text-blue-700 border-blue-200' }} 
                    text-sm font-bold px-4 py-1.5 rounded-full border uppercase tracking-wide">
                    {{ ucfirst($announcement->category) }}
                </span>
            </div>

            <!-- Title with Gradient -->
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $announcement->title }}
            </h3>

            <!-- Content -->
            <p class="text-gray-600 text-base md:text-lg mb-6 leading-relaxed">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 250) }}
            </p>

            <!-- Event Details as Stat Cards -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                @if($announcement->event_date)
                <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-primary/30 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Date</p>
                    </div>
                    <p class="text-sm font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                    </p>
                </div>
                @endif
                @if($announcement->location)
                <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-primary/30 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Location</p>
                    </div>
                    <p class="text-sm font-bold text-gray-900">{{ $announcement->location }}</p>
                </div>
                @endif
            </div>

            <!-- Action Button -->
            <a href="{{ route('announcements.show', $announcement) }}"
               class="group inline-flex items-center justify-center px-6 py-3.5 rounded-xl font-semibold transition-all duration-300
                      {{ $announcement->category == 'campaign' 
                          ? 'bg-primary text-white hover:bg-primary-dark shadow-lg hover:shadow-xl hover:-translate-y-0.5' 
                          : 'bg-blue-600 text-white hover:bg-blue-700 shadow-lg hover:shadow-xl hover:-translate-y-0.5' }}
                      focus:outline-none focus:ring-2 focus:ring-offset-2
                      {{ $announcement->category == 'campaign' 
                          ? 'focus:ring-primary' 
                          : 'focus:ring-blue-600' }}">
                <span>View Program Details</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>

        <!-- Right Image -->
        @if($announcement->photo_path)
        <div class="md:w-1/2 relative overflow-hidden bg-gray-100">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-10"></div>
            <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                 alt="{{ $announcement->title }}"
                 class="featured-image w-full h-64 md:h-full object-cover transition-transform duration-500 hover:scale-105">
        </div>
        @endif
    </div>
</div>