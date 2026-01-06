@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Edit Karyawan</h4>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" 
                           value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $karyawan->user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control"
                           value="{{ old('no_telp', $karyawan->no_telp) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection
