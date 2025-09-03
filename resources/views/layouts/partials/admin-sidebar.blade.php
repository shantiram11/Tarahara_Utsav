<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
  <a href="{{ route('admin.dashboard') }}"
   class="text-decoration-none text-white sidebar-brand d-flex align-items-center gap-2">
    <img src="{{ asset('assets/dashboard.png') }}"
         alt="Tarahara Utsav"
         style="width: 180px; height: 60px; object-fit: contain;">
</a>


  <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="nav-icon ri-dashboard-line"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!-- Hero -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.heroes.index') ? 'active' : '' }}" href="{{ route('admin.heroes.index') }}">
        <i class="nav-icon ri-home-2-line"></i>
        <span>Manage Hero Section</span>
      </a>
    </li>

    <!-- About -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}" href="{{ route('admin.about.index') }}">
        <i class="nav-icon ri-information-line"></i>
        <span>Manage About Section</span>
      </a>
    </li>

    <!-- Sponsors -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" href="{{ route('admin.sponsors.index') }}">
        <i class="nav-icon ri-hand-coin-line"></i>
        <span>Manage Sponsors</span>
      </a>
    </li>

    <!-- Festival Categories -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('admin.festival-categories.*') ? 'active' : '' }}" href="{{ route('admin.festival-categories.index') }}">
        <i class="nav-icon ri-calendar-event-line"></i>
        <span>Festival Categories</span>
      </a>
    </li>

    <li class="nav-group">
      <a class="nav-link nav-group-toggle" href="#">
        <i class="nav-icon ri-team-line"></i>
        <span>Users</span>
      </a>
      <ul class="nav-group-items">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="nav-icon ri-list-check"></i>
            <span>List</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">
            <i class="nav-icon ri-user-add-line"></i>
            <span>Create</span>
          </a>
        </li>
      </ul>
    </li>




    <li class="nav-group">
      <a class="nav-link nav-group-toggle" href="#">
        <i class="nav-icon ri-user-3-line"></i>
        <span>Profile</span>
      </a>
      <ul class="nav-group-items">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}" href="{{ route('admin.profile.edit') }}">
            <i class="nav-icon ri-user-settings-line"></i>
            <span>Edit Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.password.edit') ? 'active' : '' }}" href="{{ route('admin.password.edit') }}">
            <i class="nav-icon ri-lock-password-line"></i>
            <span>Change Password</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item mt-auto">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="nav-icon ri-arrow-go-back-line"></i>
        <span>Back to site</span>
      </a>
    </li>
  </ul>
</div>
