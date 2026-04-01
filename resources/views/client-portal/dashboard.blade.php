@extends('layouts.frontend')

@section('title', 'Your Files - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 40px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 fw-bold text-white mb-1">Welcome, {{ $portal->name }}</h1>
                @if($portal->project_reference)
                    <p class="text-white-50 mb-0">Project: {{ $portal->project_reference }}</p>
                @endif
            </div>
            <div class="col-auto">
                <a href="{{ route('client-portal.logout') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Files Available for Download -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100" style="border: 1px solid #e9ecef;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-download me-2" style="color: #742E6F;"></i>Files for You
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($filesForClient->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                                <p class="text-muted mb-0">No files available for download yet.</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($filesForClient as $file)
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div class="me-3">
                                            <i class="fas fa-file me-2 text-muted"></i>
                                            <span class="fw-medium">{{ $file->original_filename }}</span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $file->human_file_size }} &bull;
                                                Added {{ $file->created_at->format('M j, Y') }}
                                            </small>
                                            @if($file->description)
                                                <br><small class="text-muted fst-italic">{{ $file->description }}</small>
                                            @endif
                                        </div>
                                        <a href="{{ route('client-portal.download', $file) }}" class="btn btn-sm" style="background: #742E6F; color: white;">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Upload Files Section -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100" style="border: 1px solid #e9ecef;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-upload me-2" style="color: #742E6F;"></i>Upload Files to Us
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client-portal.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <input type="file" class="filepond" name="files[]" multiple required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="What are you uploading?">
                            </div>

                            @if($teamMembers->isNotEmpty())
                            <div class="mb-3">
                                <label for="notify_team_member" class="form-label">Notify Team Member (Optional)</label>
                                <select class="form-select" id="notify_team_member" name="notify_team_member">
                                    <option value="">-- Select a team member to notify --</option>
                                    @foreach($teamMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}@if($member->title) ({{ $member->title }})@endif</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select a team member to receive an email notification about your upload.</small>
                            </div>
                            @endif

                            <button type="submit" class="btn w-100" style="background: #742E6F; color: white;">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Upload Files
                            </button>
                        </form>

                        @if($filesFromClient->isNotEmpty())
                            <hr>
                            <h6 class="text-muted mb-3">Your Previous Uploads</h6>
                            <div class="list-group list-group-flush">
                                @foreach($filesFromClient as $file)
                                    <div class="list-group-item px-0 py-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>{{ $file->original_filename }}</span>
                                        <small class="text-muted d-block ms-4">
                                            Uploaded {{ $file->created_at->format('M j, Y g:i A') }}
                                            @if($file->notifiedTeamMember)
                                                &bull; Notified: {{ $file->notifiedTeamMember->name }}
                                            @endif
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted small">
                <i class="fas fa-shield-alt me-1"></i>
                All files are encrypted and securely stored. Your session will expire after 2 hours of inactivity.
            </p>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<style>
    .filepond--root {
        font-family: inherit;
    }
    .filepond--panel-root {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
    .filepond--drop-label {
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    FilePond.registerPlugin(FilePondPluginFileValidateSize);

    const inputElement = document.querySelector('input.filepond');
    if (inputElement) {
        FilePond.create(inputElement, {
            storeAsFile: true,
            allowMultiple: true,
            maxFiles: 10,
            maxFileSize: '100MB',
            labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>',
            labelMaxFileSizeExceeded: 'File is too large',
            labelMaxFileSize: 'Maximum file size is {filesize}'
        });
    }
});
</script>
@endpush
