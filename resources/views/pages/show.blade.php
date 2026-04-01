@extends('layouts.frontend')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="{{ $page->slug === 'locations' ? 'h2' : 'display-5' }} fw-bold text-white">{{ $page->title }}</h1>
    </div>
</section>

@if($page->slug === 'company-history')
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
@endif

@if($page->hasSections())
    <!-- Sections -->
    @foreach($page->sections as $sectionIndex => $section)
        @php
            $bgClass = '';
            $bgStyle = '';
            $textClass = '';

            switch($section['bg_type'] ?? 'none') {
                case 'light':
                    $bgClass = 'bg-light';
                    break;
                case 'dark':
                    $bgClass = 'bg-dark';
                    $textClass = 'text-white';
                    break;
                case 'primary':
                    $bgStyle = 'background-color: #742E6F;';
                    $textClass = 'text-white';
                    break;
                case 'color':
                    $bgStyle = 'background-color: ' . ($section['bg_color'] ?? '#ffffff') . ';';
                    // Determine if text should be light or dark based on background
                    $hex = ltrim($section['bg_color'] ?? '#ffffff', '#');
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
                    $textClass = $luminance < 0.5 ? 'text-white' : '';
                    break;
            }

            $layout = $section['layout'] ?? 1;
            $columns = $section['columns'] ?? [];
            $isFirstSection = $sectionIndex === 0;
            $showImageWithSection = $isFirstSection && isset($pageImage) && $pageImage && $pageImage->image_path && $layout == 1;

            // Helper to render column content (supports both old string format and new object format)
            $renderColumn = function($col) {
                if (is_string($col)) {
                    // Backwards compatibility: plain string is text content
                    return $col;
                }
                if (is_array($col)) {
                    if (($col['type'] ?? 'text') === 'image') {
                        if (!empty($col['content'])) {
                            return '<div class="rounded-4 overflow-hidden" style="border: 3px solid #dee2e6;"><img src="' . Storage::url($col['content']) . '" alt="" class="w-100" style="display: block;"></div>';
                        } else {
                            // Show placeholder for empty image
                            return '<div class="rounded-4 d-flex align-items-center justify-content-center" style="height: 250px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); border: 3px solid #dee2e6;"><i class="fas fa-image fa-3x text-muted"></i></div>';
                        }
                    }
                    return $col['content'] ?? '';
                }
                return '';
            };
        @endphp

        <section class="py-5 {{ $bgClass }} {{ $textClass }}" style="{{ $bgStyle }}">
            <div class="container">
                @if($showImageWithSection)
                    {{-- First section with 1-column layout: show with page image on the side --}}
                    <div class="row align-items-start">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="rounded-4 overflow-hidden" style="height: 350px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); position: sticky; top: 100px; border: 3px solid #dee2e6;">
                                <img src="{{ Storage::url($pageImage->image_path) }}" alt="{{ $pageImage->alt_text ?? $page->title }}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="section-content">
                                {!! $renderColumn($columns[0] ?? '') !!}
                            </div>
                        </div>
                    </div>
                @elseif($layout == 1)
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="section-content">
                                {!! $renderColumn($columns[0] ?? '') !!}
                            </div>
                        </div>
                    </div>
                @elseif($layout == 2)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-content">
                                {!! $renderColumn($columns[0] ?? '') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="section-content">
                                {!! $renderColumn($columns[1] ?? '') !!}
                            </div>
                        </div>
                    </div>
                @elseif($layout == 3)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="section-content">
                                {!! $renderColumn($columns[0] ?? '') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="section-content">
                                {!! $renderColumn($columns[1] ?? '') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="section-content">
                                {!! $renderColumn($columns[2] ?? '') !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endforeach
@else
    <!-- Simple Content (fallback) -->
    <section class="py-5">
        <div class="container">
            @if($page->slug === 'company-history')
            <div class="row align-items-start">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="rounded-4 overflow-hidden" style="height: 350px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); position: sticky; top: 100px; border: 3px solid #dee2e6;">
                        @if($pageImage && $pageImage->image_path)
                            <img src="{{ Storage::url($pageImage->image_path) }}" alt="{{ $pageImage->alt_text ?? 'Company History' }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            @else
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endif
@endsection

@push('styles')
<style>
    .section-content h1,
    .section-content h2,
    .section-content h3,
    .section-content h4,
    .section-content h5,
    .section-content h6 {
        color: inherit;
    }
    .text-white .section-content a {
        color: #fff;
        text-decoration: underline;
    }
    .text-white .section-content a:hover {
        opacity: 0.8;
    }
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
</style>
@endpush
