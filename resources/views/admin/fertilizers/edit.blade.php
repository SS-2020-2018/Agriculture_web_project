@extends('layouts.admin')

@section('title', 'Edit Fertilizer Guide')

@section('header')
    <h2>✏️ Edit {{ $fertilizer->crop_name }} Guide</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Fertilizer Recommendation</h3>

            <form method="POST" action="{{ route('admin.fertilizers.update', $fertilizer) }}" enctype="multipart/form-data" class="krishi-form">
                @csrf
                @method('put')

                @include('admin.fertilizers.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.fertilizers.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
