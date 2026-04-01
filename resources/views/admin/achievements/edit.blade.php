@extends('layouts.admin')

@section('title', 'Edit Achievement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Achievement</h1>
    <a href="{{ route('admin.achievements.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Achievements
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $achievement->title) }}" required>
                <small class="text-muted">e.g., "Since 1997", "20,000+ Reports"</small>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle</label>
                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $achievement->subtitle) }}">
                <small class="text-muted">e.g., "Trusted experience", "Delivered to clients"</small>
                @error('subtitle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icon Class <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i id="icon-preview" class="fas {{ $achievement->icon }}"></i></span>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $achievement->icon) }}" required>
                </div>
                <small class="text-muted">Font Awesome icon class (e.g., fa-calendar-check, fa-file-alt)</small>
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $achievement->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active (display on homepage)
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Achievement
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('icon').addEventListener('input', function() {
    const preview = document.getElementById('icon-preview');
    preview.className = 'fas ' + this.value;
});
</script>
@endpush
