@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h2>Farmer Dashboard</h2>
@endsection

@section('content')

    <div class="dashboard-welcome">
        <h1>Welcome back, {{ $user->name }} 👋</h1>
        <p>Here's what's happening on your farm today.</p>
    </div>

    <div class="dashboard-grid">
        @foreach($modules as $index => $module)
            <a href="{{ route($module['route']) }}"
               class="dashboard-card dash-color-{{ $module['color'] }}"
               style="animation-delay: {{ $index * 0.06 }}s">
                <div class="dashboard-card-icon">{{ $module['icon'] }}</div>
                <h3>{{ $module['title'] }}</h3>
                <p>{{ $module['summary'] }}</p>
            </a>
        @endforeach
    </div>

@endsection
