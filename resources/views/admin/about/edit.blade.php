@extends('layouts.admin')

@section('page_title', 'Edit About Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit About Section</h2>
    <a href="{{ route('admin.about.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line me-1"></i>Back to List
    </a>
</div>

<!-- Alert Container for Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">About Section Details</h3>
            </div>
            <div class="card-body">
                <form id="aboutForm" action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" novalidate
                      data-target-w="1080"
                      data-target-h="720">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $about->title ?? '') }}"
                               placeholder="Enter about section title...">
                        <div id="titleError" class="invalid-feedback"></div>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="4"
                                  placeholder="Enter about section content...">{{ old('content', $about->content ?? '') }}</textarea>
                        <div id="contentError" class="invalid-feedback"></div>
                    </div>

                    <!-- Images Upload -->
                    <div class="mb-3">
                        <label for="collageImagesInput" class="form-label">About Images</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror"
                               id="collageImagesInput" name="images[]" accept="image/*" multiple>
                        <div class="form-text">
                            Upload new images for about section (JPG, PNG, WEBP, max 2MB each).
                            <strong>Recommended size: 1080 x 720 pixels (landscape).</strong>
                            Images will be automatically cropped to fit this size if needed.
                            <strong>Please upload an even number of images for best layout.</strong>
                        </div>

                        <!-- Current Images Preview -->
                        @php $images = $about->images ?? []; @endphp
                        @if(count($images) > 0)
                        <div class="mt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-warning mb-0">
                                    <i class="ri-image-line me-2"></i>Current Images
                                </h6>
                                <span class="badge bg-warning text-dark">{{ count($images) }}</span>
                            </div>
                            <div class="current-images-grid">
                                @foreach($images as $index => $image)
                                <div class="current-image-card" id="current-image-{{ $index }}">
                                    <img src="{{ Storage::url($image) }}" alt="Current image">
                                    <button type="button" class="current-image-remove-btn"
                                            onclick="removeAboutImage({{ $index }})"
                                            title="Remove this image">
                                        <i class="ri-close-line"></i>
                                    </button>
                                    <span class="current-image-badge">1080 × 720</span>
                                </div>
                                @endforeach
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
                            <div id="selectedImagesContainer" class="selected-images-grid"></div>
                        </div>

                        <div id="imagesError" class="invalid-feedback"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none me-2" id="submitSpinner"></span>
                            Update About Section
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
                <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
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
                            <div class="text-success">1080 x 720 pixels</div>
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
    padding: 12px;
    border: 2px dashed #d4edda;
    border-radius: 12px;
    background: #f8fff9;
}

.image-card {
    position: relative;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    transition: all 0.3s ease;
}

.image-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,.12);
}

.image-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}

.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: rgba(220,53,69,.92);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.2s;
    cursor: pointer;
}

.image-card:hover .remove-btn {
    opacity: 1;
}

.remove-btn:hover {
    background: #dc3545;
    transform: scale(1.1);
}

.image-card-body {
    padding: 12px;
}

.image-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.image-card-subtitle {
    font-size: 0.75rem;
    color: #22c55e;
    font-weight: 500;
}

.current-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 12px;
    padding: 12px;
    border: 2px solid #ffe58f;
    border-radius: 12px;
    background: #fffdf2;
}

.current-image-card {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    transition: all 0.3s ease;
}

.current-image-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
}

.current-image-card img {
    width: 100%;
    height: 120px;
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
    background: rgba(220,53,69,.92);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.2s;
    cursor: pointer;
}

.current-image-card:hover .current-image-remove-btn {
    opacity: 1;
}

.current-image-remove-btn:hover {
    background: #dc3545;
    transform: scale(1.1);
}

.current-image-badge {
    position: absolute;
    left: 8px;
    bottom: 8px;
    padding: 2px 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #0b1324;
    background: rgba(255,255,255,.9);
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6b7280;
    grid-column: 1 / -1;
}

.empty-state i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.empty-state h6 {
    margin-bottom: 0.5rem;
    color: #374151;
}

.crop-container {
    max-height: 400px;
    overflow: hidden;
}

.image-card {
    animation: slideInUp 0.4s ease-out;
}

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
</style>

<script src="{{ asset('js/crop.js') }}"></script>
<script src="{{ asset('js/about-images.js') }}"></script>

<script>
function removeAboutImage(index) {
    if (!confirm('Are you sure you want to remove this image?')) return;
    const card = document.getElementById(`current-image-${index}`);
    const btn = card ? card.querySelector('.current-image-remove-btn') : null;
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<div class="spinner-border spinner-border-sm"></div>';
    }

    fetch(`{{ route('admin.about.images.remove', ['index' => '___IDX___']) }}`.replace('___IDX___', index), {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(r => {
        if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
        const contentType = r.headers.get('content-type');
        if (!contentType?.includes('application/json')) {
            throw new Error('Server returned HTML instead of JSON. Please check authentication.');
        }
        return r.json();
    }).then(data => {
        if (!data.success) throw new Error(data.message || 'Failed');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'scale(.9)';
            setTimeout(() => card.remove(), 200);
        }
        const badge = document.querySelector('.badge.bg-warning');
        if (badge) badge.textContent = data.remaining;

        // Show empty state if no images remain
        if (data.remaining === 0) {
            const currentImagesSection = document.querySelector('.mt-3:has(.current-images-grid)');
            if (currentImagesSection) {
                currentImagesSection.remove();
            }
        }

        showAlert('success', data.message || 'Image removed successfully');
    }).catch(err => {
        showAlert('danger', err.message);
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-close-line"></i>';
        }
    });
}

function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    if (alertContainer) alertContainer.innerHTML = alertHtml;
    setTimeout(() => {
        const alert = alertContainer?.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}
</script>
@endpush