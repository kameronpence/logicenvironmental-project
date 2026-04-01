@extends('layouts.frontend')

@section('title', 'Our Team - Option 3 (Simple Link)')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Our Team - Option 3</h1>
        <p class="text-white-50">Simple with Link - Clean and minimal</p>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($teamMembers as $member)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ $member->photo_url }}" class="img-fluid rounded shadow" alt="{{ $member->name }}" style="height: 280px; width: 100%; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center mx-auto" style="height: 280px; width: 100%;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $member->name }}</h5>
                    @if($member->title)
                        <p class="text-muted small mb-2">{{ $member->title }}</p>
                    @endif
                    <a href="#" class="text-decoration-none small" data-bs-toggle="modal" data-bs-target="#teamModal{{ $member->id }}" style="color: #742E6F;">
                        View Bio <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Team Member Modals -->
@foreach($teamMembers as $member)
<div class="modal fade" id="teamModal{{ $member->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #742E6F;">
                <h5 class="modal-title text-white">{{ $member->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" class="rounded-circle" alt="{{ $member->name }}" style="width: 120px; height: 120px; object-fit: cover;">
                    @endif
                </div>
                @if($member->title)
                    <p class="text-center fw-bold mb-3" style="color: #742E6F;">{{ $member->title }}</p>
                @endif
                @if($member->bio)
                    <p class="mb-3">{{ $member->bio }}</p>
                @else
                    <p class="text-muted fst-italic mb-3">Bio coming soon...</p>
                @endif
                @if($member->email)
                    <p class="mb-0">
                        <a href="mailto:{{ $member->email }}" class="text-dark">
                            <i class="fas fa-envelope me-2"></i>{{ $member->email }}
                        </a>
                    </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
