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
</script>
@endpush