@extends('layouts.app')

@section('title', 'Notifications')

@section('header')
    <h2>🔔 Notifications</h2>
@endsection

@section('content')

    @if (session('status') === 'notification-deleted')
        <div class="alert alert-success">✅ Notification deleted.</div>
    @endif

    <div class="notification-page-header">
        <h3>All Notifications</h3>
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm">Mark all as read</button>
        </form>
    </div>

    @if($notifications->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🔔</div>
            <h3>No notifications yet</h3>
            <p>Things like tip likes and question replies will show up here.</p>
        </div>
    @else
        <div class="notification-list-page">
            @foreach($notifications as $notification)
                <div class="notification-row {{ $notification->read_at ? '' : 'notification-row-unread' }}">
                    <a href="{{ route('notifications.open', $notification->id) }}" class="notification-row-link">
                        <span class="notification-item-icon">{{ $notification->data['icon'] ?? '🔔' }}</span>
                        <div class="notification-item-body">
                            <p>{{ $notification->data['message'] ?? 'You have a new notification.' }}</p>
                            <span>{{ $notification->created_at->format('d M, Y — h:i A') }}</span>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="icon-btn icon-btn-danger" aria-label="Delete notification">🗑️</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="notification-pagination">
            @include('partials.pagination', ['paginator' => $notifications])
        </div>
    @endif

@endsection
