
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Applicant - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0,0,0,.05);
        }

        .feature-card {
            background: white;
            border: none;
            border-radius: 15px;
            height: 100%;
            box-shadow: 0 4px 18px rgba(0,0,0,.05);
            transition: .2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(0,0,0,.08);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 23px;
            margin-bottom: 18px;
        }

        .profile-icon {
            background: #e7f0ff;
        }

        .vacancy-icon {
            background: #e5f8ed;
        }

        .application-icon {
            background: #fff1df;
        }

        .feature-card h5 {
            font-weight: bold;
        }

        .feature-card p {
            color: #6c757d;
            font-size: 14px;
            min-height: 65px;
        }

        .account-info {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg px-4 py-3">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary"
           href="{{ route('applicant.dashboard') }}">
            HRIS
        </a>

        <div class="d-flex align-items-center gap-3">

            <span class="text-muted">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="btn btn-outline-danger btn-sm" type="submit">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container py-5">

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <!-- WELCOME CARD -->
    <div class="card dashboard-card mb-4">

        <div class="card-body p-4 p-md-5">

            <h2 class="fw-bold">
                Selamat Datang, {{ auth()->user()->name }}!
            </h2>

            <p class="text-muted mt-2">
                Selamat datang di portal Applicant HRIS.
                Kamu dapat melengkapi profil, mencari lowongan pekerjaan,
                dan memantau perkembangan lamaran melalui sistem ini.
            </p>

            <hr class="my-4">

            <h5 class="fw-bold mb-3">
                Informasi Akun
            </h5>

            <div class="account-info">

                <p class="mb-2">
                    <strong>Nama:</strong>
                    {{ auth()->user()->name }}
                </p>

                <p class="mb-2">
                    <strong>Email:</strong>
                    {{ auth()->user()->email }}
                </p>

                <p class="mb-0">
                    <strong>Role:</strong>
                    Applicant
                </p>

            </div>

            <div class="mt-3">
                <span class="badge bg-primary">
                    Dashboard Applicant
                </span>
            </div>

        </div>

    </div>

    <!-- FEATURE MENU -->
    <div class="mb-3">

        <h4 class="fw-bold">
            Menu Applicant
        </h4>

        <p class="text-muted">
            Pilih menu yang ingin kamu akses.
        </p>

    </div>

    <div class="row g-4">

        <!-- PROFILE -->
        <div class="col-md-4">

            <div class="card feature-card">

                <div class="card-body p-4">

                    <div class="feature-icon profile-icon">
                        👤
                    </div>

                    <h5>Profil Saya</h5>

                    <p>
                        Lihat dan lengkapi informasi pribadi,
                        kontak, serta riwayat pendidikan.
                    </p>

                    <a href="{{ route('applicant.profile.edit') }}"
                       class="btn btn-primary w-100">
                        Kelola Profil
                    </a>

                </div>

            </div>

        </div>

        <!-- VACANCIES -->
        <div class="col-md-4">

            <div class="card feature-card">

                <div class="card-body p-4">

                    <div class="feature-icon vacancy-icon">
                        💼
                    </div>

                    <h5>Lowongan Kerja</h5>

                    <p>
                        Lihat daftar lowongan pekerjaan,
                        informasi posisi, dan persyaratan yang tersedia.
                    </p>

                    <a href="{{ route('applicant.vacancies.index') }}"
                       class="btn btn-success w-100">
                        Lihat Lowongan
                    </a>

                </div>

            </div>

        </div>

        <!-- APPLICATION HISTORY -->
        <div class="col-md-4">

            <div class="card feature-card">

                <div class="card-body p-4">

                    <div class="feature-icon application-icon">
                        📋
                    </div>

                    <h5>Riwayat Lamaran</h5>
                    <a href="{{ route('applicant.applications.index') }}"
                    class="btn btn-primary">
                        Lihat Riwayat Lamaran
                    </a>

                    <p>
                        Pantau status pengajuan lamaran pekerjaan
                        dan perkembangan proses rekrutmen.
                    </p>

                    <button class="btn btn-secondary w-100" disabled>
                        Segera Tersedia
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="text-center mt-5">

        <p class="text-muted small">
            Human Resources Information System (HRIS)
        </p>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
