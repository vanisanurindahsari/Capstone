<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiPegawaiController extends Controller
{
    /**
     * Riwayat presensi pegawai (hanya milik sendiri)
     */
    public function index()
    {
        $presensis = Presensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pegawai.viewriwayatpresensi', compact('presensis'));
    }

    /**
     * Halaman input presensi (lakukan presensi)
     */
    public function create()
    {
        $today = Carbon::today()->toDateString();

        $presensiHariIni = Presensi::where('user_id', Auth::id())
            ->where('tanggal', $today)
            ->first();

        // Kirim variabel ke Blade agar tombol bisa berubah otomatis
        return view('pegawai.inputpresensi', compact('presensiHariIni'));
    }

    /**
     * Simpan presensi (masuk / pulang)
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude'  => 'required',
            'longitude' => 'required',
            'accuracy'  => 'nullable',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $userId = Auth::id();
        $today  = Carbon::today()->toDateString();
        $now    = Carbon::now()->format('H:i:s');

        // Ambil presensi hari ini jika sudah ada
        $presensi = Presensi::firstOrNew([
            'user_id' => $userId,
            'tanggal' => $today
        ]);

        // =============================
        // PRESENSI MASUK
        // =============================
        if (!$presensi->exists) {
            // upload foto jika ada
            $fotoPath = $request->hasFile('foto') 
                ? $request->file('foto')->store('presensi', 'public')
                : null;

            $presensi->fill([
                'jam_masuk'  => $now,
                'status'     => 'Hadir',
                'latitude'   => $request->latitude,
                'longitude'  => $request->longitude,
                'accuracy'   => $request->accuracy,
                'foto'       => $fotoPath,
            ])->save();

            return back()->with('success', 'Presensi masuk berhasil');
        }

        // =============================
        // PRESENSI PULANG
        // =============================
        if (!$presensi->jam_pulang) {
            $presensi->update([
                'jam_pulang' => $now,
            ]);

            return back()->with('success', 'Presensi pulang berhasil');
        }

        // =============================
        // SUDAH PRESENSI LENGKAP
        // =============================
        return back()->with('error', 'Anda sudah melakukan presensi hari ini');
    }
}
