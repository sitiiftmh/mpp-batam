@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user-edit mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('user') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('userUpdate', $user->id) }}" method="POST">
                @csrf
                {{-- karena route menggunakan POST, kita bisa gunakan @method('POST') --}}
                {{-- jika ingin PUT, ganti method spoofing --}}

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instansi">Instansi</label>
                    <select name="instansi" id="instansi" class="form-control @error('instansi') is-invalid @enderror" required>
                        <option value="">-- Pilih Instansi --</option>
                        @foreach ($instansi as $item)
                            <option value="{{ $item->id }}" {{ old('instansi', $user->instansi) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_instansi }}
                            </option>
                        @endforeach
                    </select>
                    @error('instansi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection