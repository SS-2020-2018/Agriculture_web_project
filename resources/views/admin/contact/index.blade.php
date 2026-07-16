@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('header')
    <h2>✉️ Contact Messages</h2>
@endsection

@section('content')

    @if (session('status') === 'message-deleted')
        <div class="alert alert-success">✅ Message deleted.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $messages->count() }}</span>
            <span class="crop-stat-label">Total Messages</span>
        </div>
        <div class="crop-stat-box" style="border-left-color:#00897b">
            <span class="crop-stat-number">{{ $unreadCount }}</span>
            <span class="crop-stat-label">Unread</span>
        </div>
    </div>

    <div class="disease-toolbar">
        <input type="text" id="messageSearch" class="reminder-search-input" placeholder="🔍 Search by name, email, or subject...">

        <div class="reminder-filter-buttons" id="messageStatusFilter">
            <button type="button" class="filter-btn active" data-status="all">All</button>
            <button type="button" class="filter-btn" data-status="unread">Unread</button>
            <button type="button" class="filter-btn" data-status="read">Read</button>
        </div>
    </div>

    @if($messages->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">✉️</div>
            <h3>No messages received yet</h3>
            <p>Submissions from the Home Page contact form will show up here.</p>
        </div>
    @else
        <div class="qa-admin-list" id="messageAdminList">
            @foreach($messages as $message)
                <a href="{{ route('admin.contact.show', $message) }}"
                   class="qa-admin-row {{ $message->is_read ? '' : 'message-row-unread' }}"
                   data-title="{{ strtolower($message->name.' '.$message->email.' '.$message->subject) }}"
                   data-status="{{ $message->is_read ? 'read' : 'unread' }}">

                    <div class="qa-admin-avatar qa-admin-avatar-placeholder">{{ $message->is_read ? '📖' : '✉️' }}</div>

                    <div class="qa-admin-row-body">
                        <div class="qa-admin-row-header">
                            <strong>{{ $message->name }}</strong>
                            @unless($message->is_read)
                                <span class="qa-status-badge qa-status-pending">New</span>
                            @endunless
                        </div>
                        <p>{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 80) }}</p>
                        <span class="qa-admin-row-date">{{ $message->email }} • {{ $message->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="messageNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching messages</h3>
        </div>
    @endif

@endsection
