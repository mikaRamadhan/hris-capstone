
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Posisi - HRIS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px 20px;
            background: #f5f6fa;
            color: #263445;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 28px;
            color: #1e3a5f;
        }

        .header p {
            margin: 0;
            color: #718096;
            font-size: 14px;
        }

        .btn-add {
            background: #2864c5;
            color: white;
            padding: 12px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 16px 14px;
            text-align: left;
            border-bottom: 1px solid #edf0f5;
            font-size: 14px;
        }

        th {
            color: #64748b;
            background: #f8fafc;
            font-weight: 600;
        }

        td {
            color: #344054;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .btn {
            padding: 8px 11px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-detail {
            background: #edf0f5;
            color: #475467;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #94a3b8;
        }

        @media (max-width: 600px) {
            body {
                padding: 25px 15px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header h1 {
                font-size: 23px;
            }

            .card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Data Posisi</h1>
            <p>Kelola data posisi atau jabatan karyawan.</p>
        </div>

        <a href="{{ route('positions.create') }}" class="btn-add">
            + Tambah Posisi
        </a>
    </div>

    <div class="card">

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Posisi</th>
                    <th>Departemen</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($positions as $position)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $position->position_name }}</strong>
                        </td>

                        <td>
                            {{ $position->department->department_name ?? '-' }}
                        </td>

                        <td>
                            {{ $position->description ?: '-' }}
                        </td>

                        <td>
                            <div class="actions">

                                <a href="{{ route('positions.show', $position->id) }}"
                                   class="btn btn-detail">
                                    Detail
                                </a>

                                <a href="{{ route('positions.edit', $position->id) }}"
                                   class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('positions.destroy', $position->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus posisi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Belum ada data posisi yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
