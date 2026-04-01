@extends('layouts.admin')

@section('title', 'Edit Team Member')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<style>
    .cropper-modal-body {
        max-height: 60vh;
    }
    #cropperImage {
        max-width: 100%;
        display: block;
    }
    .cropper-container {
        max-height: 400px;
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Edit Team Member: {{ $member->name }}</h2>
    </div>
</div>

<form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data" id="teamForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $member->title) }}" placeholder="e.g., Environmental Consultant">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $member->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror"
                                  id="bio" name="bio" rows="4">{{ old('bio', $member->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Photo</h6>
                </div>
                <div class="card-body">
                    @if($member->photo)
                        <div class="mb-3 text-center" id="currentPhoto">
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                 class="img-fluid rounded" style="max-height: 150px;">
                            <p class="text-muted small mt-2">Current photo</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="photo" class="form-label">{{ $member->photo ? 'Replace Photo' : 'Upload Photo' }}</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                               id="photo" name="photo" accept="image/*">
                        <small class="text-muted">Select an image to crop and resize</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="croppedPreview" class="text-center" style="display: none;">
                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        <p class="text-success small mt-2"><i class="fas fa-check"></i> Photo cropped and ready</p>
                    </div>

                    <input type="hidden" name="cropped_photo" id="croppedPhotoData">
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Settings</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active"
                               name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (visible on website)
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="sort_order"
                               name="sort_order" value="{{ old('sort_order', $member->sort_order) }}">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>

<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body cropper-modal-body">
                <p class="text-muted small mb-3">Drag to position, scroll to zoom. The photo will be cropped to a 3:4 portrait ratio.</p>
                <div class="img-container">
                    <img id="cropperImage" src="" alt="Crop preview">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropButton">
                    <i class="fas fa-crop"></i> Crop & Use Photo
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const cropperImage = document.getElementById('cropperImage');
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
    const cropButton = document.getElementById('cropButton');
    const croppedPreview = document.getElementById('croppedPreview');
    const croppedPhotoData = document.getElementById('croppedPhotoData');
    const currentPhoto = document.getElementById('currentPhoto');
    let cropper = null;

    photoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];

            // Validate file type
            if (!file.type.match(/image\/(jpeg|jpg|png|gif|webp)/)) {
                alert('Please select a valid image file (JPG, PNG, GIF, or WebP)');
                photoInput.value = '';
                return;
            }

            // Validate file size (5MB max for cropping)
            if (file.size > 5 * 1024 * 1024) {
                alert('Image is too large. Please select an image under 5MB.');
                photoInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                cropperModal.show();
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(cropperImage, {
            aspectRatio: 3 / 4,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    });

    document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Reset file input if modal is closed without cropping
        if (!croppedPhotoData.value) {
            photoInput.value = '';
        }
    });

    cropButton.addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 533, // 3:4 ratio
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.9);
            croppedPhotoData.value = croppedDataUrl;

            // Show preview
            croppedPreview.querySelector('img').src = croppedDataUrl;
            croppedPreview.style.display = 'block';
            if (currentPhoto) {
                currentPhoto.style.display = 'none';
            }

            cropperModal.hide();
        }
    });
});
</script>
@endpush
