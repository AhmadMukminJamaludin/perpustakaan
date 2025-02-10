@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h2 class="font-weight-bold mb-1">Halo, {{ auth()->user()->name }} 👋</h2>
    <p class="text-muted mb-0">Selamat datang di perpustakaan, nikmati koleksi buku kami!</p>
</div>
@endsection