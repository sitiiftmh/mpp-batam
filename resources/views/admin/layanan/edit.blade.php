@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-edit mr-2"></i>
    Edit Jenis Layanan
</h1>

<div class="card">
    <div class="card-body">

        <form action="{{ route('layananUpdate',$layanan->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text"
                       name="nama_layanan"
                       value="{{ $layanan->nama_layanan }}"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>Kode</label>
                <input type="text"
                       name="kode"
                       value="{{ $layanan->kode }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control">{{ $layanan->deskripsi }}</textarea>
            </div>

            <div class="form-group">
                <label>Instansi</label>
                <select name="instansi_id" class="form-control">
                    @foreach ($instansi as $item)
                        <option value="{{ $item->id }}"
                            {{ $layanan->instansi_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_instansi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status</label><br>
                <input type="radio" name="status" value="1"
                    {{ $layanan->status ? 'checked' : '' }}> Aktif
                <input type="radio" name="status" value="0" class="ml-3"
                    {{ !$layanan->status ? 'checked' : '' }}> Non Aktif
            </div>

            <div class="text-right">
                <button class="btn btn-success">
                    <i class="fas fa-save mr-2"></i> Update
                </button>

                <a href="{{ route('layananDelete',$layanan->id) }}"
                   onclick="return confirm('Yakin hapus?')"
                   class="btn btn-danger">
                    Hapus
                </a>

                <a href="{{ route('layanan') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
