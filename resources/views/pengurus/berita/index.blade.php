@extends('layouts.pengurus')

@section('title', 'Kelola Berita')

@section('content')
    <h1>Kelola Berita</h1>

    <section class="data-table-container" style="margin-top:12px">
        <div style="margin-bottom:12px;">
            <a href="{{ route('pengurus.berita.create') }}" class="btn-green">Tambah Berita</a>
        </div>

        @if(session('ok'))
            <div style="padding:10px 12px;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:12px;">
                {{ session('ok') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>FOTO</th>
                    <th>JUDUL</th>
                    <th>DESKRIPSI</th>
                    <th>WAKTU</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beritas as $berita)
                    <tr>
                        <td><img src="{{ asset('storage/' . $berita->foto_berita) }}" alt="Foto Berita" width="100"></td>
                        <td>{{ $berita->judul_berita }}</td>
                        <td style="max-width:320px">{{ Str::limit(strip_tags(html_entity_decode($berita->deskripsi)), 60) }}</td>
                        <td>{{ $berita->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a class="btn-blue" href="{{ route('pengurus.berita.show', $berita) }}">Lihat</a>
                                <a class="btn-yellow" href="{{ route('pengurus.berita.edit', $berita) }}">Edit</a>
                                <form action="{{ route('pengurus.berita.destroy', $berita) }}" method="POST" class="delete-form" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-red btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#888;">Belum ada berita</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:12px;">
            {{ $beritas->links() }}
        </div>
    </section>

    <div id="deleteModal" class="custom-modal">
        <div class="custom-modal-content" style="max-width: 400px;">
            <span class="custom-modal-close">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus berita ini?</p>
            <div class="modal-footer-buttons">
                <button type="button" id="confirmDeleteBtn" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.btn-green{background:#22c55e;color:#fff;padding:8px 14px;border-radius:8px;font-weight:600;text-decoration:none}
.btn-blue{background:#3b82f6;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;margin-right:6px;font-weight:600}
.btn-yellow{background:#eab308;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;margin-right:6px;font-weight:600}
.btn-red{background:#ef4444;color:#fff;padding:6px 10px;border-radius:6px;border:0;font-weight:600;cursor:pointer}
.data-table{width:100%;border-collapse:collapse}
.data-table th,.data-table td{border:1px solid #e5e7eb;padding:8px 12px}
.data-table th{background:#f9fafb}
.custom-modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.5)}
.custom-modal-content{background-color:#fefefe;margin:10% auto;padding:20px;border:1px solid #888;width:80%;max-width:600px;border-radius:8px;position:relative}
.custom-modal-close{color:#aaa;float:right;font-size:28px;font-weight:bold;cursor:pointer}
.modal-footer-buttons{text-align:right;margin-top:20px;}
.modal-footer-buttons button{margin-left:10px;padding:8px 15px;border-radius:6px;cursor:pointer;border:none;font-weight:500;}
.btn-danger{background-color:#dc3545;color:white;}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    const closeButtons = document.querySelectorAll('.custom-modal-close');
    let formToSubmit = null;

    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            formToSubmit = this.closest('.delete-form');
            deleteModal.style.display = 'block';
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
</script>
@endpush