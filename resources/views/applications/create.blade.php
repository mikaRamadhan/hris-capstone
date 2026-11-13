<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lamaran - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 850px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.06);
        }
    </style>
</head>
<body>

<div class="container">

    <div class="mb-4">
        <h3 class="fw-bold">Tambah Lamaran</h3>
        <p class="text-muted">Masukkan informasi lamaran pekerjaan.</p>
    </div>

    <div class="card p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($applicants->isEmpty())
            <div class="alert alert-warning">
                Belum ada data pelamar. Tambahkan data pelamar terlebih dahulu sebelum membuat lamaran.
            </div>
        @endif

        @if($vacancies->isEmpty())
            <div class="alert alert-warning">
                Belum ada lowongan dengan status open.
            </div>
        @endif

        <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pelamar</label>

                <select name="applicant_id" class="form-select" required>
                    <option value="">-- Pilih Pelamar --</option>

                    @foreach($applicants as $applicant)
                        <option value="{{ $applicant->id }}"
                            {{ old('applicant_id') == $applicant->id ? 'selected' : '' }}>
                            {{ $applicant->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Lowongan Pekerjaan</label>

                <select name="vacancy_id" class="form-select" required>
                    <option value="">-- Pilih Lowongan --</option>

                    @foreach($vacancies as $vacancy)
                        <option value="{{ $vacancy->id }}"
                            {{ old('vacancy_id') == $vacancy->id ? 'selected' : '' }}>
                            {{ $vacancy->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Melamar</label>
                <input
                    type="date"
                    name="applied_at"
                    class="form-control"
                    value="{{ old('applied_at', date('Y-m-d')) }}"
                >
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status Lamaran</label>

                <select name="status" class="form-select" required>
                    <option value="submitted" {{ old('status', 'submitted') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewing" {{ old('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Dokumen Persyaratan</h5>

            <div class="mb-3">
                <label class="form-label">Jenis Dokumen</label>
                <input
                    type="text"
                    name="document_type"
                    class="form-control"
                    placeholder="Contoh: CV dan Dokumen Pendukung"
                    value="{{ old('document_type', 'Dokumen Pendukung') }}"
                >
            </div>

            <div class="mb-4">
                <label class="form-label">Upload Dokumen</label>
                <input
                    type="file"
                    name="documents[]"
                    class="form-control"
                    accept=".pdf,.doc,.docx"
                    multiple
                >
                <small class="text-muted">
                    Format PDF, DOC, DOCX. Maksimal 5 MB per file.
                </small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary"
                    {{ $applicants->isEmpty() || $vacancies->isEmpty() ? 'disabled' : '' }}>
                    Simpan Lamaran
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>