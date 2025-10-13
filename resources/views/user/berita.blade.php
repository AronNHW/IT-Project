@extends('layouts.user')

@section('title', 'Berita')

@section('content')
    <h1 class="page-title">Berita Terbaru</h1>

    <div class="berita-grid">
        @forelse ($beritas as $berita)
            <div class="berita-card">
                <img src="{{ asset('storage/' . $berita->foto_berita) }}" alt="Foto Berita" class="card-img">
                <div class="card-body">
                    <h2 class="card-title">{{ $berita->judul_berita }}</h2>
                    <p class="card-date">{{ $berita->created_at->format('d F Y') }}</p>
                    <p class="card-text">{{ Str::limit(strip_tags(html_entity_decode($berita->deskripsi)), 100) }}</p>
                    <a href="{{ route('user.berita.show', $berita->id) }}" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </div>
        @empty
            <p>Belum ada berita.</p>
        @endforelse
    </div>
@endsection
