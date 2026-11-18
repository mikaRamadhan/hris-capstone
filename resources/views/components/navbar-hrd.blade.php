
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('hrd.dashboard') }}">
            HRIS - HRD
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarHrd"
                aria-controls="navbarHrd"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarHrd">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('hrd.dashboard') ? 'active' : '' }}"
                       href="{{ route('hrd.dashboard') }}">
                        Dashboard
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
                        Lamaran & Seleksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vacancies.*') ? 'active' : '' }}"
                       href="{{ route('vacancies.index') }}">
                        Lowongan Kerja
                    </a>
                </li>

            </ul>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
