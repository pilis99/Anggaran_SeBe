<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran';
    protected $primaryKey = 'id_anggaran';
    protected $fillable = ['nama_anggaran', 'tipe_anggaran','tanggal', 'jumlah', 'id_rekening', 'id_divisi'];
    public $timestamps = false;

    // Relasi ke Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    // Relasi ke Rekening
    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening');
    }

    // Relasi ke Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_anggaran');
    }

}
