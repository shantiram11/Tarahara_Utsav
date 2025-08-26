@extends('layouts.admin')

@section('page_title', 'Create Hero Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create Hero Section</h2>
    <a href="{{ route('admin.heroes.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line me-1"></i>Back to List
    </a>
</div>

<!-- Alert Container for Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="heroForm" enctype="multipart/form-data" novalidate>
                    @csrf



                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Enter hero section description...">{{ old('description') }}</textarea>
                        <div id="descriptionError" class="invalid-feedback"></div>
                    </div>

                    <!-- Images Upload -->
                    <div class="mb-3">
                        <label for="collageImagesInput" class="form-label">Hero Images <span class="text-danger">*</span></label>
                                                 <input type="file" class="form-control @error('images') is-invalid @enderror"
                                id="collageImagesInput" name="images[]" accept="image/*" multiple>
                        <div class="form-text">
                            Upload images for hero section (JPG, PNG, max 2MB each).
                            <strong>Recommended size: 940 x 1328 pixels.</strong>
                            Images will be automatically cropped to fit this size if needed.
                                    </div>

                                                 <!-- Selected Images List -->
                         <div id="selectedImagesList" class="mt-3" style="display: none;">
                             <div class="d-flex align-items-center justify-content-between mb-3">
                                 <h6 class="text-primary mb-0">
                                     <i class="ri-image-2-line me-2"></i>Selected Images
                                 </h6>
                                 <span class="badge bg-primary" id="imageCount">0</span>
                                    </div>
                             <div id="selectedImagesContainer" class="selected-images-grid">
                                 <!-- Selected images will be displayed here -->
                            </div>
                    </div>

                        <div id="imagesPreview" class="mt-2 row"></div>
                        <div id="imagesError" class="invalid-feedback"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.heroes.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none me-2" id="submitSpinner"></span>
                            Create Hero Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Image to 940 x 1328</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <p class="text-muted">Drag and resize the crop area to select the best part of your image</p>
                </div>
                <div class="crop-container text-center">
                    <div id="cropArea"></div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Original Size:</label>
                            <div id="originalSize" class="text-muted"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Target Size:</label>
                            <div class="text-success">940 x 1328 pixels</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropButton">Crop & Add Image</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Cropper.js CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<style>
.selected-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    border: 2px dashed #e3e9ff;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
}

.selected-images-grid::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 50% 50%, rgba(13, 110, 253, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.image-card {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    z-index: 1;
}

.image-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 8px 25px rgba(13, 110, 253, 0.2);
    border-color: #0d6efd;
}

.image-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.image-card:hover img {
    transform: scale(1.05);
}

.image-card-body {
    padding: 16px;
    text-align: center;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9ff 100%);
}

.image-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 6px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.image-card-subtitle {
    font-size: 0.75rem;
    color: #28a745;
    margin: 0;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    padding: 2px 8px;
    background: rgba(40, 167, 69, 0.1);
    border-radius: 12px;
}

.remove-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: scale(0.8);
    backdrop-filter: blur(10px);
}

.image-card:hover .remove-btn {
    opacity: 1;
    transform: scale(1);
}

.remove-btn:hover {
    background: #dc3545;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #8492a6;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.6;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state h6 {
    font-weight: 600;
    margin-bottom: 8px;
    color: #5a6c7d;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
    opacity: 0.8;
}

/* File input styling */
.form-control[type="file"] {
    padding: 12px;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.form-control[type="file"]:hover {
    border-color: #0d6efd;
    background: #f0f4ff;
}

.form-control[type="file"]:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    background: white;
}

/* Badge styling */
.badge.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Header styling */
.text-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

/* Animation for new images */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.image-card {
    animation: slideInUp 0.4s ease-out;
}
</style>

<script>
// Global variables
let selectedImages = [];
let currentCropFile = null;
let cropper = null;

// Images Upload Handler
document.getElementById('collageImagesInput').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const error = document.getElementById('imagesError');
    const input = this;

    error.style.display = 'none';

    if (files.length === 0) {
        return;
    }

    files.forEach(file => {
        // Validate file size
        if (file.size > 2 * 1024 * 1024) {
            error.textContent = 'Each file must be less than 2MB';
            error.style.display = 'block';
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            error.textContent = 'Please select valid image files only';
            error.style.display = 'block';
            return;
        }

        // Check image dimensions
        checkImageDimensions(file);
    });

    // Clear the input so user can select the same file again if needed
    input.value = '';
});

