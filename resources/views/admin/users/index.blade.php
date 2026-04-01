@extends('layouts.admin')

@section('title', 'Admin Users')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Admin Users</h2>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Admin User
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isSuperAdmin())
                                <span class="badge bg-danger">Super Admin</span>
                            @else
                                <span class="badge bg-secondary">Admin</span>
                            @endif
                        </td>
                        <td>
                            @if($user->isSuperAdmin())
                                <span class="text-muted">All permissions</span>
                            @else
                                @if($user->can_manage_pages)
                                    <span class="badge bg-info me-1">Pages</span>
                                @endif
                                @if($user->can_manage_team)
                                    <span class="badge bg-info me-1">Team</span>
                                @endif
                                @if($user->can_manage_users)
                                    <span class="badge bg-info me-1">Users</span>
                                @endif
                                @if($user->can_view_activity)
                                    <span class="badge bg-info me-1">Activity</span>
                                @endif
                                @if($user->can_view_proposals)
                                    <span class="badge bg-info me-1">Proposals</span>
                                @endif
                                @if($user->can_manage_services)
                                    <span class="badge bg-info me-1">Services</span>
                                @endif
                                @if($user->can_view_documents)
                                    <span class="badge bg-info me-1">Documents</span>
                                @endif
                                @if(!$user->can_manage_pages && !$user->can_manage_team && !$user->can_manage_users && !$user->can_view_activity && !$user->can_view_proposals && !$user->can_manage_services && !$user->can_view_documents)
                                    <span class="text-muted">No permissions</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$user->isSuperAdmin() && $user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No admin users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
