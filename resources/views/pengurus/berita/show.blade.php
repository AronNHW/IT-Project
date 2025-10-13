@extends('layouts.pengurus')

@section('title', 'Detail Berita')

@section('content')
    <div class="berita-card">
        <div class="card-header">
            <h1 class="card-title">Detail Berita</h1>
        </div>
        <div class="card-body">
            <div class="berita-foto">
                <img src="{{ asset('storage/' . $berita->foto_berita) }}" alt="Foto Berita">
            </div>
            <div class="berita-info">
                <strong class="info-label">Judul:</strong>
                <span class="info-value">{{ $berita->judul_berita }}</span>
            </div>
            <div class="berita-info">
                <strong class="info-label">Waktu:</strong>
                <span class="info-value">{{ $berita->created_at->format('d F Y, H:i') }}</span>
            </div>
            <hr class="berita-divider">
            <div class="berita-deskripsi">
                <strong class="info-label">Isi Berita:</strong>
                <p>{!! $berita->deskripsi !!}</p>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('pengurus.berita.index') }}" class="btn-back">Kembali ke Daftar</a>
        </div>
    </div>
@endsection

@push('styles')
<style>
.berita-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    margin-top: 20px;
    overflow: hidden;
}
.berita-card .card-header {
    padding: 20px 24px;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}
.berita-card .card-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}
.berita-card .card-body {
    padding: 24px;
}
.berita-card .berita-foto {
    margin-bottom: 20px;
    text-align: center;
}
.berita-card .berita-foto img {
    width: 100%;
    max-height: 550px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 24px;
}
.berita-card .berita-info {
    display: flex;
    margin-bottom: 12px;
}
.berita-card .info-label {
    width: 80px;
    font-weight: 600;
    color: #4b5563;
}
.berita-card .info-value {
    color: #1f2937;
}
.berita-card .berita-divider {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #e5e7eb;
}
.berita-card .berita-deskripsi p {
    margin-top: 8px;
    line-height: 1.6;
    color: #374151;
}
.berita-card .card-footer {
    padding: 16px 24px;
    background-color: #f9fafb;
    text-align: right;
    border-top: 1px solid #e5e7eb;
}
.berita-card .btn-back {
    background-color: #6b7280;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s;
}
.berita-card .btn-back:hover {
    background-color: #4b5563;
}
</style>
@endpush
