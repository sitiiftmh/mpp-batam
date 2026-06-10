<!-- Sidebar -->

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

```
<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
    <img src="{{ asset('img/LOGO-MPP.png') }}" 
    alt="Logo MPP Batam"
    style="width: 500px; height:auto; margin-top: 20px;"
    class="img-fluid sidebar-logo">
</a>

<hr class="sidebar-divider my-4">

@auth

<!-- Dashboard -->
<li class="nav-item {{ $menuDashboard ?? '' }}">
    @if(auth()->user()->role == 'admin')
        <a class="nav-link py-1" href="{{ route('dashboard') }}">
    @elseif(auth()->user()->role == 'Petugas')
        <a class="nav-link py-1" href="{{ route('petugas.dashboard') }}">
    @endif
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<hr class="sidebar-divider">

{{-- MENU ADMIN --}}
@if(auth()->user()->role == 'admin')

<div class="sidebar-heading">
    Menu Admin
</div>

<li class="nav-item {{ $menuAdminVertifikasi ?? '' }}">
    <a class="nav-link" href="{{ route('vertifikasi') }}">
        <i class="fas fa-tasks"></i>
        <span>Monitoring dan Validasi Data Layanan</span>
    </a>
</li>

<li class="nav-item {{ $menuAdminInstansi ?? '' }}">
    <a class="nav-link" href="{{ route('instansi') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelola Data Instansi</span>
    </a>
</li>

<li class="nav-item {{ $menuAdminJenis ?? '' }}">
    <a class="nav-link" href="{{ route('layanan') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Kelola Jenis Layanan</span>
    </a>
</li>

<li class="nav-item {{ $menuAdminUser ?? '' }}">
    <a class="nav-link" href="{{ route('user') }}">
        <i class="fas fa-user"></i>
        <span>Kelola Akun Pengguna</span>
    </a>
</li>
@else

{{-- MENU PETUGAS --}}

<div class="sidebar-heading">
    Menu Petugas
</div>

<li class="nav-item {{ $menuPetugasInput ??'' }}">
    <a class="nav-link" href="{{ route('petugas.input') }}">
        <i class="fas fa-tasks"></i>
        <span>Input Layanan</span>
    </a>
</li>

<li class="nav-item {{ $menuPetugasRiwayat ?? '' }}">
    <a class="nav-link" href="{{ route('petugas.riwayat') }}">
        <i class="fas fa-fw fa-history"></i>
        <span>Riwayat Data</span>
    </a>
</li>
@endif

@endauth

<hr class="sidebar-divider d-none d-md-block">

<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
```

</ul>
<!-- End of Sidebar -->
