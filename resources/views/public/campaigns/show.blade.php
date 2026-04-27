<!-- Campaign Detail for Modal -->
<div class="p-6">
    <!-- Category Badge -->
    <div class="flex items-center justify-between mb-4">
        <span class="bg-primary/10 text-primary text-sm font-bold px-4 py-2 rounded-full uppercase tracking-wide">
            Campaign
        </span>
        @if($announcement->event_date)
        <span class="text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
            @if($announcement->event_time) • {{ $announcement->event_time }} @endif
        </span>
        @endif
    </div>

    <!-- Title -->
    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
        {{ $announcement->title }}
    </h2>

    <!-- Featured Image -->
    @if($announcement->photo_path)
    <div class="mb-6">
        <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
             alt="{{ $announcement->title }}"
             class="w-full h-64 md:h-96 object-cover rounded-xl">
    </div>
    @endif

    <!-- Full Content -->
    <div class="prose prose-sm max-w-none mb-6">
        <p class="text-gray-700 leading-relaxed whitespace-pre-line">
            {!! nl2br(e($announcement->content)) !!}
        </p>
    </div>

    <!-- Event Details -->
    @if($announcement->event_time || $announcement->location || $announcement->contact_number)
    <div class="bg-gray-50 rounded-xl p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Event Details</h3>
        <div class="space-y-2">
            @if($announcement->event_time)
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-gray-700">{{ $announcement->event_time }}</span>
            </div>
            @endif
            @if($announcement->location)
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-gray-700">{{ $announcement->location }}</span>
            </div>
            @endif
            @if($announcement->contact_number)
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span class="text-gray-700">{{ $announcement->contact_number }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Attachment -->
    @if($announcement->attachment_path)
    <div class="mb-4">
        <a href="{{ asset('storage/' . $announcement->attachment_path) }}" target="_blank" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
            </svg>
            Download Attachment
        </a>
    </div>
    @endif
</div>