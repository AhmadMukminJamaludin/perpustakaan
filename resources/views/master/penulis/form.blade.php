@extends('layouts.app')

@section('title', isset($penulis) ? 'Edit Penulis' : 'Tambah Penulis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Mengatur agar form berada di tengah -->
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($penulis) ? 'Edit Penulis' : 'Tambah Penulis' }}
                    </h3>
                </div>
                <!-- Mulai Form -->
                <form action="{{ isset($penulis) ? route('penulis.update', $penulis->id) : route('penulis.store') }}" method="POST">
                    @csrf
                    @if(isset($penulis))
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <!-- Nama Penulis -->
                        <div class="form-group">
                            <label for="nama">Nama Penulis</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $penulis->nama ?? '') }}" required>
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $penulis->email ?? '') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                                   value="{{ old('telepon', $penulis->telepon ?? '') }}">
                            @error('telepon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $penulis->bio ?? '') }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('penulis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
</div>
@endsection
