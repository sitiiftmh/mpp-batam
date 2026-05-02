@extends('layouts/app')

@section('content')

<div class="text-center mb-4">
    <h2 class="font-weight-bold">KELOLA JENIS LAYANAN</h2>
</div>

<div class="text-center mb-3">
    <form method="GET" action="{{ route('layanan') }}">
        <label class="mr-2 font-weight-bold">Pilih Instansi :</label>
        <select name="instansi_id" onchange="this.form.submit()" class="form-control d-inline w-auto">
            <option value="">-- Pilih Instansi --</option>
            @foreach ($instansi as $item)
                <option value="{{ $item->id }}"
                    {{ $selectedInstansi == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_instansi }}
                </option>
            @endforeach
        </select>
    </form>
</div>

@if ($selectedInstansi)

    <div class="bg-light p-2 mb-2 font-weight-bold">
        JENIS LAYANAN UNTUK :
        {{ $instansi->where('id',$selectedInstansi)->first()->nama_instansi }}
    </div>

     <div class="text-right mt-3">
                <a href="{{ route('layananCreate') }}?instansi_id={{ $selectedInstansi }}"
                   class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambah Jenis Layanan
                </a>
            </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Jenis Layanan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($layanan as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_layanan }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td class="text-center">
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('layananEdit',$item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <form action="{{ route('layananDelete',$item->id) }}" method="POST" style="display:inline;">
                             @csrf
                             @method('DELETE')
                              <button onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm" >
                                 <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada layanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endif

@endsection
