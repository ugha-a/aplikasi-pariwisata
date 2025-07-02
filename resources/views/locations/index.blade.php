@extends('layouts.frontend')

@push('style-alt')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        #map {
            height: 1000px;
        }
    </style>
@endpush

@section('content')
    <!--==================== HOME ====================-->
    <section class="blog section" id="LokasiWisata">
        <div class="blog__container container">
            <div class="blog__content">
                <section class="islands swiper-slide">
                    <div id="map"></div>
                </section>
            </div>
        </div>
    </section>
@endsection


@push('script-alt')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const map = L.map('map').setView([-3.9917, 122.5120], 7);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    
        const popups = @json(
            $locations->map(function($item) {
                return [
                    floatval($item->lat), 
                    floatval($item->lag), 
                    $item->name
                ];
            })
        ).map(item => ({
            position: [item[0], item[1]],
            text: item[2]
        }));
    
        console.log(popups);
    
        popups.forEach(popup => {
            const marker = L.marker(popup.position).addTo(map)
                .bindPopup(popup.text)
                .openPopup(); // <-- auto tampilkan popup
        });
    </script>
@endpush
