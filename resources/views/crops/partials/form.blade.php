@php
    // $crop is null when creating, and the existing Crop model when editing.
    $isEditing = isset($crop);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="cropImagePreview"
             src="{{ $isEditing ? $crop->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing ? '' : 'hidden' }}">
        <div id="cropImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing ? 'hidden' : '' }}">
            🌱
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
    <label for="name">Crop Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $crop->name ?? '') }}" placeholder="e.g. BRRI Dhan 29 Rice" required>
    @error('name') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row-group">
    <div class="form-row">
        <label for="planting_date">Planting Date</label>
        <input type="date" id="planting_date" name="planting_date"
               value="{{ old('planting_date', $isEditing ? $crop->planting_date->format('Y-m-d') : '') }}" required>
        @error('planting_date') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="expected_harvest_date">Expected Harvest Date</label>
        <input type="date" id="expected_harvest_date" name="expected_harvest_date"
               value="{{ old('expected_harvest_date', $isEditing ? $crop->expected_harvest_date->format('Y-m-d') : '') }}" required>
        @error('expected_harvest_date') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row-group">
    <div class="form-row">
        <label for="land_area">Land Area</label>
        <input type="text" id="land_area" name="land_area" value="{{ old('land_area', $crop->land_area ?? '') }}" placeholder="e.g. 2 Bigha">
        @error('land_area') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="status">Crop Status</label>
        @php $selectedStatus = old('status', $crop->status ?? 'growing'); @endphp
        <select id="status" name="status" required>
            <option value="growing" {{ $selectedStatus === 'growing' ? 'selected' : '' }}>Growing</option>
            <option value="ready_for_harvest" {{ $selectedStatus === 'ready_for_harvest' ? 'selected' : '' }}>Ready for Harvest</option>
            <option value="harvested" {{ $selectedStatus === 'harvested' ? 'selected' : '' }}>Harvested</option>
        </select>
        @error('status') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4" placeholder="Any notes about this crop...">{{ old('description', $crop->description ?? '') }}</textarea>
    @error('description') <p class="field-error">{{ $message }}</p> @enderror
</div>
