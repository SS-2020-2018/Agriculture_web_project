@extends('layouts.app')

@section('title', 'Crop Management')

@section('header')
    <h2>🌱 Crop Management</h2>
@endsection

@section('content')

    @if (session('status') === 'crop-added')
        <div class="alert alert-success">✅ Crop added successfully.</div>
    @elseif (session('status') === 'crop-deleted')
        <div class="alert alert-success">✅ Crop deleted successfully.</div>
    @endif

    <div class="crop-summary-grid">
        <div class="crop-stat-box">
            <span class="crop-stat-number">{{ $stats['total'] }}</span>
            <span class="crop-stat-label">Total Crops</span>
        </div>
        <div class="crop-stat-box crop-stat-green">
            <span class="crop-stat-number">{{ $stats['growing'] }}</span>
            <span class="crop-stat-label">Currently Growing</span>
        </div>
        <div class="crop-stat-box crop-stat-orange">
            <span class="crop-stat-number">{{ $stats['ready'] }}</span>
            <span class="crop-stat-label">Ready for Harvest</span>
        </div>
        <div class="crop-stat-box crop-stat-blue">
            <span class="crop-stat-number">{{ $stats['recent'] }}</span>
            <span class="crop-stat-label">Added This Week</span>
        </div>
    </div>

    <div class="crop-list-header">
        <h3>Your Crops</h3>
        <a href="{{ route('crops.create') }}" class="btn btn-primary">+ Add Crop</a>
    </div>

    @if($crops->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🌾</div>
            <h3>No crops registered yet</h3>
            <p>Add your first crop to start tracking it here.</p>
            <a href="{{ route('crops.create') }}" class="btn btn-primary">+ Add Your First Crop</a>
        </div>
    @else
        <div class="crop-grid">
            @foreach($crops as $crop)
                <div class="crop-card">
                    <div class="crop-card-image-wrap">
                        <img src="{{ $crop->image_url }}" alt="{{ $crop->name }}" class="crop-card-image">
                        <span class="crop-status-badge crop-status-{{ $crop->status_color }}">{{ $crop->status_label }}</span>
                    </div>

                    <div class="crop-card-body">
                        <h3>{{ $crop->name }}</h3>

                        <div class="crop-card-meta">
                            <span>🌱 Planted: {{ $crop->planting_date->format('d M, Y') }}</span>
                            <span>🌾 Harvest: {{ $crop->expected_harvest_date->format('d M, Y') }}</span>
                            <span>📏 {{ $crop->land_area }}</span>
                        </div>

                        @if($crop->description)
                            <p class="crop-card-description">{{ \Illuminate\Support\Str::limit($crop->description, 80) }}</p>
                        @endif

                        @if($crop->admin_feedback)
                            <div class="crop-card-feedback-hint">💬 Admin left feedback</div>
                        @endif

                        <div class="crop-card-actions">
                            <a href="{{ route('crops.show', $crop) }}" class="btn btn-secondary btn-sm">View</a>
                            <a href="{{ route('crops.edit', $crop) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('crops.destroy', $crop) }}" data-open-delete-modal>Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @include('crops.partials.delete-modal')

@endsection
