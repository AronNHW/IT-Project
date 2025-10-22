@extends('layouts.user')

@section('title', 'Data Prestasi Mahasiswa')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Data Prestasi Mahasiswa</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('user.prestasi') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama, NIM, atau Kegiatan..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="tingkat_kegiatan" class="form-select">
                            <option value="">Semua Tingkat</option>
                            @foreach ($tingkat_kegiatans as $tingkat)
                                <option value="{{ $tingkat }}" {{ request('tingkat_kegiatan') == $tingkat ? 'selected' : '' }}>
                                    {{ $tingkat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="keterangan" class="form-select">
                            <option value="">Semua Keterangan</option>
                            @foreach ($keterangans as $keterangan)
                                <option value="{{ $keterangan }}" {{ request('keterangan') == $keterangan ? 'selected' : '' }}>
                                    {{ $keterangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>IPK</th>
                        <th>Skor</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu</th>
                        <th>Tingkat</th>
                        <th>Prestasi Dicapai</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestasis as $prestasi)
                        <tr>
                            <td>{{ $prestasi->nim }}</td>
                            <td>{{ $prestasi->nama_mahasiswa }}</td>
                            <td>{{ number_format($prestasi->ipk, 2) }}</td>
                            <td>{{ number_format($prestasi->total_skor, 2) }}</td>
                            <td>{{ $prestasi->nama_kegiatan }}</td>
                            <td>{{ \Carbon\Carbon::parse($prestasi->waktu_penyelenggaraan)->translatedFormat('d F Y') }}</td>
                            <td>{{ $prestasi->tingkat_kegiatan }}</td>
                            <td>{{ $prestasi->prestasi_yang_dicapai }}</td>
                            <td>{{ $prestasi->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">Tidak ada data prestasi yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($prestasis->hasPages())
            <div class="card-footer">
                {{ $prestasis->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
