@extends('layouts.app')

@section('title', isset($penerbit) ? 'Edit Penerbit' : 'Tambah Penerbit')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Mengatur kolom agar berada di tengah -->
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($penerbit) ? 'Edit Penerbit' : 'Tambah Penerbit' }}
                    </h3>
                </div>
                <!-- Mulai Form -->
                <form action="{{ isset($penerbit) ? route('penerbit.update', $penerbit->id) : route('penerbit.store') }}" method="POST">
                    @csrf
                    @if(isset($penerbit))
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <!-- Field Nama Penerbit -->
                        <div class="form-group">
                            <label for="nama">Nama Penerbit</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $penerbit->nama ?? '') }}" required>
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Field Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $penerbit->email ?? '') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Field Telepon -->
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon', $penerbit->telepon ?? '') }}">
                            @error('telepon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Field Alamat -->
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $penerbit->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
                <!-- /.form -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
