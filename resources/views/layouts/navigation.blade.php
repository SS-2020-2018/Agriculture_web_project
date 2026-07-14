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

        <div class="navbar-search">
            <button class="search-trigger" id="searchTrigger" type="button" aria-label="Search everything">🔍</button>

            <div class="search-panel" id="searchPanel">
                <div class="search-panel-inner">

                    <div class="search-input-row">
                        <span class="search-input-icon">🔍</span>
                        <input type="text"
                               id="globalSearchInput"
                               class="search-input"
                               placeholder="Search crops, tips, news, diseases, and more..."
                               autocomplete="off"
                               data-search-url="{{ route('search') }}">
                        <span class="search-loading-spinner hidden" id="searchLoadingSpinner">⏳</span>
                        <button type="button" class="search-clear-btn hidden" id="clearSearchBtn" aria-label="Clear search">✕</button>
                    </div>

                    <div class="search-controls-row">
                        <select id="searchCategoryFilter" class="search-select">
                            <option value="all">All Categories</option>
                            <option value="crops">🌱 Crops</option>
                            <option value="tips">💡 Farming Tips</option>
                            <option value="saved_tips">🔖 Saved Tips</option>
                            <option value="questions">❓ Q&amp;A</option>
                            <option value="prices">💰 Crop Prices</option>
                            <option value="news">📰 News</option>
                            <option value="diseases">🚨 Disease Alerts</option>
                            <option value="fertilizers">🧪 Fertilizer Guide</option>
                            <option value="reminders">📅 Reminders</option>
                            <option value="feedback">⭐ Feedback</option>
                        </select>

                        <select id="searchSortSelect" class="search-select">
                            <option value="relevance">Sort: Relevance</option>
                            <option value="newest">Sort: Newest</option>
                            <option value="oldest">Sort: Oldest</option>
                            <option value="az">Sort: A–Z</option>
                        </select>
                    </div>

                    <div class="search-results-area" id="searchResultsArea">
                        <div class="search-recent-wrap hidden" id="searchRecentWrap">
                            <span class="search-recent-label">Recent Searches</span>
                            <div class="search-recent-chips" id="searchRecentChips"></div>
                        </div>

                        <div class="search-results-list" id="searchResultsList"></div>

                        <div class="search-empty-state hidden" id="searchEmptyState">
                            <div class="empty-state-icon">🔍</div>
                            <p>No results found for "<span id="searchEmptyQuery"></span>"</p>
                        </div>

                        <div class="search-hint hidden" id="searchHint">
                            <p>Type at least 2 characters to search.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('partials.notification-bell')

        @include('partials.profile-dropdown')
    </div>
</nav>
