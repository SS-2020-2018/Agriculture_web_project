<nav class="navbar" id="mainNavbar">
    <div class="navbar-container">

        <div class="navbar-brand">
            <a href="{{ route('home') }}">
                <span class="brand-icon">🌾</span>
                <span class="brand-text">Krishi Bondhu</span>
            </a>
        </div>

        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation" type="button">
            <span></span><span></span><span></span>
        </button>

        <div class="navbar-menu" id="navbarMenu">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="#services" class="nav-link">Our Services</a>
            <a href="#contact" class="nav-link">Contact</a>

            @guest
                {{-- Shown inline in the mobile dropdown menu; desktop uses the
                     buttons in .navbar-guest-actions instead --}}
                <a href="{{ route('login') }}" class="nav-link nav-link-mobile-only">Login</a>
                <a href="{{ route('register') }}" class="nav-link nav-link-mobile-only">Register</a>
            @endguest
        </div>

        @auth
            @include('partials.profile-dropdown')
        @else
            <div class="navbar-guest-actions">
                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            </div>
        @endauth
    </div>
</nav>
