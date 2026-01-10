@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style>
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
            position: relative;
        }
        .bg-karyawan { background-color: #4e73df; }
        .bg-kehadiran { background-color: #1cc88a; }
        .bg-cuti { background-color: #f6c23e; }
        .badge-status { padding: 5px 10px; border-radius: 8px; font-size: 0.9rem; }
        .percentage-change { font-size: 0.9rem; position: absolute; bottom: 10px; width: 100%; text-align: center; }
    </style>
@endpush

@section('content')

<h3 class="page-title mb-4">Dashboard Admin</h3>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card bg-karyawan text-center">
            <h5>Total Karyawan</h5>
            <h2>{{ $totalKaryawan }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-kehadiran text-center">
            <h5>Kehadiran Hari Ini</h5>
            <h2>{{ $kehadiranHariIni }}</h2>
            <div class="percentage-change">
                @if($kehadiranPersen >= 0)
                    <span class="text-success">↑ {{ $kehadiranPersen }}%</span> dari kemarin
                @else
                    <span class="text-danger">↓ {{ abs($kehadiranPersen) }}%</span> dari kemarin
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-cuti text-center">
            <h5>Cuti Hari Ini</h5>
            <h2>{{ $cutiHariIni }}</h2>
        </div>
    </div>
</div>

{{-- Grafik Kehadiran & Cuti Mingguan --}}
<div class="card mb-4">
    <div class="card-header bg-info text-white">Grafik Kehadiran & Cuti Mingguan</div>
    <div class="card-body">
        <canvas id="chartKehadiran" height="100"></canvas>
    </div>
</div>

{{-- Tabel Karyawan Cuti Hari Ini --}}
<div class="card mb-4">
    <div class="card-header bg-warning text-primary">
        Daftar Karyawan Cuti Hari Ini
    </div>
    <div class="card-body table-responsive">
        <table id="cutiTable" class="table table-bordered table-striped display nowrap">
            <thead class="table-dark">
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Cuti</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
            @foreach($karyawanCuti as $cuti)
                <tr>
                    <td>{{ $cuti->user->nomor_induk_karyawan ?? '-' }}</td>
                    <td>{{ $cuti->user->name ?? '-' }}</td>
                    <td>{{ $cuti->jenis_cuti }}</td>
                    <td>{{ $cuti->tanggal_mulai }}</td>
                    <td>{{ $cuti->tanggal_selesai }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel Kehadiran --}}
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Daftar Karyawan Sudah Hadir Hari Ini
            </div>
            <div class="card-body table-responsive">
                <table id="hadirTable" class="table table-bordered table-striped display nowrap">
                    <thead class="table-dark">
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sudahHadir as $hadir)
                        <tr>
                            <td>{{ $hadir->user->nomor_induk_karyawan ?? '-' }}</td>
                            <td>{{ $hadir->user->name ?? '-' }}</td>
                            <td>{{ $hadir->jam_masuk }}</td>
                            <td>{{ $hadir->jam_pulang ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                Daftar Karyawan Belum Hadir Hari Ini
            </div>
            <div class="card-body table-responsive">
                <table id="belumHadirTable" class="table table-bordered table-striped display nowrap">
                    <thead class="table-dark">
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($belumHadir as $belum)
                        <tr>
                            <td>{{ $belum->user->nomor_induk_karyawan ?? '-' }}</td>
                            <td>{{ $belum->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function