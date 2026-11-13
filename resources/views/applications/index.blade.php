<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lamaran - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.06);
        }

        .table th {
            background: #f1f4f9;
            white-space: nowrap;
        }

        .btn-primary {
            background: #2563eb;
            border: none;
        }

        .badge {
            padding: 8px 12px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Lamaran</h3>
            <p class="text-muted mb-0">Kelola data lamaran pekerjaan.</p>
        </div>

        <a href="{{ route('applications.create') }}" class="btn btn-primary">
            + Tambah Lamaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">

        <form method="GET" action="{{ route('applications.index') }}" class="row g-2 mb-4">

            <div class="col-md-5">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama pelamar atau lowongan..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('applications.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelamar</th>
                        <th>Lowongan</th>
                        <th>Departemen</th>
                        <th>Tanggal Melamar</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($applications as $application)

                        <tr>
                            <td>{{ $applications->firstItem() + $loop->index }}</td>

                            <td>
                                {{ $application->applicant?->full_name ?? '-' }}
                            </td>

                            <td>
                                {{ $application->vacancy?->title ?? '-' }}
                            </td>

                            <td>
                                {{ $application->vacancy?->departmentUnit?->name ?? '-' }}
                            </td>

                            <td>
                                {{ $application->applied_at?->format('d-m-Y') ?? '-' }}
                            </td>

                            <td>
                                @if($application->status == 'submitted')
                                    <span class="badge bg-secondary">Submitted</span>
                                @elseif($application->status == 'reviewing')
                                    <span class="badge bg-warning text-dark">Reviewing</span>
                                @elseif($application->status == 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @elseif($application->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('applications.show', $application->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    Detail
                                </a>

                                <a href="{{ route('applications.edit', $application->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data lamaran.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{ $applications->links('pagination::bootstrap-5') }}

    </div>

</div>

</body>
</html>