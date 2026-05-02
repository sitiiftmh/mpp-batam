@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-check-circle mr-2"></i>
        {{ $title }}
    </h1>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="alert alert-info">
                <i class="fas fa-clock mr-2"></i>
                Data Menunggu Verifikasi: <strong>{{ $totalPending }}</strong>
            </div>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('vertifikasi') }}" class="form-inline justify-content-end">
                <label for="instansi_id" class="mr-2 font-weight-bold">Filter Instansi:</label>
                <select name="instansi_id" id="instansi_id" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Semua Instansi</option>
                    @foreach ($instansiList as $instansi)
                        <option value="{{ $instansi->id }}" {{ $selectedInstansi == $instansi->id ? 'selected' : '' }}>
                            {{ $instansi->nama_instansi }}
                        </option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </noscript>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('verifikasi.bulk.setujui') }}" method="POST" id="bulkForm">
                @csrf
                <div class="mb-3">
                    <button type="button" class="btn btn-success" onclick="setujuiSelected()">
                        <i class="fas fa-check"></i> Setujui yang Dipilih
                    </button>
                </div>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-primary text-white">
            <tr class="text-center">
                <th width="30px">No</th>
                <th width="100px">Tanggal Input</th>
                <th width="120px">Petugas</th>
                <th width="200px">Instansi</th>
                <th width="250px">Jenis Layanan</th>
                <th width="80px">Jumlah Layanan</th>
                <th width="100px">Jumlah Kunjungan</th>
                <th width="170px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendingList as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->user->nama ?? '-' }}</td>
                <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                <td>{{ $item->jenisLayanan->nama_layanan ?? '-' }}</td>
                <td class="text-center">{{ $item->jumlah_layanan }}</td>
                <td class="text-center">{{ $item->jumlah_kunjungan }}</td>
                <td class="text-center" style="min-width: 160px;">
                    <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: nowrap;">
                        <form action="{{ route('verifikasi.setujui', $item->id) }}" method="POST" style="display:inline-block; margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" style="padding: 4px 10px; white-space: nowrap;" onclick="return confirm('Setujui data ini?')">
                                <i class="fas fa-check"></i> Setuju
                            </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" style="padding: 4px 10px; white-space: nowrap;" onclick="tolakData({{ $item->id }})">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pending.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Check all checkbox
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    function setujuiSelected() {
        let selected = document.querySelectorAll('input[name="ids[]"]:checked');
        if (selected.length === 0) {
            alert('Pilih minimal satu data.');
            return;
        }
        if (confirm('Setujui ' + selected.length + ' data yang dipilih?')) {
            document.getElementById('bulkForm').submit();
        }
    }

    function tolakData(id) {
        let alasan = prompt("Masukkan alasan penolakan:");
        
        if (alasan && alasan.trim() !== "") {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("verifikasi.tolak", "") }}/' + id;
            form.style.display = 'none';
            
            let csrf = document.createElement('input');
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            let alasanInput = document.createElement('input');
            alasanInput.name = 'alasan_penolakan';
            alasanInput.value = alasan;
            form.appendChild(alasanInput);
            
            document.body.appendChild(form);
            form.submit();
        } else if (alasan !== null && alasan === "") {
            alert("Alasan penolakan tidak boleh kosong!");
        }
    }
</script>
@endpush