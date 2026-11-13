
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
            color: #263248;
        }

        .page-wrapper {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(30, 50, 90, 0.05);
        }

        .page-title {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #7b8497;
            margin-bottom: 28px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin: 25px 0 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #edf0f5;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-control, .form-select {
            padding: 11px 13px;
            border-radius: 9px;
            border: 1px solid #dfe4ed;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3157d5;
            box-shadow: 0 0 0 3px rgba(49, 87, 213, 0.1);
        }

        .btn-primary-custom {
            background: #3157d5;
            color: white;
            border: none;
            padding: 11px 22px;
            border-radius: 9px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: #2445b5;
            color: white;
        }

        .btn-secondary-custom {
            background: #eef1f7;
            color: #526078;
            padding: 11px 22px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: 600;
        }

        .required {
            color: #e04444;
        }

        @media(max-width: 576px) {
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="mb-4">
        <a href="{{ route('employees.index') }}" class="text-decoration-none text-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Data Karyawan
        </a>
    </div>

    <div class="form-card">

        <h2 class="page-title">Tambah Karyawan</h2>
        <p class="subtitle">Lengkapi informasi karyawan baru di bawah ini.</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data berikut:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <h5 class="section-title">Informasi Kepegawaian</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nomor Karyawan <span class="required">*</span></label>
                    <input type="text" name="employee_number"
                        class="form-control" value="{{ old('employee_number') }}"
                        placeholder="Contoh: EMP001" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Karyawan <span class="required">*</span></label>
                    <input type="text" name="full_name"
                        class="form-control" value="{{ old('full_name') }}"
                        placeholder="Masukkan nama lengkap karyawan" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Bergabung <span class="required">*</span></label>
                    <input type="date" name="join_date"
                        class="form-control" value="{{ old('join_date') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pelamar</label>
                    <select name="applicant_id" class="form-select">
                        <option value="">Pilih Pelamar (Opsional)</option>
                        @foreach($applicants as $applicant)
                            <option value="{{ $applicant->id }}"
                                {{ old('applicant_id') == $applicant->id ? 'selected' : '' }}>
                                {{ $applicant->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Akun Pengguna</label>
                    <select name="user_id" class="form-select">
                        <option value="">Pilih Akun Pengguna (Opsional)</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Departemen</label>
                    <select name="department_id" class="form-select">
                        <option value="">Pilih Departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Posisi / Jabatan</label>
                    <select name="position_id" class="form-select">
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}"
                                {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }} - {{ $position->parent->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status Karyawan <span class="required">*</span></label>
                    <select name="employment_status" class="form-select" required>
                        <option value="active" {{ old('employment_status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="resigned" {{ old('employment_status') == 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('employees.index') }}" class="btn-secondary-custom">
                    Batal
                </a>

                <button type="submit" class="btn-primary-custom">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Karyawan
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
