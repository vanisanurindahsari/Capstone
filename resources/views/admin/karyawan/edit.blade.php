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
                    <label class="form-label">User</label>
                    <select name="id_user" class="form-control" required>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ $karyawan->id_user == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" 
                           value="{{ $karyawan->nama_lengkap }}" required>
                </div>
        
                <div class="mb-3">
                    <label class="form-label">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control"
                           value="{{ $karyawan->no_telp }}">
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
                    <textarea name="alamat" class="form-control" rows="3">{{ $karyawan->alamat }}</textarea>
                </div>
        
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection
