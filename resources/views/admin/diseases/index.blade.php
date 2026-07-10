@extends('layouts.admin')

@section('title', 'Disease Management')

@section('header')
    <h2>🚨 Disease Management</h2>
@endsection

@section('content')

    @if (session('status') === 'disease-added')
        <div class="alert alert-success">✅ Disease alert published.</div>
    @elseif (session('status') === 'disease-updated')
        <div class="alert alert-success">✅ Disease alert updated.</div>
    @elseif (session('status') === 'disease-deleted')
        <div class="alert alert-success">✅ Disease alert deleted.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $diseases->count() }}</span>
            <span class="crop-stat-label">Total Published</span>
        </div>
        <div class="crop-stat-box" style="border-left-color:#e53935">
            <span class="crop-stat-number">{{ $diseases->where('warning_level', 'critical')->count() }}</span>
            <span class="crop-stat-label">Critical Alerts</span>
        </div>
        <div class="crop-stat-box" style="border-left-color:#ef6c00">
            <span class="crop-stat-number">{{ $diseases->where('warning_level', 'high')->count() }}</span>
            <span class="crop-stat-label">High Alerts</span>
        </div>
    </div>

    <div class="crop-list-header">
        <h3>All Disease Alerts</h3>
        <a href="{{ route('admin.diseases.create') }}" class="btn btn-primary">+ Add Disease Alert</a>
    </div>

    @if($diseases->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🚨</div>
            <h3>No disease alerts published yet</h3>
            <p>Publish your first disease alert so farmers can see it.</p>
            <a href="{{ route('admin.diseases.create') }}" class="btn btn-primary">+ Add Disease Alert</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Affected Crop</th>
                        <th>Warning Level</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diseases as $disease)
                        <tr>
                            <td><img src="{{ $disease->image_url }}" alt="{{ $disease->name }}" class="admin-table-thumb"></td>
                            <td>{{ $disease->name }}</td>
                            <td>{{ $disease->affected_crop }}</td>
                            <td><span class="disease-warning-badge disease-warning-{{ $disease->warning_color }}">{{ $disease->warning_label }}</span></td>
                            <td>{{ $disease->created_at->format('d M, Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('diseases.show', $disease) }}" class="btn btn-secondary btn-sm" target="_blank">View</a>
                                <a href="{{ route('admin.diseases.edit', $disease) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('admin.diseases.destroy', $disease) }}" data-open-delete-modal>Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @include('admin.diseases.partials.delete-modal')

@endsection
