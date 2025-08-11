<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
        <div class="info">
            <a href="{{ route('admin.profile.show') }}" class="d-block user-panel-link">{{ Auth::user()->name }}</a>
        </div>
    </div>
    <style>
        .user-panel .user-panel-link {
            color: #22346c !important;     /* Warna biru gelap default, sama seperti menu sidebar */
            font-weight: 600;
            background: none !important;
            transition: color 0.18s;
            padding: 2px 12px;
            border-radius: 7px;
            display: inline-block;
        }
        .user-panel .user-panel-link:hover {
            color: #3366FF !important;     /* Warna biru terang saat hover */
            background: none !important;   /* Background tetap transparan */
            text-decoration: underline;    /* Opsional: underline saat hover */
        }
    </style>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if (in_array(auth()->user()->role, ['admin', 'dinas', 'pengelola']))
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th fa-lg"></i>
            <p>Beranda</p>
        </a>
    </li>
@endif

@if (in_array(auth()->user()->role, ['admin']))
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users fa-lg"></i>
            <p>Pengguna</p>
        </a>
    </li>
@endif

@if (in_array(auth()->user()->role, ['admin', 'dinas', 'pengelola']))
    <li class="nav-item">
        <a href="{{ route('admin.bookings.index') }}"
           class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-book fa-lg"></i>
            <p>Booking</p>
        </a>
    </li>
@endif

@if (in_array(auth()->user()->role, ['admin', 'pengelola']))
    <li class="nav-item">
        <a href="{{ route('admin.travel_packages.index') }}"
           class="nav-link {{ request()->routeIs('admin.travel_packages.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-hotel fa-lg"></i>
            <p>Travel Package</p>
        </a>
    </li>
@endif

@if (in_array(auth()->user()->role, ['admin']))
    <li class="nav-item">
        <a href="{{ route('admin.locations.index') }}"
           class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-map-marker-alt fa-lg"></i>
            <p>Lokasi</p>
        </a>
    </li>
@endif

@if (in_array(auth()->user()->role, ['admin', 'dinas', 'pengelola']))
    <li class="nav-item has-treeview {{ request()->routeIs('report.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('report.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar fa-lg"></i>
            <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('report.sales.index') }}"
                   class="nav-link {{ request()->routeIs('report.sales.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Kunjungan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('report.pemesanan.index') }}"
                   class="nav-link {{ request()->routeIs('report.pemesanan.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Booking</p>
                </a>
            </li>
        </ul>
    </li>
@endif



        </ul>
    </nav>

    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
