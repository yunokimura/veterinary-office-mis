<!-- Featured Announcement Card -->
<div class="bg-gradient-to-r from-emerald-50/50 to-blue-50/50 rounded-3xl overflow-hidden shadow-lg border border-white/50">
    <div class="md:flex">
        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide mb-4
                        {{ $announcement->category == 'campaign' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $announcement->category == 'campaign' ? 'Campaign' : 'Event' }}
            </div>
            
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 leading-tight">
                {{ $announcement->title }}
            </h3>
            
            <p class="text-gray-600 text-sm md:text-base mb-4 line-clamp-3">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
            </p>
            
            <div class="flex flex-wrap gap-2 mb-4">
                @if($announcement->event_date)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white rounded-lg shadow-sm text-xs text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                    @if($announcement->event_time) • {{ $announcement->event_time }} @endif
                </span>
                @endif
                @if($announcement->location)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white rounded-lg shadow-sm text-xs text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ \Str::limit($announcement->location, 30) }}
                </span>
                @endif
            </div>
            
            <button type="button" onclick="openAnnouncementModal({{ $announcement->id }})"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold transition-colors w-full md:w-auto
                           {{ $announcement->category == 'campaign' ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                View Details
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        
        @if($announcement->photo_path)
        <div class="md:w-1/2 p-4 flex items-center justify-center bg-white/30">
            <div class="w-full max-w-xs aspect-video rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                     alt="{{ $announcement->title }}"
                     class="w-full h-full object-cover">
            </div>
        </div>
        @endif
    </div>
</div>