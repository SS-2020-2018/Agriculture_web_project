<?php

namespace App\Providers;

use App\View\Composers\NotificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*
      Register any application services.
     */
    public function register(): void
    {
        //
    }

    /*
      Bootstrap any application services.
     */
    public function boot(): void
    {
        // Shares $navbarNotifications and $unreadNotificationCount with
        // the navbar on every page — see App\View\Composers\NotificationComposer.
        View::composer('layouts.navigation', NotificationComposer::class);
    }
}
