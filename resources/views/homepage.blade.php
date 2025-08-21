@extends('layouts.frontend')

@push('style-alt')
  {{-- Pakai SATU Swiper CSS saja --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  {{-- Boxicons for icons --}}
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

  <style>
    :root{ --primary:#3366FF; --primary-600:#254ecf; --ink:#0f172a; --muted:#64748b; --surface:#fff; }

    .button{ display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 1.25rem;
      border-radius:.9rem; font-weight:700; text-decoration:none; border:0; cursor:pointer; }
    .button.primary{ background:linear-gradient(135deg,var(--primary),var(--primary-600)); color:#fff;
      box-shadow:0 10px 22px rgba(51,102,255,.25); transition:.25s; }
    .button.primary:hover{ transform:translateY(-2px); box-shadow:0 14px 26px rgba(37,78,207,.35); }

    /* ===== HERO (rename .content -> .hero-content to avoid conflicts) ===== */
    .hero{ position:relative; height:100vh; min-height:520px; }
    .hero .swiper{ height:100%; }
    .hero .swiper-slide{ position:relative; }
    .hero .bg{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:saturate(110%); }
    .hero .overlay{ position:absolute; inset:0; background:linear-gradient(180deg,rgba(0,0,0,.35),rgba(0,0,0,.45)); }
    .hero .hero-content{ position:absolute; inset:0; display:grid; place-items:center; text-align:center; padding:0 1.25rem; }
    .hero h1{ color:#fff; font-size:clamp(2rem,5.2vw,3.5rem); font-weight:900; letter-spacing:.2px; margin:0 0 .5rem; }
    .hero p{ color:#e5e7eb; font-size:clamp(1rem,1.2vw,1.25rem); margin:0; opacity:.95; }
    .hero .cta{ margin-top:1.25rem; }
    .hero .badge{ display:inline-flex; align-items:center; gap:.5rem; color:#fff;
      background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.25);
      padding:.35rem .7rem; border-radius:999px; font-weight:700; margin-bottom:.75rem; }
    .scroll-hint{ position:absolute; left:0; right:0; bottom:20px; margin:auto; width:max-content; color:#fff; opacity:.8;
      display:flex; align-items:center; gap:.4rem; font-weight:600; animation:floaty 2.2s ease-in-out infinite; }
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(6px)}}

    .section { padding:64px 0; }
    .container{ width:min(1120px,92%); margin:0 auto; }

    .features{ display:grid; gap:1rem; grid-template-columns:repeat(1,minmax(0,1fr)); }
    @media (min-width:768px){ .features{ grid-template-columns:repeat(3,1fr); } }
    .feature{ background:linear-gradient(180deg,#fff,#f8fbff); border:1px solid #edf2ff; border-radius:1rem; padding:18px; display:flex; gap:12px; }
    .feature i{ color:var(--primary); font-size:22px; margin-top:2px; }
    .feature h4{ margin:0 0 4px; font-weight:800; color:#1f2a44; }
    .feature p{ margin:0; color:var(--muted); font-size:.98rem; }

    .grid{ display:grid; gap:1rem; }
    .grid.popular{ grid-template-columns:repeat(1,minmax(0,1fr)); }
    @media (min-width:640px){ .grid.popular{ grid-template-columns:repeat(2,1fr); } }
    @media (min-width:992px){ .grid.popular{ grid-template-columns:repeat(3,1fr); } }
    .card{ background:var(--surface); border:1px solid #eef2f9; border-radius:1rem; overflow:hidden;
      box-shadow:0 12px 30px rgba(51,102,255,.06); transition:transform .25s, box-shadow .25s; }
    .card:hover{ transform:translateY(-4px); box-shadow:0 18px 38px rgba(51,102,255,.10); }
    .card .thumb{ aspect-ratio:4/3; width:100%; object-fit:cover; display:block; }
    .card .body{ padding:14px 16px 18px; }
    .card .title{ font-weight:800; color:#0f172a; margin:2px 0 4px; }
    .card .muted{ color:#64748b; }

    .swiper-button-next,.swiper-button-prev{ color:#fff; opacity:.85; }
    .swiper-button-next:hover,.swiper-button-prev:hover{ opacity:1; }
    .swiper-pagination-bullet{ background:#fff; opacity:.6; }
    .swiper-pagination-bullet-active{ background:var(--primary); opacity:1; }
  </style>
@endpush


@section('content')

  {{-- ==================== HERO ==================== --}}
  <section class="hero">
    <div class="swiper hero-swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img class="bg" src="{{ asset('frontend/assets/img/hero.jpg') }}" alt="Sulawesi Tenggara">
          <div class="overlay"></div>
          <div class="hero-content">  {{-- <- di sini --}}
            <div data-aos="fade-up" data-aos-delay="50">
              <span class="badge"><i class="bx bxs-map-pin"></i> Sulawesi Tenggara</span>
              <h1>Jelajahi Surga Wisata di Timur Indonesia</h1>
              <p>Destinasi cantik, laut sebening kristal, budaya yang hangat.</p>
              <div class="cta">
                <a href="{{ route('travel_package.index') }}" class="button primary">
                  <i class="bx bx-compass"></i> Detail Wisata
                </a>
              </div>
            </div>
          </div>
        </div>
  
        {{-- slide lain --}}
        @foreach ($travel_packages as $package)
          @php
            $cover = optional($package->galleries->first())->images;
            $src   = $cover ? Storage::url($cover) : asset('frontend/assets/img/hero.jpg');
          @endphp
          <div class="swiper-slide">
            <img class="bg lazy" data-src="{{ $src }}" alt="{{ $package->location ?? 'Destinasi' }}">
            <div class="overlay"></div>
            <div class="hero-content">
              <div data-aos="fade-up">
                <span class="badge"><i class="bx bxs-pin"></i> {{ $package->location ?? 'Lokasi wisata' }}</span>
                <h1>{{ $package->name ?? 'Paket Wisata' }}</h1>
                @if(!empty($package->description))
                  <p>{!! \Illuminate\Support\Str::limit(strip_tags($package->description), 140) !!}</p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
  
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-pagination"></div>
      <div class="scroll-hint"><i class="bx bx-chevrons-down"></i> gulir untuk info</div>
    </div>
  </section>
  

  {{-- ==================== FEATURE STRIP ==================== --}}
  <section class="section">
    <div class="container">
      <div class="features">
        <div class="feature" data-aos="fade-up" data-aos-delay="0">
          <i class="bx bxs-shield"></i>
          <div>
            <h4>Aman & Terjamin</h4>
            <p>Partner resmi, pemandu lokal berpengalaman, dan dukungan 24/7.</p>
          </div>
        </div>
        <div class="feature" data-aos="fade-up" data-aos-delay="80">
          <i class="bx bxs-happy-beaming"></i>
          <div>
            <h4>Pengalaman Berkesan</h4>
            <p>Rangkaian aktivitas curated yang bikin liburan kamu tak terlupakan.</p>
          </div>
        </div>
        <div class="feature" data-aos="fade-up" data-aos-delay="160">
          <i class="bx bxs-purchase-tag-alt"></i>
          <div>
            <h4>Harga Transparan</h4>
            <p>Tidak ada biaya tersembunyi. Sesuaikan paket sesuai anggaranmu.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ==================== POPULAR DESTINATIONS (reveal on scroll) ==================== --}}
  <section class="section" id="popular">
    <div class="container">
      <h2 class="section__title" style="text-align:center; font-weight:900; color:#1f2a44; margin-bottom:6px;" data-aos="fade-up">
        Rekomendasi Untuk Anda
      </h2>
      <p class="muted" style="text-align:center; margin-bottom:22px;" data-aos="fade-up" data-aos-delay="80">
        Pilihan favorit wisatawan—langsung dari yang paling banyak dicari.
      </p>

      <div class="grid popular">
        @foreach ($travel_packages as $package)
          @php
            $cover = optional($package->galleries->first())->images;
            $src   = $cover ? Storage::url($cover) : asset('frontend/assets/img/hero.jpg');
          @endphp
          <article class="card" data-aos="fade-up">
            <a href="{{ route('travel_package.show', $package->slug) }}" class="stretched-link" aria-label="Buka {{ $package->name ?? 'Paket' }}"></a>
            <img class="thumb lazy" data-src="{{ $src }}" alt="{{ $package->name ?? 'Foto' }}">
            <div class="body">
              <div class="title">{{ $package->name ?? $package->location ?? '-' }}</div>
              <div class="muted">{{ $package->type }}</div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

@endsection

@push('script-alt')
  {{-- Swiper + AOS --}}
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    // ===== Swiper Hero
    const heroSwiper = new Swiper('.hero-swiper', {
      loop: true,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: { delay: 3500, disableOnInteraction: false },
      pagination: { el: '.swiper-pagination', clickable: true },
      navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
    });

    // ===== AOS (reveal on scroll)
    AOS.init({
      once: true,
      duration: 650,
      easing: 'ease-out-cubic',
      offset: 80
    });

    // ===== Lazy-load untuk gambar (di hero & kartu)
    const lazyImgs = document.querySelectorAll('img.lazy');
    const io = 'IntersectionObserver' in window
      ? new IntersectionObserver((entries, obs) => {
          entries.forEach(e => {
            if (e.isIntersecting) {
              const img = e.target;
              const src = img.getAttribute('data-src');
              if (src) { img.src = src; img.removeAttribute('data-src'); }
              img.classList.remove('lazy');
              obs.unobserve(img);
            }
          });
        }, { rootMargin: '200px 0px' })
      : null;

    lazyImgs.forEach(img => {
      if (io) io.observe(img); else img.src = img.getAttribute('data-src');
    });

    // ===== Navbar putih ketika discroll (opsional)
    document.addEventListener('scroll', () => {
      const nav = document.querySelector('.navbar');
      if (!nav) return;
      if (window.scrollY > 8) nav.classList.add('navbar-scrolled');
      else nav.classList.remove('navbar-scrolled');
    });
  </script>
@endpush
