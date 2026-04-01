@extends('layouts.admin')

@section('title', 'Edit Client Portal - ' . $clientPortal->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Client Portal</h2>
    <a href="{{ route('admin.client-portals.show', $clientPortal) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Portal
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.client-portals.update', $clientPortal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Client Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $clientPortal->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Client Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $clientPortal->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="project_reference" class="form-label">Project Reference</label>
                    <input type="text" class="form-control @error('project_reference') is-invalid @enderror" id="project_reference" name="project_reference" value="{{ old('project_reference', $clientPortal->project_reference) }}">
                    @error('project_reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $clientPortal->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    <small class="text-muted">Inactive portals cannot be accessed by clients.</small>
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label">Internal Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $clientPortal->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.client-portals.show', $clientPortal) }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
