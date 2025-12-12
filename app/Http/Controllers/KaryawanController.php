<?php

namespace App\Http\Controllers;


use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
        // Tampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    // Form tambah karyawan
    public function create()
    {
        $users = User::all(); // List user yg bisa dipilih
        return view('admin.karyawan.create', compact('users'));
    }

    // Simpan karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_user'        => 'required|exists:users,id',
            'nama_lengkap'   => 'required|string',
            'no_telp'        => 'nullable|string',
            'jenis_kelamin'  => 'required|in:L,P',
            'alamat'         => 'nullable|string',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $users = User::all();
        return view('admin.karyawan.edit', compact('karyawan', 'users'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user'        => 'required|exists:users,id',
            'nama_lengkap'   => 'required|string',
            'no_telp'        => 'nullable|string',
            'jenis_kelamin'  => 'required|in:L,P',
            'alamat'         => 'nullable|string',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // Hapus karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
