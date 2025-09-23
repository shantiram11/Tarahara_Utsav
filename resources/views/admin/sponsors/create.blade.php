@extends('layouts.admin')

@section('page_title', 'Create Sponsor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create Sponsor</h2>
    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line me-1"></i>Back to List
    </a>
</div>

<!-- Alert Container for Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="sponsorForm" action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Sponsor Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}"
                               placeholder="Enter sponsor name or company title"
                               required>
                        <div id="titleError" class="invalid-feedback"></div>
                    </div>

                    <!-- Tier Selection -->
                    <div class="mb-3">
                        <label for="tier" class="form-label">Sponsor Tier <span class="text-danger">*</span></label>
                        <select id="tier" name="tier" class="form-select @error('tier') is-invalid @enderror" required>
                            <option value="">Select a tier</option>
                            <option value="tier1" {{ old('tier') == 'tier1' ? 'selected' : '' }}>
                                Tier 1 - Premium (Larger display, prominent placement)
                            </option>
                            <option value="tier2" {{ old('tier') == 'tier2' ? 'selected' : '' }}>
                                Tier 2 - Standard (Smaller display, grid layout)
                            </option>
                        </select>
                        <div id="tierError" class="invalid-feedback"></div>
                    </div>

                    <!-- Website URL -->
                    <div class="mb-3">
                        <label for="website_url" class="form-label">Website URL</label>
                        <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                               id="website_url" name="website_url" value="{{ old('website_url') }}"
                               placeholder="https://example.com">
                        <div class="form-text">Optional: Link to sponsor's website</div>
                        <div id="website_urlError" class="invalid-feedback"></div>
                    </div>

                    <!-- Amount & Label -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount (e.g., RS. 2,00,000/-)</label>
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" placeholder="RS. 2,00,000/-">
                            <div id="amountError" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="label" class="form-label">Label (e.g., TITLE SPONSOR)</label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" placeholder="TITLE SPONSOR">
                            <div id="labelError" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Sponsor Logo/Image <span class="text-danger">*</span></label>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors duration-200"
                             id="uploadArea">
                            <div id="imagePreview" class="hidden mb-4">
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded shadow" style="max-height: 200px;">
                            </div>

                            <div id="uploadContent">
                                <i class="ri-upload-cloud-2-line text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">
                                    <span class="text-primary fw-medium">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-muted small">PNG, JPG, JPEG, WEBP up to 2MB</p>
                            </div>

                            <input type="file" id="image" name="image" accept="image/*" class="d-none" required>
                        </div>

                        <div id="imageError" class="invalid-feedback"></div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none me-2" id="submitSpinner"></span>
                            Create Sponsor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadArea = document.getElementById('uploadArea');
    const uploadContent = document.getElementById('uploadContent');

    // Handle file selection
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                showAlert('danger', 'Please select an image file');
                imageInput.value = '';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('danger', 'File size must be less than 2MB');
                imageInput.value = '';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('d-none');
                uploadContent.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-primary', 'bg-light');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary', 'bg-light');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary', 'bg-light');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });

    // Click to upload
    uploadArea.addEventListener('click', function() {
        imageInput.click();
    });
});

function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    alertContainer.innerHTML = alertHtml;

    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}
</script>
@endpush
