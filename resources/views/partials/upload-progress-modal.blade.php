<!-- Upload Progress Modal -->
<div class="modal fade" id="uploadProgressModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="upload-spinner mb-4">
                    <div class="spinner-border" style="width: 3rem; height: 3rem; color: #742E6F;" role="status">
                        <span class="visually-hidden">Uploading...</span>
                    </div>
                </div>
                <h5 class="mb-2" id="uploadProgressTitle">Uploading Files...</h5>
                <p class="text-muted mb-3" id="uploadProgressText">Please wait while your files are being uploaded.</p>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" id="uploadProgressBar" role="progressbar" style="width: 0%; background-color: #742E6F;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted mt-2 d-block" id="uploadProgressPercent">0%</small>
            </div>
        </div>
    </div>
</div>

<style>
#uploadProgressModal .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}
#uploadProgressModal .progress {
    border-radius: 4px;
    background-color: #e9ecef;
}
#uploadProgressModal .progress-bar {
    transition: width 0.3s ease;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
#uploadProgressModal .upload-spinner {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all forms with file inputs
    const formsWithFiles = document.querySelectorAll('form[enctype="multipart/form-data"]');

    formsWithFiles.forEach(form => {
        // Skip forms that have custom upload handling (like FilePond with AJAX)
        if (form.classList.contains('no-upload-modal')) return;

        // Track submission state to prevent double-submit
        let isSubmitting = false;

        form.addEventListener('submit', function(e) {
            // Prevent double submission
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            const fileInputs = form.querySelectorAll('input[type="file"]');
            let hasFiles = false;

            fileInputs.forEach(input => {
                if (input.files && input.files.length > 0) {
                    hasFiles = true;
                }
            });

            // Also check for FilePond instances
            const filePondInputs = form.querySelectorAll('.filepond');
            filePondInputs.forEach(input => {
                if (window.FilePond) {
                    const pond = FilePond.find(input);
                    if (pond && pond.getFiles().length > 0) {
                        hasFiles = true;
                    }
                }
            });

            if (hasFiles) {
                isSubmitting = true;

                // Disable submit button(s) to prevent further clicks
                const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                submitButtons.forEach(btn => {
                    btn.disabled = true;
                });

                showUploadProgress();
            }
        });
    });

    function showUploadProgress() {
        const modal = new bootstrap.Modal(document.getElementById('uploadProgressModal'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();

        // Simulate progress for forms without XHR (traditional form submit)
        // This gives visual feedback even though we can't track actual progress
        let progress = 0;
        const progressBar = document.getElementById('uploadProgressBar');
        const progressPercent = document.getElementById('uploadProgressPercent');

        const interval = setInterval(() => {
            // Slow down as we approach 90% (we don't know when it will actually complete)
            if (progress < 30) {
                progress += Math.random() * 10;
            } else if (progress < 60) {
                progress += Math.random() * 5;
            } else if (progress < 85) {
                progress += Math.random() * 2;
            } else if (progress < 95) {
                progress += Math.random() * 0.5;
            }

            progress = Math.min(progress, 95);
            progressBar.style.width = progress + '%';
            progressPercent.textContent = Math.round(progress) + '%';
        }, 500);

        // Store interval ID so it can be cleared if needed
        window.uploadProgressInterval = interval;
    }
});

// Function to show upload modal with XHR progress tracking
function uploadWithProgress(form, options = {}) {
    const modal = new bootstrap.Modal(document.getElementById('uploadProgressModal'), {
        backdrop: 'static',
        keyboard: false
    });

    const progressBar = document.getElementById('uploadProgressBar');
    const progressPercent = document.getElementById('uploadProgressPercent');
    const progressTitle = document.getElementById('uploadProgressTitle');
    const progressText = document.getElementById('uploadProgressText');

    if (options.title) progressTitle.textContent = options.title;
    if (options.text) progressText.textContent = options.text;

    modal.show();

    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percent = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = percent + '%';
            progressPercent.textContent = percent + '%';
        }
    });

    xhr.addEventListener('load', function() {
        progressBar.style.width = '100%';
        progressPercent.textContent = '100%';

        if (xhr.status >= 200 && xhr.status < 300) {
            // Redirect to the response URL or reload
            if (options.onSuccess) {
                options.onSuccess(xhr);
            } else {
                // For traditional form posts, the response might be a redirect
                window.location.reload();
            }
        } else {
            modal.hide();
            if (options.onError) {
                options.onError(xhr);
            } else {
                alert('Upload failed. Please try again.');
            }
        }
    });

    xhr.addEventListener('error', function() {
        modal.hide();
        if (options.onError) {
            options.onError(xhr);
        } else {
            alert('Upload failed. Please try again.');
        }
    });

    xhr.open(form.method || 'POST', form.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);

    return xhr;
}
</script>
