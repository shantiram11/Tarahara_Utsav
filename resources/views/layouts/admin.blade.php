<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - {{ config('app.name', 'Tarahara Utsav') }}</title>
  <!-- CoreUI and Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.1/dist/css/coreui.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
  <style>
    body { background-color: #f5f6f8; }
    .sidebar-brand { font-weight: 700; letter-spacing: .3px; }
    :root { --admin-sidebar-width: 260px; }
    #sidebar { width: var(--admin-sidebar-width); }
    .sidebar .nav-group-items .nav-link { padding-top: .35rem; padding-bottom: .35rem; font-size: .9rem; }
    .sidebar .nav-group-items .nav-icon { width: 1rem; height: 1rem; }
    @media (min-width: 992px) {
      .wrapper { margin-left: var(--admin-sidebar-width); }
    }
  </style>
</head>
<body class="sidebar-fixed">
  @include('layouts.partials.admin-sidebar')
  <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
      <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
          <i class="icon icon-lg fa-solid fa-bars"></i>
        </button>
        <a class="header-brand d-md-none" href="#">Admin</a>
        <ul class="header-nav ms-3">
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
        </ul>
        <ul class="header-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fa-solid fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
              <div class="dropdown-header bg-light py-2">
                <strong>{{ auth()->user()->name ?? 'Profile' }}</strong>
              </div>
              <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                <i class="fa-solid fa-user me-2"></i>
                Edit Profile
              </a>
              <a class="dropdown-item" href="{{ route('admin.password.edit') }}">
                <i class="fa-solid fa-lock me-2"></i>
                Change Password
              </a>
            </div>
          </li>
        </ul>
      </div>
      <div class="header-divider"></div>
      <div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item active"><span>@yield('page_title', 'Dashboard')</span></li>
          </ol>
        </nav>
      </div>
    </header>
    <div class="body flex-grow-1 px-3">
      <div class="container-lg">
        @yield('content')
      </div>
    </div>
    <footer class="footer">
      <div><a href="{{ route('home') }}">Back to site</a></div>
      <div class="ms-auto">Powered by CoreUI</div>
    </footer>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <!-- Bootstrap & CoreUI JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.1/dist/js/coreui.bundle.min.js" crossorigin="anonymous"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  @stack('scripts')
</body>
</html>
