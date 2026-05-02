@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('petugas.riwayat') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('petugas.update', $data->id) }}" method="POST">
                @csrf
                {{-- Karena route pakai POST, kita tidak perlu @method PUT --}}

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $data->tanggal) }}" required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_layanan_id">Jenis Layanan</label>
                    <select name="jenis_layanan_id" id="jenis_layanan_id" class="form-control @error('jenis_layanan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($layanan as $l)
                            <option value="{{ $l->id }}" {{ old('jenis_layanan_id', $data->jenis_layanan_id) == $l->id ? 'selected' : '' }}>
                                {{ $l->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_layanan_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_layanan">Jumlah Layanan</label>
                    <input type="number" name="jumlah_layanan" id="jumlah_layanan" class="form-control @error('jumlah_layanan') is-invalid @enderror" value="{{ old('jumlah_layanan', $data->jumlah_layanan) }}" required min="1">
                    @error('jumlah_layanan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_kunjungan">Jumlah Kunjungan</label>
                    <input type="number" name="jumlah_kunjungan" id="jumlah_kunjungan" class="form-control @error('jumlah_kunjungan') is-invalid @enderror" value="{{ old('jumlah_kunjungan', $data->jumlah_kunjungan) }}" required min="1">
                    @error('jumlah_kunjungan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection