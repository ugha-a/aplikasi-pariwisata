@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 justify-content-between d-flex">
                    <h1 class="m-0">{{ __('Laporan Kunjungan User') }}</h1>
                    <a class="btn btn-success" href="{{ route('excel.export.kunjungan') }}">
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
                            <div id="chartKunjungan"></div>
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
            var kunjungan = @json($kunjungan);
        
            var tanggalLabels = kunjungan.map(item => item.tanggal);
            var totalData = kunjungan.map(item => item.total);
        
            var options = {
                title: {
                    text: "Kunjungan 7 Hari Terakhir",
                    align: 'left',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        color: '#263238'
                    }
                },
                chart: {
                    type: 'bar',
                    height: 500
                },
                series: [{
                    name: 'Jumlah Kunjungan',
                    data: totalData
                }],
                xaxis: {
                    categories: tanggalLabels
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '50%'
                    }
                },
                dataLabels: {
                    enabled: true
                }
            };
        
            var chart = new ApexCharts(document.querySelector("#chartKunjungan"), options);
            chart.render();
        });
    </script>
@endsection
@endsection
