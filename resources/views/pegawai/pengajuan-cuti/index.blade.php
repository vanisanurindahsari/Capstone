@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@vite('resources/css/cuti.css')

@endpush


@section('content')

<h3 class="page-title mb-3">Pengajuan Cuti Saya</h3>

<a href="{{ route('cuti.create') }}" class="btn btn-primary mb-3 shadow-sm" style="border-radius: 10px;">
    + Ajukan Cuti
</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-custom">
    <table id="cutiTable" class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Nomor Induk Karyawan</th> <!-- ⬅️ Ditambahkan sesuai permintaan -->
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
                <td>{{ $item->nomor_induk_karyawan }}</td> <!-- ⬅️ Tambahan baru -->
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
                        <a href="{{ route('cuti.edit', $item->id) }}"
                           class="btn btn-warning btn-sm" style="border-radius: 8px;">Edit</a>

                        <form action="{{ route('cuti.delete', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus data?')"
                                    class="btn btn-danger btn-sm" style="border-radius: 8px;">
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

@endsection



@push('scripts')
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

        /* SEARCH KIRI - EXPORT KANAN */
        dom: '<"row mb-3"' +
                '<"col-md-6"f>' +
                '<"col-md-6 text-end"B>' +
            '>' +
            'rt' +
            '<"row mt-3"' +
                '<"col-md-6"l>' +
                '<"col-md-6 text-end"p>' +
            '>',


        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel"></i> Excel'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print'
            }
        ],

        language: {
            search: "",
            searchPlaceholder: "Cari data cuti..."
        }
    });

});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

@endpush
