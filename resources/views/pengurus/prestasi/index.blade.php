@extends('layouts.pengurus')

@section('title', 'Data Prestasi Mahasiswa')

@push('styles')
<style>
    #prestasi-page {
        --primary-color: #2563eb;
        --danger-color: #ef4444;
        --success-color: #22c55e;
        --light-gray: #f3f4f6;
        --border-color: #e5e7eb;
        --text-dark: #1f2937;
        --text-light: #6b7280;
    }
    .table-container { background-color: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); overflow: hidden; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 0.875rem; }
    .table thead th { background-color: var(--light-gray); font-weight: 600; color: var(--text-light); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .table tbody tr:hover { background-color: #f9fafb; }
    .action-btns { display: flex; gap: 0.5rem; }
    .btn { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .btn-primary { background-color: var(--primary-color); color: #fff; }
    .btn-edit { background-color: #f97316; color: #fff; }
    .btn-danger { background-color: var(--danger-color); color: #fff; }
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: center; }
    .filter-bar input, .filter-bar select { padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid var(--border-color); }
    .alert { padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem; }
    .alert-success { background-color: #dcfce7; color: #166534; }
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fefefe; margin: 15% auto; padding: 24px; border-radius: 0.75rem; width: 80%; max-width: 400px; text-align: center; }
    .modal-footer { margin-top: 1.5rem; display: flex; justify-content: center; gap: 1rem; }
</style>
@endpush

@section('content')
<div id="prestasi-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Data Prestasi Mahasiswa</h1>
        <a href="{{ route('pengurus.prestasi.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="filter-bar">
        <form action="{{ route('pengurus.prestasi.index') }}" method="GET" class="d-flex gap-3">
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
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>IPK</th>
                    <th>Skor</th>
                    <th>Kegiatan</th>
                    <th>Waktu</th>
                    <th>Tingkat</th>
                    <th>Prestasi</th>
                    <th>Aksi</th>
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
                        <td class="action-btns">
                            <a href="{{ route('pengurus.prestasi.edit', $prestasi) }}" class="btn btn-edit">Edit</a>
                            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $prestasi->id }}">Hapus</button>
                            <form id="delete-form-{{ $prestasi->id }}" action="{{ route('pengurus.prestasi.destroy', $prestasi) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">Tidak ada data prestasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $prestasis->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Konfirmasi Hapus</h3>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="modal-footer">
                <button type="button" id="cancelDelete" class="btn" style="background-color: var(--light-gray);">Batal</button>
                <button type="button" id="confirmDelete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    const cancelDelete = document.getElementById('cancelDelete');
    const confirmDelete = document.getElementById('confirmDelete');
    let formToSubmit;

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const prestasiId = this.dataset.id;
            formToSubmit = document.getElementById(`delete-form-${prestasiId}`);
            deleteModal.style.display = 'block';
        });
    });

    cancelDelete.addEventListener('click', () => {
        deleteModal.style.display = 'none';
    });

    confirmDelete.addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    window.addEventListener('click', (event) => {
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
</script>
@endpush