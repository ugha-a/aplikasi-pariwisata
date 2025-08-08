<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- ===== Tambahkan stack di sini ===== -->
    @stack('style')
    <style>

        .bg-batik-wrapper { position: fixed; inset: 0; pointer-events: none; z-index: 1; }
        .bg-batik-wave { position: absolute; opacity: 0.18; }
        .bg-batik-wave.top { top: 0; left: 0; width: 400px; height: 160px; }
        .bg-batik-wave.bottom { bottom: 0; right: 0; width: 420px; height: 180px; transform: rotateY(180deg); }
        @media (max-width: 500px) {
        .bg-batik-wave.top { width: 150px; height: 50px; }
        .bg-batik-wave.bottom { width: 160px; height: 62px; }
        }
        .login-box { position: relative; z-index: 10; }
        .bg-batik-wave {
            position: absolute;
            opacity: 0.24;
        }
        .bg-batik-wave.top {
            top: 0; left: 0;
            width: 400px; height: 160px;
        }
        .bg-batik-wave.bottom {
            bottom: 0; right: 0;
            width: 420px; height: 180px;
            transform: rotateY(180deg);
        }
        .login-box {
            position: relative;
            z-index: 10;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition login-page">
    {{-- <div class="bg-batik-wrapper">
        <!-- Ornamen SVG Nusantara: Ombak Batik -->
        <svg class="bg-batik-wave top" viewBox="0 0 330 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60Q40 10 120 25T260 25T330 60V0H0Z" fill="#FF8000"/>
            <path d="M0 100Q70 75 160 110T330 100V120H0Z" fill="#fff"/>
        </svg>
        <svg class="bg-batik-wave bottom" viewBox="0 0 340 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 90Q65 130 200 110T340 130V140H0Z" fill="#FF8000"/>
            <path d="M0 130Q90 120 160 130T340 120V140H0Z" fill="#fff"/>
        </svg>
    </div> --}}
   
<div class="login-box">
    {{-- <div class="login-logo">
        <a href="/">{{ config('app.name', 'Laravel') }}</a>
    </div> --}}
    <!-- /.login-logo -->
    @yield('content')
</div>
<!-- /.login-box -->

<!-- Vite asset, jika kamu memakai Vite. Pastikan npm run dev/build sudah dijalankan! -->
@vite('resources/js/app.js')

<!-- Bootstrap 4 Bundle (Popper sudah include) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>
</html>
