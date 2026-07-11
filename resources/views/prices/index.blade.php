@extends('layouts.app')

@section('title', 'Crop Prices')

@section('header')
    <h2>💰 Crop Price Information</h2>
@endsection

@section('content')

    <div class="disease-toolbar">
        <input type="text" id="priceSearch" class="reminder-search-input" placeholder="🔍 Search by crop name...">

        <select id="priceMarketFilter" class="disease-filter-select">
            <option value="all">All Markets</option>
            @foreach($markets as $market)
                <option value="{{ strtolower($market) }}">{{ $market }}</option>
            @endforeach
        </select>

        <select id="priceSortSelect" class="disease-filter-select">
            <option value="recent">Sort: Most Recently Updated</option>
            <option value="az">Sort: Crop Name (A–Z)</option>
            <option value="price_high">Sort: Price (High to Low)</option>
            <option value="price_low">Sort: Price (Low to High)</option>
        </select>
    </div>

    @if($prices->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">💰</div>
            <h3>No crop prices published yet</h3>
            <p>Check back later — the administrator will publish prices here as they update.</p>
        </div>
    @else
        <div class="price-grid" id="priceGrid">
            @foreach($prices as $price)
                <a href="{{ route('prices.show', $price) }}"
                   class="price-card"
                   data-title="{{ strtolower($price->crop_name) }}"
                   data-market="{{ strtolower($price->market_name) }}"
                   data-price="{{ $price->price_per_unit }}"
                   data-updated="{{ $price->updated_at->timestamp }}">
                    <div class="price-card-image-wrap">
                        @if($price->crop_image)
                            <img src="{{ $price->image_url }}" alt="{{ $price->crop_name }}" class="price-card-image">
                        @else
                            <div class="price-card-image price-card-image-placeholder">🌾</div>
                        @endif
                    </div>
                    <div class="price-card-body">
                        <h3>{{ $price->crop_name }}</h3>
                        <div class="price-card-amount">{{ $price->formatted_price }}</div>
                        <span class="price-card-market">📍 {{ $price->market_name }}</span>
                        <span class="price-card-updated">Updated {{ $price->updated_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="priceNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching crop prices</h3>
            <p>Try a different search term or filter.</p>
        </div>
    @endif

@endsection
