@extends('layouts.app')

@section('title', 'Farming Tips')

@section('header')
    <h2>💡 Farming Tips</h2>
@endsection

@section('content')

    <div class="tips-page-header">
        <p>Practical advice from our agricultural experts, updated regularly.</p>
        <a href="{{ route('saved-tips.index') }}" class="btn btn-secondary">🔖 My Saved Tips</a>
    </div>

    @if($featuredTip)
        <div class="featured-tip-card">
            <span class="featured-tip-label">⭐ Today's Featured Tip</span>
            <div class="featured-tip-body">
                <img src="{{ $featuredTip->image_url }}" alt="{{ $featuredTip->title }}" class="featured-tip-image">
                <div class="featured-tip-content">
                    <h3>{{ $featuredTip->title }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($featuredTip->description, 160) }}</p>
                    <a href="{{ route('tips.show', $featuredTip) }}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
    @endif

    @if($tips->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">💡</div>
            <h3>No farming tips published yet</h3>
            <p>Check back soon for expert advice.</p>
        </div>
    @else
        <div class="tips-grid">
            @foreach($tips as $tip)
                @php
                    $liked = in_array($tip->id, $likedTipIds);
                    $saved = in_array($tip->id, $savedTipIds);
                @endphp
                <div class="tip-card">
                    <img src="{{ $tip->image_url }}" alt="{{ $tip->title }}" class="tip-card-image">
                    <div class="tip-card-body">
                        <h3>{{ $tip->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($tip->description, 90) }}</p>
                        <span class="tip-card-date">{{ $tip->created_at->format('d M, Y') }}</span>

                        <div class="tip-card-actions">
                            <a href="{{ route('tips.show', $tip) }}" class="btn btn-secondary btn-sm">Read More</a>

                            <button type="button"
                                    class="tip-like-btn {{ $liked ? 'tip-like-btn-active' : '' }}"
                                    data-tip-id="{{ $tip->id }}"
                                    data-like-url="{{ route('tips.like', $tip) }}">
                                <span class="tip-like-icon">{{ $liked ? '❤️' : '🤍' }}</span>
                                <span class="tip-like-count">{{ $tip->likers_count }}</span>
                            </button>

                            @if($saved)
                                <span class="tip-saved-badge">🔖 Saved</span>
                            @else
                                <form method="POST" action="{{ route('saved-tips.store', $tip) }}">
                                    @csrf
                                    <button type="submit" class="icon-btn" aria-label="Save tip">🔖</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
