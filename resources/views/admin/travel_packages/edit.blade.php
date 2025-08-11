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
          <a href="{{ route('admin.travel_packages.index') }}" class="btn btn-primary">
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
              <label for="name">Nama Gambar</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror"
                     name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Sunset Wakatobi">
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="images">File Gambar</label>
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

      {{-- ========== FORM PAKET ========== --}}
      <div class="card card-neo">
        <div class="card-header">
          <h5 class="m-0">Detail Paket</h5>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('admin.travel_packages.update', [$travel_package]) }}" class="row">
            @csrf
            @method('put')

            <div class="form-group col-md-6">
              <label for="type">Tipe</label>
              <input type="text" class="form-control @error('type') is-invalid @enderror"
                     name="type" id="type" value="{{ old('type', $travel_package->type) }}"
                     placeholder="Contoh: 3D2N">
              @error('type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Lokasi: dropdown (gunakan salah satu versi A/B) --}}
            {{-- A) Dropdown dari collection $locations (kirim dari controller) --}}
            @if(!empty($locations ?? null))
              <div class="form-group col-md-6">
                <label for="Location">Lokasi</label>
                <select name="location" id="Location" class="form-control @error('location') is-invalid @enderror">
                  <option value="">-- Pilih Lokasi --</option>
                  @foreach($locations as $loc)
                    <option value="{{ $loc }}" {{ old('location', $travel_package->location) == $loc ? 'selected' : '' }}>
                      {{ $loc }}
                    </option>
                  @endforeach
                </select>
                @error('location') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            @else
            {{-- B) Tetap input text jika belum ada $locations --}}
              <div class="form-group col-md-6">
                <label for="Location">Lokasi</label>
                <input type="text" class="form-control @error('location') is-invalid @enderror"
                       id="Location" name="location"
                       value="{{ old('location', $travel_package->location) }}"
                       placeholder="Contoh: Wakatobi, Kendari">
                @error('location') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            @endif

            <div class="form-group col-md-6">
              <label for="price">Harga</label>
              <div class="input-group @error('price') has-error @enderror">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp</span>
                </div>
                <input type="number" min="0" class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price" value="{{ old('price', $travel_package->price) }}"
                       placeholder="Contoh: 250000">
              </div>
              @error('price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group col-12">
              <label for="description">Deskripsi</label>
              <textarea class="form-control @error('description') is-invalid @enderror"
                        name="description" id="description" rows="7"
                        placeholder="Masukkan deskripsi">{{ old('description', $travel_package->description) }}</textarea>
              @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group col-12">
              <label for="facility">Fasilitas</label>
              <textarea class="form-control @error('facility') is-invalid @enderror"
                        name="facility" id="facility" rows="6"
                        placeholder="Masukkan fasilitas">{{ old('facility', $travel_package->facility) }}</textarea>
              @error('facility') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-success">
                <i class="fa fa-save mr-1"></i> Simpan Perubahan
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
  :root { --brand:#3366FF; --ink:#22346c; --soft:#eaf1ff; }
  .card-neo{ border:1px solid #f1f3fa; border-radius:14px; box-shadow:0 10px 28px rgba(51,102,255,.06); }
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
  {{-- CKEditor --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
  <script>
    // CKEditor untuk dua field
    ['#description','#facility'].forEach(sel=>{
      const el = document.querySelector(sel);
      if(el){
        ClassicEditor.create(el).catch(console.error);
      }
    });

    // Preview file gambar + update label
    const inputFile = document.getElementById('images');
    const labelFile = document.querySelector('label.custom-file-label');
    const preview   = document.getElementById('imgPreview');

    if(inputFile){
      inputFile.addEventListener('change', (e)=>{
        const f = e.target.files?.[0];
        if(!f) return;
        if(labelFile) labelFile.textContent = f.name;
        const reader = new FileReader();
        reader.onload = ev => {
          preview.src = ev.target.result;
          preview.classList.remove('d-none');
        };
        reader.readAsDataURL(f);
      });
    }
  </script>
@endsection
