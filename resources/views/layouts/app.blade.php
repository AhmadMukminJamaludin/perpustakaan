<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap & AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- jQuery (Wajib untuk AdminLTE) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.2.3/dist/select2-bootstrap4.min.css">
    <!-- jQuery ConfirmJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    @vite(['resources/js/app.js'])
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed {{ request()->is('transaksi/peminjaman*') ? 'sidebar-collapse' : '' }}" style="font-size: 12px;">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @if(session('success'))
                    <blockquote class="quote-success">
                        <h5 id="note">Berhasil!</h5>
                        <p>{{ session('success') }}</p>
                    </blockquote>
                    @endif

                    @if(session('error'))
                    <blockquote class="quote-danger">
                        <h5 id="note">Terjadi Kesalahan!</h5>
                        <p>{{ session('error') }}</p>
                    </blockquote>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (localStorage.getItem("sidebar-collapsed") === "true") {
                document.body.classList.add("sidebar-collapse");
            }
        
            $('[data-widget="pushmenu"]').on("click", function () {
                let isCollapsed = document.body.classList.contains("sidebar-collapse");
                localStorage.setItem("sidebar-collapsed", !isCollapsed);
            });
        });
    </script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@stack('scripts')        
</body>
</html>
