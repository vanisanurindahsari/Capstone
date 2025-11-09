<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;

Route::get('/', function () {
    return view('/login');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Role Views
Route::middleware(['auth', 'checkrole:owner'])->get('/owner/dashboard', function () {
    return view('/owner/dashboard');
});
Route::middleware(['auth', 'checkrole:admin'])->get('/admin/dashboard', function () {
    return view('/admin/dashboard');
});
Route::middleware(['auth', 'checkrole:pegawai'])->get('/pegawai/dashboard', function () {
    return view('/pegawai/dashboard');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
Route::get('/pegawai/dashboard', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
