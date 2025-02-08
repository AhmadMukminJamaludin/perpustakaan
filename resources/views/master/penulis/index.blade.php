@extends('layouts.app')

@section('title', 'Master Data Penulis')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card Wrapper -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Penulis</h3>
                <div class="card-tools">
                    <a href="{{ route('penulis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Penulis
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-penulis" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penulis</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Bio</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penulis as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->bio }}</td>
                                <td>
                                    <a href="{{ route('penulis.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('penulis.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus penulis ini?')">
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

                <!-- Pagination (jika data banyak) -->
                <div class="mt-3">
                    {{ $penulis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Pastikan jQuery dan DataTables sudah dimuat di layout utama -->
<script>
    $(document).ready(function(){
        $('#table-penulis').DataTable();
    });
</script>
@endpush
