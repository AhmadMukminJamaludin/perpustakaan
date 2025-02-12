@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="jumbotron">
    <h1 class="display-4">Selamat Datang di Perpustakaan Digital!</h1>
    <p class="lead">Temukan berbagai koleksi buku favoritmu dan kelola peminjaman dengan mudah.</p>
    <hr class="my-4">
    <p>Gunakan fitur pencarian untuk menemukan buku yang Anda inginkan dan periksa status peminjaman Anda.</p>
    <a class="btn btn-primary" href="{{ url('/') }}" role="button">Lihat Koleksi Buku</a>
</div>  
@endsection