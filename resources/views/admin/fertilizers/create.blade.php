@extends('layouts.admin')

@section('title', 'Add Fertilizer Guide')

@section('header')
    <h2>🧪 Add Fertilizer Guide</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Fertilizer Recommendation</h3>

            <form method="POST" action="{{ route('admin.fertilizers.store') }}" enctype="multipart/form-data" class="krishi-form">
                @csrf

                @include('admin.fertilizers.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.fertilizers.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Publish Guide</button>
                </div>
            </form>
        </div>
    </div>
@endsection
