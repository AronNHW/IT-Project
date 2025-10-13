@extends('layouts.admin')

@section('title', 'Data Mahasiswa Bermasalah')

@push('styles')
<style>
    #bermasalah-page {
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
    .modal-content { background-color: #fefefe; margin: 10% auto; padding: 24px; border-radius: 0.75rem; width: 80%; max-width: 600px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1rem; }
    .modal-title { font-size: 1.25rem; font-weight: 600; }
    .modal-close { font-size: 1.5rem; font-weight: 700; color: #000; cursor: pointer; border: none; background: none; }
    .modal-body { font-size: 1rem; }
    .modal-footer { margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem; }
    .info-grid { display: grid; grid-template-columns: 150px auto; gap: 0.5rem; }
</style>
@endpush

@section('content')
<div id="bermasalah-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Data Mahasiswa Bermasalah</h1>
        <a href="{{ route('admin.mahasiswa-bermasalah.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="filter-bar">
        <form action="{{ route('admin.mahasiswa-bermasalah.index') }}" method="GET" class="d-flex gap-3">
            <input type="text" name="search" placeholder="Cari NIM, Nama..." value="{{ request('search') }}">
            <select name="jenis_masalah">
                <option value="">Semua Jenis Masalah</option>
                <option value="Akademik" {{ request('jenis_masalah') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                <option value="Keuangan" {{ request('jenis_masalah') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                <option value="Disiplin" {{ request('jenis_masalah') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
                <option value="Administrasi" {{ request('jenis_masalah') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                <option value="Lainnya" {{ request('jenis_masalah') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ditanggapi" {{ request('status') == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Masalah</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduans as $pengaduan)
                    <tr>
                        <td>{{ $pengaduan->nim ?? 'Anonim' }}</td>
                        <td>{{ $pengaduan->nama ?? 'Anonim' }}</td>
                        <td>{{ $pengaduan->jenis_masalah }}</td>
                        <td>{{ Str::limit($pengaduan->keterangan, 50) }}</td>
                        <td>{{ $pengaduan->status }}</td>
                        <td class="action-btns">
                            <button type="button" class="btn btn-primary view-btn" data-pengaduan='{{ json_encode($pengaduan) }}'>Lihat</button>
                            <a href="{{ route('admin.mahasiswa-bermasalah.edit', $pengaduan->id) }}" class="btn btn-edit">Edit</a>
                            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $pengaduan->id }}">Hapus</button>
                            <form id="delete-form-{{ $pengaduan->id }}" action="{{ route('admin.mahasiswa-bermasalah.destroy', $pengaduan->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">Tidak ada data pengaduan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengaduans->links() }}
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengaduan</h5>
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-grid">
                    <strong>Kode Tiket:</strong> <span id="view_kode_tiket"></span>
                    <strong>NIM:</strong> <span id="view_nim"></span>
                    <strong>Nama:</strong> <span id="view_nama"></span>
                    <strong>Semester:</strong> <span id="view_semester"></span>
                    <strong>Jenis Masalah:</strong> <span id="view_jenis_masalah"></span>
                    <strong>Keterangan:</strong> <span id="view_keterangan"></span>
                    <strong>Kontak:</strong> <span id="view_kontak_pengadu"></span>
                    <strong>Lampiran:</strong> <span id="view_lampiran"></span>
                    <strong>Status:</strong> <span id="view_status"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <h3>Konfirmasi Hapus</h3>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="modal-footer">
                <button type="button" id="confirmDelete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewModal = document.getElementById('viewModal');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    let formToSubmit;

    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function () {
            const pengaduan = JSON.parse(this.dataset.pengaduan);
            document.getElementById('view_kode_tiket').textContent = pengaduan.kode_tiket;
            document.getElementById('view_nim').textContent = pengaduan.nim ?? 'Anonim';
            document.getElementById('view_nama').textContent = pengaduan.nama ?? 'Anonim';
            document.getElementById('view_semester').textContent = pengaduan.semester ?? 'N/A';
            document.getElementById('view_jenis_masalah').textContent = pengaduan.jenis_masalah;
            document.getElementById('view_keterangan').textContent = pengaduan.keterangan;
            document.getElementById('view_kontak_pengadu').textContent = pengaduan.kontak_pengadu ?? 'N/A';
            document.getElementById('view_lampiran').innerHTML = pengaduan.lampiran ? `<a href="/storage/${pengaduan.lampiran}" target="_blank">Lihat Lampiran</a>` : 'Tidak ada';
            document.getElementById('view_status').textContent = pengaduan.status;
            viewModal.style.display = 'block';
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const pengaduanId = this.dataset.id;
            formToSubmit = document.getElementById(`delete-form-${pengaduanId}`);
            deleteModal.style.display = 'block';
        });
    });



    confirmDelete.addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', () => {
            viewModal.style.display = 'none';
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target == viewModal) {
            viewModal.style.display = 'none';
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
</script>
@endpush