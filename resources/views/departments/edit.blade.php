
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Departemen - HRIS</title>

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
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-weight: 600;
            font-size: 14px;
            color: #344054;
        }

        input, textarea {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #dce2ea;
            border-radius: 9px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: 0.2s;
        }

        input:focus, textarea:focus {
            border-color: #3978d5;
            box-shadow: 0 0 0 3px rgba(57,120,213,0.1);
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
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
            border: none;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-back {
            background: #edf0f5;
            color: #475467;
        }

        .btn-save {
            background: #2864c5;
            color: white;
        }

        .btn-save:hover {
            background: #1d4fa5;
        }

        .btn-back:hover {
            background: #dfe4eb;
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
                flex-direction: column-reverse;
            }

            .btn {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Edit Departemen</h1>
        <p>Perbarui informasi departemen pada sistem HRIS.</p>
    </div>

    <div class="card">

        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="department_name">Nama Departemen</label>

                <input
                    type="text"
                    id="department_name"
                    name="department_name"
                    value="{{ old('department_name', $department->department_name) }}"
                    placeholder="Contoh: Human Resources"
                    required
                >

                @error('department_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Departemen</label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Masukkan deskripsi departemen..."
                >{{ old('description', $department->description) }}</textarea>

                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <a href="{{ route('departments.index') }}" class="btn btn-back">
                    Kembali
                </a>

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
