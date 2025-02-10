@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Profil Saya</h5>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Peran</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->getRoleNames()->first() }}" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label>Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
