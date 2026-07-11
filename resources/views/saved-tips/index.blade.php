@extends('layouts.app')

@section('title', 'Saved Tips')

@section('header')
    <h2>🔖 Saved Tips</h2>
@endsection

@section('content')

    @if (session('status') === 'tip-unsaved')
        <div class="alert alert-success">✅ Removed from your saved tips.</div>
    @endif

    <div class="tips-page-header">
        <p>Tips you've saved for later — these stay here even if the original is removed.</p>
        <a href="{{ route('tips.index') }}" class="btn btn-secondary">💡 Browse All Tips</a>
    </div>

    @if($savedTips->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🔖</div>
            <h3>No saved tips yet</h3>
            <p>Tap the 🔖 icon on any farming tip to save it here for later.</p>
        </div>
    @else
        <div class="tips-grid">
            @foreach($savedTips as $savedTip)
                <div class="tip-card">
                    @if($savedTip->image_url)
                        <img src="{{ $savedTip->image_url }}" alt="{{ $savedTip->title }}" class="tip-card-image">
                    @endif
                    <div class="tip-card-body">
                        <h3>{{ $savedTip->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($savedTip->description, 100) }}</p>
                        <span class="tip-card-date">Saved {{ $savedTip->created_at->format('d M, Y') }}</span>

                        <div class="tip-card-actions">
                            <form method="POST" action="{{ route('saved-tips.destroy', $savedTip) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
