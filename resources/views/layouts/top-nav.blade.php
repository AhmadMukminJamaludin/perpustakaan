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
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
  
  <!-- jQuery (Wajib untuk AdminLTE) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

  <!-- jQuery ConfirmJS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

  <style>
    .cart-items {
        max-height: 400px;
        overflow-y: auto;
    }
    .cart-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .cart-image {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
    .cart-info {
        flex-grow: 1;
    }
  </style>
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
                  <a type="button" class="nav-link cart-button">
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
  
  $(document).ready(function () {
      // Event klik pada ikon keranjang
      $('.cart-button').on('click', function () {
          axios.get('{{ route('cart.view') }}') // Pastikan route ini sesuai dengan controller
              .then(response => {
                  var cartItems = response.data.cart_items;

                  if (cartItems.length === 0) {
                      $.alert('Keranjang kosong.');
                      return;
                  }

                  var cartContent = '<div class="cart-items">';
                  cartItems.forEach(item => {
                      cartContent += `
                          <div class="cart-item" data-id="${item.id}">
                              <img src="${item.sampul}" alt="${item.judul}" class="cart-image"/>
                              <div class="cart-info">
                                  <h5>${item.judul}</h5>
                                  <p>Penulis: ${item.penulis}</p>
                                  <button class="btn btn-danger btn-sm remove-from-cart" data-id="${item.id}">Hapus</button>
                              </div>
                          </div>
                          <hr>
                      `;
                  });
                  cartContent += '</div>';

                  // Tampilkan modal dengan isi cart
                  $.confirm({
                      title: 'Keranjang Buku',
                      content: cartContent,
                      columnClass: 'medium',
                      buttons: {
                          checkout: {
                              text: 'Pinjam',
                              btnClass: 'btn-blue',
                              action: function () {
                                var bukuIds = [];
                                let cartItem = $(this).closest('.cart-item');
                                this.$content.find('.cart-item').each(function () {
                                    var id = $(this).data('id');
                                    bukuIds.push(id);
                                });

                                if (bukuIds.length === 0) {
                                    $.alert('Keranjang kosong.');
                                    return false;
                                }

                                var tanggalPinjam = new Date().toISOString().split('T')[0];

                                axios.post('{{ route('peminjaman.store') }}', {
                                    buku_ids: bukuIds,
                                    tanggal_pinjam: tanggalPinjam
                                })
                                .then(function (res) {
                                    $.alert('Buku berhasil dipinjam!');
                                    setInterval(() => {
                                      window.location.reload();
                                    }, 2000);
                                })
                                .catch(function (error) {
                                    $.alert(error.response?.data?.message || "Terjadi kesalahan!");
                                });

                                return false;
                              }
                          },
                          close: {
                              text: 'Tutup',
                              btnClass: 'btn-red',
                              action: function () {}
                          }
                      }
                  });

                  $(document).off('click', '.remove-from-cart').on('click', '.remove-from-cart', function () {                    
                    var bukuId = $(this).data('id');
                    let cartItem = $(this).closest('.cart-item');

                      axios.post('{{ route('cart.remove') }}', { buku_id: bukuId })
                          .then(response => {
                              $.alert('Buku dihapus dari keranjang.');
                              cartItem.remove();
                              $('#cart-count').text(response.data.cart_count);
                          })
                          .catch(error => {
                              $.alert('Gagal menghapus buku.');
                          });
                  });
              })
              .catch(error => {
                  $.alert('Gagal mengambil data cart.');
              });
      });
  });
</script>

@stack('scripts')
</body>
</html>
