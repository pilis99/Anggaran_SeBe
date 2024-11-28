<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{

    protected $table = 'realisasi';
    protected $primaryKey = 'id_realisasi';
    protected $fillable = ['nama', 'jumlah_realisasi', 'id_anggaran'];

    // Relasi ke anggaran
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }
}

