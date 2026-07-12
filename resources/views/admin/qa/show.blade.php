@extends('layouts.admin')

@section('title', 'Question Details')

@section('header')
    <h2>❓ Question from {{ $question->farmer->name }}</h2>
@endsection

@section('content')

    @if (session('status') === 'answer-posted')
        <div class="alert alert-success">✅ Your reply has been posted and the farmer has been notified.</div>
    @endif

    <div class="qa-detail-page">

        <div class="qa-detail-farmer-card">
            @if($question->farmer->profile && $question->farmer->profile->photo)
                <img src="{{ asset('storage/'.$question->farmer->profile->photo) }}" alt="{{ $question->farmer->name }}" class="qa-admin-avatar">
            @else
                <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑‍🌾</div>
            @endif
            <div>
                <strong>{{ $question->farmer->name }}</strong>
                <span>{{ $question->farmer->profile->address ?? 'Address not provided' }}</span>
            </div>
            <span class="qa-status-badge qa-status-{{ $question->status }}">
                {{ $question->is_answered ? 'Answered' : 'Pending' }}
            </span>
        </div>

        <div class="qa-thread">
            <div class="qa-bubble qa-bubble-question">
                @if($question->image_url)
                    <img src="{{ $question->image_url }}" alt="Question photo" class="qa-bubble-image">
                @endif
                <p>{{ $question->question_text }}</p>
                <div class="qa-bubble-meta">
                    <span>{{ $question->created_at->format('d M, Y — h:i A') }}</span>
                </div>
            </div>

            @foreach($question->answers as $answer)
                <div class="qa-bubble qa-bubble-answer">
                    <span class="qa-answer-author">🛠️ {{ $answer->admin->name ?? 'Krishi Bondhu Admin' }}</span>
                    <p>{{ $answer->answer_text }}</p>
                    <div class="qa-bubble-meta">
                        <span>{{ $answer->created_at->format('d M, Y — h:i A') }}</span>
                        <span>👍 {{ $answer->likers()->count() }} likes</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-card">
            <h3 class="form-card-title">Post a Reply</h3>
            <form method="POST" action="{{ route('admin.qa.answer', $question) }}" class="krishi-form">
                @csrf
                <div class="form-row">
                    <label for="answer_text">Your Reply</label>
                    <textarea id="answer_text" name="answer_text" rows="5" placeholder="Write your detailed reply here..." required>{{ old('answer_text') }}</textarea>
                    @error('answer_text') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.qa.index') }}" class="btn btn-secondary">Back to List</a>
                    <button type="submit" class="btn btn-primary">Post Reply</button>
                </div>
            </form>
        </div>

    </div>

@endsection
