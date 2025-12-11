@extends('layouts.app')

@section('content')
<h3>Edit Pengajuan Cuti</h3>

<form action="{{ route('cuti.update', $pengajuan->id) }}" method="POST" class="card p-4 mt-3">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Jenis Cuti</label>
        <input type="text" name="jenis_cuti" class="form-control" value="{{ $pengajuan->jenis_cuti }}" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control" value="{{ $pengajuan->tanggal_mulai }}" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" value="{{ $pengajuan->tanggal_selesai }}" required>
    </div>

    <div class="mb-3">
        <label>Jumlah Hari</label>
        <input type="number" name="jumlah_hari" class="form-control" value="{{ $pengajuan->jumlah_hari }}" required>
    </div>

    <div class="mb-3">
        <label>Alasan</label>
        <textarea name="alasan" class="form-control" rows="3" required>{{ $pengajuan->alasan }}</textarea>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
