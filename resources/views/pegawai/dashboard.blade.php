@extends('layouts.app', ['title' => 'Dashboard Pegawai'])

@section('content')
@vite('resources/css/cuti.css')
<style>

</style>


<div class="container-fluid">

    <div class="dashboard-title">Data Cuti Karyawan</div>

    {{-- ROW STATISTIK CUTI --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="stats-box">
                <div class="stats-number">{{ $totalCuti ?? 0 }}</div>
                <div class="stats-label">Data Cuti</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-box">
                <div class="stats-number">{{ $cutiDiterima ?? 0 }}</div>
                <div class="stats-label">Data Cuti Diterima</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-box">
                <div class="stats-number">{{ $cutiDitolak ?? 0 }}</div>
                <div class="stats-label">Data Cuti Ditolak</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stats-box">
                <div class="stats-number">{{ $cutiPending ?? 0 }}</div>
                <div class="stats-label">Data Cuti Menunggu Konfirmasi</div>
            </div>
        </div>

    </div>

    {{-- SISA CUTI --}}
    <div class="col-md-3 mb-4">
        <div class="stats-box" style="background:#e6ebff;">
            <div class="stats-number" style="color:#1f2dbf;">
                {{ $sisaCuti ?? '0 Hari Lagi' }}
            </div>
            <div class="stats-label">Sisa Cuti</div>
        </div>
    </div>


    {{-- SYARAT PERMOHONAN CUTI --}}
    <div class="section-title">Syarat Permohonan Cuti</div>

    <div class="row mt-3">

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Tahunan</h5>
                <p>Cuti tahunan : 12 Hari<br>
                    Cuti ini diberikan untuk karyawan dengan masa kerja minimal 1 tahun.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Besar</h5>
                <p>Cuti besar : 3 bulan<br>
                    Diberikan kepada karyawan dengan masa kerja minimal 6 tahun.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Sakit</h5>
                <p>Berlaku apabila karyawan tidak memungkinkan bekerja dan menyertakan surat dokter.</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Melahirkan</h5>
                <p>Cuti melahirkan : 3 bulan untuk karyawan wanita.</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Alasan Penting</h5>
                <p>Diberikan sesuai kebutuhan, seperti menikah atau adanya keperluan keluarga.</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="rules-card">
                <h5>Cuti Bersama</h5>
                <p>Cuti bersama mengikuti ketetapan pemerintah dan hari libur nasional.</p>
            </div>
        </div>

    </div>

</div>

@endsection
