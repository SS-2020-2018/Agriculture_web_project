@php
    $isEditing = isset($fertilizer);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="fertilizerImagePreview"
             src="{{ $isEditing && $fertilizer->crop_image ? $fertilizer->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing && $fertilizer->crop_image ? '' : 'hidden' }}">
        <div id="fertilizerImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing && $fertilizer->crop_image ? 'hidden' : '' }}">
            🧪
        </div>
    </div>
    <div class="photo-upload-controls">
        <label for="crop_image" class="btn btn-secondary">{{ $isEditing ? 'Replace Photo' : 'Choose Photo (optional)' }}</label>
        <input type="file" id="crop_image" name="crop_image" accept="image/png, image/jpeg" class="visually-hidden-input">
        <p class="field-hint">JPG or PNG, max 4MB. Optional — falls back to a generic icon if skipped.</p>
        @error('crop_image') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="crop_name">Crop Name</label>
    <input type="text" id="crop_name" name="crop_name" value="{{ old('crop_name', $fertilizer->crop_name ?? '') }}" placeholder="e.g. Rice" required>
    @error('crop_name') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="fertilizers">Recommended Fertilizers</label>
    <input type="text" id="fertilizers" name="fertilizers" value="{{ old('fertilizers', $fertilizer->fertilizers ?? '') }}" placeholder="e.g. Urea, TSP, DAP, MOP" required>
    <p class="field-hint">Separate multiple fertilizers with commas — they'll display as individual tags to farmers.</p>
    @error('fertilizers') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row-group">
    <div class="form-row">
        <label for="application_stage">Application Stage</label>
        <input type="text" id="application_stage" name="application_stage" value="{{ old('application_stage', $fertilizer->application_stage ?? '') }}" placeholder="e.g. Before planting, 30 days after" required>
        @error('application_stage') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="quantity">Quantity per Unit of Land</label>
        <input type="text" id="quantity" name="quantity" value="{{ old('quantity', $fertilizer->quantity ?? '') }}" placeholder="e.g. Urea 50kg, TSP 30kg per acre" required>
        @error('quantity') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="application_method">Application Method</label>
    <input type="text" id="application_method" name="application_method" value="{{ old('application_method', $fertilizer->application_method ?? '') }}" placeholder="e.g. Broadcast evenly and mix into topsoil" required>
    @error('application_method') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="usage_instructions">Usage Instructions</label>
    <textarea id="usage_instructions" name="usage_instructions" rows="4" placeholder="Detailed step-by-step usage guidance...">{{ old('usage_instructions', $fertilizer->usage_instructions ?? '') }}</textarea>
    @error('usage_instructions') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="additional_notes">Additional Notes / Precautions (optional)</label>
    <textarea id="additional_notes" name="additional_notes" rows="3" placeholder="Safety precautions, storage tips, etc.">{{ old('additional_notes', $fertilizer->additional_notes ?? '') }}</textarea>
    @error('additional_notes') <p class="field-error">{{ $message }}</p> @enderror
</div>
