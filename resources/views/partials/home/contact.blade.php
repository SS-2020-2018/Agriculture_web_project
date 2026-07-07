<section class="contact-section" id="contact">
    <div class="section-container">
        <div class="section-heading">
            <h2>Get in Touch</h2>
            <p>Questions about Krishi Bondhu? We'd love to hear from you.</p>
        </div>

        @if (session('contact_status'))
            <div class="alert alert-success">✅ {{ session('contact_status') }}</div>
        @endif

        <div class="contact-grid">
            <div class="contact-info-card">
                <div class="contact-info-item">
                    <span class="contact-info-icon">📧</span>
                    <div>
                        <span class="contact-info-label">Email</span>
                        <span class="contact-info-value">support@krishibondhu.com</span>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon">📞</span>
                    <div>
                        <span class="contact-info-label">Phone</span>
                        <span class="contact-info-value">+880 1741662609</span>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon">📍</span>
                    <div>
                        <span class="contact-info-label">Office Address</span>
                        <span class="contact-info-value">Lalon Shah hall (Ground Floor,room 101),KUET, Khulna, Bangladesh</span>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon">🕒</span>
                    <div>
                        <span class="contact-info-label">Business Hours</span>
                        <span class="contact-info-value">24 Hours</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('contact.store') }}" class="krishi-form contact-form-card">
                @csrf

                <div class="form-row-group">
                    <div class="form-row">
                        <label for="contact_name">Full Name</label>
                        <input type="text" id="contact_name" name="name" value="{{ old('name') }}" required>
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-row">
                        <label for="contact_email">Email Address</label>
                        <input type="email" id="contact_email" name="email" value="{{ old('email') }}" required>
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-row-group">
                    <div class="form-row">
                        <label for="contact_phone">Phone (optional)</label>
                        <input type="text" id="contact_phone" name="phone" value="{{ old('phone') }}">
                        @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-row">
                        <label for="contact_subject">Subject</label>
                        <input type="text" id="contact_subject" name="subject" value="{{ old('subject') }}">
                        @error('subject') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <label for="contact_message">Message</label>
                    <textarea id="contact_message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>
