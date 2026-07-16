@extends('layouts.admin')

@section('title', $farmer->name)

@section('header')
    <h2>🧑‍🌾 {{ $farmer->name }}</h2>
@endsection

@section('content')

    @if (session('status') === 'crop-feedback-saved')
        <div class="alert alert-success">✅ Feedback saved for that crop.</div>
    @elseif (session('status') === 'farmer-suspended')
        <div class="alert alert-success">✅ {{ $farmer->name }}'s account has been suspended.</div>
    @elseif (session('status') === 'farmer-reactivated')
        <div class="alert alert-success">✅ {{ $farmer->name }}'s account has been reactivated.</div>
    @endif

    <div class="farmer-profile-card">
        @if($farmer->profile && $farmer->profile->photo)
            <img src="{{ asset('storage/'.$farmer->profile->photo) }}" alt="{{ $farmer->name }}" class="farmer-profile-avatar">
        @else
            <div class="farmer-profile-avatar farmer-profile-avatar-placeholder">🧑‍🌾</div>
        @endif

        <div class="farmer-profile-info">
            <h1>{{ $farmer->name }}</h1>
            <span class="qa-status-badge {{ $farmer->account_status === 'active' ? 'qa-status-answered' : 'qa-status-pending' }}">
                {{ ucfirst($farmer->account_status) }}
            </span>

            <div class="farmer-profile-detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $farmer->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value">{{ $farmer->profile->phone ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Address</span>
                    <span class="detail-value">{{ $farmer->profile->address ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">District</span>
                    <span class="detail-value">{{ $farmer->profile->district ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Profession</span>
                    <span class="detail-value">{{ $farmer->profile->profession ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Registered On</span>
                    <span class="detail-value">{{ $farmer->created_at->format('d M, Y') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.farmers.toggle-status', $farmer) }}" class="farmer-status-form">
                @csrf
                @method('patch')
                @if($farmer->account_status === 'active')
                    <button type="submit" class="btn btn-danger">🚫 Suspend Account</button>
                @else
                    <button type="submit" class="btn btn-primary">✅ Reactivate Account</button>
                @endif
            </form>
        </div>
    </div>

    <h3 class="qa-thread-heading">Registered Crops ({{ $crops->count() }})</h3>

    @if($crops->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🌱</div>
            <h3>This farmer hasn't registered any crops yet</h3>
        </div>
    @else
        <div class="crop-grid">
            @foreach($crops as $crop)
                <div class="crop-card">
                    <div class="crop-card-image-wrap">
                        <img src="{{ $crop->image_url }}" alt="{{ $crop->name }}" class="crop-card-image">
                        <span class="crop-status-badge crop-status-{{ $crop->status_color }}">{{ $crop->status_label }}</span>
                    </div>

                    <div class="crop-card-body">
                        <h3>{{ $crop->name }}</h3>
                        <div class="crop-card-meta">
                            <span>🌱 Planted: {{ $crop->planting_date->format('d M, Y') }}</span>
                            <span>🌾 Harvest: {{ $crop->expected_harvest_date->format('d M, Y') }}</span>
                            <span>📏 {{ $crop->land_area }}</span>
                        </div>

                        @if($crop->description)
                            <p class="crop-card-description">{{ $crop->description }}</p>
                        @endif

                        <div class="admin-crop-feedback-box">
                            <span class="detail-label">Your Feedback</span>
                            @if($crop->admin_feedback)
                                <p class="admin-crop-feedback-existing">{{ $crop->admin_feedback }}</p>
                                <span class="crop-feedback-date">Last updated {{ $crop->admin_feedback_at?->diffForHumans() }}</span>
                            @else
                                <p class="feedback-locked-note">No feedback given yet.</p>
                            @endif

                            <form method="POST" action="{{ route('admin.crops.feedback', $crop) }}" class="krishi-form admin-crop-feedback-form">
                                @csrf
                                @method('patch')
                                <textarea name="admin_feedback" rows="2" placeholder="Leave feedback on this crop...">{{ $crop->admin_feedback }}</textarea>
                                <button type="submit" class="btn btn-secondary btn-sm">{{ $crop->admin_feedback ? 'Update Feedback' : 'Save Feedback' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
