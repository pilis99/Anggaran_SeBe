<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    public $timestamps = false;
    protected $table = 'divisi';
    protected $primaryKey = 'id_divisi';
    protected $fillable = ['nama_divisi'];

    // Relasi ke Userr
    public function users()
    {
        return $this->hasMany(Userr::class, 'id_divisi'); // Menghubungkan dengan id_divisi di tabel userr
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_divisi'); // Sesuaikan dengan kolom yang ada di tabel pengajuan
    }
}
