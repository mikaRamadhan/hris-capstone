
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departemen & Posisi - HRIS</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1e293b;
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

        h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .subtitle {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-edit {
            background: #e0edff;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .alert {
            padding: 13px 16px;
            margin-bottom: 18px;
            border-radius: 9px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 15px 13px;
            text-align: left;
            border-bottom: 1px solid #e9edf4;
            font-size: 14px;
        }

        th {
            color: #64748b;
            background: #f8fafc;
            font-size: 12px;
            text-transform: uppercase;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .department {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .position {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 35px;
        }

        @media (max-width: 600px) {
            body {
                padding: 18px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Departemen & Posisi</h1>
            <p class="subtitle">Kelola data departemen dan posisi dalam satu halaman.</p>
        </div>

        <a href="{{ route('organizational-units.create') }}" class="btn btn-primary">
            + Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Departemen Induk</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($organizationalUnits as $index => $unit)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <strong>{{ $unit->name }}</strong>
                        </td>

                        <td>
                            @if($unit->type === 'department')
                                <span class="badge department">Departemen</span>
                            @else
                                <span class="badge position">Posisi</span>
                            @endif
                        </td>

                        <td>
                            {{ $unit->parent?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $unit->description ?: '-' }}
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('organizational-units.show', $unit->id) }}"
                                class="btn btn-primary">Detail</a>

                                <a href="{{ route('organizational-units.edit', $unit->id) }}"
                                class="btn btn-edit">Edit</a>

                                <form action="{{ route('organizational-units.destroy', $unit->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="6" class="empty">
                            Belum ada data departemen atau posisi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
