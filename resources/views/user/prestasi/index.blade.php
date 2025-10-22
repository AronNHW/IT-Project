@extends('layouts.user') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Data Prestasi')

@push('styles')
<style>
    #prestasi-page { padding: 2rem; }
    .table-container { background-color: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); overflow: hidden; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem; }
    .table thead th { background-color: #f3f4f6; font-weight: 600; color: #6b7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f9fafb; }
    .btn { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .btn-primary { background-color: #2563eb; color: #fff; }
    .filter-bar { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; align-items: center; }
    .filter-bar input, .filter-bar select { padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid #e5e7eb; }
</style>
@endpush

@section('content')
<div id="prestasi-page">
    <h1 class="mb-4" style="font-size: 1.875rem; font-weight: 700;">Data Prestasi</h1>

    <div class="filter-bar">
        <form action="{{ route('user.prestasi') }}" method="GET" class="d-flex flex-wrap gap-3">
            <input type="text" name="search" placeholder="Cari NIM, Nama, Kegiatan..." value="{{ request('search') }}">
            <select name="tingkat_kegiatan">
                <option value="">Semua Tingkat</option>
                @foreach($tingkat_kegiatans as $tingkat)
                    <option value="{{ $tingkat }}" {{ request('tingkat_kegiatan') == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
                @endforeach
            </select>
            <select name="keterangan">
                <option value="">Semua Keterangan</option>
                @foreach($keterangans as $keterangan)
                    <option value="{{ $keterangan }}" {{ request('keterangan') == $keterangan ? 'selected' : '' }}>{{ $keterangan }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('user.prestasi') }}" class="btn" style="background-color: #6b7280; color: #fff;">Reset</a>
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>IPK</th>
                    <th>Nama Kegiatan</th>
                    <th>Waktu</th>
                    <th>Tingkat</th>
                    <th>Prestasi</th>
                    <th>Pembimbing</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prestasis as $prestasi)
                    <tr>
                        <td>{{ $prestasi->nim }}</td>
                        <td>{{ $prestasi->nama_mahasiswa }}</td>
                        <td>{{ number_format($prestasi->ipk, 2) }}</td>
                        <td>{{ $prestasi->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($prestasi->waktu_penyelenggaraan)->translatedFormat('d F Y') }}</td>
                        <td>{{ $prestasi->tingkat_kegiatan }}</td>
                        <td>{{ $prestasi->prestasi_yang_dicapai }}</td>
                        <td>{{ $prestasi->pembimbing ?? '-' }}</td>
                        <td>
                            @if($prestasi->bukti_prestasi)
                                <a href="{{ Storage::url($prestasi->bukti_prestasi) }}" target="_blank" class="btn btn-primary">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 3rem 0;">Tidak ada data prestasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $prestasis->links() }}
    </div>
</div>
@endsection
