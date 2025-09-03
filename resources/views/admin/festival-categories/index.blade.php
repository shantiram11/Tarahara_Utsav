@extends('layouts.admin')

@section('page_title', 'Festival Categories')
@section('content')
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">Festival Categories</h5>
    <a href="{{ route('admin.festival-categories.create') }}" class="btn btn-sm btn-success">Create Category</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="categories-table" class="table table-striped table-hover w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Color</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <img src="{{ Storage::url($category->image) }}" alt="{{ $category->title }}"
                   class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
            </td>
            <td>{{ $category->title }}</td>
            <td>{{ Str::limit($category->description, 50) }}</td>
            <td>
              <span class="badge bg-light text-dark border">
                {{ ucfirst($category->color_scheme) }}
              </span>
            </td>
            <td>
              <button type="button" class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-secondary' }}"
                      onclick="toggleStatus({{ $category->id }})">
                {{ $category->is_active ? 'Active' : 'Inactive' }}
              </button>
            </td>

            <td>{{ $category->created_at->format('M d, Y') }}</td>
            <td>
              <div class="btn-group" role="group">
                <a href="{{ route('admin.festival-categories.show', $category) }}"
                   class="btn btn-sm btn-info" title="View">
                  <i class="ri-eye-line"></i>
                </a>
                <a href="{{ route('admin.festival-categories.edit', $category) }}"
                   class="btn btn-sm btn-warning" title="Edit">
                  <i class="ri-edit-line"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="deleteCategory({{ $category->id }})" title="Delete">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
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
                Are you sure you want to delete this festival category? This action cannot be undone.
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
<script>
let categoryToDelete = null;

function toggleStatus(categoryId) {
    fetch(`/admin/festival-categories/${categoryId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating category status');
    });
}

function deleteCategory(categoryId) {
    categoryToDelete = categoryId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!categoryToDelete) return;

    // Show loading state
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

    fetch(`/admin/festival-categories/${categoryToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the category');
    })
    .finally(() => {
        // Reset button state
        this.disabled = false;
        this.innerHTML = 'Delete';

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
    });
});
</script>
@endpush
