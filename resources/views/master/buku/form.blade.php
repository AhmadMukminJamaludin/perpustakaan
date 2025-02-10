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
        <form action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($buku))
            @method('PUT')
          @endif
          <div class="card-body">
            <!-- Field ISBN -->
            <div class="form-group">
              <label for="isbn">ISBN</label>
              <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $buku->isbn ?? '') }}" required>
              @error('isbn')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Judul Buku -->
            <div class="form-group">
              <label for="judul">Judul Buku</label>
              <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul ?? '') }}" required>
              @error('judul')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Unggah Sampul -->
            <div class="form-group">
                <label for="sampul">Unggah Sampul Buku</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('sampul') is-invalid @enderror" name="sampul" id="sampul" >
                        <label class="custom-file-label" for="sampul">Choose file</label>
                    </div>
                </div>
              @error('sampul')
                <span class="invalid-feedback d-block">{{ $message }}</span>
              @enderror
            </div>

            <!-- Preview Sampul -->
            <div class="form-group">
              <label>Preview Sampul</label>
              <div>
                @php
                    $sampulUrl = 'https://placehold.jp/200x200.png';
                    if(isset($buku) && !empty($buku->path) && file_exists(public_path('storage/' . $buku->path))){
                        $sampulUrl = asset('storage/' . $buku->path);
                    }
                @endphp
                <img id="sampulPreview" src="{{ $sampulUrl }}" alt="Preview Sampul" style="max-height: 200px;">
              </div>
            </div>

            <!-- Field Penulis dengan Select2 -->
            <div class="form-group">
              <label for="penulis">Penulis</label>
              <select name="penulis_id" id="penulis" class="form-control select2 @error('penulis_id') is-invalid @enderror">
                <option value="">-- Pilih Penulis --</option>
                @foreach($penulis as $p)
                  <option value="{{ $p->id }}" {{ old('penulis_id', $buku->penulis_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }}
                  </option>
                @endforeach
              </select>
              @error('penulis_id')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Penerbit dengan Select2 -->
            <div class="form-group">
              <label for="penerbit">Penerbit</label>
              <select name="penerbit_id" id="penerbit" class="form-control select2 @error('penerbit_id') is-invalid @enderror">
                <option value="">-- Pilih Penerbit --</option>
                @foreach($penerbit as $p)
                  <option value="{{ $p->id }}" {{ old('penerbit_id', $buku->penerbit_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }}
                  </option>
                @endforeach
              </select>
              @error('penerbit_id')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Kategori dengan Select2 -->
            <div class="form-group">
              <label for="kategori">Kategori</label>
              <select name="kategori_id" id="kategori" class="form-control select2 @error('kategori_id') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                  <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id ?? '') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                  </option>
                @endforeach
              </select>
              @error('kategori_id')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Tahun Terbit -->
            <div class="form-group">
              <label for="tahun_terbit">Tahun Terbit</label>
              <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
              @error('tahun_terbit')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="stok">Stok</label>
              <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok ?? '') }}" required>
              @error('stok')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <!-- /.card-body -->

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

    // Preview gambar sampul ketika file diunggah
    $('#sampul').on('change', function(){
      const [file] = this.files;
      if (file) {
        $('#sampulPreview').attr('src', URL.createObjectURL(file));
      }
    });
  });
</script>
@endpush
