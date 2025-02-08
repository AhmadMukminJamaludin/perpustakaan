<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Landing Page')</title>
  <!-- Bootstrap & AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <!-- jQuery (Wajib untuk AdminLTE) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  @stack('styles')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ url('/') }}" class="navbar-brand">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Perpustakaan Online') }}</span>
      </a>
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">Beranda</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Booking</a>
          </li>
          <!-- Tambahkan link lain jika diperlukan -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Informasi tambahan
    </div>
    <strong>&copy; {{ date('Y') }} {{ config('app.name', 'Perpustakaan Online') }}.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>
