@extends('layouts.app')

@push('styles')
    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    {{-- Page CSS (reuse cuti style) --}}
    @vite('resources/css/cuti.css')
@endpush

@section('content')

<div class="page-cuti"><!-- ⬅️ SAMA DENGAN CUTI -->



    <h3 class="page-title mb-3">Riwayat Presensi Saya</h3>

        <a href="{{ route('pegawai.presensi.create') }}"
       class="btn btn-primary mb-3 shadow-sm btn-radius">
        + Lakukan Presensi
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-custom">
        <table id="presensiTable" class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Lokasi</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($presensis as $item)
                <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jam_masuk ?? '-' }}</td>
                    <td>{{ $item->jam_pulang ?? '-' }}</td>

                    <td>
                        @if ($item->status === 'Hadir')
                            <span class="badge-status bg-success text-white">Hadir</span>
                        @elseif ($item->status === 'Terlambat')
                            <span class="badge-status bg-warning text-dark">Terlambat</span>
                        @else
                            <span class="badge-status bg-danger text-white">
                                {{ $item->status }}
                            </span>
                        @endif
                    </td>

                    <td>
                        {{ $item->latitude }}, {{ $item->longitude }}
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

    <script>
    $(document).ready(function () {
        $('#presensiTable').DataTable({
            responsive: true,
            dom: '<"row mb-3"<"col-md-6"f><"col-md-6 text-end">>' +
                 'rt' +
                 '<"row mt-3"<"col-md-6"l><"col-md-6 text-end"p>>',
            language: {
                search: "",
                searchPlaceholder: "Cari riwayat presensi..."
            }
        });
    });
    </script>
@endpush
