<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lamaran - HRIS</title>

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
        <h3 class="fw-bold">Edit Lamaran</h3>
        <p class="text-muted">Perbarui informasi dan status lamaran.</p>
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

        <form action="{{ route('applications.update', $application->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pelamar</label>

                <select name="applicant_id" class="form-select" required>
                    @foreach($applicants as $applicant)
                        <option value="{{ $applicant->id }}"
                            {{ old('applicant_id', $application->applicant_id) == $applicant->id ? 'selected' : '' }}>
                            {{ $applicant->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Lowongan Pekerjaan</label>

                <select name="vacancy_id" class="form-select" required>
                    @foreach($vacancies as $vacancy)
                        <option value="{{ $vacancy->id }}"
                            {{ old('vacancy_id', $application->vacancy_id) == $vacancy->id ? 'selected' : '' }}>
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
                    value="{{ old('applied_at', $application->applied_at?->format('Y-m-d')) }}"
                >
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status Lamaran</label>

                <select name="status" class="form-select" required>
                    <option value="submitted" {{ old('status', $application->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewing" {{ old('status', $application->status) == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="accepted" {{ old('status', $application->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ old('status', $application->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Dokumen Persyaratan</h5>

            <div class="mb-3">
                <label class="form-label">Jenis Dokumen Baru</label>

                <input
                    type="text"
                    name="document_type"
                    class="form-control"
                    value="{{ old('document_type', 'Dokumen Pendukung') }}"
                >
            </div>

            <div class="mb-4">
                <label class="form-label">Tambah Dokumen</label>

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
                <a href="{{ route('applications.show', $application->id) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>