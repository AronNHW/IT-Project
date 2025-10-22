@csrf

<div class="form-group">
    <label for="nim">NIM</label>
    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM Anda" value="{{ old('nim', $pengaduan->nim ?? '') }}" {{ isset($pengaduan) && $pengaduan->anonim ? 'disabled' : '' }} required>
    @error('nim')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="nama">Nama Lengkap</label>
    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama', $pengaduan->nama ?? '') }}" {{ isset($pengaduan) && $pengaduan->anonim ? 'disabled' : '' }} required>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="semester">Semester</label>
    <input type="number" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" min="1" placeholder="Contoh: 5" value="{{ old('semester', $pengaduan->semester ?? '') }}" {{ isset($pengaduan) && $pengaduan->anonim ? 'disabled' : '' }} required>
    @error('semester')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="jenis_masalah">Jenis Masalah</label>
    <select id="jenis_masalah" name="jenis_masalah" class="form-control @error('jenis_masalah') is-invalid @enderror" required>
        <option value="">-- Pilih Jenis Masalah --</option>
        <option value="Akademik" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
        <option value="Keuangan" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
        <option value="Disiplin" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
        <option value="Administrasi" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
        <option value="Lainnya" {{ old('jenis_masalah', $pengaduan->jenis_masalah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
    </select>
    @error('jenis_masalah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="keterangan">Keterangan / Deskripsi Masalah</label>
    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" placeholder="Jelaskan masalah yang ingin Anda laporkan" required>{{ old('keterangan', $pengaduan->keterangan ?? '') }}</textarea>
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="kontak_pengadu">Kontak (Email / No HP)</label>
    <input type="text" id="kontak_pengadu" name="kontak_pengadu" class="form-control @error('kontak_pengadu') is-invalid @enderror" placeholder="Opsional - untuk dihubungi admin" value="{{ old('kontak_pengadu', $pengaduan->kontak_pengadu ?? '') }}">
    @error('kontak_pengadu')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="pending" {{ old('status', $pengaduan->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="ditanggapi" {{ old('status', $pengaduan->status ?? '') == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
        <option value="selesai" {{ old('status', $pengaduan->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</div>