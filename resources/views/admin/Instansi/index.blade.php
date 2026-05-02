@extends('layouts/app')

@section('content')
<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-building mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header">
        <a href="{{ route('instansiCreate') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Instansi
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Instansi</th>
                        <th>Kontak</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th><i class="fas fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instansi as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <span class="badge badge-dark">
                                {{ $item->kode_instansi }}
                            </span>
                        </td>
                        <td>{{ $item->nama_instansi }}</td>
                        <td>{{ $item->kontak_person ?? '-' }}</td>
                        <td class="text-center">{{ $item->telepon ?? '-' }}</td>
                        <td class="text-center">
                            @if ($item->status)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Non Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('instansiEdit',$item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('instansiDelete',$item->id) }}" method="POST" style="display:inline;">
                             @csrf
                             @method('DELETE')
                              <button onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm" >
                                 <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
