
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Departemen - HRIS</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f6fa;
        }

        h1 {
            color: #1e3a8a;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .action-group form {
            margin: 0;
        }

        .btn-action {
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
        }

        .detail { background: #64748b; }
        .edit { background: #2563eb; }
        .delete { background: #dc2626; }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            margin-bottom: 15px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h1>Data Departemen</h1>

    <a href="{{ route('departments.create') }}" class="btn">
        + Tambah Departemen
    </a>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Departemen</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($departments as $department)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $department->department_name }}</td>
                    <td>{{ $department->description ?? '-' }}</td>

                    <td>
                        <div class="action-group">

                            <a href="{{ route('departments.show', $department->id) }}"
                               class="btn-action detail">
                                Detail
                            </a>

                            <a href="{{ route('departments.edit', $department->id) }}"
                               class="btn-action edit">
                                Edit
                            </a>

                            <form action="{{ route('departments.destroy', $department->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-action delete">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">
                        Belum ada data departemen.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
