@extends('layouts.admin')

@section('page_title', 'Users')
@section('content')
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">Users</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">Create User</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="users-table" class="table table-striped table-hover w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(function () {
    const table = $('#users-table').DataTable({
      processing: true,
      ajax: {
        url: '{{ route('admin.users.data') }}',
        dataSrc: ''
      },
      columns: [
        { data: null, render: (data, type, row, meta) => meta.row + 1, width: '60px' },
        { data: 'name' },
        { data: 'email' },
        { data: 'created_at' },
        { data: 'actions', orderable: false, searchable: false, width: '160px' }
      ],
      order: [[3, 'desc']],
      pageLength: 10,
    });
  });
</script>
@endpush
