<?php

namespace App\Exports;

use App\Models\InputLayanan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPdfExport
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

    public function generate()
    {
        // Ambil data sama seperti Excel
        $query = InputLayanan::with(['user', 'instansi', 'jenisLayanan'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->instansiId) {
            $query->where('instansi_id', $this->instansiId);
        }

        $data = $query->get()->map(function($item) {
            return [
                'tanggal'   => $item->tanggal,
                'petugas'   => $item->user->nama ?? '-',
                'instansi'  => $item->instansi->nama_instansi ?? '-',
                'layanan'   => $item->jenisLayanan->nama_layanan ?? '-',
                'jumlah_layanan'    => $item->jumlah_layanan,
                'jumlah_kunjungan'  => $item->jumlah_kunjungan,
                'status'    => $item->status,
            ];
        });

        // Data untuk PDF
        $pdfData = [
            'data' => $data,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'totalRecords' => $data->count(),
            'generatedAt' => now()->format('d-m-Y H:i:s')
        ];

        // Generate PDF dengan view
        $pdf = Pdf::loadView('exports.laporan-pdf', $pdfData);
        
        // Set ukuran dan orientasi
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf;
    }
}