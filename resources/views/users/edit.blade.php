@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Edit User</h1>
        <small class="text-muted">Perbarui data user di bawah ini</small>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Nama --}}
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name"
              class="form-control @error('name') is-invalid @enderror"
              placeholder="Masukkan nama lengkap"
              value="{{ old('name', $user->name) }}" required>
            @error('name')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="Masukkan email"
              value="{{ old('email', $user->email) }}" required>
            @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Password (opsional) --}}
          <div class="form-group">
            <label for="password">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" id="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Masukkan password baru (opsional)">
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Role --}}
          <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role"
              class="form-control @error('role') is-invalid @enderror" required>
              <option value="">-- Pilih Role --</option>
              <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="dinas" {{ old('role', $user->role) === 'dinas' ? 'selected' : '' }}>Dinas</option>
            </select>
            @error('role')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Tombol --}}
          <div class="mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save mr-1"></i> Perbarui
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>
@endsection
