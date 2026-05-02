<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Models\InputLayanan;
use Illuminate\Http\Request;

class PetugasController extends Controller
{

    public function dashboard()
    {
        return view('petugas.dashboard');
    }

    public function input()
    {
        
        // Ambil jenis layanan berdasarkan instansi petugas yang login
        $layanan = JenisLayanan::where('instansi_id', auth()->user()->instansi)->get();        
        return view('petugas.input.index', [
            'title' => 'Input Layanan',
            'layanan' => $layanan
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_layanan_id' => 'required|array|min:1',
            'jenis_layanan_id.*' => 'required|exists:jenis_layanans,id',
            'jumlah_layanan' => 'required|array|min:1',
            'jumlah_layanan.*' => 'required|integer|min:1',
            'jumlah_kunjungan' => 'required|array|min:1',
            'jumlah_kunjungan.*' => 'required|integer|min:1',
        ]);

        // Simpan multiple data
        foreach($request->jenis_layanan_id as $key => $jenisLayananId) {
            InputLayanan::create([
                'tanggal' => $request->tanggal,
                'jenis_layanan_id' => $jenisLayananId,
                'jumlah_layanan' => $request->jumlah_layanan[$key],
                'jumlah_kunjungan' => $request->jumlah_kunjungan[$key],
                'instansi_id' => auth()->user()->instansi,
                'user_id' => auth()->id(),
                'status' => 'pending'
            ]);
        }

        return redirect()->route('petugas.input')->with('success', count($request->jenis_layanan_id) . ' data layanan berhasil disimpan!');
    }

    public function riwayat()
    {
        $riwayat = InputLayanan::with(['jenisLayanan', 'user'])
                    ->where('user_id', auth()->id())
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('petugas.riwayat.index', [
            'title' => 'Riwayat Input Layanan',
            'menuPetugasRiwayat' => 'active',
            'riwayat' => $riwayat
        ]);
    }

    public function editData($id)
    {
        $data = InputLayanan::with('jenisLayanan')
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->firstOrFail();

        $layanan = JenisLayanan::where('instansi_id', auth()->user()->instansi)->get();

        return view('petugas.riwayat.edit', [
            'title' => 'Edit Data Layanan',
            'data' => $data,
            'layanan' => $layanan
        ]);
    }

    public function updateData(Request $request, $id)
    {
        $input = InputLayanan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->firstOrFail();

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_layanan_id' => 'required|exists:jenis_layanans,id',
            'jumlah_layanan' => 'required|integer|min:1',
            'jumlah_kunjungan' => 'required|integer|min:1',
        ]);

        $input->update([
            'tanggal' => $request->tanggal,
            'jenis_layanan_id' => $request->jenis_layanan_id,
            'jumlah_layanan' => $request->jumlah_layanan,
            'jumlah_kunjungan' => $request->jumlah_kunjungan,
        ]);

        return redirect()->route('petugas.riwayat')->with('success', 'Data berhasil diperbarui.');
    }

    public function hapusData($id)
    {
        $input = InputLayanan::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->firstOrFail();

        $input->delete();

        return redirect()->route('petugas.riwayat')->with('success', 'Data berhasil dihapus.');
    }
}