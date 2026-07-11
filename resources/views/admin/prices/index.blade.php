@extends('layouts.admin')

@section('title', 'Crop Price Management')

@section('header')
    <h2>💰 Crop Price Management</h2>
@endsection

@section('content')

    @if (session('status') === 'price-added')
        <div class="alert alert-success">✅ Price published.</div>
    @elseif (session('status') === 'price-updated')
        <div class="alert alert-success">✅ Price updated.</div>
    @elseif (session('status') === 'price-deleted')
        <div class="alert alert-success">✅ Price deleted.</div>
    @endif

    <div class="crop-list-header">
        <h3>All Crop Prices ({{ $prices->count() }})</h3>
        <a href="{{ route('admin.prices.create') }}" class="btn btn-primary">+ Add Crop Price</a>
    </div>

    @if($prices->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">💰</div>
            <h3>No crop prices published yet</h3>
            <a href="{{ route('admin.prices.create') }}" class="btn btn-primary">+ Add Crop Price</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Crop</th>
                        <th>Price</th>
                        <th>Market</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prices as $price)
                        <tr>
                            <td>
                                @if($price->crop_image)
                                    <img src="{{ $price->image_url }}" alt="{{ $price->crop_name }}" class="admin-table-thumb">
                                @else
                                    <div class="admin-table-thumb admin-table-thumb-placeholder">🌾</div>
                                @endif
                            </td>
                            <td>{{ $price->crop_name }}</td>
                            <td><strong>{{ $price->formatted_price }}</strong></td>
                            <td>{{ $price->market_name }}</td>
                            <td>{{ $price->updated_at->format('d M, Y h:i A') }}</td>
                            <td class="admin-table-actions">
                                <a href="{{ route('prices.show', $price) }}" class="btn btn-secondary btn-sm" target="_blank">View</a>
                                <a href="{{ route('admin.prices.edit', $price) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-delete-url="{{ route('admin.prices.destroy', $price) }}" data-open-delete-modal>Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @include('admin.prices.partials.delete-modal')

@endsection
