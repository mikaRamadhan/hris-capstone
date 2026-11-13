@extends('layouts.hris')

@section('title', 'Edit User')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit User</h1>
        <p class="text-muted mb-0">Perbarui informasi akun pengguna.</p>
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

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Kosongkan jika tidak ingin mengganti password">
                <small class="text-muted">Isi minimal 8 karakter jika ingin mengganti password.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password baru">
            </div>

            <div class="mb-4">
                <label class="form-label">Role Pengguna</label>
                <select name="role" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}"
                            {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
        </form>

    </div>
</div>

@endsection