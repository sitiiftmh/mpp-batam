<?php

namespace App\Http\Controllers;

use App\Models\InputLayanan;
use App\Models\Instansi;
use Illuminate\Http\Request;

class VertifikasiController extends Controller
{
    
    public function index(Request $request)
        {
        $query = InputLayanan::with(['user', 'jenisLayanan', 'instansi'])
                ->whereIn('status', ['pending', 'revisi']);

    // Filter berdasarkan instansi jika dipilih
    if ($request->filled('instansi_id')) {
        $query->where('instansi_id', $request->instansi_id);
    }

    $pendingList = $query->orderBy('created_at', 'desc')->get();

    $data = [
        'title'             => 'Verifikasi Data Layanan',
        'menuAdminVertifikasi' => 'active',
        'pendingList'       => $pendingList,
        'totalPending'      => InputLayanan::where('status', 'pending')->count(), // total semua pending
        'instansiList'      => Instansi::where('status', 1)->get(), // untuk dropdown filter
        'selectedInstansi'  => $request->instansi_id
    ];

    return view('admin.vertifikasi.index', $data);
    }

    public function bulkSetujui(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:input_layanans,id'
    ]);

    InputLayanan::where('id', $request->ids)
                ->where('status', 'pending')
                ->update(['status' => 'tervalidasi']);

    return redirect()->route('vertifikasi')->with('success', count($request->ids) . ' data berhasil disetujui.');
}

    public function setujui($id)
    {
        $input = InputLayanan::findOrFail($id);
        $input->status = 'tervalidasi';
        $input->save();

        return redirect()->route('vertifikasi')->with('success', 'Data berhasil disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255'
        ]);

        $input = InputLayanan::findOrFail($id);
        $input->status = 'revisi';
        $input->alasan_penolakan = $request->alasan_penolakan;
        $input->save();

        return redirect()->route('vertifikasi')->with('success', 'Data ditolak dengan alasan.');
    }

}
