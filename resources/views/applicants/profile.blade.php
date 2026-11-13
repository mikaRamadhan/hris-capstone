
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f5fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            padding: 18px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
            color: #0d6efd;
            text-decoration: none;
        }

        .container-main {
            max-width: 1000px;
            margin: 40px auto;
        }

        .profile-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .form-label {
            font-weight: 600;
        }

        .form-control, .form-select {
            padding: 11px 13px;
            border-radius: 9px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">

        <a href="{{ route('applicant.dashboard') }}" class="brand">
            HRIS
        </a>

        <div class="d-flex gap-2">
            <a href="{{ route('applicant.dashboard') }}"
               class="btn btn-outline-primary btn-sm">
                Dashboard
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>

<div class="container container-main">

    <div class="profile-card">

        <div class="mb-4">
            <h2 class="fw-bold">Profil Saya</h2>
            <p class="text-muted">
                Lengkapi informasi pribadi dan pendidikan untuk kebutuhan proses rekrutmen.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data yang kamu masukkan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('applicant.profile.update') }}" method="POST">

            @csrf
            @method('PUT')

            <h5 class="section-title">Informasi Pribadi</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text"
                           name="full_name"
                           class="form-control"
                           value="{{ old('full_name', $applicant->full_name) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email"
                           class="form-control"
                           value="{{ $user->email }}"
                           disabled>
                    <small class="text-muted">Email akun tidak dapat diubah di halaman ini.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text"
                           name="phone_number"
                           class="form-control"
                           value="{{ old('phone_number', $applicant->phone_number) }}"
                           placeholder="Contoh: 081234567890">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date"
                           name="date_of_birth"
                           class="form-control"
                           max="{{ date('Y-m-d') }}"
                           value="{{ old('date_of_birth', $applicant->date_of_birth?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-select">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki"
                            {{ old('gender', $applicant->gender) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan"
                            {{ old('gender', $applicant->gender) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="address"
                              class="form-control"
                              rows="3"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $applicant->address) }}</textarea>
                </div>

            </div>

            <h5 class="section-title">Informasi Pendidikan</h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <input type="text"
                           name="education"
                           class="form-control"
                           value="{{ old('education', $applicant->education) }}"
                           placeholder="Contoh: S1 Sistem Informasi">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Universitas / Institusi</label>
                    <input type="text"
                           name="university"
                           class="form-control"
                           value="{{ old('university', $applicant->university) }}"
                           placeholder="Nama universitas atau institusi">
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between flex-wrap gap-2">

                <a href="{{ route('applicant.dashboard') }}"
                   class="btn btn-outline-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary px-4">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
