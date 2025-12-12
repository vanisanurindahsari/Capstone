@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="page-title mb-4">Buat Pengajuan Cuti</h3>

    <div class="card p-4 shadow-sm" style="border-radius: 12px;">

        <form action="{{ route('pegawai.cuti.store') }}" method="POST">
            @csrf

            {{-- Nomor Induk Karyawan --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Induk Karyawan</label>
                <input type="text" name="nomor_induk_karyawan"
                       class="form-control @error('nomor_induk_karyawan') is-invalid @enderror"
                       placeholder="Masukkan Nomor Induk Karyawan" required>

                @error('nomor_induk_karyawan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Cuti --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Jenis Cuti</label>
                <select name="jenis_cuti" class="form-control @error('jenis_cuti') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Cuti --</option>
                    <option value="Cuti Tahunan">Cuti Tahunan</option>
                    <option value="Cuti Sakit">Cuti Sakit</option>
                    <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                    <option value="Cuti Penting">Cuti Penting</option>
                    <option value="Cuti Lainnya">Cuti Lainnya</option>
                </select>

                @error('jenis_cuti')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Mulai --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai"
                       class="form-control @error('tanggal_mulai') is-invalid @enderror" required>

                @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai"
                       class="form-control @error('tanggal_selesai') is-invalid @enderror" required>

                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jumlah Hari --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Jumlah Hari</label>
                <input type="number" name="jumlah_hari"
                       class="form-control @error('jumlah_hari') is-invalid @enderror"
                       placeholder="Masukkan jumlah hari cuti" required>

                @error('jumlah_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alasan --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Alasan Cuti</label>
                <textarea name="alasan" rows="4"
                          class="form-control @error('alasan') is-invalid @enderror"
                          placeholder="Tuliskan alasan pengajuan cuti"
                          required></textarea>

                @error('alasan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pegawai.cuti.index') }}" class="btn btn-secondary" style="border-radius: 8px;">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary" style="border-radius: 8px;">
                    Ajukan Cuti
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
