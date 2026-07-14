@extends('layouts.app')

@section('title', 'Reminder Calendar')

@section('header')
    <h2>📅 Reminder Calendar</h2>
@endsection

@section('content')

    @if (session('status') === 'reminder-added')
        <div class="alert alert-success">✅ Reminder added successfully.</div>
    @elseif (session('status') === 'reminder-updated')
        <div class="alert alert-success">✅ Reminder updated successfully.</div>
    @elseif (session('status') === 'reminder-deleted')
        <div class="alert alert-success">✅ Reminder deleted successfully.</div>
    @endif

    <div class="reminder-summary-grid">
        <div class="reminder-stat-box">
            <span class="reminder-stat-number" id="reminderStatTotal">{{ $stats['total'] }}</span>
            <span class="reminder-stat-label">Total Reminders</span>
        </div>
        <div class="reminder-stat-box reminder-stat-orange">
            <span class="reminder-stat-number" id="reminderStatPending">{{ $stats['pending'] }}</span>
            <span class="reminder-stat-label">Pending</span>
        </div>
        <div class="reminder-stat-box reminder-stat-green">
            <span class="reminder-stat-number" id="reminderStatCompleted">{{ $stats['completed'] }}</span>
            <span class="reminder-stat-label">Completed</span>
        </div>
        <div class="reminder-stat-box reminder-stat-indigo">
            <span class="reminder-stat-number" id="reminderStatToday">{{ $stats['today'] }}</span>
            <span class="reminder-stat-label">Scheduled Today</span>
        </div>
    </div>

    <div class="reminder-layout">

        {{-- LEFT: sidebar form (Add / Edit) --}}
        <aside class="reminder-sidebar">
            <div class="form-card" id="reminderFormCard">
                <h3 class="form-card-title" id="reminderFormTitle">Add Reminder</h3>

                <form method="POST"
                      action="{{ route('reminders.store') }}"
                      id="reminderForm"
                      class="krishi-form"
                      data-store-url="{{ route('reminders.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="reminderFormMethod" value="POST">
                    <input type="hidden" name="task_id" id="reminderTaskId" value="">

                    <div class="form-row">
                        <label for="title">Task Title</label>
                        <input type="text" id="title" name="title" list="taskSuggestions"
                               value="{{ old('title') }}" placeholder="e.g. Watering" required>
                        <datalist id="taskSuggestions">
                            <option value="Watering">
                            <option value="Fertilizing">
                            <option value="Spraying">
                            <option value="Harvesting">
                        </datalist>
                        @error('title') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="reminder_date">Reminder Date</label>
                        <input type="date" id="reminder_date" name="reminder_date" value="{{ old('reminder_date') }}" required>
                        @error('reminder_date') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-row">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Any extra details...">{{ old('notes') }}</textarea>
                        @error('notes') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="button" id="cancelEditReminder" class="btn btn-secondary hidden">Cancel</button>
                        <button type="submit" id="reminderSubmitBtn" class="btn btn-primary btn-block">Add Reminder</button>
                    </div>
                </form>
            </div>
        </aside>

        {{-- RIGHT: toolbar + reminder list --}}
        <section class="reminder-list-section">

            <div class="reminder-toolbar">
                <input type="text" id="reminderSearch" class="reminder-search-input" placeholder="🔍 Search reminders by title...">

                <div class="reminder-filter-buttons">
                    <button type="button" class="filter-btn active" data-filter="all">All</button>
                    <button type="button" class="filter-btn" data-filter="pending">Pending</button>
                    <button type="button" class="filter-btn" data-filter="completed">Completed</button>
                </div>

                <button type="button" class="btn btn-secondary btn-sm" id="reminderSortToggle">Sort: Newest First ⬍</button>
            </div>

            <h3 class="reminder-list-heading">Your Reminders</h3>

            <div class="reminder-list" id="reminderList">
                @forelse($reminders as $reminder)
                    <div class="reminder-item
                                {{ $reminder->is_completed ? 'reminder-completed' : '' }}
                                {{ $reminder->is_today ? 'reminder-today' : '' }}
                                {{ $reminder->is_overdue ? 'reminder-overdue' : '' }}
                                {{ $reminder->is_upcoming ? 'reminder-upcoming' : '' }}"
                         id="reminder-{{ $reminder->id }}"
                         data-title="{{ strtolower($reminder->title) }}"
                         data-status="{{ $reminder->is_completed ? 'completed' : 'pending' }}"
                         data-date="{{ $reminder->reminder_date->format('Y-m-d') }}">

                        <label class="reminder-checkbox-wrap">
                            <input type="checkbox"
                                   class="reminder-checkbox"
                                   data-toggle-url="{{ route('reminders.toggle', $reminder) }}"
                                   {{ $reminder->is_completed ? 'checked' : '' }}>
                            <span class="reminder-checkmark"></span>
                        </label>

                        <div class="reminder-content">
                            <div class="reminder-content-header">
                                <h4>{{ $reminder->title }}</h4>
                                <div class="reminder-badges">
                                    <span class="reminder-date-badge">{{ $reminder->reminder_date->format('d M, Y') }}</span>
                                    @if($reminder->is_today)
                                        <span class="reminder-tag reminder-tag-today">Today</span>
                                    @elseif($reminder->is_overdue)
                                        <span class="reminder-tag reminder-tag-overdue">Overdue</span>
                                    @elseif($reminder->is_upcoming)
                                        <span class="reminder-tag reminder-tag-upcoming">Upcoming</span>
                                    @endif
                                </div>
                            </div>
                            @if($reminder->notes)
                                <p class="reminder-notes">{{ $reminder->notes }}</p>
                            @endif
                        </div>

                        <div class="reminder-actions">
                            <button type="button" class="icon-btn reminder-edit-btn"
                                    data-id="{{ $reminder->id }}"
                                    data-title="{{ $reminder->title }}"
                                    data-date="{{ $reminder->reminder_date->format('Y-m-d') }}"
                                    data-notes="{{ $reminder->notes }}"
                                    data-update-url="{{ route('reminders.update', $reminder) }}"
                                    aria-label="Edit reminder">✏️</button>
                            <button type="button" class="icon-btn icon-btn-danger reminder-delete-btn"
                                    data-delete-url="{{ route('reminders.destroy', $reminder) }}"
                                    data-open-delete-modal
                                    aria-label="Delete reminder">🗑️</button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" id="reminderEmptyState">
                        <div class="empty-state-icon">📅</div>
                        <h3>No reminders yet</h3>
                        <p>Add your first farming reminder using the form on the left.</p>
                    </div>
                @endforelse

                <div class="empty-state hidden" id="reminderNoMatches">
                    <div class="empty-state-icon">🔍</div>
                    <h3>No matching reminders</h3>
                    <p>Try a different search term or filter.</p>
                </div>
            </div>

        </section>
    </div>

    @include('reminders.partials.delete-modal')

    {{-- If a validation error happened while editing a reminder, tell the
         JS which reminder's edit form to re-open on load. --}}
    @if(old('_method') === 'PUT' && old('task_id'))
        <script>window.reopenEditReminderId = {{ (int) old('task_id') }};</script>
    @endif

@endsection
