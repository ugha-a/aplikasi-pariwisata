@extends('layouts.app')

@section('content')
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-between align-items-center">
          <div>
            <h1 class="m-0">Edit Paket Wisata</h1>
            <small class="text-muted">Kelola galeri dan detail paket</small>
          </div>
          <a href="{{ route('admin.travel_packages.index') }}" class="btn btn-light border">
            <i class="fa fa-arrow-left mr-1"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main -->
  <div class="content">
    <div class="container-fluid">

      {{-- ========== GALERI ========== --}}
      <div class="card card-neo mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="m-0">Galeri</h5>
          <span class="text-muted small">{{ $travel_package->galleries->count() }} foto</span>
        </div>

        <div class="card-body">
          @if($travel_package->galleries->count())
            <div class="gallery-grid">
              @foreach($travel_package->galleries as $gallery)
                <div class="g-item">
                  <a href="{{ Storage::url($gallery->images) }}" target="_blank" class="thumb-wrap">
                    <img src="{{ Storage::url($gallery->images) }}" alt="{{ $gallery->name }}">
                  </a>
                  <div class="g-meta">
                    <div class="g-title" title="{{ $gallery->name }}">{{ $gallery->name ?: 'Tanpa judul' }}</div>
                    <div class="g-actions">
                      <a href="{{ route('admin.travel_packages.galleries.edit', [$travel_package,$gallery]) }}"
                         class="btn btn-sm btn-light">
                        <i class="fa fa-edit"></i>
                      </a>
                      <form class="d-inline-block"
                            action="{{ route('admin.travel_packages.galleries.destroy', [$travel_package,$gallery]) }}"
                            method="post"
                            onsubmit="return confirm('Yakin hapus gambar ini?')">
                        @csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center text-muted py-4">Galeri kosong.</div>
          @endif
        </div>
      </div>

      {{-- ========== TAMBAH GAMBAR ========== --}}
      <div class="card card-neo mb-4">
        <div class="card-header">
          <h5 class="m-0">Tambah Gambar</h5>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('admin.travel_packages.galleries.store', [$travel_package]) }}" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group col-md-6">
              <label class="lbl" for="name">Nama Gambar</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror"
                     name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Sunset Wakatobi">
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
              <label class="lbl" for="images">File Gambar</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input @error('images') is-invalid @enderror" name="images" id="images" accept="image/*">
                <label class="custom-file-label" for="images">Pilih file…</label>
              </div>
              @error('images') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
              <div class="mt-2">
                <img id="imgPreview" src="" alt="" class="img-preview d-none">
              </div>
            </div>
            <div class="col-12 mt-2">
              <button type="submit" class="btn btn-success">
                <i class="fa fa-save mr-1"></i> Simpan Gambar
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- ========== FORM PAKET (match form create) ========== --}}
      <div class="card card-neo">
        <div class="card-header">
          <h5 class="m-0">Detail Paket</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.travel_packages.update', [$travel_package]) }}" id="tpForm" novalidate class="row">
            @csrf
            @method('put')

            {{-- NAMA --}}
            <div class="form-group col-12">
              <label class="lbl" for="tp_name">Nama <span class="req">*</span></label>
              <div class="input-group input-neo @error('name') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='fas fa-file-signature'></i></span>
                </div>
                <input type="text" name="name" id="tp_name" class="form-control"
                       placeholder="Masukkan nama paket wisata"
                       value="{{ old('name', $travel_package->name) }}" required>
              </div>
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- TIPE --}}
            <div class="form-group col-md-6">
              <label class="lbl" for="type">Tipe <span class="req">*</span></label>
              <div class="input-group input-neo @error('type') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='fas fa-tag'></i></span>
                </div>
                <input type="text" name="type" id="type" class="form-control"
                       placeholder="Contoh: Package 1 / Open Trip / Private"
                       value="{{ old('type', $travel_package->type) }}" required>
              </div>
              @error('type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- LOKASI (dropdown id->name, sama seperti create) --}}
            <div class="form-group col-md-6">
              <label class="lbl" for="Location">Lokasi <span class="req">*</span></label>
              <div class="input-group input-neo @error('location') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='fas fa-map-marker-alt'></i></span>
                </div>
                <select name="location" id="Location" class="form-control" required>
                  <option value="">-- Pilih Lokasi --</option>
                  @foreach($locations as $loc)
                    <option value="{{ $loc->id }}"
                      {{ (string)old('location', $travel_package->location_id ?? $travel_package->location) === (string)$loc->id ? 'selected' : '' }}>
                      {{ $loc->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('location') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- HARGA (IDR) pakai format Rupiah seperti create --}}
            <div class="form-group col-md-6">
              <label class="lbl" for="price">Harga (IDR) <span class="req">*</span></label>
              <div class="input-group input-neo @error('price') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp</span>
                </div>
                <input type="text" inputmode="numeric" name="price" id="price"
                       class="form-control" placeholder="Masukkan harga"
                       value="{{ old('price', number_format((int)$travel_package->price, 0, ',', '.')) }}" required>
              </div>
              <small class="form-text text-muted">Ketik angka saja, otomatis jadi format Rupiah.</small>
              @error('price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- PENGELOLA (samakan struktur dengan create) --}}
            <div class="form-group col-md-6">
              <label class="lbl" for="user_id">Pengelola <span class="req">*</span></label>
              <div class="input-group input-neo @error('user_id') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                </div>
                {{-- NOTE: ganti $managers & name="manager" sesuai sumber data kamu.
                     Diset agar tidak bentrok dengan "location" seperti di form create awal. --}}
                <select name="user_id" id="user_id" class="form-control" required>
                  <option value="">-- Pilih User --</option>
                  @foreach(($users ?? []) as $mgr)
                    <option value="{{ $mgr->id }}"
                      {{ (string)old('user_id', $travel_package->user_id ?? '') === (string)$mgr->id ? 'selected' : '' }}>
                      {{ $mgr->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              @error('manager') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- DESKRIPSI + counter (CKEditor) --}}
            <div class="form-group col-12">
              <div class="d-flex justify-content-between align-items-center">
                <label class="lbl" for="description">Deskripsi <span class="req">*</span></label>
                {{-- <small id="descCount" class="text-muted">0/500</small> --}}
              </div>
              <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" rows="6"
                        placeholder="Tulis gambaran singkat paket wisata (maks 500 karakter)" required>{{ old('description', $travel_package->description) }}</textarea>
              @error('description') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>

            {{-- FASILITAS + counter (CKEditor) --}}
            <div class="form-group col-12">
              <div class="d-flex justify-content-between align-items-center">
                <label class="lbl" for="facility">Fasilitas</label>
                {{-- <small id="facilityCount" class="text-muted">0/500</small> --}}
              </div>
              <textarea class="form-control @error('facility') is-invalid @enderror"
                        id="facility" name="facility" rows="6"
                        placeholder="Contoh: Transportasi, Makan siang, Guide, Tiket masuk, dll.">{{ old('facility', $travel_package->facility) }}</textarea>
              @error('facility') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary btn-neo">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('styles')
<style>
  :root{
    --brand:#3366FF;
    --soft:#eaf1ff;
    --ink:#233273;
  }
  .card-neo{
    border: 1px solid #f1f3fa;
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(51,102,255,.06);
  }
  .lbl{ font-weight:600;color:#22346c;margin-bottom:.35rem; }
  .req{ color:#ff6a00; }
  .input-neo .input-group-text{
    background:#f6faff;border:1px solid #dde7ff;color:var(--brand);
  }
  .input-neo .form-control{
    border:1px solid #dde7ff;background:#fff;transition:box-shadow .15s,border .15s;
  }
  .input-neo .form-control:focus{
    border-color: var(--brand);
    box-shadow: 0 0 0 .15rem rgba(51,102,255,.15);
  }
  .has-error .form-control{ border-color:#ff6b6b; }
  .btn-neo{
    background:var(--brand);border:none;
    box-shadow:0 6px 18px rgba(51,102,255,.2);
  }
  .btn-neo:hover{ background:#254ecf; }
  #descCount,#facilityCount{ font-size:.85rem }

  /* Galeri */
  .gallery-grid{
    display:grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr));
    gap:1rem;
  }
  .g-item{ background:#fff; border:1px solid #eef2f9; border-radius:.9rem; overflow:hidden; display:flex; flex-direction:column; }
  .thumb-wrap{ display:block; width:100%; aspect-ratio:16/10; background:#f7f8fc; }
  .thumb-wrap img{ width:100%; height:100%; object-fit:cover; display:block; }
  .g-meta{ padding:.75rem .75rem; display:flex; align-items:center; justify-content:space-between; gap:.5rem; }
  .g-title{ font-weight:600; color:#22346c; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:70%; }
  .g-actions .btn{ border-radius:.5rem; }
  .custom-file-label::after{ content:"Browse"; }
  .img-preview{ max-height:110px; border-radius:.6rem; border:1px solid #eef2f9; }

  .form-group label{ font-weight:600; color:#22346c; }
  .input-group-text{ background:#f8faff; border-color:#e7ecf5; }
</style>
@endsection

@section('scripts')
  {{-- CKEditor (samakan versi dgn create) --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
  <script>
    // --- CKEditor init (Deskripsi & Fasilitas)
    const editors = {};
    function initEditor(selector){
      return ClassicEditor.create(document.querySelector(selector), {
        toolbar: ['heading','bold','italic','bulletedList','numberedList','link','blockQuote','undo','redo']
      }).then(ed => {
        editors[selector] = ed;
      }).catch(console.error);
    }
  
    // Init editors (tanpa counter)
    initEditor('#description');
    initEditor('#facility');
  
    // --- Rupiah formatter (harga)
    const price = document.getElementById('price');
    const toRupiah = (v) => {
      v = (v + '').replace(/[^\d]/g, '');
      if (!v) return '';
      return v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };
    const fromRupiah = v => (v + '').replace(/\./g, '');
  
    price.addEventListener('input', () => {
      price.value = toRupiah(price.value);
      price.selectionStart = price.selectionEnd = price.value.length;
    });
  
    // --- Client-side submit
    document.getElementById('tpForm').addEventListener('submit', (e) => {
      // konversi harga ke angka murni sebelum kirim
      price.value = fromRupiah(price.value);
    });
  </script>
  
@endsection
