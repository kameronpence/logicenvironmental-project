@extends('layouts.frontend')

@section('title', 'Invalid Link - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Client Portal</h1>
    </div>
</section>

<!-- Invalid Link Message -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card" style="border: 1px solid #e9ecef;">
                    <div class="card-body p-4 p-lg-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                        </div>
                        <h4 class="mb-3">Link Invalid or Expired</h4>
                        <p class="text-muted mb-4">
                            This access link is no longer valid. Links expire after 24 hours for security reasons, or may have already been used.
                        </p>
                        <a href="{{ route('client-portal.request') }}" class="btn btn-lg" style="background: #742E6F; color: white;">
                            <i class="fas fa-redo me-2"></i>Request New Link
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
