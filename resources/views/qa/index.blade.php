@extends('layouts.app')

@section('title', 'Question & Answer')

@section('header')
    <h2>❓ Question & Answer</h2>
@endsection

@section('content')

    @if (session('status') === 'question-submitted')
        <div class="alert alert-success">✅ Your question has been submitted. An admin will reply soon.</div>
    @endif

    <div class="form-card qa-form-card">
        <h3 class="form-card-title">Ask a Question</h3>

        <form method="POST" action="{{ route('qa.store') }}" enctype="multipart/form-data" class="krishi-form">
            @csrf

            <div class="form-row">
                <label for="question_text">Your Question</label>
                <textarea id="question_text" name="question_text" rows="4"
                          placeholder="e.g. Why are my rice leaves turning yellow?" required>{{ old('question_text') }}</textarea>
                @error('question_text') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="crop-image-upload-row">
                <div class="crop-image-preview-wrap">
                    <img id="questionImagePreview" src="" alt="Preview" class="crop-image-preview-img hidden">
                    <div id="questionImagePlaceholder" class="crop-image-preview-placeholder">📷</div>
                </div>
                <div class="photo-upload-controls">
                    <label for="image" class="btn btn-secondary">Attach Photo (optional)</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="visually-hidden-input">
                    <p class="field-hint">JPG or PNG, max 4MB.</p>
                    @error('image') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Question</button>
        </form>
    </div>

    <h3 class="qa-thread-heading">Your Conversations</h3>

    @if($questions->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">❓</div>
            <h3>No questions yet</h3>
            <p>Ask your first question above — admins usually reply quickly.</p>
        </div>
    @else
        <div class="qa-thread-list">
            @foreach($questions as $question)
                <div class="qa-thread" id="question-{{ $question->id }}">

                    {{-- The farmer's question bubble --}}
                    <div class="qa-bubble qa-bubble-question">
                        @if($question->image_url)
                            <img src="{{ $question->image_url }}" alt="Question photo" class="qa-bubble-image">
                        @endif
                        <p>{{ $question->question_text }}</p>
                        <div class="qa-bubble-meta">
                            <span>{{ $question->created_at->format('d M, Y — h:i A') }}</span>
                            <span class="qa-status-badge qa-status-{{ $question->status }}">
                                {{ $question->is_answered ? 'Answered' : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    {{-- Admin reply bubble(s) --}}
                    @foreach($question->answers as $answer)
                        <div class="qa-bubble qa-bubble-answer">
                            <span class="qa-answer-author">🛠️ {{ $answer->admin->name ?? 'Krishi Bondhu Admin' }}</span>
                            <p>{{ $answer->answer_text }}</p>
                            <div class="qa-bubble-meta">
                                <span>{{ $answer->created_at->format('d M, Y — h:i A') }}</span>
                                <button type="button"
                                        class="answer-like-btn {{ in_array($answer->id, $likedAnswerIds) ? 'answer-like-btn-active' : '' }}"
                                        data-like-url="{{ route('qa.answers.like', $answer) }}">
                                    <span class="answer-like-icon">{{ in_array($answer->id, $likedAnswerIds) ? '👍' : '👍🏻' }}</span>
                                    <span class="answer-like-count">{{ $answer->likers()->count() }}</span>
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
    @endif

@endsection
