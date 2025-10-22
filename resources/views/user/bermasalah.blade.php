@extends('layouts.user')

@section('title', 'Pengaduan')

@section('content')
<div class="pengaduan-card">
    <div class="pengaduan-header">
        <h4>Form Pengaduan Mahasiswa</h4>
        <p>Silakan isi form di bawah ini untuk menyampaikan pengaduan Anda. Data akan diproses oleh pihak admin dan Anda akan menerima kode tiket untuk melacak status pengaduan.</p>
    </div>
    <div class="pengaduan-body">
        <form action="{{ route('user.bermasalah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM Anda" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" min="1" placeholder="Contoh: 5" value="{{ old('semester') }}" required>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="jenis_masalah" class="form-label">Jenis Masalah</label>
                    <select id="jenis_masalah" name="jenis_masalah" class="form-select @error('jenis_masalah') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Masalah --</option>
                        <option value="Akademik" {{ old('jenis_masalah') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Keuangan" {{ old('jenis_masalah') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="Disiplin" {{ old('jenis_masalah') == 'Disiplin' ? 'selected' : '' }}>Disiplin</option>
                        <option value="Administrasi" {{ old('jenis_masalah') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="Lainnya" {{ old('jenis_masalah') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_masalah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="keterangan" class="form-label">Keterangan / Deskripsi Masalah</label>
                    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" placeholder="Jelaskan masalah yang ingin Anda laporkan" required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="kontak_pengadu" class="form-label">Kontak (Email / No HP)</label>
                    <input type="text" id="kontak_pengadu" name="kontak_pengadu" class="form-control @error('kontak_pengadu') is-invalid @enderror" placeholder="Opsional - untuk dihubungi admin" value="{{ old('kontak_pengadu') }}">
                    @error('kontak_pengadu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="lampiran" class="form-label">Lampiran Bukti (opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror">
                    @error('lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="anonim" name="anonim" class="form-check-input">
                        <label for="anonim" class="form-check-label">Kirim sebagai anonim (tanpa identitas)</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="persetujuan" name="persetujuan" class="form-check-input @error('persetujuan') is-invalid @enderror" required>
                        <label for="persetujuan" class="form-check-label">Saya menyetujui bahwa data yang saya kirim adalah benar.</label>
                        @error('persetujuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-submit-pengaduan">Kirim Pengaduan</button>
            </div>
        </form>
    </div>
</div>
@endsection