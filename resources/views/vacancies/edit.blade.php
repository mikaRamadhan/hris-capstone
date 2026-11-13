
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6fb; font-family:'Segoe UI',sans-serif; color:#263248; }
        .page-wrapper { max-width:1000px; margin:40px auto; padding:0 20px; }
        .form-card { background:white; border-radius:16px; padding:30px; box-shadow:0 4px 20px rgba(30,50,90,.05); }
        .page-title { font-weight:700; margin-bottom:6px; }
        .subtitle { color:#7b8497; margin-bottom:28px; }
        .section-title { font-size:16px; font-weight:700; margin:25px 0 18px; padding-bottom:10px; border-bottom:1px solid #edf0f5; }
        .form-label { font-weight:600; font-size:14px; }
        .form-control,.form-select { padding:11px 13px; border-radius:9px; border:1px solid #dfe4ed; }
        .form-control:focus,.form-select:focus { border-color:#3157d5; box-shadow:0 0 0 3px rgba(49,87,213,.1); }
        .btn-primary-custom { background:#3157d5; color:white; border:none; padding:11px 22px; border-radius:9px; font-weight:600; }
        .btn-primary-custom:hover { background:#2445b5; color:white; }
        .btn-secondary-custom { background:#eef1f7; color:#526078; padding:11px 22px; border-radius:9px; text-decoration:none; font-weight:600; }
        .required { color:#e04444; }
        @media(max-width:576px) { .form-card { padding:20px; } }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="mb-4">
        <a href="{{ route('vacancies.index') }}" class="text-decoration-none text-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar Lowongan
        </a>
    </div>

    <div class="form-card">
        <h2 class="page-title">Edit Lowongan Kerja</h2>
        <p class="subtitle">Perbarui informasi lowongan pekerjaan.</p>

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

        <form action="{{ route('vacancies.update', $vacancy->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="section-title">Informasi Lowongan</h5>

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Nama Lowongan <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $vacancy->title) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Departemen <span class="required">*</span></label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">Pilih Departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id', $vacancy->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Posisi / Jabatan</label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">Pilih Posisi (Opsional)</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}"
                                    data-department="{{ $position->parent_id }}"
                                    {{ old('position_id', $vacancy->position_id) == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Deskripsi Pekerjaan <span class="required">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description', $vacancy->description) }}</textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Persyaratan</label>
                    <textarea name="requirements" class="form-control" rows="5">{{ old('requirements', $vacancy->requirements) }}</textarea>
                </div>
            </div>

            <h5 class="section-title">Ketentuan Lowongan</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tipe Pekerjaan <span class="required">*</span></label>
                    <select name="employment_type" class="form-select" required>
                        <option value="">Pilih Tipe Pekerjaan</option>
                        @foreach(['Full Time','Part Time','Internship','Contract','Freelance'] as $type)
                            <option value="{{ $type }}" {{ old('employment_type', $vacancy->employment_type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kuota Karyawan <span class="required">*</span></label>
                    <input type="number" name="quota" class="form-control" min="1"
                           value="{{ old('quota', $vacancy->quota) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Penutupan <span class="required">*</span></label>
                    <input type="date" name="closing_date" class="form-control"
                           value="{{ old('closing_date', $vacancy->closing_date?->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Lowongan</label>

                    <select name="status" id="status" class="form-select" required>
                        <option value="open" {{ old('status', $vacancy->status) == 'open' ? 'selected' : '' }}>
                            Dibuka
                        </option>

                        <option value="closed" {{ old('status', $vacancy->status) == 'closed' ? 'selected' : '' }}>
                            Ditutup
                        </option>
                    </select>
                </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('vacancies.index') }}" class="btn-secondary-custom">Batal</a>
                <button type="submit" class="btn-primary-custom">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const departmentSelect = document.getElementById('department_id');
    const positionSelect = document.getElementById('position_id');

    function filterPositions() {
        const selectedDepartment = departmentSelect.value;
        const selectedPosition = positionSelect.value;

        Array.from(positionSelect.options).forEach(option => {
            if (!option.value) return;

            const matches = option.dataset.department === selectedDepartment;
            option.hidden = !matches;

            if (!matches && option.value === selectedPosition) {
                positionSelect.value = '';
            }
        });
    }

    departmentSelect.addEventListener('change', filterPositions);
    filterPositions();
</script>

</body>
</html>
