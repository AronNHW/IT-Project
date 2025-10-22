@extends('layouts.admin')

@section('title', 'Edit Divisi')

@section('content')
<div id="divisi-edit-page">
    <h1>Edit Divisi</h1>

    <form action="{{ route('admin.divisi.update', $divisi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_divisi">Nama Divisi</label>
            <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" value="{{ $divisi->nama_divisi }}" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required>{{ $divisi->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label for="photo_divisi">Photo Divisi</label>
            <input type="file" id="photo_divisi" name="photo_divisi" class="form-control">
            @if($divisi->photo_divisi)
                <img src="{{ Storage::url($divisi->photo_divisi) }}" alt="{{ $divisi->nama_divisi }}" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection

@push('styles')
<style>
#divisi-edit-page .form-group {
    margin-bottom: 1.5rem;
}
#divisi-edit-page .form-control {
    width: 100%;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
}
#divisi-edit-page .btn-primary {
    background-color: #2563eb;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('deskripsi');
    });
</script>
@endpush
