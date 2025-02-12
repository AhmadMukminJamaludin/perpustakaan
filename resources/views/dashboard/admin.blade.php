@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Jumlah Buku</span>
            <span class="info-box-number">{{ $jumlahBuku }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Jumlah Anggota</span>
            <span class="info-box-number">{{ $jumlahAnggota }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fas fa-sync"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Peminjaman</span>
            <span class="info-box-number">{{ $totalDipinjam }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fas fa-clock"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Total Keterlambatan</span>
            <span class="info-box-number">{{ $totalOverdue }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Peminjaman Per Bulan</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body p-2">
                <div class="chart">
                    <canvas id="chartPeminjaman" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="card card-danger">
            <div class="card-header">
            <h3 class="card-title">Buku Terpopuler</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body p-2">
                <div class="chart">
                    <canvas id="chartBukuTerpopuler" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title">Overdue Peminjaman</h3>
    
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" id="search-overdue" class="form-control float-right" placeholder="Search...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th class="text-center">Status</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody id="overdue-list">
                        <tr>
                            <td colspan="5" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('chartPeminjaman').getContext('2d');
        var chartPeminjaman = new Chart(ctx, {
            type: 'bar', // Bisa diganti 'line' untuk line chart
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                ],
                datasets: [{
                    label: 'Jumlah Peminjaman Buku',
                    data: @json($peminjamanPerBulan), // Ambil data dari PHP
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna batang
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Peminjaman'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });

        var ctx = document.getElementById('chartBukuTerpopuler').getContext('2d');
        var chartBukuTerpopuler = new Chart(ctx, {
            type: 'pie', // Pie Chart
            data: {
                labels: @json($labels), // Nama buku
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($data), // Total peminjaman
                    backgroundColor: @json($colors), // Warna random
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });

    $(document).ready(function () {
        function loadOverdueData(search = '') {
            $.ajax({
                url: "{{ route('peminjaman.overdue') }}",
                type: "GET",
                data: { search: search },
                success: function (data) {
                    let tbody = $("#overdue-list");
                    tbody.empty();

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center text-muted">Tidak ada peminjaman yang overdue.</td></tr>');
                        return;
                    }

                    $.each(data, function (index, item) {
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${item.user.name}</td>
                            <td>${item.buku.judul}</td>
                            <td class="text-center"><span class="badge badge-danger">Overdue</span></td>
                            <td class="text-danger"><strong>Terlambat sejak ${item.formatted_tanggal_kembali}</strong></td>
                        </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        // Load overdue data on page load
        loadOverdueData();

        // Lazy search feature
        $("#search-overdue").on("keyup", function () {
            let search = $(this).val();
            loadOverdueData(search);
        });
    });
</script>
@endpush