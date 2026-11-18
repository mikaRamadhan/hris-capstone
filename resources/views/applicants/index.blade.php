
@extends('layouts.hris')

@section('title', 'Data Pelamar')

@section('content')

<style>
    body {
        background: #f5f6fa;
        font-family: Arial, sans-serif;
    }

    .applicant-container {
        margin-top: 40px;
        margin-bottom: 50px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0,0,0,.06);
    }

    .btn-primary {
        background: #2563eb;
        border: none;
    }
</style>

<div class="container applicant-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Data Pelamar</h3>
            <p class="text-muted mb-0">
                Kelola informasi calon karyawan.
            </p>
        </div>

        <a href="{{ route('applicants.create') }}" class="btn btn-primary">
            + Tambah Pelamar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
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

    <div class="card p-4">

        <form method="GET"
              action="{{ route('applicants.index') }}"
              class="row g-2 mb-4">

            <div class="col-md-9">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama, telepon, atau universitas..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    Cari
                </button>

                <a href="{{ route('applicants.index') }}"
                   class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Pendidikan</th>
                        <th>Universitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($applicants as $applicant)

                        <tr>
                            <td>
                                {{ $applicants->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $applicant->full_name }}</td>

                            <td>
                                {{ $applicant->user?->email ?? '-' }}
                            </td>

                            <td>
                                {{ $applicant->phone_number ?? '-' }}
                            </td>

                            <td>
                                {{ $applicant->education ?? '-' }}
                            </td>

                            <td>
                                {{ $applicant->university ?? '-' }}
                            </td>

                            <td class="text-nowrap">

                                <a href="{{ route('applicants.show', $applicant->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    Detail
                                </a>

                                <a href="{{ route('applicants.edit', $applicant->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('applicants.destroy', $applicant->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Hapus data pelamar ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="text-center py-4 text-muted">
                                Belum ada data pelamar.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{ $applicants->links('pagination::bootstrap-5') }}

    </div>

</div>

@endsection
