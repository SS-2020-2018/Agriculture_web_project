@extends('layouts.app')

@section('title', $price->crop_name)

@section('header')
    <h2>💰 {{ $price->crop_name }}</h2>
@endsection

@section('content')

    <div class="crop-detail-page">
        <div class="crop-detail-card">
            @if($price->crop_image)
                <img src="{{ $price->image_url }}" alt="{{ $price->crop_name }}" class="crop-detail-image">
            @else
                <div class="crop-detail-image crop-detail-image-placeholder">🌾</div>
            @endif

            <div class="crop-detail-body">
                <div class="crop-detail-heading">
                    <h1>{{ $price->crop_name }}</h1>
                    <span class="price-detail-amount">{{ $price->formatted_price }}</span>
                </div>

                <div class="crop-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Market</span>
                        <span class="detail-value">📍 {{ $price->market_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Last Updated</span>
                        <span class="detail-value">{{ $price->updated_at->format('d M, Y — h:i A') }}</span>
                    </div>
                </div>

                @if($price->remarks)
                    <div class="disease-info-section">
                        <h4>📌 Remarks</h4>
                        <p>{{ $price->remarks }}</p>
                    </div>
                @endif

                @if($previousPrices->isNotEmpty())
                    <div class="disease-info-section">
                        <h4>📊 Other Recent Prices for {{ $price->crop_name }}</h4>
                        <div class="price-history-list">
                            @foreach($previousPrices as $previous)
                                <a href="{{ route('prices.show', $previous) }}" class="price-history-row">
                                    <span>{{ $previous->market_name }}</span>
                                    <strong>{{ $previous->formatted_price }}</strong>
                                    <span class="price-history-date">{{ $previous->updated_at->format('d M, Y') }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="crop-detail-actions">
                    <a href="{{ route('prices.index') }}" class="btn btn-secondary">← Back to Crop Prices</a>
                </div>
            </div>
        </div>
    </div>

@endsection
