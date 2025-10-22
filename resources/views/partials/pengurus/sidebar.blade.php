<aside class="sidebar">
   <div class="sidebar-header">
    <img src="{{ asset('assets/image/logo_hima.png') }}" alt="Logo HMTI" class="logo">
    <i class="fas fa-bars menu-icon"></i>
</div>

  <nav class="sidebar-nav">
    <ul>
      <li>
        <a href="{{ route('pengurus.dashboard') }}" class="{{ request()->routeIs('pengurus.dashboard') ? 'active' : '' }}">
          <i class="fas fa-home-alt nav-icon"></i><span class="menu-text"> Dashboard </span>
        </a>
      </li>

      <li class="nav-title">Pengurus</li>

      <li><a href="{{ route('pengurus.users.index') }}" class="{{ request()->routeIs('pengurus.users.*') ? 'active' : '' }}"><i class="fas fa-user nav-icon"></i><span class="menu-text"> Data Pengguna</span></a></li>
      <li>
        <details {{ request()->routeIs(['pengurus.kelola-anggota-himati.index', 'pengurus.calon-anggota.index', 'pengurus.calon-anggota-tahap-1.index', 'pengurus.calon-anggota-tahap-2.index']) ? 'open' : '' }}>
          <summary><i class="fas fa-users nav-icon"></i><span class="menu-text">Data Anggota Hima-TI</span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            <a href="{{ route('pengurus.kelola-anggota-himati.index') }}" class="{{ request()->routeIs('pengurus.kelola-anggota-himati.index') ? 'active' : '' }}">Kelola Anggota</a>
            <a href="{{ route('pengurus.calon-anggota.index') }}" class="{{ request()->routeIs('pengurus.calon-anggota.index') ? 'active' : '' }}">Pendaftaran Awal</a>
            <a href="{{ route('pengurus.calon-anggota-tahap-1.index') }}" class="{{ request()->routeIs('pengurus.calon-anggota-tahap-1.index') ? 'active' : '' }}">Hasil Tahap 1</a>
            <a href="{{ route('pengurus.calon-anggota-tahap-2.index') }}" class="{{ request()->routeIs('pengurus.calon-anggota-tahap-2.index') ? 'active' : '' }}">Hasil Tahap 2</a>
          </nav>
        </details>
      </li>
      <li><a href="{{ route('pengurus.divisi.index') }}" class="{{ request()->routeIs('pengurus.divisi.*') ? 'active' : '' }}"><i class="fas fa-sitemap nav-icon"></i><span class="menu-text"> Data Divisi</span></a></li>
      <li>
        <details {{ request()->routeIs('pengurus.anggota.per.divisi') ? 'open' : '' }}>
          <summary><i class="fas fa-user-friends nav-icon"></i><span class="menu-text">Data Anggota Per-Divisi</span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            @foreach($semua_divisi as $divisi)
              <a href="{{ route('pengurus.anggota.per.divisi', $divisi) }}" class="{{ request()->is('pengurus/anggota-per-divisi/' . $divisi->id) ? 'active' : '' }}">{{ $divisi->nama_divisi }}</a>
            @endforeach
          </nav>
        </details>
      </li>
      <li><a href="{{ route('pengurus.prestasi.index') }}" class="{{ request()->routeIs('pengurus.prestasi.*') ? 'active' : '' }}"><i class="fas fa-trophy nav-icon"></i><span class="menu-text"> Data Prestasi Mahasiswa </span></a></li>
      <li><a href="{{ route('pengurus.berita.index') }}" class="{{ request()->routeIs('pengurus.berita.*') ? 'active' : '' }}"><i class="fas fa-newspaper nav-icon"></i><span class="menu-text"> Data Berita</span></a></li>
      <li><a href="{{ route('pengurus.aspirasi.index') }}" class="{{ request()->routeIs('pengurus.aspirasi.*') ? 'active' : '' }}"><i class="fas fa-bullhorn nav-icon"></i><span class="menu-text"> Data Aspirasi</span></a></li>
      <li>
        <details>
          <summary><i class="fas fa-cog nav-icon"></i><span class="menu-text"> Pengaturan </span><i class="fas fa-chevron-down arrow-icon"></i></summary>
          <nav class="items">
            <a href="{{ route('pengurus.pengaturan.wa.setting') }}">Kelola Wa Setting</a>
          </nav>
        </details>
      </li>
    </ul>
  </nav>
</aside>