@extends('layouts.frontend')

@section('title', config('app.name') . ' - Environmental Consulting')

@section('content')
<!-- Hero Slider -->
<section id="heroSlider" class="position-relative">
    <div class="slider-overlay" style="background: rgba(50, 50, 50, {{ ($siteImages['banner']->overlay_opacity ?? 60) / 100 }});"></div>
    @if($siteImages['banner'] && $siteImages['banner']->image_path)
        <img src="{{ Storage::url($siteImages['banner']->image_path) }}" alt="{{ $siteImages['banner']->alt_text ?? 'Logic Environmental' }}" class="hero-image">
    @else
        <div class="hero-placeholder d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
            <i class="fas fa-image fa-5x text-muted" style="opacity: 0.3;"></i>
        </div>
    @endif
    <div class="carousel-caption d-none d-sm-block">
        <a href="{{ route('proposal') }}" class="btn btn-purple">Request Proposal</a>
    </div>
</section>
<div class="d-sm-none text-center py-2 bg-white">
    <a href="{{ route('proposal') }}" class="btn btn-purple">Request Proposal</a>
</div>

<!-- Why Choose Us Section -->
<section class="why-choose-section">
    <div class="container">
        <div class="row align-items-center justify-content-center py-2">
            <div class="col-12 col-lg-5 text-center">
                <h5 class="text-white fw-bold why-choose-title">Get to Know Logic Environmental</h5>
                <div class="d-flex flex-wrap flex-lg-nowrap justify-content-center why-choose-buttons">
                    <a href="#services" class="btn btn-light d-inline-flex align-items-center">
                        <i class="fas fa-leaf me-2"></i>Our Services
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-light d-inline-flex align-items-center">
                        <i class="fas fa-users me-2"></i>Meet Our Team
                    </a>
                    <a href="{{ route('page.show', 'company-history') }}" class="btn btn-outline-light d-inline-flex align-items-center">
                        <i class="fas fa-history me-2"></i>Our History
                    </a>
                </div>
            </div>
            @if($achievements->count() > 0)
            <div class="col-lg-7">
                <div class="row g-3">
                    @php
                        $colClass = $achievements->count() > 4 ? 'col-md-4 col-6' : 'col-6';
                    @endphp
                    @foreach($achievements as $achievement)
                    <div class="{{ $colClass }}">
                        <div class="why-choose-item d-flex align-items-center">
                            <div class="why-choose-icon-wrapper me-3">
                                <i class="fas {{ $achievement->icon }}"></i>
                            </div>
                            <div>
                                <h6 class="text-white fw-bold mb-0">{{ $achievement->title }}</h6>
                                @if($achievement->subtitle)
                                <small class="text-white-50">{{ $achievement->subtitle }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-success">Environmental Site Assessments</h2>
            <p class="lead text-muted">Our core services for property transactions and due diligence</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row g-4 justify-content-center">
                    @foreach($services as $service)
                    <div class="col-md-6">
                        <div class="card h-100 service-card" style="border: 1px solid #e9ecef;">
                            <div class="card-body p-4 text-center">
                                <i class="fas {{ $service->icon }} fa-2x text-success mb-3"></i>
                                <h5 class="card-title fw-bold">{{ $service->title }}</h5>
                                <p class="card-text text-muted small">{{ $service->short_description }}</p>
                                @if($service->full_description)
                                <a href="#" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $service->id }}">More</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                @foreach(['services_1', 'services_2', 'services_3', 'services_4'] as $index => $imageKey)
                <div class="rounded-4 {{ $index < 3 ? 'mb-4' : '' }} overflow-hidden" style="height: 200px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); border: 3px solid #dee2e6;">
                    @if($siteImages[$imageKey] && $siteImages[$imageKey]->image_path)
                        <img src="{{ Storage::url($siteImages[$imageKey]->image_path) }}" alt="{{ $siteImages[$imageKey]->alt_text ?? 'Service Image' }}" class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Mission Statement -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-auto text-center mb-4 mb-md-0">
                <div class="mission-icon-wrapper">
                    <i class="fas fa-bullseye"></i>
                </div>
            </div>
            <div class="col-lg-8">
                <h3 class="mb-3">Our Mission</h3>
                <p class="lead mb-0 fst-italic" style="color: #555;">
                    LOGIC's Mission is to deliver our clients the highest caliber of environmental services, with an emphasis upon clarity, common sense and a genuine commitment to our clients' best interests. We are committed to treating our employees and other team members with respect and to empowering them to reach their full potential at work and in all aspects of their lives.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Service Modals -->
