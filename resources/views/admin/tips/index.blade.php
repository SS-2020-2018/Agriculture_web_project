@extends('layouts.admin')

@section('title', 'Tips Management')

@section('header')
    <h2>💡 Tips Management</h2>
@endsection

@section('content')

    @if (session('status') === 'tip-added')
        <div class="alert alert-success">✅ Tip published.</div>
    @elseif (session('status') === 'tip-updated')
        <div class="alert alert-success">✅ Tip updated.</div>
    @elseif (session('status') === 'tip-deleted')
        <div class="alert alert-success">✅ Tip deleted.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $tips->count() }}</span>
            <span class="crop-stat-label">Total Tips</span>
        </div>
        <div class="crop-stat-box crop-stat-orange">
            <span class="crop-stat-number">{{ $totalLikes }}</span>
            <span class="crop-stat-label">Total Likes</span>
        </div>
    </div>

    <div class="crop-list-header">
        <h3>All Tips</h3>
        <a href="{{ route('admin.tips.create') }}" class="btn btn-primary">+ Add Tip</a>
    </div>

    @if($tips->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">💡</div>
            <h3>No tips published yet</h3>
            <a href="{{ route('admin.tips.create') }}" class="btn btn-primary">+ Add Tip</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Likes</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tips as $tip)
                        <tr>
                            <td><img src="{{ $tip->image_url }}" alt="{{ $tip->title }}" class="admin-table-thumb"></td>
                            <td>{{ $tip->title }}</td>
                            <td>
                                <button type="button"
                                        class="likes-count-btn"
                                        data-likers-url="{{ route('admin.tips.likers', $tip) }}"
                                        data-tip-title="{{ $tip->title }}">
                                    ❤️ {{ $tip->likers_count }}
                                </button>
                            </td>
                            <td>{{ $tip->created_at->format('d M, Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('tips.show', $tip) }}" class="btn btn-secondary btn-sm" target="_blank">View</a>
                                <a href="{{ route('admin.tips.edit', $tip) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('admin.tips.destroy', $tip) }}" data-open-delete-modal>Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @include('admin.tips.partials.delete-modal')
    @include('admin.tips.partials.likers-modal')

@endsection
