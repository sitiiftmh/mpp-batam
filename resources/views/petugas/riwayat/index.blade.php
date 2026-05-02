@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-history mr-2"></i>
        {{ $title }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Layanan</th>
                            <th>Jumlah Layanan</th>
                            <th>Jumlah Kunjungan</th>
                            <th>Status</th>
                            <th>Alasan (Jika Ditolak)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->jenisLayanan->nama_layanan ?? '-' }}</td>
                            <td class="text-center">{{ $item->jumlah_layanan }}</td>
                            <td class="text-center">{{ $item->jumlah_kunjungan }}</td>
                            <td class="text-center">
                                @if ($item->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($item->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif ($item->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 'ditolak')
                                    {{ $item->alasan_penolakan ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status == 'pending')
                                    <a href="{{ route('petugas.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('petugas.hapus', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection