@extends('layouts.admin')

@section('title', 'Add Tip')

@section('header')
    <h2>💡 Add Farming Tip</h2>
@endsection

@section('content')
    <div class="crop-form-page">
        <div class="form-card">
            <h3 class="form-card-title">Tip Details</h3>

            <form method="POST" action="{{ route('admin.tips.store') }}" enctype="multipart/form-data" class="krishi-form">
                @csrf

                @include('admin.tips.partials.form')

                <div class="form-actions">
                    <a href="{{ route('admin.tips.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Publish Tip</button>
                </div>
            </form>
        </div>
    </div>
@endsection
