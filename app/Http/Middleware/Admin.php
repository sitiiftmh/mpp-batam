<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login dulu');
        }
        // Cek apakah role user adalah admin
        if (Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, redirect ke halaman yang sesuai
        if (Auth::user()->role == 'Petugas') {
            return redirect()->route('petugas.dashboard')->with('error', 'Halaman khusus admin');
        }

        // Kalau role lain
        return redirect()->route('login')->with('error', 'Akses ditolak');
    }
}