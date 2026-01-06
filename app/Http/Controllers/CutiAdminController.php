<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanCuti; 
use Illuminate\Support\Facades\Auth;

class CutiAdminController extends Controller
{
    // Hanya untuk admin
    public function index()
    {
        // Cek role user, jika bukan admin redirect
        if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'owner'){
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua data pengajuan cuti
        $pengajuan = PengajuanCuti::with('user')->orderBy('tanggal_mulai', 'desc')->get();

        return view('admin.viewdatacuti', compact('pengajuan'));
    }
}
