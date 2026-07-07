@extends('layouts.app')

@section('title', 'Edit Profile')

@section('header')
    <h2>Edit Profile</h2>
@endsection

@section('content')
    <div class="profile-page">

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">✅ Your profile has been updated successfully.</div>
        @endif

        <div class="edit-grid">

            {{-- ACCOUNT + PROFILE INFO --}}
            <div class="form-card">
                <h3 class="form-card-title">Account &amp; Profile Information</h3>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="krishi-form">
                    @csrf
                    @method('patch')

                    <div class="photo-upload-row">
                        <div class="photo-preview-wrap">
                            <img id="photoPreview"
                                 src="{{ $user->profile && $user->profile->photo ? asset('storage/' . $user->profile->photo) : '' }}"
                                 alt="Preview"
                                 class="photo-preview-img {{ $user->profile && $user->profile->photo ? '' : 'hidden' }}">
                            <div id="photoPlaceholder"
                                 class="photo-preview-placeholder {{ $user->profile && $user->profile->photo ? 'hidden' : '' }}">
                                🧑‍🌾
                            </div>
                        </div>
                        <div class="photo-upload-controls">
                            <label for="photo" class="btn btn-secondary">Choose Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/png, image/jpeg" class="visually-hidden-input">
                            <p class="field-hint">JPG or PNG, max 2MB</p>
                            @error('photo')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                            @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-row">
                            <label for="district">District</label>
                            <input type="text" id="district" name="district" value="{{ old('district', $user->profile->district ?? '') }}">
                            @error('district') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->profile->address ?? '') }}">
                        @error('address') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="profession">Profession</label>
                        <input type="text" id="profession" name="profession" value="{{ old('profession', $user->profile->profession ?? '') }}" placeholder="e.g. Rice Farmer, Vegetable Grower">
                        @error('profession') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>

            {{-- UPDATE PASSWORD --}}
            <div class="form-card">
                <h3 class="form-card-title">Update Password</h3>

                <form method="POST" action="{{ route('password.update') }}" class="krishi-form">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password">
                        @error('current_password', 'updatePassword') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password">
                        @error('password', 'updatePassword') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>

            {{-- DELETE ACCOUNT --}}
            <div class="form-card form-card-danger">
                <h3 class="form-card-title">Delete Account</h3>
                <p class="form-card-note">
                    Once your account is deleted, all of its data — including
                    your profile, crops, and reminders — will be permanently
                    removed. This action cannot be undone.
                </p>

                <button type="button" class="btn btn-danger" id="openDeleteAccountModal">Delete Account</button>

                <div class="modal-backdrop hidden" id="deleteAccountModal">
                    <div class="modal-box">
                        <h4>Are you sure you want to delete your account?</h4>
                        <p>Please enter your password to confirm.</p>

                        <form method="POST" action="{{ route('profile.destroy') }}" class="krishi-form">
                            @csrf
                            @method('delete')

                            <div class="form-row">
                                <label for="delete_password">Password</label>
                                <input type="password" id="delete_password" name="password">
                                @error('password', 'userDeletion') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="modal-actions">
                                <button type="button" class="btn btn-secondary" id="cancelDeleteAccount">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
