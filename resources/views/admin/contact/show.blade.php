@extends('layouts.admin')

@section('title', 'Message from '.$message->name)

@section('header')
    <h2>✉️ Message from {{ $message->name }}</h2>
@endsection

@section('content')

    <div class="qa-detail-page">

        <div class="qa-detail-farmer-card">
            <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑</div>
            <div>
                <strong>{{ $message->name }}</strong>
                <span>{{ $message->email }}{{ $message->phone ? ' • '.$message->phone : '' }}</span>
            </div>
            <span class="qa-status-badge qa-status-answered">Read</span>
        </div>

        <div class="crop-detail-page">
            <div class="crop-detail-card">
                <div class="crop-detail-body">
                    <div class="crop-detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Subject</span>
                            <span class="detail-value">{{ $message->subject ?: 'No subject provided' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Received</span>
                            <span class="detail-value">{{ $message->created_at->format('d M, Y — h:i A') }}</span>
                        </div>
                    </div>

                    <div class="disease-info-section">
                        <h4>Message</h4>
                        <p>{{ $message->message }}</p>
                    </div>

                    <div class="crop-detail-actions">
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">← Back to Messages</a>
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject ?: 'Your message to Krishi Bondhu' }}" class="btn btn-primary">✉️ Reply via Email</a>
                        <form method="POST" action="{{ route('admin.contact.destroy', $message) }}" onsubmit="return confirm('Delete this message permanently?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
