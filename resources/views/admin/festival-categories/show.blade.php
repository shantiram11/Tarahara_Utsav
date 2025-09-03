@extends('layouts.admin')

@section('page_title', 'View Festival Category')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">View Festival Category</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.festival-categories.edit', $festivalCategory) }}" class="btn btn-sm btn-warning">
            <i class="ri-edit-line me-1"></i>Edit
          </a>
          <a href="{{ route('admin.festival-categories.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="text-center mb-4">
              <img src="{{ Storage::url($festivalCategory->image) }}" alt="{{ $festivalCategory->title }}"
                   class="img-fluid rounded shadow" style="max-height: 300px;">
            </div>

            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Category Details</h6>
                <table class="table table-sm">
                  <tr>
                    <td><strong>Title:</strong></td>
                    <td>{{ $festivalCategory->title }}</td>
                  </tr>
                  <tr>
                    <td><strong>Slug:</strong></td>
                    <td><code>{{ $festivalCategory->slug }}</code></td>
                  </tr>
                  <tr>
                    <td><strong>Color Scheme:</strong></td>
                    <td>
                      <span class="badge bg-light text-dark border">
                        {{ ucfirst($festivalCategory->color_scheme) }}
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Status:</strong></td>
                    <td>
                      <span class="badge {{ $festivalCategory->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $festivalCategory->is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Created:</strong></td>
                    <td>{{ $festivalCategory->created_at->format('M d, Y H:i') }}</td>
                  </tr>
                  <tr>
                    <td><strong>Updated:</strong></td>
                    <td>{{ $festivalCategory->updated_at->format('M d, Y H:i') }}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="mb-4">
              <h4>{{ $festivalCategory->title }}</h4>
              <p class="text-muted">{{ $festivalCategory->description }}</p>
            </div>

            @if($festivalCategory->content)
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0">Detailed Content</h6>
              </div>
              <div class="card-body">
                <div class="content-preview">
                  {!! nl2br(e($festivalCategory->content)) !!}
                </div>
              </div>
            </div>
            @else
            <div class="alert alert-info">
              <i class="ri-information-line me-2"></i>
              No detailed content available for this category.
              <a href="{{ route('admin.festival-categories.edit', $festivalCategory) }}">Add content</a> to create a blog-like detail page.
            </div>
            @endif

            <div class="mt-4">
              <h6>Frontend Preview</h6>
              <div class="border rounded p-3 bg-light">
                <div class="d-flex align-items-center gap-3">
                  <img src="{{ Storage::url($festivalCategory->image) }}" alt="{{ $festivalCategory->title }}"
                       class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                  <div>
                    <h6 class="mb-1">{{ $festivalCategory->title }}</h6>
                    <p class="text-muted small mb-0">{{ Str::limit($festivalCategory->description, 100) }}</p>
                  </div>
                </div>
              </div>
              <div class="mt-2">
                <small class="text-muted">
                  <i class="ri-eye-line me-1"></i>
                  <a href="{{ route('festival-categories.show', $festivalCategory->slug) }}" target="_blank">
                    View on frontend
                  </a>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
