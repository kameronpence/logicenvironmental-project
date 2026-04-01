@extends('layouts.frontend')

@section('title', 'Client Portal - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Client Portal</h1>
        <p class="lead text-white">Access your project files securely</p>
    </div>
</section>

<!-- Request Link Form -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
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

                <div class="card" style="border: 1px solid #e9ecef;">
                    <div class="card-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-lock fa-3x" style="color: #742E6F;"></i>
                            </div>
                            <h4>Request Access Link</h4>
                            <p class="text-muted">Enter your email address and we'll send you a secure link to access your files.</p>
                        </div>

                        <form action="{{ route('client-portal.request-link') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-lg w-100" style="background: #742E6F; color: white;">
                                <i class="fas fa-paper-plane me-2"></i>Send Access Link
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small">
                        <i class="fas fa-shield-alt me-1"></i>
                        Your link will expire after 24 hours for security.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
