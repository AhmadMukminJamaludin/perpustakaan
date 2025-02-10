@extends('layouts.top-nav')

@section('title', 'Koleksi Buku')

@section('content')
<div class="container mt-4">
    <form method="GET" action="{{ route('landing') }}" class="mb-4">
        <div class="input-group mw-50">
            <input 
                type="text" 
                name="search" 
                class="form-control mw-50" 
                placeholder="Cari buku atau penulis..."
                value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>
    <div class="row">
        @foreach($bukuList as $buku)
        <div class="col-md-4 mb-4">
            <div class="card h-100 position-relative">
                @if ($buku->peminjaman_count == $maxPeminjaman && $buku->peminjaman_count > 0)
                    <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-danger text-md">
                            Terpopuler
                        </div>
                    </div>
                @endif
                <img 
                    class="card-img-top" 
                    src="{{ $buku->path ? asset('storage/' . $buku->path) : 'https://placehold.jp/200x300.png' }}" 
                    alt="{{ $buku->judul }}"
                    style="object-fit: cover; height: 300px;">
                
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $buku->judul }}</h5>
                    <p class="card-text"><strong>ISBN:</strong> {{ $buku->isbn }}</p>
                    <p class="card-text">
                        <strong>Penulis:</strong> {{ $buku->penulis->nama ?? 'Tidak diketahui' }}
                    </p>
                    <p class="card-text">
                        <strong>Penerbit:</strong> {{ $buku->penerbit->nama ?? 'Tidak diketahui' }}
                    </p>
                </div>
                <div class="card-footer">
                    @if ($buku->sisa_stok == 0)
                        <button class="btn btn-danger btn-block" disabled>
                            <i class="fas fa-ban mr-2"></i> Stok Kosong
                        </button>
                    @elseif (in_array($buku->id, $bukuDipinjam))
                        <button class="btn btn-secondary btn-block" disabled>Buku Sudah Dipinjam</button>
                    @else
                        <button class="btn btn-outline-primary btn-block btn-booking" data-id="{{ $buku->id }}">
                            <i class="fas fa-shopping-cart mr-2"></i> Booking
                        </button>
                        <button class="btn btn-outline-info btn-block btn-detail" 
                            data-judul="{{ $buku->judul }}" 
                            data-isbn="{{ $buku->isbn }}" 
                            data-penulis="{{ $buku->penulis->nama ?? 'Tidak diketahui' }}" 
                            data-penerbit="{{ $buku->penerbit->nama ?? 'Tidak diketahui' }}"
                            data-tahun="{{ $buku->tahun_terbit }}"
                            data-stok="{{ $buku->sisa_stok }}"
                            data-gambar="{{ $buku->path ? asset('storage/' . $buku->path) : 'https://placehold.jp/200x300.png' }}">
                            <i class="fas fa-eye mr-2"></i> Detail
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination Manual -->
    <div class="d-flex justify-content-center">
        @if ($bukuList->hasPages())
        <nav aria-label="Navigasi halaman">
            <ul class="pagination">
            {{-- Link Halaman Sebelumnya --}}
            @if ($bukuList->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                <a class="page-link" href="{{ $bukuList->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Elemen-elemen Pagination --}}
            @foreach ($bukuList->links()->elements as $element)
                @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ $element }}</span>
                </li>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $bukuList->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endif
                @endforeach
                @endif
            @endforeach

            {{-- Link Halaman Berikutnya --}}
            @if ($bukuList->hasMorePages())
                <li class="page-item">
                <a class="page-link" href="{{ $bukuList->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">&raquo;</span>
                </li>
            @endif
            </ul>
        </nav>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Fungsi untuk menambahkan buku ke cart
        $('.btn-booking').on('click', function () {
            var bukuId = $(this).data('id');

            axios.post('{{ route('cart.add') }}', {
                buku_id: bukuId
            })
            .then(response => {
                $('#cart-count').text(response.data.cart_count);
                $.alert('Buku berhasil ditambahkan ke keranjang!');
            })
            .catch(error => {
                if (error.response.status === 401) {
                    showLoginModal(bukuId);
                } else {
                    $.alert(error.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        function showLoginModal(bukuId) {
            $.confirm({
                title: 'Login Diperlukan',
                content: '' +
                    '<form id="login-form">' +
                    '<div class="form-group">' +
                    '<label>Email</label>' +
                    '<input type="email" id="email" placeholder="Masukkan email" class="form-control" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Password</label>' +
                    '<input type="password" id="password" placeholder="Masukkan password" class="form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    login: {
                        text: 'Login',
                        btnClass: 'btn-blue',
                        action: function () {
                            var email = $('#email').val();
                            var password = $('#password').val();
                            var modalInstance = this;

                            if (!email || !password) {
                                $.alert('Email dan password harus diisi.');
                                return false;
                            }

                            axios.post('{{ route('login') }}', {
                                email: email,
                                password: password
                            })
                            .then(response => {
                                $.alert('Login berhasil!');

                                updateNavbar(true);

                                updateCartCount();

                                modalInstance.close();
                                
                                addToCart(bukuId);
                            })
                            .catch(error => {
                                $.alert('Login gagal. Periksa email dan password.');
                            });

                            return false;
                        }
                    },
                    cancel: function () {}
                }
            });
        }

        function addToCart(bukuId) {
            axios.post('{{ route('cart.add') }}', {
                buku_id: bukuId
            })
            .then(response => {
                $('#cart-count').text(response.data.cart_count);
                $.alert('Buku berhasil ditambahkan ke cart!');
            })
            .catch(error => {
                $.alert(error.response?.data?.message || 'Terjadi kesalahan!');
            });
        }

        // Fungsi untuk memperbarui jumlah cart saat halaman dimuat
        function updateCartCount() {
            axios.get('{{ route('cart.count') }}')
            .then(response => {
                $('#cart-count').text(response.data.cart_count);
            })
            .catch(error => {
                console.error(error);
            });
        }

        updateCartCount();

        $('.btn-detail').on('click', function() {
            var judul = $(this).data('judul');
            var isbn = $(this).data('isbn');
            var penulis = $(this).data('penulis');
            var penerbit = $(this).data('penerbit');
            var tahun = $(this).data('tahun');
            var stok = $(this).data('stok');
            var gambar = $(this).data('gambar');

            $.confirm({
                title: 'Detail Buku',
                content: `
                    <div class="text-center">
                        <img src="${gambar}" alt="${judul}" style="width: 100px; height: 150px; object-fit: cover; border-radius: 5px;">
                        <h4 class="mt-3">${judul}</h4>
                        <hr>
                        <p><strong>ISBN:</strong> ${isbn}</p>
                        <p><strong>Penulis:</strong> ${penulis}</p>
                        <p><strong>Penerbit:</strong> ${penerbit}</p>
                        <p><strong>Tahun Terbit:</strong> ${tahun}</p>
                        <p><strong>Sisa Stok:</strong> ${stok}</p>
                    </div>
                `,
                columnClass: 'medium',
                buttons: {
                    close: {
                        text: 'Tutup',
                        btnClass: 'btn-red',
                        action: function () {}
                    }
                }
            });
        });
    });
</script>
@endpush

