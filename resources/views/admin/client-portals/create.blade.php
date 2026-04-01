@extends('layouts.admin')

@section('title', 'Create Client Portal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create Client Portal</h2>
    <a href="{{ route('admin.client-portals.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to List
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.client-portals.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Client Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Client Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Magic links will be sent to this email address.</small>
                </div>

                <div class="col-md-6">
                    <label for="project_reference" class="form-label">Project Reference</label>
                    <input type="text" class="form-control @error('project_reference') is-invalid @enderror" id="project_reference" name="project_reference" value="{{ old('project_reference') }}">
                    @error('project_reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Optional reference number or project name.</small>
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label">Internal Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">These notes are only visible to admins.</small>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="send_link" name="send_link" value="1" checked>
                        <label class="form-check-label" for="send_link">
                            Send access link to client immediately
                        </label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.client-portals.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Create Portal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
