@extends('layouts.client')

@section('title', 'Notifications - Dasmariñas City Veterinary Services')

@section('content')
<!-- Header / Navbar -->
@include('Client.partials.navbar')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Notifications</h1>
            <p class="text-sm text-slate-500 mt-1">Stay updated on your applications and appointments.</p>
        </div>
        @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="ml-4">
                @csrf
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        @forelse($notifications as $notification)
            <div class="p-4 border-b border-slate-100 last:border-0 {{ $notification->is_read ? 'bg-slate-50' : 'bg-white' }} hover:bg-slate-50/50 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-4 mb-1">
                            <h3 class="font-semibold text-slate-800 text-sm">{{ $notification->title }}</h3>
                            <span class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-600">{{ $notification->message }}</p>
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="mt-2 inline">
                                @csrf
                                <button type="submit" class="text-xs text-emerald-600 hover:text-emerald-800 underline underline-offset-2">Mark as read</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-500">
                <i class="fa-solid fa-bell-slash text-4xl mb-4 block"></i>
                <p class="text-sm font-medium">No notifications yet</p>
                <p class="text-xs text-slate-400 mt-1">You'll see updates here when your applications or appointments change status.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@endsection