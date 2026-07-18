@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header')
    <h2>📊 Admin Dashboard</h2>
@endsection

@section('content')

    @if (session('status') === 'farmer-suspended')
        <div class="alert alert-success">✅ Farmer account suspended.</div>
    @elseif (session('status') === 'farmer-reactivated')
        <div class="alert alert-success">✅ Farmer account reactivated.</div>
    @elseif (session('status') === 'crop-feedback-saved')
        <div class="alert alert-success">✅ Feedback saved for that crop.</div>
    @elseif (session('status') === 'message-deleted')
        <div class="alert alert-success">✅ Message deleted.</div>
    @endif

    <div class="admin-stat-grid">
        <a href="{{ route('weather.index') }}" class="admin-stat-card admin-stat-blue">
            <span class="admin-stat-icon">⛅</span>
            <div>
                <span class="admin-stat-value admin-stat-value-sm">{{ $weatherSummary ?? 'Tap to view' }}</span>
                <span class="admin-stat-label">Weather</span>
            </div>
        </a>

        <a href="{{ route('admin.farmers.index') }}" class="admin-stat-card admin-stat-green">
            <span class="admin-stat-icon">🧑‍🌾</span>
            <div>
                <span class="admin-stat-value">{{ $stats['farmers'] }}</span>
                <span class="admin-stat-label">Total Farmers</span>
            </div>
        </a>

        <a href="{{ route('admin.farmers.index') }}" class="admin-stat-card admin-stat-teal">
            <span class="admin-stat-icon">🌱</span>
            <div>
                <span class="admin-stat-value">{{ $stats['crops'] }}</span>
                <span class="admin-stat-label">Registered Crops</span>
            </div>
        </a>

        <a href="{{ route('admin.qa.index') }}" class="admin-stat-card admin-stat-orange">
            <span class="admin-stat-icon">❓</span>
            <div>
                <span class="admin-stat-value">{{ $stats['todays_questions'] }}</span>
                <span class="admin-stat-label">Today's Questions</span>
            </div>
        </a>

        <a href="{{ route('admin.news.index') }}" class="admin-stat-card admin-stat-cyan">
            <span class="admin-stat-icon">📰</span>
            <div>
                <span class="admin-stat-value">{{ $stats['news'] }}</span>
                <span class="admin-stat-label">News Articles</span>
            </div>
        </a>

        <a href="{{ route('admin.feedback.index') }}" class="admin-stat-card admin-stat-pink">
            <span class="admin-stat-icon">⭐</span>
            <div>
                <span class="admin-stat-value">{{ $stats['feedback'] }}</span>
                <span class="admin-stat-label">Total Feedback</span>
            </div>
        </a>

        <a href="{{ route('admin.diseases.index') }}" class="admin-stat-card admin-stat-red">
            <span class="admin-stat-icon">🚨</span>
            <div>
                <span class="admin-stat-value">{{ $stats['diseases'] }}</span>
                <span class="admin-stat-label">Disease Records</span>
            </div>
        </a>

        <a href="{{ route('admin.fertilizers.index') }}" class="admin-stat-card admin-stat-purple">
            <span class="admin-stat-icon">🧪</span>
            <div>
                <span class="admin-stat-value">{{ $stats['fertilizers'] }}</span>
                <span class="admin-stat-label">Fertilizer Records</span>
            </div>
        </a>

        <a href="{{ route('admin.tips.index') }}" class="admin-stat-card admin-stat-yellow">
            <span class="admin-stat-icon">💡</span>
            <div>
                <span class="admin-stat-value">{{ $stats['tips'] }}</span>
                <span class="admin-stat-label">Farming Tips</span>
            </div>
        </a>

        <a href="{{ route('admin.prices.index') }}" class="admin-stat-card admin-stat-indigo">
            <span class="admin-stat-icon">💰</span>
            <div>
                <span class="admin-stat-value">{{ $stats['prices'] }}</span>
                <span class="admin-stat-label">Crop Price Records</span>
            </div>
        </a>

        <a href="{{ route('admin.contact.index') }}" class="admin-stat-card admin-stat-teal">
            <span class="admin-stat-icon">✉️</span>
            <div>
                <span class="admin-stat-value">{{ $stats['unread_messages'] }}</span>
                <span class="admin-stat-label">Unread Messages</span>
            </div>
        </a>

    </div>

    <div class="admin-activity-grid">

        <div class="admin-activity-card">

            <div class="admin-activity-header">
                <h3>Recent Farmer Registrations</h3>
                <a href="{{ route('admin.farmers.index') }}" class="admin-view-all-link">View All →</a>
            </div>

            @forelse($recentFarmers as $farmer)
                <a href="{{ route('admin.farmers.show', $farmer) }}" class="admin-activity-row">
                    @if($farmer->profile && $farmer->profile->photo)
                        <img src="{{ asset('storage/'.$farmer->profile->photo) }}" alt="{{ $farmer->name }}" class="qa-admin-avatar">
                    @else
                        <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑‍🌾</div>
                    @endif
                    <div class="admin-activity-row-body">
                        <strong>{{ $farmer->name }}</strong>
                        <span>{{ $farmer->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <p class="admin-activity-empty">No farmers registered yet.</p>
            @endforelse

        </div>

        <div class="admin-activity-card">

            <div class="admin-activity-header">
                <h3>Recent Feedback</h3>
                <a href="{{ route('admin.feedback.index') }}" class="admin-view-all-link">View All →</a>
            </div>

            @forelse($recentFeedback as $entry)
                <div class="admin-activity-row">
                    <div class="star-display">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star-display-icon {{ $i <= $entry->rating ? 'star-display-filled' : '' }}">★</span>
                        @endfor
                    </div>
                    <div class="admin-activity-row-body">
                        <strong>{{ $entry->user->name ?? 'Unknown' }}</strong>
                        <span>{{ \Illuminate\Support\Str::limit($entry->comment, 50) }}</span>
                    </div>
                </div>
            @empty
                <p class="admin-activity-empty">No feedback submitted yet.</p>
            @endforelse
            
        </div>

        <div class="admin-activity-card">
            <div class="admin-activity-header">
                <h3>Latest Questions</h3>
                <a href="{{ route('admin.qa.index') }}" class="admin-view-all-link">View All →</a>
            </div>
            @forelse($latestQuestions as $question)
                <a href="{{ route('admin.qa.show', $question) }}" class="admin-activity-row">
                    <span class="admin-activity-row-icon">❓</span>
                    <div class="admin-activity-row-body">
                        <strong>{{ \Illuminate\Support\Str::limit($question->question_text, 45) }}</strong>
                        <span>{{ $question->farmer->name ?? 'Unknown' }} • {{ $question->status === 'answered' ? 'Answered' : 'Pending' }}</span>
                    </div>
                </a>
            @empty
                <p class="admin-activity-empty">No questions submitted yet.</p>
            @endforelse
        </div>

        <div class="admin-activity-card">
            <div class="admin-activity-header">
                <h3>Latest News</h3>
                <a href="{{ route('admin.news.index') }}" class="admin-view-all-link">View All →</a>
            </div>
            @forelse($latestNews as $article)
                <a href="{{ route('news.show', $article) }}" class="admin-activity-row" target="_blank">
                    <span class="admin-activity-row-icon">{{ $article->category_icon }}</span>
                    <div class="admin-activity-row-body">
                        <strong>{{ \Illuminate\Support\Str::limit($article->title, 45) }}</strong>
                        <span>{{ $article->created_at->format('d M, Y') }}</span>
                    </div>
                </a>
            @empty
                <p class="admin-activity-empty">No news published yet.</p>
            @endforelse
        </div>

        <div class="admin-activity-card">
            <div class="admin-activity-header">
                <h3>Recently Updated Crop Prices</h3>
                <a href="{{ route('admin.prices.index') }}" class="admin-view-all-link">View All →</a>
            </div>
            @forelse($recentPrices as $price)
                <a href="{{ route('prices.show', $price) }}" class="admin-activity-row" target="_blank">
                    <span class="admin-activity-row-icon">💰</span>
                    <div class="admin-activity-row-body">
                        <strong>{{ $price->crop_name }}</strong>
                        <span>{{ $price->formatted_price }} • {{ $price->updated_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <p class="admin-activity-empty">No crop prices published yet.</p>
            @endforelse
        </div>

        <div class="admin-activity-card">
            <div class="admin-activity-header">
                <h3>Recent Contact Messages</h3>
                <a href="{{ route('admin.contact.index') }}" class="admin-view-all-link">View All →</a>
            </div>
            @forelse($recentMessages as $message)
                <a href="{{ route('admin.contact.show', $message) }}" class="admin-activity-row">
                    <span class="admin-activity-row-icon">{{ $message->is_read ? '📖' : '✉️' }}</span>
                    <div class="admin-activity-row-body">
                        <strong>{{ $message->name }}{{ $message->is_read ? ' (Read)' : ' (New)' }}</strong>
                        <span>{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 40) }}</span>
                    </div>
                </a>
            @empty
                <p class="admin-activity-empty">No messages received yet.</p>
            @endforelse
        </div>

    </div>

@endsection
