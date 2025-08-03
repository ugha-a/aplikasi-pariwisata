    @extends('layouts.app')

    @section('content')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Dashboard') }}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ __('Selamat Datangs') }} {{ auth()->user()->name }} !
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart1"></div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

    @section('scripts')
        <script>
             document.addEventListener('DOMContentLoaded', () => {
                var wisata = @json($wisata);

                // ✅ Ambil nama wisata dan total pesanan
                var wisataLabels = wisata.map(item => item.travel_package?.nama_paket ?? 'Tidak diketahui');
                var wisataData = wisata.map(item => item.total);

                var options2 = {
                    title: {
                        text: "Wisata Terpopuler",
                        align: 'left',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#263238'
                        },
                    },
                    chart: {
                        type: 'bar',
                        height: '500'
                    },
                    series: [{
                        name: 'Jumlah Pesanan',
                        data: wisataData
                    }],
                    xaxis: {
                        categories: wisataLabels  // ✅ pastikan ini adalah array string
                    }
                };

                var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                chart2.render();
            });
        </script>
    @endsection
    @endsection
