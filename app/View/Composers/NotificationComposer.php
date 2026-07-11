<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer
{
    /*
      Shares the 5 most recent notifications and the unread count with
      layouts.navigation, so the bell icon works on every authenticated
      page without every controller having to remember to pass it in.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();

        if (! $user) {
            $view->with([
                'navbarNotifications' => collect(),
                'unreadNotificationCount' => 0,
            ]);

            return;
        }

        $view->with([
            'navbarNotifications' => $user->notifications()->latest()->take(5)->get(),
            'unreadNotificationCount' => $user->unreadNotifications()->count(),
        ]);
    }
}
