@extends('layouts.hris')

@section('title', 'Detail User')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail User</h1>
        <p class="text-muted mb-0">Informasi lengkap akun pengguna.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">

        <table class="table">
            <tr>
                <th width="220">ID User</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ ucfirst($user->role ?? 'Belum diatur') }}</td>
            </tr>
            <tr>
                <th>Terdaftar</th>
                <td>{{ $user->created_at?->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diperbarui</th>
                <td>{{ $user->updated_at?->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th>Profil Pelamar</th>
                <td>
                    @if($user->applicant)
                        <span class="badge bg-success">Sudah terhubung</span>
                        — {{ $user->applicant->full_name }}
                    @else
                        <span class="badge bg-secondary">Belum ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Profil Karyawan</th>
                <td>
                    @if($user->employee)
                        <span class="badge bg-success">Sudah terhubung</span>
                        — {{ $user->employee->full_name }}
                    @else
                        <span class="badge bg-secondary">Belum ada</span>
                    @endif
                </td>
            </tr>
        </table>

    </div>
</div>


@endsection