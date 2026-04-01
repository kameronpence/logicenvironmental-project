@extends('layouts.frontend')

@section('title', 'Request a Proposal - ' . config('app.name'))
@section('meta_description', 'Request a proposal for environmental consulting services from Logic Environmental.')

@section('content')
<!-- Page Header -->
<section class="hero" style="padding: 40px 0;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-white">Request a Proposal</h1>
        <p class="lead text-white">Complete the form below and we'll provide a detailed proposal</p>
    </div>
</section>

<!-- Proposal Form -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('proposal_success'))
                    <div class="alert alert-success mb-4" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Thank You!</h4>
                        <p>Your proposal request has been submitted successfully. A member of our team will review your project details and get back to you within 24-48 hours.</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Please correct the following errors:</h5>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card" style="border: 1px solid #e9ecef;">
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('proposal.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Person Requesting Proposal -->
                            <h5 class="mb-4 pb-2 border-bottom text-dark"><i class="fas fa-user me-2"></i>Person Requesting Proposal</h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
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
                                    <label for="company" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="branch" class="form-label">Branch</label>
                                    <input type="text" class="form-control" id="branch" name="branch" value="{{ old('branch') }}">
                                </div>
                                <div class="col-12">
                                    <label for="street_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('street_address') is-invalid @enderror" id="street_address" name="street_address" value="{{ old('street_address') }}" required>
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="zip_code" class="form-label">Zip Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                                    @error('zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Property Information -->
                            <h5 class="mb-4 pb-2 border-bottom text-dark"><i class="fas fa-building me-2"></i>Property Information</h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label for="property_address" class="form-label">Address/Tax Parcel <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('property_address') is-invalid @enderror" id="property_address" name="property_address" value="{{ old('property_address') }}" required>
                                    @error('property_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="county" class="form-label">County <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('county') is-invalid @enderror" id="county" name="county" value="{{ old('county') }}" required>
                                    @error('county')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="property_size" class="form-label">Size of Property <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('property_size') is-invalid @enderror" id="property_size" name="property_size" value="{{ old('property_size') }}" placeholder="Include units: sq feet, acres, etc" required>
                                    @error('property_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="owner_name" class="form-label">Property Owner Name</label>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="owner_phone" class="form-label">Property Owner Phone</label>
                                    <input type="tel" class="form-control" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="owner_email" class="form-label">Property Owner E-mail</label>
                                    <input type="email" class="form-control" id="owner_email" name="owner_email" value="{{ old('owner_email') }}">
                                </div>
                            </div>

                            <!-- Proposal Information -->
                            <h5 class="mb-4 pb-2 border-bottom text-dark"><i class="fas fa-file-alt me-2"></i>Proposal Information</h5>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="investigation_type" class="form-label">What type of service are you requesting? <span class="text-danger">*</span></label>
                                    <select class="form-select @error('investigation_type') is-invalid @enderror" id="investigation_type" name="investigation_type" required>
                                        <option value="">Please Choose...</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->title }}" {{ old('investigation_type') == $service->title ? 'selected' : '' }}>{{ $service->title }}</option>
                                        @endforeach
                                        <option value="Other" {{ old('investigation_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('investigation_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="report_deadline" class="form-label">Required Timeframe <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('report_deadline') is-invalid @enderror" id="report_deadline" name="report_deadline" value="{{ old('report_deadline') }}" required>
                                    @error('report_deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="hardcopies_needed" class="form-label">Hardcopies Needed? <span class="text-danger">*</span></label>
                                    <select class="form-select @error('hardcopies_needed') is-invalid @enderror" id="hardcopies_needed" name="hardcopies_needed" required>
                                        <option value="">Please Choose...</option>
                                        <option value="Yes" {{ old('hardcopies_needed') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('hardcopies_needed') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('hardcopies_needed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="report_addressees" class="form-label">Please list the names and addresses of all parties to whom the written report must be addressed <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('report_addressees') is-invalid @enderror" id="report_addressees" name="report_addressees" rows="3" required>{{ old('report_addressees') }}</textarea>
                                    @error('report_addressees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="num_structures" class="form-label">Number of Structures On Site <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('num_structures') is-invalid @enderror" id="num_structures" name="num_structures" value="{{ old('num_structures', 0) }}" min="0" max="15" required>
                                    <small class="text-muted">Enter 0 - 15</small>
                                    @error('num_structures')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8">
                                    <label for="structure_age" class="form-label">Age or age range of structures <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('structure_age') is-invalid @enderror" id="structure_age" name="structure_age" value="{{ old('structure_age') }}" placeholder="Indicate Number of Months, Years, Etc" required>
                                    @error('structure_age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="survey_available" class="form-label">Is a survey or site drawing available? <span class="text-danger">*</span></label>
                                    <select class="form-select @error('survey_available') is-invalid @enderror" id="survey_available" name="survey_available" required>
                                        <option value="">Please Choose...</option>
                                        <option value="Yes" {{ old('survey_available') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('survey_available') == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Unknown" {{ old('survey_available') == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                    </select>
                                    @error('survey_available')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="prior_reports" class="form-label">Are any prior environmental reports available? <span class="text-danger">*</span></label>
                                    <select class="form-select @error('prior_reports') is-invalid @enderror" id="prior_reports" name="prior_reports" required>
                                        <option value="">Please Choose...</option>
                                        <option value="Yes" {{ old('prior_reports') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('prior_reports') == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Unknown" {{ old('prior_reports') == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                    </select>
                                    @error('prior_reports')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="access_problems" class="form-label">Do you know of any special access problems? <span class="text-danger">*</span></label>
                                    <select class="form-select @error('access_problems') is-invalid @enderror" id="access_problems" name="access_problems" required>
                                        <option value="">Please Choose...</option>
                                        <option value="Yes" {{ old('access_problems') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('access_problems') == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Unknown" {{ old('access_problems') == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                    </select>
                                    @error('access_problems')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attach Files -->
                            <h5 class="mb-4 pb-2 border-bottom text-dark"><i class="fas fa-paperclip me-2"></i>Attach Files (Optional)</h5>

                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <p class="text-muted small mb-3">If you have any documents (such as prior environmental reports, maps, legal descriptions, surveys, etc.) you would like to provide, please attach your file(s).</p>
                                    <input type="file" class="filepond" name="attachments[]" multiple>
                                    <small class="text-muted d-block mt-2">Allowed: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX, PSD. Up to 5 files.</small>
                                </div>
                            </div>

                            <!-- Cloudflare Turnstile -->
                            <div class="mb-4 text-center">
                                <div class="cf-turnstile d-inline-block" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>
                                @error('cf-turnstile-response')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-dark btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Proposal Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        <i class="fas fa-lock me-2"></i>Your information is secure and will only be used to respond to your inquiry.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<style>
    .filepond--root {
        font-family: inherit;
    }
    .filepond--panel-root {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
    .filepond--drop-label {
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to errors if any
        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Create FilePond instance
        const inputElement = document.querySelector('input.filepond');
        if (inputElement) {
            FilePond.create(inputElement, {
                storeAsFile: true,
                allowMultiple: true,
                maxFiles: 5,
                labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>'
            });
        }
    });
</script>
@endpush
