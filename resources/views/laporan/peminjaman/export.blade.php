<!-- resources/views/laporan/peminjaman/export.blade.php -->
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
        @foreach($peminjamanList as $index => $pinjam)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pinjam->user->name }}</td>
                <td>{{ $pinjam->user->email }}</td>
                <td>{{ $pinjam->buku->judul }}</td>
                <td>{{ optional($pinjam->buku->penulis)->nama ?? '-' }}</td>
                <td>{{ $pinjam->tanggal_pinjam->format('d-m-Y') }}</td>
                <td>{{ optional($pinjam->tanggal_kembali)->format('d-m-Y') ?? '-' }}</td>
                <td>
                    @if ($pinjam->status === 'dikembalikan')
                        Dikembalikan @if($pinjam->tanggal_dikembalikan) ({{ $pinjam->tanggal_dikembalikan->format('d-m-Y') }}) @endif
                    @elseif ($pinjam->tanggal_kembali && $pinjam->tanggal_kembali->isPast())
                        Terlambat
                    @else
                        {{ $pinjam->status === 'menunggu verifikasi' ? 'Menunggu Verifikasi' : 'Dipinjam' }}
                    @endif
                </td>
                <td>{{ $pinjam->lama_pinjaman }}</td>
                <td>{{ $pinjam->lama_keterlambatan }}</td>
                <td>{{ $pinjam->denda ? 'Rp ' . number_format($pinjam->denda, 0, ',', '.') : '-' }}</td>
                <td>{{ $pinjam->denda ? 'Rp ' . number_format($pinjam->total_denda, 0, ',', '.') : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
