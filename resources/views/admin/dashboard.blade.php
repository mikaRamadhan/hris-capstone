
@extends('layouts.hris')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    .dashboard-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 3px 15px rgba(0,0,0,.05);
        transition: .2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
    }

    .dashboard-number {
        font-size: 30px;
        font-weight: 700;
    }

    .dashboard-link {
        text-decoration: none;
        color: inherit;
    }

    .dashboard-link:hover {
        color: inherit;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Dashboard Admin</h2>
        <p class="text-muted mb-0">
            Selamat datang, {{ auth()->user()->name }}.
            Berikut ringkasan pengelolaan sistem HRIS.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- TOTAL USER --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('users.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Total Pengguna</div>
                        <div class="dashboard-number text-primary">
                            {{ $totalUsers }}
                        </div>
                        <div class="small text-muted mt-2">
                            Manajemen akun pengguna
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL PELAMAR --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('applicants.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Total Pelamar</div>
                        <div class="dashboard-number text-success">
                            {{ $totalApplicants }}
                        </div>
                        <div class="small text-muted mt-2">
                            Data calon karyawan
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL LAMARAN --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('applications.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Total Lamaran</div>
                        <div class="dashboard-number text-warning">
                            {{ $totalApplications }}
                        </div>
                        <div class="small text-muted mt-2">
                            Data pengajuan lamaran
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL LOWONGAN --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('vacancies.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Total Lowongan</div>
                        <div class="dashboard-number text-info">
                            {{ $totalVacancies }}
                        </div>
                        <div class="small text-muted mt-2">
                            Data lowongan pekerjaan
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL KARYAWAN --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('employees.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Total Karyawan</div>
                        <div class="dashboard-number text-danger">
                            {{ $totalEmployees }}
                        </div>
                        <div class="small text-muted mt-2">
                            Data karyawan perusahaan
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL UNIT ORGANISASI --}}
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('organizational-units.index') }}" class="dashboard-link">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="text-muted mb-2">Unit Organisasi</div>
                        <div class="dashboard-number text-secondary">
                            {{ $totalOrganizationalUnits }}
                        </div>
                        <div class="small text-muted mt-2">
                            Departemen dan posisi
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- AKSES CEPAT --}}
    <div class="card dashboard-card mt-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Akses Cepat</h5>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('users.create') }}"
                   class="btn btn-primary">
                    + Tambah User
                </a>

                <a href="{{ route('vacancies.create') }}"
                   class="btn btn-success">
                    + Tambah Lowongan
                </a>

                <a href="{{ route('organizational-units.create') }}"
                   class="btn btn-secondary">
                    + Tambah Unit Organisasi
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
