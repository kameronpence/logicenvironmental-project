@extends('layouts.frontend')

@section('title', 'Contact Us - ' . config('app.name'))
@section('meta_description', 'Contact Logic Environmental for questions about our environmental consulting services.')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 60px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Contact Us</h1>
        <p class="lead text-white">We're here to answer your questions</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card h-100" style="border: 1px solid #e9ecef;">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Get In Touch</h5>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-map-marker-alt fa-2x" style="color: #742E6F;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Georgia Office</h6>
                                <p class="text-muted mb-0">
                                    3400 McClure Bridge Road<br>
                                    Suite F602<br>
                                    Duluth, GA 30096
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone fa-2x" style="color: #742E6F;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Phone</h6>
                                <p class="text-muted mb-0">
                                    <a href="tel:+17708170212">770-817-0212</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope fa-2x" style="color: #742E6F;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">
                                    <a href="mailto:info@logicenvironmental.com">info@logicenvironmental.com</a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x" style="color: #742E6F;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Business Hours</h6>
                                <p class="text-muted mb-0">
                                    Monday - Friday: 8:30 AM - 5:00 PM<br>
                                    Saturday - Sunday: Closed
                                </p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <p class="mb-0">
                            <a href="{{ route('page.show', 'locations') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-map-marked-alt me-2"></i>View All Locations
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                @if(session('contact_success'))
                    <div class="alert alert-success mb-4" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Message Sent!</h4>
                        <p class="mb-0">Thank you for contacting us. We'll get back to you as soon as possible.</p>
                    </div>
                @endif

                <div class="card" style="border: 1px solid #e9ecef;">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="card-title mb-4">Send Us a Message</h5>

                        <form action="{{ route('contact.submit') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                        <option value="">Select a subject...</option>
                                        <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="Service Question" {{ old('subject') == 'Service Question' ? 'selected' : '' }}>Question About Services</option>
                                        <option value="Project Status" {{ old('subject') == 'Project Status' ? 'selected' : '' }}>Existing Project Status</option>
                                        <option value="Employment" {{ old('subject') == 'Employment' ? 'selected' : '' }}>Employment Opportunities</option>
                                        <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required placeholder="How can we help you?">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>
                                    @error('cf-turnstile-response')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-muted text-center">
                        Looking to request a detailed proposal for a project?
                        <a href="{{ route('proposal') }}" class="text-success fw-bold">Submit a Proposal Request</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
