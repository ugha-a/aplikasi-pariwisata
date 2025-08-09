@extends('layouts.app')

@section('content')
<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12 d-flex justify-content-between align-items-center">
        <h1 class="m-0">Buat Travel Package</h1>
        <a href="{{ route('admin.travel_packages.index') }}" class="btn btn-light border">
          <i class="fa fa-arrow-left mr-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-neo">
          <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.travel_packages.store') }}" id="tpForm" novalidate>
              @csrf

              <div class="form-row">
                {{-- TIPE --}}
                <div class="form-group col-md-6">
                  <label class="lbl" for="type">Tipe <span class="req">*</span></label>
                  <div class="input-group input-neo @error('type') has-error @enderror">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='fas fa-tag'></i></span>
                    </div>
                    <input type="text" name="type" id="type" class="form-control"
                           placeholder="Contoh: Package 1 / Open Trip / Private"
                           value="{{ old('type') }}" required>
                  </div>
                  @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- LOKASI --}}
                <div class="form-group col-md-6">
                  <label class="lbl" for="Location">Lokasi <span class="req">*</span></label>
                  <div class="input-group input-neo @error('location') has-error @enderror">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='fas fa-map-marker-alt'></i></span>
                    </div>
                    <input type="text" name="location" id="Location" class="form-control"
                           placeholder="Contoh: Kendari, Wakatobi"
                           value="{{ old('location') }}" required>
                  </div>
                  @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
              </div>

              <div class="form-row">
                {{-- HARGA --}}
                <div class="form-group col-md-6">
                  <label class="lbl" for="price">Harga (IDR) <span class="req">*</span></label>
                  <div class="input-group input-neo @error('price') has-error @enderror">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" inputmode="numeric" name="price" id="price"
                           class="form-control" placeholder="Masukkan harga"
                           value="{{ old('price') }}" required>
                  </div>
                  <small class="form-text text-muted">Ketik angka saja, otomatis jadi format Rupiah.</small>
                  @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
              </div>

              {{-- DESKRIPSI --}}
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="lbl" for="description">Deskripsi <span class="req">*</span></label>
                  <small id="descCount" class="text-muted">0/500</small>
                </div>
                <textarea class="form-control" id="description" name="description" rows="6"
                          placeholder="Tulis gambaran singkat paket wisata (maks 500 karakter)" required>{{ old('description') }}</textarea>
                @error('description') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
              </div>

              {{-- FASILITAS --}}
              <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="lbl" for="facility">Fasilitas</label>
                  <small id="facilityCount" class="text-muted">0/500</small>
                </div>
                <textarea class="form-control" id="facility" name="facility" rows="6"
                          placeholder="Contoh: Transportasi, Makan siang, Guide, Tiket masuk, dll.">{{ old('facility') }}</textarea>
                @error('facility') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-neo">
                  <i class="fas fa-save mr-1"></i> Simpan
                </button>
              </div>
            </form>
          </div> <!-- /card-body -->
        </div>
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
  .lbl{
    font-weight:600;color:#22346c;margin-bottom:.35rem;
  }
  .req{color:#ff6a00;}
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
  .has-error .form-control{border-color:#ff6b6b;}
  .btn-neo{
    background:var(--brand);border:none;
    box-shadow:0 6px 18px rgba(51,102,255,.2);
  }
  .btn-neo:hover{background:#254ecf;}
  /* CKEditor look & min height */
  .ck-editor__editable_inline{min-height:220px;border-radius:10px;}
  /* Counter text align */
  #descCount,#facilityCount{font-size:.85rem}
</style>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  // --- CKEditor init (Deskripsi & Fasilitas)
  const editors = {};
  function initEditor(selector, onChangeCb){
    return ClassicEditor.create(document.querySelector(selector),{
      toolbar: ['heading','bold','italic','bulletedList','numberedList','link','blockQuote','undo','redo']
    }).then(ed=>{
      editors[selector]=ed;
      ed.model.document.on('change:data', ()=> onChangeCb(ed.getData()));
    }).catch(console.error);
  }

  // --- Live counter (strip HTML to count)
  const limit = 500;
  const countText = html => (new DOMParser).parseFromString(html,'text/html').body.textContent || '';
  const setCounter = (elId, html) => {
    const text = countText(html).trim();
    const n = text.length;
    const el = document.getElementById(elId);
    el.textContent = `${n}/${limit}`;
    el.style.color = n>limit ? '#ff4d4d' : '#6c757d';
  };

  // Init editors + counters
  initEditor('#description', html=> setCounter('descCount', html)).then(()=>{
    setCounter('descCount', editors['#description']?.getData()||'');
  });
  initEditor('#facility', html=> setCounter('facilityCount', html)).then(()=>{
    setCounter('facilityCount', editors['#facility']?.getData()||'');
  });

  // --- Rupiah formatter (harga)
  const price = document.getElementById('price');
  const toRupiah = (v)=>{
    v = (v+'').replace(/[^\d]/g,'');
    if(!v) return '';
    return v.replace(/\B(?=(\d{3})+(?!\d))/g,'.');
  };
  const fromRupiah = v => (v+'').replace(/\./g,''); // if you need raw number later

  price.addEventListener('input', ()=>{
    const caret = price.selectionStart;
    price.value = toRupiah(price.value);
    // keep caret at end to avoid jumping – simplest approach
    price.selectionStart = price.selectionEnd = price.value.length;
  });

  // --- Client-side tiny checks before submit
  document.getElementById('tpForm').addEventListener('submit', (e)=>{
    // enforce description limit
    const descTxt = countText(editors['#description']?.getData()||'');
    if(descTxt.length > limit){
      e.preventDefault();
      alert('Deskripsi melebihi 500 karakter.');
      return;
    }
    // convert price to raw number (optional)
    // you can also handle in controller by stripping dots.
    price.value = fromRupiah(price.value);
  });
</script>
@endsection
