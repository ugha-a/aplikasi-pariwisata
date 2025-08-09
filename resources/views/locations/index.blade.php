@extends('layouts.frontend')

@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">

<style>
  :root{
    --brand:#3366FF;
    --accent:#FF8000;
    --ink:#22346c;
    --muted:#6c7493;
  }

  /* Bungkus peta agar spacing konsisten */
  .map-card{
    background:#fff;
    border:1px solid #eef2ff;
    border-radius:1rem;
    box-shadow:0 10px 30px rgba(51,102,255,.08);
    overflow:hidden;
  }

  #map{
    height: 68vh;         /* default */
    min-height: 420px;    /* jaga jangan kependekan */
    width: 100%;
  }
  @media (min-width: 768px){
    #map{ height: 72vh; }
  }
  @media (min-width: 1200px){
    #map{ height: 78vh; }
  }

  /* Styling popup biar elegan */
  .leaflet-popup-content-wrapper{
    border-radius:.75rem;
    border:1px solid #e8eeff;
    box-shadow:0 10px 26px rgba(51,102,255,.12);
  }
  .leaflet-popup-content{
    margin: .85rem .9rem;
    color: var(--ink);
  }
  .popup-title{
    font-weight:800; color:var(--brand); margin:0 0 .1rem; font-size:1.05rem;
  }
  .popup-sub{
    margin:0; color:var(--muted); font-size:.92rem;
  }

  /* Tombol zoom & scale agak lembut */
  .leaflet-control-zoom a{
    color:#1e2a60;
  }
  .leaflet-control{
    border-radius:.6rem !important;
    overflow:hidden;
    border:1px solid #eef2ff !important;
    box-shadow:0 6px 18px rgba(51,102,255,.10) !important;
  }
</style>
@endpush

@section('content')
<section class="section" id="LokasiWisata">
  <div class="container">
    <h2 class="section__title" style="text-align:center">Lokasi Wisata</h2>

    <div class="map-card">
      <div id="map"></div>
    </div>
  </div>
</section>
@endsection

@push('script-alt')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="anonymous"></script>
<script>
  // Pusat awal kira-kira Sultra (nanti akan di-fitBounds)
  const map = L.map('map', {
    zoomControl: true
  }).setView([-3.9917, 122.5120], 7);

  // Tile OSM
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  // Scale (km/miles)
  L.control.scale({imperial:false}).addTo(map);

  // Ambil data dari server
  // NOTE: pastikan model field-nya lat & lng (bukan 'lag')
  const points = @json(
    $locations->map(function($item){
      return [
        (float) $item->lat,
        (float) $item->lng,   // <-- pastikan ini 'lng'
        (string) $item->name,
        (string) ($item->address ?? ''), // opsional jika ada
        (string) ($item->slug ?? '')     // opsional jika ada detail page
      ];
    })
  );

  // Custom icon "brand" (biru)
  const BrandIcon = L.divIcon({
    className: 'custom-marker',
    html: `
      <svg width="26" height="38" viewBox="0 0 26 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13 38s12-14.2 12-23A12 12 0 1 0 1 15c0 8.8 12 23 12 23Z" fill="#3366FF" opacity=".95"/>
        <circle cx="13" cy="15" r="5.5" fill="#fff"/>
        <circle cx="13" cy="15" r="3.5" fill="#FF8000"/>
      </svg>
    `,
    iconSize: [26, 38],
    iconAnchor: [13, 38],
    popupAnchor: [0, -34]
  });

  const markers = [];
  points.forEach(([lat, lng, name, address, slug]) => {
    if (isFinite(lat) && isFinite(lng)) {
      const html = `
        <h3 class="popup-title">${name ?? 'Tanpa Nama'}</h3>
        ${address ? `<p class="popup-sub">${address}</p>` : ''}
        ${slug ? `<a href="/travel-packages/${slug}" style="color:#3366FF;font-weight:600;text-decoration:none">Lihat detail &rarr;</a>` : ''}
      `;
      const m = L.marker([lat, lng], { icon: BrandIcon }).addTo(map).bindPopup(html);
      markers.push(m);
    }
  });

  // Fit bounds ke semua marker (kalau ada)
  if (markers.length){
    const group = L.featureGroup(markers);
    map.fitBounds(group.getBounds(), { padding: [40, 40] });
  } else {
    // fallback zoom default
    map.setView([-3.9917, 122.5120], 7);
  }
</script>
@endpush
