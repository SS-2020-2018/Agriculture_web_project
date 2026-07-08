@extends('layouts.app')

@section('title', $title)

@section('header')
    <h2>{{ $icon }} {{ $title }}</h2>
@endsection

@section('content')
    <div class="coming-soon-panel">
        <div class="coming-soon-icon">{{ $icon }}</div>
        <h1>{{ $title }} is on its way</h1>
        <p>
            This module hasn't been built yet in our current development
            phase. Once it's ready, this card will take you straight to the
            full {{ strtolower($title) }} experience.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
@endsection
