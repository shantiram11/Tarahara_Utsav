@extends('layouts.admin')

@section('page_title', 'About Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    @if(!$about)
    <div class="text-muted">
        <i class="ri-information-line me-1"></i>Only one about section is allowed
    </div>
    @else
    <div class="text-muted">
        <i class="ri-information-line me-1"></i>Only one about section is allowed
    </div>
    @endif
</div>

<!-- Success/Error Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    @if($about)
    <div class="col-12 mb-3">
        <!-- Top actions -->
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0">About Section</h5>
                <small class="text-muted" id="imageCount-{{ $about->id }}">{{ count($about->images ?? []) }} image(s)</small>
            </div>
            <!-- about actions -->
            <div class="d-flex gap-2">
                <a href="{{ route('admin.about.edit') }}" class="btn btn-sm btn-primary">
                    <i class="ri-edit-line me-1"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAbout({{ $about->id }})">
                    <i class="ri-delete-bin-line me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <h6 class="text-muted mb-1">Title:</h6>
        <p class="mb-2">{{ $about->title }}</p>
        <h6 class="text-muted mb-1">Content:</h6>
        <p>{{ $about->content }}</p>
    </div>

    <!-- Masonry Gallery (no card container) -->
    @if($about->images && count($about->images) > 0)
    <div class="masonry">
        @foreach($about->images as $index => $image)
        <div class="masonry-item" id="masonry-{{ $index }}">
            <img src="{{ Storage::url($image) }}" class="masonry-img" data-src="{{ Storage::url($image) }}" alt="About image">
            <button type="button" class="masonry-remove" title="Remove image"
                    onclick="removeImage({{ $about->id }}, {{ $index }})">
                <i class="ri-close-line"></i>
            </button>
            <span class="res-badge"></span>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="ri-image-line text-muted" style="font-size: 2.5rem;"></i>
        <p class="text-muted mt-2 mb-0">No images uploaded yet</p>
    </div>
    @endif
    @else
    <div class="col-12">
        <div class="text-center py-5">
            <i class="ri-image-line text-muted" style="font-size: 3rem;"></i>
            <h4 class="text-muted mt-3">No About Section Found</h4>
            <p class="text-muted">Create your about section with beautiful images to get started.</p>
            <a href="{{ route('admin.about.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Create About Section
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this about section? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.card.about-card { border: 1px solid #eef0f4; border-radius: 16px; overflow: hidden; }
.thumb-wrap { position: relative; border-radius: 10px; overflow: hidden; }
.masonry { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
.masonry-item { position: relative; border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 4px 16px rgba(18,38,63,.06); transition: all 0.3s ease; }
.masonry-item:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(18,38,63,.1); }
.masonry-img { height: 200px; width: 100%; object-fit: cover; display: block; background: #f7f9fc; }
.masonry-remove { position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; border: none; border-radius: 50%; background: rgba(220,53,69,.9); color: white; display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.2s; cursor: pointer; }
.masonry-item:hover .masonry-remove { opacity: 1; }
.masonry-remove:hover { background: #dc3545; transform: scale(1.1); }
.res-badge { position: absolute; left: 8px; bottom: 8px; padding: 2px 8px; font-size: .75rem; font-weight: 600; color: #0b1324; background: rgba(255,255,255,.9); border-radius: 999px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
</style>

<script>
let deleteAboutId = null;

function deleteAbout(aboutId) {
    deleteAboutId = aboutId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!deleteAboutId) return;

    fetch(`/admin/about`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to delete'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting');
    });

    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
});

function removeImage(aboutId, imageIndex) {
    if (!confirm('Are you sure you want to remove this image?')) {
        return;
    }

    const imageCard = document.getElementById(`masonry-${imageIndex}`);
    const removeBtn = imageCard?.querySelector('.masonry-remove');

    if (removeBtn) {
        removeBtn.disabled = true;
        removeBtn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
    }

    fetch(`/admin/about/images/${imageIndex}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const contentType = response.headers.get('content-type');
        if (!contentType?.includes('application/json')) {
            throw new Error('Server returned HTML instead of JSON. Please check authentication.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (imageCard) {
                imageCard.style.transition = 'all 0.3s ease';
                imageCard.style.opacity = '0';
                imageCard.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    imageCard.remove();
                    const countEl = document.querySelector('[id^="imageCount-"]');
                    if (countEl) {
                        countEl.textContent = `${data.remaining} image(s)`;
                    }
                    // Show empty state if no images remain
                    if (data.remaining === 0) {
                        const masonry = document.querySelector('.masonry');
                        if (masonry) {
                            masonry.innerHTML = `
                                <div class="text-center py-5 col-12">
                                    <i class="ri-image-line text-muted" style="font-size: 2.5rem;"></i>
                                    <p class="text-muted mt-2 mb-0">No images uploaded yet</p>
                                </div>
                            `;
                        }
                    }
                }, 300);
            }
            showAlert('success', data.message || 'Image removed successfully');
        } else {
            showAlert('danger', data.message || 'Error removing image');
            if (removeBtn) {
                removeBtn.disabled = false;
                removeBtn.innerHTML = '<i class="ri-close-line"></i>';
            }
        }
    })
    .catch(error => {
        showAlert('danger', `Error: ${error.message}`);
        if (removeBtn) {
            removeBtn.disabled = false;
            removeBtn.innerHTML = '<i class="ri-close-line"></i>';
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

function applyResBadges() {
    document.querySelectorAll('.masonry-img').forEach(img => {
        const setResolution = () => {
            const w = img.naturalWidth || 0;
            const h = img.naturalHeight || 0;
            const badge = img.parentElement.querySelector('.res-badge');
            if (badge && w && h) {
                badge.textContent = `${w} × ${h}`;
            }
        };
        if (img.complete) {
            setResolution();
        } else {
            img.addEventListener('load', setResolution, { once: true });
        }
    });
}

document.addEventListener('DOMContentLoaded', applyResBadges);
</script>
@endpush