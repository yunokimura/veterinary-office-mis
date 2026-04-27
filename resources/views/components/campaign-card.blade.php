<!-- Campaign/Event Card -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover max-w-5xl mx-auto">
    @if($announcement->photo_path)
        <!-- Card WITH photo: text left, image right on desktop -->
        <div class="md:flex">
            <div class="md:w-2/3 p-6 md:p-8">
                <!-- Category Badge -->
                <div class="flex items-center space-x-3 mb-4">
                    @if($announcement->category)
                    <span class="
                        {{ $announcement->category == 'campaign' 
                            ? 'bg-primary/10 text-primary' 
                            : 'bg-secondary/10 text-secondary' }} 
                        text-sm font-medium px-3 py-1 rounded-full">
                        {{ ucfirst($announcement->category) }}
                    </span>
                    @endif
                    @if($announcement->event_date)
                    <span class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">
                    {{ $announcement->title }}
                </h2>

                <!-- Content -->
                <p class="text-gray-600 mb-4">
                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
                </p>

                <!-- Event Details Grid -->
                @if($announcement->event_time || $announcement->location || $announcement->contact_number)
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    @if($announcement->event_time)
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-700">{{ $announcement->event_time }}</span>
                    </div>
                    @endif
                    @if($announcement->location)
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-700">{{ $announcement->location }}</span>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Contact -->
                @if($announcement->contact_number)
                <div class="flex items-center space-x-2 text-sm text-primary mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $announcement->contact_number }}</span>
                </div>
                @endif

                <!-- Action Button - Modal -->
                <button onclick="openAnnouncementModal({{ $announcement->id }})"
                        class="inline-flex items-center px-4 py-2 rounded-lg font-medium transition-colors cursor-pointer
                               {{ $announcement->category == 'campaign' 
                                   ? 'bg-primary text-white hover:bg-primary-dark' 
                                   : 'bg-secondary text-white hover:bg-secondary-dark' }}">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="md:w-1/3 bg-gray-100">
                <img src="{{ asset('storage/' . $announcement->photo_path) }}" 
                     alt="{{ $announcement->title }}"
                     class="w-full h-64 md:h-80 object-cover">
            </div>
        </div>
    @else
        <!-- Card WITHOUT photo: centered, reduced width -->
        <div class="p-6 md:p-8">
            <!-- Category Badge -->
            <div class="flex items-center justify-center space-x-3 mb-4">
                @if($announcement->category)
                <span class="
                    {{ $announcement->category == 'campaign' 
                        ? 'bg-primary/10 text-primary' 
                        : 'bg-secondary/10 text-secondary' }} 
                    text-sm font-medium px-3 py-1 rounded-full">
                    {{ ucfirst($announcement->category) }}
                </span>
                @endif
                @if($announcement->event_date)
                <span class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($announcement->event_date)->format('M d, Y') }}
                </span>
                @endif
            </div>

            <!-- Title -->
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 text-center">
                {{ $announcement->title }}
            </h2>

            <!-- Content -->
            <p class="text-gray-600 mb-4 text-center">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
            </p>

            <!-- Event Details Grid -->
            @if($announcement->event_time || $announcement->location || $announcement->contact_number)
            <div class="grid sm:grid-cols-2 gap-4 mb-4">
                @if($announcement->event_time)
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-gray-700">{{ $announcement->event_time }}</span>
                </div>
                @endif
                @if($announcement->location)
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-gray-700">{{ $announcement->location }}</span>
                </div>
                @endif
            </div>
            @endif

            <!-- Contact -->
            @if($announcement->contact_number)
            <div class="flex items-center justify-center space-x-2 text-sm text-primary mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>{{ $announcement->contact_number }}</span>
            </div>
            @endif

            <!-- Action Button - Modal -->
            <div class="text-center">
                <button onclick="openAnnouncementModal({{ $announcement->id }})"
                        class="inline-flex items-center px-4 py-2 rounded-lg font-medium transition-colors cursor-pointer
                               {{ $announcement->category == 'campaign' 
                                   ? 'bg-primary text-white hover:bg-primary-dark' 
                                   : 'bg-secondary text-white hover:bg-secondary-dark' }}">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
