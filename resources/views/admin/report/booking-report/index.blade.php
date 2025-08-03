@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 justify-content-between d-flex">
                    <h1 class="m-0">{{ __('Laporan Kunjungan Wisata') }}</h1>
                    <a class="btn btn-success" href="{{ route('excel.export.pemesanan') }}">
                        Excel
                    </a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
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
                            <div id="chartTopBooking"></div>
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
            var topBooking = @json($topBooking);
        
            var labels = topBooking.map(item => item.nama_paket);
            console.log(topBooking);
            
            var data = topBooking.map(item => item.total);
        
            var options = {
                chart: {
                    type: 'pie',
                    height: 500
                },
                labels: labels,
                series: data,
                title: {
                    text: "5 Paket Wisata Paling Banyak Dibooking",
                    align: 'left',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val, opts) {
                            var index = opts.seriesIndex;
                            return val + " kali dibooking";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 300 },
                        legend: { position: 'bottom' }
                    }
                }]
            };
        
            var chart = new ApexCharts(document.querySelector("#chartTopBooking"), options);
            chart.render();
        });
    </script>
@endsection
@endsection
