<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pengajuan Cuti Karyawan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .status-menunggu {
            background-color: #fff3cd;
            font-weight: bold;
        }
        .status-disetujui {
            background-color: #d4edda;
            font-weight: bold;
        }
        .status-ditolak {
            background-color: #f8d7da;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h3>Data Pengajuan Cuti Karyawan</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Jenis Cuti</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Jumlah Hari</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengajuan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nomor_induk_karyawan }}</td>
            <td>{{ $item->jenis_cuti }}</td>
            <td>{{ $item->tanggal_mulai }}</td>
            <td>{{ $item->tanggal_selesai }}</td>
            <td>{{ $item->jumlah_hari }}</td>
            <td
                class="
                    @if($item->status === 'Menunggu') status-menunggu
                    @elseif($item->status === 'Disetujui') status-disetujui
                    @else status-ditolak
                    @endif
                ">
                {{ $item->status }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
