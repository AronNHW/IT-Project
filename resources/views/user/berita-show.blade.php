@extends('layouts.user')

@section('title', $berita->judul_berita)

@section('content')
    <div class="berita-detail">
        <h1 class="berita-title">{{ $berita->judul_berita }}</h1>
        <p class="berita-date">{{ $berita->created_at->format('d F Y') }}</p>
        <img src="{{ asset('storage/' . $berita->foto_berita) }}" alt="Foto Berita" class="berita-img">
        <div class="berita-content">
            {!! $berita->deskripsi !!}
        </div>
    </div>

    <div id="komentar-section" class="komentar-section">
        @if(session('success'))
            <div class="alert alert-success" style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="komentar-title">Komentar</h2>
        <form action="{{ route('user.komentar.store', $berita->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="isi_komentar">Komentar</label>
                <textarea name="isi_komentar" id="isi_komentar" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Kirim Komentar</button>
        </form>

        <div class="komentar-list">
            @forelse ($berita->komentars as $komentar)
                <div class="komentar-item">
                    <p class="komentar-nama">{{ $komentar->nama }}</p>
                    <p class="komentar-isi">{{ $komentar->isi_komentar }}</p>
                    <p class="komentar-tanggal">{{ $komentar->created_at->format('d F Y, H:i') }}</p>
                </div>
            @empty
                <p>Belum ada komentar.</p>
            @endforelse
        </div>
    </div>
@endsection