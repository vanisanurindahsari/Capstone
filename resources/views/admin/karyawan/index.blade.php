@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Karyawan</h4>

        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th width="40">#</th>
                        <th>Nama User</th>
                        <th>Nama Lengkap</th>
                        <th>No. Telp</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($karyawans as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            {{-- ANTISIPASI USER KOSONG --}}
                            <td>
                                {{ $k->user->name ?? '-' }}
                            </td>

                            <td>{{ $k->nama_lengkap }}</td>
                            <td>{{ $k->no_telp ?? '-' }}</td>

                            <td>
                                <span class="badge {{ $k->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">
                                    {{ $k->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>

                            <td>{{ $k->alamat ?? '-' }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.karyawan.edit', $k->id) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-users"></i>
                                <br>
                                Belum ada data karyawan
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
