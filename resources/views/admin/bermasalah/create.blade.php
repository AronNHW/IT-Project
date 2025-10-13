@extends('layouts.admin')

@section('title', 'Tambah Data Pengaduan')

@push('styles')
<style>
    .form-container { max-width: 800px; margin: auto; background-color: #fff; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; }
    .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; }
    .form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; }
    .btn { padding: 0.75rem 1.5rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .btn-primary { background-color: #2563eb; color: #fff; }
</style>
@endpush

@section('content')
    <div class="form-container">
        <h1>Tambah Data Pengaduan</h1>

        <form action="{{ route('admin.mahasiswa-bermasalah.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.bermasalah._form')
        </form>
    </div>
@endsection
