
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f5fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            padding: 18px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
            color: #0d6efd;
            text-decoration: none;
        }

        .main-container {
            max-width: 950px;
            margin: 40px auto;
        }

        .detail-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .detail-label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .content-section {
            margin-top: 30px;
        }

        .content-section h5 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .content-text {
            white-space: pre-line;
            line-height: 1.8;
            color: #555;
        }

        .apply-section {
            background: #f0f5ff;
            border: 1px solid #d8e5ff;
            border-radius: 14px;
            padding: 25px;
            margin-top: 35px;
        }

        .btn-apply {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-apply:hover {
            background: #0b5ed7;
            color: white;
        }

        @media (max-width: 576px) {
            .detail-card {
                padding: 22px;
            }

            .main-container {
                margin: 25px auto;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">

        <a href="{{ route('applicant.dashboard') }}" class="brand">
            HRIS
        </a>

        <div class="d-flex gap-2">
            <a href="{{ route('applicant.profile.edit') }}"
               class="btn btn-outline-primary btn-sm">
                Profil Saya
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>

<div class="container main-container">

    <a href="{{ route('applicant.vacancies.index') }}"
       class="btn btn-outline-secondary mb-3">
        ← Kembali ke Daftar Lowongan
    </a>

    <div class="detail-card">

        <div class="mb-4">
            <span class="badge bg-success mb-3">Lowongan Dibuka</span>

            <h2 class="fw-bold">{{ $vacancy->title }}</h2>

            <p class="text-muted mb-0">
                Informasi lengkap mengenai lowongan pekerjaan.
            </p>
        </div>

        <hr>

        <div class="row">

            <div class="col-md-6">
                <div class="detail-label">Departemen</div>
                <div class="detail-value">
                    {{ $vacancy->departmentUnit?->name ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-label">Jabatan</div>
                <div class="detail-value">
                    {{ $vacancy->positionUnit?->name ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-label">Jenis Pekerjaan</div>
                <div class="detail-value">
                    {{ $vacancy->employment_type ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-label">Kuota Penerimaan</div>
                <div class="detail-value">
                    {{ $vacancy->quota ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-label">Batas Pendaftaran</div>
                <div class="detail-value">
                    @if($vacancy->closing_date)
                        {{ $vacancy->closing_date->format('d M Y') }}
                    @elseif($vacancy->deadline)
                        {{ \Carbon\Carbon::parse($vacancy->deadline)->format('d M Y') }}
                    @else
                        Tidak ditentukan
                    @endif
                </div>
            </div>

        </div>

        <div class="content-section">
            <h5>Deskripsi Pekerjaan</h5>

            <div class="content-text">
                {{ $vacancy->description ?: 'Belum ada deskripsi pekerjaan.' }}
            </div>
        </div>

        <div class="content-section">
            <h5>Persyaratan</h5>

            <div class="content-text">
                {{ $vacancy->requirements ?: 'Belum ada persyaratan yang dicantumkan.' }}
            </div>
        </div>

        <div class="apply-section">

            <h5 class="fw-bold mb-2">Tertarik dengan posisi ini?</h5>

            <p class="text-muted mb-3">
                Kirim lamaranmu sekarang melalui sistem HRIS.
                Pastikan data profil sudah benar sebelum mengajukan lamaran.
            </p>

            <a href="{{ route('applicant.applications.create', $vacancy->id) }}"
               class="btn btn-apply">
                Apply Sekarang →
            </a>

        </div>

    </div>

</div>

</body>
</html>
