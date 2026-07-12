@extends('layouts.admin')

@section('title', 'Q&A Management')

@section('header')
    <h2>❓ Question & Answer Management</h2>
@endsection

@section('content')

    <div class="disease-toolbar">
        <input type="text" id="qaSearch" class="reminder-search-input" placeholder="🔍 Search by farmer name or question...">

        <div class="reminder-filter-buttons" id="qaStatusFilter">
            <button type="button" class="filter-btn active" data-status="all">All</button>
            <button type="button" class="filter-btn" data-status="pending">Pending</button>
            <button type="button" class="filter-btn" data-status="answered">Answered</button>
        </div>
    </div>

    @if($questions->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">❓</div>
            <h3>No questions submitted yet</h3>
        </div>
    @else
        <div class="qa-admin-list" id="qaAdminList">
            @foreach($questions as $question)
                <a href="{{ route('admin.qa.show', $question) }}"
                   class="qa-admin-row"
                   data-title="{{ strtolower($question->question_text.' '.$question->farmer->name) }}"
                   data-status="{{ $question->status }}">

                    @if($question->farmer->profile && $question->farmer->profile->photo)
                        <img src="{{ asset('storage/'.$question->farmer->profile->photo) }}" alt="{{ $question->farmer->name }}" class="qa-admin-avatar">
                    @else
                        <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑‍🌾</div>
                    @endif

                    <div class="qa-admin-row-body">
                        <div class="qa-admin-row-header">
                            <strong>{{ $question->farmer->name }}</strong>
                            <span class="qa-status-badge qa-status-{{ $question->status }}">
                                {{ $question->is_answered ? 'Answered' : 'Pending' }}
                            </span>
                        </div>
                        <p>{{ \Illuminate\Support\Str::limit($question->question_text, 100) }}</p>
                        <span class="qa-admin-row-date">{{ $question->created_at->diffForHumans() }}</span>
                    </div>

                    @if($question->image_url)
                        <img src="{{ $question->image_url }}" alt="Attached photo" class="qa-admin-row-thumb">
                    @endif
                </a>
            @endforeach
        </div>

        <div class="empty-state hidden" id="qaNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching questions</h3>
        </div>
    @endif

@endsection
