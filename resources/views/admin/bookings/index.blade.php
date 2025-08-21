@extends('layouts.app')

@section('styles')
<style>
  /* Header card */
  .page-head{
    display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;
  }
  .btn-export{
    background:#3366FF; border-color:#3366FF; color:#fff;
    box-shadow:0 4px 12px rgba(51,102,255,.16);
  }
  .btn-export:hover{ background:#254ecf; border-color:#254ecf; color:#fff; }

  /* Search */
  .search-wrap{ position:relative; min-width:260px; flex:1 1 260px; max-width:420px; }
  .search-wrap input{
    padding-left:2.2rem; border-radius:.6rem; border:1px solid #e7ecf5; background:#f8faff;
  }
  .search-wrap .icon{
    position:absolute; left:.65rem; top:50%; transform:translateY(-50%); opacity:.6;
  }

  /* Table styling */
  .table-wrap{ overflow:auto; }
  table.booking-table thead th{
    border-top:none; border-bottom:1px solid #edf1f7; background:#fbfcff;
    color:#22346c; font-weight:700; letter-spacing:.2px; position:sticky; top:0; z-index:1;
  }
  table.booking-table tbody td{ vertical-align:middle; }
  .table-hover tbody tr:hover{ background:#f7faff; }

  /* Badges */
  .badge-soft{ padding:.4rem .6rem; border-radius:.5rem; font-weight:600; font-size:.8rem; }
  .badge-soft.pending{  background:#fff7e6; color:#b26c00; border:1px solid #ffe1b3; }
  .badge-soft.rejected{ background:#ffecec; color:#b02a37; border:1px solid #ffc9c9; }
  .badge-soft.approved{ background:#eaf1ff; color:#3366FF; border:1px solid #cfe0ff; }

  .text-muted-sm{ color:#6c7493; font-size:.92rem; }
  .actions .btn{ margin-right:.25rem; }

  /* Status cell: badge + meta */
  .status-cell .badge-soft{
    display:inline-block;
    border-radius:.55rem;
    font-weight:700;
    font-size:.82rem;
    padding:.38rem .62rem;
  }
  .status-meta{
    display:flex;
    align-items:center;
    gap:.4rem;
    margin-top:.3rem;
    color:#6c7493;
    font-size:.82rem;
    letter-spacing:.1px;
  }
  .status-meta i{ opacity:.7; }
</style>
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <div class="page-head">
            <h1 class="m-0">{{ __('Booking') }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        {{-- Header di dalam card: Search --}}
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
          <div class="search-wrap position-relative flex-grow-1" style="max-width:420px; min-width:260px;">
            <i class="fas fa-search position-absolute" style="left:.65rem; top:50%; transform:translateY(-50%); opacity:.6;"></i>
            <input id="bookingSearch" type="search" class="form-control"
                   placeholder="Cari nama/email/HP/status/paket…"
                   style="padding-left:2.2rem; border-radius:.6rem; border:1px solid #e7ecf5; background:#f8faff;">
          </div>
        </div>

        {{-- Tabel --}}
        <div class="table-wrap">
          <table class="table table-hover mb-0 booking-table" id="bookingTable">
            <thead>
              <tr>
                <th style="width:64px">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Travel Package</th>
                <th style="width:150px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $booking)
                @php
                  $status = strtolower(trim($booking->status));
                  $statusMap = [
                    'menunggu'=>['pending','Menunggu'],'pending'=>['pending','Menunggu'],
                    'ditolak'=>['rejected','Ditolak'],'rejected'=>['rejected','Ditolak'],
                    'di-setujui'=>['approved','Disetujui'],'disetujui'=>['approved','Disetujui'],
                  ];
                  [$cls,$label] = $statusMap[$status] ?? ['pending', ucfirst($booking->status)];
                @endphp
                <tr>
                  <td>{{ $loop->iteration + ($bookings->currentPage()-1)*$bookings->perPage() }}</td>
                  <td><div class="font-weight-bold text-dark">{{ $booking->name }}</div></td>
                  <td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td>
                  <td>{{ $booking->number_phone }}</td>
                  <td>
                    @php
                      try { echo \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y'); }
                      catch (\Exception $e) { echo e($booking->date); }
                    @endphp
                  </td>
                  <td class="status-cell">
                    <span class="badge-soft {{ $cls }}">
                      {{ $label }}
                    </span>
                    <div class="status-meta">
                      <i class="fas fa-user-shield"></i>
                      <span>oleh: {{ $booking->processedBy->name ?? 'Admin' }}</span>
                    </div>
                  </td>
                  <td>{{ $booking->travel_package->name }}</td>
                  <td class="actions">
                    {{-- Lihat bukti pembayaran (jika ada) --}}
                    @if(!empty($booking->file))
                      <button type="button"
                              class="btn btn-sm btn-outline-secondary btn-proof"
                              title="Lihat bukti pembayaran"
                              data-src="{{ Storage::url($booking->file) }}"
                              data-filename="{{ basename($booking->file) }}"
                              data-who="{{ $booking->name }}">
                        <i class="fas fa-receipt"></i>
                      </button>
                    @endif

                    {{-- Setujui --}}
                    @if (!in_array($status, ['di-setujui','disetujui']))
                      <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Setujui">
                          <i class="fas fa-check-circle"></i>
                        </button>
                      </form>
                    @endif

                    {{-- Hapus --}}
                    <form onclick="return confirm('Yakin hapus data ini?');" class="d-inline-block"
                          action="{{ route('admin.bookings.destroy', [$booking]) }}" method="post">
                      @csrf @method('delete')
                      <button class="btn btn-sm btn-outline-danger" title="Hapus">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted">Belum ada data booking.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer clearfix">
          <div class="d-flex justify-content-end">
            {{ $bookings->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Preview Bukti Pembayaran --}}
  <div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Bukti Pembayaran — <span id="proofWho">-</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body text-center">
          <img id="proofImg" src="" alt="Bukti pembayaran" class="img-fluid" style="max-height:70vh; object-fit:contain;">
          <div id="proofFallback" class="text-muted small d-none mt-2">File tidak dapat dipratinjau.</div>
        </div>

        <div class="modal-footer">
          <a id="proofDownload" class="btn btn-primary" href="#" download>
            <i class="fas fa-download mr-1"></i> Download
          </a>
          {{-- <a id="proofOpen" class="btn btn-outline-secondary" href="#" target="_blank" rel="noopener">
            <i class="fas fa-external-link-alt mr-1"></i> Buka di tab baru
          </a> --}}
          <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    /* ========== Pencarian sederhana di tabel ========== */
    const input = document.getElementById('bookingSearch');
    const rows  = Array.from(document.querySelectorAll('#bookingTable tbody tr'));
    if (input) {
      const norm = s => (s||'').toString().toLowerCase().trim();
      let t; const debounced = (fn, d=120)=> (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), d); };
      input.addEventListener('input', debounced(() => {
        const q = norm(input.value);
        rows.forEach(tr => { tr.style.display = norm(tr.innerText).includes(q) ? '' : 'none'; });
      }));
    }

    /* ========== Modal Preview Bukti ========== */
    const $modal     = $('#proofModal');
    const imgEl      = document.getElementById('proofImg');
    const whoEl      = document.getElementById('proofWho');
    const dlLink     = document.getElementById('proofDownload');
    const openLink   = document.getElementById('proofOpen');
    const fallbackEl = document.getElementById('proofFallback');

    document.querySelectorAll('.btn-proof').forEach(btn => {
      btn.addEventListener('click', () => {
        const src  = btn.getAttribute('data-src');
        const name = btn.getAttribute('data-filename') || 'bukti-pembayaran';
        const who  = btn.getAttribute('data-who') || '-';

        whoEl.textContent = who;
        imgEl.src = src;
        imgEl.alt = `Bukti pembayaran — ${who}`;
        dlLink.href = src;
        dlLink.setAttribute('download', name);
        // openLink.href = src;

        fallbackEl.classList.add('d-none');
        imgEl.onerror = () => {
          imgEl.src = '';
          fallbackEl.classList.remove('d-none');
        };

        $modal.modal('show');
      });
    });
  });
</script>
@endsection
