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
                                {{ __('Welcome') }} {{ auth()->user()->name }} !
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart3"></div>
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
            var pemesanan = @json($pemesanan);
            var wisata = @json($wisata);
            
            console.log(kunjungan);
            console.log(pemesanan);
            console.log(wisata);

            var options1 = {
                title: {
                    text: "Kunjungan",
                    align: 'left',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        fontFamily: undefined,
                        color: '#263238'
                    },
                },
                chart: {
                    type: 'bar',
                    height: '500'
                },
                series: [{
                    name: 'sales',
                    data: [kunjungan]
                }],
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
                }
            }

            var options2 = {
                title: {
                    text: "Wisata Terpopuler",
                    align: 'left',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        fontFamily: undefined,
                        color: '#263238'
                    },
                },
                chart: {
                    type: 'bar',
                    height: '500'
                },
                series: [{
                    name: 'sales',
                    data: [wisata]
                }],
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
                }
            }

            var options3 = {
                title: {
                    text: "Pemesanan",
                    align: 'left',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        fontFamily: undefined,
                        color: '#263238'
                    },
                },
                chart: {
                    type: 'bar',
                    height: '500'
                },
                series: [{
                    name: 'sales',
                    data: [pemesanan]
                }],
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
                }
            }

            var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
            var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
            var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);

            chart1.render();
            chart2.render();
            chart3.render();
        })
    </script>
@endsection
@endsection
