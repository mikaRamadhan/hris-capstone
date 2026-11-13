<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .container-main { max-width: 850px; margin: 40px auto; }
        .card { border: 0; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,.05); }
    </style>
</head>
<body>

<div class="container container-main">

    <a href="{{ route('applicant.applications.index') }}"
       class="btn btn-outline-secondary btn-sm mb-3">
        ← Kembali ke Riwayat
    </a>

    <div class="card">
        <div class="card-body p-4 p-md-5">

            <h3 class="fw-bold mb-1">Detail Lamaran</h3>
            <p class="text-muted mb-4">
                Informasi pengajuan lamaran pekerjaan kamu.
            </p>

            <h5 class="fw-bold">
                {{ $application->vacancy?->title ?? 'Lowongan tidak tersedia' }}
            </h5>

            <p class="text-muted">
                {{ $application->vacancy?->departmentUnit?->name ?? '-' }}
            </p>

            <hr>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Nama Pelamar</div>
                <div class="col-md-8 fw-semibold">
                    {{ $application->applicant?->full_name ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Tanggal Melamar</div>
                <div class="col-md-8">
                    {{ $application->applied_at?->format('d-m-Y H:i') ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Status Lamaran</div>
                <div class="col-md-8">
                    @php
                        $labels = [
                            'submitted' => 'Terkirim',
                            'reviewing' => 'Sedang Ditinjau',
                            'accepted' => 'Diterima',
                            'rejected' => 'Ditolak',
                        ];
                    @endphp

                    <span class="badge bg-primary">
                        {{ $labels[$application->status] ?? ucfirst($application->status) }}
                    </span>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Dokumen Pendukung</h5>

            @forelse ($application->documents as $document)
                <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 gap-2">
                    <div>
                        <div class="fw-semibold">
                            {{ $document->file_name }}
                        </div>
                        <small class="text-muted">
                            {{ $document->document_type }}
                        </small>
                    </div>

                    <a href="{{ asset('storage/' . $document->file_path) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Dokumen
                    </a>
                </div>
            @empty
                <p class="text-muted">Tidak ada dokumen yang diunggah.</p>
            @endforelse

            <hr>

            <div class="alert alert-info mb-0">
                Informasi status lamaran akan diperbarui oleh pihak HRD
                apabila terdapat perubahan proses seleksi.
            </div>

        </div>
    </div>

</div>

</body>
</html>