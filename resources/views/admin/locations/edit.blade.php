@extends('layouts.app')

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-between align-items-center">
          <div>
            <h1 class="m-0">Edit Lokasi</h1>
            <small class="text-muted">Perbarui data lokasi wisata</small>
          </div>
          <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left mr-1"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid">
      <div class="card card-neo">
        <div class="card-header bg-white border-0">
          <h5 class="mb-0 text-dark">Form Edit</h5>
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('admin.locations.update', $location) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
              <!-- Nama Lokasi -->
              <div class="form-group col-md-6">
                <label for="name" class="font-weight-semibold">Nama Lokasi</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name"
                       value="{{ old('name', $location->name) }}"
                       placeholder="Contoh: Pantai Nambo" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                <small class="form-text text-muted">Gunakan nama yang mudah dikenali pengunjung.</small>
              </div>

              <!-- User Pemilik/PIC -->
              <div class="form-group col-md-6">
                <label for="user" class="font-weight-semibold">Pengelola</label>
                <select id="user" name="user"
                        class="form-control select2 @error('user') is-invalid @enderror" required>
                  <option value="">— Pilih Pengelola —</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}"
                      {{ (string)old('user', $location->user_id) === (string)$u->id ? 'selected' : '' }}>
                      {{ $u->name }} — {{ $u->email }}
                    </option>
                  @endforeach
                </select>
                @error('user') <small class="text-danger">{{ $message }}</small> @enderror
                <small class="form-text text-muted">Hubungkan lokasi dengan user yang bertanggung jawab.</small>
              </div>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
              <label for="description" class="font-weight-semibold">Deskripsi</label>
              <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" rows="6"
                        placeholder="Tulis deskripsi singkat lokasi...">{{ old('description', $location->description) }}</textarea>
              @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
              <!-- Latitude -->
              <div class="form-group col-md-6">
                <label for="lat" class="font-weight-semibold">Latitude</label>
                <input type="text"
                       class="form-control @error('lat') is-invalid @enderror"
                       id="lat" name="lat"
                       value="{{ old('lat', $location->lat) }}"
                       placeholder="Contoh: -3.9917" required>
                @error('lat') <small class="text-danger">{{ $message }}</small> @enderror
                <small class="form-text text-muted">Nilai desimal, negatif untuk selatan (S).</small>
              </div>

              <!-- Longitude -->
              <div class="form-group col-md-6">
                <label for="lag" class="font-weight-semibold">Longitude</label>
                <input type="text"
                       class="form-control @error('lag') is-invalid @enderror"
                       id="lag" name="lag"
                       value="{{ old('lag', $location->lag) }}"
                       placeholder="Contoh: 122.5120" required>
                @error('lag') <small class="text-danger">{{ $message }}</small> @enderror
                <small class="form-text text-muted">Nilai desimal, positif untuk timur (E).</small>
              </div>
            </div>

            <div class="pt-2">
              <button type="submit" class="btn btn-primary-blue">
                <i class="fa fa-save mr-1"></i> Update
              </button>
              <a href="{{ route('admin.locations.index') }}" class="btn btn-light border">Batal</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('styles')
<style>
  :root{ --brand:#3366FF; }
  .card-neo{
    border:1px solid #f1f3fa; border-radius:14px;
    box-shadow:0 10px 28px rgba(51,102,255,.06);
  }
  .font-weight-semibold{ font-weight:600; }
  .btn-primary-blue{
    background:var(--brand); border-color:var(--brand); color:#fff;
    box-shadow:0 4px 12px rgba(51,102,255,.16);
  }
  .btn-primary-blue:hover{ background:#254ecf; border-color:#254ecf; color:#fff; }
  .form-control:focus{
    border-color:var(--brand); box-shadow:0 0 0 .15rem rgba(51,102,255,.15);
  }
  .ck-editor__editable_inline{ min-height:220px; }
</style>
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
@endsection

@section('scripts')
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    // CKEditor
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    // Select2 untuk dropdown User
    $(function(){
      $('#user_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: '— Pilih User —'
      });
    });
  </script>
@endsection
