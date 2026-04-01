@extends('layouts.admin')

@section('title', 'Client Portal - ' . $clientPortal->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $clientPortal->name }}</h2>
        <p class="text-muted mb-0">{{ $clientPortal->email }}</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.client-portals.send-link', $clientPortal) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Send Access Link
            </button>
        </form>
        <a href="{{ route('admin.client-portals.edit', $clientPortal) }}" class="btn btn-outline-secondary">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.client-portals.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-2">Project Reference</h6>
                <p class="mb-0 fw-bold">{{ $clientPortal->project_reference ?? 'Not set' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-2">Last Accessed</h6>
                <p class="mb-0 fw-bold">
                    @if($clientPortal->last_accessed_at)
                        {{ $clientPortal->last_accessed_at->format('M j, Y g:i A') }}
                    @else
                        Never
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-2">Status</h6>
                <p class="mb-0">
                    @if($clientPortal->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@if($clientPortal->notes)
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Internal Notes</h5>
    </div>
    <div class="card-body">
        <p class="mb-0">{{ $clientPortal->notes }}</p>
    </div>
</div>
@endif

<!-- Files For Client (Admin Uploads) -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-file-download me-2"></i>Files for Client to Download</h5>
    </div>
    <div class="card-body">
        @if($clientPortal->filesForClient->isEmpty())
            <p class="text-muted text-center py-3 mb-0">No files uploaded for this client yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Size</th>
                            <th>Uploaded By</th>
                            <th>Uploaded</th>
                            <th>Downloaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientPortal->filesForClient as $file)
                        <tr>
                            <td>
                                <i class="fas fa-file me-2 text-muted"></i>
                                {{ $file->original_filename }}
                                @if($file->description)
                                    <br><small class="text-muted">{{ $file->description }}</small>
                                @endif
                            </td>
                            <td>{{ $file->human_file_size }}</td>
                            <td>{{ $file->uploader->name ?? 'Unknown' }}</td>
                            <td>{{ $file->created_at->format('M j, Y') }}</td>
                            <td>
                                @if($file->downloaded_at)
                                    <span class="badge bg-success">{{ $file->downloaded_at->format('M j, Y') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Not yet</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.client-portals.download', [$clientPortal, $file]) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('admin.client-portals.delete-file', [$clientPortal, $file]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Files From Client (Client Uploads) -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Files Uploaded by Client</h5>
    </div>
    <div class="card-body">
        @if($clientPortal->filesFromClient->isEmpty())
            <p class="text-muted text-center py-3 mb-0">No files uploaded by the client yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientPortal->filesFromClient as $file)
                        <tr>
                            <td>
                                <i class="fas fa-file me-2 text-muted"></i>
                                {{ $file->original_filename }}
                                @if($file->description)
                                    <br><small class="text-muted">{{ $file->description }}</small>
                                @endif
                            </td>
                            <td>{{ $file->human_file_size }}</td>
                            <td>{{ $file->created_at->format('M j, Y g:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.client-portals.download', [$clientPortal, $file]) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('admin.client-portals.delete-file', [$clientPortal, $file]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Upload Files for Client -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Files for Client</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.client-portals.upload', $clientPortal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <input type="file" class="filepond" name="files[]" multiple required>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Brief description of the files">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Upload Files
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Danger Zone -->
<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.client-portals.destroy', $clientPortal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client portal? All files will be permanently deleted.')">
            @csrf
            @method('DELETE')
            <p class="text-muted mb-3">Deleting this portal will permanently remove all files and cannot be undone.</p>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>Delete Client Portal
            </button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputElement = document.querySelector('input.filepond');
    if (inputElement) {
        FilePond.create(inputElement, {
            storeAsFile: true,
            allowMultiple: true,
            maxFiles: 10,
            labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>'
        });
    }
});
</script>
@endpush
