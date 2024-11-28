<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggaran;
use App\Divisi;
use App\Rekening;
use Illuminate\Support\Facades\DB;
use App\TahunAktif; // Import model TahunAktif

class AnggaranController extends Controller
{
    // Menampilkan data anggaran
    public function index(Request $request)
    {
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

        // Mendapatkan id_divisi dari user yang sedang login
        $idDivisi = auth()->user()->id_divisi;

        // Mengambil data anggaran yang sesuai dengan tahun yang dipilih
        $anggarans = Anggaran::where('id_divisi', $idDivisi)
            ->whereYear('tanggal', $selectedYear)
            ->get();

        // Mengambil total saldo anggaran sesuai dengan tahun yang dipilih
        $totalSaldo = Anggaran::where('id_divisi', $idDivisi)
            ->whereYear('tanggal', $selectedYear)
            ->sum('jumlah');

        // Mengirim data anggaran dan saldo ke view
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        return view('anggaran.index', compact('anggarans', 'totalSaldo', 'years', 'selectedYear'));
    }

    // Form untuk menambah anggaran
    public function create()
    {
        // Ambil semua divisi dan rekening
        $divisis = Divisi::all();
        $rekings = Rekening::all();
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
        $activeYear = TahunAktif::getTahunAktif();

        // Cek apakah tahun aktif ada
        if ($activeYear) {
            $tahunAktif = $activeYear->tahun; // Ambil nilai tahun dari objek
        } else {
            return redirect()->back()->withErrors(['message' => 'Tidak ada tahun aktif']);
        }

        // Tentukan tahun yang dipilih (gunakan tahun aktif atau request dari pengguna)
        $selectedYear = request()->get('tahun', $tahunAktif);

        return view('anggaran.create', compact('divisis', 'rekings', 'years', 'tahunAktif', 'selectedYear'));
    }

    // Menyimpan data anggaran
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi data anggaran
        $validated = $request->validate([
            'nama_anggaran' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'id_divisi' => 'required|exists:divisi,id_divisi',
            'id_rekening' => 'required|exists:rekening,id_rekening',
            'tipe_anggaran' => 'required|string',
        ]);

        // Mendapatkan tahun aktif
        $activeYear = TahunAktif::getTahunAktif();

        // Jika tidak ada tahun aktif, tampilkan pesan error
        if ($activeYear) {
            $tahunAktif = $activeYear->tahun; // Ambil nilai tahun dari objek
        } else {
            return redirect()->back()->withErrors(['message' => 'Tidak ada tahun aktif']);
        }

        // Menyimpan data anggaran
        $anggaran = new Anggaran();
        $anggaran->nama_anggaran = $validated['nama_anggaran'];
        $anggaran->jumlah = $validated['jumlah'];
        $anggaran->tanggal = $validated['tanggal'];
        $anggaran->id_divisi = $validated['id_divisi'];
        $anggaran->id_rekening = $validated['id_rekening'];
        $anggaran->tipe_anggaran = $validated['tipe_anggaran'];
        if ($anggaran->save()) {
            return redirect()->route('manage.data.anggaran')->with('success', 'Anggaran berhasil disimpan.');
        } else {
            return redirect()->back()->withErrors(['message' => 'Anggaran gagal disimpan.']);
        }
    }

    // Menampilkan form edit anggaran
    public function edit($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        $divisis = Divisi::all();
        $rekings = Rekening::all();
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        return view('anggaran.edit', compact('anggaran', 'divisis', 'rekings', 'years'));
    }

    // Mengupdate data anggaran
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_anggaran' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'id_divisi' => 'required|exists:divisi,id_divisi',
            'id_rekening' => 'required|exists:rekening,id_rekening',
            'tipe_anggaran' => 'required|string',
        ]);

        $anggaran = Anggaran::findOrFail($id);

        // Cek apakah anggaran sesuai dengan tahun aktif
        $activeYear = TahunAktif::getTahunAktif();
        if ($anggaran->id_tahun != $activeYear->tahun) {
            return redirect()->back()->withErrors(['message' => 'Anggaran tidak dapat diubah karena tidak sesuai dengan tahun aktif.']);
        }

        $anggaran->update($validated);

        return redirect()->route('manage.data.anggaran')->with('success', 'Anggaran berhasil diperbarui.');
    }

    // Menghapus data anggaran
    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);

        // Tambahkan validasi tahun aktif jika diperlukan
        $activeYear = TahunAktif::getTahunAktif();
        if ($anggaran->id_tahun != $activeYear->tahun) {
            return redirect()->back()->withErrors(['message' => 'Anggaran ini tidak dapat dihapus karena tidak sesuai dengan tahun aktif.']);
        }

        $anggaran->delete();

        return redirect()->route('manage.data.anggaran')->with('success', 'Anggaran berhasil dihapus.');
    }
}
