@extends('layouts.app')

@section('title', 'Weather')

@section('header')
    <h2>⛅ Weather</h2>
@endsection

@section('content')

    <div class="weather-search-card">
        <form method="GET" action="{{ route('weather.index') }}" class="weather-search-form">
            <input type="text" name="city" value="{{ $searchedCity }}" placeholder="🔍 Search for a city, e.g. Khulna" class="weather-search-input">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($searchedCity)
                <a href="{{ route('weather.index') }}" class="btn btn-secondary">Use My Location</a>
            @endif
        </form>

        @if(count($recentSearches) > 0)
            <div class="weather-recent-chips">
                <span class="weather-recent-label">Recent:</span>
                @foreach($recentSearches as $recent)
                    <a href="{{ route('weather.index', ['city' => $recent]) }}" class="weather-chip">{{ $recent }}</a>
                @endforeach
            </div>
        @endif
    </div>

    @if($errorMessage)
        <div class="alert alert-error">⚠️ {{ $errorMessage }}</div>
    @endif

    @if($weather)
        <div class="weather-location-heading">
            <h3>{{ $weather['city'] }}{{ $weather['country'] ? ', '.$weather['country'] : '' }}</h3>
            <span>{{ now()->format('l, d M Y — h:i A') }}</span>
        </div>

        <div class="weather-grid">

            {{-- Temperature --}}
            <div class="weather-card weather-card-blue">
                <div class="weather-card-header">
                    <span class="weather-card-icon">🌡️</span>
                    <h4>Temperature</h4>
                </div>
                <div class="weather-temp-big">{{ $weather['temp'] }}°C</div>
                <p class="weather-card-sub">Feels like {{ $weather['feels_like'] }}°C</p>
                <div class="weather-minmax">
                    <span>⬇ Min {{ $weather['temp_min'] }}°C</span>
                    <span>⬆ Max {{ $weather['temp_max'] }}°C</span>
                </div>
            </div>

            {{-- Weather Condition --}}
            <div class="weather-card weather-card-yellow">
                <div class="weather-card-header">
                    <span class="weather-card-icon">☁️</span>
                    <h4>Condition</h4>
                </div>
                <div class="weather-condition-row">
                    <img src="{{ $weather['icon_url'] }}" alt="{{ $weather['condition'] }}" class="weather-condition-icon">
                    <div>
                        <div class="weather-condition-name">{{ $weather['condition'] }}</div>
                        <p class="weather-card-sub">{{ $weather['description'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Wind --}}
            <div class="weather-card weather-card-teal">
                <div class="weather-card-header">
                    <span class="weather-card-icon">🌬️</span>
                    <h4>Wind</h4>
                </div>
                <div class="weather-temp-big">{{ $weather['wind_speed'] ?? 'N/A' }} <span class="weather-unit">m/s</span></div>
                <p class="weather-card-sub">Direction: {{ $weather['wind_direction'] }}</p>
            </div>

            {{-- Atmospheric --}}
            <div class="weather-card weather-card-purple">
                <div class="weather-card-header">
                    <span class="weather-card-icon">💧</span>
                    <h4>Atmospheric</h4>
                </div>
                <div class="weather-stat-list">
                    <div class="weather-stat-row"><span>Humidity</span><strong>{{ $weather['humidity'] ?? 'N/A' }}%</strong></div>
                    <div class="weather-stat-row"><span>Pressure</span><strong>{{ $weather['pressure'] ?? 'N/A' }} hPa</strong></div>
                    <div class="weather-stat-row"><span>Visibility</span><strong>{{ $weather['visibility_km'] ?? 'N/A' }} km</strong></div>
                    <div class="weather-stat-row"><span>Cloud Cover</span><strong>{{ $weather['clouds'] ?? 'N/A' }}%</strong></div>
                </div>
            </div>

            {{-- Sunrise & Sunset --}}
            <div class="weather-card weather-card-orange">
                <div class="weather-card-header">
                    <span class="weather-card-icon">🌅</span>
                    <h4>Sunrise &amp; Sunset</h4>
                </div>
                <div class="weather-sun-row">
                    <div><span class="weather-card-sub">Sunrise</span><strong>{{ $weather['sunrise'] }}</strong></div>
                    <div><span class="weather-card-sub">Sunset</span><strong>{{ $weather['sunset'] }}</strong></div>
                </div>
            </div>

            {{-- Location Details --}}
            <div class="weather-card weather-card-green">
                <div class="weather-card-header">
                    <span class="weather-card-icon">📍</span>
                    <h4>Location Details</h4>
                </div>
                <div class="weather-stat-list">
                    <div class="weather-stat-row"><span>Latitude</span><strong>{{ $weather['lat'] }}</strong></div>
                    <div class="weather-stat-row"><span>Longitude</span><strong>{{ $weather['lon'] }}</strong></div>
                    <div class="weather-stat-row"><span>Timezone</span><strong>{{ $weather['timezone_label'] }}</strong></div>
                </div>
            </div>

        </div>
    @elseif(!$errorMessage)
        <div class="empty-state">
            <div class="empty-state-icon">⛅</div>
            <h3>Search for a city to see the weather</h3>
        </div>
    @endif

@endsection
