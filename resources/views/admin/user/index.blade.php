@extends('layouts/app')

@section('content')
<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-user-alt mr-2"></i>
    {{ $title }}
</h1>

<div class="card">
    <div class="card-header">
        <a href="{{ route('userCreate') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Instansi</th>
                        <th>Role</th>
                        <th><i class="fas fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary">{{ $item->email }}</span>
                        </td>
                        <td>{{ $item->instansiRel->nama_instansi ?? '-' }}</td>
                        <td class="text-center">
                            @if ($item->role == 'admin')
                                <span class="badge badge-dark">{{ $item->role }}</span>
                            @else
                                <span class="badge badge-info">{{ $item->role }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('userEdit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <span id="userName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama = button.data('nama');
        var modal = $(this);
        modal.find('#userName').text(nama);
        modal.find('#deleteForm').attr('action', '{{ route("userDestroy", "") }}/' + id);
    });
</script>
@endpush

@endsection