// Check image dimensions and show crop modal if needed
function checkImageDimensions(file) {
    const img = new Image();
        const reader = new FileReader();

        reader.onload = function(e) {
        img.onload = function() {
            const { width, height } = img;

            // Check if image matches target dimensions (940 x 1328)
            if (width === 940 && height === 1328) {
                            // Perfect size, add directly
            addImageToSelection(file);
            showAlert('success', `Image "${file.name}" added successfully!`);
            } else {
                // Show crop modal
                showCropModal(file, width, height);
            }
        };
        img.src = e.target.result;
    };

        reader.readAsDataURL(file);
}

// Show crop modal
function showCropModal(file, originalWidth, originalHeight) {
    currentCropFile = file;

    // Update original size display
    document.getElementById('originalSize').textContent = `${originalWidth} x ${originalHeight} pixels`;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('cropModal'));
    modal.show();

    // Initialize cropper after modal is shown
    modal._element.addEventListener('shown.bs.modal', function() {
        initializeCropper(file);
    });
}

// Initialize cropper
function initializeCropper(file) {
    const cropArea = document.getElementById('cropArea');
    cropArea.innerHTML = '';

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.maxWidth = '100%';
    img.style.maxHeight = '400px';
    cropArea.appendChild(img);

    // Initialize cropper with 940:1328 aspect ratio
    cropper = new Cropper(img, {
        aspectRatio: 940 / 1328,
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 1,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
    });
}

// Crop button click handler
document.getElementById('cropButton').addEventListener('click', function() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({
            width: 940,
            height: 1328
        });

        // Convert canvas to blob
        canvas.toBlob(function(blob) {
            // Create a new file from the blob
            const croppedFile = new File([blob], currentCropFile.name, {
                type: currentCropFile.type,
                lastModified: Date.now()
            });

            // Add cropped image to selection
            addImageToSelection(croppedFile);
            showAlert('success', `Image "${croppedFile.name}" cropped and added successfully!`);

            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();

            // Clean up
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            currentCropFile = null;
        }, currentCropFile.type);
    }
});

// Add image to selection
function addImageToSelection(file) {
    const imageId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    selectedImages.push({
        id: imageId,
        file: file,
        name: file.name
    });

    console.log('Added image to selection:', file.name, 'Total images:', selectedImages.length);

    // Display the selected image
    displaySelectedImage(imageId, file);

    // Update the selected images count display
    updateSelectedImagesCount();
}

// Display selected image in the list
function displaySelectedImage(imageId, file) {
    const container = document.getElementById('selectedImagesContainer');
    const reader = new FileReader();

    reader.onload = function(e) {
        const imageCard = document.createElement('div');
        imageCard.className = 'image-card';
        imageCard.id = imageId;

        const fileName = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;

        imageCard.innerHTML = `
            <img src="${e.target.result}" alt="Selected image">
            <button type="button" class="remove-btn" onclick="removeSelectedImage('${imageId}')" title="Remove image">
                <i class="ri-close-line"></i>
            </button>
            <div class="image-card-body">
                <div class="image-card-title">${fileName}</div>
                <div class="image-card-subtitle">
                    <i class="ri-check-line me-1"></i>940 × 1328
                </div>
            </div>
        `;

        container.appendChild(imageCard);
    };

    reader.readAsDataURL(file);
}

// Remove selected image
function removeSelectedImage(imageId) {
    // Remove from selectedImages array
    selectedImages = selectedImages.filter(img => img.id !== imageId);

    // Remove from DOM
    const imageElement = document.getElementById(imageId);
    if (imageElement) {
        imageElement.remove();
    }

    // Update the selected images count display
    updateSelectedImagesCount();
}

