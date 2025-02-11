@extends('layouts.app')

@section('title', 'Transaksi Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Daftar Booking</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-booking">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Anggota</th>
                                <th>Sampul</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Booking</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td class="text-center align-middle">
                                        @php
                                            $sampulUrl = 'https://placehold.jp/200x200.png';
                                            if(isset($item->buku) && !empty($item->buku->path) && file_exists(public_path('storage/' . $item->buku->path))){
                                                $sampulUrl = asset('storage/' . $item->buku->path);
                                            }
                                        @endphp
                                        <img id="sampulPreview" src="{{ $sampulUrl }}" alt="Preview Sampul" style="max-height: 75px;">
                                    </td>
                                    <td>{{ $item->buku->judul }} <br>
                                        <small><b>Penerbit:</b> {{ $item->buku->penerbit->nama }}</small> <br>
                                        <small><b>ISBN:</b> {{ $item->buku->isbn }}</small>
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <form action="{{ route('booking.remove', ['user_id' => $item->user_id,'buku_id' => $item->buku_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus booking ini?')">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash mr-1"></i> Hapus
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
        $('#table-booking').DataTable();
    });
</script>
@endpush