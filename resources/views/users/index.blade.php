@extends('layouts.app')

@section('styles')
<style>
  .card-header-toolbar {
    display: flex; gap: .75rem; align-items: center; justify-content: space-between; flex-wrap: wrap;
  }
  .search-wrap {
    position: relative; min-width: 260px; flex: 1 1 260px; max-width: 420px;
  }
  .search-wrap input {
    padding-left: 2.2rem;
    border-radius: .6rem;
    border: 1px solid #e7ecf5;
    background: #f8faff;
  }
  .search-wrap .icon {
    position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); opacity: .6;
  }
  .table thead th {
    border-top: none; border-bottom: 1px solid #edf1f7; color: #22346c; font-weight: 700; letter-spacing: .2px;
    background: #fbfcff; position: sticky; top: 0; z-index: 1;
  }
  .table tbody td { vertical-align: middle; }
  .table-hover tbody tr:hover { background: #f7faff; }
  .user-chip {
    display: inline-flex; align-items: center; gap: .75rem;
  }
  .user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: inline-grid; place-items: center; font-weight: 700; font-size: .9rem;
    color: #fff; background: #3366FF; box-shadow: 0 2px 8px rgba(51,102,255,.18);
  }
  .email-link { color: #3366FF; text-decoration: none; }
  .email-link:hover { text-decoration: underline; }
  .empty-state { text-align: center; padding: 3rem 1rem; color: #6c7493; }
  .empty-state .icon { font-size: 2rem; display:block; margin-bottom:.5rem; opacity:.55; }
</style>
@endsection

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">{{ __('Users') }}</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-header border-0">
              <div class="card-header-toolbar">
                <div class="search-wrap">
                  <i class="icon fas fa-search"></i>
                  <input id="userSearch" type="search" class="form-control" placeholder="Cari nama atau email…">
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                  <i class="fas fa-user-plus mr-1"></i> Create User
                </a>
              </div>
            </div>

            <div class="card-body p-0">
              @if($users->count())
              <div class="table-responsive">
                <table class="table table-hover mb-0" id="usersTable">
                  <thead>
                    <tr>
                      <th style="width: 50%">Name</th>
                      <th>Email</th>
                      <th style="width: 1%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                      @php
                        $initials = collect(explode(' ', trim($user->name)))
                          ->map(fn($p) => mb_substr($p, 0, 1))
                          ->take(2)
                          ->implode('');
                      @endphp
                      <tr>
                        <td>
                          <div class="user-chip">
                            <span class="user-avatar">{{ $initials ?: 'U' }}</span>
                            <div>
                              <div class="font-weight-bold text-dark mb-0">{{ $user->name }}</div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <a class="email-link" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </td>
                        <td class="text-nowrap pr-3">
                          <a href="{{ route('admin.users.edit', $user) }}" 
                             class="btn btn-sm btn-light" title="Edit">
                            <i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                class="d-inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
                  <span class="icon fas fa-users"></span>
                  <div class="h5 mb-1">Belum ada data user</div>
                  <div>Tambahkan user baru untuk mulai mengelola akses.</div>
                </div>
              @endif
            </div>

            <div class="card-footer clearfix">
              <div class="d-flex justify-content-end">
                {{ $users->links() }}
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
    const input = document.getElementById('userSearch');
    const rows  = Array.from(document.querySelectorAll('#usersTable tbody tr'));
    if(!input) return;

    function normalize(s){ return (s || '').toString().toLowerCase().trim(); }

    input.addEventListener('input', () => {
      const q = normalize(input.value);
      rows.forEach(tr => {
        const text = normalize(tr.innerText);
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  });
</script>
@endsection
