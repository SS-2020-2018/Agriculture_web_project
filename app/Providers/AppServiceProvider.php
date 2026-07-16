<?php

namespace App\Providers;

use App\View\Composers\AdminSidebarComposer;
use App\View\Composers\NotificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Shares $navbarNotifications and $unreadNotificationCount with
        // both the farmer navbar AND the admin panel's top bar —
        // see App\View\Composers\NotificationComposer.
        View::composer(['layouts.navigation', 'layouts.admin'], NotificationComposer::class);

        // Shares $unreadContactMessagesCount with the admin sidebar's
        // "Messages" badge only (Phase 15b).
        View::composer('layouts.admin', AdminSidebarComposer::class);
    }
}
