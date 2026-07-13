@extends('layouts.admin')

@section('title', 'Feedback Management')

@section('header')
    <h2>⭐ Feedback Management</h2>
@endsection

@section('content')

    @if (session('status') === 'feedback-reviewed')
        <div class="alert alert-success">✅ Feedback marked as reviewed.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $feedbackEntries->count() }}</span>
            <span class="crop-stat-label">Total Feedback</span>
        </div>
        <div class="crop-stat-box crop-stat-orange">
            <span class="crop-stat-number">{{ $averageRating }} ★</span>
            <span class="crop-stat-label">Average Rating</span>
        </div>
        <div class="crop-stat-box crop-stat-green">
            <span class="crop-stat-number">{{ $feedbackEntries->where('is_reviewed', true)->count() }}</span>
            <span class="crop-stat-label">Reviewed</span>
        </div>
    </div>

    <div class="disease-toolbar">
        <input type="text" id="feedbackSearch" class="reminder-search-input" placeholder="🔍 Search by farmer name or comment...">

        <select id="feedbackRatingFilter" class="disease-filter-select">
            <option value="all">All Ratings</option>
            <option value="5">★★★★★ (5)</option>
            <option value="4">★★★★ (4)</option>
            <option value="3">★★★ (3)</option>
            <option value="2">★★ (2)</option>
            <option value="1">★ (1)</option>
        </select>

        <div class="reminder-filter-buttons" id="feedbackStatusFilter">
            <button type="button" class="filter-btn active" data-status="all">All</button>
            <button type="button" class="filter-btn" data-status="pending">Pending</button>
            <button type="button" class="filter-btn" data-status="reviewed">Reviewed</button>
        </div>

        <select id="feedbackSortSelect" class="disease-filter-select">
            <option value="recent">Sort: Newest</option>
            <option value="highest">Sort: Highest Rating</option>
            <option value="lowest">Sort: Lowest Rating</option>
        </select>
    </div>

    @if($feedbackEntries->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">⭐</div>
            <h3>No feedback submitted yet</h3>
        </div>
    @else
        <div class="feedback-admin-list" id="feedbackAdminList">
            @foreach($feedbackEntries as $entry)
                <div class="feedback-admin-card"
                     data-title="{{ strtolower($entry->comment.' '.$entry->user->name) }}"
                     data-rating="{{ $entry->rating }}"
                     data-status="{{ $entry->is_reviewed ? 'reviewed' : 'pending' }}"
                     data-created="{{ $entry->created_at->timestamp }}">

                    @if($entry->user->profile && $entry->user->profile->photo)
                        <img src="{{ asset('storage/'.$entry->user->profile->photo) }}" alt="{{ $entry->user->name }}" class="qa-admin-avatar">
                    @else
                        <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑‍🌾</div>
                    @endif

                    <div class="feedback-admin-body">
                        <div class="feedback-admin-header">
                            <strong>{{ $entry->user->name }}</strong>
                            <div class="star-display">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star-display-icon {{ $i <= $entry->rating ? 'star-display-filled' : '' }}">★</span>
                                @endfor
                            </div>
                            <span class="qa-status-badge {{ $entry->is_reviewed ? 'qa-status-answered' : 'qa-status-pending' }}">
                                {{ $entry->is_reviewed ? 'Reviewed' : 'Pending' }}
                            </span>
                        </div>
                        <p>{{ $entry->comment }}</p>
                        <span class="qa-admin-row-date">{{ $entry->created_at->format('d M, Y — h:i A') }}</span>
                    </div>

                    @unless($entry->is_reviewed)
                        <form method="POST" action="{{ route('admin.feedback.review', $entry) }}">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-secondary btn-sm">Mark Reviewed</button>
                        </form>
                    @endunless
                </div>
            @endforeach
        </div>

        <div class="empty-state hidden" id="feedbackNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching feedback</h3>
        </div>
    @endif

@endsection
