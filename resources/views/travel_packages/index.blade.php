@extends('layouts.frontend')

@section('content')
    <!--==================== POPULAR ====================-->
    <section class="section" id="popular">
        <div class="container">
            <h2 class="section__title" style="text-align: center">
                Package Travel
            </h2>
            <div class="popular__scroll-list">
                @foreach ($travel_packages as $travel_package)
                    <div class="popular__card-list">
                        <a href="{{ route('travel_package.show', $travel_package->slug) }}">
                            <div class="popular__data">
                                <h2 class="popular__price" style="color:#6c7493;">
                                    <span>Rp</span>{{ convertToIDR($travel_package->price) }}
                                </h2>
                                <h3 class="popular__title" style="color:#3366FF;">
                                    {{ $travel_package->location }}
                                </h3>
                                <p class="popular__description" style="color:#6c7493;">
                                    {{ $travel_package->type }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('style-alt')
    <style>
    /* Wrapper grid: 2 kolom, scroll vertikal, gap */
    .popular__scroll-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    /* BATAS MAKSIMUM LEBAR GRID, misal: */
    max-width: 700px;
    margin: 2rem auto 0 auto;
    /* Overflow-x dan scroll-y dihilangkan supaya tetap rapih */
    overflow: visible;
    padding-bottom: 2rem;
}

@media (max-width: 900px) {
    .popular__scroll-list {
        max-width: 100%;
        grid-template-columns: 1fr;
    }
}

    /* Style card */
    .popular__card-list {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 6px 24px hsl(228, 66%, 53%, 0.12);
    padding: 1.5rem 1.2rem;
    transition: transform .22s, box-shadow .22s;
    border: 1.5px solid transparent;
    width: 100%;
    max-width: 320px; /* opsional, agar card tidak terlalu lebar */
    margin: 0 auto;
    }
    .popular__card-list:hover {
    transform: translateY(-5px) scale(1.04);
    box-shadow: 0 12px 38px hsla(228,66%,53%,0.24);
    border: 2px solid hsl(228, 66%, 53%);
    }

    .popular__card-list a {
    color: inherit;
    text-decoration: none;
    display: block;
    }

    .popular__price {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: 0.5px;
    color: #6c7493;
    }
    .popular__price span {
    color: #FF8800;
    font-weight: bold;
    margin-right: 2px;
    }
    .popular__title {
    font-size: 1.15rem;
    margin-bottom: 0.15rem;
    font-weight: 800;
    color: #3366FF;
    }
    .popular__description {
    font-size: 1.01rem;
    opacity: 0.85;
    color: #6c7493;
    }

    /* Responsive: 1 kolom di HP */
    @media (max-width: 768px) {
    .popular__scroll-list {
        grid-template-columns: 1fr;
        max-height: unset;
    }
    }
    </style>
@endpush
