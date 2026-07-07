@extends('layouts.app')

@section('title', 'My Profile')

@section('header')
    <h2>My Profile</h2>
@endsection

@section('content')
    <div class="profile-page">
        <div class="profile-card">
            <div class="profile-cover"></div>

            <div class="profile-photo-wrap">
                @if($user->profile && $user->profile->photo)
                    <img src="{{ asset('storage/' . $user->profile->photo) }}"
                         alt="{{ $user->name }}" class="profile-photo-large">
                @else
                    <div class="profile-photo-placeholder">🧑‍🌾</div>
                @endif
            </div>

            <h1 class="profile-name">{{ $user->name }}</h1>
            <span class="profile-role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary edit-profile-btn">✏️ Edit Profile</a>

            <div class="profile-details-grid">
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $user->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value">{{ $user->profile->phone ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Address</span>
                    <span class="detail-value">{{ $user->profile->address ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">District</span>
                    <span class="detail-value">{{ $user->profile->district ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Profession</span>
                    <span class="detail-value">{{ $user->profile->profession ?? 'Not provided' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Member Since</span>
                    <span class="detail-value">{{ $user->created_at->format('d M, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
