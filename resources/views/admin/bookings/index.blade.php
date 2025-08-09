@extends('layouts.app')

@section('styles')
<style>
  /* Header card */
  .page-head {
    display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;
  }
  .btn-export {
    background:#3366FF; border-color:#3366FF; color:#fff;
    box-shadow:0 4px 12px rgba(51,102,255,.16);
  }
  .btn-export:hover { background:#254ecf; border-color:#254ecf; color:#fff; }

  /* Table styling */
  .table-wrap { overflow:auto; }
  table.booking-table thead th{
    border-top:none; border-bottom:1px solid #edf1f7; background:#fbfcff;
    color:#22346c; font-weight:700; letter-spacing:.2px; position:sticky; top:0; z-index:1;
  }
  table.booking-table tbody td{ vertical-align:middle; }
  .table-hover tbody tr:hover{ background:#f7faff; }

  /* Badges */
  .badge-soft {
    padding:.4rem .6rem; border-radius:.5rem; font-weight:600; font-size:.8rem;
  }
  .badge-soft.pending   { background:#fff7e6; color:#b26c00; border:1px solid #ffe1b3; }
  .badge-soft.rejected  { background:#ffecec; color:#b02a37; border:1px solid #ffc9c9; }
  .badge-soft.approved  { background:#eaf1ff; color:#3366FF; border:1px solid #cfe0ff; }

  /* Small utilities */
  .text-muted-sm{ color:#6c7493; font-size:.92rem; }
  .actions .btn{ margin-right:.25rem; }
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
            <a class="btn btn-export" href="{{ route('excel.export.pemesanan') }}">
              <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="table-wrap">
          <table class="table table-hover mb-0 booking-table">
            <thead>
              <tr>
                <th style="width:64px">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Travel Package</th>
                <th style="width:110px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $booking)
                @php
                  // Map status -> class & label rapi
                  $status = strtolower(trim($booking->status));
                  $statusMap = [
                    'menunggu'    => ['pending',  'Menunggu'],
                    'pending'     => ['pending',  'Menunggu'],
                    'ditolak'     => ['rejected', 'Ditolak'],
                    'rejected'    => ['rejected', 'Ditolak'],
                    'di-setujui'  => ['approved', 'Disetujui'],
                    'disetujui'   => ['approved', 'Disetujui'],
                  ];
                  [$cls, $label] = $statusMap[$status] ?? ['pending', ucfirst($booking->status)];
                @endphp
                <tr>
                  <td>{{ $loop->iteration + ($bookings->currentPage()-1)*$bookings->perPage() }}</td>
                  <td>
                    <div class="font-weight-bold text-dark">{{ $booking->name }}</div>
                    {{-- <div class="text-muted-sm">ID #{{ $booking->id }}</div> --}}
                  </td>
                  <td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td>
                  <td>{{ $booking->number_phone }}</td>
                  <td>
                    @php
                      try {
                        $dt = \Carbon\Carbon::parse($booking->date);
                        echo $dt->translatedFormat('d M Y');
                      } catch (\Exception $e) {
                        echo e($booking->date);
                      }
                    @endphp
                  </td>
                  <td><span class="badge-soft {{ $cls }}">{{ $label }}</span></td>
                  <td>{{ $booking->travel_package->location }}</td>
                  <td class="actions">
                    <form onclick="return confirm('Yakin hapus data ini?');" class="d-inline-block"
                          action="{{ route('admin.bookings.destroy', [$booking]) }}" method="post">
                      @csrf @method('delete')
                      <button class="btn btn-sm btn-outline-danger" title="Hapus">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>

                    @if ($status !== 'di-setujui' && $status !== 'disetujui')
                      <a href="{{ route('admin.bookings.show', $booking->id) }}"
                         class="btn btn-sm btn-outline-primary" title="Setujui">
                        <i class="fas fa-check-circle"></i>
                      </a>
                    @endif
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
@endsection
