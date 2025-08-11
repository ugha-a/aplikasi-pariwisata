@extends('layouts.frontend')

@section('content')
  <!-- ============ HERO SLIDER ============ -->
  <section class="section pb-0">
    <div class="swiper gallery-top hero-swiper">
        <div class="swiper-wrapper">
            @forelse($travel_package->galleries as $g)
              <div class="swiper-slide hero-slide">
                <img src="{{ Storage::url($g->images) }}" alt="{{ $g->name ?? 'Foto wisata' }}">
                <div class="hero-overlay"></div>
                @if($g->name)
                  <div class="hero-caption container">
                    <span class="caption-sub">Explore</span>
                    <h1 class="caption-title">{{ $g->name }}</h1>
                  </div>
                @endif
              </div>
            @empty
              {{-- Jika tidak ada foto, tampilkan beberapa dummy image --}}
              @foreach (['https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200&auto=format&fit=crop', 'https://images.unsplash.com/photo-1493558103817-58b2924bce98?q=80&w=1200&auto=format&fit=crop'] as $dummy)
                <div class="swiper-slide hero-slide">
                  <img src="{{ $dummy }}" alt="Foto wisata">
                  <div class="hero-overlay"></div>
                  <div class="hero-caption container">
                    <span class="caption-sub">Explore</span>
                    <h1 class="caption-title">{{ $travel_package->location }}</h1>
                  </div>
                </div>
              @endforeach
            @endforelse
          </div>
      <!-- nav -->
      {{-- <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-pagination"></div> --}}
    </div>

    @if($travel_package->galleries->count() > 1)
      <div class="swiper gallery-thumbs thumb-swiper container">
        <div class="swiper-wrapper">
          @foreach ($travel_package->galleries as $g)
            <div class="swiper-slide thumb-item">
              <img src="{{ Storage::url($g->images) }}" alt="thumb">
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </section>

  <!-- ============ INFO & MAP ============ -->
  <section class="section pt-4" id="detail">
    <div class="container">
      <div class="grid-2">
        <!-- Kiri: Deskripsi -->
        <article class="card info-card">
          <h3 class="card-title mb-2">Informasi Wisata: {{ $travel_package->location }}</h3>
          <div class="muted mb-3">Kategori: <b>{{ $travel_package->type }}</b></div>

          <div class="richtext">
            {!! $travel_package->description !!}
          </div>

          @if($travel_package->facilities)
            <hr class="my-3">
            <h4 class="mt-2">Fasilitas</h4>
            <div class="richtext">
              {!! $travel_package->facilities !!}
            </div>
          @endif

          <div class="price-pill mt-3">
            <span>Harga tiket:</span>
            <strong>Rp {{ convertToIDR($travel_package->price) }}</strong>
          </div>
        </article>

        <!-- Kanan: Peta -->
        <aside class="card map-card">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="card-title m-0">Lokasi</h3>
            <a target="_blank"
               href="https://www.google.com/maps/search/?api=1&query={{ ($travel_package->lat ?? $travel_package->latitude ?? -3.9917) }},{{ ($travel_package->lag ?? $travel_package->lng ?? $travel_package->longitude ?? 122.5120) }}"
               class="small-link">Buka di Google Maps →</a>
          </div>
          <div id="miniMap"></div>
          @if(!empty($travel_package->address))
            <div class="addr mt-2"><i class='bx bx-map-pin'></i> {{ $travel_package->address }}</div>
          @endif
        </aside>
      </div>

      <!-- CTA -->
      <div class="sticky-cta">
        <button id="btnPesan" class="btn btn-primary-big">
          <i class="bx bx-calendar-check mr-1"></i> Pesan sekarang
        </button>
      </div>

      <!-- ============ PANEL BOOKING (hidden dulu) ============ -->
      <div id="bookingPanel" class="booking-panel card">
        <div class="card-body">
          <div class="panel-head">
            <h3 class="card-title m-0">Form Pemesanan</h3>
            <button id="closePanel" class="icon-btn" aria-label="Tutup"><i class='bx bx-x'></i></button>
          </div>

          <form action="{{ route('booking.store') }}" method="POST" class="grid-form">
            @csrf
            <input type="hidden" name="travel_package_id" value="{{ $travel_package->id }}">

            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="name" class="form-control" placeholder="Nama anda" required>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email anda" required>
            </div>

            <div class="form-group">
              <label>Nomor HP</label>
              <input type="tel" name="number_phone" class="form-control" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="form-group">
              <label>Tanggal Kunjungan</label>
              <input type="date" name="date" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Waktu Check-in</label>
              <input type="time" name="check_in" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Waktu Check-out</label>
              <input type="time" name="check_out" class="form-control" required>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-send mr-1"></i> Kirim Pemesanan
              </button>
              <button type="button" id="cancelPanel" class="btn btn-light">Batal</button>
            </div>
          </form>
        </div>

        <!-- Footer card: tombol WA dinas -->
        @php
          $wa = $dinasPhone ?? '6282281813799'; // ganti ke nomor dinas kamu (format internasional, tanpa +)
          $waText = urlencode('Halo, saya ingin memesan paket: '.$travel_package->location);
        @endphp
        <div class="card-footer d-flex justify-content-between align-items-center">
          <div class="small text-muted">Butuh bantuan cepat? Hubungi dinas via WhatsApp.</div>
          <a class="btn btn-success" target="_blank" href="https://wa.me/{{ $wa }}?text={{ $waText }}">
            <i class="bx bxl-whatsapp mr-1"></i> WhatsApp Dinas
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ REKOMENDASI ============ -->
  <section class="section" id="popular">
    <div class="container">
      <span class="section__subtitle" style="text-align:center">Paket Lainnya</span>
      <h2 class="section__title" style="text-align:center">Rekomendasi untuk Anda</h2>

      <div class="popular__all">
        @foreach ($travel_packages as $tp)
          <article class="popular__card">
            <a href="{{ route('travel_package.show', $tp->slug) }}">
              @if ($tp->galleries->isNotEmpty())
                <img src="{{ Storage::url($tp->galleries->first()->images) }}" class="popular__img" alt="Foto">
              @endif
              <div class="popular__data">
                <h2 class="popular__price">
                  <span>Rp</span>{{ convertToIDR($tp->price) }}
                </h2>
                <h3 class="popular__title">{{ $tp->location }}</h3>
                <p class="popular__description">{{ $tp->type }}</p>
              </div>
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  @if (session()->has('message'))
    <div id="alert" class="alert">
      {{ session('message') }}
      <i class='bx bx-x alert-close' id="close"></i>
    </div>
  @endif
@endsection

@push('style-alt')
  {{-- Leaflet CSS --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

  <style>
    /* Hero Swiper */
    .hero-swiper { width:100%; height: 56vh; position:relative; }
    .hero-slide { position:relative; width:100%; height:100%; }
    .hero-slide img{ width:100%; height:100%; object-fit:cover; display:block; }
    .hero-overlay{ position:absolute; inset:0; background:linear-gradient(180deg,rgba(0,0,0,.25),rgba(0,0,0,.35)); }
    .hero-caption{ position:absolute; bottom:3rem; left:0; right:0; color:#fff; }
    .caption-sub{ font-weight:600; letter-spacing:.08em; opacity:.9; }
    .caption-title{ font-size:2.2rem; font-weight:800; margin:.25rem 0 0; }

    .thumb-swiper{ margin-top:.75rem; }
    .thumb-item{ height:72px; border-radius:.5rem; overflow:hidden; opacity:.75; }
    .thumb-item img{ width:100%; height:100%; object-fit:cover; }
    .thumb-item.swiper-slide-thumb-active{ opacity:1; box-shadow:0 0 0 2px #3366FF inset; }

    /* Grid detail */
    .grid-2{
      display:grid; grid-template-columns: 2fr 1.1fr; gap: 1.25rem;
    }
    .card{ background:#fff; border-radius:1rem; border:1px solid #eef2f9; box-shadow:0 10px 28px rgba(51,102,255,.06); }
    .card-title{ font-weight:800; color:#22346c; }
    .richtext p{ margin-bottom:.6rem; color:#4b5569; }
    .price-pill{ background:#f6faff; border:1px solid #dde7ff; padding:.6rem .9rem; border-radius:.6rem; display:inline-flex; gap:.5rem; align-items:center; }

    .map-card #miniMap{ width:100%; height:280px; border-radius:.75rem; overflow:hidden; }
    .map-card .addr{ color:#6c7493; font-size:.95rem; }

    /* CTA + Panel Booking */
    .sticky-cta{ display:flex; justify-content:center; margin:1.25rem 0 0; }
    .btn-primary-big{
      background:#3366FF; color:#fff; border:none; border-radius:.7rem; padding:.9rem 1.4rem; font-weight:700;
      box-shadow:0 10px 18px rgba(51,102,255,.18);
    }
    .btn-primary-big:hover{ background:#254ecf; }

    .booking-panel{
      margin-top:1rem; overflow:hidden; transform-origin: top center;
      max-height:0; opacity:0; transform:translateY(-8px); transition:max-height .5s cubic-bezier(.2,.7,.2,1), opacity .35s, transform .35s;
    }
    .booking-panel.open{ max-height: 900px; opacity:1; transform:translateY(0); }
    .panel-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem; }
    .icon-btn{ background:#f6f7fb; border:1px solid #e9eef8; border-radius:.6rem; width:36px; height:36px; display:grid; place-items:center; }
    .grid-form{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 1rem; }
    .grid-form .form-group{ display:flex; flex-direction:column; }
    .form-actions{ grid-column: 1 / -1; display:flex; gap:.5rem; }

    .btn{ border-radius:.6rem; }
    .btn-light{ background:#f8faff; border:1px solid #e7ecf5; }

    /* Alert */
    .alert { position: fixed; top: 88px; left:0; right:0; margin:auto; width:min(720px,92%); background:#3366FF; color:#fff;
      padding:.9rem 2.2rem .9rem 1rem; border-radius:.7rem; z-index:9999; box-shadow:0 12px 24px rgba(51,102,255,.25); }
    .alert-close{ position:absolute; right:.6rem; top:.4rem; font-size:1.4rem; cursor:pointer; }

    @media (max-width: 992px){
      .grid-2{ grid-template-columns: 1fr; }
      .hero-swiper{ height: 42vh; }
      .grid-form{ grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 576px){
      .grid-form{ grid-template-columns: 1fr; }
      .caption-title{ font-size:1.6rem; }
    }
  </style>
@endpush

@push('script-alt')
  {{-- Leaflet JS --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    /* ==================== SWIPER ==================== */
    const topEl    = document.querySelector('.gallery-top');
    const thumbsEl = document.querySelector('.gallery-thumbs');
    const hasSwiper = typeof window.Swiper !== 'undefined';

    let thumbsInstance = null;

    if (hasSwiper && thumbsEl) {
        const thumbSlides = thumbsEl.querySelectorAll('.swiper-slide').length;
        if (thumbSlides > 1) {
        thumbsInstance = new Swiper('.gallery-thumbs', {
            slidesPerView: 6,
            spaceBetween: 10,
            watchSlidesProgress: true,
            breakpoints: {
            0:   { slidesPerView: 4 },
            768: { slidesPerView: 6 }
            }
        });
        }
    }

    if (hasSwiper && topEl) {
        const heroOpts = {
        effect: 'fade',
        fadeEffect: { crossFade: true },
        loop: true,
        autoplay: { delay: 1000, disableOnInteraction: false }, // ganti slide tiap 1 detik
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
        };
        if (thumbsInstance) heroOpts.thumbs = { swiper: thumbsInstance };
        new Swiper('.gallery-top', heroOpts);
    }

    /* ==================== LEAFLET MINI MAP ==================== */
    const mapEl = document.getElementById('miniMap');
    if (mapEl && window.L) {
        const lat = parseFloat(@json($travel_package->lat ?? $travel_package->latitude ?? -3.9917));
        const lng = parseFloat(@json($travel_package->lag ?? $travel_package->lng ?? $travel_package->longitude ?? 122.5120));

        const map = L.map('miniMap', { scrollWheelZoom: false }).setView([lat, lng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup(`{{ $travel_package->location }}`).openPopup();
    }

    /* ==================== BOOKING PANEL TOGGLE ==================== */
    const panel     = document.getElementById('bookingPanel');
    const openBtn   = document.getElementById('btnPesan');
    const closeBtn  = document.getElementById('closePanel');
    const cancelBtn = document.getElementById('cancelPanel');

    const openPanel  = () => panel?.classList.add('open');
    const closePanel = () => panel?.classList.remove('open');

    openBtn?.addEventListener('click',  openPanel);
    closeBtn?.addEventListener('click', closePanel);
    cancelBtn?.addEventListener('click', closePanel);

    // Alert close (jika ada)
    const alertClose = document.getElementById('close');
    const alertBox   = document.getElementById('alert');
    alertClose?.addEventListener('click', () => { if (alertBox) alertBox.style.display = 'none'; });
    });
    </script>
@endpush
