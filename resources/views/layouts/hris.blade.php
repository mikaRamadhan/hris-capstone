<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Manajemen User') - HRIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            color: #263238;
        }

        .main-content {
            padding: 35px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .table th {
            background: #f1f4f9;
            white-space: nowrap;
        }

        .table td, .table th {
            padding: 14px;
            vertical-align: middle;
        }

        .form-label {
            font-weight: 600;
        }

        .btn {
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px 12px;
            }

            .page-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>