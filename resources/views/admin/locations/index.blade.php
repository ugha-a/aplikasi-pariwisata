@extends('layouts.app')

@section('styles')
<style>
  .card-header-toolbar{
    display:flex; gap:.75rem; align-items:center; justify-content:space-between; flex-wrap:wrap;
  }
  .search-wrap{ position:relative; min-width:260px; flex:1 1 260px; max-width:420px; }
  .search-wrap input{
    padding-left:2.2rem; border-radius:.6rem; border:1px solid #e7ecf5; background:#f8faff;
  }
  .search-wrap .icon{
    position:absolute; left:.65rem; top:50%; transform:translateY(-50%); opacity:.6;
  }
  .table thead th{
    border-top:none; border-bottom:1px solid #edf1f7; color:#22346c; font-weight:700; letter-spacing:.2px;
    background:#fbfcff;
  }
  .table-hover tbody tr:hover{ background:#f7faff; }
  .coord-badge{
    display:inline-block; padding:.25rem .5rem; border-radius:.5rem; background:#eff5ff; color:#1e3a8a;
    font-weight:600; font-size:.875rem;
  }
  .empty-state{ text-align:center; padding:3rem 1rem; color:#6c7493; }
  .empty-state .icon{ font-size:2rem; display:block; margin-bottom:.5rem; opacity:.55; }
</style>
@endsection

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">{{ __('Locations') }}</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-header border-0">
              <div class="card-header-toolbar">
                <div class="search-wrap">
                  <i class="icon fas fa-search"></i>
                  <input id="locationSearch" type="search" class="form-control" placeholder="Cari lokasi…">
                </div>
                <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                  <i class="fa fa-plus mr-1"></i> Tambah Lokasi
                </a>
              </div>
            </div>

            <div class="card-body p-0">
              @if($locations->count())
              <div class="table-responsive">
                <table class="table table-hover mb-0" id="locationsTable">
                  <thead>
                    <tr>
                      <th style="width:70px">No</th>
                      <th>Lokasi</th>
                      <th>Latitude</th>
                      <th>Longitude</th>
                      <th class="text-right" style="width:1%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($locations as $loc)
                      <tr>
                        <td>{{ ($locations->currentPage()-1)*$locations->perPage() + $loop->iteration }}</td>
                        <td class="font-weight-bold text-dark">{{ $loc->name }}</td>
                        <td><span class="coord-badge">{{ $loc->lat }}</span></td>
                        {{-- NOTE: jika field di DB bernama "lng", ganti $loc->lag -> $loc->lng --}}
                        <td><span class="coord-badge">{{ $loc->lag }}</span></td>
                        <td class="text-right text-nowrap pr-3">
                          <a href="{{ route('admin.locations.edit', $loc) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('admin.locations.destroy', $loc) }}" method="post"
                                class="d-inline-block"
                                onsubmit="return confirm('Yakin hapus lokasi ini?');">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fa fa-trash"></i>
                              </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
                <div class="empty-state">
                  <span class="icon fas fa-map-marked-alt"></span>
                  <div class="h5 mb-1">Belum ada data lokasi</div>
                  <div>Tambahkan lokasi baru untuk mulai menandai titik wisata.</div>
                </div>
              @endif
            </div>

            <div class="card-footer clearfix">
              <div class="d-flex justify-content-end">
                {{ $locations->links() }}
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('locationSearch');
    const rows  = Array.from(document.querySelectorAll('#locationsTable tbody tr'));
    if(!input) return;

    const norm = s => (s||'').toString().toLowerCase().trim();

    input.addEventListener('input', () => {
      const q = norm(input.value);
      rows.forEach(tr => {
        tr.style.display = norm(tr.innerText).includes(q) ? '' : 'none';
      });
    });
  });
</script>
@endsection
