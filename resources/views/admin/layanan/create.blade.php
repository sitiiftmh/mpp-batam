@extends('layouts/app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plus-circle mr-2"></i>
    Tambah Jenis Layanan
</h1>

<div class="card">
    <div class="card-body">

        <form action="{{ route('layananStore') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text"
                       name="nama_layanan"
                       class="form-control"
                       placeholder="Masukan nama layanan"
                       required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control"
                          placeholder="Masukan deskripsi"></textarea>
            </div>

            <div class="form-group">
            <label for="instansi_id">Instansi</label>
            @if($selectedInstansi)
                <input type="hidden" name="instansi_id" value="{{ $selectedInstansi }}">
                <input type="text" class="form-control" value="{{ $instansi->where('id', $selectedInstansi)->first()->nama_instansi ?? 'Instansi tidak ditemukan' }}" readonly disabled>
                <small class="text-muted">Instansi sudah ditentukan, tidak dapat diubah.</small>
            @else
                <select name="instansi_id" id="instansi_id" class="form-control @error('instansi_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Instansi --</option>
                    @foreach ($instansi as $item)
                        <option value="{{ $item->id }}" {{ old('instansi_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_instansi }}
                        </option>
                    @endforeach
                </select>
                @error('instansi_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            @endif
        </div>

            <div class="form-group">
                <label>Status</label><br>
                <input type="radio" name="status" value="1" checked> Aktif
                <input type="radio" name="status" value="0" class="ml-3"> Non Aktif
            </div>

            <div class="text-right">
                <button class="btn btn-success">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="{{ route('layanan') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
