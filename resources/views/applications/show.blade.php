<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 950px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.06);
            margin-bottom: 20px;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .value {
            font-weight: 600;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Lamaran</h3>
            <p class="text-muted mb-0">Informasi lengkap data lamaran.</p>
        </div>

        <a href="{{ route('applications.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Informasi Lamaran</h5>

            <a href="{{ route('applications.edit', $application->id) }}"
               class="btn btn-warning btn-sm">
                Edit Lamaran
            </a>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="label">ID Lamaran</div>
                <div class="value">#{{ $application->id }}</div>
            </div>

            <div class="col-md-6">
                <div class="label">Tanggal Melamar</div>
                <div class="value">
                    {{ $application->applied_at?->format('d F Y H:i') ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Lowongan</div>
                <div class="value">
                    {{ $application->vacancy?->title ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Departemen</div>
                <div class="value">
                    {{ $application->vacancy?->departmentUnit?->name ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Status Lamaran</div>
                <div class="value">
                    @if($application->status == 'submitted')
                        <span class="badge bg-secondary">Submitted</span>
                    @elseif($application->status == 'reviewing')
                        <span class="badge bg-warning text-dark">Reviewing</span>
                    @elseif($application->status == 'accepted')
                        <span class="badge bg-success">Accepted</span>
                    @elseif($application->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="card p-4">

        <h5 class="fw-bold mb-3">Profil Pelamar</h5>

        <div class="row">

            <div class="col-md-6">
                <div class="label">Nama Lengkap</div>
                <div class="value">
                    {{ $application->applicant?->full_name ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Nomor Telepon</div>
                <div class="value">
                    {{ $application->applicant?->phone_number ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Jenis Kelamin</div>
                <div class="value">
                    {{ $application->applicant?->gender ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Tanggal Lahir</div>
                <div class="value">
                    {{ $application->applicant?->date_of_birth?->format('d-m-Y') ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Pendidikan</div>
                <div class="value">
                    {{ $application->applicant?->education ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="label">Universitas</div>
                <div class="value">
                    {{ $application->applicant?->university ?? '-' }}
                </div>
            </div>

            <div class="col-12">
                <div class="label">Alamat</div>
                <div class="value">
                    {{ $application->applicant?->address ?? '-' }}
                </div>
            </div>

        </div>

    </div>

    <div class="card p-4">

        <h5 class="fw-bold mb-3">Dokumen Persyaratan</h5>

        @forelse($application->documents as $document)

            <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">

                <div>
                    <div class="fw-semibold">
                        {{ $document->document_type }}
                    </div>

                    <small class="text-muted">
                        {{ $document->file_name }}
                    </small>
                </div>

                <a
                    href="{{ asset('storage/' . $document->file_path) }}"
                    target="_blank"
                    class="btn btn-sm btn-primary"
                >
                    Lihat Dokumen
                </a>

            </div>

        @empty

            <p class="text-muted mb-0">
                Belum ada dokumen yang diunggah.
            </p>

        @endforelse

    </div>

    <div class="card p-4">

        <h5 class="fw-bold mb-3">Hapus Lamaran</h5>

        <p class="text-muted">
            Menghapus data lamaran juga akan menghapus dokumen yang tersimpan pada lamaran tersebut.
        </p>

        <form
            action="{{ route('applications.destroy', $application->id) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini beserta dokumennya?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Hapus Lamaran
            </button>
        </form>

    </div>

</div>

</body>
</html>