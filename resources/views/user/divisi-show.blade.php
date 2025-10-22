@extends('layouts.user')

@section('title', $divisi->nama_divisi)

@section('content')
    <div class="divisi-detail">
        <h1 class="divisi-title">{{ $divisi->nama_divisi }}</h1>
        @if($divisi->photo_divisi)
            <img src="{{ Storage::url($divisi->photo_divisi) }}" alt="{{ $divisi->nama_divisi }}" class="divisi-img">
        @endif
        <div class="divisi-content">
            {!! $divisi->deskripsi !!}
        </div>
    </div>
@endsection

@push('styles')
<style>
.divisi-detail {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    padding: 2rem;
    margin-top: 2rem;
}
.divisi-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.divisi-img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 2rem;
}
.divisi-content p {
    line-height: 1.8;
    color: #374151;
    font-size: 1.125rem;
}
</style>
@endpush
