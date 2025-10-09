@extends('layouts.admin')

@section('title', 'Kelola Divisi')

@section('content')
<div id="divisi-admin-page">
    <h1>Kelola Divisi</h1>

    <section class="data-table-container" style="margin-top:12px">
        <div style="margin-bottom:12px;">
            <a href="{{ route('admin.divisi.create') }}" class="btn-add">Tambah Divisi</a>
        </div>

        @if(session('success'))
            <div style="padding:10px 12px;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:12px;">
                {{ session('success') }}
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th>PHOTO</th>
                    <th>NAMA DIVISI</th>
                    <th>DESKRIPSI</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($divisis as $divisi)
                    <tr>
                        <td>
                            @if($divisi->photo_divisi)
                                <img src="{{ Storage::url($divisi->photo_divisi) }}" alt="{{ $divisi->nama_divisi }}" width="100">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $divisi->nama_divisi }}</td>
                        <td style="max-width:320px">{{ Str::limit($divisi->deskripsi, 60) }}</td>
                        <td>
                            <a href="{{ route('admin.divisi.show', $divisi) }}" class="btn-blue">Lihat</a>
                            <a href="{{ route('admin.divisi.edit', $divisi) }}" class="btn-yellow">Edit</a>
                            <form action="{{ route('admin.divisi.destroy', $divisi) }}" method="POST" class="delete-form" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-red btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#888;">Belum ada divisi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:12px;">
            {{ $divisis->links() }}
        </div>
    </section>

    <div id="deleteModal" class="custom-modal">
        <div class="custom-modal-content" style="max-width: 400px;">
            <span class="custom-modal-close">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus divisi ini?</p>
            <div class="modal-footer-buttons">
                <button type="button" id="confirmDeleteBtn" class="btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
#divisi-admin-page .btn-add{background:#22c55e;color:#fff;padding:8px 14px;border-radius:8px;font-weight:600;text-decoration:none}
#divisi-admin-page .btn-blue{background:#3b82f6;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;margin-right:6px;font-weight:600; border: none; cursor: pointer;}
#divisi-admin-page .btn-yellow{background:#f59e0b;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;margin-right:6px;font-weight:600; border: none; cursor: pointer;}
#divisi-admin-page .btn-red{background:#ef4444;color:#fff;padding:6px 10px;border-radius:6px;border:0;font-weight:600;cursor:pointer}
#divisi-admin-page .data-table{width:100%;border-collapse:collapse}
#divisi-admin-page .data-table th,#divisi-admin-page .data-table td{border:1px solid #e5e7eb;padding:8px 12px}
#divisi-admin-page .data-table th{background:#f9fafb}
#divisi-admin-page .custom-modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.5)}
#divisi-admin-page .custom-modal-content{background-color:#fefefe;margin:10% auto;padding:20px;border:1px solid #888;width:80%;max-width:600px;border-radius:8px;position:relative}
#divisi-admin-page .custom-modal-close{color:#aaa;float:right;font-size:28px;font-weight:bold;cursor:pointer}
#divisi-admin-page .modal-footer-buttons{text-align:right;margin-top:20px;}
#divisi-admin-page .modal-footer-buttons button{margin-left:10px;padding:8px 15px;border-radius:6px;cursor:pointer;border:none;font-weight:500;}
#divisi-admin-page .btn-danger{background-color:#dc3545;color:white;}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageContainer = document.getElementById('divisi-admin-page');
    if (!pageContainer) return;

    const deleteModal = pageContainer.querySelector('#deleteModal');
    const closeButtons = pageContainer.querySelectorAll('.custom-modal-close');
    let formToSubmit = null;

    pageContainer.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            formToSubmit = this.closest('.delete-form');
            deleteModal.style.display = 'block';
        });
    });

    pageContainer.querySelector('#confirmDeleteBtn').addEventListener('click', function() {
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
