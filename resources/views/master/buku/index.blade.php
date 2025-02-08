@extends('layouts.app')

@section('title', 'Master Data Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Buku</h3>
                    <div class="card-tools">
                        <a href="{{ route('buku.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-buku">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->judul }} <br>
                                    <small><b>Penerbit:</b> {{ $item->penerbit->nama }}</small> <br>
                                    <small><b>ISBN:</b> {{ $item->isbn }}</small>
                                </td>
                                <td>{{ $item->kategori->nama }}</td>
                                <td>{{ $item->penulis->nama }}</td>
                                <td>{{ $item->tahun_terbit }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table-buku').DataTable();
    });
</script>
@endpush
