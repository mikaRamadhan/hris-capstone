@extends('layouts.hris')

@section('title', 'Manajemen User')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen User</h1>
        <p class="text-muted mb-0">Kelola akun pengguna HRIS.</p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        + Tambah User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">

        <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-4">
            <div class="col-md-6">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama atau email..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="hrd" {{ request('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                    <option value="applicant" {{ request('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'hrd')
                                    <span class="badge bg-primary">HRD</span>
                                @elseif($user->role === 'applicant')
                                    <span class="badge bg-success">Applicant</span>
                                @else
                                    <span class="badge bg-secondary">{{ $user->role ?? 'Belum diatur' }}</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at?->format('d-m-Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection