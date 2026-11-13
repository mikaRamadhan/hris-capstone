
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Departemen - HRIS</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 { color: #1e3a8a; }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 7px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error { color: red; }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Departemen</h1>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <label>Nama Departemen</label>
        <input type="text"
               name="department_name"
               value="{{ old('department_name') }}"
               placeholder="Contoh: Human Resources"
               required>

        <label>Deskripsi</label>
        <textarea name="description"
                  rows="5"
                  placeholder="Deskripsi departemen...">{{ old('description') }}</textarea>

        <button type="submit">Simpan Departemen</button>
    </form>

    <a href="{{ route('departments.index') }}" class="back">
        ← Kembali ke Daftar Departemen
    </a>

</div>

</body>
</html>
