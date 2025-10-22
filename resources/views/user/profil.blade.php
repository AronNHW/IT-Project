@extends('layouts.user')

@section('title', 'Profil HIMA TI')

@push('styles')
<style>
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1d4ed8;
        --text-light: #f9fafb;
        --text-dark: #1f2937;
        --bg-light: #f3f4f6;
        --card-bg: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .profil-container {
        padding: 2rem 1rem;
    }

    .profil-container h1 {
        text-align: center;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 2.25rem;
        margin-bottom: 1.5rem;
    }

    .profil-container .logo {
        display: block;
        margin: 0 auto 2rem;
        width: 180px; /* Increased logo size */
        height: 180px; /* Increased logo size */
    }

    .profil-container .hero {
        width: min(1400px, 95%);
        margin: 0 auto 3rem;
        background: var(--primary-color);
        color: var(--text-light);
        border-radius: 1rem;
        padding: 2.5rem;
        text-align: center;
        line-height: 1.7;
        box-shadow: var(--shadow-lg);
    }

    .profil-container .hero h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .profil-container .hero ul {
        list-style: none;
        padding: 0;
        margin: 0 auto;
        display: table;
        text-align: left;
    }

    .profil-container .hero ul li::before {
        content: "✓ ";
        color: var(--text-light);
    }

    .profil-container .grid {
        display: grid;
        gap: 2rem;
        grid-template-columns: repeat(4, 1fr);
        width: min(1400px, 95%);
        margin: 0 auto 4rem;
    }

    @media(max-width: 1200px) {
        .profil-container .grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 768px) {
        .profil-container .grid {
            grid-template-columns: 1fr;
        }
    }

    .profil-container .card {
        background: var(--card-bg);
        color: var(--text-dark);
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: var(--shadow-sm);
        border: 1px solid #e5e7eb;
    }

    .profil-container .card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .profil-container .icon {
        display: block;
        margin: 0 auto 1rem;
        width: 64px;
        height: 64px;
        fill: var(--primary-color);
    }

    .profil-container .card .name {
        font-weight: 700;
        font-size: 1.125rem;
    }

    .profil-container .card .role {
        color: #6b7280;
    }

</style>
@endpush

@section('content')
<div class="profil-container">
  <h1>{!! $settings['site_name']->value ?? 'HIMPUNAN MAHASISWA<br>TEKNOLOGI INFORMASI D3' !!}</h1>

  <img class="logo" src="{{ isset($settings['logo']) ? asset($settings['logo']->value) : asset('assets/image/logo_hima.png') }}" alt="Logo HIMA-TI">

  <div class="hero">
    <p>
      {!! $settings['deskripsi']->value ?? 'Himpunan Mahasiswa Teknologi Informasi (HIMA-TI) Politeknik Negeri Tanah Laut merupakan organisasi kemahasiswaan 
      yang berperan sebagai wadah pengembangan potensi, kreativitas, dan solidaritas mahasiswa di lingkungan Program Studi Teknologi Informasi.' !!}
    </p>

    <h3>Visi</h3>
    <p>{{ $settings['visi']->value ?? 'Menjadikan HIMA-TI sebagai wadah yang aktif, inovatif, dan berkarakter dalam pengembangan potensi mahasiswa Teknologi Informasi.' }}</p>

    <h3>Misi</h3>
    <div style="display: inline-block; text-align: left;">{!! nl2br(e($settings['misi']->value ?? 'Meningkatkan solidaritas dan profesionalisme antaranggota.')) !!}</div>
  </div>

  <div class="grid">
    <div class="card">
      <svg class="icon" viewBox="0 0 24 24">
        <path d="M12 12c2.7 0 8 1.34 8 4v4H4v-4c0-2.66 5.3-4 8-4Zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
      </svg>
      <div class="name">{{ $settings['nama_ketua']->value ?? 'Nama Ketua' }}</div>
      <div class="role">Ketua Umum</div>
    </div>

    <div class="card">
      <svg class="icon" viewBox="0 0 24 24">
        <path d="M16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-8 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 2C5.7 13 1 14.2 1 16.5V19h8v-2c0-.68.28-1.3.72-1.72C9.92 14.44 8.95 13 8 13Zm8 0c-.95 0-1.92 1.44-2.72 2.28.44.42.72 1.04.72 1.72V19h8v-2.5c0-2.33-4.67-3.5-7-3.5Z"/>
      </svg>
      <div class="name">{{ $settings['nama_wakil']->value ?? 'Nama Wakil' }}</div>
      <div class="role">Wakil Ketua</div>
    </div>

    <div class="card">
      <svg class="icon" viewBox="0 0 24 24">
        <path d="M4 4h16v2H4zm0 4h10v2H4zm0 4h16v2H4zm0 4h10v2H4z"/>
      </svg>
      <div class="name">{{ $settings['nama_sekretaris']->value ?? 'Nama Sekretaris' }}</div>
      <div class="role">Sekretaris Umum</div>
    </div>

    <div class="card">
      <svg class="icon" viewBox="0 0 24 24">
        <path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
      </svg>
      <div class="name">{{ $settings['nama_bendahara']->value ?? 'Nama Bendahara' }}</div>
      <div class="role">Bendahara Umum</div>
    </div>
  </div>
</div>
@endsection
