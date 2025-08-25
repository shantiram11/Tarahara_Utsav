@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="fs-6 text-muted">Welcome</div>
        <div class="fs-4 fw-semibold">Admin Panel</div>
        <small class="text-muted">Use the sidebar to navigate.</small>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body text-muted">
        Dashboard is currently minimal as requested.
      </div>
    </div>
  </div>
</div>
@endsection
