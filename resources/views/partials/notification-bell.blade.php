<div class="navbar-notifications">
    <button class="notification-trigger" id="notificationTrigger" type="button" aria-label="Open notifications">
        🔔
        @if($unreadNotificationCount > 0)
            <span class="notification-badge">{{ $unreadNotificationCount > 9 ? '9+' : $unreadNotificationCount }}</span>
        @endif
    </button>

    <div class="notification-dropdown" id="notificationDropdown">
        <div class="notification-dropdown-header">
            <strong>Notifications</strong>
            @if($unreadNotificationCount > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="notification-mark-all-btn">Mark all as read</button>
                </form>
            @endif
        </div>

        <div class="notification-dropdown-list">
            @forelse($navbarNotifications as $notification)
                <a href="{{ route('notifications.open', $notification->id) }}"
                   class="notification-item {{ $notification->read_at ? '' : 'notification-item-unread' }}">
                    <span class="notification-item-icon">{{ $notification->data['icon'] ?? '🔔' }}</span>
                    <div class="notification-item-body">
                        <p>{{ $notification->data['message'] ?? 'You have a new notification.' }}</p>
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="notification-empty">No notifications yet.</div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}" class="notification-view-all">View All Notifications</a>
    </div>
</div>
