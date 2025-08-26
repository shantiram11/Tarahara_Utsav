@extends('layouts.admin')

@section('page_title', 'Hero Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    @if($heroes->count() == 0)
    @else
    <div class="text-muted">
        <i class="ri-information-line me-1"></i>Only one hero section is allowed
    </div>
    @endif
</div>

<!-- Success/Error Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    @forelse($heroes as $hero)
    <div class="col-12 mb-3">
        <!-- Top actions -->
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0">Hero Section</h5>
                <small class="text-muted" id="imageCount-{{ $hero->id }}">{{ count($hero->images ?? []) }} image(s)</small>
            </div>
            <!-- hero description -->

            <!-- hero actions -->
            <div class="d-flex gap-2">
                <a href="{{ route('admin.heroes.edit', $hero) }}" class="btn btn-sm btn-primary">
                    <i class="ri-edit-line me-1"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteHero({{ $hero->id }})">
                    <i class="ri-delete-bin-line me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

        <p>Description: {{ $hero->description }}</p>
        <!-- Masonry Gallery (no card container) -->
        @if($hero->images && count($hero->images) > 0)
        <div class="masonry">
            @foreach($hero->images as $index => $image)
            <div class="masonry-item" id="masonry-{{ $index }}">
                <img src="{{ Storage::url($image) }}" class="masonry-img" data-src="{{ Storage::url($image) }}" alt="Hero image">
                <button type="button" class="masonry-remove" title="Remove image"
                        onclick="removeImage({{ $hero->id }}, {{ $index }})">
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
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="ri-image-line text-muted" style="font-size: 3rem;"></i>
            <h4 class="text-muted mt-3">No Hero Section Found</h4>
            <p class="text-muted">Create your hero section with beautiful images to get started.</p>
            <a href="{{ route('admin.heroes.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Create Hero Section
            </a>
        </div>
    </div>
    @endforelse
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
                Are you sure you want to delete this hero section? This action cannot be undone.
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
.card.hero-card { border: 1px solid #eef0f4; border-radius: 16px; overflow: hidden; }
.thumb-wrap { position: relative; border-radius: 10px; overflow: hidden; }
.thumb-wrap img { display: block; }
.res-badge {
    position: absolute; left: 8px; bottom: 8px; padding: 2px 8px;
    font-size: 0.75rem; font-weight: 600; color: #0b1324;
    background: rgba(255,255,255,0.9); border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* Horizontal gallery (no outer card) */
.masonry {
    display: flex;
    flex-wrap: nowrap;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 8px;
    scroll-snap-type: x mandatory;
}
.masonry-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 16px rgba(18, 38, 63, .06);
    flex: 0 0 auto;
    scroll-snap-align: start;
}
.masonry-img {
    height: 240px;
    width: auto;
    display: block;
    object-fit: contain;
    background: #f7f9fc;
}
.masonry-remove {
    position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; border-radius: 50%;
    border: none; background: rgba(220,53,69,0.92); color: #fff; display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: scale(0.85); transition: all .2s ease; box-shadow: 0 2px 8px rgba(220,53,69,.35);
}
.masonry-item:hover .masonry-remove { opacity: 1; transform: scale(1); }
.masonry-item .res-badge { left: 8px; bottom: 8px; }
</style>
<script>
let heroToDelete = null;

function deleteHero(heroId) {
    heroToDelete = heroId;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!heroToDelete) return;

    // Show loading state
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

    // Send AJAX delete request
    fetch(`/admin/heroes/${heroToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
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
            // Show success message
            showAlert('success', data.message);

            // Remove the card from DOM
            const triggerBtn = document.querySelector(`[onclick="deleteHero(${heroToDelete})"]`);
            const cardCol = triggerBtn ? triggerBtn.closest('.col-lg-8, .col-xl-6, .col-md-6') : null;
            if (cardCol) { cardCol.remove(); }

            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();

            // Check if no more heroes
            if (document.querySelectorAll('.card.h-100').length === 0) {
                location.reload(); // Reload to show empty state
            }
        } else {
            // Handle different types of errors
            if (data.redirect) {
                // Handle authentication redirect
                showAlert('warning', data.message || 'Authentication required');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                showAlert('danger', data.message || 'Error deleting hero section');
            }
        }
    })
    .catch(error => {
        showAlert('danger', `Error: ${error.message}`);
    })
    .finally(() => {
        // Reset button state
        this.disabled = false;
        this.innerHTML = 'Delete';
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
// Remove single image from gallery (index page)
function removeImage(heroId, imageIndex) {
    if (!confirm('Remove this image?')) return;
    fetch(`/admin/heroes/${heroId}/images/${imageIndex}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) throw new Error(data.message || 'Failed');
        const item = document.getElementById(`gallery-${imageIndex}`);
        if (item) { item.style.opacity = '0'; item.style.transform = 'scale(.9)'; setTimeout(()=>item.remove(), 180); }
        const counter = document.getElementById(`imageCount-${heroId}`);
        if (counter) counter.textContent = `${data.remaining_images} image(s)`;
        showAlert('success', 'Image removed successfully');
    })
    .catch(err => showAlert('danger', err.message));
}
// Compute and render image resolutions
function applyResolutionBadges() {
    const thumbs = document.querySelectorAll('.hero-thumb, .masonry-img');
    thumbs.forEach(img => {
        const setBadge = () => {
            try {
                const w = img.naturalWidth || 0;
                const h = img.naturalHeight || 0;
                const parent = img.parentElement;
                const badge = parent ? parent.querySelector('.res-badge') : null;
                if (badge && w && h) { badge.textContent = `${w} × ${h}`; }
            } catch (e) { /* noop */ }
        };
        if (img.complete) {
            setBadge();
        } else {
            img.addEventListener('load', setBadge, { once: true });
            img.addEventListener('error', () => {
                const badge = img.parentElement.querySelector('.res-badge');
                if (badge) { badge.textContent = '–'; }
            }, { once: true });
        }
    });
}

document.addEventListener('DOMContentLoaded', applyResolutionBadges);
</script>
@endpush
