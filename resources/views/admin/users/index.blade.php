@extends('layouts.admin')
@section('title','Kelola Pengguna')

@push('styles')
<style>
.btn-green{background:#22c55e;color:#fff;padding:8px 14px;border-radius:8px;font-weight:600;text-decoration:none}
.btn-blue{background:#3b82f6;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;font-weight:600; border: none; cursor: pointer;}
.btn-yellow{background:#eab308;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;font-weight:600; border: none; cursor: pointer;}
.btn-red{background:#ef4444;color:#fff;padding:6px 10px;border-radius:6px;border:0;font-weight:600;cursor:pointer}
.data-table{width:100%;border-collapse:collapse}
.data-table th,.data-table td{border:1px solid #e5e7eb;padding:8px 12px; vertical-align: middle;}
.data-table th{background:#f9fafb}
.custom-modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.5)}
.custom-modal-content{background-color:#fefefe;margin:10% auto;padding:20px;border:1px solid #888;width:80%;max-width:600px;border-radius:8px;position:relative}
.custom-modal-close{color:#aaa;float:right;font-size:28px;font-weight:bold;cursor:pointer}
.modal-footer-buttons{text-align:right;margin-top:20px;}
.modal-footer-buttons button{margin-left:10px;padding:8px 15px;border-radius:6px;cursor:pointer;border:none;font-weight:500;}
.btn-danger{background-color:#dc3545;color:white;}

/* Form styling from previous turn for modals */
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; }
.form-control { display: block; width: 100%; padding: .75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
.form-control:focus { color: #495057; background-color: #fff; border-color: #80bdff; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
.btn-primary { color: #fff; background-color: #007bff; border-color: #007bff; }
</style>
@endpush

@section('content')
  <h1>Kelola Pengguna</h1>

  @if(session('success'))
      <div class="alert alert-success" style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
          {{ session('success') }}
      </div>
  @endif
  @if($errors->any())
      <div class="alert alert-danger" style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
          <ul class="mb-0" style="padding-left: 1.2rem;">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

 <section class="data-table-container">
  <table class="data-table">
    <thead>
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Email</th>
        <th>No. WA</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $user)
        <tr>
          <td><img src="{{ $user->photo_url ?? 'https://i.pravatar.cc/40' }}" alt="Photo" style="width: 40px; height: 40px; border-radius: 50%;"></td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->no_wa ?? 'N/A' }}</td>
          <td>{{ strtoupper($user->role) }}</td>
          <td>
            <div style="display: flex; gap: 6px;">
                <button class="btn-blue btn-lihat" data-id="{{ $user->id }}">Lihat</button>
                <button class="btn-yellow btn-edit" data-id="{{ $user->id }}">Edit</button>
                <button class="btn-red btn-hapus" data-id="{{ $user->id }}">Hapus</button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center; color:#888; padding:20px;">
            Belum ada data user
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top: 1rem;">
    {{ $users->links() }}
  </div>
</section>

<!-- View Modal -->
<div id="viewModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="custom-modal-close">&times;</span>
    <h2>Detail Pengguna</h2>
    <div style="padding-top:1rem; text-align: center;">
        <img id="view_photo" src="" alt="Photo" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 1rem; object-fit: cover;">
        <p><strong>Nama:</strong> <span id="view_name"></span></p>
        <p><strong>Email:</strong> <span id="view_email"></span></p>
        <p><strong>No. WA:</strong> <span id="view_no_wa"></span></p>
        <p><strong>Role:</strong> <span id="view_role"></span></p>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="custom-modal-close">&times;</span>
    <h2>Edit Pengguna</h2>
    <form id="editForm" method="POST" style="padding-top:1rem;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="edit_name">Nama</label>
            <input type="text" id="edit_name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="edit_email">Email</label>
            <input type="email" id="edit_email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="edit_no_wa">No. WA</label>
            <input type="text" id="edit_no_wa" name="no_wa" class="form-control">
        </div>
        <div class="form-group">
            <label for="edit_role">Role</label>
            <select id="edit_role" name="role" class="form-control" required>
            <option value="admin">Admin</option>
            <option value="pengurus">Pengurus</option>
            <option value="user">User</option>
            </select>
        </div>
        <div class="modal-footer-buttons">
            <button type="submit" class="btn-primary" style="padding: 8px 15px; border: none; border-radius: 6px;">Simpan Perubahan</button>
        </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="custom-modal">
  <div class="custom-modal-content">
    <span class="custom-modal-close">&times;</span>
    <h2>Konfirmasi Hapus</h2>
    <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
    <div class="modal-footer-buttons">
        <form id="deleteForm" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Hapus</button>
        </form>
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
    const modals = [viewModal, editModal, deleteModal];

    // Close modals
    modals.forEach(modal => {
        modal.querySelector('.custom-modal-close').addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });
    window.addEventListener('click', (event) => {
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    });

    // View buttons
    document.querySelectorAll('.btn-lihat').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.id;
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('view_photo').src = user.photo_url || 'https://i.pravatar.cc/100';
                    document.getElementById('view_name').textContent = user.name;
                    document.getElementById('view_email').textContent = user.email;
                    document.getElementById('view_no_wa').textContent = user.no_wa || 'N/A';
                    document.getElementById('view_role').textContent = user.role.toUpperCase();
                    viewModal.style.display = 'block';
                });
        });
    });

    // Edit buttons
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.id;
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('edit_name').value = user.name;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_no_wa').value = user.no_wa;
                    document.getElementById('edit_role').value = user.role;
                    document.getElementById('editForm').action = `/admin/users/${userId}`;
                    editModal.style.display = 'block';
                });
        });
    });

    // Delete buttons
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.dataset.id;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            deleteModal.style.display = 'block';
        });
    });
});
</script>
@endpush