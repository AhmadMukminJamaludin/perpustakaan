<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Landing Page')</title>
  <!-- Bootstrap & AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <!-- jQuery (Wajib untuk AdminLTE) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

  <!-- jQuery ConfirmJS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
  @vite(['resources/js/app.js'])
  @stack('styles')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ url('/') }}" class="navbar-brand">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Perpustakaan Online') }}</span>
      </a>
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
              <li class="nav-item">
                  <a class="nav-link" href="#">
                      <i class="fa-solid fa-cart-shopping"></i>
                      <span class="badge badge-danger navbar-badge" id="cart-count"></span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}" id="auth-link">
                      <i class="fa-solid fa-right-to-bracket mr-2"></i>
                      Sign In
                  </a>
              </li>
          </ul>
      </div>       
    </div>
  </nav>
  
  <div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>@yield('title')</small></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>&copy; {{ date('Y') }} {{ config('app.name', 'Perpustakaan Online') }}.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
      // Cek status login tanpa refresh
      axios.get('{{ route('check.auth') }}')
          .then(response => {
              if (response.data.authenticated) {
                  updateNavbar(true, response.data.dashboard_url);
              }
          })
          .catch(error => {
              console.error("Error checking authentication:", error);
          });
  });

  function updateNavbar(isAuthenticated, dashboardUrl = '/dashboard') {
      let authLink = document.getElementById('auth-link');
      if (authLink) {
          if (isAuthenticated) {
              authLink.innerHTML = `<i class="fa-solid fa-user mr-2"></i> Dashboard`;
              authLink.href = dashboardUrl;
          } else {
              authLink.innerHTML = `<i class="fa-solid fa-right-to-bracket mr-2"></i> Sign In`;
              authLink.href = '{{ route('login') }}';
          }
      }
  }
</script>

@stack('scripts')
</body>
</html>
