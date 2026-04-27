<!-- Featured Campaign Card -->
<div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-3xl overflow-hidden shadow-lg">
    <div class="md:flex">
        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-md mb-4 md:mb-6">
                @if($announcement->photo_path)
                    <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
                         alt="{{ $announcement->title }}"
                         class="w-8 h-8 object-contain rounded-lg">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                @endif
            </div>
            
            <!-- Category Badge -->
            @if($announcement->category)
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium 
                        {{ $announcement->category == 'campaign' 
                            ? 'bg-primary/10 text-primary' 
                            : 'bg-secondary/10 text-secondary' }} mb-3">
                {{ ucfirst($announcement->category) }}
            </span>
            @endif
            
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">
                {{ $announcement->title }}
            </h3>
            
            <p class="text-gray-600 text-base md:text-lg mb-4">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 250) }}
            </p>

            <!-- Event Details -->
            <div class="flex flex-wrap gap-3 mb-4">
                @if($announcement->event_date)
                <div class="flex items-center space-x-2 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}</span>
                </div>
                @endif
                @if($announcement->location)
                <div class="flex items-center space-x-2 bg-white px-3 py-1.5 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm text-gray-700">{{ $announcement->location }}</span>
                </div>
                @endif
            </div>

            <!-- Action -->
            <a href="{{ route('announcements.show', $announcement) }}"
               class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-medium transition-colors w-full md:w-auto
                      {{ $announcement->category == 'campaign' 
                          ? 'bg-primary text-white hover:bg-primary-dark' 
                          : 'bg-secondary text-white hover:bg-secondary-dark' }}">
                View Program Details
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        @if($announcement->photo_path)
        <div class="md:w-1/2 flex items-center justify-center p-6">
            <div class="relative w-full max-w-lg">
                <div class="aspect-video bg-white rounded-2xl shadow-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                         alt="{{ $announcement->title }}"
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>