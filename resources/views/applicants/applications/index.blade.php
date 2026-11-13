<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lamaran - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .container-main { max-width: 1100px; margin: 40px auto; }
        .card { border: 0; border-radius: 14px; box-shadow: 0 5px 20px rgba(0,0,0,.05); }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .submitted { background: #e3edff; color: #2457c5; }
        .reviewing { background: #fff2cc; color: #946200; }
        .accepted { background: #d9f5e5; color: #167344; }
        .rejected { background: #ffe0e0; color: #b42318; }
    </style>
</head>
<body>

<div class="container container-main">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Riwayat Lamaran</h3>
            <p class="text-muted mb-0">Daftar lowongan yang sudah kamu lamar.</p>
        </div>

        <a href="{{ route('applicant.vacancies.index') }}"
           class="btn btn-primary">
            Cari Lowongan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-4">

            @forelse ($applications as $application)

                @php
                    $status = strtolower($application->status);
                    $statusClass = in_array($status, ['submitted', 'reviewing', 'accepted', 'rejected'])
                        ? $status
                        : 'submitted';

                    $statusLabel = [
                        'submitted' => 'Terkirim',
                        'reviewing' => 'Sedang Ditinjau',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ][$status] ?? ucfirst($application->status);
                @endphp

                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $application->vacancy?->title ?? 'Lowongan tidak tersedia' }}
                            </h5>

                            <p class="text-muted mb-1">
                                {{ $application->vacancy?->departmentUnit?->name ?? '-' }}
                            </p>

                            <small class="text-muted">
                                Tanggal Lamaran:
                                {{ $application->applied_at?->format('d-m-Y H:i') ?? '-' }}
                            </small>
                        </div>

                        <span class="status {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>

                    </div>

                    <div class="mt-3">
                        <a href="{{ route('applicant.applications.show', $application->id) }}"
                           class="btn btn-outline-primary btn-sm">
                            Lihat Detail Lamaran
                        </a>
                    </div>
                </div>

            @empty

                <div class="text-center py-5">
                    <h5 class="fw-bold">Belum Ada Lamaran</h5>
                    <p class="text-muted">
                        Kamu belum mengirim lamaran pekerjaan.
                    </p>
                    <a href="{{ route('applicant.vacancies.index') }}"
                       class="btn btn-primary">
                        Lihat Lowongan Kerja
                    </a>
                </div>

            @endforelse

            <div class="mt-3">
                {{ $applications->links() }}
            </div>

        </div>
    </div>

    <a href="{{ route('applicant.dashboard') }}"
       class="btn btn-outline-secondary mt-3">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>