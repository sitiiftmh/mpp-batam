<?php

namespace App\Http\Controllers;

use App\Models\InputLayanan;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');

        // Tentukan rentang tanggal sesuai periode
        $now = Carbon::now();
        switch ($period) {
            case 'daily':
                $startDate = $now->copy()->subDays(6)->startOfDay();   // 7 hari terakhir
                $endDate   = $now->copy()->endOfDay();
                break;
            case 'weekly':
                $startDate = $now->copy()->subWeeks(3)->startOfWeek();  // 4 minggu terakhir
                $endDate   = $now->copy()->endOfWeek();
                break;
            case 'yearly':
                $startDate = $now->copy()->subYears(4)->startOfYear();  // 5 tahun terakhir
                $endDate   = $now->copy()->endOfYear();
                break;
            case 'monthly':
            default:
                $startDate = $now->copy()->subMonths(5)->startOfMonth(); // 6 bulan terakhir
                $endDate   = $now->copy()->endOfMonth();
                break;
        }

        // ========== 1. Total Layanan & Kunjungan dalam periode ==========
        $totalLayanan = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah_layanan');

        $totalKunjungan = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('jumlah_kunjungan');

        // ========== 2. Instansi dengan layanan terbanyak dalam periode ==========
        $instansiLayananTerbanyak = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select('instansi_id', DB::raw('SUM(jumlah_layanan) as total'))
            ->with('instansi')
            ->groupBy('instansi_id')
            ->orderBy('total', 'desc')
            ->first();
        $namaInstansiLayananTerbanyak = $instansiLayananTerbanyak->instansi->nama_instansi ?? '-';

        // ========== 3. Instansi dengan kunjungan terbanyak dalam periode ==========
        $instansiKunjunganTerbanyak = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select('instansi_id', DB::raw('SUM(jumlah_kunjungan) as total'))
            ->with('instansi')
            ->groupBy('instansi_id')
            ->orderBy('total', 'desc')
            ->first();
        $namaInstansiKunjunganTerbanyak = $instansiKunjunganTerbanyak->instansi->nama_instansi ?? '-';

        // ========== 4. Data pie chart (dalam periode) ==========
        $pieData = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select('instansi_id', DB::raw('SUM(jumlah_kunjungan) as total'))
            ->with('instansi')
            ->groupBy('instansi_id')
            ->orderBy('total', 'desc')
            ->get();

        $pieLabels = $pieData->map(fn($item) => $item->instansi->nama_instansi ?? 'Unknown')->toArray();
        $pieValues = $pieData->map(fn($item) => (int) $item->total)->toArray();

        // ========== 5. Data line chart (trend kunjungan per periode) ==========
        $lineData = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select(DB::raw($this->getDateSql($period, 'tanggal') . ' as period'), DB::raw('SUM(jumlah_kunjungan) as total'))
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->get();

        $lineLabels = $lineData->map(function($item) use ($period) {
            if ($period == 'daily') return Carbon::parse($item->period)->format('d/m');
            if ($period == 'weekly') return 'Minggu ' . $item->period;
            if ($period == 'monthly') return Carbon::createFromFormat('Y-m', $item->period)->format('m/Y');
            if ($period == 'yearly') return $item->period;
            return $item->period;
        })->toArray();
        $lineValues = $lineData->map(fn($item) => (int) $item->total)->toArray();

        // ========== 6. Data tabel trend (per instansi dalam periode) ==========
        $trendData = InputLayanan::where('status', 'disetujui')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select(
                'instansi_id',
                DB::raw('SUM(jumlah_layanan) as total_layanan'),
                DB::raw('SUM(jumlah_kunjungan) as total_kunjungan')
            )
            ->with('instansi')
            ->groupBy('instansi_id')
            ->orderBy('total_kunjungan', 'desc')
            ->get();

        // ========== 7. Teks periode untuk ditampilkan di view (sederhana) ==========
        switch ($period) {
            case 'daily':   $periodeText = 'Harian'; break;
            case 'weekly':  $periodeText = 'Mingguan'; break;
            case 'monthly': $periodeText = 'Bulanan'; break;
            case 'yearly':  $periodeText = 'Tahunan'; break;
            default:        $periodeText = ucfirst($period); break;
        }

        return view('welcome', compact(
            'totalLayanan', 'totalKunjungan',
            'namaInstansiLayananTerbanyak', 'namaInstansiKunjunganTerbanyak',
            'pieLabels', 'pieValues',
            'lineLabels', 'lineValues',
            'trendData', 'period', 'periodeText'
        ));
    }

    private function getDateSql($period, $column)
    {
        switch ($period) {
            case 'daily':   return "DATE($column)";
            case 'weekly':  return "YEARWEEK($column)";
            case 'monthly': return "DATE_FORMAT($column, '%Y-%m')";
            case 'yearly':  return "YEAR($column)";
            default:        return "DATE($column)";
        }
    }
}