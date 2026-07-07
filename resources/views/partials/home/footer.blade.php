<footer class="site-footer">
    <div class="footer-container">

        <div class="footer-column footer-brand-column">
            <a href="{{ route('home') }}" class="footer-brand">
                <span class="brand-icon">🌾</span>
                <span class="brand-text">Krishi Bondhu</span>
            </a>
            <p>Krishi Bondhu helps farmers manage crops, track weather,
               spot diseases early, and get fair market prices — all from one
               simple platform.</p>

            <div class="footer-social">
                <a href="#" class="social-icon" aria-label="Facebook">📘</a>
                <a href="#" class="social-icon" aria-label="Twitter">🐦</a>
                <a href="#" class="social-icon" aria-label="YouTube">📺</a>
                <a href="#" class="social-icon" aria-label="Instagram">📷</a>
            </div>
        </div>

        <div class="footer-column">
            <h4>Quick Links</h4>
            <a href="{{ route('home') }}">Home</a>
            <a href="#services">Our Services</a>
            <a href="#contact">Contact</a>
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @endguest
        </div>

        <div class="footer-column">
            <h4>Useful Links</h4>
            <a href="#services">Weather Information</a>
            <a href="#services">Crop Management</a>
            <a href="#services">Disease Alerts</a>
            <a href="#services">Market Prices</a>
        </div>

        <div class="footer-column">
            <h4>Contact Info</h4>
            <p>📧 support@krishibondhu.com</p>
            <p>📞 +880 1741662609</p>
            <p>📍 Lalon Shah hall (Ground Floor,room 101),KUET, Khulna, Bangladesh</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Krishi Bondhu. All rights reserved.</p>
    </div>

    <button class="back-to-top" id="backToTopBtn" aria-label="Back to top" type="button">⬆</button>
</footer>
