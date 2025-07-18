<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('content')
    <div class="login-page"
        style="
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <div class="login-box text-center" style="width: 360px;">
            <div class="login-logo mb-4">
                {{-- Logo SMA Negeri 1 Gubug --}}
                <img src="{{ asset('vendor/logo.png') }}" alt="Logo SMA NEGERI 1 GUBUG"
                    style="width: 120px; height: auto; display: block; margin: 0 auto 15px;">
                {{-- Nama Sekolah --}}
                <h1
                    style="font-size: 2rem; font-weight: 600; color: #ffffff; text-shadow: 0 1px 4px rgba(0,0,0,0.6); margin: 0;">
                    PERPUSTAKAAN
                </h1>
                <h1
                    style="font-size: 2rem; font-weight: 600; color: #ffffff; text-shadow: 0 1px 4px rgba(0,0,0,0.6); margin: 0;">
                    SMA NEGERI 1 GUBUG
                </h1>
            </div>
            <div class="card" style="opacity: 0.95;">
                <div class="card-body login-card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>

                    <p class="mt-3 text-center">
                        <a href="{{ route('register') }}" style="color: #007bff;">Daftar member baru?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
