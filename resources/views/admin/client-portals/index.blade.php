@extends('layouts.admin')

@section('title', 'Client Portals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Client Portals</h2>
    <a href="{{ route('admin.client-portals.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>New Client Portal
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($portals->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No client portals yet.</p>
                <a href="{{ route('admin.client-portals.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Create First Portal
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Project Reference</th>
                            <th>Files For Client</th>
                            <th>Files From Client</th>
                            <th>Last Accessed</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($portals as $portal)
                        <tr>
                            <td>
                                <strong>{{ $portal->name }}</strong><br>
                                <small class="text-muted">{{ $portal->email }}</small>
                            </td>
                            <td>{{ $portal->project_reference ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $portal->files_for_client_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $portal->files_from_client_count }}</span>
                            </td>
                            <td>
                                @if($portal->last_accessed_at)
                                    {{ $portal->last_accessed_at->diffForHumans() }}
                                @else
                                    <span class="text-muted">Never</span>
                                @endif
                            </td>
                            <td>
                                @if($portal->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.client-portals.show', $portal) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.client-portals.edit', $portal) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $portals->links() }}
        @endif
    </div>
</div>
@endsection
