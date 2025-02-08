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
            <div class="card h-100">
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
                    <a href="#" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Booking
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-search mr-2"></i>
                        Detail
                    </a>
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