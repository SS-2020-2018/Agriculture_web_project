@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h2>Farmer Dashboard</h2>
@endsection

@section('content')
    <div class="welcome-panel">
        <h1>Welcome back, {{ auth()->user()->name }} 👋</h1>
        <p>
            This is a placeholder dashboard
        </p>

        <a href="{{ route('profile.show') }}" class="btn btn-primary">View My Profile</a>
    </div>
@endsection
