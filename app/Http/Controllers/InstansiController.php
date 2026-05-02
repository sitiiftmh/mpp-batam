<?php
namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        $data = [
            "title" => "Data Instansi",
            "menuInstansi" => "active",
            "instansi" => Instansi::latest()->get()
        ];

        return view('admin.instansi.index', $data);
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Instansi",
            "menuInstansi" => "active"
        ];

        return view('admin.instansi.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_instansi' => 'required|unique:instansis,kode_instansi',
            'nama_instansi' => 'required',
        ],[
            'kode_instansi.required' => 'Kode instansi wajib diisi',
            'kode_instansi.unique'   => 'Kode sudah digunakan',
            'nama_instansi.required' => 'Nama instansi wajib diisi',
        ]);

        Instansi::create([
            'kode_instansi' => $request->kode_instansi,
            'nama_instansi' => $request->nama_instansi,
            'kontak_person' => $request->kontak_person,
            'telepon' => $request->telepon,
            'status' => $request->status
        ]);

        return redirect()->route('instansi')->with('success','Instansi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            "title" => "Edit Instansi",
            "menuInstansi" => "active",
            "instansi" => Instansi::findOrFail($id)
        ];

        return view('admin.instansi.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_instansi' => 'required|unique:instansis,kode_instansi,'.$id,
            'nama_instansi' => 'required',
        ]);

        $instansi = Instansi::findOrFail($id);

        $instansi->update([
            'kode_instansi' => $request->kode_instansi,
            'nama_instansi' => $request->nama_instansi,
            'kontak_person' => $request->kontak_person,
            'telepon' => $request->telepon,
            'status' => $request->status
        ]);

        return redirect()->route('instansi')->with('success','Instansi berhasil diupdate');
    }

    public function destroy($id)
    {
        Instansi::findOrFail($id)->delete();

        return redirect()->route('instansi')->with('success','Instansi berhasil dihapus');
    }
}
