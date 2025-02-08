@extends('layouts.app')

@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menggunakan lebar kolom 6 dan di-offset agar berada di tengah -->
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h3>
                </div>
                <!-- Form mulai -->
                <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}" method="POST">
                    @csrf
                    @if(isset($kategori))
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <!-- Field Nama Kategori -->
                        <div class="form-group">
                            <label for="nama">Nama Kategori</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $kategori->nama ?? '') }}" required>
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Field Deskripsi -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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
