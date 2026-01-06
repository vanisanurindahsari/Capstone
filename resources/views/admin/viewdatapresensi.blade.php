@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

<h3 class="page-title mb-3">Data Absensi Karyawan</h3>

<div class="card card-custom p-3">
    <table id="absensiAdminTable" class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($absensis as $item)
            <tr>
                <td>{{ $item->user->karyawan->nomor_induk_karyawan ?? '-' }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $item->jam_masuk ?? '-' }}</td>
                <td>{{ $item->jam_pulang ?? '-' }}</td>
                <td>
                    @if($item->jam_masuk && $item->jam_pulang)
                        <span class="badge bg-success">Hadir</span>
                    @elseif($item->jam_masuk && !$item->jam_pulang)
                        <span class="badge bg-warning text-dark">Masuk</span>
                    @else
                        <span class="badge bg-danger">Tidak Hadir</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#absensiAdminTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        order: [[2, 'desc']]
    });
});
</script>
@endpush
