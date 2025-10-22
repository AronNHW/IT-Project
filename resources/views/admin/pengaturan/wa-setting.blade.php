@extends('layouts.admin')

@section('title', 'Kelola Setting WhatsApp')

@push('styles')
<style>
    :root{
      --bg:#f5f6f8;
      --card:#ffffff;
      --text:#1f2937;
      --muted:#6b7280;
      --primary:#2563eb;
      --primary-pressed:#1d4ed8;
      --radius:14px;
      --shadow:0 6px 20px rgba(0,0,0,.06);
    }
    .wa-settings-card {
      background:var(--card);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:26px;
    }
    .wa-settings-card h1{
      font-size:20px;
      margin:0 0 22px 0;
      font-weight:600;
    }
    .wa-settings-card h2{
      font-size:18px;
      margin:22px 0 8px;
      font-weight:600;
      border-top: 1px solid #e5e7eb;
      padding-top: 22px;
    }
    .wa-settings-card .label{
      display:block;
      font-size:12px;
      color:var(--muted);
      margin-bottom:8px;
      margin-top: 1rem;
    }
    .wa-settings-card .field{
      width:100%;
      padding:12px 14px;
      border:1px solid #e5e7eb;
      border-radius:10px;
      font:inherit;
      outline:none;
      background:#fff;
      transition:border .15s ease, box-shadow .15s ease;
    }
    .wa-settings-card .field:focus{
      border-color:var(--primary);
      box-shadow:0 0 0 4px rgba(37,99,235,.12);
    }
    .wa-settings-card textarea.field{
      min-height:110px;
      resize:vertical;
      line-height:1.5;
    }
    .wa-settings-card .hint{
      font-size:12px;
      color:var(--muted);
      margin-top:6px;
    }
    .wa-settings-card .actions{
      margin-top:22px;
      display:flex;
      gap:12px;
    }
    .wa-settings-card .btn{
      appearance:none;
      border:0;
      background:var(--primary);
      color:#fff;
      font-weight:600;
      padding:12px 18px;
      border-radius:12px;
      cursor:pointer;
      transition:transform .04s ease, background .15s ease, box-shadow .15s ease;
      box-shadow:0 8px 22px rgba(37,99,235,.25);
    }
    .wa-settings-card .btn:active{ transform:translateY(1px); }
    .wa-settings-card .btn:hover{ background:var(--primary-pressed); }
    /* small screens */
    @media (max-width:540px){
      .wa-settings-card { padding:20px; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <form class="wa-settings-card" action="{{ route('admin.pengaturan.wa.update') }}" method="POST">
        @csrf
        @method('PUT')

        <h1>Kelola Setting WhatsApp</h1>

        <h2>Kelola Setting Pesan Tahap 1</h2>

        <label class="label" for="msgAccepted">Pesan untuk Pendaftaran Diterima</label>
        <textarea
            class="field"
            id="msgAccepted"
            name="pesan_diterima"
            placeholder="Contoh: Assalamu'alaikum, selamat! Pendaftaran Anda telah diterima..."
            required
        >{{ old('pesan_diterima', $pesan_diterima ?? '') }}</textarea>

        <label class="label" for="msgRejected">Pesan untuk Pendaftaran Ditolak</label>
        <textarea
            class="field"
            id="msgRejected"
            name="pesan_ditolak"
            placeholder="Contoh: Mohon maaf, pendaftaran Anda belum bisa kami terima pada tahap ini..."
            required
        >{{ old('pesan_ditolak', $pesan_ditolak ?? '') }}</textarea>

        <div class="actions">
            <button class="btn" type="submit">Simpan Setting</button>
        </div>
    </form>
</div>
@endsection
