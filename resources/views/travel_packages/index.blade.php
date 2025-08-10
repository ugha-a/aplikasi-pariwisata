@extends('layouts.frontend')

@section('content')
<section class="section" id="popular">
  <div class="container">
    <h2 class="section__title" style="text-align:center">Detail Wisata</h2>

    {{-- FILTER & SEARCH BAR --}}
    <div class="popular__filter-bar">
      <form method="GET" action="" class="popular__filter-form">
        <div class="field-with-icon">
          <i class="bx bx-search"></i>
          <input type="text" name="search" class="popular__search-input"
                 placeholder="Cari nama wisata atau lokasi..." value="{{ request('search') }}" />
        </div>

        <select name="lokasi" class="popular__filter-select">
          <option value="">Semua Lokasi</option>
          {{-- @foreach ($locations as $loc) --}}
          {{-- <option value="{{ $loc }}" {{ request('lokasi')==$loc?'selected':'' }}>{{ $loc }}</option> --}}
          {{-- @endforeach --}}
        </select>

        <button type="submit" class="btn-search"><i class="bx bx-search"></i> Cari</button>
      </form>
    </div>

    {{-- GRID KARTU --}}
    <div class="cards-grid">
      @forelse ($travel_packages as $tp)
        <article class="place-card">
          <a href="{{ route('travel_package.show', $tp->slug) }}" class="card-link">
            {{-- MEDIA: SLIDER GAMBAR --}}
            <div class="card-media">
              <div class="swiper card-swiper" id="swiper-{{ $tp->id }}">
                <div class="swiper-wrapper">
                  @php
                    $slides = $tp->galleries ?? collect();
                  @endphp

                  @if($slides->count())
                    @foreach($slides as $g)
                      <div class="swiper-slide">
                        <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $tp->location }}">
                      </div>
                    @endforeach
                  @else
                    <div class="swiper-slide">
                      <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200&auto=format&fit=crop" alt="placeholder">
                    </div>
                    <div class="swiper-slide">
                      <img src="https://images.unsplash.com/photo-1493558103817-58b2924bce98?q=80&w=1200&auto=format&fit=crop" alt="placeholder">
                    </div>
                  @endif
                </div>
              </div>
            </div>

            {{-- BODY --}}
            <div class="card-body">
              <h3 class="card-title">{{ $tp->location }}</h3>
              <p class="card-sub">{{ $tp->type }}</p>

              <div class="card-meta">
                <div class="rating">
                  <i class="bx bxs-star"></i>
                  <i class="bx bxs-star"></i>
                  <i class="bx bxs-star"></i>
                  <i class="bx bxs-star"></i>
                  <i class="bx bxs-star-half"></i>
                  <span class="muted">(20 Review)</span>
                </div>

                <div class="price">
                  <span class="rp">Rp</span>{{ convertToIDR($tp->price) }}
                </div>
              </div>
            </div>
          </a>
        </article>
      @empty
        <div class="empty">Data tidak ditemukan.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection

@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css">
<style>
  :root { --brand:#3366FF; --ink:#1f2a4a; --muted:#6c7493; --card:#ffffff; --soft:#eef3ff; --accent:#ff6b00; }

  /* Filter bar */
  .popular__filter-bar{ display:flex; justify-content:center; margin-bottom:1.6rem; }
  .popular__filter-form{
    display:flex; gap:1rem; flex-wrap:wrap; align-items:center;
    background:#fff; padding:1rem 1.2rem; border-radius:1rem;
    box-shadow:0 8px 24px rgba(31,42,74,.06);
  }
  .field-with-icon{ position:relative; }
  .field-with-icon i{ position:absolute; left:.65rem; top:50%; transform:translateY(-50%); opacity:.55; }
  .popular__search-input, .popular__filter-select{
    padding:.55rem 1rem .55rem 2.2rem; border-radius:.6rem;
    border:1px solid #e7ecf5; background:#f8faff; min-width:220px; outline:none;
  }
  .popular__filter-select{ padding-left:1rem; min-width:180px; }
  .popular__search-input:focus, .popular__filter-select:focus{ border-color:var(--brand); background:#fff; }
  .btn-search{
    background:var(--brand); color:#fff; border:none; border-radius:.6rem; padding:.6rem 1.2rem;
    box-shadow:0 8px 20px rgba(51,102,255,.18); display:flex; align-items:center; gap:.45rem;
  }
  .btn-search:hover{ background:#254ecf; }

  /* Grid cards */
  .cards-grid{
    display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:1.5rem;
  }
  @media (max-width: 900px){ .cards-grid{ grid-template-columns:1fr; } }

  /* Card */
  .place-card{
    background:var(--card); border-radius:14px; overflow:hidden;
    box-shadow:0 12px 30px rgba(31,42,74,.08); transition:transform .2s, box-shadow .2s;
  }
  .place-card:hover{ transform:translateY(-4px); box-shadow:0 16px 40px rgba(31,42,74,.12); }
  .card-link{ color:inherit; text-decoration:none; display:block; }

  .card-media{ position:relative; width:100%; height:220px; overflow:hidden; }
  .card-media img{ width:100%; height:100%; object-fit:cover; display:block; }

  .card-body{ padding:1rem 1.2rem 1.2rem; }
  .card-title{ font-size:1.15rem; font-weight:800; color:var(--ink); margin:0 0 .25rem; }
  .card-sub{ color:var(--muted); margin:0 0 .75rem; }

  .card-meta{
    display:flex; align-items:center; justify-content:space-between; gap:.75rem;
  }
  .rating{ display:flex; align-items:center; gap:.15rem; color:#ffb200; }
  .rating .muted{ color:#9aa3b2; margin-left:.35rem; font-size:.95rem; }
  .price{ font-weight:800; color:#d13c2e; } /* sedikit kemerahan seperti contoh */
  .price .rp{ color:#ff8800; margin-right:2px; }

  .empty{ text-align:center; width:100%; color:#b3b3b3; font-style:italic; padding:1.2rem 0; }

  /* Swiper dots (optional hidden for clean look) */
  .swiper-pagination{ display:none; }
</style>
@endpush

@push('script-alt')
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
<script>
  // Inisialisasi semua slider pada halaman
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.card-swiper').forEach(function(el){
      new Swiper(el, {
        loop: true,
        speed: 1000,
        autoplay: { delay: 3500, disableOnInteraction: false }, // ganti setiap 1 detik
        slidesPerView: 1,
        effect: 'slide'
      });
    });
  });
</script>
@endpush
