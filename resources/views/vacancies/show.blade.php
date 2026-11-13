
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6fb; font-family:'Segoe UI',sans-serif; color:#263248; padding:35px 15px; }
        .detail-container { max-width:950px; margin:auto; }
        .detail-card { background:white; border-radius:16px; padding:30px; box-shadow:0 5px 20px rgba(0,0,0,.05); }
        .page-title { font-size:25px; font-weight:700; }
        .section-title { font-size:16px; font-weight:700; margin:25px 0 15px; color:#2457c5; }
        .info-box { background:#f8f9fc; padding:15px; border-radius:10px; height:100%; }
        .info-label { color:#7b8495; font-size:13px; margin-bottom:6px; }
        .info-value { font-weight:600; overflow-wrap:anywhere; }
        .description-box { background:#f8f9fc; border-radius:10px; padding:18px; line-height:1.8; white-space:pre-line; }
        .btn-primary { background:#2457c5; border:none; }
        @media(max-width:576px) { .detail-card { padding:20px; } }
    </style>
</head>
<body>

<div class="detail-container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="page-title mb-1">Detail Lowongan Kerja</h2>
            <p class="text-secondary mb-0">Informasi lengkap lowongan pekerjaan</p>
        </div>

        <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="detail-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-2">{{ $vacancy->title }}</h3>
                <span class="text-secondary">ID Lowongan: #{{ $vacancy->id }}</span>
            </div>

            @if($vacancy->status === 'active')
                <span class="badge bg-success px-3 py-2">Aktif</span>
            @elseif($vacancy->status === 'inactive')
                <span class="badge bg-secondary px-3 py-2">Tidak Aktif</span>
            @elseif($vacancy->status === 'closed')
                <span class="badge bg-danger px-3 py-2">Ditutup</span>
            @else
                <span class="badge bg-warning px-3 py-2">{{ ucfirst($vacancy->status) }}</span>
            @endif
        </div>

        <hr>

        <h5 class="section-title">Informasi Lowongan</h5>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Departemen</div>
                    <div class="info-value">{{ $vacancy->departmentUnit?->name ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Posisi / Jabatan</div>
                    <div class="info-value">{{ $vacancy->position?->name ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Tipe Pekerjaan</div>
                    <div class="info-value">{{ $vacancy->employment_type ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Kuota</div>
                    <div class="info-value">{{ $vacancy->quota ?? '-' }} orang</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Tanggal Penutupan</div>
                    <div class="info-value">{{ $vacancy->closing_date?->format('d-m-Y') ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Dibuat Oleh</div>
                    <div class="info-value">{{ $vacancy->creator?->name ?? '-' }}</div>
                </div>
            </div>
        </div>

        <h5 class="section-title">Deskripsi Pekerjaan</h5>
        <div class="description-box">{{ $vacancy->description ?: '-' }}</div>

        <h5 class="section-title">Persyaratan</h5>
        <div class="description-box">{{ $vacancy->requirements ?: 'Tidak ada persyaratan tambahan.' }}</div>

        <h5 class="section-title">Informasi Lamaran</h5>
        <div class="info-box">
            <div class="info-label">Jumlah Lamaran Masuk</div>
            <div class="info-value">
                {{ $vacancy->applications->count() }} pelamar
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('vacancies.edit', $vacancy->id) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen me-1"></i>Edit Lowongan
            </a>
        </div>
    </div>
</div>

</body>
</html>
