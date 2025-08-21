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
                <h1 class="caption-title">{{ $travel_package->name ?? 'Lokasi' }}</h1>
              </div>
            @endif
          </div>
        @empty
          @foreach ([
            'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1493558103817-58b2924bce98?q=80&w=1200&auto=format&fit=crop'
          ] as $dummy)
            <div class="swiper-slide hero-slide">
              <img src="{{ $dummy }}" alt="Foto wisata">
              <div class="hero-overlay"></div>
              <div class="hero-caption container">
                <span class="caption-sub">Explore</span>
                <h1 class="caption-title">{{ optional($travel_package->locations)->name ?? 'Lokasi' }}</h1>
              </div>
            </div>
          @endforeach
        @endforelse
      </div>
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
          <h3 class="card-title mb-2">Informasi Wisata: {{ $travel_package->name }}</h3>
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
            <strong>Rp {{ convertToIDR($travel_package->price, false) }}</strong>
          </div>
        </article>

        @php
          $lat = $travel_package->lat ?? $travel_package->latitude ?? -3.9917;
          $lng = $travel_package->lng ?? $travel_package->longitude ?? 122.5120;
          $locName = optional($travel_package->locations)->name ?? 'Lokasi';
        @endphp

        <!-- Kanan: Peta -->
        <aside class="card map-card">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="card-title m-0">Lokasi</h3>
            <a target="_blank"
               href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
               class="small-link">Buka di Google Maps →</a>
          </div>
          <div id="miniMap"></div>
          @if(!empty($travel_package->address))
            <div class="addr mt-2"><i class='bx bx-map-pin'></i> {{ $travel_package->address }}</div>
          @endif
        </aside>
      </div>

      <!-- CTA menempel -->
      <div class="sticky-cta">
        <button id="btnPesan" class="btn-primary-big">
          <i class="bx bx-calendar-check"></i> Pesan Sekarang
        </button>
      </div>

      <!-- ============ PANEL BOOKING ============ -->
      <div id="bookingPanel" class="booking-panel card">
        <div class="card-body">
          <div class="panel-head">
            <h3 class="card-title m-0">Form Pemesanan</h3>
            <button id="closePanel" class="icon-btn" aria-label="Tutup"><i class='bx bx-x'></i></button>
          </div>

          <form id="bookingForm" action="{{ route('booking.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid-form">
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
              <!-- Ubah ke button JS: buka modal pembayaran -->
              <button type="button" id="btnPayment" class="btn btn-primary">
                <i class="bx bx-send"></i> Lanjutkan Pemesanan
              </button>
              <button type="button" id="cancelPanel" class="btn btn-cancel">
                <i class="bx bx-x-circle"></i> Batal
              </button>
            </div>
          </form>
        </div>

        @php
          // Nomor WhatsApp pengelola
          $waRaw   = $travel_package->users->phone ?? '';
          $waClean = preg_replace('/\D/', '', trim($waRaw));
          if (strpos($waClean, '0') === 0) $waClean = '62' . substr($waClean, 1);
          $wa      = $waClean;
          $waText  = urlencode('Halo, saya ingin memesan paket: ' . ($travel_package->name ?? ''));
        @endphp

        <div class="card-footer d-flex justify-content-between align-items-center">
          <div class="small text-muted">Butuh bantuan cepat? Hubungi pengelola wisata via WhatsApp.</div>
          <a class="btn btn-success" target="_blank" href="https://wa.me/{{ $wa }}?text={{ $waText }}">
            <i class="bx bxl-whatsapp mr-1"></i> WhatsApp Pengelola Wisata
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
                <h2 class="popular__price">{{ $tp->name ?? '-' }}</h2>
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
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

  <style>
    /* ===== Hero Swiper ===== */
    .hero-swiper { width:100%; height: 56vh; position:relative; }
    .hero-slide { position:relative; width:100%; height:100%; }
    .hero-slide img{ width:100%; height:100%; object-fit:cover; display:block; }
    .hero-overlay{ position:absolute; inset:0; background:linear-gradient(180deg,rgba(0,0,0,.25),rgba(0,0,0,.35)); }
    .hero-caption{ position:absolute; bottom:3rem; left:0; right:0; color:#fff; text-align:center; }
    .caption-sub{ font-weight:600; letter-spacing:.08em; opacity:.9; }
    .caption-title{ font-size:2.2rem; font-weight:800; margin:.25rem 0 0; }

    .thumb-swiper{ margin-top:.75rem; }
    .thumb-item{ height:72px; border-radius:.5rem; overflow:hidden; opacity:.75; }
    .thumb-item img{ width:100%; height:100%; object-fit:cover; }
    .thumb-item.swiper-slide-thumb-active{ opacity:1; box-shadow:0 0 0 2px #3366FF inset; }

    /* ===== Grid detail ===== */
    .grid-2{ display:grid; grid-template-columns: 2fr 1.1fr; gap: 1.25rem; }
    .card{ background:#fff; border-radius:1rem; border:1px solid #eef2f9; box-shadow:0 10px 28px rgba(51,102,255,.06); }
    .card-title{ font-weight:800; color:#22346c; }
    .richtext p{ margin-bottom:.6rem; color:#4b5569; }
    .price-pill{ background:#f6faff; border:1px solid #dde7ff; padding:.6rem .9rem; border-radius:.6rem; display:inline-flex; gap:.5rem; align-items:center; }

    .map-card #miniMap{ width:100%; height:280px; border-radius:.75rem; overflow:hidden; }
    .map-card .addr{ color:#6c7493; font-size:.95rem; }

    /* ===== CTA & Booking Panel ===== */
    .sticky-cta{ display:flex; justify-content:center; margin:1.25rem 0 0; }
    .btn-primary-big{
      background: linear-gradient(135deg, #3366FF, #254ecf);
      color:#fff; border:none; border-radius:.9rem;
      padding:1rem 2rem; font-weight:700; font-size:1.05rem;
      display:inline-flex; align-items:center; gap:.5rem;
      box-shadow:0 8px 18px rgba(51,102,255,.25);
      transition: all .25s ease;
    }
    .btn-primary-big:hover{ background: linear-gradient(135deg,#254ecf,#1f3bb3); transform: translateY(-2px); box-shadow:0 12px 22px rgba(37,78,207,.35); }

    .booking-panel{
      margin-top:1rem; overflow:hidden; transform-origin: top center;
      max-height:0; opacity:0; transform:translateY(-8px);
      transition:max-height .5s cubic-bezier(.2,.7,.2,1), opacity .35s, transform .35s, box-shadow .35s;
    }
    .booking-panel.open{ max-height: 900px; opacity:1; transform:translateY(0); }
    .panel-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem; }
    .icon-btn{ background:#f6f7fb; border:1px solid #e9eef8; border-radius:.6rem; width:36px; height:36px; display:grid; place-items:center; }

    .grid-form{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 1rem; }
    .grid-form .form-group{ display:flex; flex-direction:column; }
    .form-actions{ grid-column: 1 / -1; display:flex; gap:.75rem; justify-content:flex-end; }

    .btn{ border-radius:.7rem; }
    .btn-primary{
      background:#3366FF; border:none; color:#fff; font-weight:600;
      padding:.75rem 1.4rem; display:inline-flex; align-items:center; gap:.4rem;
      box-shadow:0 4px 12px rgba(51,102,255,.25); transition: all .25s ease;
    }
    .btn-primary:hover{ background:#254ecf; transform: translateY(-2px); }

    .btn-cancel{
      background:#fff; border:2px solid #e5e8f0; color:#6b7280; font-weight:600;
      padding:.75rem 1.4rem; display:inline-flex; align-items:center; gap:.4rem;
      transition: all .25s ease;
    }
    .btn-cancel:hover{ background:#f9fafc; border-color:#d1d5db; color:#374151; }

    /* ===== Alert ===== */
    .alert { position: fixed; top: 88px; left:0; right:0; margin:auto;
      width:min(720px,92%); background:#3366FF; color:#fff;
      padding:.9rem 2.2rem .9rem 1rem; border-radius:.7rem; z-index:9999;
      box-shadow:0 12px 24px rgba(51,102,255,.25); }
    .alert a{ color:#fff; text-decoration:underline; }
    .alert-close{ position:absolute; right:.6rem; top:.4rem; font-size:1.4rem; cursor:pointer; }

    /* ===== Modal Pembayaran ===== */
    .modal-overlay{
      position:fixed; inset:0; background:rgba(0,0,0,.55);
      display:none; align-items:center; justify-content:center; z-index:9999;
    }
    .modal-box{
      background:#fff; border-radius:1rem; padding:1.25rem 1.25rem 1rem;
      width:min(560px,92%); box-shadow:0 10px 28px rgba(0,0,0,.25);
      animation:fadeUp .25s ease;
    }
    @keyframes fadeUp{from{opacity:0; transform:translateY(16px)} to{opacity:1; transform:translateY(0)}}
    .modal-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:.75rem; }
    .modal-body label{ display:block; margin:.5rem 0; cursor:pointer; }
    .modal-body .desc{ color:#64748b; font-size:.95rem; margin-bottom:.5rem; }
    .highlight{ background:#f6faff; padding:.75rem; border:1px solid #dde7ff; border-radius:.6rem; font-weight:600; }
    .modal-footer{ display:flex; justify-content:flex-end; gap:.6rem; margin-top:1rem; }
    .copy-btn{ background:#f3f6ff; border:1px solid #dfe7ff; border-radius:.5rem; padding:.4rem .6rem; font-size:.85rem; }

    /* ===== Responsive ===== */
    @media (max-width: 992px){
      .grid-2{ grid-template-columns: 1fr; }
      .hero-swiper{ height: 42vh; }
      .grid-form{ grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 576px){
      .grid-form{ grid-template-columns: 1fr; }
      .caption-title{ font-size:1.6rem; }
      .sticky-cta{ position: sticky; top: 72px; z-index: 50; }
    }

    /* jarak tombol salin */
  .copy-row{ margin-top:.5rem; }

  /* uploader custom */
  .upload-wrap{
    margin-top:1rem; display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;
  }
  .file-input{ display:none; } /* sembunyikan input asli */

  .file-label{
    display:inline-flex; align-items:center; gap:.5rem;
    background:#f3f6ff; color:#22346c;
    border:1px solid #dfe7ff; border-radius:.6rem;
    padding:.65rem 1rem; font-weight:600; cursor:pointer;
    transition:all .2s ease;
    box-shadow:0 2px 8px rgba(51,102,255,.08);
  }
  .file-label:hover{ background:#e9efff; border-color:#cfe0ff; transform:translateY(-1px); }

  .file-name{
    color:#64748b; font-size:.95rem; padding:.4rem .6rem;
    background:#fafbff; border:1px dashed #e3e9fb; border-radius:.5rem;
  }

  .hint{ display:block; width:100%; color:#94a3b8; margin-top:.25rem; }
  </style>
@endpush


@push('script-alt')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <!-- ====== Modal Pembayaran (HTML di bawah ini supaya di luar panel) ====== -->
  <div id="paymentModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="payTitle">
      <div class="modal-head">
        <h3 id="payTitle" class="card-title m-0">Pilih Metode Pembayaran</h3>
        <button id="closePayment" class="icon-btn" aria-label="Tutup modal"><i class='bx bx-x'></i></button>
      </div>

      <div class="modal-body">
        <div class="desc">Pilih salah satu metode berikut lalu unggah bukti pembayaran.</div>

        <label><input type="radio" name="metode-bayar" value="bank"> Transfer Bank</label>
        <label><input type="radio" name="metode-bayar" value="ewallet"> E-Wallet</label>

        <div id="paymentDetail" class="mt-3" style="display:none;">
          <p class="highlight" id="rekeningInfo">—</p>
        
          <!-- spasi kecil + tombol salin -->
          <div class="copy-row">
            <button type="button" id="copyNumber" class="copy-btn">
              <i class="bx bx-copy-alt"></i> Salin nomor
            </button>
          </div>
        
          <!-- uploader custom -->
          <div class="upload-wrap">
            <input type="file" id="buktiBayar" name="file" class="file-input" accept="image/*" form="bookingForm" required>

            <label for="buktiBayar" class="file-label">
              <i class="bx bx-upload"></i>
              <span>Pilih Bukti (JPG/PNG)</span>
            </label>
            <span class="file-name" id="fileName">Belum ada file</span>
            <small class="hint">Maks. 5MB</small>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" id="submitPayment" class="btn btn-primary" form="bookingForm" disabled>
          <i class="bx bx-upload"></i> Kirim Bukti
        </button>
      </div>
    </div>
  </div>

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
          slidesPerView: 6, spaceBetween: 10, watchSlidesProgress: true,
          breakpoints: { 0:{slidesPerView:4}, 768:{slidesPerView:6} }
        });
      }
    }

    if (hasSwiper && topEl) {
      const heroOpts = {
        effect: 'fade', fadeEffect: { crossFade: true }, loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      };
      if (thumbsInstance) heroOpts.thumbs = { swiper: thumbsInstance };
      new Swiper('.gallery-top', heroOpts);
    }

    /* ==================== LEAFLET MINI MAP ==================== */
    const mapEl = document.getElementById('miniMap');
    if (mapEl && window.L) {
      let lat = @json((float)($lat ?? -3.9917));
      let lng = @json((float)($lng ?? 122.5120));
      const locName = @json($locName);
      if (!isFinite(lat)) lat = -3.9917;
      if (!isFinite(lng)) lng = 122.5120;

      const map = L.map('miniMap', { scrollWheelZoom: false }).setView([lat, lng], 12);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap'
      }).addTo(map);
      L.marker([lat, lng]).addTo(map).bindPopup(locName).openPopup();
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

    /* ==================== PAYMENT MODAL ==================== */
    const btnPayment   = document.getElementById('btnPayment');
    const modal        = document.getElementById('paymentModal');
    const closePayment = document.getElementById('closePayment');
    const metodeRadios = document.querySelectorAll('input[name="metode-bayar"]');
    const paymentDetail= document.getElementById('paymentDetail');
    const rekeningInfo = document.getElementById('rekeningInfo');
    const copyBtn      = document.getElementById('copyNumber');
    const buktiBayar   = document.getElementById('buktiBayar');
    const fileNameEl   = document.getElementById('fileName');
    const submitPay    = document.getElementById('submitPayment');

    // Data nomor (edit sesuai real)
    const BANK_INFO   = "BCA • 123-456-789 a.n. Wisata Indah";
    const EWALLET_INFO= "DANA/OVO • 0812-3456-7890 a.n. Wisata Indah";

    function openModal(){ modal.style.display = 'flex'; modal.setAttribute('aria-hidden','false'); }
    function closeModal(){
      modal.style.display = 'none'; modal.setAttribute('aria-hidden','true');
      metodeRadios.forEach(r => r.checked = false);
      paymentDetail.style.display = 'none';
      rekeningInfo.textContent = '—';
      buktiBayar.value = '';
      submitPay.disabled = true;
    }

    btnPayment?.addEventListener('click', openModal);
    closePayment?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e)=>{ if(e.target === modal) closeModal(); });

    metodeRadios.forEach(r => {
      r.addEventListener('change', () => {
        paymentDetail.style.display = 'block';
        rekeningInfo.textContent = (r.value === 'bank') ? BANK_INFO : EWALLET_INFO;
      });
    });

    copyBtn?.addEventListener('click', () => {
      const raw = rekeningInfo.textContent || '';
      const number = (raw.match(/\d[\d\-]*/g) || [''])[0].replace(/\D/g,''); // ambil angka saja
      if (!number) return;
      navigator.clipboard.writeText(number).then(()=>{
        copyBtn.textContent = 'Tersalin!';
        setTimeout(()=> copyBtn.textContent = 'Salin nomor', 1500);
      });
    });

    buktiBayar?.addEventListener('change', () => {
      const file = buktiBayar.files?.[0];
      fileNameEl.textContent = file ? file.name : 'Belum ada file';
      submitPay.disabled = !file;
    })

    const formEl = document.getElementById('bookingForm');
    submitPay?.addEventListener('click', (e) => {
      // karena button sudah type="submit" + form="bookingForm", event ini akan submit.
      // kita hanya cegah submit kalau data belum lengkap.
      if (!paymentMethodHidden.value || !buktiBayar.files?.length) {
        e.preventDefault();
        const warn = document.createElement('div');
        warn.className = 'alert';
        warn.innerHTML = 'Pilih metode & unggah bukti pembayaran terlebih dahulu.<i class="bx bx-x alert-close" style="position:absolute; right:.6rem; top:.4rem; cursor:pointer;"></i>';
        document.body.appendChild(warn);
        warn.querySelector('.alert-close')?.addEventListener('click', ()=> warn.remove());
        setTimeout(()=> warn.remove(), 5000);
      }
      // jika lengkap → biarkan submit normal (TIDAK closeModal & TIDAK showNotice di sini)
    });

    /* ===== Notifikasi dinamis (re-usable) ===== */
    function showNotice(html){
      const alertBox = document.createElement('div');
      alertBox.className = 'alert';
      alertBox.innerHTML = `${html}<i class='bx bx-x alert-close' style="position:absolute; right:.6rem; top:.4rem; font-size:1.4rem; cursor:pointer;"></i>`;
      document.body.appendChild(alertBox);
      alertBox.querySelector('.alert-close')?.addEventListener('click', ()=> alertBox.remove());
      setTimeout(()=> alertBox.remove(), 1000 * 12); // auto hide 12s
    }

    // Close alert bawaan jika ada
    document.getElementById('close')?.addEventListener('click', () => {
      document.getElementById('alert')?.remove();
    });
  });
  </script>
@endpush
