@extends('layouts.app')

@section('title', $news->title)

@section('header')
    <h2>📰 {{ $news->title }}</h2>
@endsection

@section('content')

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="crop-detail-image">

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $news->title }}</h1>
                    <span class="news-category-badge">{{ $news->category_icon }} {{ $news->category_label }}</span>
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Published</span>
                        <span class="detail-value">{{ $news->created_at->format('d M, Y — h:i A') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Published By</span>
                        <span class="detail-value">{{ $news->admin->name ?? 'Krishi Bondhu Admin' }}</span>
                    </div>
                </div>

                <div class="disease-info-section">
                    <p>{{ $news->description }}</p>
                </div>

                <div class="crop-detail-actions">
                    <a href="{{ route('news.index') }}" class="btn btn-secondary">← Back to News</a>
                </div>
            </div>
        </div>
    </div>

@endsection
