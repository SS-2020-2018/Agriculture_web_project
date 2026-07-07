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
            {{-- Crops, Weather, Reminders, Tips, Prices, Q&A, News, Feedback,
                 Fertilizer Guide links will be appended here phase by phase --}}
        </div>

        <div class="navbar-profile">
            <button class="profile-trigger" id="profileTrigger" type="button" aria-label="Open profile menu">
                @if(auth()->user()->profile && auth()->user()->profile->photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile->photo) }}"
                         alt="{{ auth()->user()->name }}" class="profile-avatar-img">
                @else
                    <span class="profile-avatar-emoji">🧑‍🌾</span>
                @endif
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>{{ auth()->user()->email }}</span>
                </div>

                <a href="{{ route('profile.show') }}" class="dropdown-item">
                    <span class="dropdown-icon">👤</span> View Profile
                </a>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <span class="dropdown-icon">✏️</span> Edit Profile
                </a>
                <a href="{{ route('dashboard') }}" class="dropdown-item">
                    <span class="dropdown-icon">📊</span> Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}" class="dropdown-logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-logout">
                        <span class="dropdown-icon">🚪</span> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
