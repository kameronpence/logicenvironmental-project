@extends('layouts.admin')

@section('title', 'View Proposal')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Proposal from {{ $proposal->name }}</h2>
        <p class="text-muted">Submitted {{ $proposal->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.proposals.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Proposals
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Person Requesting Proposal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Name</label>
                        <p class="mb-0"><strong>{{ $proposal->name }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Email</label>
                        <p class="mb-0"><a href="mailto:{{ $proposal->email }}">{{ $proposal->email }}</a></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Company</label>
                        <p class="mb-0">{{ $proposal->company ?: '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Branch</label>
                        <p class="mb-0">{{ $proposal->branch ?: '-' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small">Address</label>
                        <p class="mb-0">
                            {{ $proposal->street_address }}<br>
                            {{ $proposal->city }}, {{ $proposal->state }} {{ $proposal->zip_code }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-building me-2"></i>Property Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-muted small">Property Address/Tax Parcel</label>
                        <p class="mb-0"><strong>{{ $proposal->property_address }}</strong></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">County</label>
                        <p class="mb-0">{{ $proposal->county }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small">Property Size</label>
                        <p class="mb-0">{{ $proposal->property_size }}</p>
                    </div>
                    @if($proposal->owner_name)
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Owner Name</label>
                        <p class="mb-0">{{ $proposal->owner_name }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Owner Phone</label>
                        <p class="mb-0">{{ $proposal->owner_phone ?: '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Owner Email</label>
                        <p class="mb-0">{{ $proposal->owner_email ?: '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Proposal Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Investigation Type</label>
                        <p class="mb-0"><strong>{{ $proposal->investigation_type }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Report Deadline</label>
                        <p class="mb-0">{{ $proposal->report_deadline }}</p>
                    </div>
                    @if($proposal->verbal_deadline)
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Verbal Report Deadline</label>
                        <p class="mb-0">{{ $proposal->verbal_deadline }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Hardcopies Needed</label>
                        <p class="mb-0">{{ $proposal->hardcopies_needed }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label text-muted small">Report Addressees</label>
                        <p class="mb-0">{!! nl2br(e($proposal->report_addressees)) !!}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Number of Structures</label>
                        <p class="mb-0">{{ $proposal->num_structures }}</p>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-muted small">Structure Age</label>
                        <p class="mb-0">{{ $proposal->structure_age }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Survey/Site Drawing Available</label>
                        <p class="mb-0">{{ $proposal->survey_available }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Prior Environmental Reports</label>
                        <p class="mb-0">{{ $proposal->prior_reports }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small">Special Access Problems</label>
                        <p class="mb-0">{{ $proposal->access_problems }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($proposal->attachments && count($proposal->attachments) > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>Attachments ({{ count($proposal->attachments) }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($proposal->attachments as $attachment)
                    @php
                        $extension = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
                        $icon = match($extension) {
                            'pdf' => 'fa-file-pdf text-danger',
                            'doc', 'docx' => 'fa-file-word text-primary',
                            'xls', 'xlsx' => 'fa-file-excel text-success',
                            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'fa-file-image text-info',
                            'zip', 'rar', '7z' => 'fa-file-archive text-warning',
                            default => 'fa-file text-secondary',
                        };
                        $filePath = storage_path('app/public/' . $attachment['path']);
                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                        $fileSizeFormatted = $fileSize > 0 ? ($fileSize > 1048576 ? round($fileSize / 1048576, 1) . ' MB' : round($fileSize / 1024, 1) . ' KB') : 'Unknown';
                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas {{ $icon }} fa-lg me-3"></i>
                            <div>
                                <div class="fw-medium">{{ $attachment['name'] }}</div>
                                <small class="text-muted">{{ strtoupper($extension) }} - {{ $fileSizeFormatted }}</small>
                            </div>
                        </div>
                        <div class="btn-group">
                            @if($isImage)
                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                            <a href="{{ asset('storage/' . $attachment['path']) }}" download="{{ $attachment['name'] }}" class="btn btn-sm btn-outline-primary" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Status & Notes</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.proposals.update', $proposal) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="new" {{ $proposal->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="reviewed" {{ $proposal->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="contacted" {{ $proposal->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="completed" {{ $proposal->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Internal Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4">{{ $proposal->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

        <div class="d-grid gap-2">
            <a href="mailto:{{ $proposal->email }}" class="btn btn-outline-primary">
                <i class="fas fa-envelope"></i> Send Email
            </a>
        </div>
    </div>
</div>
@endsection
