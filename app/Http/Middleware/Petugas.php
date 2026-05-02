<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class Petugas
{
    public function handle(Request $request, Closure $next): Response
    {
        // kalau belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // kalau role petugas boleh lanjut
        if (Auth::user()->role == 'Petugas') {
            return $next($request);
        }
 
        // kalau admin masuk ke dashboard admin
        if (Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}