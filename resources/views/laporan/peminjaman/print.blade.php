<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h4 {
            margin-bottom: 20px;
        }
        table {
            width:100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border:1px solid #000;
            padding:4px;
            text-align: center;
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            border-radius: 4px;
            color: #fff;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; }
        .badge-danger  { background-color: #dc3545; }
    </style>
</head>
<body>
    <h4 style="text-align: center;">Laporan Peminjaman</h4>
    <table>
        <thead>
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
            @forelse($peminjamanList as $i => $pinjam)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $pinjam->user->name }}</td>
                    <td>{{ $pinjam->user->email }}</td>
                    <td>{{ $pinjam->buku->judul }}</td>
                    <td>{{ $pinjam->buku->penulis->nama ?? '-' }}</td>
                    <td>{{ $pinjam->tanggal_pinjam->format('d-m-Y') }}</td>
                    <td>
                        {{ optional($pinjam->tanggal_kembali)->format('d-m-Y') ?? '-' }}
                    </td>
                    <td>
                        @if ($pinjam->status === 'dikembalikan')
                            <span class="badge badge-success">Dikembalikan</span><br>
                            {{ optional($pinjam->tanggal_dikembalikan)->format('d-m-Y') ?? '-' }}
                        @elseif ($pinjam->tanggal_kembali && $pinjam->tanggal_kembali->isPast())
                            <span class="badge badge-danger">Terlambat</span>
                        @else
                            <span class="badge badge-warning">
                                {{ $pinjam->status === 'menunggu verifikasi'
                                    ? 'Menunggu Verifikasi'
                                    : 'Dipinjam' }}
                            </span>
                        @endif
                    </td>
                    <td class="text-right">{{ $pinjam->lama_pinjaman }}</td>
                    <td class="text-right">{{ $pinjam->lama_keterlambatan }}</td>
                    <td class="text-right">
                        {{ $pinjam->denda
                            ? 'Rp ' . number_format($pinjam->denda, 0, ',', '.')
                            : '-' }}
                    </td>
                    <td class="text-right">
                        {{ $pinjam->denda
                            ? 'Rp ' . number_format($pinjam->total_denda, 0, ',', '.')
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
