@extends('layouts.app')

@section('title', 'Master Data Penerbit')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card Wrapper -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penerbit</h3>
                    <div class="card-tools">
                        <a href="{{ route('penerbit.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Penerbit
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-penerbit" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Penerbit</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penerbit as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>
                                        <a href="{{ route('penerbit.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('penerbit.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus penerbit ini?')">
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

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $penerbit->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Pastikan jQuery dan DataTables sudah dimuat, misalnya melalui CDN di layout utama -->
<script>
    $(document).ready(function () {
        $('#table-penerbit').DataTable();
    });
</script>
@endpush
