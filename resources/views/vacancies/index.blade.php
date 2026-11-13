
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lowongan Kerja - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        }

        .table th {
            background: #f1f4f9;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .btn {
            border-radius: 7px;
        }

        .page-title {
            font-weight: 700;
            color: #253858;
        }

        .vacancy-title {
            font-weight: 600;
            color: #253858;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title mb-1">Data Lowongan Kerja</h3>
            <p class="text-muted mb-0">
                Kelola informasi lowongan pekerjaan.
            </p>
        </div>

        <a href="{{ route('vacancies.create') }}" class="btn btn-primary">
            + Tambah Lowongan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Lowongan</h5>
                <span class="badge bg-primary">
                    Total: {{ $vacancies->count() }} Lowongan
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th>Nama Lowongan</th>
                            <th>Departemen</th>
                            <th>Tipe Pekerjaan</th>
                            <th>Kuota</th>
                            <th>Tanggal Penutupan</th>
                            <th>Status</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vacancies as $index => $vacancy)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <span class="vacancy-title">
                                        {{ $vacancy->title }}
                                    </span>
                                </td>

                               <td>
                                    {{ $vacancy->departmentUnit?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $vacancy->employment_type }}
                                </td>

                                <td>
                                    {{ $vacancy->quota }} Orang
                                </td>

                                <td>
                                    {{ $vacancy->closing_date
                                        ? \Carbon\Carbon::parse($vacancy->closing_date)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if($vacancy->status == 'open')
                                        <span class="badge bg-success">Dibuka</span>
                                    @else
                                        <span class="badge bg-danger">Ditutup</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1">

                                        <a href="{{ route('vacancies.show', $vacancy->id) }}"
                                           class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>

                                        <a href="{{ route('vacancies.edit', $vacancy->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('vacancies.destroy', $vacancy->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data lowongan kerja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
