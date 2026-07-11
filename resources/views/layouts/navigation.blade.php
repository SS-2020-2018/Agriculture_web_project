<nav class="navbar" id="mainNavbar">
    <div class="navbar-container">

        <div class="navbar-brand">
            <a href="{{ route('dashboard') }}">
                <span class="brand-icon">🌾</span>
                <span class="brand-text">Krishi Bondhu</span>
            </a>
        </div>

        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation" type="button">
            <span></span><span></span><span></span>
        </button>

        <div class="navbar-menu" id="navbarMenu">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('tips.index') }}"
               class="nav-link {{ request()->routeIs('tips.*') ? 'active' : '' }}">
                Farming Tips
            </a>
            {{-- Crops, Weather, Reminders, Prices, Q&A, News, Feedback,
                 Fertilizer Guide links will be appended here phase by phase --}}
        </div>

        @include('partials.notification-bell')

        @include('partials.profile-dropdown')
    </div>
</nav>
