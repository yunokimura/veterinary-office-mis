<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.admin', 'Client/layouts/navigation', 'Client/partials.navbar'], function ($view) {
            if (Auth::check()) {
                $unreadCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $unreadNotifications = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                $view->with([
                    'unreadCount' => $unreadCount,
                    'unreadNotifications' => $unreadNotifications,
                ]);
            }
        });
    }
}
