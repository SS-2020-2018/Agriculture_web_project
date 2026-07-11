@php
    $isEditing = isset($price);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="priceImagePreview"
             src="{{ $isEditing && $price->crop_image ? $price->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing && $price->crop_image ? '' : 'hidden' }}">
        <div id="priceImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing && $price->crop_image ? 'hidden' : '' }}">
            🌾
        </div>
    </div>
    <div class="photo-upload-controls">
        <label for="crop_image" class="btn btn-secondary">{{ $isEditing ? 'Replace Photo' : 'Choose Photo (optional)' }}</label>
        <input type="file" id="crop_image" name="crop_image" accept="image/png, image/jpeg" class="visually-hidden-input">
        <p class="field-hint">
            JPG or PNG, max 4MB. Optional — falls back to a generic crop icon if skipped.
        </p>
        @error('crop_image') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row-group">
    <div class="form-row">
        <label for="crop_name">Crop Name</label>
        <input type="text" id="crop_name" name="crop_name" value="{{ old('crop_name', $price->crop_name ?? '') }}" placeholder="e.g. Rice" required>
        @error('crop_name') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="market_name">Market Name</label>
        <input type="text" id="market_name" name="market_name" value="{{ old('market_name', $price->market_name ?? '') }}" placeholder="e.g. Khulna Krishi Market" required>
        @error('market_name') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row-group">
    <div class="form-row">
        <label for="price_per_unit">Price</label>
        <input type="number" id="price_per_unit" name="price_per_unit" step="0.01" min="0"
               value="{{ old('price_per_unit', $price->price_per_unit ?? '') }}" placeholder="e.g. 45.00" required>
        @error('price_per_unit') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="unit">Per Unit</label>
        <input type="text" id="unit" name="unit" list="unitSuggestions" value="{{ old('unit', $price->unit ?? 'kg') }}" required>
        <datalist id="unitSuggestions">
            <option value="kg">
            <option value="sack">
            <option value="ton">
            <option value="maund">
        </datalist>
        @error('unit') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="remarks">Remarks (optional)</label>
    <textarea id="remarks" name="remarks" rows="3" placeholder="Any additional notes...">{{ old('remarks', $price->remarks ?? '') }}</textarea>
    @error('remarks') <p class="field-error">{{ $message }}</p> @enderror
</div>
