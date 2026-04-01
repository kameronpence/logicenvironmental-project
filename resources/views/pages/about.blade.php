@extends('layouts.frontend')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">{{ $page->title }}</h1>
    </div>
</section>

@if($page->hasSections())
    <!-- Sections with Page Image -->
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
            $showImageWithSection = $isFirstSection && $pageImage && $pageImage->image_path && $layout == 1;

            $renderColumn = function($col) {
                if (is_string($col)) {
                    return $col;
                }
                if (is_array($col)) {
                    if (($col['type'] ?? 'text') === 'image') {
                        if (!empty($col['content'])) {
                            return '<div class="rounded-4 overflow-hidden" style="border: 3px solid #dee2e6;"><img src="' . Storage::url($col['content']) . '" alt="" class="w-100" style="display: block;"></div>';
                        } else {
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
                        <div class="col-lg-8">
                            <div class="section-content">
                                {!! $renderColumn($columns[0] ?? '') !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="rounded-4 overflow-hidden" style="height: 350px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); position: sticky; top: 100px; border: 3px solid #dee2e6;">
                                <img src="{{ Storage::url($pageImage->image_path) }}" alt="{{ $pageImage->alt_text ?? 'About Us' }}" class="w-100 h-100" style="object-fit: cover;">
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
<!-- Page Content -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-8">
                <div class="page-content mb-5">
                    {!! $page->content !!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rounded-4 overflow-hidden" style="height: 350px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); position: sticky; top: 100px; border: 3px solid #dee2e6;">
                    @if($pageImage && $pageImage->image_path)
                        <img src="{{ Storage::url($pageImage->image_path) }}" alt="{{ $pageImage->alt_text ?? 'About Us' }}" class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
@if($teamMembers->count() > 0)
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">{{ \App\Models\SiteSetting::get('team_section_title', 'Our Team') }}</h2>
        <div class="row justify-content-center">
            @foreach($teamMembers as $member)
            <div class="col-8 col-sm-6 col-md-6 col-lg-3 mb-5">
                <div class="team-card" style="border-radius: 0.5rem; border: 1px solid #e9ecef;">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" class="img-fluid" alt="{{ $member->name }}" style="width: 100%; border-radius: 0.5rem 0.5rem 0 0;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px; width: 100%; border-radius: 0.5rem 0.5rem 0 0;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    @endif
                    <div class="text-center bg-white p-3" style="border-radius: 0 0 0.5rem 0.5rem;">
                        <h5 class="mb-1">{{ $member->name }}</h5>
                        @if($member->title)
                            <p class="text-muted small mb-2">{{ $member->title }}</p>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#teamModal{{ $member->id }}">
                            View Bio & Email
                        </button>
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
@endif

<!-- Contact CTA -->
<section class="py-5">
    <div class="container text-center">
        <h3 class="mb-4">Ready to Work With Our Team?</h3>
        <a href="{{ route('proposal') }}" class="btn btn-success btn-lg me-2">
            <i class="fas fa-file-alt me-2"></i>Request a Proposal
        </a>
        <a href="{{ route('contact') }}" class="btn btn-outline-success btn-lg">
            <i class="fas fa-envelope me-2"></i>Contact Us
        </a>
    </div>
</section>
@endsection

