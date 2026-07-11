@extends('layouts.app')

@section('title', $tip->title)

@section('header')
    <h2>💡 {{ $tip->title }}</h2>
@endsection

@section('content')

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            <img src="{{ $tip->image_url }}" alt="{{ $tip->title }}" class="crop-detail-image">

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $tip->title }}</h1>
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Published</span>
                        <span class="detail-value">{{ $tip->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Total Likes</span>
                        <span class="detail-value" id="tipShowLikeCount">{{ $tip->likers_count }}</span>
                    </div>
                </div>

                <div class="disease-info-section">
                    <p>{{ $tip->description }}</p>
                </div>

                <div class="crop-detail-actions">
                    <a href="{{ route('tips.index') }}" class="btn btn-secondary">← Back to Tips</a>

                    <button type="button"
                            class="tip-like-btn tip-like-btn-lg {{ $isLiked ? 'tip-like-btn-active' : '' }}"
                            id="tipShowLikeBtn"
                            data-like-url="{{ route('tips.like', $tip) }}">
                        <span class="tip-like-icon">{{ $isLiked ? '❤️' : '🤍' }}</span>
                        <span>{{ $isLiked ? 'Liked' : 'Like this tip' }}</span>
                    </button>

                    @if($isSaved)
                        <span class="tip-saved-badge">🔖 Saved to your collection</span>
                    @else
                        <form method="POST" action="{{ route('saved-tips.store', $tip) }}">
                            @csrf
                            <button type="submit" class="btn btn-secondary">🔖 Save Tip</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
