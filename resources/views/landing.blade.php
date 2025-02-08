@extends('layouts.top-nav')

@section('title', 'Selamat Datang di Perpustakaan Online')

@section('content')
    <div id="landing-booking"></div>
@endsection

@push('scripts')
    @vite('resources/js/app.jsx')
@endpush
