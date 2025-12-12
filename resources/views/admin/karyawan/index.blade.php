@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Data Karyawan</h4>

    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Karyawan
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama User</th>
                        <th>Nama Lengkap</th>
                        <th>No. Telp</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th width="130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->user->name }}</td>
                        <td>{{ $k->nama_lengkap }}</td>
                        <td>{{ $k->no_telp }}</td>
                        <td>{{ $k->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $k->alamat }}</td>
                        <td>
                            <a href="{{ route('admin.karyawan.edit', $k->id) }}"
                               class="btn btn-warning btn-sm">
                               <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
