@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h1 class="guest-title">Welcome Back</h1>
    <p class="guest-subtitle">Log in to manage your farm with Krishi Bondhu.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="krishi-form">
        @csrf

        <div class="form-row">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-row">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-row-inline">
            <label class="checkbox-label">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="guest-link">Forgot your password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary btn-block">Log In</button>

        <p class="guest-footer-text">
            Don't have an account?
            <a href="{{ route('register') }}" class="guest-link">Register here</a>
        </p>
    </form>
@endsection
