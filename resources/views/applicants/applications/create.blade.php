<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Lamaran - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .container-main { max-width: 850px; margin: 40px auto; }
        .card { border: 0; border-radius: 16px; box-shadow: 0 5px 22px rgba(0,0,0,.06); }
        .btn-primary { background: #2457c5; border: 0; }
        .btn-primary:hover { background: #19449f; }
    </style>
</head>
<body>

<div class="container container-main">

    <a href="{{ route('applicant.vacancies.show', $vacancy->id) }}"
       class="btn btn-outline-secondary btn-sm mb-3">
        ← Kembali ke Detail Lowongan
    </a>

    <div class="card">
        <div class="card-body p-4 p-md-5">

            <h3 class="fw-bold mb-2">Form Pengajuan Lamaran</h3>
            <p class="text-muted mb-4">
                Periksa informasi lowongan sebelum mengirim lamaran.
            </p>

            <div class="alert alert-primary">
                <h5 class="fw-bold">{{ $vacancy->title }}</h5>
                <div>
                    Departemen:
                    {{ $vacancy->departmentUnit?->name ?? '-' }}
                </div>
                <div>
                    Posisi:
                    {{ $vacancy->positionUnit?->name ?? '-' }}
                </div>
                <div>
                    Tipe Pekerjaan:
                    {{ $vacancy->employment_type ?? '-' }}
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold">Data Pelamar</h6>
                <p class="mb-1">
                    Nama: {{ $applicant->full_name }}
                </p>
                <p class="mb-1">
                    Email: {{ Auth::user()->email }}
                </p>
                <p class="mb-1">
                    Nomor Telepon: {{ $applicant->phone_number ?? '-' }}
                </p>
                <a href="{{ route('applicant.profile.edit') }}"
                   class="btn btn-sm btn-outline-primary mt-2">
                    Perbarui Profil
                </a>
            </div>

            <hr>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applicant.applications.store', $vacancy->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Dokumen Pendukung
                    </label>

                    <input
                        type="file"
                        name="documents[]"
                        class="form-control"
                        accept=".pdf,.doc,.docx"
                        multiple
                    >

                    <small class="text-muted">
                        Dokumen bersifat opsional. Format PDF, DOC, atau DOCX.
                        Maksimal 5 MB per file. Kamu dapat memilih beberapa file.
                    </small>
                </div>

                <div class="alert alert-warning">
                    Pastikan profil pelamar sudah benar sebelum mengirim lamaran.
                    Lamaran yang telah dikirim akan tercatat pada riwayat lamaran.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        Kirim Lamaran
                    </button>

                    <a href="{{ route('applicant.vacancies.show', $vacancy->id) }}"
                       class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>