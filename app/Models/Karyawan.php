<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
        use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'no_telp',
        'jenis_kelamin',
        'alamat',
    ];

    /**
     * Relasi ke tabel users
     * Setiap karyawan dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
