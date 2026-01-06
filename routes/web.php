<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\PresensiAdminController;
use App\Http\Controllers\PresensiPegawaiController;


// =============================
// LOGIN
// =============================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =============================
// OWNER
// =============================
Route::middleware(['auth', 'checkrole:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
});


// =============================
// ADMIN
// =============================
Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Karyawan
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        // Presensi
        Route::get('/presensi', [PresensiAdminController::class, 'index'])->name('presensi.index');
});


// =============================
// PEGAWAI
// =============================
Route::middleware(['auth', 'checkrole:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {

        Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');

        // Pengajuan Cuti
        Route::get('/cuti', [PengajuanCutiController::class, 'index'])->name('cuti.index');
        Route::get('/cuti/create', [PengajuanCutiController::class, 'create'])->name('cuti.create');
        Route::post('/cuti', [PengajuanCutiController::class, 'store'])->name('cuti.store');
        Route::get('/cuti/{id}/edit', [PengajuanCutiController::class, 'edit'])->name('cuti.edit');
        Route::put('/cuti/{id}', [PengajuanCutiController::class, 'update'])->name('cuti.update');
        Route::delete('/cuti/{id}', [PengajuanCutiController::class, 'destroy'])->name('cuti.delete');

        // Presensi
        // Presensi Pegawai
        Route::get('/presensi', [PresensiPegawaiController::class, 'index'])->name('presensi.index');
        Route::get('/presensi/create', [PresensiPegawaiController::class, 'create'])->name('presensi.create');
        Route::post('/presensi', [PresensiPegawaiController::class, 'store'])->name('presensi.store');

});

