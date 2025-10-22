@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
    <h1>Tambah Berita</h1>

    <div class="form-container">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul_berita">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" value="{{ old('judul_berita') }}" required>
                @error('judul_berita')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto_berita">Foto Berita <span style="color: red;">*</span></label>
                <input type="file" id="foto_berita" name="foto_berita" accept="image/*" required>
                @error('foto_berita')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>
@endsection

@push('styles')
<style>
.form-container {background-color: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);}
.form-group {margin-bottom: 20px;}
.form-group label {display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563;}
.form-group input[type="text"], .form-group textarea, .form-group input[type="file"] {width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;}
.form-group .error-message {color: #ef4444; font-size: 0.875rem; margin-top: 6px;}
.btn-submit {background-color: #22c55e; color: #fff; padding: 12px 20px; border: 0; border-radius: 8px; font-weight: 600; cursor: pointer;}
</style>
@endpush

@push('scripts')
<script>
    CKEDITOR.replace('deskripsi');
</script>
@endpush
