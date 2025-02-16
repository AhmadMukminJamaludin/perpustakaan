@extends('layouts.app')

@section('title', 'Transaksi Pembayaran Denda')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tagihan</h3>
                </div>
                <div class="card-body table-responsive" style="font-size: 10px;">
                    <table class="table table-bordered table-hover dataTable dtr-inline" id="table-tagihan">
                        <thead class="text-center align-middle">
                            <tr>
                                <th>No</th>
                                <th>Kode Tagihan</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Lama Pinjaman (Hari)</th>
                                <th>Keterlambatan (Hari)</th>
                                <th>Denda (Keterlambatan + Kehilangan)</th>
                                <th>Total Denda</th>
                                <th>Status Pembayaran</th>
                                @if (Auth::user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->order_id }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->peminjaman->buku->judul }}</td>
                                    <td>{{ $item->peminjaman->buku->penulis->nama ?? '-' }}</td>
                                    <td class="text-right">{{ $item->peminjaman->lama_pinjaman }}</td>
                                    <td class="text-right">{{ $item->peminjaman->lama_keterlambatan }}</td>
                                    <td class="text-right">
                                        @php
                                            $denda = (int) $item->peminjaman->denda; // Konversi ke integer
                                            $lamaKeterlambatan = (int) $item->peminjaman->lama_keterlambatan; // Konversi ke integer
                                            $dendaKehilangan = (int) $item->peminjaman->denda_kehilangan; // Konversi ke integer
                                            
                                            $totalDenda = $denda * $lamaKeterlambatan;
                                        @endphp
                                    
                                        @if ($totalDenda > 0 || $dendaKehilangan > 0)
                                            {{ number_format($totalDenda, 0, ',', '.') }}
                                            @if ($dendaKehilangan > 0)
                                                + {{ number_format($dendaKehilangan, 0, ',', '.') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>                                    
                                    <td class="text-right">{{ $item->peminjaman->denda ? number_format($item->peminjaman->total_denda, 0, ',', '.') : '-' }}</td>
                                    <td class="text-center">
                                        {{ $item->payment_status }}
                                    </td>
                                    @if (Auth::user()->hasRole('admin'))
                                        <td class="text-nowrap">
                                            @if ($item->payment_status != 'settlement')
                                                <button class="btn btn-info btn-xs btn-bayar-denda" style="font-size: 10px"
                                                    data-id="{{ $item->id }}"
                                                    data-amount="{{ $item->peminjaman->total_denda }}"
                                                    data-order="{{ $item->order_id }}">
                                                    <i class="fas fa-credit-card mr-1"></i> Bayar Denda
                                                </button>
                                            @endif
                                        </td>
                                    @endif
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
    
@push('styles')

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Midtrans Snap.js (gunakan sandbox atau production sesuai konfigurasi) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-tagihan').DataTable();
    });

    $(document).on('click', '.btn-bayar-denda', function() {
        var tagihanId = $(this).data('id');
        var amount = $(this).data('amount');
        var orderId = $(this).data('order');

        axios.post('{{ route("pembayaran_denda.create_payment") }}', {
            tagihan_id: tagihanId,
            amount: amount
        })
        .then(function(response) {
            var snapToken = response.data.snapToken;
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    $.alert('Pembayaran berhasil!');
                    location.reload();
                },
                onPending: function(result) {
                    $.alert('Pembayaran sedang diproses, silakan tunggu.');
                    location.reload();
                },
                onError: function(result) {
                    $.alert('Pembayaran gagal, silakan coba lagi.');
                }
            });
        })
        .catch(function(error) {
            $.alert('Gagal membuat transaksi pembayaran.');
            console.error(error.response ? error.response.data : error);
        });
    });
</script>
@endpush