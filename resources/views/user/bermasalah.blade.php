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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan NIM Anda" required>
                </div>

                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="col-md-6">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" id="semester" name="semester" class="form-control" min="1" placeholder="Contoh: 5" required>
                </div>

                <div class="col-md-6">
                    <label for="jenis_masalah" class="form-label">Jenis Masalah</label>
                    <select id="jenis_masalah" name="jenis_masalah" class="form-select" required>
                        <option value="">-- Pilih Jenis Masalah --</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="Disiplin">Disiplin</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="keterangan" class="form-label">Keterangan / Deskripsi Masalah</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Jelaskan masalah yang ingin Anda laporkan" required></textarea>
                </div>

                <div class="col-12">
                    <label for="kontak_pengadu" class="form-label">Kontak (Email / No HP)</label>
                    <input type="text" id="kontak_pengadu" name="kontak_pengadu" class="form-control" placeholder="Opsional - untuk dihubungi admin">
                </div>

                <div class="col-12">
                    <label for="lampiran" class="form-label">Lampiran Bukti (opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control">
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="anonim" name="anonim" class="form-check-input">
                        <label for="anonim" class="form-check-label">Kirim sebagai anonim (tanpa identitas)</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="persetujuan" name="persetujuan" class="form-check-input" required>
                        <label for="persetujuan" class="form-check-label">Saya menyetujui bahwa data yang saya kirim adalah benar.</label>
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