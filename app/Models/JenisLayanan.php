<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    protected $fillable = [
        'instansi_id',
        'nama_layanan',
        'deskripsi',
        'estimasi_waktu',
        'status'
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}