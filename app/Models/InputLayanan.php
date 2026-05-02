<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputLayanan extends Model
{
     protected $table = 'input_layanans';

    protected $fillable = [
        'tanggal',
        'jenis_layanan_id',
        'instansi_id',
        'user_id',
        'jumlah_layanan',
        'jumlah_kunjungan',
        'status',
        'alasan_penolakan'
    ];
        public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
