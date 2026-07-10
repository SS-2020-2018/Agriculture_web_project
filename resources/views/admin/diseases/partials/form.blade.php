@php
    $isEditing = isset($disease);
@endphp

<div class="crop-image-upload-row">
    <div class="crop-image-preview-wrap">
        <img id="diseaseImagePreview"
             src="{{ $isEditing ? $disease->image_url : '' }}"
             alt="Preview"
             class="crop-image-preview-img {{ $isEditing ? '' : 'hidden' }}">
        <div id="diseaseImagePlaceholder" class="crop-image-preview-placeholder {{ $isEditing ? 'hidden' : '' }}">
            🚨
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

<div class="form-row-group">
    <div class="form-row">
        <label for="name">Disease Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $disease->name ?? '') }}" placeholder="e.g. Rice Blast" required>
        @error('name') <p class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label for="affected_crop">Affected Crop</label>
        <input type="text" id="affected_crop" name="affected_crop" value="{{ old('affected_crop', $disease->affected_crop ?? '') }}" placeholder="e.g. Rice" required>
        @error('affected_crop') <p class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="form-row">
    <label for="warning_level">Warning Level</label>
    @php $selectedLevel = old('warning_level', $disease->warning_level ?? 'medium'); @endphp
    <select id="warning_level" name="warning_level" required>
        <option value="low" {{ $selectedLevel === 'low' ? 'selected' : '' }}>🟢 Low</option>
        <option value="medium" {{ $selectedLevel === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
        <option value="high" {{ $selectedLevel === 'high' ? 'selected' : '' }}>🟠 High</option>
        <option value="critical" {{ $selectedLevel === 'critical' ? 'selected' : '' }}>🔴 Critical</option>
    </select>
    @error('warning_level') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="symptoms">Symptoms</label>
    <textarea id="symptoms" name="symptoms" rows="3" placeholder="Describe how to recognize this disease...">{{ old('symptoms', $disease->symptoms ?? '') }}</textarea>
    @error('symptoms') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="preventive_measures">Preventive Measures</label>
    <textarea id="preventive_measures" name="preventive_measures" rows="3" placeholder="How can farmers prevent it?">{{ old('preventive_measures', $disease->preventive_measures ?? '') }}</textarea>
    @error('preventive_measures') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="suggested_treatments">Suggested Treatments</label>
    <textarea id="suggested_treatments" name="suggested_treatments" rows="3" placeholder="How can farmers treat it?">{{ old('suggested_treatments', $disease->suggested_treatments ?? '') }}</textarea>
    @error('suggested_treatments') <p class="field-error">{{ $message }}</p> @enderror
</div>

<div class="form-row">
    <label for="additional_recommendations">Additional Recommendations (optional)</label>
    <textarea id="additional_recommendations" name="additional_recommendations" rows="3">{{ old('additional_recommendations', $disease->additional_recommendations ?? '') }}</textarea>
    @error('additional_recommendations') <p class="field-error">{{ $message }}</p> @enderror
</div>
