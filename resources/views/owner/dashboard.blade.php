@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
/* Hero Cards */
.hero-card {
    border-radius: 15px;
    padding: 25px 20px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.hero-card .icon {
    font-size: 2.5rem;
    position: absolute;
    top: 20px;
    right: 20px;
    opacity: 0.3;
}
.bg-karyawan { background: linear-gradient(135deg, #6a11cb, #2575fc); }
.bg-kehadiran { background: linear-gradient(135deg, #1dd1a1, #10ac84); }
.bg-cuti { background: linear-gradient(135deg, #ff9a9e, #fecfef); }

/* Tabel mini */
.table-sm-card {
    font-size: 0.9rem;
}
.table-sm-card th, .table-sm-card td {
    padding: 6px 8px;
}

/* Chart card */
.card-chart {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-radius: 12px;
}

/* Persentase kehadiran */
.percentage-change {
    font-size: 0.85rem;
    margin-top: 5px;
}
.text-up { color: #1cc88a; }
.text-down { color: #e74a3b; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <h3 class="page-title mb-4">Dashboard Owner</h3>

    {{-- Hero Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="hero-card bg-karyawan">
                <i class="bi bi-people icon"></i>
                <h5>Total Karyawan</h5>
                <h2>{{ $totalKaryawan }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="hero-card bg-kehadiran">
                <i class="bi bi-check2-square icon"></i>
                <h5>Kehadiran Hari Ini</h5>
                <h2>{{ $kehadiranHariIni }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="hero-card bg-cuti">
                <i class="bi bi-calendar-x icon"></i>
                <h5>Cuti Hari Ini</h5>
                <h2>{{ $cutiHariIni }}</h2>
            </div>
        </div>
    </div>

    {{-- Grafik Kehadiran & Cuti --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-chart p-3">
                <h6>Kehadiran Mingguan</h6>
                <canvas id="chartHadir" height="150"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-chart p-3">
                <h6>Cuti Mingguan</h6>
                <canvas id="chartCuti" height="150"></canvas>
            </div>
        </div>
    </div>

    {{-- Tabel Ringkas Karyawan --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">Sudah Hadir</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped table-sm-card mb-0">
                        <thead><tr><th>NIK</th><th>Nama</th></tr></thead>
                        <tbody>
                        @foreach($sudahHadir as $hadir)
                            <tr>
                                <td>{{ $hadir->user->nomor_induk_karyawan ?? '-' }}</td>
                                <td>{{ $hadir->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">Belum Hadir</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped table-sm-card mb-0">
                        <thead><tr><th>NIK</th><th>Nama</th></tr></thead>
                        <tbody>
                        @foreach($belumHadir as $belum)
                            <tr>
                                <td>{{ $belum->nomor_induk_karyawan ?? '-' }}</td>
                                <td>{{ $belum->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">Cuti Hari Ini</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped table-sm-card mb-0">
                        <thead><tr><th>NIK</th><th>Nama</th><th>Jenis Cuti</th></tr></thead>
                        <tbody>
                        @foreach($karyawanCuti as $cuti)
                            <tr>
                                <td>{{ $cuti->user->nomor_induk_karyawan ?? '-' }}</td>
                                <td>{{ $cuti->user->name ?? '-' }}</td>
                                <td>{{ $cuti->jenis_cuti }}</td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Kehadiran
const ctxHadir = document.getElementById('chartHadir').getContext('2d');
new Chart(ctxHadir, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Hadir',
            data: @json($chartHadir),
            borderColor: '#1dd1a1',
            backgroundColor: 'rgba(29,209,161,0.2)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { responsive: true }
});

// Chart Cuti
const ctxCuti = document.getElementById('chartCuti').getContext('2d');
new Chart(ctxCuti, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Cuti',
            data: @json($chartCuti),
            backgroundColor: '#f6c23e'
        }]
    },
    options: { responsive: true }
});
</script>
@endpush