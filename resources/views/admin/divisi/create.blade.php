@extends('layouts.admin')

@section('title', 'Tambah Divisi')

@section('content')
<div id="divisi-create-page">
    <h1>Tambah Divisi</h1>

    <form action="{{ route('admin.divisi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama_divisi">Nama Divisi</label>
            <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="photo_divisi">Photo Divisi <span style="color: red;">*</span></label>
            <input type="file" id="photo_divisi" name="photo_divisi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@push('styles')
<style>
#divisi-create-page .form-group {
    margin-bottom: 1.5rem;
}
#divisi-create-page .form-control {
    width: 100%;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
}
#divisi-create-page .btn-primary {
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
    CKEDITOR.replace('deskripsi');
</script>
@endpush
