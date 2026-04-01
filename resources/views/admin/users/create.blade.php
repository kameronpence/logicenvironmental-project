@extends('layouts.admin')

@section('title', 'Add Admin User')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Add Admin User</h2>
    </div>
</div>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Permissions</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_manage_pages"
                               name="can_manage_pages" value="1" {{ old('can_manage_pages') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_manage_pages">
                            <strong>Manage Pages</strong>
                            <small class="d-block text-muted">Can create, edit, and delete pages</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_manage_team"
                               name="can_manage_team" value="1" {{ old('can_manage_team') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_manage_team">
                            <strong>Manage Team</strong>
                            <small class="d-block text-muted">Can add, edit, and remove team members</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_manage_users"
                               name="can_manage_users" value="1" {{ old('can_manage_users') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_manage_users">
                            <strong>Manage Users</strong>
                            <small class="d-block text-muted">Can add and manage admin users</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_view_activity"
                               name="can_view_activity" value="1" {{ old('can_view_activity') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_view_activity">
                            <strong>View Activity Log</strong>
                            <small class="d-block text-muted">Can view the activity log</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_view_proposals"
                               name="can_view_proposals" value="1" {{ old('can_view_proposals') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_view_proposals">
                            <strong>View Proposals</strong>
                            <small class="d-block text-muted">Can view submitted proposal requests</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_manage_services"
                               name="can_manage_services" value="1" {{ old('can_manage_services') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_manage_services">
                            <strong>Manage Services</strong>
                            <small class="d-block text-muted">Can manage Other Services on homepage</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="can_view_documents"
                               name="can_view_documents" value="1" {{ old('can_view_documents') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_view_documents">
                            <strong>View Client Uploads</strong>
                            <small class="d-block text-muted">Can view client document submissions</small>
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
