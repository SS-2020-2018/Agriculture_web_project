@extends('layouts.admin')

@section('title', 'Edit Crop Price')

@section('header')
    <h2>✏️ Edit {{ $price->crop_name }} Price</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Price Details</h3>

            <form method="POST" action="{{ route('admin.prices.update', $price) }}" enctype="multipart/form-data" class="krishi-form">
                @csrf
                @method('put')

                @include('admin.prices.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.prices.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
