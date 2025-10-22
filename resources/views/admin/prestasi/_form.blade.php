@csrf
<div class="form-group">
    <label for="nim">NIM</label>
    <input type="text" name="nim" id="nim" value="{{ old('nim', $prestasi->nim ?? '') }}" required>
    @error('nim') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="nama_mahasiswa">Nama Mahasiswa</label>
    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="{{ old('nama_mahasiswa', $prestasi->nama_mahasiswa ?? '') }}" required>
    @error('nama_mahasiswa') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="ipk">IPK</label>
    <input type="number" name="ipk" id="ipk" value="{{ old('ipk', $prestasi->ipk ?? '') }}" step="0.01" min="0" max="4" required>
    @error('ipk') <div class="error-message">{{ $message }}</div> @enderror
</div>



<div class="form-group">
    <label for="nama_kegiatan">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $prestasi->nama_kegiatan ?? '') }}" required>
    @error('nama_kegiatan') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="waktu_penyelenggaraan">Waktu Penyelenggaraan</label>
    <input type="date" name="waktu_penyelenggaraan" id="waktu_penyelenggaraan" value="{{ old('waktu_penyelenggaraan', isset($prestasi) ? \Carbon\Carbon::parse($prestasi->waktu_penyelenggaraan)->format('Y-m-d') : '') }}" required>
    @error('waktu_penyelenggaraan') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="tingkat_kegiatan">Tingkat Kegiatan</label>
    <select name="tingkat_kegiatan" id="tingkat_kegiatan" required>
        <option value="">Pilih Tingkat</option>
        @foreach($tingkat_kegiatans as $tingkat)
            <option value="{{ $tingkat }}" {{ old('tingkat_kegiatan', $prestasi->tingkat_kegiatan ?? '') == $tingkat ? 'selected' : '' }}>{{ $tingkat }}</option>
        @endforeach
    </select>
    @error('tingkat_kegiatan') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="prestasi_select">Prestasi yang Dicapai</label>
    <select id="prestasi_select" class="form-control">
        @php
            $prestasiValue = old('prestasi_yang_dicapai', $prestasi->prestasi_yang_dicapai ?? '');
            $options = ['Juara 1', 'Juara 2', 'Juara 3'];
        @endphp
        <option value="Juara 1" @if($prestasiValue == 'Juara 1') selected @endif>Juara 1</option>
        <option value="Juara 2" @if($prestasiValue == 'Juara 2') selected @endif>Juara 2</option>
        <option value="Juara 3" @if($prestasiValue == 'Juara 3') selected @endif>Juara 3</option>
        <option value="Lainnya" @if(!in_array($prestasiValue, $options) && $prestasiValue != '') selected @endif>Lainnya</option>
    </select>
    <input type="text" id="prestasi_text" class="form-control mt-2" style="display: none;" value="{{ $prestasiValue }}">
    <input type="hidden" name="prestasi_yang_dicapai" id="prestasi_hidden" value="{{ $prestasiValue }}">
    @error('prestasi_yang_dicapai') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <select name="keterangan" id="keterangan" required>
        <option value="">Pilih Keterangan</option>
        @foreach($keterangans as $keterangan)
            <option value="{{ $keterangan }}" {{ old('keterangan', $prestasi->keterangan ?? '') == $keterangan ? 'selected' : '' }}>{{ $keterangan }}</option>
        @endforeach
    </select>
    @error('keterangan') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="pembimbing">Pembimbing</label>
    <input type="text" name="pembimbing" id="pembimbing" value="{{ old('pembimbing', $prestasi->pembimbing ?? '') }}">
    @error('pembimbing') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="bukti_prestasi">Bukti Prestasi (Gambar/PDF)</label>
    <input type="file" name="bukti_prestasi" id="bukti_prestasi">
    @if(isset($prestasi) && $prestasi->bukti_prestasi)
        <div class="mt-2">
            <a href="{{ Storage::url($prestasi->bukti_prestasi) }}" target="_blank">Lihat Bukti Saat Ini</a>
        </div>
    @endif
    @error('bukti_prestasi') <div class="error-message">{{ $message }}</div> @enderror
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.prestasi.index') }}" class="btn" style="background-color: #f3f4f6;">Batal</a>
</div>
