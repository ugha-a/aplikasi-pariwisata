@extends('layouts.frontend')

@section('content')
    <!--==================== POPULAR ====================-->
    <section class="section" id="popular">
        <div class="container">
            <h2 class="section__title" style="text-align: center">
                Detail Wisata
            </h2>
            {{-- FILTER & SEARCH BAR --}}
            <div class="popular__filter-bar">
                <form method="GET" action="" class="popular__filter-form">
                    <input type="text" name="search" class="popular__search-input"
                        placeholder="Cari nama wisata" value="{{ request('search') }}" />

                    <select name="lokasi" class="popular__filter-select">
                        <option value="">Semua Lokasi</option>
                        {{-- @foreach($locations as $loc) --}}
                            <option value="lokasi">lokasi</option>
                        {{-- @endforeach --}}
                    </select>
                    <button type="submit" class="btn-search"><i class="bx bx-search"></i> Cari</button>
                </form>
            </div>

            <div class="popular__scroll-list">
                @forelse ($travel_packages as $travel_package)
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
                @empty
                    <div style="text-align:center;width:100%;color:#b3b3b3;font-style:italic;">Data tidak ditemukan.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('style-alt')
<style>
.popular__filter-bar {
    display: flex;
    justify-content: center;
    margin-bottom: 2.2rem;
}
.popular__filter-form {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
    background: #fff;
    padding: 1.15rem 1.6rem;
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(51,102,255,0.08);
}
.popular__search-input, .popular__filter-select {
    padding: 0.55rem 1rem;
    border-radius: 0.55rem;
    border: 1.3px solid #dde7ff;
    background: #f6faff;
    font-size: 1rem;
    min-width: 190px;
    outline: none;
    transition: border .18s;
}
.popular__search-input:focus, .popular__filter-select:focus {
    border-color: #3366FF;
}
.btn-search {
    background: #3366FF;
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 0.5rem;
    padding: 0.6rem 1.7rem;
    box-shadow: 0 2px 12px rgba(51,102,255,0.12);
    cursor: pointer;
    transition: background .18s;
    display: flex;
    align-items: center;
    gap: 0.4em;
}
.btn-search:hover { background: #254ecf; }
/* --------- CARD LIST --------- */
.popular__scroll-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    max-width: 700px;
    margin: 2rem auto 0 auto;
    overflow: visible;
    padding-bottom: 2rem;
}
@media (max-width: 900px) {
    .popular__scroll-list {
        max-width: 100%;
        grid-template-columns: 1fr;
    }
}
.popular__card-list {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 6px 24px hsl(228, 66%, 53%, 0.12);
    padding: 1.5rem 1.2rem;
    transition: transform .22s, box-shadow .22s;
    border: 1.5px solid transparent;
    width: 100%;
    max-width: 320px;
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
@media (max-width: 768px) {
    .popular__scroll-list {
        grid-template-columns: 1fr;
        max-height: unset;
    }
    .popular__filter-form { flex-direction: column; gap: .8rem; padding: 0.9rem 0.5rem; }
    .popular__search-input, .popular__filter-select { width: 100%; min-width: unset; }
}
</style>
@endpush
