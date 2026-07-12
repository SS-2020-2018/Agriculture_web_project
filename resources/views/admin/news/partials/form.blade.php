@php
    $isEditing = isset($news);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="newsImagePreview"
             src="{{ $isEditing ? $news->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing ? '' : 'hidden' }}">
        <div id="newsImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing ? 'hidden' : '' }}">
            📰
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
    <label for="title">News Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $news->title ?? '') }}" placeholder="e.g. Heavy Rainfall Expected This Week" required>
    @error('title') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="category">Category</label>
    @php $selectedCategory = old('category', $news->category ?? 'new_farming_method'); @endphp
    <select id="category" name="category" required>
        <option value="rain_alert" {{ $selectedCategory === 'rain_alert' ? 'selected' : '' }}>🌧️ Rain Alert</option>
        <option value="government_notice" {{ $selectedCategory === 'government_notice' ? 'selected' : '' }}>🏛️ Government Notice</option>
        <option value="disease_pest_alert" {{ $selectedCategory === 'disease_pest_alert' ? 'selected' : '' }}>🐛 Disease & Pest Alert</option>
        <option value="new_farming_method" {{ $selectedCategory === 'new_farming_method' ? 'selected' : '' }}>🌱 New Farming Method</option>
    </select>
    @error('category') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="description">Full Article</label>
    <textarea id="description" name="description" rows="8" placeholder="Write the complete news content here...">{{ old('description', $news->description ?? '') }}</textarea>
    @error('description') <p class="field-error">{{ $message }}</p> @enderror
</div>
