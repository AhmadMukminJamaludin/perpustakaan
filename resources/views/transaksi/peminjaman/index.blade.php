@extends('layouts.app')

@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Daftar Peminjaman</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover dataTable dtr-inline" style="font-size: 10px;" id="table-peminjaman">
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
                                <th>Aksi</th>
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
                                            <span class="badge badge-success">Dikembalikan</span>
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
                                    <td class="text-right">{{ $peminjaman->denda ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : '-' }}</td>
                                    <td class="text-right">{{ $peminjaman->denda ? 'Rp ' . number_format($peminjaman->total_denda, 0, ',', '.') : '-' }}</td>
                                    <td class="text-nowrap">
                                        @if ($peminjaman->status === 'menunggu verifikasi')
                                            <button class="btn btn-primary btn-sm btn-verifikasi" style="font-size: 10px" data-id="{{ $peminjaman->id }}" data-user="{{ $peminjaman->user->name }}" data-email="{{ $peminjaman->user->email }}">
                                                <i class="fas fa-check-circle mr-1"></i> Verifikasi
                                            </button>
                                        @elseif ($peminjaman->status === 'dipinjam')
                                            <button class="btn btn-success btn-sm btn-kembalikan" style="font-size: 10px"
                                                data-id="{{ $peminjaman->id }}"
                                                data-judul="{{ $peminjaman->buku->judul }}">
                                                <i class="fa fa-check"></i> Dikembalikan
                                            </button>                                    
                                        @endif
                                        <button class="btn btn-warning btn-sm edit-peminjaman" style="font-size: 10px"
                                            data-id="{{ $peminjaman->id }}"
                                            data-user="{{ $peminjaman->user->name }}"
                                            data-buku="{{ $peminjaman->buku->judul }}"
                                            data-tanggal-pinjam="{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}"
                                            data-tanggal-kembali="{{ $peminjaman->tanggal_kembali?->format('Y-m-d') }}"
                                            data-status="{{ $peminjaman->status }}"
                                            data-denda="{{ $peminjaman->denda }}"
                                        >
                                            <i class="fa fa-edit"></i> Ubah
                                        </button>
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table-peminjaman').DataTable();
        $(document).on('click', '.btn-verifikasi', function () {
            var peminjamanId = $(this).data('id');
            var userName = $(this).data('user');
            var userEmail = $(this).data('email');
    
            $.confirm({
                title: 'Verifikasi Peminjaman',
                content: `
                    <form id="verifikasi-form">
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" class="form-control" value="${userName}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email Peminjam</label>
                            <input type="text" class="form-control" value="${userEmail}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="tanggal-kembali" required>
                        </div>
                        <div class="form-group">
                            <label>Denda per Hari (Rp)</label>
                            <input type="number" class="form-control" id="denda" placeholder="Masukkan denda (Opsional)">
                        </div>
                    </form>
                `,
                buttons: {
                    simpan: {
                        text: 'Simpan',
                        btnClass: 'btn-blue',
                        action: function () {
                            var tanggalKembali = $('#tanggal-kembali').val();
                            var denda = $('#denda').val();
    
                            if (!tanggalKembali) {
                                $.alert('Tanggal kembali harus diisi!');
                                return false;
                            }
    
                            // Kirim data ke server dengan Axios
                            axios.post('{{ route('peminjaman.verifikasi') }}', {
                                id: peminjamanId,
                                tanggal_kembali: tanggalKembali,
                                denda: denda
                            }).then(response => {
                                $.alert('Peminjaman berhasil diverifikasi!');
                                location.reload(); // Reload halaman agar data diperbarui
                            }).catch(error => {
                                $.alert('Gagal memverifikasi peminjaman.');
                            });
    
                            return false;
                        }
                    },
                    batal: {
                        text: 'Batal',
                        btnClass: 'btn-red',
                        action: function () {}
                    }
                }
            });
        });
        $('.edit-peminjaman').on('click', function () {
            let peminjamanId = $(this).data('id');
            let user = $(this).data('user');
            let buku = $(this).data('buku');
            let tanggalPinjam = $(this).data('tanggal-pinjam');
            let tanggalKembali = $(this).data('tanggal-kembali');
            let status = $(this).data('status');
            let denda = $(this).data('denda');
    
            $.confirm({
                title: 'Ubah Peminjaman',
                content: `
                    <form id="formEditPeminjaman">
                        <div class="form-group">
                            <label>Peminjam</label>
                            <input type="text" class="form-control" value="${user}" readonly>
                        </div>
    
                        <div class="form-group">
                            <label>Buku</label>
                            <input type="text" class="form-control" value="${buku}" readonly>
                        </div>
    
                        <div class="form-group">
                            <label>Tanggal Pinjam</label>
                            <input type="date" id="edit-tanggal-pinjam" class="form-control" value="${tanggalPinjam}" required>
                        </div>
    
                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="date" id="edit-tanggal-kembali" class="form-control" value="${tanggalKembali}" required>
                        </div>
    
                        <div class="form-group">
                            <label>Status</label>
                            <select id="edit-status" class="form-control">
                                <option value="menunggu verifikasi" ${status === 'menunggu verifikasi' ? 'selected' : ''}>menunggu verifikasi</option>
                                <option value="dipinjam" ${status === 'dipinjam' ? 'selected' : ''}>dipinjam</option>
                                <option value="dikembalikan" ${status === 'dikembalikan' ? 'selected' : ''}>dikembalikan</option>
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label>Denda (Per Hari)</label>
                            <input type="number" id="edit-denda" class="form-control" value="${denda}" min="0">
                        </div>
                    </form>
                `,
                columnClass: 'medium',
                buttons: {
                    simpan: {
                        text: 'Simpan',
                        btnClass: 'btn-blue',
                        action: function () {
                            let data = {
                                tanggal_pinjam: $('#edit-tanggal-pinjam').val(),
                                tanggal_kembali: $('#edit-tanggal-kembali').val(),
                                status: $('#edit-status').val(),
                                denda: $('#edit-denda').val(),
                            };
    
                            axios.post('/transaksi/peminjaman/' + peminjamanId + '/update', data)
                                .then(response => {
                                    $.alert('Peminjaman berhasil diperbarui!');
                                    setInterval(() => {
                                        location.reload();
                                    }, 2000);
                                })
                                .catch(error => {
                                    $.alert('Gagal memperbarui peminjaman.');
                                    console.error(error.response.data);
                                });
                        }
                    },
                    batal: {
                        text: 'Batal',
                        btnClass: 'btn-red',
                        action: function () {
                            // Tidak melakukan apa-apa, hanya menutup modal
                        }
                    }
                }
            });
        });
        $(document).on('click', '.btn-kembalikan', function () {
            var peminjamanId = $(this).data('id');
            var judulBuku = $(this).data('judul');
    
            $.confirm({
                title: 'Konfirmasi Pengembalian',
                content: `
                    <p>Apakah buku <strong>${judulBuku}</strong> sudah dikembalikan?</p>
                    <form id="form-kembalikan">
                        <div class="form-group">
                            <label for="tanggal_dikembalikan">Tanggal Dikembalikan</label>
                            <input type="datetime-local" id="tanggal_dikembalikan" class="form-control" required>
                        </div>
                    </form>
                `,
                buttons: {
                    konfirmasi: {
                        text: 'Ya, Kembalikan',
                        btnClass: 'btn-green',
                        action: function () {
                            var tanggalDikembalikan = $('#tanggal_dikembalikan').val();
    
                            if (!tanggalDikembalikan) {
                                $.alert('Harap isi tanggal dikembalikan.');
                                return false;
                            }
    
                            // Kirim permintaan ke backend
                            axios.post('{{ route("peminjaman.kembalikan") }}', {
                                id: peminjamanId,
                                tanggal_dikembalikan: tanggalDikembalikan
                            })
                            .then(response => {
                                $.alert({
                                    title: 'Berhasil!',
                                    content: 'Buku telah dikembalikan.',
                                    type: 'green',
                                    onClose: function () {
                                        location.reload(); // Refresh halaman setelah sukses
                                    }
                                });
                            })
                            .catch(error => {
                                $.alert({
                                    title: 'Error!',
                                    content: 'Gagal mengembalikan buku.',
                                    type: 'red'
                                });
                            });
                        }
                    },
                    batal: {
                        text: 'Batal',
                        btnClass: 'btn-red'
                    }
                }
            });
        });
    });

</script>
@endpush