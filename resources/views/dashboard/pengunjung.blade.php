@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pinjam</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th class="text-right">Tanggal Pinjam</th>
                                <th class="text-right">Jatuh Tempo</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Functional-requirements.docx</td>
                                <td class="text-right">12-10-2025</td>
                                <td class="text-right">12-10-2025</td>
                                <td class="text-center py-0 align-middle">
                                    <span class="badge badge-danger">Terlambat</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kalender</h3>
                </div>
                <div class="card-body p-1">
                    <div id="mini-calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1px !important;
        padding-bottom: 1px !important;
        padding-top: 1px !important;
    }
</style>
@endpush