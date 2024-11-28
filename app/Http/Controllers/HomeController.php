<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Userr;
use App\TahunAktif;
use Illuminate\Support\Facades\DB;  // Tambahkan baris ini

class HomeController extends Controller
{
    public function homeKadiv()
    {
        // Ambil data tahun dan tahun aktif
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $activeYear = DB::table('tahun_aktif')->where('status', true)->value('tahun');
        // Tentukan tahun yang dipilih (gunakan tahun aktif atau request dari pengguna)
        $selectedYear = request()->get('tahun', $activeYear);

        // Validasi peran pengguna
        if (auth()->user()->role === Userr::ROLE_KADIV) {
            return view('home_kadiv', compact('years', 'activeYear', 'selectedYear'));
        }

        // Jika bukan Kadiv, arahkan ke metode untuk admin
        return $this->homeAdmin();
    }

    public function homeAdmin()
    {
        // Ambil data tahun dan tahun aktif
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $activeYear = DB::table('tahun_aktif')->where('status', true)->value('tahun');
        // Tentukan tahun yang dipilih (gunakan tahun aktif atau request dari pengguna)
        $selectedYear = request()->get('tahun', $activeYear);
        // Render view untuk admin
        return view('home_admin', compact('years', 'activeYear','selectedYear'));
    }

}
