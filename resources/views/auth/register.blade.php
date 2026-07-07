@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <h1 class="guest-title">Create Your Account</h1>
    <p class="guest-subtitle">Join Krishi Bondhu and start managing your farm smarter.</p>

    <form method="POST" action="{{ route('register') }}" class="krishi-form">
        @csrf

        <div class="form-row">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-row">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-row">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-row">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>

        <p class="guest-footer-text">
            Already have an account?
            <a href="{{ route('login') }}" class="guest-link">Log in</a>
        </p>
    </form>
@endsection
