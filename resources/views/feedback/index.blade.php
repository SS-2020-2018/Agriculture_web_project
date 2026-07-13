@extends('layouts.app')

@section('title', 'Feedback')

@section('header')
    <h2>⭐ Feedback</h2>
@endsection

@section('content')

    @if (session('status') === 'feedback-submitted')
        <div class="alert alert-success">✅ Thank you! Your feedback has been submitted.</div>
    @elseif (session('status') === 'feedback-updated')
        <div class="alert alert-success">✅ Your feedback has been updated.</div>
    @elseif (session('status') === 'feedback-deleted')
        <div class="alert alert-success">✅ Your feedback has been removed.</div>
    @endif

    <div class="form-card feedback-form-card" id="feedbackFormCard">
        <h3 class="form-card-title" id="feedbackFormTitle">Share Your Experience</h3>
        <p class="feedback-form-sub">Tell us what you think of Krishi Bondhu — your feedback helps us improve.</p>

        <form method="POST"
              action="{{ route('feedback.store') }}"
              id="feedbackForm"
              class="krishi-form"
              data-store-url="{{ route('feedback.store') }}">
            @csrf
            <input type="hidden" name="_method" id="feedbackFormMethod" value="POST">

            <div class="form-row">
                <label>Your Rating</label>
                <div class="star-rating" id="starRating">
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">★</span>
                    @endfor
                </div>
                @error('rating') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-row">
                <label for="comment">Your Comments</label>
                <textarea id="comment" name="comment" rows="4"
                          placeholder="Suggestions, compliments, or things we could improve...">{{ old('comment') }}</textarea>
                @error('comment') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-actions">
                <button type="button" id="cancelEditFeedback" class="btn btn-secondary hidden">Cancel</button>
                <button type="submit" id="feedbackSubmitBtn" class="btn btn-primary">Submit Feedback</button>
            </div>
        </form>
    </div>

    <h3 class="qa-thread-heading">Your Previous Feedback</h3>

    @if($feedbackEntries->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">⭐</div>
            <h3>No feedback submitted yet</h3>
            <p>Share your thoughts using the form above.</p>
        </div>
    @else
        <div class="feedback-history-list">
            @foreach($feedbackEntries as $entry)
                <div class="feedback-history-card">
                    <div class="feedback-history-header">
                        <div class="star-display">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star-display-icon {{ $i <= $entry->rating ? 'star-display-filled' : '' }}">★</span>
                            @endfor
                        </div>
                        <span class="qa-status-badge {{ $entry->is_reviewed ? 'qa-status-answered' : 'qa-status-pending' }}">
                            {{ $entry->is_reviewed ? 'Reviewed' : 'Pending Review' }}
                        </span>
                    </div>
                    <p>{{ $entry->comment }}</p>
                    <div class="feedback-history-footer">
                        <span>{{ $entry->created_at->format('d M, Y — h:i A') }}</span>

                        @if($entry->is_editable)
                            <div class="feedback-history-actions">
                                <button type="button" class="icon-btn feedback-edit-btn"
                                        data-id="{{ $entry->id }}"
                                        data-rating="{{ $entry->rating }}"
                                        data-comment="{{ $entry->comment }}"
                                        data-update-url="{{ route('feedback.update', $entry) }}"
                                        aria-label="Edit feedback">✏️</button>
                                <button type="button" class="icon-btn icon-btn-danger feedback-delete-btn"
                                        data-delete-url="{{ route('feedback.destroy', $entry) }}"
                                        data-open-delete-modal
                                        aria-label="Delete feedback">🗑️</button>
                            </div>
                        @else
                            <span class="feedback-locked-note">🔒 Locked (already reviewed)</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @include('feedback.partials.delete-modal')

@endsection
