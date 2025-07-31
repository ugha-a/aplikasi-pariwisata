@extends('layouts.frontend')

<<<<<<< HEAD
{{-- @php
    function convertToIDR($amountInUSD)
    {
        $exchangeRate = 15000; // Contoh nilai tukar USD ke IDR
        $amountInIDR = $amountInUSD * $exchangeRate;
        return $amountInIDR;
    }
@endphp --}}
=======
@dd(function_exists('convertToIDR'))
>>>>>>> 8ccba90dd2e1b862ec9ca804837a52cf7bd4450b

@section('content')
    <!--==================== HOME ====================-->
    <section>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <section class="islands swiper-slide">
                    <img src="{{ asset('frontend/assets/img/bali.jpg') }}" alt="" class="islands__bg" />

                    <div class="islands__container container">
                        <div class="islands__data">
                            <h1 class="islands__title">Package Travel</h1>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!--==================== POPULAR ====================-->
    <section class="section" id="popular">
        <div class="container">
            <h2 class="section__title" style="text-align: center">
                Package Travel
            </h2>

            <div class="popular__all">
                @foreach ($travel_packages as $travel_package)
                    <article class="popular__card">
                        <a href="{{ route('travel_package.show', $travel_package->slug) }}">
                            <img src="{{ Storage::url(optional($travel_package->galleries->first())->images) }}" class="islands__bg" alt="Wisata 2" />

                            <div class="popular__data">
                                <h2 class="popular__price">
                                    <span>Rp</span>{{ convertToIDR($travel_package->price) }}
                                </h2>
                                <h3 class="popular__title">{{ $travel_package->location }}</h3>
                                <p class="popular__description">{{ $travel_package->type }}</p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
