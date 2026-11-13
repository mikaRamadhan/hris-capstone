<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelamar - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; font-family: Arial, sans-serif; }
        .container { max-width: 900px; margin-top: 40px; margin-bottom: 40px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 15px rgba(0,0,0,.06); }
        .label { color: #6b7280; font-size: 13px; margin-bottom: 4px; }
        .value { font-weight: 600; margin-bottom: 18px; }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="fw-bold">Detail Pelamar</h3>
            <p class="text-muted mb-0">Informasi lengkap calon karyawan.</p>
        </div>

        <a href="{{ route('applicants.index') }}" class="btn btn-secondary align-self-center">Kembali</a>
    </div>

    <div class="card p-4">

        <div class="d-flex justify-content-between mb-4">
            <h5 class="fw-bold">Informasi Pribadi</h5>
            <a href="{{ route('applicants.edit', $applicant->id) }}" class="btn btn-warning btn-sm">Edit</a>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $applicant->full_name }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Email</div>
                <div class="value">{{ $applicant->user?->email ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Nomor Telepon</div>
                <div class="value">{{ $applicant->phone_number ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Jenis Kelamin</div>
                <div class="value">{{ $applicant->gender ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Tanggal Lahir</div>
                <div class="value">{{ $applicant->date_of_birth?->format('d-m-Y') ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Pendidikan</div>
                <div class="value">{{ $applicant->education ?? '-' }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Universitas</div>
                <div class="value">{{ $applicant->university ?? '-' }}</div>
            </div>

            <div class="col-12">
                <div class="label">Alamat</div>
                <div class="value">{{ $applicant->address ?? '-' }}</div>
            </div>

        </div>

    </div>

    <div class="card p-4 mt-4">
        <h5 class="fw-bold mb-3">Riwayat Lamaran</h5>

        @forelse($applicant->applications as $application)
            <div class="border rounded p-3 mb-2">
                <strong>{{ $application->vacancy?->title ?? '-' }}</strong>
                <div class="text-muted small">
                    {{ $application->applied_at?->format('d-m-Y') ?? '-' }}
                    · Status: {{ ucfirst($application->status) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">Pelamar belum memiliki riwayat lamaran.</p>
        @endforelse
    </div>

</div>

</body>
</html>