@extends('layouts.app', ['title' => 'Dashboard Owner'])

@section('content')
@vite('resources/css/pengajuancuti.css')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Pengajuan Cuti Karyawan</h4>
        <div>
            {{-- EXPORT PDF --}}
            <a href="{{ route('owner.cuti.export.pdf') }}"
               class="btn btn-success btn-sm">
                Export PDF
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jumlah Hari</th>
                            <th>Status / Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nomor_induk_karyawan }}</td>
                            <td>{{ $item->jenis_cuti }}</td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>{{ $item->jumlah_hari }}</td>

                            {{-- STATUS + ACTION --}}
                            <td>
                                @if($item->status === 'Menunggu')
                                    <form action="{{ route('owner.cuti.updateStatus', $item->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Disetujui">
                                        <button type="submit"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Setujui cuti ini?')">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('owner.cuti.updateStatus', $item->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Tolak cuti ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                @elseif($item->status === 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Data pengajuan cuti belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
