@extends('layouts.frontend')

@push('style-alt')
  <!-- Libs -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

  <style>
    /* ================== Design Tokens ================== */
    :root{
      --primary:#3366FF;
      --accent:#FF6600;
      --ink:#0f172a;
      --muted:#64748b;
      --ink-weak:#1f2a44;
      --surface:#ffffff;
      --shadow: 0 14px 40px rgba(51,102,255,.10);
      --radius-xl: 18px;
      --radius-lg: 14px;
    }

    /* ============ Aksen Nusantara ============ */
    .u-ornament { position: relative; }
    .u-ornament::before{
      content:""; position:absolute; inset-inline:0; top:-10px; height:10px;
      background:
        repeating-linear-gradient(45deg, var(--primary) 0 12px, transparent 12px 24px),
        repeating-linear-gradient(-45deg, var(--accent) 0 12px, transparent 12px 24px);
      background-size:24px 24px;
      opacity:.35; pointer-events:none;
    }
    .u-line{
      height:4px; background:linear-gradient(90deg,var(--accent),var(--primary));
      border-radius:999px; opacity:.75;
    }

    /* =============== Komponen umum =============== */
    .container{ width:min(1120px,92%); margin-inline:auto; }
    .section{ padding:72px 0; }
    .section__eyebrow{
      display:inline-flex; align-items:center; gap:.5rem;
      font-weight:800; letter-spacing:.4px; text-transform:uppercase;
      color:var(--accent); font-size:.85rem;
    }
    .section__title{
      font-size:clamp(1.6rem,3.8vw,2.25rem);
      font-weight:900; color:var(--ink-weak); margin:.25rem 0 .75rem;
      letter-spacing:.2px;
    }
    .section__lead{ color:var(--muted); max-width:60ch; }

    .button{
      display:inline-flex; align-items:center; gap:.5rem; padding:.9rem 1.25rem;
      border-radius:999px; font-weight:800; text-decoration:none; border:2px solid transparent; cursor:pointer;
      transition:transform .25s, box-shadow .25s, background .25s, color .25s, border-color .25s;
    }
    .button.primary{
      background:linear-gradient(135deg,var(--primary),#254ecf); color:#fff; border-color:transparent;
      box-shadow:0 12px 28px rgba(51,102,255,.28);
    }
    .button.primary:hover{ transform:translateY(-3px); box-shadow:0 18px 38px rgba(51,102,255,.35); }
    .button.ghost{
      background:transparent; color:var(--primary); border-color:var(--primary);
    }
    .button.ghost:hover{ background:var(--primary); color:#fff; }

    /* ================= HERO ================= */
    .hero{
      position:relative;
      height: clamp(560px, 78vh, 880px);
      display:grid;
    }
    .hero .swiper,
    .hero .swiper-wrapper,
    .hero .swiper-slide{ height:100%; }
    .hero .swiper-slide{ position:relative; }
    .hero .bg{
      position:absolute; inset:0; width:100%; height:100%; object-fit:cover;
      filter:saturate(112%) contrast(1.02);
      transform:scale(1.02);
    }
    .hero .overlay{
      position:absolute; inset:0;
      background: linear-gradient(180deg, rgba(0,0,0,.25), rgba(0,0,0,.55));
    }
    .hero .hero-content{
      position:relative; z-index:1; display:grid; place-items:center; text-align:center; padding:0 1.25rem;
      height:100%;
    }
    .hero .badge{
      display:inline-flex; align-items:center; gap:.5rem; color:#fff;
      background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.25);
      padding:.4rem .75rem; border-radius:999px; font-weight:800; margin-bottom:.75rem;
    }
    .hero h1{
      color:#fff; font-size:clamp(2rem,5.5vw,3.6rem); font-weight:1000; letter-spacing:.3px;
      text-shadow:0 10px 28px rgba(0,0,0,.28);
      margin:0 0 .5rem;
    }
    .hero p{ color:#e7eefc; font-size:clamp(1rem,1.25vw,1.25rem); margin:0; opacity:.95; }
    .hero .cta{ margin-top:1.25rem; display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap; }

    /* ================= Feature Strip ================= */
    .features{ display:grid; gap:16px; grid-template-columns:repeat(1,minmax(0,1fr)); }
    @media (min-width:768px){ .features{ grid-template-columns:repeat(3,1fr); } }
    .feature{
      background:var(--surface);
      border:1px solid #eef2ff; border-radius:var(--radius-lg);
      padding:18px; display:flex; gap:14px; align-items:flex-start;
      box-shadow: var(--shadow);
      position:relative; overflow:hidden;
    }
    .feature::after{
      content:""; position:absolute; inset-inline-start:0; inset-block:0; width:6px;
      background:linear-gradient(180deg,var(--accent),var(--primary));
    }
    .feature i{
      --size:40px;
      width:var(--size); height:var(--size); flex:0 0 var(--size);
      display:grid; place-items:center; border-radius:12px;
      border:2px solid var(--primary); color:var(--primary); font-size:22px;
      background:#f6f9ff;
    }
    .feature h4{ margin:2px 0 6px; font-weight:900; color:var(--ink-weak); }
    .feature p{ margin:0; color:var(--muted); font-size:.98rem; }

    /* ================= Popular Cards ================= */
    .card{
      background:var(--surface); border:1px solid #eef2f9; border-radius:var(--radius-xl); overflow:hidden;
      box-shadow: var(--shadow); transition:transform .25s, box-shadow .25s, border-color .25s;
      position:relative; isolation:isolate;
    }
    .card:hover{ transform:translateY(-4px); box-shadow:0 18px 42px rgba(51,102,255,.14); border-color:#dfe7ff; }
    .card .thumb{ aspect-ratio:4/3; width:100%; object-fit:cover; display:block; }
    .card .body{ padding:12px 14px 16px; }
    .card .title{ font-weight:900; color:var(--ink); margin:0 0 4px; font-size:.95rem; }
    .card .muted{ color:var(--muted); font-size:.8rem; }
    .card::before{
      content:""; position:absolute; top:12px; right:12px; width:34px; height:10px; border-radius:999px;
      background:linear-gradient(90deg,var(--accent),var(--primary)); opacity:.9;
    }

    /* ================= Swiper ================= */
    .swiper-button-next,.swiper-button-prev{ color:#fff; opacity:.95; filter:drop-shadow(0 6px 14px rgba(0,0,0,.35)); }
    .swiper-pagination-bullet{ background:#fff; opacity:.6; }
    .swiper-pagination-bullet-active{ background:var(--accent); opacity:1; }

    /* ================= Util ================= */
    .scroll-hint{
      position:absolute; left:0; right:0; bottom:18px; margin:auto; width:max-content; color:#fff; opacity:.9;
      display:flex; align-items:center; gap:.4rem; font-weight:800; text-transform:uppercase; letter-spacing:.3px;
      animation:floaty 2.2s ease-in-out infinite;
    }
    @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(6px)}}

    @media(max-width:640px){
      .section{ padding:56px 0; }
      .hero .badge{ font-size:.9rem; }
    }
    .hero .swiper-pagination,
    .hero .swiper-button-next,
    .hero .swiper-button-prev {
      display: none !important;
    }

    /* ================= Popular Slider ================= */
    #popular.section {
      padding-top: 32px;
      padding-bottom: 24px;  /* spasi normal ke footer */
      margin-bottom: 0;
    }
    #popular .section__title { margin-bottom: .4rem; }
    #popular .section__lead { margin-bottom: 1rem; }

    .popular-wrapper {
      position: relative;
      padding: 0 40px;
      margin-top: 12px;
    }
    .popular-swiper {
      padding-bottom: 0 !important;
    }
    .popular-swiper .swiper-wrapper {
      margin-bottom: 0 !important;
    }
    .popular-swiper .swiper-slide {
      width: 240px !important;
      height: auto !important;
      display: flex;
      justify-content: center;
      align-items: flex-start; /* biar card nempel atas */
    }

    .card.small {
      max-width: 240px;
      border-radius: 16px;
      overflow: hidden;
      background: var(--surface);
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      height: auto !important;   /* <— perbaikan inti */
    }
    .card.small .thumb {
      width: 100%;
      aspect-ratio: 4/3;
      object-fit: cover;
      border-bottom: 1px solid #f1f5f9;
    }

    .popular-prev, .popular-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 44px; height: 44px;
      border-radius: 50%;
      background: #fff;
      box-shadow: 0 6px 16px rgba(0,0,0,.12);
      display: grid; place-items: center;
      cursor: pointer;
      z-index: 10;
      transition: all .25s;
      color: var(--primary);
      font-size: 24px;
      font-weight: 700;
    }
    .popular-prev:hover, .popular-next:hover {
      background: var(--primary); color: #fff;
    }
    .popular-prev { left: 0; }
    .popular-next { right: 0; }

    .card.small { height: auto !important; }
    .popular-swiper .swiper-slide { align-items: flex-start; }

    /* Footer langsung setelah popular */
    footer {
      margin-top: 0 !important;
      padding-top: 20px; /* supaya ada sedikit ruang */
    }
  </style>
@endpush




@section('content')

  {{-- ==================== HERO ==================== --}}
  <section class="hero u-ornament">
    <div class="swiper hero-swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img class="bg" src="{{ asset('frontend/assets/img/hero.jpg') }}" alt="Sulawesi Tenggara">
          <div class="overlay"></div>
          <div class="hero-content">
            <div data-aos="fade-up" data-aos-delay="50">
              <span class="badge"><i class="bx bxs-map-pin"></i> Sulawesi Tenggara</span>
              <h1>Jelajahi Surga Wisata di Timur Indonesia</h1>
              <p>Destinasi cantik, laut sebening kristal, budaya yang hangat.</p>
              <div class="cta">
                <a href="{{ route('travel_package.index') }}" class="button primary">
                  <i class="bx bx-compass"></i> Detail Wisata
                </a>
                <a href="#popular" class="button ghost"><i class="bx bx-chevrons-down"></i> Lihat Rekomendasi</a>
              </div>
            </div>
          </div>
        </div>

        {{-- Slide dinamis dari paket --}}
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
      <div class="scroll-hint"><i class="bx bx-chevrons-down"></i> Gulir</div>
    </div>
  </section>

  {{-- ==================== FEATURE STRIP ==================== --}}
  <section class="section">
    <div class="container">
      <div class="section__eyebrow"><i class="bx bxs-diamond"></i> Keunggulan Kami</div>
      <h2 class="section__title">Layanan Andal untuk Perjalanan Berkesan</h2>
      <div class="u-line" style="margin-bottom:18px;"></div>

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
            <p>Kurasi aktivitas yang autentik—ramah keluarga hingga petualangan.</p>
          </div>
        </div>
        <div class="feature" data-aos="fade-up" data-aos-delay="160">
          <i class="bx bxs-purchase-tag-alt"></i>
          <div>
            <h4>Harga Transparan</h4>
            <p>Tanpa biaya tersembunyi. Pilih paket sesuai anggaranmu.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ==================== POPULAR DESTINATIONS ==================== --}}
  <section class="section" id="popular">
    <div class="container">
      <div class="section__eyebrow"><i class="bx bxs-hot"></i> Rekomendasi</div>
      <h2 class="section__title">Destinasi Favorit Wisatawan</h2>
      <p class="section__lead">Dipilih dari destinasi yang paling banyak dilihat dan diulas baik.</p>
  
      <div class="popular-wrapper">
        <div class="swiper popular-swiper">
          <div class="swiper-wrapper">
            @foreach ($travel_packages->take(9) as $package)
              @php
                $cover = optional($package->galleries->first())->images;
                $src   = $cover ? Storage::url($cover) : asset('frontend/assets/img/hero.jpg');
              @endphp
              <div class="swiper-slide">
                <article class="card small" data-aos="fade-up">
                  <a href="{{ route('travel_package.show', $package->slug) }}" class="stretched-link"></a>
                  <img class="thumb lazy" data-src="{{ $src }}" alt="{{ $package->name ?? 'Foto' }}">
                  <div class="body">
                    <div class="title">{{ $package->name ?? $package->location ?? '-' }}</div>
                    <div class="muted">{{ $package->type }}</div>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        </div>
        <!-- Tombol Navigasi -->
        <div class="popular-prev"><i class="bx bx-chevron-left"></i></div>
        <div class="popular-next"><i class="bx bx-chevron-right"></i></div>
      </div>
    </div>
  </section>
  
@endsection


@push('script-alt')
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
      // ===== Swiper Hero
      const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 3500, disableOnInteraction: false }
        // tidak ada navigation & pagination
        });

      // ===== AOS
      AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic', offset: 90 });

      // ===== Lazy-load gambar
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
          }, { rootMargin: '220px 0px' })
        : null;
      lazyImgs.forEach(img => { if (io) io.observe(img); else img.src = img.getAttribute('data-src'); });

      // ===== Smooth scroll untuk anchor internal
      document.querySelectorAll('a[href^="#"]').forEach(a=>{
        a.addEventListener('click', e=>{
          const id = a.getAttribute('href').slice(1);
          const t = document.getElementById(id);
          if(t){ e.preventDefault(); t.scrollIntoView({behavior:'smooth', block:'start'}); }
        });
      });
    });

    const popularSwiper = new Swiper('.popular-swiper', {
      slidesPerView: 1,
      spaceBetween: 16,
      navigation: {
        nextEl: '.popular-next',
        prevEl: '.popular-prev',
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        992: { slidesPerView: 3 }
      }
    });


  </script>
@endpush
