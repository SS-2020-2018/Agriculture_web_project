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
               class="nav-link {{ request()->routeIs('tips.*') || request()->routeIs('saved-tips.*') ? 'active' : '' }}">
                Tips
            </a>
            <a href="{{ route('qa.index') }}"
               class="nav-link {{ request()->routeIs('qa.*') ? 'active' : '' }}">
                Q&amp;A
            </a>
            <a href="{{ route('news.index') }}"
               class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                News
            </a>
            <a href="{{ route('feedback.index') }}"
               class="nav-link {{ request()->routeIs('feedback.*') ? 'active' : '' }}">
                Feedback
            </a>
            <a href="{{ route('fertilizer.index') }}"
               class="nav-link {{ request()->routeIs('fertilizer.*') ? 'active' : '' }}">
                Fertilizer
            </a>
        </div>

        @include('partials.notification-bell')

        @include('partials.profile-dropdown')
    </div>
</nav>
