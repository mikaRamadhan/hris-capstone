
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - HRIS</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 35px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #1e293b;
        }

        .container { max-width: 700px; margin: auto; }

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

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dbe1ea;
            border-radius: 9px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        textarea { min-height: 110px; resize: vertical; }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .hint { color: #64748b; font-size: 12px; }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 18px;
            border-radius: 9px;
            border: none;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #e2e8f0; color: #334155; }

        @media (max-width: 600px) {
            body { padding: 18px; }
            .card { padding: 22px; }
            .actions { flex-direction: column; }
            .actions .btn { text-align: center; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h1>Edit Data</h1>
        <p class="subtitle">Perbarui informasi departemen atau posisi.</p>

        @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:9px;margin-bottom:20px;">
                Terdapat kesalahan pada pengisian form. Silakan periksa kembali.
            </div>
        @endif

        <form action="{{ route('organizational-units.update', $organizationalUnit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Jenis Data</label>
                <input
                    type="text"
                    value="{{ $organizationalUnit->type === 'department' ? 'Departemen' : 'Posisi' }}"
                    disabled
                >
                <small class="hint">Jenis data tidak dapat diubah setelah dibuat.</small>
            </div>

            <div class="form-group">
                <label for="name">Nama</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $organizationalUnit->name) }}"
                    required
                >
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            @if($organizationalUnit->type === 'position')
                <div class="form-group">
                    <label for="parent_id">Departemen Induk</label>
                    <select name="parent_id" id="parent_id" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('parent_id', $organizationalUnit->parent_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description">{{ old('description', $organizationalUnit->description) }}</textarea>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('organizational-units.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
