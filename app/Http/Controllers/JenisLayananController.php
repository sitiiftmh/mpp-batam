<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Models\Instansi;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
   public function index(Request $request)
{
    $instansi = Instansi::where('status',1)->get();

    $selectedInstansi = $request->instansi_id;

    $layanan = [];

    if ($selectedInstansi) {
        $layanan = JenisLayanan::where('instansi_id', $selectedInstansi)->get();
    }

    $data = [
        "title" => "Kelola Jenis Layanan",
        "menuLayanan" => "active",
        "instansi" => $instansi,
        "selectedInstansi" => $selectedInstansi,
        "layanan" => $layanan
    ];

    return view('admin.layanan.index', $data);
}

 public function create(Request $request)
{
    $instansi_id = $request->instansi_id;

    $data = [
        "title" => "Tambah Jenis Layanan",
        "menuLayanan" => "active",
        "instansi" => Instansi::where('status', 1)->get(),
        "selectedInstansi" => $instansi_id
    ];

    return view('admin.layanan.create', $data);
}


    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required',
            'nama_layanan' => 'required',
        ]);

        JenisLayanan::create($request->all());

        return redirect()->route('layanan')->with('success','Layanan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            "title" => "Edit Jenis Layanan",
            "menuLayanan" => "active",
            "layanan" => JenisLayanan::findOrFail($id),
            "instansi" => Instansi::where('status',1)->get()
        ];

        return view('admin.layanan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'instansi_id' => 'required',
            'nama_layanan' => 'required',
        ]);

        $layanan = JenisLayanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('layanan')->with('success','Layanan berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisLayanan::findOrFail($id)->delete();

        return redirect()->route('layanan')->with('success','Layanan berhasil dihapus');
    }
}
