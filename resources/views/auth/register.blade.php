<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f3f5fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .register-card {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.07);
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            color: #2457d6;
        }

        .form-control {
            padding: 12px;
            border-radius: 9px;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 9px;
            background: #2457d6;
            color: white;
            font-weight: 600;
        }

        .btn-register:hover {
            background: #1945b5;
            color: white;
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="text-center mb-4">
        <div class="brand">HRIS</div>
        <h4 class="fw-bold mt-2">Buat Akun Applicant</h4>
        <p class="text-muted small">Daftar untuk mulai mencari dan melamar pekerjaan.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="Masukkan email aktif"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Minimal 8 karakter"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required
            >
        </div>

        <button type="submit" class="btn btn-register">
            Daftar Sekarang
        </button>
    </form>

    <div class="text-center mt-4">
        <small class="text-muted">Sudah mempunyai akun?</small>
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
            Login
        </a>
    </div>

</div>

</body>
</html>