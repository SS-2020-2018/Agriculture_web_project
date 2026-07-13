@extends('layouts.app')

@section('title', 'Fertilizer Guide')

@section('header')
    <h2>🧪 Fertilizer Guide</h2>
@endsection

@section('content')

    <div class="weather-search-card">
        <input type="text" id="fertilizerSearch" list="cropNameSuggestions"
               class="weather-search-input" placeholder="🔍 Search by crop name, e.g. Rice, Potato, Tomato...">
        <datalist id="cropNameSuggestions">
            @foreach($cropNames as $cropName)
                <option value="{{ $cropName }}">
            @endforeach
        </datalist>
    </div>

    @if($fertilizers->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🧪</div>
            <h3>No fertilizer guides published yet</h3>
            <p>Check back later for crop-specific fertilizer recommendations.</p>
        </div>
    @else
        <div class="fertilizer-grid" id="fertilizerGrid">
            @foreach($fertilizers as $fertilizer)
                <a href="{{ route('fertilizer.show', $fertilizer) }}"
                   class="fertilizer-card"
                   data-title="{{ strtolower($fertilizer->crop_name) }}">
                    <div class="fertilizer-card-image-wrap">
                        @if($fertilizer->crop_image)
                            <img src="{{ $fertilizer->image_url }}" alt="{{ $fertilizer->crop_name }}" class="fertilizer-card-image">
                        @else
                            <div class="fertilizer-card-image fertilizer-card-image-placeholder">🧪</div>
                        @endif
                    </div>
                    <div class="fertilizer-card-body">
                        <h3>{{ $fertilizer->crop_name }}</h3>

                        <div class="fertilizer-chip-list">
                            @foreach($fertilizer->fertilizers_list as $item)
                                <span class="fertilizer-chip">{{ $item }}</span>
                            @endforeach
                        </div>

                        <div class="fertilizer-card-meta">
                            <span>📅 {{ $fertilizer->application_stage }}</span>
                            <span>⚖️ {{ $fertilizer->quantity }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="fertilizerNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No fertilizer guide found for that crop</h3>
            <p>Try a different crop name, or check the spelling.</p>
        </div>
    @endif

@endsection
