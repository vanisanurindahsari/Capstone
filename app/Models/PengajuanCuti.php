<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_induk_karyawan',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
