@extends('layouts.hris')

@section('title', 'Tambah User')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah User</h1>
        <p class="text-muted mb-0">Tambahkan akun pengguna baru ke sistem HRIS.</p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" placeholder="contoh@email.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Minimal 8 karakter" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Role Pengguna</label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan User</button>
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
        </form>

    </div>
</div>

@endsection