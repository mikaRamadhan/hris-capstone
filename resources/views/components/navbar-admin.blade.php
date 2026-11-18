
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            HRIS - ADMIN
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarAdmin"
                aria-controls="navbarAdmin"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        Manajemen User
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('applicants.*') ? 'active' : '' }}"
                       href="{{ route('applicants.index') }}">
                        Data Pelamar
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('applications.*') ? 'active' : '' }}"
                       href="{{ route('applications.index') }}">
                        Data Lamaran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vacancies.*') ? 'active' : '' }}"
                       href="{{ route('vacancies.index') }}">
                        Lowongan Kerja
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                       href="{{ route('employees.index') }}">
                        Data Karyawan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('organizational-units.*') ? 'active' : '' }}"
                       href="{{ route('organizational-units.index') }}">
                        Unit Organisasi
                    </a>
                </li>

            </ul>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
