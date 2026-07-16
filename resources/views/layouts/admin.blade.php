<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Krishi Bondhu') }} Admin &mdash; @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="admin-layout" id="adminLayout">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-brand">
                <span class="brand-icon">🌾</span>
                <span class="brand-text admin-sidebar-label">Krishi Bondhu</span>
            </div>

            <nav class="admin-sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">📊</span>
                    <span class="admin-sidebar-label">Dashboard</span>
                </a>
                <a href="{{ route('admin.farmers.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.farmers.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">🧑‍🌾</span>
                    <span class="admin-sidebar-label">Farmers</span>
                </a>
                <a href="{{ route('admin.diseases.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.diseases.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">🚨</span>
                    <span class="admin-sidebar-label">Diseases</span>
                </a>
                <a href="{{ route('admin.fertilizers.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.fertilizers.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">🧪</span>
                    <span class="admin-sidebar-label">Fertilizers</span>
                </a>
                <a href="{{ route('admin.tips.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.tips.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">💡</span>
                    <span class="admin-sidebar-label">Farming Tips</span>
                </a>
                <a href="{{ route('admin.news.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">📰</span>
                    <span class="admin-sidebar-label">Agriculture News</span>
                </a>
                <a href="{{ route('admin.prices.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.prices.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">💰</span>
                    <span class="admin-sidebar-label">Crop Prices</span>
                </a>
                <a href="{{ route('admin.qa.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.qa.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">❓</span>
                    <span class="admin-sidebar-label">Q&amp;A</span>
                </a>
                <a href="{{ route('admin.feedback.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">⭐</span>
                    <span class="admin-sidebar-label">Feedback</span>
                </a>
                <a href="{{ route('admin.contact.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">✉️</span>
                    <span class="admin-sidebar-label">Messages</span>
                    @if($unreadContactMessagesCount > 0)
                        <span class="admin-sidebar-badge">{{ $unreadContactMessagesCount > 9 ? '9+' : $unreadContactMessagesCount }}</span>
                    @endif
                </a>

                <div class="admin-sidebar-divider"></div>

                <a href="{{ route('notifications.index') }}"
                   class="admin-sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">🔔</span>
                    <span class="admin-sidebar-label">Notifications</span>
                </a>
                <a href="{{ route('profile.show') }}"
                   class="admin-sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="admin-sidebar-icon">👤</span>
                    <span class="admin-sidebar-label">Profile</span>
                </a>
                <a href="{{ route('dashboard') }}" class="admin-sidebar-link">
                    <span class="admin-sidebar-icon">🌾</span>
                    <span class="admin-sidebar-label">Farmer View</span>
                </a>
            </nav>
        </aside>

        {{-- Mobile overlay, click to close sidebar on small screens --}}
        <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>

        {{-- ===================== MAIN AREA ===================== --}}
        <div class="admin-main-wrapper">

            <header class="admin-topbar">
                <button class="admin-sidebar-toggle" id="adminSidebarToggle" type="button" aria-label="Toggle sidebar">☰</button>

                <div class="admin-topbar-search">
                    <input type="text"
                           id="adminTopSearch"
                           class="admin-topbar-search-input"
                           placeholder="🔍 Search farmers, questions, crops..."
                           autocomplete="off"
                           data-search-url="{{ route('search') }}">

                    <div class="admin-search-dropdown" id="adminSearchDropdown">
                        <div class="search-results-list" id="adminSearchResultsList"></div>
                        <div class="search-empty-state hidden" id="adminSearchEmptyState">
                            <p>No results found.</p>
                        </div>
                    </div>
                </div>

                <div class="admin-topbar-actions">
                    @include('partials.notification-bell')
                    @include('partials.profile-dropdown')
                </div>
            </header>

            @hasSection('header')
                <div class="page-header">
                    <div class="page-header-content">
                        @yield('header')
                    </div>
                </div>
            @endif

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
