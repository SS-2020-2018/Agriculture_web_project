@extends('layouts.app')

@section('title', 'Add Crop')

@section('header')
    <h2>🌱 Add New Crop</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Crop Details</h3>

            <form method="POST" action="{{ route('crops.store') }}" enctype="multipart/form-data" class="krishi-form">
                @csrf

                @include('crops.partials.form')

                <div class="form-actions">
                    <a href="{{ route('crops.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Crop</button>
                </div>
            </form>
        </div>
    </div>
@endsection
