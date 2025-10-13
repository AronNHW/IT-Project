@extends('layouts.user')

@section('title', 'Pendaftaran Pengurus HIMA TI')

@section('content')
<div id="pendaftaran-form" class="pendaftaran-card">
    <div class="pendaftaran-header">
        <h4>Formulir Pendaftaran Pengurus HIMA TI</h4>
        <p>Silakan isi form berikut untuk mendaftar sebagai pengurus HIMA TI.</p>
    </div>
    <div class="pendaftaran-body">
        <form action="{{ route('user.pendaftaran.store') }}" method="POST">
            @csrf
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="col-md-6">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan NIM" required>
                </div>
                <div class="col-md-6">
                    <label for="hp" class="form-label">Nomor HP</label>
                    <input type="text" id="hp" name="hp" class="form-control" placeholder="Masukkan nomor aktif" required>
                </div>
                <div class="col-md-6">
                    <label for="divisi" class="form-label">Divisi Tujuan</label>
                    <select id="divisi" name="divisi_id" class="form-select" required>
                        <option selected disabled value="">Pilih Divisi...</option>
                        @foreach($divisis as $div)
                            <option value="{{ $div->id }}">{{ $div->nama_divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="alasan" class="form-label">Alasan Bergabung</label>
                    <textarea id="alasan" name="alasan" class="form-control" rows="4" placeholder="Ceritakan alasan Anda bergabung" required></textarea>
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