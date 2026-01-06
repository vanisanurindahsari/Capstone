@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Edit Karyawan</h4>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" 
                           value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
                </div>

                {{-- NIK --}}
                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control"
                           value="{{ old('nik', $karyawan->nik) }}" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $karyawan->user->email) }}" required>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>

                {{-- No. Telp --}}
                <div class="mb-3">
                    <label class="form-label">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control"
                           value="{{ old('no_telp', $karyawan->no_telp) }}">
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Alamat --}}
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
