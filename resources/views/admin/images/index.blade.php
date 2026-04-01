@extends('layouts.admin')

@section('title', 'Homepage Images')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Homepage Images</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header bg-light">
        <i class="fas fa-images me-2"></i>Manage Homepage Images
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">Upload and manage images for the homepage banner and services section.</p>

        <div class="row g-4">
            @foreach($images as $location => $data)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <strong>{{ $data['label'] }}</strong>
                    </div>
                    <div class="card-body text-center">
                        @if($data['image'] && $data['image']->image_path)
                            <img src="{{ Storage::url($data['image']->image_path) }}" alt="{{ $data['image']->alt_text ?? $data['label'] }}" class="img-fluid rounded mb-3" style="max-height: 150px; object-fit: cover;">
                            @if(!$data['image']->is_active)
                                <span class="badge bg-warning mb-2">Inactive</span>
                            @endif
                        @else
                            <div class="rounded mb-3 d-flex align-items-center justify-content-center" style="height: 150px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                            <span class="badge bg-secondary mb-2">No image</span>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.images.edit', $location) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-edit me-1"></i>
                            {{ $data['image'] && $data['image']->image_path ? 'Change Image' : 'Upload Image' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
