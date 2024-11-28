<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{

    protected $table = 'dokumen';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = ['nama_dok', 'tanggal', 'lokasi_dok', 'id_realisasi', 'id_anggaran'];

    // Relasi ke realisasi
    public function realisasi()
    {
        return $this->belongsTo(Realisasi::class, 'id_realisasi');
    }

    // Relasi ke anggaran
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }
}

