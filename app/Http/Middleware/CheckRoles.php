<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Cek apakah role user ada di dalam database (misalnya di tabel Userr)
        if ($user && $user->role === $role) {
            return $next($request);
        }

        // Jika tidak memiliki role yang sesuai, redirect ke halaman lain atau error
        return redirect()->route('login'); // Anda bisa mengganti ini dengan halaman yang sesuai
    }
}

