<?php

namespace App\Http\Controllers\Auth;

use App\Userr; // Pastikan Anda mengimpor model Userr
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Import Request

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.login'); // Pastikan view ini mengarah ke file login yang benar
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Userr::where('email', $request->email)->first();

        // Cek kredensial
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     // Jika login berhasil, periksa peran pengguna
        //     $user = Auth::userr();
        //     dd($user);
        if ($user && $user->password == $request->password) {
            // Jika login berhasil, periksa peran pengguna
            Auth::login($user);

            if ($user->role == Userr::ROLE_ADMIN) {
                return redirect()->intended('home/admin'); // Halaman untuk admin
            } elseif ($user->role == Userr::ROLE_KADIV) {
                return redirect()->intended('home/kadiv'); // Halaman untuk kepala divisi
            }

        }

        // Jika login gagal
        return redirect()->back()->withErrors(['email' => 'Kredensial tidak valid.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Menghapus semua data sesi
        $request->session()->regenerateToken(); // Mengamankan token sesi baru

        return redirect('/login'); // Arahkan kembali ke halaman login setelah logout
    }

}
