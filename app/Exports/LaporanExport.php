<?php
namespace App\Exports;

use App\Models\InputLayanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $instansiId;

    public function __construct($startDate, $endDate, $instansiId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->instansiId = $instansiId;
    }

    public function collection()
    {
        $query = InputLayanan::with(['user', 'instansi', 'jenisLayanan'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->instansiId) {
            $query->where('instansi_id', $this->instansiId);
        }

        return $query->get()->map(function($item) {
            return [
                'tanggal'   => $item->tanggal,
                'petugas'   => $item->user->nama ?? '-',
                'instansi'  => $item->instansi->nama_instansi ?? '-',
                'layanan'   => $item->jenisLayanan->nama_layanan ?? '-',
                'jumlah'    => $item->jumlah_layanan,
                'status'    => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Petugas', 'Instansi', 'Layanan', 'Jumlah', 'Status'];
    }
}