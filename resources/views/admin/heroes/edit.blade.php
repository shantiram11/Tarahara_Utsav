@extends('layouts.admin')

@section('page_title', 'Edit Hero Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Hero Section</h2>
    <a href="{{ route('admin.heroes.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line me-1"></i>Back to List
    </a>
</div>

<!-- Alert Container for Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Hero Section Details</h5>
            </div>
            <div class="card-body">
                <form id="heroForm" enctype="multipart/form-data" novalidate
                      data-submit-url="{{ route('admin.heroes.update', $hero) }}"
                      data-method="POST"
                      data-method-override="PUT"
                      data-require-images="false"
                      data-hero-id="{{ $hero->id }}"
                      data-success-redirect="{{ route('admin.heroes.index') }}">
                    @csrf
                    @method('PUT')



                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Enter hero section description...">{{ old('description', $hero->description) }}</textarea>
                        <div id="descriptionError" class="invalid-feedback"></div>
                    </div>

                                         <!-- Images Upload -->
                    <div class="mb-3">
                         <label for="collageImagesInput" class="form-label">Hero Images</label>
                         <input type="file" class="form-control @error('images') is-invalid @enderror"
                                id="collageImagesInput" name="images[]" accept="image/*" multiple>
                         <div class="form-text">
                             Upload new images for hero section (JPG, PNG, max 2MB each).
                             <strong>Recommended size: 940 x 1328 pixels.</strong>
                             Images will be automatically cropped to fit this size if needed.
                                        </div>

                                                 <!-- Current Images Preview -->
                         @if($hero->images && count($hero->images) > 0)
                         <div class="mt-3">
                             <div class="d-flex align-items-center justify-content-between mb-2">
                                 <h6 class="text-warning mb-0">
                                     <i class="ri-image-line me-2"></i>Current Images
                                 </h6>
                                 <span class="badge bg-warning text-dark">{{ count($hero->images) }}</span>
                                        </div>
                             <div class="current-images-grid">
                                 @foreach($hero->images as $index => $image)
                                 <div class="current-image-card" id="current-image-{{ $index }}">
                                     <img src="{{ Storage::url($image) }}" alt="Current image">
                                     <button type="button" class="current-image-remove-btn"
                                             onclick="removeCurrentImage({{ $hero->id }}, {{ $index }})"
                                             title="Remove this image">
                                         <i class="ri-close-line"></i>
                                            </button>
                                </div>
                                @endforeach
                                        </div>
                             <div class="form-text mt-2">
                                 <i class="ri-information-line me-1"></i>
                                 New images will be added to existing ones. Use the × button to remove individual images.
                                    </div>
                                </div>
                            @endif

                                                 <!-- New Selected Images List -->
                         <div id="selectedImagesList" class="mt-3" style="display: none;">
                             <div class="d-flex align-items-center justify-content-between mb-3">
                                 <h6 class="text-success mb-0">
                                     <i class="ri-image-add-line me-2"></i>New Images to Add
                                 </h6>
                                 <span class="badge bg-success" id="imageCount">0</span>
                                </div>
                             <div id="selectedImagesContainer" class="selected-images-grid">
                                 <!-- New selected images will be displayed here -->
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
                            Update Hero Section
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
    background: linear-gradient(135deg, #f0fff4 0%, #e8f5e8 100%);
    border: 2px dashed #d4edda;
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
    background: radial-gradient(circle at 50% 50%, rgba(40, 167, 69, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.image-card {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    z-index: 1;
}

.image-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2);
    border-color: #28a745;
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
    background: linear-gradient(180deg, #ffffff 0%, #f0fff4 100%);
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
    background: linear-gradient(135deg, #52c41a 0%, #389e0d 100%);
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

/* Current images styling */
.current-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 12px;
    padding: 16px;
    background: linear-gradient(135deg, #fff9e6 0%, #fff2cc 100%);
    border: 2px solid #ffe58f;
    border-radius: 12px;
    margin-top: 8px;
}

.current-image-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.current-image-card:hover {
    transform: translateY(-2px);
}

.current-image-card img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    display: block;
}

.current-image-remove-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0;
    transform: scale(0.8);
    backdrop-filter: blur(10px);
}

.current-image-card:hover .current-image-remove-btn {
    opacity: 1;
    transform: scale(1);
}

.current-image-remove-btn:hover {
    background: #dc3545;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
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
    border-color: #28a745;
    background: #f0fff4;
}

.form-control[type="file"]:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.1);
    background: white;
}

/* Badge styling */
.badge.bg-success {
    background: linear-gradient(135deg, #52c41a 0%, #389e0d 100%) !important;
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge.bg-warning {
    background: linear-gradient(135deg, #faad14 0%, #d48806 100%) !important;
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Header styling */
.text-success {
    background: linear-gradient(135deg, #52c41a 0%, #389e0d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

.text-warning {
    background: linear-gradient(135deg, #faad14 0%, #d48806 100%);
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

<script src="{{ asset('js/hero-images.js') }}"></script>
@endpush
