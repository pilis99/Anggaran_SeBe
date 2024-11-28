<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rekening;
use App\TahunAktif;
use Illuminate\Support\Facades\DB;  // Tambahkan baris ini

class ManageDataController extends Controller
{
    public function index(Request $request)
    {
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $rekings = Rekening::all(); // Ambil semua data rekening
        // Tahun yang dipilih pengguna
        $selectedYear = $request->get('tahun');

        // Jika tidak ada tahun yang dipilih, gunakan tahun aktif
        if (!$selectedYear) {
            $activeYear = TahunAktif::getTahunAktif();
            if ($activeYear) {
                $selectedYear = $activeYear->tahun;
            } else {
                return redirect()->back()->withErrors(['message' => 'Tidak ada tahun aktif']);
            }
        }
        return view('ManageData/index', compact('rekings','years','selectedYear')); // Kirim data rekening ke view
    }

    public function createRekening(Request $request)
    {
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $selectedYear = $request->get('tahun');

        // Jika tidak ada tahun yang dipilih, gunakan tahun aktif
        if (!$selectedYear) {
            $activeYear = TahunAktif::getTahunAktif();
            if ($activeYear) {
                $selectedYear = $activeYear->tahun;
            } else {
                return redirect()->back()->withErrors(['message' => 'Tidak ada tahun aktif']);
            }
        }
        return view('ManageData/create', compact('years','selectedYear')); // Halaman untuk form tambah rekening
    }

    public function storeRekening(Request $request)
    {
        // Validasi data rekening
        $request->validate([
            'nomor_rek' => 'required|string|max:255|unique:rekening,nomor_rek', // Validasi unique
            'alokasi_rekening' => 'required|string|max:255',
            'jenis_rek' => 'required|string|max:255',
        ], [
            'nomor_rek.unique' => 'Nomor rekening sudah ada. Silakan masukkan nomor rekening yang berbeda.', // Pesan kesalahan khusus
        ]);

        // Menyimpan data rekening baru
        $rekening = new Rekening();
        $rekening->nomor_rek = $request->nomor_rek;
        $rekening->alokasi_rekening = $request->alokasi_rekening;
        $rekening->jenis_rek = $request->jenis_rek;
        $rekening->save();

        return redirect()->route('manage.data')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function editRekening($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('ManageData/edit', compact('rekening')); // Buat view edit untuk rekening
    }

    public function destroyRekening($id)
    {
        \Log::info("Menghapus rekening dengan ID: " . $id); // Tambahkan log
        $rekening = Rekening::findOrFail($id);
        if ($rekening->anggaran()->count() > 0) {
            return redirect()->route('manage.data')->with('error', 'Rekening tidak dapat dihapus karena sudah berelasi di tabel anggaran.');
        }
        $rekening->delete();

        return redirect()->route('manage.data')->with('success', 'Rekening berhasil dihapus.');
    }

    public function updateRekening(Request $request, $id)
    {
        // Validasi data rekening
        $request->validate([
            'nomor_rek' => 'required|string|max:255|unique:rekening,nomor_rek,' . $id . ',id_rekening', // Ganti 'id' dengan 'id_rekening'
            'alokasi_rekening' => 'required|string|max:255',
            'jenis_rek' => 'required|string|max:255',
        ]);

        // Temukan rekening dan perbarui
        $rekening = Rekening::findOrFail($id);
        $rekening->nomor_rek = $request->nomor_rek;
        $rekening->alokasi_rekening = $request->alokasi_rekening;
        $rekening->jenis_rek = $request->jenis_rek;
        $rekening->save();

        return redirect()->route('manage.data')->with('success', 'Rekening berhasil diperbarui.');
    }
}
