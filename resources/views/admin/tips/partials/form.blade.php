@php
    $isEditing = isset($tip);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="tipImagePreview"
             src="{{ $isEditing ? $tip->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing ? '' : 'hidden' }}">
        <div id="tipImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing ? 'hidden' : '' }}">
            💡
        </div>
    </div>
    <div class="photo-upload-controls">
        <label for="image" class="btn btn-secondary">{{ $isEditing ? 'Replace Photo' : 'Choose Photo' }}</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="visually-hidden-input">
        <p class="field-hint">
            JPG or PNG, max 4MB.
            @if($isEditing) Leave empty to keep the current photo. @endif
        </p>
        @error('image') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="title">Tip Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $tip->title ?? '') }}" placeholder="e.g. Best time to water rice paddies" required>
    @error('title') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="6" placeholder="Write the full tip here...">{{ old('description', $tip->description ?? '') }}</textarea>
    @error('description') <p class="field-error">{{ $message }}</p> @enderror
</div>
