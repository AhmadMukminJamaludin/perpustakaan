@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="container-fluid mb-3">
        <a href="{{ route('laporan.peminjaman.exportExcel') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('laporan.peminjaman.printPdf') }}" class="btn btn-primary" target="_blank">
            <i class="fas fa-print"></i> Print PDF
        </a>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Peminjaman</h3>
        </div>
        <div class="card-body table-responsive" style="font-size: 10px;">
            <table class="table table-bordered table-hover dataTable dtr-inline" id="table-peminjaman">
                <thead class="text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Email</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Lama Pinjaman (Hari)</th>
                        <th>Keterlambatan (Hari)</th>
                        <th>Denda</th>
                        <th>Total Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanList as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->user->name }}</td>
                            <td>{{ $peminjaman->user->email }}</td>
                            <td>{{ $peminjaman->buku->judul }}</td>
                            <td>{{ $peminjaman->buku->penulis->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>{{ optional($peminjaman->tanggal_kembali)->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                @if ($peminjaman->status === 'dikembalikan')
                                    <span class="badge badge-success">Dikembalikan</span> <br>
                                    {{ optional($peminjaman->tanggal_dikembalikan)->format('d-m-Y') ?? '-' }}
                                @elseif ($peminjaman->tanggal_kembali && $peminjaman->tanggal_kembali->isPast())
                                    <span class="badge badge-danger">Terlambat</span>
                                @else
                                    <span class="badge badge-warning">
                                        {{ $peminjaman->status === 'menunggu verifikasi' ? 'Menunggu Verifikasi' : 'Dipinjam' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">{{ $peminjaman->lama_pinjaman }}</td>
                            <td class="text-right">{{ $peminjaman->lama_keterlambatan }}</td>
                            <td class="text-right">
                                {{ $peminjaman->denda ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-right">
                                {{ $peminjaman->denda ? 'Rp ' . number_format($peminjaman->total_denda, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table-peminjaman').DataTable();
        });
    </script>
@endpush
