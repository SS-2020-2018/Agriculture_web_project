@extends('layouts.app')

@section('title', 'Disease Alerts')

@section('header')
    <h2>🚨 Disease Alerts</h2>
@endsection

@section('content')

    <div class="disease-toolbar">
        <input type="text" id="diseaseSearch" class="reminder-search-input" placeholder="🔍 Search by disease or crop name...">

        <select id="diseaseCropFilter" class="disease-filter-select">
            <option value="all">All Crops</option>
            @foreach($affectedCrops as $crop)
                <option value="{{ strtolower($crop) }}">{{ $crop }}</option>
            @endforeach
        </select>

        <div class="reminder-filter-buttons" id="diseaseLevelFilter">
            <button type="button" class="filter-btn active" data-level="all">All</button>
            <button type="button" class="filter-btn" data-level="low">Low</button>
            <button type="button" class="filter-btn" data-level="medium">Medium</button>
            <button type="button" class="filter-btn" data-level="high">High</button>
            <button type="button" class="filter-btn" data-level="critical">Critical</button>
        </div>
    </div>

    @if($diseases->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">✅</div>
            <h3>No disease alerts right now</h3>
            <p>Check back later — the administrator will publish alerts here as needed.</p>
        </div>
    @else
        <div class="disease-grid" id="diseaseGrid">
            @foreach($diseases as $disease)
                <a href="{{ route('diseases.show', $disease) }}"
                   class="disease-card"
                   data-title="{{ strtolower($disease->name.' '.$disease->affected_crop) }}"
                   data-crop="{{ strtolower($disease->affected_crop) }}"
                   data-level="{{ $disease->warning_level }}">
                    <div class="disease-card-image-wrap">
                        <img src="{{ $disease->image_url }}" alt="{{ $disease->name }}" class="disease-card-image">
                        <span class="disease-warning-badge disease-warning-{{ $disease->warning_color }}">{{ $disease->warning_label }}</span>
                    </div>
                    <div class="disease-card-body">
                        <h3>{{ $disease->name }}</h3>
                        <span class="disease-card-crop">🌾 {{ $disease->affected_crop }}</span>
                        <p>{{ \Illuminate\Support\Str::limit($disease->symptoms, 90) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="diseaseNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching disease alerts</h3>
            <p>Try a different search term or filter.</p>
        </div>
    @endif

@endsection
