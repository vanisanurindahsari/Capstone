<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class PengajuanCutiController extends Controller
{
    // =========================
    // PEGAWAI
    // =========================
    public function index()
    {
        $pengajuan = PengajuanCuti::where('user_id', Auth::id())->latest()->get();
        return view('pegawai.pengajuan-cuti.index', compact('pengajuan'));
    }

    public function create()
    {
        return view('pegawai.pengajuan-cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_induk_karyawan' => 'required',
            'jenis_cuti' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jumlah_hari' => 'required|integer',
            'alasan' => 'required',
        ]);

        PengajuanCuti::create([
            'user_id' => Auth::id(),
            'nomor_induk_karyawan' => $request->nomor_induk_karyawan,
            'jenis_cuti' => $request->jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_hari' => $request->jumlah_hari,
            'alasan' => $request->alasan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('pegawai.cuti.index')
            ->with('success', 'Pengajuan cuti berhasil diajukan!');
    }

    public function edit($id)
    {
        $pengajuan = PengajuanCuti::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Data tidak bisa diedit karena sudah diproses!');
        }

        return view('pegawai.pengajuan-cuti.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_induk_karyawan' => 'required',
            'jenis_cuti' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jumlah_hari' => 'required|integer',
            'alasan' => 'required',
        ]);

        $pengajuan = PengajuanCuti::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Data tidak bisa diubah karena sudah diproses!');
        }

        $pengajuan->update($request->all());

        return redirect()->route('pegawai.cuti.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanCuti::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Data tidak bisa dihapus karena sudah diproses!');
        }

        $pengajuan->delete();

        return redirect()->route('pegawai.cuti.index')
            ->with('success', 'Pengajuan cuti berhasil dihapus!');
    }

    // =========================
    // OWNER
    // =========================
    public function dashboardOwner()
    {
        $pengajuan = PengajuanCuti::latest()->get();
        return view('owner.dashboard', compact('pengajuan'));
    }

    public function exportPdf()
    {
        $pengajuan = PengajuanCuti::latest()->get();

        $pdf = Pdf::loadView('owner.pengajuan-cuti-pdf', compact('pengajuan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('pengajuan-cuti-karyawan.pdf');
    }
}
