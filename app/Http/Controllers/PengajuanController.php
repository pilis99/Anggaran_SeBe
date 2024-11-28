<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengajuan;
use App\Divisi;
use App\Anggaran;
use App\Rekening;
use App\TahunAktif;
use Illuminate\Support\Facades\DB;

class pengajuanController extends Controller
{
    // Menampilkan semua data pengajuan
    public function show(Request $request)
    {

        // Ambil tahun aktif
        $activeYear = TahunAktif::getTahunAktif();
        if (!$activeYear) {
            TahunAktif::updateTahunAktif();
            $activeYear = TahunAktif::getTahunAktif();
            return redirect()->back()->withErrors(['message' => 'Tidak ada tahun aktif yang tersedia.']);
        }

        // Ambil tahun yang dipilih dari request atau gunakan tahun aktif
        $selectedYear = $request->get('tahun', $activeYear->tahun);

        // Ambil ID divisi dari pengguna yang login
        $userDivisiId = auth()->user()->divisi->id_divisi;

        // Mengambil semua data pengajuan berdasarkan divisi pengguna dan tahun yang dipilih
        $pengajuans = Pengajuan::with('divisi', 'anggaran')
            ->where('id_divisi', $userDivisiId)
            ->whereYear('tanggal', $selectedYear)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Ambil data rekening dan anggaran untuk form (opsional)
        $divisis = Divisi::all();
        $rekings = Rekening::all();
        $anggarans = Anggaran::where('id_divisi', $userDivisiId)->get();

        // Hitung total anggaran divisi pengguna untuk tahun yang dipilih
        $totalAnggaran = Anggaran::selectRaw('SUM(jumlah) as total')
            ->where('id_divisi', $userDivisiId)
            ->whereYear('tanggal', $selectedYear)
            ->value('total') ?? 0;

        // Hitung total pengeluaran yang disetujui dari pengajuan
        $totalPengeluaran = $pengajuans->where('status', 'Disetujui')->sum('jumlah');

        // Hitung total penerimaan dari anggaran (tipe_anggaran = 'penerimaan')
        $totalPenerimaan = Anggaran::where('id_divisi', $userDivisiId)
            ->where('tipe_anggaran', 'penerimaan')
            ->whereYear('tanggal', $selectedYear)
            ->sum('jumlah');

        $sisaSaldoDivisi = [];
        foreach ($anggarans as $anggaran) {
            $sisaSaldoDivisi[$anggaran->id_divisi] = $totalAnggaran; // Awal saldo sesuai total anggaran divisi
        }


        // Menghitung total saldo dengan mengurangi total pengeluaran dari total penerimaan + anggaran
        $totalSaldo = $totalPenerimaan + $totalAnggaran - $totalPengeluaran;

        // Ambil daftar tahun dari tabel tahun aktif
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        // Kirim data ke view
        return view('pengajuan', compact(
            'pengajuans',
            'rekings',
            'divisis',
            'anggarans',
            'totalAnggaran',
            'sisaSaldoDivisi',
            'totalSaldo',
            'years',
            'selectedYear'
        ));
    }


    // Menampilkan form pengajuan
    public function create()
    {
        $divisis = Divisi::all();
        $anggarans = Anggaran::all();
        return view('pengajuan.create', compact('divisis', 'anggarans'));
    }

    // Menyimpan data pengajuan
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'id_divisi' => 'required|exists:divisi,id_divisi',
            'id_rekening' => 'required|exists:rekening,id_rekening',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'nama_pengajuan' => 'required|string',
            'id_anggaran' => 'required|exists:anggaran,id_anggaran', // Pastikan id_anggaran ada
        ]);

        // Mendapatkan tahun dari tanggal input
        $tahunInput = \Carbon\Carbon::parse($request->tanggal)->year;

        // Cek apakah tahun input sesuai dengan tahun aktif
        $activeYear = TahunAktif::getTahunAktif();
        if (!$activeYear || $activeYear->tahun != $tahunInput) {
            return redirect()->back()->withErrors(['message' => 'Pengajuan hanya dapat dilakukan untuk tahun aktif.'])->withInput();
        }

        // Menyimpan pengajuan baru
        $pengajuan = new Pengajuan();
        $pengajuan->id_divisi = $request->id_divisi;
        $pengajuan->id_rekening = $request->id_rekening;
        $pengajuan->jumlah = $request->jumlah;
        $pengajuan->tanggal = $request->tanggal;
        $pengajuan->nama_pengajuan = $request->nama_pengajuan;  // Nama pengajuan disimpan
        $pengajuan->id_anggaran = $request->id_anggaran;  // ID anggaran disimpan
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function edit($id)
    {
        // Ambil data pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);
        $divisis = Divisi::all();
        $anggarans = Anggaran::all();
        $rekings = Rekening::all();

        return view('editPengajuan', compact('pengajuan', 'divisis', 'anggarans', 'rekings'));
    }

    // Mengupdate data pengajuan
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'id_divisi' => 'required|exists:divisi,id_divisi',
            'id_rekening' => 'required|exists:rekening,id_rekening',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'nama_pengajuan' => 'required|string',
            'id_anggaran' => 'required|exists:anggaran,id_anggaran', // Pastikan id_anggaran ada
        ]);

        // Mengambil pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->id_divisi = $request->id_divisi;
        $pengajuan->id_rekening = $request->id_rekening;
        $pengajuan->jumlah = $request->jumlah;
        $pengajuan->tanggal = $request->tanggal;
        $pengajuan->nama_pengajuan = $request->nama_pengajuan;  // Nama pengajuan disimpan
        $pengajuan->id_anggaran = $request->id_anggaran;  // ID anggaran disimpan
        $pengajuan->save();

        return redirect()->route('pengajuan.show')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    // Menghapus data pengajuan
    public function destroy($id)
    {
        // Mengambil pengajuan berdasarkan ID
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan.show')->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function index(Request $request)
    {
        $divisions = Divisi::withCount('pengajuan')->get(); // Ambil divisi dengan jumlah pengajuan
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');
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
        return view('Admin.Pengajuan.index', compact('divisions', 'years', 'selectedYear'));
    }

    public function detail($id)
    {
        // dd($id);
        $division = Divisi::findOrFail($id);
        $pengajuans = Pengajuan::where('id_divisi', $id)->get();
        // dd($division);
        // Menghitung sisa saldo divisi
        $totalAnggaran = Anggaran::where('id_divisi', $id)->sum('jumlah');
        $totalPengeluaran = $pengajuans->sum('jumlah');
        $sisaSaldoDivisi = $totalAnggaran - $totalPengeluaran;

        return view('Admin.Pengajuan.detail', compact('division', 'pengajuans', 'sisaSaldoDivisi'));
    }


    public function updateStatus(Request $request)
    {
        $pengajuan = Pengajuan::findOrFail($request->id);
        $pengajuan->status = $request->status;
        $pengajuan->save();

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

}
