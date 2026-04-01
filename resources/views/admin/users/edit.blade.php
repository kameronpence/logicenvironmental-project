@extends('layouts.admin')

@section('title', 'Edit Admin User')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Edit Admin User: {{ $user->name }}</h2>
    </div>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password">
                        <small class="text-muted">Leave blank to keep current password</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation">
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
                    @if($user->isSuperAdmin())
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Super Admin has all permissions and cannot be modified.
                        </div>
                    @else
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_manage_pages"
                                   name="can_manage_pages" value="1" {{ old('can_manage_pages', $user->can_manage_pages) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_manage_pages">
                                <strong>Manage Pages</strong>
                                <small class="d-block text-muted">Can create, edit, and delete pages</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_manage_team"
                                   name="can_manage_team" value="1" {{ old('can_manage_team', $user->can_manage_team) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_manage_team">
                                <strong>Manage Team</strong>
                                <small class="d-block text-muted">Can add, edit, and remove team members</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_manage_users"
                                   name="can_manage_users" value="1" {{ old('can_manage_users', $user->can_manage_users) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_manage_users">
                                <strong>Manage Users</strong>
                                <small class="d-block text-muted">Can add and manage admin users</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_view_activity"
                                   name="can_view_activity" value="1" {{ old('can_view_activity', $user->can_view_activity) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_view_activity">
                                <strong>View Activity Log</strong>
                                <small class="d-block text-muted">Can view the activity log</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_view_proposals"
                                   name="can_view_proposals" value="1" {{ old('can_view_proposals', $user->can_view_proposals) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_view_proposals">
                                <strong>View Proposals</strong>
                                <small class="d-block text-muted">Can view submitted proposal requests</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_manage_services"
                                   name="can_manage_services" value="1" {{ old('can_manage_services', $user->can_manage_services) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_manage_services">
                                <strong>Manage Services</strong>
                                <small class="d-block text-muted">Can manage Other Services on homepage</small>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="can_view_documents"
                                   name="can_view_documents" value="1" {{ old('can_view_documents', $user->can_view_documents) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_view_documents">
                                <strong>View Client Uploads</strong>
                                <small class="d-block text-muted">Can view client document submissions</small>
                            </label>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
