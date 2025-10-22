@extends('layouts.user')

@section('title', 'Divisi')

@section('content')
    <div style="display: flex; justify-content: center;" class="mb-4">
        <img src="{{ asset('assets/image/logo_hima.png') }}" alt="Logo HIMA" style="max-width: 150px;">
    </div>
    <h1 class="page-title">Divisi Himpunan Mahasiswa Teknologi Informasi</h1>

    <div class="divisi-grid">
        @forelse ($divisis as $divisi)
            <div class="divisi-card">
                @if($divisi->photo_divisi)
                    <img src="{{ Storage::url($divisi->photo_divisi) }}" alt="{{ $divisi->nama_divisi }}" class="card-img">
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $divisi->nama_divisi }}</h2>
                                                            <p class="card-text">{{ Str::limit(strip_tags(html_entity_decode($divisi->deskripsi)), 100) }}</p>
                    <a href="{{ route('user.divisi.show', $divisi) }}" class="btn-read-more">Baca Selengkapnya</a>
                </div>
            </div>
        @empty
            <p>Belum ada data divisi.</p>
        @endforelse
    </div>
@endsection

@push('styles')
<style>
.divisi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}
.divisi-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.2s;
}
.divisi-card:hover {
    transform: translateY(-5px);
}
.divisi-card .card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.divisi-card .card-body {
    padding: 1.5rem;
}
.divisi-card .card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.divisi-card .card-text {
    color: #6b7280;
}
.btn-read-more {
    display: inline-block;
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    background-color: #2563eb;
    color: #fff;
    border-radius: 0.375rem;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.2s;
}
.btn-read-more:hover {
    background-color: #1d4ed8;
}
</style>
@endpush