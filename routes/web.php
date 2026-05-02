<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPetugasController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\JenisLayananController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VertifikasiController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// dashboard publik 
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Login
Route::get('/login', [AuthController::class,'login'] )->name('login');
Route::post('/login', [AuthController::class, 'loginProses'])->name('loginProses');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','admin'])->group(function(){

//dashboard
Route::get('/dashboard', [DashboardController::class,'index'] 
)->name('dashboard');

//laporan
Route::get('/laporan/export', [DashboardController::class, 'exportLaporan'])->name('laporan.export');

//tambah akun
Route::get('/user', [UserController::class, 'index'])->name('user'); 
Route::get('/user/create', [UserController::class, 'create'])->name('userCreate'); 
Route::post('/user/store', [UserController::class, 'store'])->name('userStore'); 
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('userEdit'); 
Route::post('/user/update/{id}', [UserController::class, 'update'])->name('userUpdate'); 
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('userDestroy'); 

//kelola data instansi
Route::get('/instansi', [InstansiController::class, 'index'])->name('instansi');
Route::get('/instansi/create', [InstansiController::class,'create'])->name('instansiCreate');
Route::post('/instansi/store', [InstansiController::class,'store'])->name('instansiStore');
Route::get('/instansi/edit/{id}', [InstansiController::class,'edit'])->name('instansiEdit');
Route::post('/instansi/update/{id}', [InstansiController::class,'update'])->name('instansiUpdate');
Route::delete('/instansi/{id}', [InstansiController::class,'destroy'])->name('instansiDelete');

//kelola jenis layanan
Route::get('/layanan', [JenisLayananController::class,'index'])->name('layanan');
Route::get('/layanan/create', [JenisLayananController::class,'create'])->name('layananCreate');
Route::post('/layanan/store', [JenisLayananController::class,'store'])->name('layananStore');
Route::get('/layanan/edit/{id}', [JenisLayananController::class,'edit'])->name('layananEdit');
Route::post('/layanan/update/{id}', [JenisLayananController::class,'update'])->name('layananUpdate');
Route::delete('/layanan/{id}', [JenisLayananController::class,'destroy'])->name('layananDelete');

//kelola vertifikasi
Route::get('/Vertifikasi', [VertifikasiController::class, 'index'])->name('vertifikasi');
Route::post('/verifikasi/bulk-setujui', [VertifikasiController::class, 'bulkSetujui'])->name('verifikasi.bulk.setujui');
Route::post('/verifikasi/setujui/{id}', [VertifikasiController::class, 'setujui'])->name('verifikasi.setujui');
Route::post('/verifikasi/tolak/{id}', [VertifikasiController::class, 'tolak'])->name('verifikasi.tolak');
}); 

// dashboard petugas
Route::get('/petugas/dashboard', [DashboardPetugasController::class, 'index'])
    ->middleware(['auth','petugas'])
    ->name('petugas.dashboard');

// input layanan petugas
Route::get('/input-layanan', [PetugasController::class, 'input'])
    ->middleware(['auth','petugas'])
    ->name('petugas.input');

Route::post('/input-layanan', [PetugasController::class, 'store'])
    ->middleware(['auth','petugas'])
    ->name('petugas.store');

//riwayat data
Route::get('/riwayat-data', [PetugasController::class, 'riwayat'])
    ->middleware(['auth','petugas'])
    ->name('petugas.riwayat');
Route::get('/edit-data/{id}', [PetugasController::class, 'editData'])
    ->middleware(['auth','petugas'])
    ->name('petugas.edit');
Route::post('/update-data/{id}', [PetugasController::class, 'updateData'])
    ->middleware(['auth','petugas'])
    ->name('petugas.update');
Route::delete('/hapus-data/{id}', [PetugasController::class, 'hapusData'])
    ->middleware(['auth','petugas'])
    ->name('petugas.hapus');    