@extends('layouts.admin')

@section('title', 'Add News')

@section('header')
    <h2>📰 Add News Article</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Article Details</h3>

            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="krishi-form">
                @csrf

                @include('admin.news.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Publish Article</button>
                </div>
            </form>
        </div>
    </div>
@endsection
