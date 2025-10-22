@extends('layouts.pengurus')

@section('title', 'Kelola Anggota Hima-TI')

@push('styles')
<style>
    /* Using similar styles from other pages for consistency */
    #anggota-aktif-page h1 { font-size: 1.875rem; font-weight: 700; color: #1F2937; margin-bottom: 1.5rem; }
    .table-container { background-color: #fff; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid #E5E7EB; }
    .data-table thead th { background-color: #F3F4F6; font-weight: 600; color: #6B7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .data-table tbody tr:hover { background-color: #F9FAFB; }
    .action-btns { display: flex; gap: 0.5rem; }
    .btn { padding: 0.4rem 0.8rem; border-radius: 0.375rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; font-size: 0.875rem; }
    .btn-blue { background-color: #3b82f6; color: #fff; }
    .btn-yellow { background-color: #f97316; color: #fff; }
    .btn-red { background-color: #ef4444; color: #fff; }
    .alert-success { background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; }
    /* Modal Styles */
    .custom-modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .custom-modal-content { background-color: #fefefe; margin: 5% auto; padding: 24px; border-radius: 0.75rem; width: 80%; max-width: 600px; position: relative; }
    .custom-modal-close { position: absolute; top: 10px; right: 20px; color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
    .candidate-info { display: grid; grid-template-columns: 160px auto; gap: 0 1rem; margin-bottom: 0.75rem; font-size: 1rem; align-items: start; }
    .candidate-info strong { font-weight: 600; color: #4b5563; position: relative; }
    .candidate-info strong::after { content: ':'; position: absolute; right: 0; }
    .modal-footer { margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem; }
    /* Form styles for modal */
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
    .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; }
</style>
@endpush

@section('content')
<div id="anggota-aktif-page">
    <h1>
        @if(isset($divisi))
            Anggota Aktif Divisi {{ $divisi->nama_divisi }}
        @else
            Anggota Aktif Hima-TI
        @endif
    </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Nomor HP</th>
                    <th>Divisi</th>
                    <th>Bergabung Sejak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>
                            @if($member->gambar)
                                <img src="{{ asset('storage/' . $member->gambar) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div style="width: 50px; height: 50px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->nim ?? 'N/A' }}</td>
                        <td>{{ $member->hp ?? 'N/A' }}</td>
                        <td>{{ $member->divisi->nama_divisi ?? 'N/A' }}</td>
                        <td>{{ $member->updated_at->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <button type="button" class="btn btn-blue view-btn" data-member='{{ json_encode($member) }}'>Lihat</button>
                                <button type="button" class="btn btn-yellow edit-btn" data-member='{{ json_encode($member) }}' data-update-url="{{ route('pengurus.anggota.update', $member->id) }}">Edit</button>
                                <button type="button" class="btn btn-red delete-btn" data-id="{{ $member->id }}">Hapus</button>
                                <form id="delete-form-{{ $member->id }}" action="{{ route('pengurus.anggota.destroy', $member->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem;">Belum ada anggota aktif.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div style="margin-top: 1.5rem;">
        {{ $members->links() }}
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-close view-close">&times;</span>
        <h2>Detail Anggota</h2>
        <div class="modal-body-content" style="padding-top: 20px;">
            <div style="text-align: center; margin-bottom: 1rem;">
                <img id="view_gambar" src="" alt="Foto Anggota" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px; margin: auto;">
            </div>
            <div class="candidate-info"><strong>Nama</strong> <span id="view_name"></span></div>
            <div class="candidate-info"><strong>NIM</strong> <span id="view_nim"></span></div>
            <div class="candidate-info"><strong>Nomor HP</strong> <span id="view_hp"></span></div>
            <div class="candidate-info"><strong>Divisi</strong> <span id="view_divisi"></span></div>
            <div class="candidate-info"><strong>Alasan Bergabung</strong> <span id="view_alasan_bergabung"></span></div>
            <div class="candidate-info"><strong>Status</strong> <span id="view_status"></span></div>
            <div class="candidate-info"><strong>Bergabung Sejak</strong> <span id="view_joined_at"></span></div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-close edit-close">&times;</span>
        <h2>Edit Data Anggota</h2>
        <form id="editForm" method="POST" style="margin-top: 2rem;">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_name">Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            <div class="form-group">
                <label for="edit_nim">NIM</label>
                <input type="text" name="nim" id="edit_nim" required>
            </div>
            <div class="form-group">
                <label for="edit_hp">Nomor HP</label>
                <input type="text" name="hp" id="edit_hp" required>
            </div>
            <div class="form-group">
                <label for="edit_divisi">Divisi</label>
                <select id="edit_divisi" name="divisi_id" required>
                    @foreach($semua_divisi as $div)
                        <option value="{{ $div->id }}">{{ $div->nama_divisi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn edit-close" style="background-color: #f3f4f6;">Batal</button>
                <button type="submit" class="btn btn-blue">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="custom-modal">
    <div class="custom-modal-content" style="max-width: 400px; text-align: center;">
        <span class="custom-modal-close delete-close">&times;</span>
        <h2>Konfirmasi Hapus</h2>
        <p>Apakah Anda yakin ingin menghapus data anggota ini?</p>
        <div class="modal-footer">
            <button type="button" id="confirmDeleteBtn" class="btn btn-red">Hapus</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewModal = document.getElementById('viewModal');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    let deleteFormToSubmit;

    // View Modal Logic
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function () {
            const member = JSON.parse(this.dataset.member);

            const imageView = document.getElementById('view_gambar');
            if (member.gambar) {
                imageView.src = `{{ asset('storage') }}/${member.gambar}`;
                imageView.style.display = 'block';
            } else {
                imageView.src = '';
                imageView.style.display = 'none';
            }

            document.getElementById('view_name').textContent = member.name;
            document.getElementById('view_nim').textContent = member.nim;
            document.getElementById('view_hp').textContent = member.hp;
            document.getElementById('view_divisi').textContent = member.divisi ? member.divisi.nama_divisi : 'N/A';
            document.getElementById('view_alasan_bergabung').textContent = member.alasan_bergabung;
            document.getElementById('view_status').textContent = member.status;
            document.getElementById('view_joined_at').textContent = new Date(member.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            viewModal.style.display = 'block';
        });
    });

    // Edit Modal Logic
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const member = JSON.parse(this.dataset.member);
            const updateUrl = this.dataset.updateUrl;

            document.getElementById('editForm').action = updateUrl;
            document.getElementById('edit_name').value = member.name;
            document.getElementById('edit_nim').value = member.nim;
            document.getElementById('edit_hp').value = member.hp;
            document.getElementById('edit_divisi').value = member.divisi_id;
            
            editModal.style.display = 'block';
        });
    });

    // Delete Modal Logic
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const memberId = this.dataset.id;
            deleteFormToSubmit = document.getElementById(`delete-form-${memberId}`);
            deleteModal.style.display = 'block';
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    });

    // Close Modals
    function closeModal(modal) {
        if(modal) modal.style.display = 'none';
    }
    document.querySelectorAll('.view-close').forEach(el => el.addEventListener('click', () => closeModal(viewModal)));
    document.querySelectorAll('.edit-close').forEach(el => el.addEventListener('click', () => closeModal(editModal)));
    document.querySelectorAll('.delete-close').forEach(el => el.addEventListener('click', () => closeModal(deleteModal)));
    window.addEventListener('click', (event) => {
        if (event.target == viewModal) closeModal(viewModal);
        if (event.target == editModal) closeModal(editModal);
        if (event.target == deleteModal) closeModal(deleteModal);
    });
});
</script>
@endpush