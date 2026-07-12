@extends('layouts.admin')

@section('title', 'News Management')

@section('header')
    <h2>📰 News Management</h2>
@endsection

@section('content')

    @if (session('status') === 'news-added')
        <div class="alert alert-success">✅ Article published.</div>
    @elseif (session('status') === 'news-updated')
        <div class="alert alert-success">✅ Article updated.</div>
    @elseif (session('status') === 'news-deleted')
        <div class="alert alert-success">✅ Article deleted.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $articles->count() }}</span>
            <span class="crop-stat-label">Total Published</span>
        </div>
        <div class="crop-stat-box crop-stat-blue">
            <span class="crop-stat-number">{{ $articles->first()?->created_at?->format('d M') ?? '—' }}</span>
            <span class="crop-stat-label">Most Recent Publication</span>
        </div>
    </div>

    <div class="crop-list-header">
        <h3>All Articles</h3>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Add News Article</a>
    </div>

    @if($articles->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📰</div>
            <h3>No news articles published yet</h3>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Add News Article</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td><img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="admin-table-thumb"></td>
                            <td>{{ $article->title }}</td>
                            <td><span class="news-category-badge">{{ $article->category_icon }} {{ $article->category_label }}</span></td>
                            <td>{{ $article->created_at->format('d M, Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('news.show', $article) }}" class="btn btn-secondary btn-sm" target="_blank">View</a>
                                <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('admin.news.destroy', $article) }}" data-open-delete-modal>Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @include('admin.news.partials.delete-modal')

@endsection
