@extends('layouts.admin')

@section('title', 'Kelola Calon Anggota Tahap 1')

@push('styles')
<style>
    #calon-anggota-page {
        --primary-color: #2563eb;
        --primary-hover-color: #1d4ed8;
        --danger-color: #ef4444;
        --danger-hover-color: #dc2626;
        --light-gray: #F3F4F6;
        --border-color: #E5E7EB;
        --text-dark: #1F2937;
        --text-light: #6B7280;
    }

    #calon-anggota-page h1 { font-size: 1.875rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1.5rem; }
    #calon-anggota-page .data-table-container { background-color: #fff; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; }
    #calon-anggota-page .data-table { width: 100%; border-collapse: collapse; }
    #calon-anggota-page .data-table th, #calon-anggota-page .data-table td { padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border-color); }
    #calon-anggota-page .data-table thead th { background-color: var(--light-gray); font-weight: 600; color: var(--text-light); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    #calon-anggota-page .data-table tbody tr:hover { background-color: #F9FAFB; }
    #calon-anggota-page .data-table td { color: var(--text-dark); }
    #calon-anggota-page .data-table .empty-row td { text-align: center; padding: 3rem; color: var(--text-light); }
    #calon-anggota-page .action-btns { display: flex; gap: 0.5rem; }
    #calon-anggota-page .btn-lihat { background: #3b82f6; color: #fff; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-weight: 600; border: 0; cursor: pointer; }
    #calon-anggota-page .btn-hapus { background: #ef4444; color: #fff; padding: 6px 10px; border-radius: 6px; border: 0; font-weight: 600; cursor: pointer; }

    .status-badge {
        display: inline-block;
        padding: 0.4em 0.8em;
        font-size: 0.85em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }

    .status-diterima {
        color: #fff;
        background-color: #28a745; /* Green */
    }

    .status-ditolak {
        color: #fff;
        background-color: #dc3545; /* Red */
    }

    .status-gagal-wawancara {
        color: #fff;
        background-color: #6c757d; /* Gray */
    }

    .status-lulus-wawancara {
        color: #fff;
        background-color: #17a2b8; /* Info Blue */
    }

    /* Custom Modal Styles */
    #calon-anggota-page .custom-modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5); }
    #calon-anggota-page .custom-modal-content { background-color: #fefefe; margin: 5% auto; padding: 24px; border: 1px solid #888; width: 80%; max-width: 600px; border-radius: 12px; position: relative; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    #calon-anggota-page .custom-modal-close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    #calon-anggota-page .custom-modal-close:hover, #calon-anggota-page .custom-modal-close:focus { color: black; text-decoration: none; }
    #calon-anggota-page .modal-body-content { padding-top: 20px; }
    #calon-anggota-page .candidate-info {
        display: grid;
        grid-template-columns: 160px auto;
        gap: 0 1rem;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        align-items: start;
    }
    #calon-anggota-page .candidate-info strong {
        font-weight: 600;
        color: #4b5563;
        position: relative;
    }
    #calon-anggota-page .candidate-info strong::after {
        content: ':';
        position: absolute;
        right: 0;
    }
    #calon-anggota-page .modal-footer-buttons { text-align: right; margin-top: 20px; }
    #calon-anggota-page .modal-footer-buttons button { margin-left: 10px; padding: 10px 18px; border-radius: 8px; cursor: pointer; border: none; font-weight: 600; }
    #calon-anggota-page .btn-danger { background-color: var(--danger-color); color: white; }
    #calon-anggota-page .btn-success { background-color: #28a745; color: white; }

    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: center; }
    .filter-bar input, .filter-bar select { padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid var(--border-color); }
    .btn { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; }
    .btn-primary { background-color: var(--primary-color); color: #fff; }
    .btn-secondary { background-color: #6c757d; color: #fff; }
</style>
@endpush

@section('content')
<div id="calon-anggota-page">
    <h1>Data Calon Anggota Tahap 1 Hima-TI</h1>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route('admin.calon-anggota-tahap-1.index') }}" method="GET" class="d-flex gap-3">
            <input type="text" name="search" placeholder="Cari Nama atau NIM..." value="{{ request('search') }}">
            
            <select name="divisi_id">
                <option value="">Semua Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->id }}" {{ request('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama_divisi }}</option>
                @endforeach
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                @foreach($statuses as $key => $value)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.calon-anggota-tahap-1.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <section class="data-table-container">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Nomor HP</th>
                    <th>Divisi Tujuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidates as $candidate)
                    <tr>
                        <td>
                            @if($candidate->gambar)
                                <img src="{{ asset('storage/' . $candidate->gambar) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div style="width: 50px; height: 50px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td>{{ $candidate->name }}</td>
                        <td>{{ $candidate->nim ?? 'N/A' }}</td>
                        <td>{{ $candidate->hp ?? 'N/A' }}</td>
                        <td>{{ $candidate->divisi->nama_divisi ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge 
                                @if($candidate->status == 'diterima') status-diterima
                                @elseif($candidate->status == 'ditolak') status-ditolak
                                @elseif($candidate->status == 'Gagal Wawancara') status-gagal-wawancara
                                @elseif($candidate->status == 'Lulus Wawancara') status-lulus-wawancara
                                @endif">
                                {{ $statuses[$candidate->status] ?? $candidate->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button type="button" class="btn-lihat" data-candidate='{{ json_encode($candidate) }}' data-divisi='{{ $candidate->divisi->nama_divisi ?? "N/A" }}' data-status='{{ $statuses[$candidate->status] ?? $candidate->status }}'>Lihat</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="7" class="text-center">Tidak ada data calon anggota tahap 1.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="mt-4">
        {{ $candidates->links() }}
    </div>

    <!-- Modals -->
    <div id="viewModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close">&times;</span>
            <h2>Detail Calon Anggota Tahap 1</h2>
            <div class="modal-body-content">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <img id="view_gambar" src="" alt="Foto Calon Anggota" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px; margin: auto;">
                </div>
                <div class="candidate-info"><strong>Nama</strong> <span id="view_name"></span></div>
                <div class="candidate-info"><strong>NIM</strong> <span id="view_nim"></span></div>
                <div class="candidate-info"><strong>Nomor HP</strong> <span id="view_hp"></span></div>
                <div class="candidate-info"><strong>Divisi Tujuan</strong> <span id="view_divisi"></span></div>
                <div class="candidate-info"><strong>Alasan Bergabung</strong> <span id="view_alasan_bergabung"></span></div>
                <div class="candidate-info"><strong>Status</strong> <span id="view_status"></span></div>
            </div>
            <div class="modal-footer-buttons">
                <form id="deleteFormInModal" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const page = document.getElementById('calon-anggota-page');
    if (!page) return;

    const viewModal = page.querySelector('#viewModal');
    const modals = [viewModal];
    let currentCandidateId = null;

    // Open View Modal
    page.querySelectorAll('.btn-lihat').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = JSON.parse(btn.dataset.candidate);
            currentCandidateId = data.id;

            const imageView = page.querySelector('#view_gambar');
            if (data.gambar) {
                imageView.src = `{{ asset('storage') }}/${data.gambar}`;
                imageView.style.display = 'block';
            } else {
                imageView.src = '';
                imageView.style.display = 'none';
            }

            page.querySelector('#view_name').textContent = data.name;
            page.querySelector('#view_nim').textContent = data.nim;
            page.querySelector('#view_hp').textContent = data.hp;
            page.querySelector('#view_divisi').textContent = btn.dataset.divisi;
            page.querySelector('#view_alasan_bergabung').textContent = data.alasan;
            page.querySelector('#view_status').textContent = btn.dataset.status;

            const deleteForm = document.getElementById('deleteFormInModal');
            if (deleteForm) {
                const action = "{{ route('admin.calon-anggota.destroy', ':id') }}".replace(':id', currentCandidateId);
                deleteForm.action = action;
            }

            viewModal.style.display = 'block';
        });
    });

    // Close Modal Logic
    page.querySelectorAll('.custom-modal-close').forEach(btn => {
        btn.addEventListener('click', () => modals.forEach(m => m.style.display = 'none'));
    });

    window.addEventListener('click', (event) => {
        modals.forEach(m => {
            if (event.target == m) m.style.display = 'none';
        });
    });
});
</script>
@endpush