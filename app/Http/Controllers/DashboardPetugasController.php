<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InputLayanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardPetugasController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
    $startOfMonth = Carbon::now()->startOfMonth();

    $data = [
        'title'            => 'Dashboard Petugas',
        'menuDashboard'    => 'active', // untuk menandai menu aktif di sidebar
        'totalHariIni'     => InputLayanan::where('user_id', auth()->id())
                                ->whereDate('tanggal', $today)
                                ->count(),
        'totalBulanIni'    => InputLayanan::where('user_id', auth()->id())
                                ->whereBetween('tanggal', [$startOfMonth, $today])
                                ->count(),
        'totalPending'     => InputLayanan::where('user_id', auth()->id())
                                ->where('status', 'pending')
                                ->count(),
        'totalDisetujui'   => InputLayanan::where('user_id', auth()->id())
                                ->where('status', 'disetujui')
                                ->count(),
    ];

    return view('petugas.dashboard', $data);
    }
}