<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = ['nama_pengajuan','jumlah', 'tanggal', 'id_divisi', 'id_rekening','id_anggaran','status']; // Tambahkan 'tipe_transaksi'
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

    // Relasi ke Anggaran
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran');
    }
}
