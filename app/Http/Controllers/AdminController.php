<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Presensi;
use App\Models\PengajuanCuti;
use Carbon\Carbon;

class AdminController extends Controller
{
        public function dashboard() {
       // Total karyawan
        $totalKaryawan = User::count();

        // Kehadiran hari ini
        $today = Carbon::today()->toDateString();
        $kehadiranHariIni = Presensi::whereDate('tanggal', $today)->count();

        // Kehadiran kemarin (untuk persentase)
        $yesterday = Carbon::yesterday()->toDateString();
        $kehadiranKemarin = Presensi::whereDate('tanggal', $yesterday)->count();

        $kehadiranPersen = $kehadiranKemarin
            ? round((($kehadiranHariIni - $kehadiranKemarin) / $kehadiranKemarin) * 100)
            : 100;

        // Cuti hari ini
        $cutiHariIni = PengajuanCuti::whereDate('tanggal_mulai', '<=', $today)
                                     ->whereDate('tanggal_selesai', '>=', $today)
                                     ->count();

        // Daftar karyawan cuti hari ini
        $karyawanCuti = PengajuanCuti::with('user')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->get();

        // Daftar karyawan sudah hadir hari ini
        $sudahHadir = Presensi::with('user')
            ->whereDate('tanggal', $today)
            ->get();

        // Daftar karyawan belum hadir hari ini
        $belumHadir = User::whereDoesntHave('presensi', function($q) use ($today) {
            $q->whereDate('tanggal', $today);
        })->get();

        // Chart data 7 hari terakhir
        $chartLabels = [];
        $chartHadir  = [];
        $chartCuti   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $chartLabels[] = Carbon::parse($date)->format('d M');
            $chartHadir[]  = Presensi::whereDate('tanggal', $date)->count();
            $chartCuti[]   = PengajuanCuti::whereDate('tanggal_mulai', '<=', $date)
                                           ->whereDate('tanggal_selesai', '>=', $date)
                                           ->count();
        }

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'kehadiranHariIni',
            'kehadiranPersen',
            'cutiHariIni',
            'karyawanCuti',
            'sudahHadir',
            'belumHadir',
            'chartLabels',
            'chartHadir',
            'chartCuti'
        ));
    }
}