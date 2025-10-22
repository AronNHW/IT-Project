@extends('layouts.user')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container">
    <h1>Pengaturan Profil</h1>
    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div class="mb-3">
            <label for="no_wa" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ $user->no_wa }}">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="photo" name="photo">
            @if ($user->photo_url)
                <img src="{{ $user->photo_url }}" alt="Foto Profil" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Peran</label>
            <input type="text" class="form-control" id="role" name="role" value="{{ $user->role }}" disabled>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ url()->previous() }}" class="btn btn-light-green me-2">Cancel</a>
            <button type="submit" class="btn btn-dark-green">Update</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .btn-light-green {
        background-color: #90EE90;
        color: #000;
    }
    .btn-dark-green {
        background-color: #006400;
        color: #fff;
    }
</style>
@endpush
