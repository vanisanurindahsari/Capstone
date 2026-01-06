<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiAdminController extends Controller
{
    /**
     * Tampilkan semua data presensi karyawan untuk admin
     */
    public function index()
    {
        // Ambil semua presensi, beserta relasi user dan karyawan
        $absensis = Presensi::with('user.karyawan')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.viewdatapresensi', compact('absensis'));
    }
}
