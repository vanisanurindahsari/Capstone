@extends('layouts.app')

@push('styles')
    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    {{-- Page CSS --}}
    @vite('resources/css/cuti.css')
@endpush
@vite('resources/css/pengajuancuti.css')

@section('content')

<div class="page-cuti">

    <h3 class="page-title mb-3">Pengajuan Cuti Saya</h3>

    <a href="{{ route('pegawai.cuti.create') }}"
       class="btn btn-primary mb-3 shadow-sm btn-radius">
        + Ajukan Cuti
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-custom">
        <table id="cutiTable" class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nomor Induk Karyawan</th>
                    <th>Jenis Cuti</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Jumlah Hari</th>
                    <th>Status</th>
                    <th>Alasan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($pengajuan as $item)
                <tr>
                    <td>{{ $item->nomor_induk_karyawan }}</td>
                    <td>{{ $item->jenis_cuti }}</td>
                    <td>{{ $item->tanggal_mulai }}</td>
                    <td>{{ $item->tanggal_selesai }}</td>
                    <td>{{ $item->jumlah_hari }}</td>

                    <td>
                        @if ($item->status == 'Disetujui')
                            <span class="badge-status bg-success text-white">Disetujui</span>
                        @elseif ($item->status == 'Ditolak')
                            <span class="badge-status bg-danger text-white">Ditolak</span>
                        @else
                            <span class="badge-status bg-warning text-dark">Menunggu</span>
                        @endif
                    </td>

                    <td>{{ $item->alasan }}</td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('pegawai.cuti.edit', $item->id) }}"
                               class="btn btn-warning btn-sm btn-radius">
                                Edit
                            </a>

                            <form action="{{ route('pegawai.cuti.delete', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus data?')"
                                        class="btn btn-danger btn-sm btn-radius">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Datatables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
    $(document).ready(function () {
        $('#cutiTable').DataTable({
    responsive: true,
    dom: '<"row mb-3"<"col-md-6"f>>rt<"row mt-3"<"col-md-6"l><"col-md-6 text-end"p>>',
    language: {
        search: "",
        searchPlaceholder: "Cari data cuti..."
    }
});

    });
    </script>
@endpush
