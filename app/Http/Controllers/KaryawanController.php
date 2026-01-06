<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    // =============================
    // LIST
    // =============================
    public function index()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    // =============================
    // FORM TAMBAH
    // =============================
    public function create()
    {
        return view('admin.karyawan.create');
    }

    // =============================
    // SIMPAN USER + KARYAWAN
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'no_telp'       => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request) {

            // 1️⃣ Buat user baru
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'pegawai',
            ]);

            // 2️⃣ Buat karyawan terkait
            Karyawan::create([
                'user_id'       => $user->id, // pastikan di model & migration pakai user_id
                'nama_lengkap'  => $request->nama_lengkap,
                'no_telp'       => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);
        });

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan & akun berhasil ditambahkan.');
    }

    // =============================
    // FORM EDIT
    // =============================
    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $karyawan->user_id,
            'no_telp'       => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $karyawan) {

            // Update user terkait
            $karyawan->user->update([
                'name'  => $request->nama_lengkap,
                'email' => $request->email,
            ]);

            // Update karyawan
            $karyawan->update([
                'nama_lengkap'  => $request->nama_lengkap,
                'no_telp'       => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);
        });

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // =============================
    // HAPUS
    // =============================
    public function destroy($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        DB::transaction(function () use ($karyawan) {
            // Hapus user dulu baru karyawan
            $karyawan->user->delete();
            $karyawan->delete();
        });

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
