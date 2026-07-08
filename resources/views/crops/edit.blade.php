@extends('layouts.app')

@section('title', 'Edit Crop')

@section('header')
    <h2>✏️ Edit {{ $crop->name }}</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Crop Details</h3>

            <form method="POST" action="{{ route('crops.update', $crop) }}" enctype="multipart/form-data" class="krishi-form">
                @csrf
                @method('put')

                @include('crops.partials.form')

                <div class="form-actions">
                    <a href="{{ route('crops.show', $crop) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
