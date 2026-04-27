<!-- Announcement Card - Compact Fixed Height -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden" style="height: 320px;">
    @if($announcement->photo_path)
        <!-- Layout with image: text left, image right -->
        <div class="h-full flex">
            <div class="w-3/5 p-5 overflow-y-auto">
                <!-- Category Badge -->
                <div class="flex items-center space-x-2 mb-3">
                    @if($announcement->category)
                    <span class="
                        {{ $announcement->category == 'campaign' 
                            ? 'bg-emerald-100 text-emerald-700' 
                            : 'bg-blue-100 text-blue-700' }} 
                        text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                        {{ $announcement->category == 'campaign' ? 'Campaign' : 'Event' }}
                    </span>
                    @endif
                </div>
                
                <!-- Title -->
                <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                    {{ $announcement->title }}
                </h3>
                
                <!-- Date -->
                @if($announcement->event_date)
                <div class="flex items-center space-x-1.5 text-xs text-gray-400 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}</span>
                    @if($announcement->event_time)
                    <span class="mx-1">•</span>
                    <span>{{ $announcement->event_time }}</span>
                    @endif
                </div>
                @endif
                
                <!-- Content Preview -->
                <p class="text-xs text-gray-600 mb-3 line-clamp-3 leading-relaxed">
                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 180) }}
                </p>
                
                <!-- Learn More Trigger -->
                <button type="button" 
                        onclick="openAnnouncementModal({{ $announcement->id }})"
                        class="inline-flex items-center gap-1.5 text-xs font-bold transition-colors
                               {{ $announcement->category == 'campaign' 
                                   ? 'text-emerald-600 hover:text-emerald-700' 
                                   : 'text-blue-600 hover:text-blue-700' }}">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="w-2/5 h-full">
                <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                     alt="{{ $announcement->title }}"
                     class="w-full h-full object-cover">
            </div>
        </div>
    @else
        <!-- Layout without image: centered -->
        <div class="h-full flex flex-col items-center justify-center p-6 text-center max-w-sm mx-auto">
            <!-- Category Badge -->
            <div class="flex items-center space-x-2 mb-3">
                @if($announcement->category)
                <span class="
                    {{ $announcement->category == 'campaign' 
                        ? 'bg-emerald-100 text-emerald-700' 
                        : 'bg-blue-100 text-blue-700' }} 
                    text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                    {{ $announcement->category == 'campaign' ? 'Campaign' : 'Event' }}
                </span>
                @endif
            </div>
            
            <!-- Icon -->
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3
                        {{ $announcement->category == 'campaign' 
                            ? 'bg-emerald-100' 
                            : 'bg-blue-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 
                     {{ $announcement->category == 'campaign' 
                         ? 'text-emerald-600' 
                         : 'text-blue-600' }}" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-sm font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                {{ $announcement->title }}
            </h3>
            
            <!-- Date -->
            @if($announcement->event_date)
            <div class="flex items-center space-x-1.5 text-xs text-gray-400 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}</span>
                @if($announcement->event_time)
                <span class="mx-1">•</span>
                <span>{{ $announcement->event_time }}</span>
                @endif
            </div>
            @endif
            
            <!-- Content Preview -->
            <p class="text-xs text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}
            </p>
            
            <!-- Learn More Trigger -->
            <button type="button"
                    onclick="openAnnouncementModal({{ $announcement->id }})"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors
                           {{ $announcement->category == 'campaign' 
                               ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' 
                               : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                Learn More
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    @endif
</div>