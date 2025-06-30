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
        //jhdsijf

        const map = L.map('map').setView([-3.9917, 122.5120], 7);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Data popup yang ingin ditampilkan
        const popups = [{
                position: [-5.2583, 122.5897],
                text: 'Pantai Katembe'
            },
            {
                position: [-5.2833, 122.6333],
                text: 'Pantai Mutiara'
            },
            {
                position: [-5.3500, 122.7000],
                text: 'Air Terjun Kandawu Ndawuna'
            },
            {
                position: [-5.5000, 122.7000],
                text: 'Wisata Jembatan Lingkar'
            },
            {
                position: [-5.5125, 122.7050],
                text: 'Pantai La Poili'
            },
            {
                position: [-5.6000, 122.7500],
                text: 'Wisata Kalibiru'
            },
            {
                position: [-5.6500, 122.8000],
                text: 'Gua Laumehe'
            },
            {
                position: [-5.7000, 122.8500],
                text: 'Air Terjun Kalata'
            },
            {
                position: [-5.3299, 122.3647],
                text: 'Gua Koo'
            },
            {
                position: [-5.1500, 122.7500],
                text: 'Hutan Lambusango'
            },
            {
                position: [-5.6000, 122.7000],
                text: 'Bukit Rongi'
            },
            {
                position: [-5.6500, 122.7500],
                text: 'Taman Waburi'
            },
            {
                position: [-5.7000, 122.8000],
                text: 'Air Terjun Bembe'
            },
            {
                position: [-5.7500, 122.8500],
                text: 'Goa Maobu'
            },
            {
                position: [-5.8000, 122.9000],
                text: 'Pantai Bone'
            },

            // Tambahan dari file "link maps.docx"
            {
                position: [-4.110291, 122.621593],
                text: 'Air Terjun Moramo'
            },
            {
                position: [-3.956095, 122.523852],
                text: 'Pulau Bokori'
            },
            {
                position: [-3.508842, 122.161843],
                text: 'Air Panas Wawolesea'
            },
            {
                position: [-4.009354, 122.607211],
                text: 'Air Terjun Nanga-Nanga'
            },
            {
                position: [-3.410106, 122.310685],
                text: 'Pulau Labengki'
            },
            {
                position: [-4.105455, 122.595022],
                text: 'Air Terjun Lamsou'
            },
            {
                position: [-3.810088, 122.484435],
                text: 'Pantai Pudonggala'
            },
            {
                position: [-4.075755, 122.557988],
                text: 'Air Terjun Garuda'
            },
            {
                position: [-3.983908, 122.515782],
                text: 'Tugu Adipura (Kendari)'
            },
            {
                position: [-4.172185, 121.987782],
                text: 'Air Terjun Tamborano'
            }
        ];




        // Loop melalui array popups untuk menambahkan marker dan popup
        popups.forEach(popup => {
            const marker = L.marker(popup.position).addTo(map)
                .bindPopup(popup.text);
        });
    </script>
@endpush
