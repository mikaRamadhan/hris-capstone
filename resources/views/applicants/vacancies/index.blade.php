
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan - HRIS</title>

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
            max-width: 1200px;
            margin: 40px auto;
        }

        .page-heading {
            background: linear-gradient(120deg, #0d6efd, #1746a2);
            color: white;
            padding: 35px;
            border-radius: 18px;
            margin-bottom: 30px;
        }

        .vacancy-card {
            background: white;
            border: none;
            border-radius: 16px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 4px 18px rgba(0,0,0,.04);
            transition: .2s;
        }

        .vacancy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,.09);
        }

        .vacancy-title {
            font-size: 19px;
            font-weight: bold;
            color: #202b3c;
        }

        .vacancy-info {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 9px;
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .btn-detail {
            border-radius: 9px;
            padding: 10px 18px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('applicant.dashboard') }}" class="brand">HRIS</a>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('applicant.profile.edit') }}"
               class="btn btn-outline-primary btn-sm">
                Profil Saya
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger btn-sm" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container main-container">

    <div class="page-heading">
        <h2 class="fw-bold">Temukan Lowongan Kerja</h2>
        <p class="mb-0">
            Jelajahi peluang pekerjaan dan temukan posisi yang sesuai dengan kemampuanmu.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="search-box">
        <form action="{{ route('applicant.vacancies.index') }}" method="GET">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari berdasarkan nama posisi..."
                       value="{{ request('search') }}">

                <button class="btn btn-primary" type="submit">
                    Cari Lowongan
                </button>

                @if(request('search'))
                    <a href="{{ route('applicant.vacancies.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Lowongan Tersedia</h5>
        <span class="text-muted">{{ $vacancies->total() }} lowongan</span>
    </div>

    <div class="row g-4">

        @forelse($vacancies as $vacancy)

            <div class="col-md-6 col-lg-4">
                <div class="vacancy-card">

                    <span class="badge bg-success mb-3">
                        Dibuka
                    </span>

                    <h5 class="vacancy-title">
                        {{ $vacancy->title }}
                    </h5>

                    <div class="vacancy-info mt-3">
                        <strong>Departemen:</strong>
                        {{ $vacancy->departmentUnit?->name ?? '-' }}
                    </div>

                    <div class="vacancy-info">
                        <strong>Jabatan:</strong>
                        {{ $vacancy->positionUnit?->name ?? '-' }}
                    </div>

                    <div class="vacancy-info">
                        <strong>Jenis Pekerjaan:</strong>
                        {{ $vacancy->employment_type ?? '-' }}
                    </div>

                    <div class="vacancy-info">
                        <strong>Kuota:</strong>
                        {{ $vacancy->quota ?? '-' }}
                    </div>

                    <div class="vacancy-info">
                        <strong>Batas Pendaftaran:</strong>
                        @if($vacancy->closing_date)
                            {{ $vacancy->closing_date->format('d M Y') }}
                        @elseif($vacancy->deadline)
                            {{ \Carbon\Carbon::parse($vacancy->deadline)->format('d M Y') }}
                        @else
                            Tidak ditentukan
                        @endif
                    </div>

                    <hr>

                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($vacancy->description ?? ''), 100) }}
                    </p>

                    <a href="{{ route('applicant.vacancies.show', $vacancy->id) }}"
                    class="btn btn-outline-primary">
                        Lihat Detail
                    </a>

                    <a href="{{ route('applicant.applications.create', $vacancy->id) }}"
                    class="btn btn-primary">
                        Apply Sekarang
                    </a>

                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="bg-white rounded-4 p-5 text-center">
                    <h5 class="fw-bold">Lowongan Belum Tersedia</h5>
                    <p class="text-muted mb-0">
                        @if(request('search'))
                            Tidak ditemukan lowongan yang sesuai dengan pencarian.
                        @else
                            Saat ini belum ada lowongan pekerjaan yang dibuka.
                        @endif
                    </p>
                </div>
            </div>

        @endforelse

    </div>

    <div class="mt-4">
        {{ $vacancies->links('pagination::bootstrap-5') }}
    </div>

    <div class="mt-4">
        <a href="{{ route('applicant.dashboard') }}"
           class="btn btn-outline-secondary">
            Kembali ke Dashboard
        </a>
    </div>

</div>

</body>
</html>
