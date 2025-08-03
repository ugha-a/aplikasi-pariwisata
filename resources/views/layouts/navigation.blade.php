<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('admin.profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            @if (in_array(auth()->user()->role, ['admin', 'dinas']))
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th fa-lg"></i>
                        <p>Beranda</p>
                    </a>
                </li>
            @endif
    
            @if (in_array(auth()->user()->role, ['admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users fa-lg"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
            @endif
    
            @if (in_array(auth()->user()->role, ['admin', 'dinas']))
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book fa-lg"></i>
                        <p>Booking</p>
                    </a>
                </li>
            @endif
    
            @if (in_array(auth()->user()->role, ['admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.travel_packages.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-hotel fa-lg"></i>
                        <p>Travel Package</p>
                    </a>
                </li>
            @endif
    
            @if (in_array(auth()->user()->role, ['admin']))
                <li class="nav-item">
                    <a href="{{ route('admin.locations.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marker-alt fa-lg"></i>
                        <p>Lokasi</p>
                    </a>
                </li>
            @endif

            @if (in_array(auth()->user()->role, ['admin', 'dinas']))
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar fa-lg"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.sales.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.pemesanan.index') }}" class="nav-link">
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
