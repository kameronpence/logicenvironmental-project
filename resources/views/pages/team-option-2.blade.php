@extends('layouts.frontend')

@section('title', 'Our Team - Option 2 (Hover Reveal)')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Our Team - Option 2</h1>
        <p class="text-white-50">Hover Reveal - Details appear on hover</p>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($teamMembers as $member)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="team-card-hover position-relative overflow-hidden rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#teamModal{{ $member->id }}" style="cursor: pointer;">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" class="w-100" alt="{{ $member->name }}" style="height: 350px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 350px;">
                            <i class="fas fa-user fa-4x text-muted"></i>
                        </div>
                    @endif
                    <div class="team-overlay position-absolute bottom-0 start-0 end-0 p-3 text-white">
                        <h5 class="mb-0">{{ $member->name }}</h5>
                        <p class="team-title mb-0 small">{{ $member->title }}</p>
                        <span class="team-view-bio small">View Bio <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
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

@push('styles')
<style>
.team-card-hover {
    transition: transform 0.3s;
}
.team-card-hover:hover {
    transform: scale(1.02);
}
.team-overlay {
    background: linear-gradient(transparent, rgba(116, 46, 111, 0.95));
    padding-top: 60px !important;
}
.team-title {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s;
}
.team-view-bio {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s 0.1s;
    display: inline-block;
    margin-top: 8px;
}
.team-card-hover:hover .team-title,
.team-card-hover:hover .team-view-bio {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endpush
