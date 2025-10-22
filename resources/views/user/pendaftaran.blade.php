@extends('layouts.user')

@section('title', 'Pendaftaran Pengurus HIMA TI')

@push('styles')
<style>
    .registration-closed-overlay,
    .login-required-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(5px);
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
        border-radius: 0.75rem;
    }
    .registration-closed-message h4,
    .login-required-message h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    .registration-closed-message p,
    .login-required-message p {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    .login-required-message .btn-login {
        background-color: #3b82f6;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
    }
    .login-required-message .btn-login:hover {
        background-color: #2563eb;
    }

    /* CSS untuk menonaktifkan interaksi saat blur */
    .pendaftaran-card.blurred > * {
        pointer-events: none;
        user-select: none;
    }
</style>
@endpush

@section('content')
<div id="pendaftaran-form" class="pendaftaran-card" style="position: relative;">
    {{-- Overlay untuk status pendaftaran ditutup --}}
    @if (!$registrationStatus || $registrationStatus->value == 'closed')
        <div class="registration-closed-overlay">
            <div class="registration-closed-message">
                <h4>Pendaftaran Belum Dibuka</h4>
                <p>Pendaftaran belum dibuka pada saat ini. Tunggu info selanjutnya dari website kami.</p>
            </div>
        </div>
    @endif

    {{-- Overlay untuk belum login --}}
    @guest
        @if (!$registrationStatus || $registrationStatus->value == 'closed')
            {{-- Jika pendaftaran ditutup DAN belum login --}}
            <div class="login-required-overlay">
                <div class="login-required-message">
                    <h4>Pendaftaran Belum Dibuka</h4>
                    <p>Silakan login terlebih dahulu dan tunggu informasi terbaru dari kami.</p>
                    <a href="{{ route('login') }}" class="btn-login">Login Sekarang</a>
                </div>
            </div>
        @else
            {{-- Jika pendaftaran dibuka TAPI belum login --}}
            <div class="login-required-overlay">
                <div class="login-required-message">
                    <h4>Anda Belum Login</h4>
                    <p>Silakan login terlebih dahulu untuk mengakses halaman pendaftaran.</p>
                    <a href="{{ route('login') }}" class="btn-login">Login Sekarang</a>
                </div>
            </div>
        @endif
    @endguest

    {{-- Konten formulir pendaftaran --}}
    <div class="pendaftaran-header">
        <h4>Formulir Pendaftaran Pengurus HIMA TI</h4>
        <p>Silakan isi form berikut untuk mendaftar sebagai pengurus HIMA TI.</p>
    </div>
    <div class="pendaftaran-body">
        <form action="{{ route('user.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="hp" class="form-label">Nomor HP</label>
                    <input type="text" id="hp" name="hp" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan nomor aktif" value="{{ old('hp') }}" required>
                    @error('hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="divisi" class="form-label">Divisi Tujuan</label>
                    <select id="divisi" name="divisi_id" class="form-select @error('divisi_id') is-invalid @enderror" required>
                        <option selected disabled value="">Pilih Divisi...</option>
                        @foreach($divisis as $div)
                            <option value="{{ $div->id }}" {{ old('divisi_id') == $div->id ? 'selected' : '' }}>{{ $div->nama_divisi }}</option>
                        @endforeach
                    </select>
                    @error('divisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="gambar" class="form-label">Upload Foto Diri <span style="color: red;">*</span></label>
                    <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" required>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="alasan" class="form-label">Alasan Bergabung</label>
                    <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="4" placeholder="Ceritakan alasan Anda bergabung" required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-submit-pendaftaran">
                    <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection