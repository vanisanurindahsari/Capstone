@extends('layouts.app') 

@section('content')

<h3 class="page-title mb-3">Presensi Hari Ini</h3>

<div class="row">
    <div class="col-md-6">

        <div class="card card-custom p-4">

            <!-- <div class="mb-2">
                <strong>Tanggal:</strong> {{ now()->translatedFormat('d F Y') }}
            </div>

            <div class="mb-3">
                <strong>Waktu:</strong>
                <span id="jamSekarang"></span>
            </div> -->

            <h4 class="fw-bold mb-1">Absensi Karyawan Sandy Leather</h4>
            <div class="text-muted mb-3">📍 Tanggulangin, Sidoarjo</div>

            <div class="mb-2">
                <strong>Tanggal:</strong> {{ now()->translatedFormat('d F Y') }}
            </div>

            <div class="mb-2">
                <strong>Jam Kerja:</strong> 09.00 - 17.00
            </div>

            <div class="mb-2">
                <strong>Waktu:</strong>
                <span id="jamSekarang"></span>
            </div>

            <div class="mb-3">
                <strong>Status Kehadiran:</strong>
                <span id="statusHadir" class="badge bg-secondary">Menentukan...</span>
            </div>

            <hr>

            <div class="mb-2">
                <strong>Lokasi Anda:</strong><br>
                <span id="lokasiUser" class="text-muted">Mengambil lokasi...</span>
            </div>

            <div class="mb-3">
                <strong>Status Area:</strong>
                <span id="statusRadius" class="badge bg-secondary">Menentukan...</span>
            </div>


            {{-- ALERT --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('pegawai.presensi.store') }}" method="POST">
                @csrf

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="accuracy" id="accuracy">
                <input type="hidden" name="status_kehadiran" id="statusKehadiran">


                @php
                    // Tombol berubah sesuai status presensi hari ini
                    $btnClass = 'btn-success';
                    $btnIcon  = 'fa-fingerprint';
                    $btnText  = 'Lakukan Presensi';
                    $disabled = false;

                    if(isset($presensiHariIni)) {
                        if(!$presensiHariIni->jam_pulang) {
                            $btnClass = 'btn-warning';
                            $btnIcon  = 'fa-sign-out-alt';
                            $btnText  = 'Presensi Pulang';
                        } else {
                            $btnClass = 'btn-secondary';
                            $btnIcon  = 'fa-check';
                            $btnText  = 'Presensi Selesai';
                            $disabled = true;
                        }
                    }
                @endphp

                <button type="submit" class="btn {{ $btnClass }} w-100 btn-lg" {{ $disabled ? 'disabled' : '' }}>
                    <i class="fas {{ $btnIcon }}"></i> {{ $btnText }}
                </button>
            </form>

            <small class="text-muted d-block mt-3">
                * Pastikan GPS aktif dan berada di area kantor
            </small>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // JAM REALTIME
    function updateJam() {
        document.getElementById('jamSekarang').innerText =
            new Date().toLocaleTimeString('id-ID');
    }
    setInterval(updateJam, 1000);
    updateJam();

    // Jam Kerja
    function cekJamKerja() {
        const sekarang = new Date();
        const jam = sekarang.getHours();
        const menit = sekarang.getMinutes();
        const totalMenitSekarang = jam * 60 + menit;

        // setting Jam kerja 09:00 - 17:00
        const jamMasuk = 9 * 60;        // 09:00 → 540 menit
        const jamPulang = 17 * 60;      // 17:00 → 1020 menit
        const batasTelat = 20;          // 20 menit toleransi

        const statusEl = document.getElementById('statusHadir');
        document.getElementById('statusKehadiran').value = 'tepat_waktu';
        document.getElementById('statusKehadiran').value = 'terlambat';
        document.getElementById('statusKehadiran').value = 'tidak_hadir';

        // === LOGIKA STATUS ===
        if (totalMenitSekarang < jamMasuk || totalMenitSekarang >= jamPulang) {

            statusEl.innerText = 'Tidak Hadir (di luar jam kerja)';
            statusEl.className = 'badge bg-danger';

        } else if (totalMenitSekarang <= jamMasuk + batasTelat) {

            statusEl.innerText = 'Hadir Tepat Waktu';
            statusEl.className = 'badge bg-success';

        } else {

            statusEl.innerText = 'Terlambat Hadir';
            statusEl.className = 'badge bg-warning';
        }
    }
    setInterval(() => {
        updateJam();
        cekJamKerja();
    }, 1000);

    // GPS
    // if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(pos => {
    //         document.getElementById('latitude').value  = pos.coords.latitude;
    //         document.getElementById('longitude').value = pos.coords.longitude;
    //         document.getElementById('accuracy').value  = pos.coords.accuracy;
    //     }, () => {
    //         alert('Gagal mengambil lokasi. Aktifkan GPS.');
    //     }, {
    //         enableHighAccuracy: true
    //     });
    // }
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {

            const userLat = pos.coords.latitude;
            const userLng = pos.coords.longitude;

            document.getElementById('latitude').value  = userLat;
            document.getElementById('longitude').value = userLng;
            document.getElementById('accuracy').value  = pos.coords.accuracy;
            document.getElementById('lokasiUser').innerText =
            userLat.toFixed(6) + ', ' + userLng.toFixed(6);

            const kantorLat = -7.5027157;
            const kantorLng = 112.7040687;
            const radiusMax = 100000000; // meter

            const jarak = hitungJarak(userLat, userLng, kantorLat, kantorLng);
            const statusRadiusEl = document.getElementById('statusRadius');
            const tombol = document.querySelector('button[type=submit]');

            if (jarak <= radiusMax) {
                statusRadiusEl.innerText = 'Dalam Area Kantor';
                statusRadiusEl.className = 'badge bg-success';
                tombol.disabled = false;
            } else {
                statusRadiusEl.innerText = 'Di Luar Area Kantor (' + Math.round(jarak) + ' m)';
                statusRadiusEl.className = 'badge bg-danger';
                tombol.disabled = true;
            }

        }, () => {
            alert('Gagal mengambil lokasi. Aktifkan GPS.');
        }, {
            enableHighAccuracy: true
        });
    }

    // Fungsi hitung jarak antara 2 koordinat (Haversine Formula)
    function hitungJarak(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // meter
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ/2) * Math.sin(Δλ/2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
</script>
@endpush