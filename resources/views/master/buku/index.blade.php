@extends('layouts.app')

@section('title', 'Master Data Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Daftar Buku</h3>
                    <div class="card-tools">
                        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm" style="font-size: 10px">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-buku" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Sampul</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Total Stok</th>
                                <th>Sisa Stok</th>
                                <th>Total Dipinjam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-center align-middle">
                                    @php
                                        $sampulUrl = 'https://placehold.jp/200x200.png';
                                        if(isset($item) && !empty($item->path) && file_exists(public_path('storage/' . $item->path))){
                                            $sampulUrl = asset('storage/' . $item->path);
                                        }
                                    @endphp
                                    <img id="sampulPreview" src="{{ $sampulUrl }}" alt="Preview Sampul" style="max-height: 75px;">
                                </td>
                                <td><b>{{ $item->judul }}</b> <br>
                                    <small><b>Penerbit:</b> {{ $item->penerbit->nama }}</small> <br>
                                    <small><b>ISBN:</b> {{ $item->isbn }}</small>
                                </td>
                                <td>{{ $item->kategori->nama }}</td>
                                <td>{{ $item->penulis->nama }}</td>
                                <td class="text-right">{{ $item->tahun_terbit }}</td>
                                <td class="text-right">{{ $item->stok }}</td>
                                <td class="text-right">{{ $item->sisa_stok }}</td>
                                <td class="text-right">{{ $item->jumlah_dipinjam }}</td>
                                <td>
                                    @if ($item->jumlah_dipinjam > 0)
                                        <button class="btn btn-primary btn-xs btn-lihat-peminjam" 
                                            data-id="{{ $item->id }}" style="font-size: 10px">
                                            <i class="fas fa-eye"></i> Lihat Peminjam
                                        </button>
                                    @endif
                                    <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-warning btn-xs" style="font-size: 10px">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" style="font-size: 10px">
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

<div class="modal fade" id="modalPeminjam" tabindex="-1" role="dialog" aria-labelledby="modalPeminjamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPeminjamLabel">Riwayat Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody id="peminjamList">
                        <tr>
                            <td colspan="3" class="text-center">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
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

    $(document).on("click", ".btn-lihat-peminjam", function () {
        let bukuId = $(this).data("id"); // Ambil ID buku dari tombol
        let modalBody = $("#peminjamList");

        // Kosongkan isi modal & tampilkan loading
        modalBody.html('<tr><td colspan="3" class="text-center">Memuat data...</td></tr>');

        // Panggil API untuk mendapatkan daftar peminjam
        axios.get(`/master/buku/${bukuId}/peminjam`)
            .then(response => {
                let peminjaman = response.data;
                let rows = "";

                if (peminjaman.length > 0) {
                    peminjaman.forEach(p => {
                        rows += `
                            <tr>
                                <td>${p.user}</td>
                                <td>${p.tanggal_pinjam}</td>
                                <td>${p.tanggal_kembali ?? 'Menunggu verifikasi'}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="3" class="text-center">Tidak ada riwayat peminjaman.</td></tr>';
                }

                modalBody.html(rows);
            })
            .catch(error => {
                modalBody.html('<tr><td colspan="3" class="text-center text-danger">Gagal memuat data!</td></tr>');
                console.error("Error:", error);
            });

        // Tampilkan modal
        $("#modalPeminjam").modal("show");
    });
</script>
@endpush
