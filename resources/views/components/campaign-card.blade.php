<!-- Campaign/Event Card -->
<article class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-shadow flex flex-col">
    @if($announcement->photo_path)
        <div class="relative h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                 alt="{{ $announcement->title }}"
                 class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
                 onerror="this.src='https://placehold.co/600x400/166534/ffffff?text=Announcement'">
            <span class="absolute top-4 left-4 {{ $announcement->category == 'campaign' ? 'bg-emerald-600' : 'bg-blue-600' }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                {{ ucfirst($announcement->category) }}
            </span>
        </div>
    @else
        <div class="relative h-48 bg-slate-200 overflow-hidden">
            <img src="https://placehold.co/600x400/166534/ffffff?text=Announcement" alt="Default announcement" class="w-full h-full object-cover">
            <span class="absolute top-4 left-4 {{ $announcement->category == 'campaign' ? 'bg-emerald-600' : 'bg-blue-600' }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                {{ ucfirst($announcement->category) }}
            </span>
        </div>
    @endif

    <div class="p-6 flex-1 flex flex-col justify-between">
        <div>
            <div class="text-xs text-slate-400 font-medium mb-2">
                <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3 hover:text-primary transition-colors">
                {{ $announcement->title }}
            </h3>
            <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 200) }}
            </p>
        </div>
        <a href="{{ route('announcements.show', $announcement) }}" class="inline-flex items-center text-primary font-semibold hover:underline text-sm">
            Read More <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
        </a>
    </div>
</article>
