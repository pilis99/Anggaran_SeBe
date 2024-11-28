<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    public $timestamps = false;
    protected $table = 'rekening';
    protected $primaryKey = 'id_rekening';
    protected $fillable = ['nomor_rek', 'alokasi_rekening', 'jenis_rek'];

    // Relasi ke anggaran
    public function anggaran()
    {
        return $this->hasMany(Anggaran::class, 'id_rekening');
    }
}
