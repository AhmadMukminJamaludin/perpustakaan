@extends('layouts.app')

@section('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku' }}</h3>
                </div>
                
                <form action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}" method="POST">
                    @csrf
                    @if(isset($buku)) @method('PUT') @endif
                    
                    <div class="card-body">
                        <!-- Judul Buku -->
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" id="isbn" 
                                   value="{{ old('isbn', $buku->isbn ?? '') }}" required>
                            @error('isbn')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Judul Buku -->
                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" id="judul" 
                                   value="{{ old('judul', $buku->judul ?? '') }}" required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penulis dengan Select2 -->
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <select name="penulis_id" class="form-control select2 @error('penulis_id') is-invalid @enderror">
                                <option value="">-- Pilih Penulis --</option>
                                @foreach($penulis as $p)
                                    <option value="{{ $p->id }}" {{ (old('penulis_id', $buku->penulis_id ?? '') == $p->id) ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penulis_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penerbit dengan Select2 -->
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <select name="penerbit_id" class="form-control select2 @error('penerbit_id') is-invalid @enderror">
                                <option value="">-- Pilih Penerbit --</option>
                                @foreach($penerbit as $p)
                                    <option value="{{ $p->id }}" {{ (old('penerbit_id', $buku->penerbit_id ?? '') == $p->id) ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penerbit_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kategori dengan Select2 -->
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori_id" class="form-control select2 @error('kategori_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ (old('kategori_id', $buku->kategori_id ?? '') == $k->id) ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tahun Terbit -->
                        <div class="form-group">
                            <label for="tahun_terbit">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" 
                                   id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
                            @error('tahun_terbit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" value="{{ old('harga', $buku->harga ?? '') }}" required>
                            @error('harga')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih salah satu",
            allowClear: true
        });
    });
</script>
@endpush

