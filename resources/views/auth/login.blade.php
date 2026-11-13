<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HRIS</title>

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

        .login-card {
            width: 100%;
            max-width: 430px;
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

        .subtitle {
            color: #777;
            font-size: 14px;
        }

        .form-control {
            padding: 12px;
            border-radius: 9px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 9px;
            background: #2457d6;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #1945b5;
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="text-center mb-4">
        <div class="brand">HRIS</div>
        <h4 class="fw-bold mt-2">Selamat Datang</h4>
        <p class="subtitle">Silakan login ke akun HRIS kamu.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
            <label class="form-check-label" for="remember">
                Ingat saya
            </label>
        </div>

        <button type="submit" class="btn btn-login">
            Login
        </button>
    </form>

    <div class="text-center mt-4">
        <small class="text-muted">Belum mempunyai akun?</small>
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
            Daftar sekarang
        </a>
    </div>

</div>

</body>
</html>x