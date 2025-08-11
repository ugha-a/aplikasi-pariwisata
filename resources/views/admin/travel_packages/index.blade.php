@extends('layouts.app')

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-between align-items-center">
          <div>
            <h1 class="m-0">Travel Package</h1>
            <small class="text-muted">Kelola data paket wisata dengan cepat & mudah</small>
          </div>
          <a href="{{ route('admin.travel_packages.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i> Tambah
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="card card-neo">
        <div class="card-body">
          <div class="table-responsive">

            {{-- Toolbar di atas tabel: search custom --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                    {{-- <span class="input-group-text"> <i class="fas fa-search position-absolute"></i></i></span> --}}
                  </div>
                  {{-- <input id="globalSearch" type="text" class="form-control" placeholder="Cari tipe, lokasi, atau harga…"> --}}
                </div>
              </div>
            </div>

            <table id="tpTable" class="table table-hover table-borderless w-100 align-middle">
              <thead class="thead-neo">
                <tr>
                  <th style="width: 56px">No</th>
                  <th>Tipe</th>
                  <th>Lokasi</th>
                  <th>Pengelola</th>
                  <th>Harga</th>
                  <th style="width: 120px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($travel_packages as $travel_package)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $travel_package->type }}</td>
                    <td>{{ $travel_package->locations?->name ?? '-' }}</td>
                    <td>{{ $travel_package->users?->name ?? '-' }}</td>
                    <td data-price="{{ $travel_package->price }}">{{ $travel_package->price }}</td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                        <a href="{{ route('admin.travel_packages.edit', [$travel_package]) }}"
                           class="btn btn-light btn-action" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <form class="d-inline-block"
                              action="{{ route('admin.travel_packages.destroy', [$travel_package]) }}"
                              method="post"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                          @csrf
                          @method('delete')
                          <button class="btn btn-sm btn-outline-danger" title="Hapus">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('styles')
<style>
  :root{ --brand:#3366FF; --soft:#eaf1ff; --ink:#22346c; }
  .card-neo{ border:1px solid #f1f3fa; border-radius:14px; box-shadow:0 10px 28px rgba(51,102,255,.06); }
  .thead-neo th{ background:var(--soft); color:var(--ink); border:none!important; }
  #tpTable tbody tr:hover{ background:#fcfdff; }
  .btn-action{ border:1px solid #edf1ff; }
  .btn-action:hover{ border-color:var(--brand); color:var(--brand)!important; box-shadow:0 2px 10px rgba(51,102,255,.12); }
  /* Sembunyikan search bawaan DataTables (karena pakai custom) */
  div.dataTables_filter{ display:none; }
  /* Style length & buttons tetap rapi */
  div.dataTables_length select{ border:1px solid #dde7ff; border-radius:.5rem; padding:.25rem .5rem; }
  .dt-buttons .btn{
    border:1px solid #dde7ff!important; background:#fff!important; color:var(--ink)!important; border-radius:.5rem!important;
  }
  .dt-buttons .btn:hover{ color:var(--brand)!important; border-color:var(--brand)!important; }
  table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
  table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before{ background-color:var(--brand); }
</style>
@endsection

@section('scripts')
<script>
  jQuery(function($){
    // cek cepat
    console.log('jQuery:', $.fn.jquery);
    console.log('DataTables ready?', !!$.fn.dataTable);

    // formatter rupiah
    const rupiah = n => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(+n||0);
    $('#tpTable tbody td[data-price]').each(function(){
      const raw = $(this).attr('data-price');
      $(this).text(rupiah(raw));
    });

    const dt = $('#tpTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[1, 'asc']],
        language: {
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            paginate: { previous: "‹", next: "›" }
        },
        columnDefs: [
            { targets: 0, className: "text-center", orderable: false },
            { targets: -1, orderable: false, searchable: false, className: "text-nowrap" }
        ],
        // Hilangkan lengthMenu & default search box
        dom: "<'row mb-3'<'col-md-6'<'custom-search'>>>" +
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-md-6'i><'col-md-6 text-md-right'p>>"
        });

        // Tambahkan search box custom
        $("div.custom-search").html(`
        <div style="position: relative; max-width: 320px;">
            <i class="fas fa-search position-absolute" style="left:.65rem; top:50%; transform:translateY(-50%); opacity:.6;"></i>
            <input id="globalSearch" type="search" class="form-control"
                placeholder="Cari tipe/lokasi/pengelola/harga…"
                style="padding-left:2.2rem; border-radius:.6rem; border:1px solid #e7ecf5; background:#f8faff;">
        </div>
        `);

        // Event filter
        $('#globalSearch').on('keyup change', function () {
        dt.search(this.value).draw();
        });


    // search custom (kalau ada #globalSearch)
    $('#globalSearch').on('input change', function(){
      dt.search(this.value).draw();
    });

    // renumber kolom No
    dt.on('order.dt search.dt', function () {
      let i = 1;
      dt.cells(null, 0, {search:'applied', order:'applied'}).every(function () {
        this.data(i++);
      });
    }).draw();
  });
</script>
@endsection
