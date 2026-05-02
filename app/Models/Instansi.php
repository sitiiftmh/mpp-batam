<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $fillable = [
        'kode_instansi',
        'nama_instansi',
        'kontak_person',
        'telepon',
        'status',
    ];

    public function inputLayanan()
{
    return $this->hasMany(InputLayanan::class, 'instansi_id');
}
}
