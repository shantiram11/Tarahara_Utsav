@extends('layouts.admin')

@section('page_title', 'Edit TU Honours')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit TU Honours</h5>
        <a href="{{ route('admin.festival-categories.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
      </div>
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route('admin.festival-categories.update', $festivalCategory) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $festivalCategory->title) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $festivalCategory->description) }}</textarea>
            <div class="form-text">Brief description for the category card (max 500 characters)</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="6">{{ old('content', $festivalCategory->content) }}</textarea>
            <div class="form-text">Detailed content for the blog-like detail page (optional)</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div class="d-flex align-items-center gap-3">
              <img src="{{ Storage::url($festivalCategory->image) }}" alt="{{ $festivalCategory->title }}"
                   class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
              <div>
                <p class="text-muted mb-1">Current category image</p>
                <p class="text-muted small mb-0">Upload a new image below to replace it</p>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">New Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <div class="form-text">Upload a new image for the category (JPG, PNG, WEBP, max 2MB) - optional for updates</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Color Scheme <span class="text-danger">*</span></label>
            <select name="color_scheme" class="form-select" required>
              <option value="">Select a color scheme</option>
              <option value="violet" {{ old('color_scheme', $festivalCategory->color_scheme) == 'violet' ? 'selected' : '' }}>Violet</option>
              <option value="rose" {{ old('color_scheme', $festivalCategory->color_scheme) == 'rose' ? 'selected' : '' }}>Rose</option>
              <option value="emerald" {{ old('color_scheme', $festivalCategory->color_scheme) == 'emerald' ? 'selected' : '' }}>Emerald</option>
              <option value="amber" {{ old('color_scheme', $festivalCategory->color_scheme) == 'amber' ? 'selected' : '' }}>Amber</option>
              <option value="indigo" {{ old('color_scheme', $festivalCategory->color_scheme) == 'indigo' ? 'selected' : '' }}>Indigo</option>
              <option value="pink" {{ old('color_scheme', $festivalCategory->color_scheme) == 'pink' ? 'selected' : '' }}>Pink</option>
              <option value="blue" {{ old('color_scheme', $festivalCategory->color_scheme) == 'blue' ? 'selected' : '' }}>Blue</option>
              <option value="green" {{ old('color_scheme', $festivalCategory->color_scheme) == 'green' ? 'selected' : '' }}>Green</option>
              <option value="red" {{ old('color_scheme', $festivalCategory->color_scheme) == 'red' ? 'selected' : '' }}>Red</option>
              <option value="yellow" {{ old('color_scheme', $festivalCategory->color_scheme) == 'yellow' ? 'selected' : '' }}>Yellow</option>
            </select>
          </div>



          <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="d-flex gap-4">
              <div class="form-check">
                <input type="radio" class="form-check-input" name="is_active" value="1"
                       id="active" {{ old('is_active', $festivalCategory->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="is_active" value="0"
                       id="inactive" {{ !old('is_active', $festivalCategory->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="inactive">Inactive</label>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.festival-categories.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
