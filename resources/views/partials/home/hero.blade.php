<section class="hero-slider" id="heroSlider">

    {{-- Slide 1 --}}
    <div class="hero-slide hero-slide-1 active" data-slide="0">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Grow Smarter with Krishi Bondhu</h1>
            <p>Your all-in-one digital companion for weather, crops, prices, and expert farming advice.</p>
            <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    {{-- Slide 2 --}}
    <div class="hero-slide hero-slide-2" data-slide="1">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Never Miss a Farming Task</h1>
            <p>Set reminders, track your crops, and get disease alerts before they spread.</p>
            <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    {{-- Slide 3 --}}
    <div class="hero-slide hero-slide-3" data-slide="2">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Sell at the Right Price</h1>
            <p>Check live market prices and connect with agricultural experts anytime.</p>
            <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    {{-- Manual navigation arrows --}}
    <button class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Previous banner" type="button">&#10094;</button>
    <button class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Next banner" type="button">&#10095;</button>

    {{-- Indicator dots --}}
    <div class="hero-indicators" id="heroIndicators">
        <button class="hero-indicator active" data-slide="0" aria-label="Go to banner 1" type="button"></button>
        <button class="hero-indicator" data-slide="1" aria-label="Go to banner 2" type="button"></button>
        <button class="hero-indicator" data-slide="2" aria-label="Go to banner 3" type="button"></button>
    </div>
</section>
