@extends('layouts.admin')

@section('title', 'Edit Image - ' . $label)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ $label }}</h1>
    <a href="{{ route('admin.images.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Images
    </a>
</div>

@if($location === 'banner')
<!-- Live Preview Banner -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-eye me-2"></i>Live Preview (adjusts as you move sliders)
    </div>
    <div class="card-body p-0">
        <div id="live-preview" class="position-relative overflow-hidden" style="height: {{ old('banner_height', $image?->banner_height ?? 300) }}px; background: #fff;">
            @if($image && $image->image_path)
                <img src="{{ Storage::url($image->image_path) }}" id="preview-image" style="position: absolute; transform: translate(-50%, -50%); height: {{ old('image_scale', $image?->image_scale ?? 100) }}%; width: auto; max-width: none; left: {{ old('image_position_x', $image?->image_position_x ?? 50) }}%; top: {{ old('image_position_y', $image?->image_position_y ?? 50) }}%;">
            @else
                <div id="preview-placeholder" class="w-100 h-100 d-flex align-items-center justify-content-center text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <span class="text-muted"><i class="fas fa-image fa-3x mb-2"></i><br>Upload an image to see preview</span>
                </div>
            @endif
            <div id="overlay-layer" class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(50, 50, 50, {{ (old('overlay_opacity', $image?->overlay_opacity ?? 60)) / 100 }}); pointer-events: none;"></div>
            <div class="position-absolute" style="left: 50%; top: 80%; transform: translate(-50%, -50%); pointer-events: none;">
                <span class="btn btn-lg" style="background-color: #742E6F; color: #fff;">Request Proposal</span>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.images.update', $location) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-{{ $location === 'banner' ? '8' : '8' }}">
                    @if($location === 'banner')
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="banner_height" class="form-label fw-bold">Banner Height: <span id="height-value">{{ old('banner_height', $image?->banner_height ?? 300) }}px</span></label>
                                <input type="range" class="form-range" id="banner_height" name="banner_height" min="100" max="600" value="{{ old('banner_height', $image?->banner_height ?? 300) }}">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>100px</span>
                                    <span>600px</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_scale" class="form-label fw-bold">Image Size: <span id="scale-value">{{ old('image_scale', $image?->image_scale ?? 100) }}%</span></label>
                                <input type="range" class="form-range" id="image_scale" name="image_scale" min="20" max="200" value="{{ old('image_scale', $image?->image_scale ?? 100) }}">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>20% (small)</span>
                                    <span>200% (large)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_position_x" class="form-label fw-bold">Horizontal Position: <span id="position-x-value">{{ old('image_position_x', $image?->image_position_x ?? 50) }}%</span></label>
                                <input type="range" class="form-range" id="image_position_x" name="image_position_x" min="0" max="100" value="{{ old('image_position_x', $image?->image_position_x ?? 50) }}">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>Left</span>
                                    <span>Center</span>
                                    <span>Right</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_position_y" class="form-label fw-bold">Vertical Position: <span id="position-y-value">{{ old('image_position_y', $image?->image_position_y ?? 50) }}%</span></label>
                                <input type="range" class="form-range" id="image_position_y" name="image_position_y" min="0" max="100" value="{{ old('image_position_y', $image?->image_position_y ?? 50) }}">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>Top</span>
                                    <span>Center</span>
                                    <span>Bottom</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="overlay_opacity" class="form-label fw-bold">Overlay Darkness: <span id="opacity-value">{{ old('overlay_opacity', $image?->overlay_opacity ?? 60) }}%</span></label>
                        <input type="range" class="form-range" id="overlay_opacity" name="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', $image?->overlay_opacity ?? 60) }}">
                        <div class="d-flex justify-content-between text-muted small">
                            <span>No overlay</span>
                            <span>Very dark</span>
                        </div>
                    </div>

                    <hr class="my-4">
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">{{ $image && $image->image_path ? 'Replace Image' : 'Upload Image' }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="text-muted d-block">Max 5MB. Supported formats: JPEG, PNG, GIF, WebP</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title (optional)</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $image?->title ?? '') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alt_text" class="form-label">Alt Text (optional)</label>
                                <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text" name="alt_text" value="{{ old('alt_text', $image?->alt_text ?? '') }}">
                                @error('alt_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $image?->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (display on site)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-header">Current Image</div>
                        <div class="card-body text-center">
                            @if($image && $image->image_path)
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image?->alt_text ?? $label }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center" style="height: 150px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted mt-2 mb-0">No image uploaded</p>
                            @endif
                        </div>
                        @if($image && $image->image_path)
                        <div class="card-footer bg-white">
                            <small class="text-muted d-block mb-2">To change the image, just upload a new one above.</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@if($location === 'banner')
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewContainer = document.getElementById('live-preview');
    const previewImage = document.getElementById('preview-image');
    const overlayLayer = document.getElementById('overlay-layer');

    // Height slider
    const heightSlider = document.getElementById('banner_height');
    const heightDisplay = document.getElementById('height-value');
    if (heightSlider && previewContainer) {
        heightSlider.addEventListener('input', function() {
            heightDisplay.textContent = this.value + 'px';
            previewContainer.style.height = this.value + 'px';
        });
    }

    // Scale/Zoom slider
    const scaleSlider = document.getElementById('image_scale');
    const scaleDisplay = document.getElementById('scale-value');
    if (scaleSlider && previewImage) {
        scaleSlider.addEventListener('input', function() {
            scaleDisplay.textContent = this.value + '%';
            previewImage.style.height = this.value + '%';
        });
    }

    // Position X slider
    const positionXSlider = document.getElementById('image_position_x');
    const positionXDisplay = document.getElementById('position-x-value');
    if (positionXSlider && previewImage) {
        positionXSlider.addEventListener('input', function() {
            positionXDisplay.textContent = this.value + '%';
            previewImage.style.left = this.value + '%';
        });
    }

    // Position Y slider
    const positionYSlider = document.getElementById('image_position_y');
    const positionYDisplay = document.getElementById('position-y-value');
    if (positionYSlider && previewImage) {
        positionYSlider.addEventListener('input', function() {
            positionYDisplay.textContent = this.value + '%';
            previewImage.style.top = this.value + '%';
        });
    }

    // Overlay opacity slider
    const opacitySlider = document.getElementById('overlay_opacity');
    const opacityDisplay = document.getElementById('opacity-value');
    if (opacitySlider && overlayLayer) {
        opacitySlider.addEventListener('input', function() {
            opacityDisplay.textContent = this.value + '%';
            overlayLayer.style.background = 'rgba(50, 50, 50, ' + (this.value / 100) + ')';
        });
    }

    // File upload preview
    const fileInput = document.getElementById('image');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImage) {
                        previewImage.src = e.target.result;
                    } else {
                        // Create image if placeholder was shown
                        const placeholder = document.getElementById('preview-placeholder');
                        if (placeholder) {
                            const img = document.createElement('img');
                            img.id = 'preview-image';
                            img.src = e.target.result;
                            img.style.cssText = 'position: absolute; transform: translate(-50%, -50%); height: ' + scaleSlider.value + '%; width: auto; max-width: none; left: ' + positionXSlider.value + '%; top: ' + positionYSlider.value + '%;';
                            placeholder.replaceWith(img);
                        }
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endpush
@endif
