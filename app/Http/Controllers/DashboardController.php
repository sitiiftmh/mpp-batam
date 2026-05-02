<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Instansi;
use App\Models\User;
use App\Models\InputLayanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    $data = [
        'title'             => 'Dashboard',
        'menuDashboard'      => 'active',
        'totalInstansi'      => Instansi::count(),
        'totalPetugas'       => User::where('role', 'petugas')->count(),
        'totalPending'       => InputLayanan::where('status', 'pending')->count(),
        'totalTerverifikasi' => InputLayanan::whereIn('status', ['disetujui', 'ditolak'])->count(), // atau hanya disetujui
        'recentPending'      => InputLayanan::with(['user', 'instansi', 'jenisLayanan'])
                                ->where('status', 'pending')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get(),
        'instansiList'       => Instansi::where('status', 1)->get(),
    ];
    return view('dashboard', $data);
}
public function exportLaporan(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'instansi_id'=> 'nullable|exists:instansis,id'
    ]);

    $fileName = 'laporan_'.$request->start_date.'_'.$request->end_date.'.xlsx';

    return Excel::download(
        new LaporanExport($request->start_date, $request->end_date, $request->instansi_id),
        $fileName
    );
}

}
