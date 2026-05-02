@extends('layouts/app')

@section('content')
<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-edit mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('instansiUpdate',$instansi->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Kode Instansi</label>
                <input type="text" name="kode_instansi"
                       value="{{ $instansi->kode_instansi }}"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Instansi</label>
                <input type="text" name="nama_instansi"
                       value="{{ $instansi->nama_instansi }}"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kontak Person</label>
                <input type="text" name="kontak_person"
                       value="{{ $instansi->kontak_person }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telepon"
                       value="{{ $instansi->telepon }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $instansi->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$instansi->status ? 'selected' : '' }}>Non Aktif</option>
                </select>
            </div>

            <button class="btn btn-success">
                <i class="fas fa-save mr-2"></i> Update
            </button>
            <a href="{{ route('instansi') }}" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>
@endsection
