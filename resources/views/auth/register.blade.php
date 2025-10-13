<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar HIMA-TI</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --bg:#0b1220;
      --card:#111827;
      --text:#e5e7eb;
      --muted:#b6c2d1;
      --border:rgba(255,255,255,.06);
      --link:#3b82f6;
    }

    *{box-sizing:border-box;}
    body{
      margin:0;
      min-height:100vh;
      font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      color:var(--text);
      background:var(--bg);
      background-image:radial-gradient(rgba(255,255,255,.08) 1px,transparent 1px);
      background-size:18px 18px;
      display:flex;;
      align-items:center;
      justify-content:center;
      padding:24px;
    }

    .auth-card{
      width:100%;
      max-width:520px;
      background:rgba(17,24,39,.92);
      border:1px solid var(--border);
      border-radius:20px;
      box-shadow:0 20px 35px rgba(0,0,0,.55),0 2px 6px rgba(0,0,0,.25);
      overflow:hidden;
    }

    .auth-card .card-header{
      text-align:center;
      padding:28px 24px 8px;
      border-bottom:1px solid var(--border);
      background:transparent;
    }

    .auth-logo{
      width:72px;height:72px;border-radius:50%;
      background:#fff;display:block;margin:0 auto 12px;object-fit:contain;
    }

    .auth-title{
      margin:0 0 4px;font-weight:700;color:#ffffff !important;
    }

    .auth-subtitle{
      margin:0;color:var(--muted) !important;font-size:.95rem;
    }

    .auth-card .card-body{padding:24px 24px 18px;}
    .auth-card label{color:#cbd5e1;}

    .btn-primary{
      background-color:#2563eb;border:none;font-weight:600;
    }
    .btn-primary:hover{background-color:#1e40af;}

    /* Tombol Google */
    .google-btn{
      width:100%;
      display:flex;;
      align-items:center;
      justify-content:center;
      gap:10px;
      background:#fff;
      color:#111827;
      text-decoration:none;
      border-radius:12px;
      border:none;
      padding:12px 16px;
      font-weight:600;
      box-shadow:0 6px 20px rgba(0,0,0,.15);
      transition:box-shadow .2s ease,transform .05s ease;
    }
    .google-btn:hover{box-shadow:0 10px 24px rgba(0,0,0,.22);}
    .google-btn:active{transform:translateY(1px);}
    .google-icon{width:20px;height:20px;}

    .auth-links{text-align:center;margin-top:1rem;}
    .auth-links p{margin:0 0 .5rem 0;color:#ffffff;}
    .auth-links a{color:var(--link);text-decoration:none;font-weight:600;}
    .auth-links a:hover{text-decoration:underline;}
    .back-link{display:inline-block;margin-top:.5rem;color:#c0cbe0;text-decoration:underline;}

    .auth-footer{
      text-align:center;color:#94a3b8;padding:0 0 18px;font-size:.9rem;
    }

    @media(max-width:480px){.auth-card{border-radius:16px;}}
  </style>
</head>
<body>

  <main class="card auth-card" role="main" aria-labelledby="register-title">
    <header class="card-header">
      <img src="{{ asset('assets/image/logo_hima.png') }}" alt="Logo HMTI" class="auth-logo">
      <h2 id="register-title" class="auth-title">Daftar HIMA-TI</h2>
      <p class="auth-subtitle">Buat akun baru untuk melanjutkan</p>
    </header>

    <section class="card-body">
      {{-- Error Validasi --}}
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Form Register --}}
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
          <label for="no_wa" class="form-label">No. WhatsApp</label>
          <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" required>
        </div>



        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
      </form>

      {{-- Daftar via Google --}}
      <div class="mt-3">
        <a href="{{ url('auth/google') }}" class="google-btn" aria-label="Daftar dengan Google">
          <svg class="google-icon" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill="#4285F4" d="M533.5 278.4c0-18.6-1.7-36.4-4.8-53.6H272v101.5h147.3c-6.4 34.6-26 63.9-55.4 83.5v69.4h89.6c52.4-48.2 80-119.2 80-200.8z"/>
            <path fill="#34A853" d="M272 544.3c73 0 134.3-24.2 179-65.1l-89.6-69.4c-24.9 16.7-56.8 26.6-89.4 26.6-68.6 0-126.7-46.3-147.6-108.5H33.7v68.3c44.3 88.1 134.4 148.1 238.3 148.1z"/>
            <path fill="#FBBC05" d="M124.4 327.9c-10.3-30.6-10.3-63.7 0-94.3v-68.3H33.7C12.1 214.1 0 244.8 0 278s12.1 63.9 33.7 112.7l90.7-62.8z"/>
            <path fill="#EA4335" d="M272 106.5c39.6-.6 77.5 14.5 106.4 41.8l79.5-79.5C405.9 24.7 344.8 0 272 0 168.1 0 78 60 33.7 148.1l90.7 68.3C145.3 152.1 203.4 106.5 272 106.5z"/>
          </svg>
          Daftar dengan Google
        </a>
      </div>

      <div class="auth-links">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        <a class="back-link" href="/user/beranda">Kembali ke Beranda</a>
      </div>
    </section>

    <div class="auth-footer">© {{ now()->year }} HIMA-TI Politala</div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>