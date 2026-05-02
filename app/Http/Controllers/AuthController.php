<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // proses login
    public function loginProses(Request $request)
    {
     $request->validate([
            'email'    => 'required', 
            'password' => 'required|min:8',
        ],[
            'email.required'  =>'email tidak boleh kosong',
            'password.required'  =>'password tidak boleh kosong',
            'password.min'  =>'password minimal 8 karakter',

        ]);   
        $data =array(
            'email'     => $request -> email,
            'password'  => $request -> password,
        );
         if (Auth::attempt($data)) {
        $request->session()->regenerate(); // Penting untuk keamanan

        if (auth()->user()->role == 'admin') {
            return redirect()->route('dashboard')
                ->with('success', 'Anda berhasil login sebagai admin');
        } else if (auth()->user()->role == 'Petugas') {
            return redirect('/petugas/dashboard') // Pastikan nama route ini benar
                ->with('success', 'Anda berhasil login sebagai petugas');
        }
    } else {
        return redirect()->back()
            ->with('error', 'Email atau password salah')
            ->withInput(); // Jangan lupa withInput()
    }
}

     // logout
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login')->with('success','anda berhasil logout'); 
    }
}
    

