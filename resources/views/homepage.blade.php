@extends('layouts.frontend')

{{-- @php
    function convertToIDR($amountInUSD)
    {
        $exchangeRate = 15000; // Contoh nilai tukar USD ke IDR
        $amountInIDR = $amountInUSD * $exchangeRate;
        return $amountInIDR;
    }
@endphp --}}

<link rel="stylesheet" href="{{ asset('css/swiper.css') }}">

@push('styles')
<link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<style>
  /* Brand Colors */
  :root {
    --primary-color: #3366FF; /* Blue from font */
    --accent-color: #FF6600;  /* Pin icon color */
  }

  /* Base Button Styles (Bootstrap-like) */
  .btn {
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out,
                background-color .15s ease-in-out,
                border-color .15s ease-in-out,
                box-shadow .15s ease-in-out;
    cursor: pointer;
  }

  /* Primary Button */
  .btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #254dcf;
    border-color: #254dcf;
    color: #fff;
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
    backdrop-filter: brightness(70%);
    z-index: 1;
  }
  .hero-section .islands__container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
    flex-direction: column;
    padding: 0 1rem;
    text-align: center;
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

  /* Swiper Navigation & Pagination Colors */
  .swiper-button-next, .swiper-button-prev {
    color: var(--primary-color) !important;
  }
  .swiper-pagination-bullet-active {
    background-color: var(--primary-color) !important;
  }

  .navbar.navbar-scrolled {
    background-color: #fff !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: background .3s;
  }
</style>
@endpush

@section('content')
    <!--==================== HOME ====================-->
    {{-- <section>
        <div class="swiper-container">
            <div>
                <section class="islands">
                    <img src="{{ asset('frontend/assets/img/hero.jpg') }}" alt="" class="islands__bg" />
                    <div class="bg__overlay">
                        <div class="islands__container container">
                            <div class="islands__data" style="z-index: 99; position: relative">
                                <h1 class="islands__title">
                                    Sulawesi Tenggara
                                </h1>
                                <p class="islands__description">
                                    Selamat datang di wisata Sulawesi Tenggara
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section> --}}

    <section class="swiper mySwiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="{{ asset('frontend/assets/img/hero.jpg') }}" class="islands__bg" alt="Sulawesi Tenggara" />
                <div class="bg__overlay">
                    <div class="islands__container container">
                        <div class="islands__data" style="z-index: 99; position: relative">
                            <h1 class="islands__title">Sulawesi Tenggara</h1>
                            <p class="islands__description">Selamat datang di wisata Sulawesi Tenggara</p>
                            <a class="islands__description button button-booking" style="margin-top: 50px">Detail Wisata</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            @foreach ($travel_packages as $package)
                <div class="swiper-slide">
                    <img src="{{ Storage::url(optional($package->galleries->first())->images) }}" class="islands__bg" alt="Wisata 2" />
                    <div class="bg__overlay">
                        <div class="islands__container container">
                            <div class="islands__data" style="z-index: 99; position: relative">
                                <h1 class="islands__title">{{ $package->location }}</h1>
                                <div class="islands__description text-white">{!! $package->description !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Tambah slide lainnya sesuai kebutuhan -->
        </div>

        <!-- Optional navigation -->
        {{-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div> --}}
    </section>


    {{-- <div class="swiper-container wisataSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ Storage::url($package->galleries->first()->images) }}" alt="{{ $package->location }}">
                <div class="card-body">
                    <h3>{{ $package->location }}</h3>
                    <p>{!! $package->description !!}</p>
                </div>
                <!-- konten slide ke-1 -->
            </div>
            <!-- optional: pagination, navigation -->
        </div> --}}

    <!--==================== WISATA SLIDER ====================-->
    {{-- <div class="swiper wisataSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card">

                    </div>
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div> --}}



    <!--==================== POPULAR ====================-->
    {{-- <section id="popular" class="section pt-5">
        <div class="container">
      
          <h2 class="section__title text-center mb-4" data-aos="fade-up">
            Tempat Populer
          </h2>
      
          <div class="popular__container swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
              @foreach($travel_packages as $package)
                <div class="swiper-slide">
                  <div class="card popular__card border-0 h-100">
                    <a href="{{ route('travel_package.show', $package->slug) }}" class="text-decoration-none">
                      <img src="{{ Storage::url(optional($package->galleries->first())->images) }}" 
                           alt="{{ $package->location }}" 
                           class="card-img-top popular__img" />
                      <div class="card-body text-center popular__data">
                        <h3 class="popular__price"><span>Rp</span>{{ convertToIDR($package->price) }}</h3>
                        <h4 class="popular__title">{{ $package->location }}</h4>
                        <p class="popular__description">{{ $package->type }}</p>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
      
            <!-- Navigation -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
      
            <!-- Pagination -->
            <div class="swiper-pagination mt-4"></div>
          </div>
        </div>
      </section> --}}

    <!--==================== VALUE ====================-->
    {{-- <section class="value section" id="value">
        <div class="value__container container grid">
            <div class="value__images">
                <div class="value__orbe"></div>

                <div class="value__img">
                    <img src="{{ asset('frontend/assets/img/team.jpg') }}" alt="" />
                </div>
            </div>

            <div class="value__content">
                <div class="value__data">
                    <h2 class="section__title">
                        Pengalaman Yang Kami Janjikan Kepada Anda
                    </h2>
                    <p class="value__description">
                        Kami selalu siap melayani dengan memberikan pelayanan terbaik untuk Anda.
                        Kami membuat pilihan yang baik untuk bepergian ke seluruh wisata yang ada di Sulawesi Tenggara.
                    </p>
                </div>

                <div class="value__accordion">
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class="bx bxs-shield-x value-accordion-icon"></i>
                            <h3 class="value__accordion-title">
                                Tempat terbaik di Sulawesi Tenggara
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class="bx bxs-down-arrow"></i>
                            </div>
                        </header>

                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                Kami menyediakan tempat-tempat terbaik di sekitar
                                Sumbawa dan memiliki kualitas yang baik
                                di sana.
                            </p>
                        </div>
                    </div>
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class="bx bxs-x-square value-accordion-icon"></i>
                            <h3 class="value__accordion-title">
                                Harga Terjangkau Untuk Anda!
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class="bx bxs-down-arrow"></i>
                            </div>
                        </header>

                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                Kami mencoba untuk membuat anggaran Anda sesuai dengan
                                tujuan wisata yang ingin Anda tuju.
                            </p>
                        </div>
                    </div>
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class="bx bxs-check-square value-accordion-icon"></i>
                            <h3 class="value__accordion-title">
                                Jaminan Keamanan
                            </h3>
                            <div class="value__accordion-arrow">
                                <i class="bx bxs-down-arrow"></i>
                            </div>
                        </header>

                        <div class="value__accordion-content">
                            <p class="value__accordion-description">
                                Kami memastikan bahwa layanan kami memiliki
                                keamanan yang sangat baik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    {{-- <script>
        // Hero slider dengan autoplay 1 detik
        const swiper = new Swiper('.mySwiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 2500, // berpindah setiap 1 detik
                disableOnInteraction: false,
            },
            effect: 'fade',
        });

        // Wisata slider dengan autoplay 1 detik
        const wisataSwiper = new Swiper('.wisataSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 1000, // tambahkan autoplay di sini juga
                disableOnInteraction: false,
            },
        });
    </script> --}}
@endsection
