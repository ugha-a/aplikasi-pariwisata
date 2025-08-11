@extends('layouts.app')

@section('styles')
<style>
  :root{
    --brand:#2f3b7c;
    --terracotta:#c0643b;
    --forest:#2e7d4a;
    --gold:#d4a017;
    --ink:#1f2940;
    --soft:#f6f7fb;
  }

  /* ======= Page Head (hero) ======= */
  .hero{
    position:relative; border-radius:18px; overflow:hidden;
    background: linear-gradient(135deg, rgba(47,59,124,.06), rgba(208,160,23,.08)),
                linear-gradient( to right, #ffffff, #fbfcff );
    border:1px solid #eef1f6;
    box-shadow:0 14px 32px rgba(31,41,64,.06);
  }
  .hero-inner{ padding:22px; }
  .hero h1{ color:var(--ink); font-weight:800; letter-spacing:.2px; margin:0; }
  .hero small{ color:#6b738a; display:block; margin-top:4px; }

  /* Ornamen motif */
  .hero::after{
    content:""; position:absolute; inset:0; pointer-events:none; opacity:.25;
    background-image:
      radial-gradient(circle at 0% 0%, transparent 32px, rgba(192,100,59,.09) 33px, transparent 34px),
      radial-gradient(circle at 8% 10%, transparent 20px, rgba(46,125,74,.08) 21px, transparent 22px),
      linear-gradient(135deg, repeating-linear-gradient(135deg, transparent 0 18px, rgba(47,59,124,.06) 18px 36px));
    background-size: 220px 220px, 180px 180px, auto;
    background-position: right -40px top -10px, right 80px bottom -60px, center;
    mix-blend-mode: multiply;
  }

  /* ======= Cards & KPI ======= */
  .card-neo{
    border:1px solid #eef1f6; border-radius:16px; background:#fff;
    box-shadow:0 10px 26px rgba(31,41,64,.05);
  }
  .kpi{
    display:flex; align-items:center; gap:.9rem;
    padding:18px; border-radius:14px; background:linear-gradient(180deg,#ffffff, #fbfcff);
    border:1px solid #eef1f6;
  }

  .kpi-grid{
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1rem; /* jarak antar kartu */
}

  .kpi .ico{
    width:42px; height:42px; border-radius:12px; display:grid; place-items:center;
    box-shadow:0 8px 18px rgba(0,0,0,.06); flex-shrink:0;
  }
  .ico-blue{background:rgba(47,59,124,.1); color:var(--brand);}
  .ico-green{background:rgba(46,125,74,.1); color:var(--forest);}
  .ico-gold{background:rgba(212,160,23,.12); color:var(--gold);}
  .kpi .label{ color:#6b738a; font-size:.86rem; }
  .kpi .value{ color:var(--ink); font-weight:800; font-size:1.25rem; letter-spacing:.2px; }

  /* ======= Section Titles ======= */
  .section-title{
    font-weight:800; color:var(--ink); margin-bottom:.4rem;
  }
  .section-sub{ color:#6b738a; font-size:.92rem; }

  /* Responsive tweaks */
  @media (max-width: 992px){
    .hero-inner{
      flex-direction:column !important;
      gap:10px;
    }
    .hero small{
      font-size:.85rem;
    }
  }
  @media (max-width: 768px){
    .kpi{
      padding:14px;
      flex-direction: row;
    }
    .kpi .value{
      font-size:1.15rem;
    }
    #chart2{
      min-height: 320px !important;
    }
  }
  @media (max-width: 576px){
    .hero-inner{
      padding:16px;
    }
    .kpi{
      flex-direction:column;
      align-items:flex-start;
      gap:6px;
    }
    .kpi .ico{
      width:38px;
      height:38px;
    }
    .kpi .value{
      font-size:1.05rem;
    }
    #chart2{
      min-height: 260px !important;
    }
  }
</style>
@endsection

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <div class="hero">
            <div class="hero-inner d-flex align-items-start justify-content-between flex-wrap">
              <div>
                <h1 class="m-0">Dashboard</h1>
                <small>Selamat datang, {{ auth()->user()->name }}. Semoga harimu seindah Nusantara 🌿</small>
              </div>
              {{-- <div class="d-flex mt-3 mt-sm-0" style="gap:.75rem;">
                <a href="{{ route('excel.export.pemesanan') }}" class="btn btn-sm" style="background:var(--brand); color:#fff; box-shadow:0 8px 18px rgba(47,59,124,.25);">
                  <i class="fas fa-file-excel mr-1"></i> Export Excel
                </a>
              </div> --}}
            </div>
          </div><!-- /.hero -->
        </div>
      </div>
    </div>
  </div>

  <!-- Main -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Greeting card -->
        <div class="col-lg-12 mb-3">
          <div class="card-neo">
            <div class="card-body">
              <p class="mb-0" style="color:#4b5370;">
                {{ __('Selamat Datang') }} <strong>{{ auth()->user()->name }}</strong>!
              </p>
            </div>
          </div>
        </div>

        <!-- KPI row -->
        @php
          $isAdminOrDinas = in_array(auth()->user()->role, ['admin', 'dinas']);
        @endphp

        <div class="col-12 mb-3">
          <div class="kpi-grid">
            {{-- Kartu yang selalu tampil --}}
            <div class="kpi">
              <div class="ico ico-blue"><i class="fas fa-suitcase-rolling"></i></div>
              <div>
                <div class="label">Total Paket</div>
                <div class="value">{{ $travel_package ?? '-' }}</div>
              </div>
            </div>

            <div class="kpi">
              <div class="ico ico-green"><i class="fas fa-shopping-bag"></i></div>
              <div>
                <div class="label">Total Booking</div>
                <div class="value">{{ $booking ?? '-' }}</div>
              </div>
            </div>

            {{-- Kartu khusus Admin/Dinas --}}
            @if ($isAdminOrDinas)
              <div class="kpi">
                <div class="ico ico-gold"><i class="fas fa-user-tie"></i></div>
                <div>
                  <div class="label">Total Pengelola</div>
                  <div class="value">{{ $totalPengelola ?? '-' }}</div>
                </div>
              </div>
            @endif
          </div>
        </div>
  

        <!-- Chart: Wisata Terpopuler -->
        <div class="col-lg-12 mb-4">
          <div class="card-neo">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div>
                  <div class="section-title">Wisata Terpopuler</div>
                  <div class="section-sub">Berdasarkan jumlah pesanan</div>
                </div>
              </div>
              <div id="chart2" style="min-height: 420px;"></div>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div>
  </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // 🔽 gunakan data dari $topBooking
    const topBooking = @json($topBooking);

    const wisataLabels = (topBooking || []).map(item => item?.nama_paket ?? 'Tidak diketahui');
    const wisataData   = (topBooking || []).map(item => Number(item?.total ?? 0));

    const options2 = {
      chart: {
        type: 'bar',
        height: 420,
        toolbar: { show: false },
        foreColor: '#4b5370'
      },
      series: [{
        name: 'Jumlah Pesanan',
        data: wisataData
      }],
      xaxis: {
        categories: wisataLabels,
        labels: { rotate: -20, trim: true },
        axisBorder: { show:false },
        tickPlacement: 'on'
      },
      yaxis: { labels: { formatter: val => Math.round(val) } },
      plotOptions: { bar: { borderRadius: 8, columnWidth: '48%', dataLabels: { position: 'top' } } },
      dataLabels: {
        enabled: true,
        offsetY: -18,
        style: { fontSize: '11px', fontWeight: '700', colors: ['#4b5370'] },
        formatter: val => (val || 0)
      },
      tooltip: { theme: 'light', y: { formatter: val => `${val} pesanan` } },
      grid: { borderColor: '#eef1f6', strokeDashArray: 4 },
      colors: ['#2f3b7c', '#c0643b', '#2e7d4a', '#d4a017'],
      fill: { opacity: .95 },
      states: {
        hover: { filter: { type: 'lighten', value: 0.05 } },
        active:{ filter: { type: 'darken',  value: 0.05 } }
      },
      legend: { show: false }
    };

    new ApexCharts(document.querySelector("#chart2"), options2).render();
  });
</script>
@endsection

