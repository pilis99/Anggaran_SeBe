<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Userr; // Import model Userr
use App\Divisi; // Import model Divisi
use App\TahunAktif;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function index(Request $request)
    {
        $users = Userr::all(); // Ambil semua data pengguna
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
        return view('KelolaUser/index', compact('users','years','selectedYear')); // Kirim data pengguna ke view
    }

    public function destroy($id)
    {
        $user = Userr::findOrFail($id);

        // Hapus pengguna
        $user->delete();

        return redirect()->route('manage.user')->with('success', 'Pengguna berhasil dihapus.');
    }

    // Menampilkan form pendaftaran
    public function showRegistrationForm()
    {
        $divisis = Divisi::all(); // Ambil semua data divisi
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        return view('KelolaUser.create', compact('divisis','years')); // Kirim data divisi ke view
    }

    public function editUser($id)
    {
        $user = Userr::findOrFail($id); // Ambil data pengguna berdasarkan ID
        $divisis = Divisi::all(); // Ambil semua divisi
        $years = DB::table('tahun_aktif')->distinct()->pluck('tahun');

        return view('KelolaUser.edit', compact('user', 'divisis','years')); // Kirim data pengguna dan divisi ke view
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userr',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'id_divisi' => 'required_if:role,kepala_divisi|exists:divisi,id_divisi', // Validasi untuk id_divisi jika role adalah kepala_divisi
        ]);

        Userr::create([
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password,
            'id_divisi' => $request->role === 'kepala_divisi' ? $request->id_divisi : null, // Menyimpan id_divisi hanya jika role adalah kepala_divisi
        ]);

        return redirect()->route('manage.user')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = Userr::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userr,email,' . $id . ',id_user',
            'role' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed', // Password bisa kosong
            'id_divisi' => 'required_if:role,kepala_divisi|exists:divisi,id_divisi', // Validasi untuk id_divisi jika role adalah kepala_divisi
        ]);

        $user->nama_user = $request->nama_user;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        // Update id_divisi hanya jika role adalah kepala_divisi
        if ($request->role === 'kepala_divisi') {
            $user->id_divisi = $request->id_divisi;
        }

        $user->save();

        return redirect()->route('manage.user')->with('success', 'Pengguna berhasil diperbarui.');
    }
}
