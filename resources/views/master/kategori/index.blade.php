@extends('layouts.app')

@section('title', 'Master Data Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card Wrapper -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kategori</h3>
                <div class="card-tools">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table-kategori" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                <!-- Jika menggunakan pagination -->
                <div class="mt-3">
                    {{ $kategori->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('scripts')
<!-- Pastikan jQuery dan DataTables sudah dimuat, misalnya melalui CDN di layout utama -->
<script>
    $(document).ready(function () {
        $('#table-kategori').DataTable();
    });
</script>
@endpush
