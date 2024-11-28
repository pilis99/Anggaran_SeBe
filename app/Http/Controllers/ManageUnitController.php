<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Divisi;
use App\TahunAktif;
use Illuminate\Support\Facades\DB; 

class ManageUnitController extends Controller
{
    // Menampilkan daftar unit
    public function index(Request $request)
    {
        // Ambil semua data unit dari database
        $divisis = Divisi::all();
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $activeYear = TahunAktif::getTahunAktif();
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
        // Kirim data unit ke view
        return view('KelolaUnit.index', compact('divisis','years','activeYear','selectedYear'));
    }
    // Menampilkan halaman tambah data Unit/Divisi
    public function create()
    {
        // Mengambil ID terakhir dan menghitung ID berikutnya
        $lastDivisi = Divisi::orderBy('id_divisi', 'desc')->first();
        $nextId = $lastDivisi ? $lastDivisi->id_divisi + 1 : 1;
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        return view('KelolaUnit.create', compact('nextId','years'));
    }

    // Menyimpan data Unit/Divisi baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
        ]);

        // Menyimpan data ke database
        $divisi = new Divisi();
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->save();

        return redirect()->route('manage.unit')->with('success', 'Data unit berhasil ditambahkan.');
    }

    // Menampilkan halaman edit data Unit/Divisi
    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id); // Mengambil data berdasarkan ID

        return view('KelolaUnit.edit', compact('divisi'));
    }

    // Memperbarui data Unit/Divisi
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
        ]);

        // Update data di database
        $divisi = Divisi::findOrFail($id);
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->save();

        return redirect()->route('manage.unit')->with('success', 'Data unit berhasil diperbarui.');
    }

    // Menghapus data Unit/Divisi
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id); // Mengambil data berdasarkan ID
        $divisi->delete();

        return redirect()->route('manage.unit')->with('success', 'Data unit berhasil dihapus.');
    }
}
