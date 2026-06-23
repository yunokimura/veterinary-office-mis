<!-- Campaign/Event Card -->
<div class="campaign-card bg-white rounded-2xl shadow-lg overflow-hidden 
            {{ $announcement->category == 'campaign' ? 'campaign-category' : 'program-category' }} 
            max-w-4xl mx-auto">
    
    @if($announcement->photo_path)
        <!-- Card WITH photo: text left, image right on desktop -->
        <div class="md:flex">
            <div class="md:w-3/5 p-6 md:p-8">
                <!-- Category Badge with Icon -->
                <div class="flex items-center space-x-3 mb-4">
                    <div class="category-icon w-10 h-10 rounded-lg flex items-center justify-center
                                {{ $announcement->category == 'campaign' 
                                    ? 'bg-primary/10' 
                                    : 'bg-blue-100' }}">
                        @if($announcement->category == 'campaign')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        @endif
                    </div>
                    <span class="
                        {{ $announcement->category == 'campaign' 
                            ? 'bg-primary/10 text-primary border-primary/20' 
                            : 'bg-blue-50 text-blue-700 border-blue-200' }} 
                        text-sm font-semibold px-3 py-1.5 rounded-full border">
                        {{ ucfirst($announcement->category) }}
                    </span>
                </div>

                <!-- Published Date -->
                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Published: {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}</span>
                </div>

                <!-- Title -->
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $announcement->title }}
                </h2>

                <!-- Content with fade effect -->
                <div class="content-fade">
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
                    </p>
                </div>

                <!-- Event Details Grid -->
                @if($announcement->event_time || $announcement->location || $announcement->contact_number)
                <div class="grid sm:grid-cols-2 gap-3 mb-5">
                    @if($announcement->event_time)
                    <div class="event-detail-card rounded-lg p-3 flex items-start space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 mb-0.5">Event Time</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->event_time }}</p>
                        </div>
                    </div>
                    @endif
                    @if($announcement->location)
                    <div class="event-detail-card rounded-lg p-3 flex items-start space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 mb-0.5">Location</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->location }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Contact -->
                @if($announcement->contact_number)
                <div class="flex items-center space-x-2 text-sm text-primary mb-5 bg-primary/5 rounded-lg px-3 py-2 inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-medium">{{ $announcement->contact_number }}</span>
                </div>
                @endif

                <!-- Action Button -->
                <button onclick="openAnnouncementModal({{ $announcement->id }})"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg font-semibold transition-all cursor-pointer
                               {{ $announcement->category == 'campaign' 
                                   ? 'bg-primary text-white hover:bg-primary-dark shadow-md hover:shadow-lg' 
                                   : 'bg-blue-600 text-white hover:bg-blue-700 shadow-md hover:shadow-lg' }}
                               focus:outline-none focus:ring-2 focus:ring-offset-2
                               {{ $announcement->category == 'campaign' 
                                   ? 'focus:ring-primary' 
                                   : 'focus:ring-blue-600' }}">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
            <div class="md:w-2/5 relative overflow-hidden bg-gray-100">
                <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
                     alt="{{ $announcement->title }}"
                     class="card-image w-full h-64 md:h-full object-cover">
                <div class="image-overlay"></div>
            </div>
        </div>
    @else
        <!-- Card WITHOUT photo: centered, full width -->
        <div class="p-6 md:p-8">
            <!-- Category Badge with Icon -->
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="category-icon w-10 h-10 rounded-lg flex items-center justify-center
                            {{ $announcement->category == 'campaign' 
                                ? 'bg-primary/10' 
                                : 'bg-blue-100' }}">
                    @if($announcement->category == 'campaign')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    @endif
                </div>
                <span class="
                    {{ $announcement->category == 'campaign' 
                        ? 'bg-primary/10 text-primary border-primary/20' 
                        : 'bg-blue-50 text-blue-700 border-blue-200' }} 
                    text-sm font-semibold px-3 py-1.5 rounded-full border">
                    {{ ucfirst($announcement->category) }}
                </span>
            </div>

            <!-- Published Date -->
            <div class="flex items-center justify-center space-x-2 text-sm text-gray-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Published: {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}</span>
            </div>

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 text-center leading-tight">
                {{ $announcement->title }}
            </h2>

            <!-- Content with fade effect -->
            <div class="content-fade">
                <p class="text-gray-600 mb-4 text-center line-clamp-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
                </p>
            </div>

            <!-- Event Details Grid -->
            @if($announcement->event_time || $announcement->location || $announcement->contact_number)
            <div class="grid sm:grid-cols-2 gap-3 mb-5 max-w-2xl mx-auto">
                @if($announcement->event_time)
                <div class="event-detail-card rounded-lg p-3 flex items-start space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-500 mb-0.5">Event Time</p>
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->event_time }}</p>
                    </div>
                </div>
                @endif
                @if($announcement->location)
                <div class="event-detail-card rounded-lg p-3 flex items-start space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-500 mb-0.5">Location</p>
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->location }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Contact -->
            @if($announcement->contact_number)
            <div class="flex items-center justify-center space-x-2 text-sm text-primary mb-5 bg-primary/5 rounded-lg px-3 py-2 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span class="font-medium">{{ $announcement->contact_number }}</span>
            </div>
            @endif

            <!-- Action Button -->
            <div class="text-center">
                <button onclick="openAnnouncementModal({{ $announcement->id }})"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg font-semibold transition-all cursor-pointer
                               {{ $announcement->category == 'campaign' 
                                   ? 'bg-primary text-white hover:bg-primary-dark shadow-md hover:shadow-lg' 
                                   : 'bg-blue-600 text-white hover:bg-blue-700 shadow-md hover:shadow-lg' }}
                               focus:outline-none focus:ring-2 focus:ring-offset-2
                               {{ $announcement->category == 'campaign' 
                                   ? 'focus:ring-primary' 
                                   : 'focus:ring-blue-600' }}">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>