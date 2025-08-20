<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!--=============== BOXICONS ===============-->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <!--=============== SWIPER CSS ===============-->
  <link rel="stylesheet" href="{{ asset('frontend/assets/libraries/swiper-bundle.min.css') }}" />

  <!--=============== CSS ===============-->
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />

  {{-- penting: head memanggil stack ini --}}
  @stack('style-alt')

  <title>Sulawesi Tenggara</title>

  <style>
    :root{
        --logo-size: 75px;            /* desktop */
        --logo-gap: 10px;
        --brand-weight: 800;
        --brand-size: 1.5rem;        /* ~18px */
        --brand-letter: .1px;
        --brand-accent: #ff8a00;      /* warna ikon peta */
        }

        /* header pakai padding agar tinggi terasa lega */
        .header { padding-block: 12px; }
        .header .nav { display:flex; align-items:center; justify-content:space-between; }

        /* Komposisi brand */
        .nav__logo{
        display:flex; align-items:center; gap: var(--logo-gap);
        text-decoration:none;
        }

        .brand-logo__box{
            width: var(--logo-size);
            height: var(--logo-size);
            flex: 0 0 var(--logo-size);
            display:inline-block;
            background-repeat:no-repeat;
            background-position:center;
            background-size:contain;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,.06); /* halus saja */
        }

        .logo-text{
        display:inline-flex; align-items:center; gap:6px;
        font-weight: var(--brand-weight);
        font-size: var(--brand-size);
        letter-spacing: var(--brand-letter);
        line-height: 1;
        }

        /* kecilkan ikon peta agar jadi aksen, bukan fokus */
        .logo-text .bx{
        font-size: 1em;
        color: var(--brand-accent);
        translate: 0 1px; /* sedikit turun biar sejajar baseline */
        }

        /* ===== Responsif yang halus ===== */
        @media (max-width: 1024px){
        :root{ --logo-size: 42px; --brand-size: 1.08rem; }
        }

        @media (max-width: 768px){
        :root{ --logo-size: 34px; --logo-gap: 8px; --brand-size: 1rem; }
        .header{ padding-block: 10px; }
        }

        /* Jika ada rule global img, kita memang tidak pakai <img> untuk logo */
        .nav__logo img{ display:none!important; }
  </style>

@push('style-alt')
<link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<style>
  :root{
    --primary-color:#3366FF;
    --accent-color:#FF6600;
    --header-bg:#fff;
    --header-shadow:rgba(0,0,0,.1);
    --header-height:72px;
  }
  @media (max-width:768px){
    :root{ --header-height:64px; }
  }

  /* Header fixed + padding konten */
  .header{
    position:fixed; inset-block-start:0; inset-inline:0;
    height:var(--header-height);
    background:var(--header-bg)!important;
    box-shadow:0 2px 4px var(--header-shadow);
    z-index:1000; display:flex; align-items:center;
    overflow:hidden;
  }
  .header .nav{
    width:100%;
    display:flex; align-items:center; justify-content:space-between;
  }
  .main{ padding-top:var(--header-height); }

  /* Warna teks navbar */
  .header .nav__logo, .header .nav__link, .header .change-theme{ color:#000!important; }

  /* Susunan logo + teks */
.nav__logo{
  display:flex; align-items:center; gap:8px;
  font-weight:700; text-decoration:none;
}

  /* Kotak logo (pakai class baru supaya tidak bentrok) */
  .brand-logo__box{
  display:inline-block;
  width:32px; height:32px; flex:0 0 32px;
  border-radius:4px; overflow:hidden; line-height:0;
  background-repeat:no-repeat;
  background-position:center;
  background-size:contain;
}

  .logo-text { display:inline-flex; align-items:center; gap:4px; }

  @media (max-width:768px){
  .brand-logo__box{ width:28px; height:28px; flex-basis:28px; }
}

.header{
  position:fixed; inset-block-start:0; inset-inline:0;
  height:72px; background:#fff!important;
  box-shadow:0 2px 4px rgba(0,0,0,.1); z-index:1000;
  display:flex; align-items:center; overflow:hidden;
}
.header .nav{ width:100%; display:flex; align-items:center; justify-content:space-between; }
.main{ padding-top:72px; }
@media (max-width:768px){ .header{ height:64px; } .main{ padding-top:64px; } }

/* Link dan teks */
.header .nav__logo, .header .nav__link, .header .change-theme{ color:#000!important; }
.nav__logo{ display:flex; align-items:center; gap:8px; font-weight:700; text-decoration:none; }

/* === LOGO TANPA <img> === */
/* .brand-logo__box{
  width:32px; height:32px; flex:0 0 32px;
  display:inline-block; border-radius:4px; overflow:hidden; line-height:0;
  background: url("{{ asset('images/logo-provinsi.png') }}") no-repeat center center;
  background-size: contain;
}
@media (max-width:768px){
  .brand-logo__box{ width:28px; height:28px; flex-basis:28px; }
}
.brand-logo__box{ outline:1px solid #f00; background-color:#eee; }

.logo-text{ display:inline-flex; align-items:center; gap:4px; } */

/* MATIKAN SEMUA <img> DI DALAM .nav__logo (jika ada sisa element lama) */
/* .nav__logo img{ display:none !important; } */

/* Opsional: komponen lain (kalau perlu) */
.popular__card{ border:none; border-radius:.5rem; overflow:hidden; transition:transform .3s; background:#fff; box-shadow:0 4px 10px rgba(0,0,0,.06); }
.popular__card:hover{ transform:translateY(-5px); }
.popular__img{ width:100%; border-radius:.5rem .5rem 0 0; display:block; object-fit:cover; }
.popular__data{ padding:1rem; text-align:center; }
.swiper-button-prev,.swiper-button-next{ color:#3366FF!important; }
.swiper-pagination-bullet-active{ background-color:#3366FF!important; }
</style>
@endpush
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

  <!--==================== FOOTER ====================-->
  <footer class="footer section">
    <div class="footer__container container grid">
      <div>
        <a href="{{ route('homepage') }}" class="footer__logo">
          SULAWESI<i class="bx bxs-map"></i>TENGGARA
        </a>
        <p class="footer__description">
          Visi kami adalah membantu orang menemukan <br />
          Tempat wisata terbaik di Sulawesi Tenggara.
        </p>
      </div>

      <div class="footer__content">
        <div>
          <h3 class="footer__title">About</h3>
          <ul class="footer__links">
            <li><a href="#" class="footer__link">About Us</a></li>
            <li><a href="#" class="footer__link">Features</a></li>
            <li><a href="#" class="footer__link">News & Blog</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__title">Company</h3>
          <ul class="footer__links">
            <li><a href="#" class="footer__link">How We Work?</a></li>
            <li><a href="#" class="footer__link">Capital</a></li>
            <li><a href="#" class="footer__link">Security</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__title">Support</h3>
          <ul class="footer__links">
            <li><a href="#" class="footer__link">FAQs</a></li>
            <li><a href="#" class="footer__link">Support center</a></li>
            <li><a href="#" class="footer__link">Contact Us</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__title">Follow us</h3>
          <ul class="footer__social">
            <a href="#" class="footer__social-link"><i class="bx bxl-facebook-circle"></i></a>
            <a href="#" class="footer__social-link"><i class="bx bxl-instagram-alt"></i></a>
            <a href="#" class="footer__social-link"><i class="bx bxl-pinterest"></i></a>
          </ul>
        </div>
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
