@extends('layouts.app')

@section('title', 'Agriculture News')

@section('header')
    <h2>📰 Agriculture News</h2>
@endsection

@section('content')

    <div class="disease-toolbar">
        <input type="text" id="newsSearch" class="reminder-search-input" placeholder="🔍 Search news by title...">

        <div class="reminder-filter-buttons" id="newsCategoryFilter">
            <button type="button" class="filter-btn active" data-category="all">All</button>
            <button type="button" class="filter-btn" data-category="rain_alert">🌧️ Rain</button>
            <button type="button" class="filter-btn" data-category="government_notice">🏛️ Government</button>
            <button type="button" class="filter-btn" data-category="disease_pest_alert">🐛 Disease/Pest</button>
            <button type="button" class="filter-btn" data-category="new_farming_method">🌱 New Methods</button>
        </div>

        <select id="newsSortSelect" class="disease-filter-select">
            <option value="recent">Sort: Latest First</option>
            <option value="az">Sort: A–Z</option>
        </select>
    </div>

    @if($articles->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📰</div>
            <h3>No news articles published yet</h3>
            <p>Check back later for updates from the administrator.</p>
        </div>
    @else
        <div class="news-grid" id="newsGrid">
            @foreach($articles as $article)
                <a href="{{ route('news.show', $article) }}"
                   class="news-card"
                   data-title="{{ strtolower($article->title) }}"
                   data-category="{{ $article->category }}"
                   data-published="{{ $article->created_at->timestamp }}">
                    <div class="news-card-image-wrap">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="news-card-image">
                        <span class="news-category-badge news-category-badge-overlay">{{ $article->category_icon }} {{ $article->category_label }}</span>
                    </div>
                    <div class="news-card-body">
                        <h3>{{ $article->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($article->description, 100) }}</p>
                        <span class="news-card-date">{{ $article->created_at->format('d M, Y') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="newsNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching news articles</h3>
            <p>Try a different search term or category.</p>
        </div>
    @endif

@endsection
