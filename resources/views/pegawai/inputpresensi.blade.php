@extends('layouts.app')

@section('content')

<h3 class="page-title mb-3">Presensi Hari Ini</h3>

<div class="row">
    <div class="col-md-6">

        <div class="card card-custom p-4">

            <div class="mb-2">
                <strong>Tanggal:</strong> {{ now()->translatedFormat('d F Y') }}
            </div>

            <div class="mb-3">
                <strong>Waktu:</strong>
                <span id="jamSekarang"></span>
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

    // GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('latitude').value  = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            document.getElementById('accuracy').value  = pos.coords.accuracy;
        }, () => {
            alert('Gagal mengambil lokasi. Aktifkan GPS.');
        }, {
            enableHighAccuracy: true
        });
    }
</script>
@endpush
