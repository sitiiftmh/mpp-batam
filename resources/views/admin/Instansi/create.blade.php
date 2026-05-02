@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-building mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('instansi') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('instansiStore') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="kode_instansi">Kode Instansi <span class="text-danger">*</span></label>
                    <input type="text" name="kode_instansi" id="kode_instansi" class="form-control @error('kode_instansi') is-invalid @enderror" value="{{ old('kode_instansi') }}" required>
                    @error('kode_instansi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_instansi">Nama Instansi <span class="text-danger">*</span></label>
                    <input type="text" name="nama_instansi" id="nama_instansi" class="form-control @error('nama_instansi') is-invalid @enderror" value="{{ old('nama_instansi') }}" required>
                    @error('nama_instansi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kontak_person">Kontak Person</label>
                    <input type="text" name="kontak_person" id="kontak_person" class="form-control" value="{{ old('kontak_person') }}">
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection