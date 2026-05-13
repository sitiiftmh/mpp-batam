<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard MPP Kota Batam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-mpp.png') }}">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #eef3fb;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-stat {
            border-radius: 12px;
        }
        .stat-number {
            font-size: 22px;
            font-weight: bold;
        }
        canvas {
            max-height: 220px;
        }
    </style>
</head>
<body>

<!-- ================= NAVBAR ATAS (LOGO + LOGIN) ================= -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" 
        href="@auth
            @if(auth()->user()->role == 'admin')
                {{ route('dashboard') }}
            @elseif(auth()->user()->role == 'petugas')
                {{ route('petugas.dashboard') }}
            @endif
        @else
            {{ route('welcome') }}
        @endauth">
            <img src="{{ asset('img/LOGO-MPP.png') }}" height="70" class="me-2">
        </a>

        <div class="ms-auto">
            @guest
            <a class="btn btn-outline-primary px-10 py-2 fs-5 dropdown-toggle fw-semibold rounded-pill" href="{{ route('login') }}">Login</a>
            @endguest

            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                        {{ Auth::user()->nama }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                         <li>
                            <a class="dropdown-item" 
                               href="{{ auth()->user()->role == 'admin' ? route('dashboard') : route('petugas.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Kembali ke Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>

    </div>
</nav>

<!-- ================= JUDUL ================= -->
<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid justify-content-center">
        <span class="navbar-brand fw-bold">
            Laporan Periodik Data Layanan & Pengunjung MPP Kota Batam
        </span>
    </div>
</nav>

<div class="container">

<!-- ================= FILTER ================= -->
<form method="GET" action="{{ route('welcome') }}" class="row mb-4">
    <div class="col-md-3">
        <select name="period" class="form-select" onchange="this.form.submit()">
            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Mingguan</option>
            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
        </select>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
</form>

<!-- ================= STAT ================= -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm card-stat">
            <div class="card-body">
                <small>Total Layanan</small>
                <div class="stat-number text-primary">{{ number_format($totalLayanan) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm card-stat">
            <div class="card-body">
                <small>Total Kunjungan</small>
                <div class="stat-number text-success">{{ number_format($totalKunjungan) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm card-stat">
            <div class="card-body">
                <small>Instansi Terbanyak</small>
                <div class="fw-semibold">{{ $namaInstansiLayananTerbanyak }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm card-stat">
            <div class="card-body">
                <small>Kunjungan Terbanyak</small>
                <div class="fw-semibold">{{ $namaInstansiKunjunganTerbanyak }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ================= CHART ================= -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Diagram Kunjungan ({{ $periodeText }})</h6>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Trend Kunjungan ({{ $periodeText }})</h6>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ================= TABEL TREND ================= -->
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <h6>Trend Kunjungan dan Layanan Masyarakat</h6>
        <p class="text-muted">Periode: {{ $periodeText }}</p>
        <div class="table-responsive">
            <table class="table table-bordered table-sm mt-3">
                <thead class="table-light">
                    <tr><th>Instansi</th><th>Layanan</th><th>Kunjungan</th></tr>
                </thead>
                <tbody>
                    @forelse($trendData as $item)
                    <tr>
                        <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                        <td>{{ number_format($item->total_layanan) }}</td>
                        <td>{{ number_format($item->total_kunjungan) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= JUDUL LAYANAN ================= -->
<div class="bg-primary text-white py-3 mb-4 shadow-sm">
    <div class="container text-center">
        <h4 class="fw-bold mb-0">Layanan – Layanan MPP Kota Batam</h4>
    </div>
</div>


<div class="container my-5">
    <div class="bg-white p-4 rounded shadow-sm">
        <div class="row g-4 justify-content-center">
        @php
            $layanan = [
                ['pemprov.jpg','Pemprov Kepri'],
                ['pemko.jpg','Pemko Batam'],
                ['bp.jpg','BP Batam'],
                ['polda.jpg','Polresta Barelang'],
                ['beacukai.jpg','BeaCukai'],
                ['bpjs.jpg','BPJS Kesehatan'],
                ['baznas.jpg','Baznas'],
                ['bnn.jpg','BNN'],
                ['bpn.jpg','Bpn Kepri'],
                ['bpom.jpg','BPOM Kota Batam'],
                ['djp.jpg','KPP'],
                ['kejaksaan.jpg','Kejaksaan'],
                ['kemenag.jpg','Kementrian Agama'],
                ['kemenkumham.jpg','Kemenkumham'],
                ['taspen.jpg','Taspen'],
                ['ut.png','UT'],

            ];
        @endphp

        @foreach($layanan as $l)
        <div class="col-6 col-md-3 col-lg-2 text-center">
                    <div class="d-flex flex-column align-items-center">
                    <img src="{{ asset('img/layanan/'.$l[0]) }}" 
                             alt="{{ $l[1] }}"
                             style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 8px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                    <span style="font-size: 14px; font-weight: 500; color: #333;">{{ $l[1] }}</span>
                    </div>
        </div>
        @endforeach

    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($pieLabels) !!},
        datasets: [{ data: {!! json_encode($pieValues) !!} }]
    }
});

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($lineLabels) !!},
        datasets: [{ data: {!! json_encode($lineValues) !!}, label: 'Kunjungan' }]
    }
});
</script>

</body>
</html>