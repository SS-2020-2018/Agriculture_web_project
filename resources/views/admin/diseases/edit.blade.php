@extends('layouts.admin')

@section('title', 'Edit Disease')

@section('header')
    <h2>✏️ Edit {{ $disease->name }}</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Disease Details</h3>

            <form method="POST" action="{{ route('admin.diseases.update', $disease) }}" enctype="multipart/form-data" class="krishi-form">
                @csrf
                @method('put')

                @include('admin.diseases.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.diseases.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
