
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
            color: #263248;
        }

        .page-wrapper {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #7b8497;
        }

        .table-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(30, 50, 90, 0.05);
        }

        .table thead th {
            background: #f5f7fc;
            color: #526078;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
        }

        .employee-name {
            font-weight: 700;
            color: #263248;
        }

        .employee-number {
            color: #7b8497;
            font-size: 12px;
        }

        .btn-add {
            background: #3157d5;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 9px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-add:hover {
            background: #2445b5;
            color: white;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            text-decoration: none;
            border: none;
        }

        .btn-detail {
            background: #e8efff;
            color: #3157d5;
        }

        .btn-edit {
            background: #fff3dc;
            color: #d99116;
        }

        .btn-delete {
            background: #ffe8e8;
            color: #dc3545;
        }

        .status-badge {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        @media(max-width: 768px) {
            .table-card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="page-title">Data Karyawan</h2>
            <p class="subtitle mb-0">
                Kelola dan pantau seluruh informasi karyawan perusahaan.
            </p>
        </div>

        <a href="{{ route('employees.create') }}" class="btn-add">
            <i class="fa-solid fa-plus me-2"></i>Tambah Karyawan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0">Daftar Karyawan</h5>
            <span class="text-secondary small">
                Total: {{ $employees->count() }} karyawan
            </span>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th>Posisi / Jabatan</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($employees as $index => $employee)

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <div class="employee-name">
                                    {{ $employee->full_name }}
                                </div>
                                <div class="employee-number">
                                    {{ $employee->employee_number }}
                                </div>
                            </td>

                            <td>
                                {{ $employee->department?->name ?? '-' }}
                            </td>

                            <td>
                                {{ $employee->position?->name ?? '-' }}
                            </td>

                            <td>
                                {{ $employee->join_date?->format('d-m-Y') ?? '-' }}
                            </td>

                            <td>
                                @if($employee->employment_status === 'active')
                                    <span class="badge bg-success status-badge">Aktif</span>
                                @elseif($employee->employment_status === 'inactive')
                                    <span class="badge bg-secondary status-badge">Tidak Aktif</span>
                                @elseif($employee->employment_status === 'resigned')
                                    <span class="badge bg-danger status-badge">Mengundurkan Diri</span>
                                @else
                                    <span class="badge bg-warning status-badge">Belum Ditentukan</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('employees.show', $employee->id) }}"
                                       class="action-btn btn-detail"
                                       title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                       class="action-btn btn-edit"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('employees.destroy', $employee->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn btn-delete"
                                                title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                <i class="fa-solid fa-users fa-2x mb-3 d-block"></i>
                                Belum ada data karyawan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
