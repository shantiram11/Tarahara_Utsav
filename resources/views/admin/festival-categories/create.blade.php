@extends('layouts.admin')

@section('page_title', 'Create TU Honours')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create TU Honours</h5>
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
        <form method="POST" action="{{ route('admin.festival-categories.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            <div class="form-text">Brief description for the category card (max 500 characters)</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="6">{{ old('content') }}</textarea>
            <div class="form-text">Detailed content for the blog-like detail page (optional)</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Image <span class="text-danger">*</span></label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <div class="form-text">Upload an image for the category (JPG, PNG, WEBP, max 2MB)</div>
          </div>

          <div class="mb-3 ">
            <label class="form-label">Color Scheme <span class="text-danger">*</span></label>
            <select name="color_scheme" class="form-select" required>
              <option value="">Select a color scheme</option>
              <option value="violet" {{ old('color_scheme') == 'violet' ? 'selected' : '' }}>Violet</option>
              <option value="rose" {{ old('color_scheme') == 'rose' ? 'selected' : '' }}>Rose</option>
              <option value="emerald" {{ old('color_scheme') == 'emerald' ? 'selected' : '' }}>Emerald</option>
              <option value="amber" {{ old('color_scheme') == 'amber' ? 'selected' : '' }}>Amber</option>
              <option value="indigo" {{ old('color_scheme') == 'indigo' ? 'selected' : '' }}>Indigo</option>
              <option value="pink" {{ old('color_scheme') == 'pink' ? 'selected' : '' }}>Pink</option>
              <option value="blue" {{ old('color_scheme') == 'blue' ? 'selected' : '' }}>Blue</option>
              <option value="green" {{ old('color_scheme') == 'green' ? 'selected' : '' }}>Green</option>
              <option value="red" {{ old('color_scheme') == 'red' ? 'selected' : '' }}>Red</option>
              <option value="yellow" {{ old('color_scheme') == 'yellow' ? 'selected' : '' }}>Yellow</option>
            </select>
          </div>



          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.festival-categories.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
