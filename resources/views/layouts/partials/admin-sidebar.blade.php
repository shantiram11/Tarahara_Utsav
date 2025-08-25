<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
  <div class="sidebar-brand d-none d-md-flex align-items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-white sidebar-brand">{{ config('app.name', 'Tarahara Utsav') }}</a>
  </div>
  <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="nav-icon fa-solid fa-gauge"></i>
        Dashboard
      </a>
    </li>

    <li class="nav-group">
      <a class="nav-link nav-group-toggle" href="#">
        <i class="nav-icon fa-solid fa-users"></i>
        Users
      </a>
      <ul class="nav-group-items">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="nav-icon fa-solid fa-list"></i>
            List
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users.create') }}">
            <i class="nav-icon fa-solid fa-plus"></i>
            Create
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-group">
      <a class="nav-link nav-group-toggle" href="#">
        <i class="nav-icon fa-solid fa-user"></i>
        Profile
      </a>
      <ul class="nav-group-items">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.profile.edit') }}">
            <i class="nav-icon fa-solid fa-user-pen"></i>
            Edit Profile
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.password.edit') }}">
            <i class="nav-icon fa-solid fa-lock"></i>
            Change Password
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item mt-auto">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
        Back to site
      </a>
    </li>
  </ul>
</div>
