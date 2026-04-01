@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Add Service</h2>
    </div>
</div>

<form action="{{ route('admin.services.store') }}" method="POST" id="serviceForm">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Service Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon Class</label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="iconPreview" class="fas fa-cog"></i></span>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon" value="{{ old('icon', 'fa-cog') }}" required
                                   placeholder="e.g., fa-leaf, fa-flask, fa-hard-hat">
                        </div>
                        <small class="text-muted">
                            Enter a Font Awesome icon class (without 'fas').
                            <a href="https://fontawesome.com/v5/search?o=r&m=free&s=solid" target="_blank">Browse icons</a>
                        </small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description" name="short_description" rows="3" required
                                  placeholder="Brief description shown on the card">{{ old('short_description') }}</textarea>
                        <small class="text-muted">This appears on the service card on the home page</small>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="full_description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('full_description') is-invalid @enderror"
                                  id="full_description" name="full_description" rows="6"
                                  placeholder="Detailed description shown in the modal popup">{{ old('full_description') }}</textarea>
                        <small class="text-muted">This appears when users click "More" to view details</small>
                        @error('full_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Settings</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active"
                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (visible on website)
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="sort_order"
                               name="sort_order" value="{{ old('sort_order', 0) }}">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Preview</h6>
                </div>
                <div class="card-body">
                    <div class="card h-100 text-center p-3" id="cardPreview">
                        <div class="card-body">
                            <i id="previewIcon" class="fas fa-cog fa-3x text-primary mb-3"></i>
                            <h5 id="previewTitle" class="card-title">Service Title</h5>
                            <p id="previewDesc" class="card-text text-muted small">Short description will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const iconInput = document.getElementById('icon');
    const shortDescInput = document.getElementById('short_description');

    const previewIcon = document.getElementById('previewIcon');
    const iconPreviewSmall = document.getElementById('iconPreview');
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');

    titleInput.addEventListener('input', function() {
        previewTitle.textContent = this.value || 'Service Title';
    });

    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        previewIcon.className = 'fas ' + iconClass + ' fa-3x text-primary mb-3';
        iconPreviewSmall.className = 'fas ' + iconClass;
    });

    shortDescInput.addEventListener('input', function() {
        previewDesc.textContent = this.value || 'Short description will appear here';
    });
});
</script>
@endpush
