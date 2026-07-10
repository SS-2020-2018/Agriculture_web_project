@extends('layouts.app')

@section('title', $disease->name)

@section('header')
    <h2>🚨 {{ $disease->name }}</h2>
@endsection

@section('content')

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            <img src="{{ $disease->image_url }}" alt="{{ $disease->name }}" class="crop-detail-image">

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $disease->name }}</h1>
                    <span class="disease-warning-badge disease-warning-{{ $disease->warning_color }}">{{ $disease->warning_label }} Risk</span>
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Affected Crop</span>
                        <span class="detail-value">🌾 {{ $disease->affected_crop }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Published</span>
                        <span class="detail-value">{{ $disease->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Last Updated</span>
                        <span class="detail-value">{{ $disease->updated_at->format('d M, Y') }}</span>
                    </div>
                </div>

                <div class="disease-info-section">
                    <h4>🔍 Symptoms</h4>
                    <p>{{ $disease->symptoms }}</p>
                </div>

                <div class="disease-info-section">
                    <h4>🛡️ Preventive Measures</h4>
                    <p>{{ $disease->preventive_measures }}</p>
                </div>

                <div class="disease-info-section">
                    <h4>💊 Suggested Treatments</h4>
                    <p>{{ $disease->suggested_treatments }}</p>
                </div>

                @if($disease->additional_recommendations)
                    <div class="disease-info-section">
                        <h4>📌 Additional Recommendations</h4>
                        <p>{{ $disease->additional_recommendations }}</p>
                    </div>
                @endif

                <div class="crop-detail-actions">
                    <a href="{{ route('diseases.index') }}" class="btn btn-secondary">← Back to Disease Alerts</a>
                </div>
            </div>
        </div>
    </div>

@endsection
