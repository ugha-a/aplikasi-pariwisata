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
    @stack('style-alt')
    <title>Sulawesi Tenggara</title>
</head>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<style>
  /* Brand Colors */
  :root {
    --primary-color: #3366FF;
    --accent-color: #FF6600;
    --header-bg: #fff;
    --header-shadow: rgba(0, 0, 0, 0.1);
  }

  /* Always-white header with shadow */
  .header {
    background-color: var(--header-bg) !important;
    box-shadow: 0 2px 4px var(--header-shadow);
    transition: background .3s, box-shadow .3s;
    z-index: 1000;
  }
  .header .nav__logo,
  .header .nav__link,
  .header .change-theme {
    color: #000 !important;
  }

  /* Hero Section Fullscreen Background Image */
  .hero-section {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
  }
  .hero-section .swiper-slide {
    position: relative;
    width: 100%;
    height: 100%;
  }
  .hero-section .swiper-slide img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .hero-section .bg__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
  }
  .hero-section .islands__container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    color: #fff;
    text-align: center;
    padding: 0 1rem;
  }
  .hero-section .islands__title {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
  }
  .hero-section .islands__description {
    font-size: 1.25rem;
    margin-bottom: 1rem;
  }

  /* Base Button Styles */
  .btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    border: none;
    cursor: pointer;
    transition: background-color .3s;
  }
  .btn-primary {
    background-color: var(--primary-color);
    color: #fff;
  }
  .btn-primary:hover {
    background-color: darken(var(--primary-color), 10%);
  }

  /* Popular Section */
  .popular__container {
    position: relative;
    padding: 2rem 0;
  }
  .popular__card {
    border: none;
    border-radius: 0.5rem;
    overflow: hidden;
    transition: transform .3s;
  }
  .popular__card:hover {
    transform: translateY(-5px);
  }
  .popular__img {
    width: 100%;
    border-radius: 0.5rem 0.5rem 0 0;
  }
  .popular__data {
    padding: 1rem;
    text-align: center;
  }

  /* Swiper Controls */
  .swiper-button-prev, .swiper-button-next {
    color: var(--primary-color) !important;
  }
  .swiper-pagination-bullet-active {
    background-color: var(--primary-color) !important;
  }
</style>
@endpush

<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="{{ route('homepage') }}" class="nav__logo">SULAWESI<i class="bx bxs-map"></i>TENGGARA</a>

            <div class="nav__menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="{{ route('homepage') }}"
                            class="nav__link {{ request()->is('/') ? ' active-link' : '' }}">
                            <i class="bx bx-home-alt"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="{{ route('travel_package.index') }}"
                            class="nav__link {{ request()->is('travel-packages') || request()->is('travel-packages/*') ? ' active-link' : '' }}">
                            <i class="bx bx-building-house"></i>
                            <span>Detail Wisata</span>
                        </a>
                    </li>
                    {{-- <li class="nav__item">
                        <a href="{{ route('location.index') }}"
                            class="nav__link {{ request()->is('locations') || request()->is('locations/*') ? ' active-link' : '' }}">
                            <i class="bx bx-award"></i>
                            <span>Location</span>
                        </a>
                    </li> --}}
                    <li class="nav__item">
                        <a href="{{ route('contact') }}"
                            class="nav__link {{ request()->is('contact') ? ' active-link' : '' }}">
                            <i class="bx bx-phone"></i>
                            <span>Login</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- theme -->
            <i class="bx bx-moon change-theme" id="theme-button"></i>

            {{-- <a target="_blank" href="https://api.whatsapp.com/send?phone=088111444&text=I want to booking"
                class="button nav__button">Booking Now</a> --}}
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
            </div>

            <div class="footer__content">
                <div>
                    <h3 class="footer__title">About</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">About Us</a>
                        </li>
                        <li>
                            <a href="#" class="footer__link">Features </a>
                        </li>
                        <li>
                            <a href="#" class="footer__link">News & Blog</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">Company</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">How We Work?
                            </a>
                        </li>
                        <li>
                            <a href="#" class="footer__link">Capital </a>
                        </li>
                        <li>
                            <a href="#" class="footer__link"> Security</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">Support</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">FAQs </a>
                        </li>
                        <li>
                            <a href="#" class="footer__link">Support center
                            </a>
                        </li>
                        <li>
                            <a href="#" class="footer__link"> Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">Follow us</h3>

                    <ul class="footer__social">
                        <a href="#" class="footer__social-link">
                            <i class="bx bxl-facebook-circle"></i>
                        </a>
                        <a href="#" class="footer__social-link">
                            <i class="bx bxl-instagram-alt"></i>
                        </a>
                        <a href="#" class="footer__social-link">
                            <i class="bx bxl-pinterest"></i>
                        </a>
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
