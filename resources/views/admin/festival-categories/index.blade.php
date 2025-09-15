@extends('layouts.admin')

@section('page_title', 'TU Honours')
@section('content')
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">TU Honours</h5>
    <a href="{{ route('admin.festival-categories.create') }}" class="btn btn-sm btn-success">Create Category</a>
  </div>

  <!-- Search Bar -->
  <div class="card-body border-bottom">
    <div class="row">
      <div class="col-md-6">
        <div class="input-group">
          <input type="text" class="form-control" id="searchInput" placeholder="Search categories by title..." value="{{ request('search') }}">
          <button class="btn btn-outline-secondary" type="button" onclick="searchCategories()">
            <i class="ri-search-line"></i>
          </button>
          @if(request('search'))
            <button class="btn btn-outline-danger" type="button" onclick="clearSearch()">
              <i class="ri-close-line"></i>
            </button>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex gap-2">
          <select class="form-select" id="statusFilter" onchange="filterByStatus()">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          <select class="form-select" id="colorFilter" onchange="filterByColor()">
            <option value="">All Colors</option>
            <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Blue</option>
            <option value="green" {{ request('color') == 'green' ? 'selected' : '' }}>Green</option>
            <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Red</option>
            <option value="purple" {{ request('color') == 'purple' ? 'selected' : '' }}>Purple</option>
            <option value="orange" {{ request('color') == 'orange' ? 'selected' : '' }}>Orange</option>
            <option value="pink" {{ request('color') == 'pink' ? 'selected' : '' }}>Pink</option>
          </select>
        </div>
      </div>
    </div>
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
                Are you sure you want to delete this TU Honours? This action cannot be undone.
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

// Search and Filter Functions
function searchCategories() {
    const searchTerm = document.getElementById('searchInput').value;
    const url = new URL(window.location);

    if (searchTerm.trim()) {
        url.searchParams.set('search', searchTerm);
    } else {
        url.searchParams.delete('search');
    }

    window.location.href = url.toString();
}

function clearSearch() {
    const url = new URL(window.location);
    url.searchParams.delete('search');
    url.searchParams.delete('status');
    url.searchParams.delete('color');
    window.location.href = url.toString();
}

function filterByStatus() {
    const status = document.getElementById('statusFilter').value;
    const url = new URL(window.location);

    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }

    window.location.href = url.toString();
}

function filterByColor() {
    const color = document.getElementById('colorFilter').value;
    const url = new URL(window.location);

    if (color) {
        url.searchParams.set('color', color);
    } else {
        url.searchParams.delete('color');
    }

    window.location.href = url.toString();
}

// Allow Enter key to trigger search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchCategories();
    }
});

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
