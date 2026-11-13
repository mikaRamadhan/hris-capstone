<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelamar - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; font-family: Arial, sans-serif; }
        .container { max-width: 850px; margin-top: 40px; margin-bottom: 40px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 15px rgba(0,0,0,.06); }
    </style>
</head>
<body>

<div class="container">

    <h3 class="fw-bold mb-1">Edit Pelamar</h3>
    <p class="text-muted mb-4">Perbarui informasi calon karyawan.</p>

    <div class="card p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('applicants.update', $applicant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Akun Pengguna</label>
                <select name="user_id" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $applicant->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $applicant->full_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Telepon</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $applicant->phone_number) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $applicant->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $applicant->date_of_birth?->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Kelamin</label>
                <select name="gender" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('gender', $applicant->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender', $applicant->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                <input type="text" name="education" class="form-control" value="{{ old('education', $applicant->education) }}">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Universitas / Institusi</label>
                <input type="text" name="university" class="form-control" value="{{ old('university', $applicant->university) }}">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('applicants.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>