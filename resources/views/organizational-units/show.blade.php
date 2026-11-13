
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data - HRIS</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 35px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1e293b;
        }

        .container { max-width: 750px; margin: auto; }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .05);
        }

        h1 { margin: 0 0 8px; font-size: 25px; }

        .subtitle {
            color: #64748b;
            margin: 0 0 25px;
            font-size: 14px;
        }

        .detail {
            padding: 16px 0;
            border-bottom: 1px solid #e9edf4;
        }

        .detail:last-child { border-bottom: none; }

        .label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .value {
            font-size: 15px;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .department { background: #dbeafe; color: #1d4ed8; }
        .position { background: #f3e8ff; color: #7e22ce; }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
        }

        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #e2e8f0; color: #334155; margin-left: 7px; }

        @media (max-width: 600px) {
            body { padding: 18px; }
            .card { padding: 22px; }
            .btn { margin: 8px 5px 0 0; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h1>Detail Data</h1>
        <p class="subtitle">Informasi lengkap departemen atau posisi.</p>

        <div class="detail">
            <div class="label">Nama</div>
            <div class="value">{{ $organizationalUnit->name }}</div>
        </div>

        <div class="detail">
            <div class="label">Jenis Data</div>
            <div class="value">
                @if($organizationalUnit->type === 'department')
                    <span class="badge department">Departemen</span>
                @else
                    <span class="badge position">Posisi</span>
                @endif
            </div>
        </div>

        <div class="detail">
            <div class="label">Departemen Induk</div>
            <div class="value">{{ $organizationalUnit->parent?->name ?? '-' }}</div>
        </div>

        <div class="detail">
            <div class="label">Deskripsi</div>
            <div class="value" style="font-weight:normal;">
                {{ $organizationalUnit->description ?: '-' }}
            </div>
        </div>

        <a href="{{ route('organizational-units.edit', $organizationalUnit->id) }}"
           class="btn btn-primary">Edit Data</a>

        <a href="{{ route('organizational-units.index') }}"
           class="btn btn-secondary">Kembali</a>
    </div>
</div>

</body>
</html>
