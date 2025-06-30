@extends('layouts.frontend')

@php
    function convertToIDR($amountInUSD)
    {
        $exchangeRate = 15000; // Contoh nilai tukar USD ke IDR
        $amountInIDR = $amountInUSD * $exchangeRate;
        return $amountInIDR;
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/swiper.css') }}">

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
                <img src="{{ asset('frontend/assets/img/hero.jpg') }}" class="islands__bg" alt="Sulawesi Selatan" />
                <div class="bg__overlay">
                    <div class="islands__container container">
                        <div class="islands__data" style="z-index: 99; position: relative">
                            <h1 class="islands__title">Sulawesi Selatan</h1>
                            <p class="islands__description">Selamat datang di wisata Sulawesi Selatan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            @foreach ($travel_packages as $package)
                <div class="swiper-slide">
                    <img src="{{ Storage::url($package->galleries->first()->images) }}" class="islands__bg"
                        alt="Wisata 2" />
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
    <section class="section" id="popular">
        <div class="container">

            <h2 class="section__title" style="text-align: center">
                Tempat Populer
            </h2>

            <div class="popular__container swiper">
                <div class="swiper-wrapper">
                    @foreach ($travel_packages as $travel_package)
                        <article class="popular__card swiper-slide">
                            <a href="{{ route('travel_package.show', $travel_package->slug) }}">
                                <img src="{{ Storage::url($travel_package->galleries->first()->images) }}" alt=""
                                    class="popular__img" />
                                <div class="popular__data">
                                    <h2 class="popular__price">
                                        <span>Rp</span>{{ number_format(convertToIDR($travel_package->price), 2, ',', '.') }}
                                    </h2>
                                    <h3 class="popular__title">
                                        {{ $travel_package->location }}
                                    </h3>
                                    <p class="popular__description">{{ $travel_package->type }}</p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="swiper-button-next">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="bx bx-chevron-left"></i>
                </div>
            </div>
        </div>
    </section>

    <!--==================== VALUE ====================-->
    <section class="value section" id="value">
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
                        Kami membuat pilihan yang baik untuk bepergian ke seluruh wisata yang ada di Sumbawa.
                    </p>
                </div>

                <div class="value__accordion">
                    <div class="value__accordion-item">
                        <header class="value__accordion-header">
                            <i class="bx bxs-shield-x value-accordion-icon"></i>
                            <h3 class="value__accordion-title">
                                Tempat terbaik di Sumbawa
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
    </section>


    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
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
    </script>
@endsection
