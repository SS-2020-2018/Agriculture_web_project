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
    <div class="app-wrapper">

        <nav class="admin-navbar">
            <div class="admin-navbar-container">
                <div class="admin-navbar-brand">
                    <span class="brand-icon">🛠️</span>
                    <span class="brand-text">Krishi Bondhu Admin</span>
                </div>

                <div class="admin-navbar-links">
                    <a href="{{ route('admin.diseases.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.diseases.*') ? 'active' : '' }}">
                        🚨 Diseases
                    </a>
                    <a href="{{ route('admin.tips.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.tips.*') ? 'active' : '' }}">
                        💡 Tips
                    </a>
                    <a href="{{ route('admin.prices.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.prices.*') ? 'active' : '' }}">
                        💰 Prices
                    </a>
                    <a href="{{ route('admin.qa.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.qa.*') ? 'active' : '' }}">
                        ❓ Q&amp;A
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        📰 News
                    </a>
                    <a href="{{ route('admin.feedback.index') }}"
                       class="nav-link-admin {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                        ⭐ Feedback
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-link-admin">← Farmer Dashboard</a>

                    <form method="POST" action="{{ route('logout') }}" class="admin-logout-form">
                        @csrf
                        <button type="submit" class="nav-link-admin admin-logout-btn">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        @hasSection('header')
            <header class="page-header">
                <div class="page-header-content">
                    @yield('header')
                </div>
            </header>
        @endif

        <main class="app-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