@foreach($services as $service)
@if($service->full_description)
<div class="modal fade" id="serviceModal{{ $service->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white"><i class="fas {{ $service->icon }} me-2"></i>{{ $service->title }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {!! nl2br(e($service->full_description)) !!}
            </div>
            <div class="modal-footer">
                <a href="{{ route('proposal') }}" class="btn btn-success">Request Proposal</a>
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection

@push('styles')
<style>
    #heroSlider {
        position: relative;
        overflow: hidden;
        background: #fff;
        height: 150px;
    }
    @media (min-width: 576px) {
        #heroSlider {
            height: {{ $siteImages['banner']->banner_height ?? 300 }}px;
        }
    }
    #heroSlider .hero-image {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        height: auto;
        width: 100%;
        z-index: 0;
    }
    @media (min-width: 576px) {
        #heroSlider .hero-image {
            height: {{ $siteImages['banner']->image_scale ?? 100 }}%;
            width: auto;
            left: {{ $siteImages['banner']->image_position_x ?? 50 }}%;
            top: {{ $siteImages['banner']->image_position_y ?? 50 }}%;
        }
    }
    #heroSlider .hero-placeholder {
        height: 100%;
        width: 100%;
    }
    #heroSlider .slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }
    #heroSlider .carousel-caption {
        position: absolute;
        left: 50%;
        bottom: 20px;
        transform: translateX(-50%);
        z-index: 2;
        text-align: center;
        padding: 10px;
    }
    #heroSlider .carousel-caption .btn {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
    #heroSlider .carousel-caption h1 {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    #heroSlider .carousel-caption .lead {
        font-size: 1rem;
        margin-bottom: 1rem;
    }
    .btn-purple {
        background-color: #742E6F;
        border-color: #742E6F;
        color: #fff;
    }
    .btn-purple:hover {
        background-color: #5a2357;
        border-color: #5a2357;
        color: #fff;
    }
@media (min-width: 576px) {
        #heroSlider .carousel-caption h1 {
            font-size: 2rem;
        }
        #heroSlider .carousel-caption .lead {
            font-size: 1.1rem;
        }
        #heroSlider .carousel-caption .btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
        }
    }
    @media (min-width: 768px) {
        #heroSlider .carousel-caption h1 {
            font-size: 2.5rem;
        }
        #heroSlider .carousel-caption .lead {
            font-size: 1.15rem;
        }
    }
    @media (min-width: 992px) {
        #heroSlider .carousel-caption h1 {
            font-size: 2.75rem;
        }
        #heroSlider .carousel-caption .lead {
            font-size: 1.5rem;
        }
    }
    /* Why Choose Us Section */
    .why-choose-section {
        background: linear-gradient(135deg, #742E6F 0%, #5a2357 100%);
        padding: 1.5rem 0;
        text-align: center;
    }
    .why-choose-section .col-12 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .why-choose-section .btn {
        font-weight: 600;
    }
    .why-choose-section .btn-light {
        color: #742E6F;
    }
    .why-choose-title {
        margin-bottom: 20px;
        font-size: 1.2rem;
        text-align: center;
    }
    .why-choose-buttons {
        gap: 10px;
        display: flex;
        justify-content: center;
    }
    .why-choose-buttons .btn {
        white-space: nowrap;
        font-size: 0.8rem;
        padding: 0.375rem 0.6rem;
    }
    @media (min-width: 768px) {
        .why-choose-section {
            padding: 2rem 0;
        }
        .why-choose-title {
            margin-bottom: 30px;
            font-size: 1.5rem;
            white-space: nowrap;
        }
        .why-choose-buttons {
            gap: 30px;
        }
        .why-choose-buttons .btn {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
    }
    .why-choose-item {
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
    }
    .why-choose-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 6px;
        flex-shrink: 0;
    }
    .why-choose-icon-wrapper i {
        font-size: 1rem;
        color: white;
    }
    .why-choose-item h6 {
        font-size: 0.85rem;
    }
    .why-choose-item small {
        font-size: 0.75rem;
    }
    /* Mission Statement */
    .mission-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #742E6F 0%, #5a2357 100%);
        border-radius: 50%;
    }
    .mission-icon-wrapper i {
        font-size: 3.5rem;
        color: white;
    }
    /* Center modals vertically */
    .modal-dialog {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }
    @media (min-width: 576px) {
        .modal-dialog {
            min-height: calc(100% - 3.5rem);
        }
    }
</style>
@endpush

