<!-- Universal Empty State Component -->
<div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4 text-slate-400">
        <i class="fa-solid fa-inbox text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $title ?? 'No Results Found' }}</h3>
    <p class="text-slate-500 text-sm max-w-xs mx-auto">{{ $message ?? 'There are currently no items to display. Check back soon.' }}</p>
</div>
