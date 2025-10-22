<aside class="sidebar">
   <div class="sidebar-header">
    <img src="{{ $logo ? asset($logo->value) : asset('assets/image/logo_hima.png') }}" alt="Logo HMTI" class="logo">
    <i class="fas fa-bars menu-icon"></i>
</div>

  <nav class="sidebar-nav">
    <ul>
      <li>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fas fa-home-alt nav-icon"></i><span class="menu-text"> Dashboard </span>
        </a>
      </li>

      <li class="nav-title">Admin</li>

      <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-user nav-icon"></i><span class="menu-text"> Data Pengguna</span></a></li>
      <li>
        <details {{ request()->routeIs(['admin.kelola-anggota-himati.index', 'admin.calon-anggota.index', 'admin.calon-anggota-tahap-1.index', 'admin.calon-anggota-tahap-2.index']) ? 'open' : '' }}>
          <summary><i class="fas fa-users nav-icon"></i><span class="menu-text">Data Anggota Hima-TI</span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            <a href="{{ route('admin.kelola-anggota-himati.index') }}" class="{{ request()->routeIs('admin.kelola-anggota-himati.index') ? 'active' : '' }}">Kelola Anggota</a>
            <a href="{{ route('admin.calon-anggota.index') }}" class="{{ request()->routeIs('admin.calon-anggota.index') ? 'active' : '' }}">Pendaftaran Awal</a>
            <a href="{{ route('admin.calon-anggota-tahap-1.index') }}" class="{{ request()->routeIs('admin.calon-anggota-tahap-1.index') ? 'active' : '' }}">Hasil Tahap 1</a>
            <a href="{{ route('admin.calon-anggota-tahap-2.index') }}" class="{{ request()->routeIs('admin.calon-anggota-tahap-2.index') ? 'active' : '' }}">Hasil Tahap 2</a>
          </nav>
        </details>
      </li>
      <li><a href="{{ route('admin.divisi.index') }}" class="{{ request()->routeIs('admin.divisi.*') ? 'active' : '' }}"><i class="fas fa-sitemap nav-icon"></i><span class="menu-text"> Data Divisi</span></a></li>
      <li>
        <details {{ request()->routeIs('admin.anggota.per.divisi') ? 'open' : '' }}>
          <summary><i class="fas fa-user-friends nav-icon"></i><span class="menu-text">Data Anggota Per-Divisi</span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            @foreach($semua_divisi as $divisi)
              <a href="{{ route('admin.anggota.per.divisi', $divisi) }}" class="{{ request()->is('admin/anggota-per-divisi/' . $divisi->id) ? 'active' : '' }}">{{ $divisi->nama_divisi }}</a>
            @endforeach
          </nav>
        </details>
      </li>
      <li><a href="{{ route('admin.prestasi.index') }}" class="{{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}"><i class="fas fa-trophy nav-icon"></i><span class="menu-text"> Data Prestasi Mahasiswa </span></a></li>
      <li><a href="{{ route('admin.mahasiswa-bermasalah.index') }}" class="{{ request()->routeIs('admin.mahasiswa-bermasalah.index') ? 'active' : '' }}"><i class="fas fa-exclamation-triangle nav-icon"></i><span class="menu-text">Data Mahasiswa Bermasalah</span></a></li>
      <li><a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"><i class="fas fa-newspaper nav-icon"></i><span class="menu-text"> Data Berita</span></a></li>
      <li><a href="{{ route('admin.aspirasi.index') }}" class="{{ request()->routeIs('admin.aspirasi.*') ? 'active' : '' }}"><i class="fas fa-bullhorn nav-icon"></i><span class="menu-text"> Data Aspirasi</span></a></li>
      <li>
        <details>
          <summary><i class="fas fa-cog nav-icon"></i><span class="menu-text"> Pengaturan </span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            <a href="{{ route('admin.pengaturan.wa.setting') }}">Kelola Wa Setting</a>
            <a href="{{ route('admin.setting.index') }}">Pengaturan Website</a>
          </nav>
        </details>
      </li>
    </ul>
  </nav>
</aside>