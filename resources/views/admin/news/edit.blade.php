@extends('layouts.admin')

@section('title', 'Edit News')

@section('header')
    <h2>✏️ Edit {{ $news->title }}</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Article Details</h3>

            <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="krishi-form">
                @csrf
                @method('put')

                @include('admin.news.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
