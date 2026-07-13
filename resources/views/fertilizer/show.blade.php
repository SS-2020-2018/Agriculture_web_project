@extends('layouts.app')

@section('title', $fertilizer->crop_name)

@section('header')
    <h2>🧪 {{ $fertilizer->crop_name }} Fertilizer Guide</h2>
@endsection

@section('content')

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            @if($fertilizer->crop_image)
               <img src="{{ $fertilizer->image_url }}" alt="{{ $fertilizer->crop_name }}" class="crop-detail-image fertilizer-detail-image">
            @else
                <div class="crop-detail-image crop-detail-image-placeholder">🧪</div>
            @endif

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $fertilizer->crop_name }}</h1>
                </div>

                <div class="fertilizer-chip-list fertilizer-chip-list-lg">
                    @foreach($fertilizer->fertilizers_list as $item)
                        <span class="fertilizer-chip">{{ $item }}</span>
                    @endforeach
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Application Stage</span>
                        <span class="detail-value">{{ $fertilizer->application_stage }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Quantity per Unit of Land</span>
                        <span class="detail-value">{{ $fertilizer->quantity }}</span>
                    </div>
                </div>

                <div class="disease-info-section">
                    <h4>🌾 Application Method</h4>
                    <p>{{ $fertilizer->application_method }}</p>
                </div>

                <div class="disease-info-section">
                    <h4>📋 Usage Instructions</h4>
                    <p>{{ $fertilizer->usage_instructions }}</p>
                </div>

                @if($fertilizer->additional_notes)
                    <div class="disease-info-section">
                        <h4>⚠️ Additional Notes &amp; Precautions</h4>
                        <p>{{ $fertilizer->additional_notes }}</p>
                    </div>
                @endif

                <div class="crop-detail-actions">
                    <a href="{{ route('fertilizer.index') }}" class="btn btn-secondary">← Back to Fertilizer Guide</a>
                </div>
            </div>
        </div>
    </div>

@endsection
