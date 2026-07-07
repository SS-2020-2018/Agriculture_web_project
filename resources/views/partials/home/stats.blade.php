<section class="stats-bar">
    <div class="stats-container">
        @foreach($stats as $stat)
            <div class="stat-item">
                <span class="stat-number" data-count="{{ $stat['count'] }}">0</span><span class="stat-suffix">{{ $stat['suffix'] }}</span>
                <span class="stat-label">{{ $stat['label'] }}</span>
            </div>
        @endforeach
    </div>
</section>
