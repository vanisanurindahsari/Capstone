<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanCuti;

class OwnerController extends Controller
{
    /**
     * Update status pengajuan cuti (Disetujui / Ditolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $cuti = PengajuanCuti::findOrFail($id);
        $cuti->status = $request->status;
        $cuti->save();

        return redirect()->back()
            ->with('success', 'Status cuti berhasil diperbarui');
    }
}
