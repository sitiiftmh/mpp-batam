@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Data Layanan</h6>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($layanan->isEmpty())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Perhatian!</strong> Belum ada data jenis layanan untuk instansi Anda. 
                    Silakan hubungi admin untuk menambahkan jenis layanan terlebih dahulu.
                </div>
            @endif

            <form action="{{ route('petugas.store') }}" method="POST">
                @csrf
                
                <!-- Tanggal -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <!-- Data Layanan -->
                <div class="form-group">
                    <label class="font-weight-bold">Data Layanan</label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="layanan-table">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40%">Jenis Layanan</th>
                                    <th width="25%">Jumlah Layanan</th>
                                    <th width="25%">Jumlah Kunjungan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="layanan-body">
                                <!-- Baris 1 -->
                                <tr class="layanan-row">
                                    <td>
                                        <select name="jenis_layanan_id[]" class="form-control" required>
                                            <option value="">-- Pilih Jenis Layanan --</option>
                                            @foreach($layanan as $item)
                                                <!-- PERHATIKAN: pakai nama_layanan, BUKAN nama -->
                                                <option value="{{ $item->id }}">{{ $item->nama_layanan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_layanan[]" class="form-control" placeholder="Jumlah layanan" required>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_kunjungan[]" class="form-control" placeholder="Jumlah kunjungan" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button type="button" class="btn btn-success btn-sm" id="btn-tambah-layanan" {{ $layanan->isEmpty() ? 'disabled' : '' }}>
                                            <i class="fas fa-plus"></i> Tambah Jenis Layanan
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5" {{ $layanan->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Simpan Semua Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function getNewRow() {
        let selectOptions = '<option value="">-- Pilih Jenis Layanan --</option>';
        
        @foreach($layanan as $item)
            selectOptions += '<option value="{{ $item->id }}">{{ $item->nama_layanan }}</option>';
        @endforeach
        
        return `
            <tr class="layanan-row">
                <td>
                    <select name="jenis_layanan_id[]" class="form-control" required>
                        ${selectOptions}
                    </select>
                 </td>
                <td>
                    <input type="number" name="jumlah_layanan[]" class="form-control" placeholder="Jumlah layanan" required>
                 </td>
                <td>
                    <input type="number" name="jumlah_kunjungan[]" class="form-control" placeholder="Jumlah kunjungan" required>
                 </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                 </td>
             </tr>
        `;
    }
    
    $('#btn-tambah-layanan').click(function() {
        let newRow = getNewRow();
        $('#layanan-body').append(newRow);
        updateDeleteButtons();
    });
    
    $(document).on('click', '.btn-hapus', function() {
        let rowCount = $('.layanan-row').length;
        if(rowCount > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('Minimal harus ada satu jenis layanan!');
        }
        updateDeleteButtons();
    });
    
    function updateDeleteButtons() {
        let rowCount = $('.layanan-row').length;
        $('.btn-hapus').each(function() {
            if(rowCount === 1) {
                $(this).prop('disabled', true);
            } else {
                $(this).prop('disabled', false);
            }
        });
    }
    
    updateDeleteButtons();
});
</script>
@endpush