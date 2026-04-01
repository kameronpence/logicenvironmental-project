@extends('layouts.frontend')

@section('title', 'Our Team - Option 5 (Circular Photos)')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Our Team - Option 5</h1>
        <p class="text-white-50">Circular Photos - Modern and clean</p>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($teamMembers as $member)
            <div class="col-md-6 col-lg-3 mb-5">
                <div class="text-center team-card-circular" data-bs-toggle="modal" data-bs-target="#teamModal{{ $member->id }}" style="cursor: pointer;">
                    <div class="photo-wrapper mx-auto mb-3">
                        @if($member->photo)
                            <img src="{{ $member->photo_url }}" class="rounded-circle" alt="{{ $member->name }}" style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 180px; height: 180px; border: 4px solid #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                                <i class="fas fa-user fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $member->name }}</h5>
                    @if($member->title)
                        <p class="mb-0 small" style="color: #742E6F;">{{ $member->title }}</p>
                    @endif
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
.team-card-circular .photo-wrapper img,
.team-card-circular .photo-wrapper > div {
    transition: transform 0.3s, box-shadow 0.3s;
}
.team-card-circular:hover .photo-wrapper img,
.team-card-circular:hover .photo-wrapper > div {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(116, 46, 111, 0.2) !important;
}
</style>
@endpush
