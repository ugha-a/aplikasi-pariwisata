@extends('layouts.frontend')

@section('content')
<section class="section" id="popular">
  <div class="container">
    <h2 class="section__title" style="text-align:center">Detail Wisata</h2>

    {{-- FILTER & SEARCH BAR (server-side GET + auto submit) --}}
    <div class="popular__filter-bar">
      <form id="filterForm" class="popular__filter-form" method="GET" action="">
        <div class="field-with-icon">
          <i class="bx bx-search"></i>
          <input id="qSearch" name="search" type="text" class="popular__search-input"
                 placeholder="Cari nama wisata atau lokasi..."
                 value="{{ request('search') }}" />
        </div>

        <select id="filterLokasi" name="lokasi" class="popular__filter-select">
          <option value="">Semua Lokasi</option>
          @foreach ($locations as $loc)
            @php $val = strtolower($loc->name); @endphp
            <option value="{{ $val }}" {{ request('lokasi') === $val ? 'selected' : '' }}>
              {{ $loc->name }}
            </option>
          @endforeach
        </select>
      </form>
    </div>

    {{-- GRID KARTU (halaman ini saja) --}}
    <div class="cards-grid">
      @forelse ($travel_packages as $tp)
        <article class="place-card">
          <a href="{{ route('travel_package.show', $tp->slug) }}" class="card-link">
            <div class="card-media">
              <div class="swiper card-swiper" id="swiper-{{ $tp->id }}">
                <div class="swiper-wrapper">
                  @php $slides = $tp->galleries ?? collect(); @endphp
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

            <div class="card-body">
              <h3 class="card-title">{{ $tp->location }}</h3>
              <p class="card-sub">{{ $tp->type }}</p>
              <div class="card-meta">
                <div></div>
                <div class="price"><span class="rp">Rp</span>{{ convertToIDR($tp->price) }}</div>
              </div>
            </div>
          </a>
        </article>
      @empty
        <div class="empty">Data tidak ditemukan.</div>
      @endforelse
    </div>

    {{-- PAGINATION: bawa query search & lokasi --}}
    <div class="d-flex justify-content-center mt-4">
      {{ $travel_packages->appends(request()->only('search','lokasi'))->links() }}
    </div>

  </div>
</section>
@endsection

@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css">
<style>
  :root { --brand:#3366FF; --ink:#1f2a4a; --muted:#6c7493; --card:#fff; --soft:#eef3ff; }
  .popular__filter-bar{ display:flex; justify-content:center; margin-bottom:1.6rem; }
  .popular__filter-form{ display:flex; gap:1rem; flex-wrap:wrap; align-items:center; background:#fff; padding:1rem 1.2rem; border-radius:1rem; box-shadow:0 8px 24px rgba(31,42,74,.06); }
  .field-with-icon{ position:relative; }
  .field-with-icon i{ position:absolute; left:.65rem; top:50%; transform:translateY(-50%); opacity:.55; }
  .popular__search-input, .popular__filter-select{ padding:.55rem 1rem .55rem 2.2rem; border-radius:.6rem; border:1px solid #e7ecf5; background:#f8faff; min-width:220px; outline:none; }
  .popular__filter-select{ padding-left:1rem; min-width:180px; }
  .popular__search-input:focus, .popular__filter-select:focus{ border-color:var(--brand); background:#fff; }
  .cards-grid{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1.5rem; }
  @media (max-width:900px){ .cards-grid{ grid-template-columns:1fr; } }
  .place-card{ background:var(--card); border-radius:14px; overflow:hidden; box-shadow:0 12px 30px rgba(31,42,74,.08); transition:transform .2s, box-shadow .2s; }
  .place-card:hover{ transform:translateY(-4px); box-shadow:0 16px 40px rgba(31,42,74,.12); }
  .card-media{ position:relative; width:100%; height:220px; overflow:hidden; }
  .card-media img{ width:100%; height:100%; object-fit:cover; display:block; }
  .card-body{ padding:1rem 1.2rem 1.2rem; }
  .card-title{ font-size:1.15rem; font-weight:800; color:var(--ink); margin:0 0 .25rem; }
  .card-sub{ color:var(--muted); margin:0 0 .75rem; }
  .card-meta{ display:flex; align-items:center; justify-content:space-between; gap:.75rem; }
  .price{ font-weight:800; color:#d13c2e; }
  .price .rp{ color:#ff8800; margin-right:2px; }
  .empty{ text-align:center; width:100%; color:#b3b3b3; font-style:italic; padding:1.2rem 0; }
  .swiper-pagination{ display:none; }
</style>
@endpush

@push('script-alt')
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Swiper tiap kartu
  document.querySelectorAll('.card-swiper').forEach(el=>{
    new Swiper(el, {
      loop: true,
      speed: 600,
      autoplay: { delay: 1000, disableOnInteraction: false },
      slidesPerView: 1,
      effect: 'slide'
    });
  });

  // Auto-submit filter (debounce) -> server-side paginate tetap jalan
  const form   = document.getElementById('filterForm');
  const input  = document.getElementById('qSearch');
  const select = document.getElementById('filterLokasi');

  const debounce = (fn, d=400) => {
    let t; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn.apply(this,args), d); };
  };

  const submitNow = () => form?.submit();

  input?.addEventListener('input', debounce(submitNow, 450));
  select?.addEventListener('change', submitNow);
});
</script>
@endpush
