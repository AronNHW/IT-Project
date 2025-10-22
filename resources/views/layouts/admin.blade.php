<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Dashboard Admin')</title>

  {{-- Fonts & Icons (sesuai file) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  {{-- CSS utama --}}
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

  @stack('styles')
<style>
    .profile-dropdown-wrapper {
        position: relative;
    }
    .profile-dropdown-toggle {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-dropdown-toggle img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 10px;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 1001;
        min-width: 180px;
        padding: 0.5rem 0;
    }
    .profile-dropdown-menu.active {
        display: block;
    }
    .profile-dropdown-item {
        display: block;
        width: 100%;
        padding: 0.6rem 1.5rem;
        clear: both;
        font-weight: 500;
        color: #374151;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        text-decoration: none;
    }
    .profile-dropdown-item:hover {
        background-color: #f3f4f6;
    }
    .profile-dropdown-divider {
        height: 0;
        margin: 0.5rem 0;
        overflow: hidden;
        border-top: 1px solid #e9ecef;
    }
</style>
</head>
<body>
  @include('partials.admin.sidebar')

  <main class="main-content">
    <header class="topbar">
      <div class="profile-dropdown-wrapper">
        <div class="profile-dropdown-toggle">
            <span>Hi, {{ Auth::user()->name ?? 'Admin' }}</span>
            <img src="{{ Auth::user()->photo_url ?? 'https://i.pravatar.cc/150?u=' . Auth::id() }}" alt="User Avatar">
        </div>
        <div class="profile-dropdown-menu">
            <a class="profile-dropdown-item" href="{{ route('user.beranda') }}">Beranda User</a>
            <a class="profile-dropdown-item" href="{{ route('user.profil.edit') }}">Pengaturan Profil</a>
            <div class="profile-dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" class="profile-dropdown-item">Logout</button>
            </form>
        </div>
      </div>
    </header>

    <section class="dashboard-section">
      @yield('content')
    </section>
  </main>

  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  @stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.profile-dropdown-toggle');
        const menu = document.querySelector('.profile-dropdown-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });
        }
    });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.menu-icon');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (menuIcon) {
        menuIcon.addEventListener('click', function () {
          sidebar.classList.toggle('collapsed');
          mainContent.classList.toggle('expanded');
        });
    }
  });
</script>
</body>
</html>