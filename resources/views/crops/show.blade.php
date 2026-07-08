@extends('layouts.app')

@section('title', $crop->name)

@section('header')
    <h2>🌱 {{ $crop->name }}</h2>
@endsection

@section('content')

    @if (session('status') === 'crop-updated')
        <div class="alert alert-success">✅ Crop updated successfully.</div>
    @endif

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            <img src="{{ $crop->image_url }}" alt="{{ $crop->name }}" class="crop-detail-image">

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $crop->name }}</h1>
                    <span class="crop-status-badge crop-status-{{ $crop->status_color }}">{{ $crop->status_label }}</span>
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Planting Date</span>
                        <span class="detail-value">{{ $crop->planting_date->format('d M, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Expected Harvest Date</span>
                        <span class="detail-value">{{ $crop->expected_harvest_date->format('d M, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Land Area</span>
                        <span class="detail-value">{{ $crop->land_area }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Registered On</span>
                        <span class="detail-value">{{ $crop->created_at->format('d M, Y') }}</span>
                    </div>
                </div>

                @if($crop->description)
                    <div class="crop-detail-description">
                        <span class="detail-label">Description</span>
                        <p>{{ $crop->description }}</p>
                    </div>
                @endif

                <div class="crop-feedback-box">
                    <span class="detail-label">Admin Feedback</span>
                    @if($crop->admin_feedback)
                        <p>{{ $crop->admin_feedback }}</p>
                        <span class="crop-feedback-date">— {{ $crop->admin_feedback_at?->format('d M, Y') }}</span>
                    @else
                        <p class="crop-feedback-empty">No feedback from the administrator yet.</p>
                    @endif
                </div>

                <div class="crop-detail-actions">
                    <a href="{{ route('crops.index') }}" class="btn btn-secondary">← Back to Crops</a>
                    <a href="{{ route('crops.edit', $crop) }}" class="btn btn-primary">✏️ Edit</a>
                    <button type="button" class="btn btn-danger" data-delete-url="{{ route('crops.destroy', $crop) }}" data-open-delete-modal>🗑️ Delete</button>
                </div>
            </div>
        </div>
    </div>

    @include('crops.partials.delete-modal')

@endsection
