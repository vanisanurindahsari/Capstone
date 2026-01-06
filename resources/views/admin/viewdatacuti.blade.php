@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .badge-menunggu {
        background-color: #fff3cd;
        color: #856404;
    }
    .badge-disetujui {
        background-color: #d4edda;
        color: #155724;
    }
    .badge-ditolak {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')

<h3 class="page-title mb-3">Data Pengajuan Cuti Karyawan</h3>

<div class="card card-custom p-3">
    <table id="cutiAdminTable" class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Hari</th>
                <th>Status</th>
                @if(auth()->user()->role === 'owner')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($pengajuan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nomor_induk_karyawan }}</td>
                <td>{{ $item->nama_karyawan }}</td>
                <td>{{ $item->jenis_cuti }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                <td>{{ $item->jumlah_hari }}</td>
                <td>
                    @if($item->status === 'Menunggu')
                        <span class="badge badge-menunggu">Menunggu</span>
                    @elseif($item->status === 'Disetujui')
                        <span class="badge badge-disetujui">Disetujui</span>
                    @else
                        <span class="badge badge-ditolak">Ditolak</span>
                    @endif
                </td>
                
                @if(auth()->user()->role === 'owner')
                <td>
                    <form action="{{ route('cuti.acc', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">ACC</button>
                    </form>
                    <form action="{{ route('cuti.tolak', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
                @endif

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
    $('#cutiAdminTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        order: [[4, 'desc']] // urut berdasarkan tanggal mulai
    });
});
</script>
@endpush
