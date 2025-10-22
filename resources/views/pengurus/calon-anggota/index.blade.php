@extends('layouts.pengurus')

@section('title', 'Kelola Calon Anggota')

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
    #calon-anggota-page .data-table th, #calon-anggota-page .data-table td { padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    #calon-anggota-page .data-table thead th { background-color: var(--light-gray); font-weight: 600; color: var(--text-light); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    #calon-anggota-page .data-table tbody tr:hover { background-color: #F9FAFB; }
    #calon-anggota-page .data-table td { color: var(--text-dark); }
    #calon-anggota-page .data-table .empty-row td { text-align: center; padding: 3rem; color: var(--text-light); }
    #calon-anggota-page .action-btns { display: flex; gap: 0.5rem; align-items: center; }
    #calon-anggota-page .btn-lihat { background: #3b82f6; color: #fff; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-weight: 600; border: 0; cursor: pointer; }
    #calon-anggota-page .btn-hapus { background: #ef4444; color: #fff; padding: 6px 10px; border-radius: 6px; border: 0; font-weight: 600; cursor: pointer; }

    .status-badge { display: inline-block; padding: 0.4em 0.8em; font-size: 0.85em; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: middle; border-radius: 0.375rem; }
    .status-pending { color: #212529; background-color: #ffc107; }
    .status-diterima { color: #fff; background-color: #28a745; }
    .status-ditolak { color: #fff; background-color: #dc3545; }

    #calon-anggota-page .custom-modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5); }
    #calon-anggota-page .custom-modal-content { background-color: #fefefe; margin: 5% auto; padding: 24px; border: 1px solid #888; width: 80%; max-width: 600px; border-radius: 12px; position: relative; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    #calon-anggota-page .custom-modal-close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    #calon-anggota-page .custom-modal-close:hover, #calon-anggota-page .custom-modal-close:focus { color: black; text-decoration: none; }
    #calon-anggota-page .modal-body-content { padding-top: 20px; }
    #calon-anggota-page .candidate-info { display: flex; margin-bottom: 12px; font-size: 1rem; }
    #calon-anggota-page .candidate-info strong { width: 120px; font-weight: 600; color: #4b5563; }
    #calon-anggota-page .modal-footer-buttons { text-align: right; margin-top: 20px; }
    #calon-anggota-page .modal-footer-buttons button { margin-left: 10px; padding: 10px 18px; border-radius: 8px; cursor: pointer; border: none; font-weight: 600; }
    #calon-anggota-page .btn-danger { background-color: var(--danger-color); color: white; }
    #calon-anggota-page .btn-success { background-color: #28a745; color: white; }
</style>
@endpush

@section('content')
<div id="calon-anggota-page">
    <h1>Data Calon Anggota Hima-TI</h1>

    @if(session('success'))
        <div class="alert alert-success" style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning" style="background-color: #fffbeb; color: #b45309; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
            {{ session('warning') }}
        </div>
    @endif

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
                            <span class="status-badge status-{{ strtolower($candidate->status) ?: 'pending' }}">
                                {{ $candidate->status ?? 'Menunggu' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button type="button" class="btn-lihat" data-candidate='{{ json_encode($candidate) }}'>Lihat</button>
                                <form action="{{ route('pengurus.calon-anggota.destroy', $candidate->id) }}" method="POST" class="delete-form" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="7" class="text-center">Tidak ada data calon anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <!-- View Modal -->
    <div id="viewModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close">&times;</span>
            <h2>Detail Calon Anggota</h2>
            <div class="modal-body-content">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <img id="view_gambar" src="" alt="Foto Calon Anggota" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px; margin: auto;">
                </div>
                <div class="candidate-info"><strong>Nama:</strong> <span id="view_name"></span></div>
                <div class="candidate-info"><strong>NIM:</strong> <span id="view_nim"></span></div>
                <div class="candidate-info"><strong>Nomor HP:</strong> <span id="view_hp"></span></div>
                <div class="candidate-info"><strong>Divisi Tujuan:</strong> <span id="view_divisi"></span></div>
                <div class="candidate-info"><strong>Alasan:</strong> <span id="view_alasan_bergabung"></span></div>
                <div class="candidate-info"><strong>Status:</strong> <span id="view_status"></span></div>
            </div>
            <div class="modal-footer-buttons">
                <form id="approveForm" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin MENERIMA calon ini? Notifikasi WA akan dikirim.');">
                    @csrf
                    <button type="submit" class="btn-success">Terima</button>
                </form>
                <form id="rejectForm" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin MENOLAK calon ini? Notifikasi WA akan dikirim.');">
                    @csrf
                    <button type="submit" class="btn-danger">Tolak</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="custom-modal">
        <div class="custom-modal-content" style="max-width: 400px;">
            <span class="custom-modal-close">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="modal-footer-buttons">
                <button type="button" id="confirmDeleteBtn" class="btn-danger">Hapus</button>
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
    const deleteModal = page.querySelector('#deleteModal');
    const modals = [viewModal, deleteModal];
    let formToSubmit = null;

    // Open View Modal
    page.querySelectorAll('.btn-lihat').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = JSON.parse(btn.dataset.candidate);

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
            page.querySelector('#view_divisi').textContent = data.divisi ? data.divisi.nama_divisi : 'N/A';
            page.querySelector('#view_alasan_bergabung').textContent = data.alasan_bergabung;
            page.querySelector('#view_status').textContent = data.status;

            const approveForm = page.querySelector('#approveForm');
            const rejectForm = page.querySelector('#rejectForm');
            approveForm.action = `/pengurus/calon-anggota/${data.id}/approve`;
            rejectForm.action = `/pengurus/calon-anggota/${data.id}/reject`;

            viewModal.style.display = 'block';
        });
    });

    // Open Delete Modal
    page.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', () => {
            formToSubmit = btn.closest('.delete-form');
            deleteModal.style.display = 'block';
        });
    });

    // Confirm Delete Action
    page.querySelector('#confirmDeleteBtn').addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
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