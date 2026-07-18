<?php

namespace App\View\Composers;

use App\Models\ContactMessage;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /*
      Shares the unread contact-message count with the admin sidebar's
      "Messages" link badge. Kept as its own composer (rather than
      folding into NotificationComposer) so this extra query only ever
      runs on admin pages, never on farmer pages.
     */
    public function compose(View $view): void
    {
        $view->with('unreadContactMessagesCount', ContactMessage::where('is_read', false)->count());
    }
}
