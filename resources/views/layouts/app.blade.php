<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
        <!-- Fonts -->
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- DataTables CSS (BS4 + Responsive + Buttons) -->
    <link rel="stylesheet"
    href="https://cdn.datatables.net/v/bs4/dt-1.13.8/r-2.5.0/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.css"/>

    <!-- (Opsional) Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <style>

        .sidebar-brand-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 58px;
            background: #fff !important;
            border-bottom: 1px solid #f2f4f9;
            transition: background 0.19s;
            cursor: pointer;
            text-decoration: none !important;
        }

        .sidebar-brand-text {
            color: #22346c !important;
            font-weight: 700;
            font-size: 1.18rem;
            letter-spacing: 1.3px;
            transition: color 0.18s;
        }

        /* Hover effect */
        .sidebar-brand-custom:hover .sidebar-brand-text {
            color: #3366FF !important;
        }
        /* --- WHITE SIDEBAR, HEADER, FOOTER + SOFT SHADOW --- */
        .main-sidebar,
        .main-header,
        .main-footer {
            background: #fff !important;
            color: #22346c !important;
        }
    
        /* NAVBAR: Soft blue shadow & elegant border */
        .main-header {
            box-shadow: 0 2px 14px 0 rgba(51,102,255,0.06), 0 1.5px 4px 0 rgba(0,0,0,0.03) !important;
            border-bottom: 1px solid #f2f4f9;
        }
        /* FOOTER: Soft blue shadow (atas) & elegant border */
        .main-footer {
            box-shadow: 0 -3px 14px 0 rgba(51,102,255,0.06), 0 -1.5px 6px 0 rgba(0,0,0,0.03) !important;
            border-top: 1px solid #f2f4f9;
        }
        /* SIDEBAR: White, very subtle right border */
        .main-sidebar {
            border-right: 1px solid #f2f4f9;
            box-shadow: none !important;
        }
    
        /* SIDEBAR MENU, BRAND, ICONS: BIRU */
        .sidebar .nav-sidebar > .nav-item > .nav-link {
            color: #22346c !important;
            background: transparent !important;
            border-radius: 8px;
            margin: 0 6px;
            transition: background 0.18s;
        }
        .sidebar .nav-sidebar > .nav-item > .nav-link.active,
        .sidebar .nav-sidebar > .nav-item > .nav-link:hover {
            background: #eaf1ff !important;
            color: #3366FF !important;
        }
        .sidebar .brand-link,
        .sidebar .brand-link .brand-text {
            color: #3366FF !important;
            background: #fff !important;
            border-bottom: 1px solid #f2f4f9;
        }
        .sidebar .nav-icon, .sidebar .brand-link i {
            color: #3366FF !important;
            opacity: 0.88;
        }
        @media (max-width: 991.98px) {
            .main-sidebar { border-right: none !important; }
        }

        .sidebar .nav-sidebar .nav-treeview {
    background: #f6faff; /* Putih kebiruan, agar kontras */
    margin-left: 0.25rem;
    border-radius: 8px;
    padding: 4px 0;
    /* box-shadow lembut agar tidak flat */
    box-shadow: 0 2px 6px rgba(51,102,255,0.06);
}

.sidebar .nav-treeview > .nav-item > .nav-link {
    color: #22346c !important;
    background: transparent !important;
    font-size: 0.97rem;
    border-radius: 6px;
    margin: 2px 12px 2px 20px; /* indent agar jelas submenu */
    padding-left: 1.7rem;
    transition: background 0.17s, color 0.17s;
}

.sidebar .nav-treeview > .nav-item > .nav-link.active,
.sidebar .nav-treeview > .nav-item > .nav-link:hover {
    background: #eaf1ff !important;   /* Hover biru muda */
    color: #3366FF !important;
    font-weight: 600;
}
.sidebar .nav-treeview .nav-icon {
    color: #3366FF !important;
    opacity: 0.82;
}
    </style>
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars" style="color: #3366FF"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" style="color: #3366FF">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="{{ route('admin.profile.show') }}" class="dropdown-item" style="color: #3366FF">
                            <i class="mr-2 fas fa-file" style="color: #3366FF"></i>
                            {{ __('My profile') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();" style="color: #3366FF">
                                <i class="mr-2 fas fa-sign-out-alt" style="color: #3366FF"></i>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link sidebar-brand-custom">
                <span class="brand-text align-middle sidebar-brand-text">Nusantara</span>
            </a>
            @include('layouts.navigation')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (count($errors) > 0)
                <div class="content-header mb-0 pb-0">
                    <div class="container-fluid">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="p-0 m-0" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('message'))
                <div class="content-header mb-0 pb-0">
                    <div class="container-fluid">
                        <div class="mb-0 alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show"
                            role="alert">
                            <strong>{{ session()->get('message') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
            @endif
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Kuhaku
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- ====== JS: urutan penting ====== -->
  <!-- 1) jQuery (harus sebelum DataTables & AdminLTE) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- 2) Bootstrap Bundle (untuk AdminLTE & DataTables BS4) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- 3) DataTables JS bundle (harus setelah jQuery) -->
  <script src="https://cdn.datatables.net/v/bs4/dt-1.13.8/r-2.5.0/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>

  <!-- 4) (Opsional) JSZip kalau pakai export Excel -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

  <!-- 5) AdminLTE (setelah jQuery & Bootstrap) -->
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    @vite('resources/js/app.js')
    <!-- AdminLTE App -->

    @yield('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> --}}
</body>

</html>
