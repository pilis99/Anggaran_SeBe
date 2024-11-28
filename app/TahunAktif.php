<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TahunAktif extends Model
{
    public $timestamps = false;
    protected $table = 'tahun_aktif'; // Nama tabel
    protected $primaryKey = 'id_tahun'; // Primary key
    protected $fillable = ['tahun', 'status']; // Kolom yang bisa diisi

    // Fungsi untuk mendapatkan tahun aktif
    public static function getTahunAktif()
    {
        return self::where('status', 'aktif')->first();
        // return DB::table('tahun_aktif')->where('status', 'aktif')->value('tahun') ?? date('Y');
    }


    // Fungsi untuk memperbarui status tahun aktif
    public static function updateTahunAktif()
    {
        $currentYear = date('Y'); // Ambil tahun sekarang

        // Pastikan tahun saat ini sudah ada di tabel sebelum diupdate
        if (DB::table('tahun_aktif')->where('tahun', $currentYear)->exists()) {
            // Nonaktifkan semua tahun
            DB::table('tahun_aktif')->update(['status' => 'tidak_aktif']);

            // Aktifkan tahun sesuai tahun sekarang
            DB::table('tahun_aktif')->where('tahun', $currentYear)->update(['status' => 'aktif']);
        } else {
            // Jika tahun sekarang belum ada di tabel, tambahkan sebagai tahun aktif
            DB::table('tahun_aktif')->insert([
                'tahun' => $currentYear,
                'status' => 'aktif',
            ]);
        }
    }

}
