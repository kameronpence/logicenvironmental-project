@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Site Settings</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Notification Emails</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addEmail">
                        <i class="fas fa-plus me-1"></i> Add Email
                    </button>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Configure which email addresses receive notifications from each form. At least one email must be selected for each form type.</p>

                    <div id="emailsContainer">
                        @foreach($notificationEmails as $index => $emailEntry)
                        <div class="email-row border rounded p-3 mb-3" data-index="{{ $index }}">
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <label class="form-label mb-1">Email Address</label>
                                    <input type="email" class="form-control @error('emails.'.$index.'.email') is-invalid @enderror"
                                           name="emails[{{ $index }}][email]"
                                           value="{{ old('emails.'.$index.'.email', $emailEntry['email']) }}" required>
                                    @error('emails.'.$index.'.email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label mb-1">Receive Notifications From</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="emails[{{ $index }}][proposal]" value="1"
                                                   id="proposal_{{ $index }}"
                                                   {{ old('emails.'.$index.'.proposal', $emailEntry['proposal'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="proposal_{{ $index }}">
                                                Proposals
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="emails[{{ $index }}][contact]" value="1"
                                                   id="contact_{{ $index }}"
                                                   {{ old('emails.'.$index.'.contact', $emailEntry['contact'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="contact_{{ $index }}">
                                                Contact
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="emails[{{ $index }}][client_uploads]" value="1"
                                                   id="client_uploads_{{ $index }}"
                                                   {{ old('emails.'.$index.'.client_uploads', $emailEntry['client_uploads'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="client_uploads_{{ $index }}">
                                                Client Uploads
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-email" title="Remove">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div id="noEmails" class="text-center py-4 text-muted" style="{{ count($notificationEmails) > 0 ? 'display: none;' : '' }}">
                        <i class="fas fa-envelope fa-2x mb-2"></i>
                        <p>No notification emails configured. Click "Add Email" to get started.</p>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Settings
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>About Email Settings</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2">
                        <strong>Proposals:</strong> Detailed proposal requests from potential clients.
                    </p>
                    <p class="text-muted mb-2">
                        <strong>Contact:</strong> General inquiries from the contact page.
                    </p>
                    <p class="text-muted mb-0">
                        <strong>Client Uploads:</strong> File uploads from the client portal (when no team member is selected).
                    </p>
                </div>
            </div>
        </div>
    </div>
</form>

<template id="emailRowTemplate">
    <div class="email-row border rounded p-3 mb-3" data-index="__INDEX__">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <label class="form-label mb-1">Email Address</label>
                <input type="email" class="form-control" name="emails[__INDEX__][email]" required>
            </div>
            <div class="col-md-5">
                <label class="form-label mb-1">Receive Notifications From</label>
                <div class="d-flex flex-wrap gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="emails[__INDEX__][proposal]" value="1" id="proposal___INDEX__" checked>
                        <label class="form-check-label" for="proposal___INDEX__">
                            Proposals
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="emails[__INDEX__][contact]" value="1" id="contact___INDEX__" checked>
                        <label class="form-check-label" for="contact___INDEX__">
                            Contact
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="emails[__INDEX__][client_uploads]" value="1" id="client_uploads___INDEX__" checked>
                        <label class="form-check-label" for="client_uploads___INDEX__">
                            Client Uploads
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-email" title="Remove">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('emailsContainer');
    const template = document.getElementById('emailRowTemplate');
    const noEmails = document.getElementById('noEmails');
    let nextIndex = {{ count($notificationEmails) }};

    function updateNoEmailsVisibility() {
        const hasEmails = container.querySelectorAll('.email-row').length > 0;
        noEmails.style.display = hasEmails ? 'none' : 'block';
    }

    function reindexEmails() {
        const rows = container.querySelectorAll('.email-row');
        rows.forEach((row, index) => {
            row.dataset.index = index;
            row.querySelectorAll('[name*="["]').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            });
            row.querySelectorAll('[id*="_"]').forEach(el => {
                const baseName = el.id.split('_')[0];
                el.id = `${baseName}_${index}`;
            });
            row.querySelectorAll('[for*="_"]').forEach(el => {
                const baseName = el.getAttribute('for').split('_')[0];
                el.setAttribute('for', `${baseName}_${index}`);
            });
        });
        nextIndex = rows.length;
    }

    document.getElementById('addEmail').addEventListener('click', function() {
        const html = template.innerHTML.replace(/__INDEX__/g, nextIndex);
        container.insertAdjacentHTML('beforeend', html);
        nextIndex++;
        updateNoEmailsVisibility();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-email')) {
            const row = e.target.closest('.email-row');
            if (container.querySelectorAll('.email-row').length > 1) {
                row.remove();
                reindexEmails();
                updateNoEmailsVisibility();
            } else {
                alert('You must have at least one notification email.');
            }
        }
    });

    // Form validation
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        const rows = container.querySelectorAll('.email-row');
        let hasProposal = false;
        let hasContact = false;

        rows.forEach(row => {
            if (row.querySelector('[name*="[proposal]"]:checked')) hasProposal = true;
            if (row.querySelector('[name*="[contact]"]:checked')) hasContact = true;
        });

        if (!hasProposal) {
            e.preventDefault();
            alert('At least one email must be selected to receive Proposal Form notifications.');
            return;
        }
        if (!hasContact) {
            e.preventDefault();
            alert('At least one email must be selected to receive Contact Form notifications.');
            return;
        }
    });
});
</script>
@endpush
