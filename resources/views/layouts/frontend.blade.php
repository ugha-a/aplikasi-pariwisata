<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!--=============== BOXICONS ===============-->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <!--=============== SWIPER CSS ===============-->
  <link rel="stylesheet" href="{{ asset('frontend/assets/libraries/swiper-bundle.min.css') }}" />

  <!--=============== CSS GLOBAL PROJECT ===============-->
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />

  {{-- tempat child view mendorong CSS tambahan --}}
  @stack('style-alt')

  <title>Sulawesi Tenggara</title>

  <!--=============== LIB TAMBAHAN ===============-->
  <link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>

  <!--=============== CUSTOM STYLE (INLINE, BUKAN ) ===============-->
  <style>
    /* ====== VARIABEL WARNA GLOBAL ====== */
    :root{
      --primary-color:#3366FF; /* biru */
      --accent-color:#FF6600;  /* oranye */
      --header-bg:#fff;
      --header-shadow:rgba(0,0,0,.1);
      --header-height:72px;
    }
    @media (max-width:768px){ :root{ --header-height:64px; } }

    /* ====== HEADER FIXED ====== */
    .header{
      position:fixed; inset-block-start:0; inset-inline:0;
      height:var(--header-height);
      background:var(--header-bg)!important;
      box-shadow:0 2px 4px var(--header-shadow);
      z-index:1000; display:flex; align-items:center; overflow:hidden;
    }
    .header .nav{ width:100%; display:flex; align-items:center; justify-content:space-between; }
    .main{ padding-top:var(--header-height); }

    .header::after{
      content:"";
      position:absolute;
      inset-inline:0;
      bottom:0;
      height:8px;
      background:
        repeating-linear-gradient(
          45deg, var(--primary-color) 0 12px, transparent 12px 24px
        ),
        repeating-linear-gradient(
          -45deg, var(--accent-color) 0 12px, transparent 12px 24px
        );
      background-size:24px 24px;
      opacity:.15; /* halus, elegan */
      pointer-events:none;
    }
    .header::after {
      opacity: .35; /* dari .15 → .35 */
    }

    /* ====== BRAND DI NAV ====== */
    .nav__logo{ display:flex; align-items:center; gap:8px; font-weight:700; text-decoration:none; color:#000; }
    .brand-logo__box{
      display:inline-block; width:32px; height:32px; flex:0 0 32px; border-radius:4px; overflow:hidden; line-height:0;
      background-repeat:no-repeat; background-position:center; background-size:contain;
    }
    .logo-text{ display:inline-flex; align-items:center; gap:4px; }
    @media (max-width:768px){ .brand-logo__box{ width:28px; height:28px; flex-basis:28px; } }

    /* ====== KOMPONEN CONTOH ====== */
    .popular__card{ border:none; border-radius:.5rem; overflow:hidden; transition:transform .3s; background:#fff; box-shadow:0 4px 10px rgba(0,0,0,.06); }
    .popular__card:hover{ transform:translateY(-5px); }
    .popular__img{ width:100%; border-radius:.5rem .5rem 0 0; display:block; object-fit:cover; }
    .popular__data{ padding:1rem; text-align:center; }
    .swiper-button-prev,.swiper-button-next{ color:var(--primary-color)!important; }
    .swiper-pagination-bullet-active{ background-color:var(--primary-color)!important; }

    /* ====== ANTI HORIZONTAL SCROLL + CONTAINER ====== */
    html, body { overflow-x: hidden; }
    .container{ max-width:1120px; width:100%; margin-inline:auto; padding-inline:16px; box-sizing:border-box; }
    .scrollup{ position:fixed; inset-inline-end:16px; inset-block-end:20px; }

    /* ===================================================================== */
    /* ========================== FOOTER NUSANTARA ========================== */
    /* ===================================================================== */
    footer.footer--nusantara{
      background:#fff; color:#333;
      padding-block:48px 28px;
      border-top:6px solid var(--accent-color);
      position:relative; overflow-x:clip;
    }
    /* Ornamen zigzag halus (aksen Nusantara) */
    footer.footer--nusantara::before{
      content:""; position:absolute; inset-inline:0; top:0; height:10px;
      background:
        repeating-linear-gradient(45deg, var(--primary-color) 0 12px, transparent 12px 24px),
        repeating-linear-gradient(-45deg, var(--accent-color) 0 12px, transparent 12px 24px);
      background-size:24px 24px; opacity:.15; pointer-events:none;
    }

    footer.footer--nusantara .footer__grid{
      display:grid; grid-template-columns:1.5fr 1fr 1fr; gap:32px; align-items:start;
    }
    @media (max-width:900px){ footer.footer--nusantara .footer__grid{ grid-template-columns:1fr; gap:20px; } }

    footer.footer--nusantara .footer__brand{
      display:flex; align-items:center; gap:10px; font-weight:800; font-size:1.2rem; text-decoration:none; color:#000; margin-bottom:12px;
    }
    footer.footer--nusantara .footer__brand .bx{ color:var(--accent-color); translate:0 1px; }
    footer.footer--nusantara .footer__description{ line-height:1.6; color:#444; margin:0; overflow-wrap:anywhere; }

    footer.footer--nusantara .footer__title{
      font-size:.95rem; font-weight:700; text-transform:uppercase; color:var(--primary-color);
      margin-bottom:14px; letter-spacing:.3px;
    }

    footer.footer--nusantara .footer__links{ list-style:none; padding:0; margin:0; display:grid; gap:10px; }
    footer.footer--nusantara .footer__link{ color:#444; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    footer.footer--nusantara .footer__link:hover{ color:var(--accent-color); text-decoration:underline; text-underline-offset:3px; }

    footer.footer--nusantara .footer__badges{ display:flex; flex-wrap:wrap; gap:10px; }
    footer.footer--nusantara .chip{
      padding:.5rem .9rem; border-radius:999px; border:1px solid var(--primary-color);
      color:var(--primary-color); text-decoration:none; font-size:.9rem; font-weight:500; transition:.2s;
    }
    footer.footer--nusantara .chip:hover{ background:var(--primary-color); color:#fff; }

    footer.footer--nusantara .footer__separator{ height:1px; background:#e6e6e6; margin-block:28px; }
    footer.footer--nusantara .footer__bottom{
      display:flex; justify-content:space-between; align-items:center; gap:16px; font-size:.9rem; color:#666;
    }
    @media (max-width:768px){ footer.footer--nusantara .footer__bottom{ flex-direction:column; text-align:center; } }

    /* ================= NAVBAR HOVER EFFECTS ================= */
    .nav__list{
      display:flex; align-items:center; gap:8px;
      margin:0; padding:0; list-style:none;
    }

    .nav__link{
      position:relative;
      display:inline-flex; align-items:center; gap:8px;
      padding:10px 14px; border-radius:12px;
      color:#1f2937; text-decoration:none; font-weight:600;
      transition: color .2s ease, background-color .2s ease, transform .2s ease;
    }

    /* underline gradasi animasi */
    .nav__link::after{
      content:""; position:absolute; left:12px; right:12px; bottom:6px; height:3px;
      background:linear-gradient(90deg,var(--accent-color),var(--primary-color));
      border-radius:999px;
      transform:scaleX(0); transform-origin:left; transition:transform .28s ease;
    }

    /* hover */
    .nav__link:hover{
      color:var(--primary-color);
      background:rgba(51,102,255,.08);
    }
    .nav__link:hover::after{ transform:scaleX(1); }
    .nav__link .bx{ transition:transform .25s ease; }
    .nav__link:hover .bx{ transform:translateY(-1px); }

    /* active (halaman saat ini) */
    .nav__link.active-link{
      color:var(--primary-color);
      background:rgba(51,102,255,.10);
    }
    .nav__link.active-link::after{ transform:scaleX(1); }

    /* focus keyboard (aksesibilitas) */
    .nav__link:focus-visible{
      outline:none;
      box-shadow:0 0 0 3px rgba(51,102,255,.30);
    }

    /* sentuhan kecil saat diklik */
    .nav__link:active{ transform:translateY(1px); }

    /* hormati preferensi pengguna */
    @media (prefers-reduced-motion: reduce){
      .nav__link, .nav__link::after, .nav__link .bx{ transition:none !important; }
    }
  </style>
</head>

<body>
  <!--==================== HEADER ====================-->
  <header class="header" id="header">
    <nav class="nav container">
      <a href="{{ route('homepage') }}" class="nav__logo" aria-label="Sulawesi Tenggara">
        <span class="brand-logo__box" style="background-image:url('/images/logo-provinsi.png');"></span>
        <span class="logo-text">SULAWESI<i class="bx bxs-map"></i>TENGGARA</span>
      </a>

      <div class="nav__menu">
        <ul class="nav__list">
          <li class="nav__item">
            <a href="{{ route('homepage') }}" class="nav__link {{ request()->is('/') ? ' active-link' : '' }}">
              <i class="bx bx-home-alt"></i><span>Home</span>
            </a>
          </li>
          <li class="nav__item">
            <a href="{{ route('travel_package.index') }}" class="nav__link {{ request()->is('travel-packages') || request()->is('travel-packages/*') ? ' active-link' : '' }}">
              <i class="bx bx-building-house"></i><span>Detail Wisata</span>
            </a>
          </li>
          <li class="nav__item">
            <a href="{{ route('login') }}" class="nav__link {{ request()->is('contact') ? ' active-link' : '' }}">
              <i class="bx bx-phone"></i><span>Login</span>
            </a>
          </li>
        </ul>
      </div>

      <i class="bx bx-moon change-theme" id="theme-button"></i>
    </nav>
  </header>

  <!--==================== MAIN ====================-->
  <main class="main">
    @yield('content')
  </main>

  <!--==================== FOOTER (NUSANTARA) ====================-->
  <footer class="footer footer--nusantara">
    <div class="container">
      <div class="footer__grid">
        <!-- Kolom Brand & Deskripsi -->
        <div>
          <a href="{{ route('homepage') }}" class="footer__brand" aria-label="Beranda">
            <span class="brand-logo__box" style="background-image:url('/images/logo-provinsi.png');"></span>
            SULAWESI<i class="bx bxs-map"></i>TENGGARA
          </a>
          <p class="footer__description">
            Aplikasi Wisata Sulawesi Tenggara memudahkan Anda menemukan destinasi terbaik,
            paket perjalanan, serta informasi akomodasi—semuanya dalam satu tempat yang sederhana dan cepat.
          </p>
        </div>

        <!-- Kolom Navigasi -->
        <div>
          <h4 class="footer__title">Jelajah</h4>
          <ul class="footer__links">
            <li><a class="footer__link" href="{{ route('homepage') }}"><i class="bx bx-home-circle"></i>Beranda</a></li>
            <li><a class="footer__link" href="{{ route('travel_package.index') }}"><i class="bx bx-map-alt"></i>Detail Wisata</a></li>
            <li><a class="footer__link" href="{{ route('login') }}"><i class="bx bx-log-in-circle"></i>Login</a></li>
          </ul>
        </div>

        <!-- Kolom Sosial & Kontak -->
        <div>
          <h4 class="footer__title">Tetap Terhubung</h4>
          <div class="footer__badges" role="group" aria-label="tautan sosial">
            <a href="#" class="chip"><i class="bx bxl-instagram"></i> Instagram</a>
            <a href="#" class="chip"><i class="bx bxl-facebook"></i> Facebook</a>
            <a href="#" class="chip"><i class="bx bxl-youtube"></i> YouTube</a>
          </div>
          <div style="height:10px"></div>
          <div class="footer__badges" role="group" aria-label="kontak">
            <a href="mailto:info@sultra.app" class="chip"><i class="bx bx-envelope"></i> info@sultra.app</a>
            <a href="https://wa.me/6281234567890" class="chip"><i class="bx bxl-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>

      <div class="footer__separator"></div>

      <div class="footer__bottom">
        <span>© {{ date('Y') }} Sulawesi Tenggara Travel. All rights reserved.</span>
        <span>Desain khas Nusantara • Aksen biru & oranye</span>
      </div>
    </div>
  </footer>

  <!--========== SCROLL UP ==========-->
  <a href="#" class="scrollup" id="scroll-up">
    <i class="bx bx-chevrons-up"></i>
  </a>

  <!--=============== SCROLLREVEAL ===============-->
  <script src="{{ asset('frontend/assets/libraries/scrollreveal.min.js') }}"></script>

  <!--=============== SWIPER JS ===============-->
  <script src="{{ asset('frontend/assets/libraries/swiper-bundle.min.js') }}"></script>

  <!--=============== MAIN JS ===============-->
  <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

  @stack('script-alt')
</body>
</html>
