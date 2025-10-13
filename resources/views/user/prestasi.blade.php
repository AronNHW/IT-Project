@extends('layouts.user')

@section('content')
    <h1 class="my-4">Data Prestasi Mahasiswa</h1>

    <!-- Filter and Search Form -->
    <form method="GET" action="{{ route('user.prestasi') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama/NIM..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="periode" class="form-control">
                    <option value="">Semua Periode</option>
                    @foreach ($periodes as $periode)
                        <option value="{{ $periode->periode }}" {{ request('periode') == $periode->periode ? 'selected' : '' }}>
                            {{ $periode->periode }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="sistem_kuliah" class="form-control">
                    <option value="">Semua Sistem Kuliah</option>
                    @foreach ($sistemKuliahs as $sistem)
                        <option value="{{ $sistem->sistem_kuliah }}" {{ request('sistem_kuliah') == $sistem->sistem_kuliah ? 'selected' : '' }}>
                            {{ $sistem->sistem_kuliah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('user.prestasi') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Sistem Kuliah</th>
                        <th>IPK</th>
                        <th>Periode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestasis as $prestasi)
                        <tr>
                            <td>{{ $prestasi->nim }}</td>
                            <td>{{ $prestasi->nama }}</td>
                            <td>{{ $prestasi->sistem_kuliah }}</td>
                            <td>{{ $prestasi->ipk }}</td>
                            <td>{{ $prestasi->periode }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $prestasis->links() }}
        </div>
    </div>
@endsection