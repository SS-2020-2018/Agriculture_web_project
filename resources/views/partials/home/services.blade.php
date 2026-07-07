<section class="services-section" id="services">
    <div class="section-container">
        <div class="section-heading">
            <h2>Our Services</h2>
            <p>Everything a modern farmer needs, in one platform.</p>
        </div>

        <div class="services-grid">
            @foreach($services as $service)
                <div class="service-card service-color-{{ $service['color'] }}">
                    <div class="service-icon">{{ $service['icon'] }}</div>
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
