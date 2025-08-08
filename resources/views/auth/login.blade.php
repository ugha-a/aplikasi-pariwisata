@extends('layouts.guest')

@section('content')
        <div class="login-brand mb-4">
            <span class="brand-blue">SULAWESI </span>
            {{-- <i class="bx bxs-map brand-orange"></i> --}}
            <span class="brand-blue">TENGGARA</span>
        </div>
    <div class="login-box-custom shadow-lg">
        <h2 class="login-title mb-4">Login</h2>
        <p class="login-desc mb-4">
            Selamat datang di sistem informasi<br>
            <b>Wisata Sulawesi Tenggara</b>
        </p>
        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email" required autofocus>
                @error('email')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bx bx-lock"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password" required>
                @error('password')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary-blue w-40">Login</button>
            </div>
        </form>
        @if (Route::has('password.request'))
            <div class="text-end">
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #3366FF 0%, #4185f5 50%, #FF8000 100%);
    position: relative;
    overflow-x: hidden;
}

/* SVG pattern batik wave di sudut atas kiri dan bawah kanan */
.bg-batik-wave {
    position: absolute;
    z-index: 1;
    opacity: 0.18;
    pointer-events: none;
}

.bg-batik-wave.top {
    top: 0;
    left: 0;
    width: 330px;
    height: 120px;
}

.bg-batik-wave.bottom {
    bottom: 0;
    right: 0;
    width: 340px;
    height: 140px;
    transform: rotateY(180deg);
}
.login-box, .login-box-custom {
    position: relative;
    z-index: 2;
}
.login-brand {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2.1rem;
    font-weight: bold;
    letter-spacing: 2px;
    margin-bottom: 2rem;
    gap: 0.18em;
    /* memastikan sejajar */
}
.brand-blue {
    color: #fff;
}
.brand-orange {
    color: #fff;
    font-size: 1.3em;
    margin: 0 0.15em;
    vertical-align: middle;
}
.login-box-custom {
    background: #fff;
    max-width: 390px;
    margin: 0 auto 3rem auto;
    border-radius: 1.1rem;
    padding: 2.2rem 2rem 2rem 2rem;
    box-shadow: 0 8px 36px rgba(51,102,255,0.13), 0 1.5px 10px rgba(51,102,255,0.08);
    border: 1.5px solid #eef4ff;
    transition: box-shadow .2s;
}
.login-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 1px;
    color: #233273;
    text-align: center;
    margin-bottom: 0.6rem;
}
.login-desc {
    color: #6c7493;
    font-size: 1.01rem;
    text-align: center;
    margin-bottom: 1.1rem;
}
.input-group {
    background: #f6faff;
    border-radius: 0.65rem;
    border: 1.5px solid #dde7ff;
    margin-bottom: 1.1rem;
    box-shadow: none !important;
}
.input-group-text {
    background: transparent;
    border: none;
    color: #3366FF;
    font-size: 1.2rem;
}
.form-control {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    color: #233273;
    font-weight: 500;
}
.form-control:focus {
    background: #eef3ff !important;
    border: none;
    box-shadow: 0 0 0 1.5px #3366FF;
}
.btn-primary-blue {
    background: #3366FF;
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: .55rem;
    padding: .6rem 2.2rem;
    box-shadow: 0 4px 14px rgba(51,102,255,0.18);
    transition: background 0.18s;
}
.btn-primary-blue:hover,
.btn-primary-blue:focus {
    background: #254ecf;
    color: #fff;
}
.form-check-input:checked {
    background-color: #3366FF;
    border-color: #3366FF;
}
.forgot-link {
    color: #3366FF;
    font-size: .97rem;
    text-decoration: none;
    font-weight: 500;
}
.forgot-link:hover {
    text-decoration: underline;
    color: #254ecf;
}
.invalid-feedback {
    color: #ff5656;
    font-size: 0.92em;
    margin-top: 0.2em;
}
@media (max-width: 500px) {
    .login-box-custom {
        padding: 1.2rem 0.7rem;
        max-width: 96vw;
    }
    .login-brand {
        font-size: 1.15rem;
    }
}
</style>
@endpush
