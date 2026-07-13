@extends('layouts.admin')

@section('title', 'Fertilizer Management')

@section('header')
    <h2>🧪 Fertilizer Management</h2>
@endsection

@section('content')

    @if (session('status') === 'fertilizer-added')
        <div class="alert alert-success">✅ Fertilizer guide published.</div>
    @elseif (session('status') === 'fertilizer-updated')
        <div class="alert alert-success">✅ Fertilizer guide updated.</div>
    @elseif (session('status') === 'fertilizer-deleted')
        <div class="alert alert-success">✅ Fertilizer guide deleted.</div>
    @endif

    <div class="crop-list-header">
        <h3>All Fertilizer Guides ({{ $fertilizers->count() }})</h3>
        <a href="{{ route('admin.fertilizers.create') }}" class="btn btn-primary">+ Add Fertilizer Guide</a>
    </div>

    @if($fertilizers->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🧪</div>
            <h3>No fertilizer guides published yet</h3>
            <a href="{{ route('admin.fertilizers.create') }}" class="btn btn-primary">+ Add Fertilizer Guide</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Crop</th>
                        <th>Fertilizers</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fertilizers as $fertilizer)
                        <tr>
                            <td>
                                @if($fertilizer->crop_image)
                                    <img src="{{ $fertilizer->image_url }}" alt="{{ $fertilizer->crop_name }}" class="admin-table-thumb">
                                @else
                                    <div class="admin-table-thumb admin-table-thumb-placeholder">🧪</div>
                                @endif
                            </td>
                            <td>{{ $fertilizer->crop_name }}</td>
                            <td>{{ $fertilizer->fertilizers }}</td>
                            <td>{{ $fertilizer->updated_at->format('d M, Y') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('fertilizer.show', $fertilizer) }}" class="btn btn-secondary btn-sm" target="_blank">View</a>
                                <a href="{{ route('admin.fertilizers.edit', $fertilizer) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('admin.fertilizers.destroy', $fertilizer) }}" data-open-delete-modal>Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @include('admin.fertilizers.partials.delete-modal')

@endsection