// Update selected images count display
function updateSelectedImagesCount() {
    const container = document.getElementById('selectedImagesList');
    const imageContainer = document.getElementById('selectedImagesContainer');
    const countBadge = document.getElementById('imageCount');
    const count = selectedImages.length;

    if (count === 0) {
        container.style.display = 'none';
        imageContainer.innerHTML = `
            <div class="empty-state">
                <i class="ri-image-add-line"></i>
                <h6>No images selected yet</h6>
                <p>Choose files above to add images to your hero section</p>
            </div>
        `;
    } else {
        container.style.display = 'block';
        countBadge.textContent = count;

        // Remove empty state if it exists
        const emptyState = imageContainer.querySelector('.empty-state');
        if (emptyState) {
            emptyState.remove();
        }
    }
}

// Form Submission
document.getElementById('heroForm').addEventListener('submit', function(e) {
    e.preventDefault();

    console.log('Form submission started. Selected images:', selectedImages.length);

    // Clear previous errors
    clearErrors();

    // Validate form
    if (!validateForm()) {
        console.log('Form validation failed');
        return;
    }

    console.log('Form validation passed, proceeding with submission');

    // Prepare form data
    const formData = new FormData();

    // Add CSRF token
    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');

    // Add description
    const description = document.getElementById('description').value.trim();
    if (description) {
        formData.append('description', description);
    }

    // Add selected images
    console.log('Selected images count:', selectedImages.length);
    selectedImages.forEach((imageData, index) => {
        console.log(`Adding image ${index}:`, imageData.file.name, imageData.file.size);
        formData.append(`images[${index}]`, imageData.file);
    });



    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.getElementById('submitSpinner');
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');

    // Send AJAX request
    fetch('{{ route("admin.heroes.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
            .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType?.includes('application/json')) {
            return response.text().then(() => {
                throw new Error('Server returned HTML instead of JSON. Please check authentication.');
            });
        }

        return response.json();
    })
    .then(data => {

        if (data.success) {
            showAlert('success', data.message);
            // Redirect to index page after a short delay
            setTimeout(() => {
                window.location.href = '{{ route("admin.heroes.index") }}';
            }, 1500);
        } else {
            // Handle different types of errors
            if (data.errors) {
                console.log('Validation errors received:', data.errors);
                let errorMessages = [];
                Object.keys(data.errors).forEach(field => {
                    if (field === 'images') {
                        showFieldError('imagesError', data.errors[field].join(', '));
                    }
                    errorMessages.push(`${field}: ${data.errors[field].join(', ')}`);
                });
                showAlert('danger', 'Validation errors: ' + errorMessages.join(' | '));
            } else if (data.redirect) {
                // Handle authentication redirect
                showAlert('warning', data.message || 'Authentication required');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                showAlert('danger', data.message || 'Error creating hero section');
            }
        }
    })
    .catch(error => {
        showAlert('danger', `Error: ${error.message}`);
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});

function validateForm() {
    let isValid = true;

    // Check if at least one image is selected
    if (selectedImages.length === 0) {
        showFieldError('imagesError', 'Please select at least one image for the hero section');
        showAlert('danger', 'Please select at least one image before submitting');
        isValid = false;
    }

    // Check description (optional)
    const description = document.getElementById('description').value.trim();
    if (description && description.length > 1000) {
        showFieldError('descriptionError', 'Description must be less than 1000 characters');
        isValid = false;
    }

    return isValid;
}

function clearErrors() {
    document.querySelectorAll('.invalid-feedback').forEach(error => {
        error.style.display = 'none';
        error.textContent = '';
    });
    document.querySelectorAll('.is-invalid').forEach(field => {
        field.classList.remove('is-invalid');
    });
}

function showFieldError(fieldId, message) {
    const errorElement = document.getElementById(fieldId);
    if (errorElement) {
    const field = errorElement.previousElementSibling;
    errorElement.textContent = message;
    errorElement.style.display = 'block';
        if (field) {
    field.classList.add('is-invalid');
        }
    }
}

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

// Debug function to check current state
function debugState() {
    console.log('=== DEBUG STATE ===');
    console.log('Selected images:', selectedImages);
    console.log('Selected images count:', selectedImages.length);
    console.log('Container visible:', document.getElementById('selectedImagesList').style.display !== 'none');
    console.log('==================');
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedImagesCount();

    // Add debug button for testing (remove in production)
    console.log('Hero form initialized. Selected images:', selectedImages.length);
});
</script>
@endpush
