
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Posisi - HRIS</title>

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
            max-width: 750px;
            margin: auto;
        }

        .header {
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

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .info-group {
            padding: 18px 0;
            border-bottom: 1px solid #edf0f5;
        }

        .info-group:last-child {
            border-bottom: none;
        }

        .label {
            color: #718096;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .value {
            font-size: 16px;
            font-weight: 600;
            color: #263445;
        }

        .description {
            font-weight: normal;
            line-height: 1.7;
            white-space: pre-line;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-back {
            background: #edf0f5;
            color: #475467;
        }

        .btn-edit {
            background: #2864c5;
            color: white;
        }

        @media (max-width: 600px) {
            body {
                padding: 25px 15px;
            }

            .card {
                padding: 22px 18px;
            }

            .header h1 {
                font-size: 23px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Detail Posisi</h1>
        <p>Informasi lengkap posisi atau jabatan dalam sistem HRIS.</p>
    </div>

    <div class="card">

        <div class="info-group">
            <div class="label">ID Posisi</div>
            <div class="value">{{ $position->id }}</div>
        </div>

        <div class="info-group">
            <div class="label">Nama Posisi</div>
            <div class="value">{{ $position->position_name }}</div>
        </div>

        <div class="info-group">
            <div class="label">Departemen</div>
            <div class="value">
                {{ $position->department->department_name ?? '-' }}
            </div>
        </div>

        <div class="info-group">
            <div class="label">Deskripsi Posisi</div>
            <div class="value description">
                {{ $position->description ?: 'Belum ada deskripsi.' }}
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('positions.index') }}" class="btn btn-back">
                Kembali
            </a>

            <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-edit">
                Edit Posisi
            </a>
        </div>

    </div>

</div>

</body>
</html>
