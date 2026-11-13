
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karyawan - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f6fa;
            font-family: Arial, sans-serif;
            padding: 35px 15px;
            color: #263248;
        }

        .detail-container {
            max-width: 900px;
            margin: auto;
        }

        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .page-title {
            font-size: 25px;
            font-weight: 700;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin: 25px 0 15px;
            color: #2457c5;
        }

        .info-box {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 10px;
            height: 100%;
        }

        .info-label {
            color: #7b8495;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .info-value {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .btn-primary {
            background: #2457c5;
            border: none;
        }

        @media (max-width: 576px) {
            .detail-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="detail-container">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="page-title mb-1">Detail Karyawan</h2>
            <p class="text-secondary mb-0">Informasi lengkap data karyawan</p>
        </div>

        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="detail-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">{{ $employee->full_name }}</h4>
                <span class="text-secondary">
                    {{ $employee->employee_number }}
                </span>
            </div>

            @if($employee->employment_status === 'active')
                <span class="badge bg-success px-3 py-2">Aktif</span>
            @elseif($employee->employment_status === 'inactive')
                <span class="badge bg-secondary px-3 py-2">Tidak Aktif</span>
            @else
                <span class="badge bg-danger px-3 py-2">Resign</span>
            @endif
        </div>

        <hr>

        <h5 class="section-title">Informasi Kepegawaian</h5>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Nomor Karyawan</div>
                    <div class="info-value">{{ $employee->employee_number }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Nama Karyawan</div>
                    <div class="info-value">{{ $employee->full_name }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Departemen</div>
                    <div class="info-value">
                        {{ $employee->department?->name ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Posisi / Jabatan</div>
                    <div class="info-value">
                        {{ $employee->position?->name ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Tanggal Bergabung</div>
                    <div class="info-value">
                        {{ $employee->join_date?->format('d-m-Y') ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Status Kepegawaian</div>
                    <div class="info-value">
                        {{ ucfirst($employee->employment_status) }}
                    </div>
                </div>
            </div>

        </div>

        <h5 class="section-title">Informasi Akun dan Pelamar</h5>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Data Pelamar</div>
                    <div class="info-value">
                        {{ $employee->applicant?->full_name ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Akun Pengguna</div>
                    <div class="info-value">
                        {{ $employee->user?->name ?? '-' }}
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Karyawan
            </a>
        </div>

    </div>
</div>

</body>
</html>
