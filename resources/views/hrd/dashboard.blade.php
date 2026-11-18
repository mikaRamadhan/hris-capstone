
@extends('layouts.hris')

@section('title', 'Dashboard HRD')

@section('content')

<div class="container-fluid py-4 hrd-dashboard">

    {{-- HEADER --}}
    <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <span class="header-label">HUMAN RESOURCE MANAGEMENT</span>
            <h2 class="fw-bold mb-1">Dashboard HRD</h2>
            <p class="text-muted mb-0">
                Selamat datang, {{ auth()->user()->name }}.
                Pantau aktivitas rekrutmen dan pengelolaan karyawan.
            </p>
        </div>

        <div class="date-card">
            <i class="bi bi-calendar3 me-2"></i>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>


    {{-- STATISTIK UTAMA --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-label">Total Pelamar</div>
                <div class="stat-value">
                    {{ number_format($totalApplicants) }}
                </div>
                <div class="stat-caption">Profil calon karyawan</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="stat-label">Total Lamaran</div>
                <div class="stat-value">
                    {{ number_format($totalApplications) }}
                </div>
                <div class="stat-caption">Lamaran pekerjaan masuk</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-label">Lamaran Terkirim</div>
                <div class="stat-value">
                    {{ number_format($totalSubmitted) }}
                </div>
                <div class="stat-caption">Menunggu pemeriksaan HRD</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card stat-green">
                <div class="stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-label">Lamaran Diterima</div>
                <div class="stat-value">
                    {{ number_format($totalAccepted) }}
                </div>
                <div class="stat-caption">Kandidat yang diterima</div>
            </div>
        </div>

    </div>


    {{-- STATISTIK TAMBAHAN --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-6">
            <div class="mini-stat">
                <div>
                    <span>Sedang Ditinjau</span>
                    <h4>{{ number_format($totalReviewing) }}</h4>
                </div>
                <i class="bi bi-search text-primary"></i>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="mini-stat">
                <div>
                    <span>Lamaran Ditolak</span>
                    <h4>{{ number_format($totalRejected) }}</h4>
                </div>
                <i class="bi bi-x-circle text-danger"></i>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="mini-stat">
                <div>
                    <span>Lowongan Aktif</span>
                    <h4>{{ number_format($totalVacancies) }}</h4>
                </div>
                <i class="bi bi-briefcase text-success"></i>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="mini-stat">
                <div>
                    <span>Total Karyawan</span>
                    <h4>{{ number_format($totalEmployees) }}</h4>
                </div>
                <i class="bi bi-person-workspace text-info"></i>
            </div>
        </div>

    </div>


    {{-- GRAFIK --}}
    <div class="row g-4 mb-4">

        {{-- Grafik tren lamaran --}}
        <div class="col-xl-8">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Tren Lamaran</h5>
                        <p>Perkembangan jumlah lamaran selama enam bulan terakhir</p>
                    </div>

                    <span class="chart-tag">
                        <i class="bi bi-graph-up me-1"></i>
                        6 Bulan Terakhir
                    </span>
                </div>

                <div class="chart-container">
                    <canvas id="monthlyApplicationsChart"></canvas>
                </div>

            </div>
        </div>


        {{-- Grafik status lamaran --}}
        <div class="col-xl-4">
            <div class="dashboard-card h-100">

                <div class="card-heading">
                    <div>
                        <h5>Status Lamaran</h5>
                        <p>Distribusi status seluruh lamaran</p>
                    </div>
                </div>

                <div class="status-chart-container">
                    <canvas id="applicationStatusChart"></canvas>
                </div>

                <div class="status-legend">
                    <div>
                        <span class="legend-dot dot-submitted"></span>
                        Terkirim
                    </div>

                    <div>
                        <span class="legend-dot dot-reviewing"></span>
                        Ditinjau
                    </div>

                    <div>
                        <span class="legend-dot dot-accepted"></span>
                        Diterima
                    </div>

                    <div>
                        <span class="legend-dot dot-rejected"></span>
                        Ditolak
                    </div>
                </div>

            </div>
        </div>

    </div>


    {{-- GRAFIK LOWONGAN TERPOPULER --}}
    <div class="dashboard-card mb-4">

        <div class="card-heading">
            <div>
                <h5>Lowongan Paling Diminati</h5>
                <p>Lima lowongan dengan jumlah lamaran terbanyak</p>
            </div>
        </div>

        <div class="top-vacancy-chart">
            <canvas id="topVacancyChart"></canvas>
        </div>

    </div>


    {{-- LAMARAN TERBARU --}}
    <div class="dashboard-card mb-4">

        <div class="card-heading">
            <div>
                <h5>Lamaran Terbaru</h5>
                <p>Aktivitas lamaran pekerjaan yang baru masuk</p>
            </div>

            <a href="{{ route('applications.index') }}"
               class="btn btn-primary btn-sm">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">

            <table class="table align-middle dashboard-table mb-0">

                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Posisi Dilamar</th>
                        <th>Tanggal Lamaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($latestApplications as $application)

                        @php
                            $status = strtolower($application->status);

                            $statusLabelsMap = [
                                'submitted' => 'Terkirim',
                                'reviewing' => 'Sedang Ditinjau',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp

                        <tr>

                            <td>
                                <div class="applicant-cell">

                                    <div class="applicant-avatar">
                                        {{ strtoupper(substr($application->applicant?->full_name ?? 'P', 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $application->applicant?->full_name ?? 'Pelamar tidak tersedia' }}
                                        </strong>
                                        <small>Pelamar</small>
                                    </div>

                                </div>
                            </td>

                            <td>
                                {{ $application->vacancy?->title ?? '-' }}
                            </td>

                            <td>
                                {{ $application->applied_at?->format('d M Y') ?? '-' }}
                            </td>

                            <td>
                                <span class="status-pill status-{{ $status }}">
                                    {{ $statusLabelsMap[$status] ?? ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('applications.show', $application->id) }}"
                                   class="btn btn-light btn-sm">
                                    Detail
                                    <i class="bi bi-arrow-up-right ms-1"></i>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada lamaran yang masuk.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- AKSES CEPAT --}}
    <div class="dashboard-card">

        <div class="card-heading">
            <div>
                <h5>Akses Cepat</h5>
                <p>Menu utama pengelolaan Human Resources</p>
            </div>
        </div>

        <div class="row g-3">

            <div class="col-md-3 col-6">
                <a href="{{ route('applicants.index') }}" class="quick-link">
                    <i class="bi bi-people"></i>
                    <span>Data Pelamar</span>
                    <small>Kelola profil pelamar</small>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="{{ route('applications.index') }}" class="quick-link">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Lamaran & Seleksi</span>
                    <small>Periksa proses rekrutmen</small>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="{{ route('vacancies.index') }}" class="quick-link">
                    <i class="bi bi-briefcase"></i>
                    <span>Lowongan Kerja</span>
                    <small>Kelola informasi lowongan</small>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="{{ route('employees.index') }}" class="quick-link">
                    <i class="bi bi-person-workspace"></i>
                    <span>Data Karyawan</span>
                    <small>Kelola data karyawan</small>
                </a>
            </div>

        </div>

    </div>

</div>


{{-- STYLE DASHBOARD --}}
<style>

    .hrd-dashboard {
        color: #1e293b;
    }

    .dashboard-header {
        padding: 8px 2px 12px;
    }

    .header-label {
        display: inline-block;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }

    .dashboard-header h2 {
        color: #172554;
        font-size: 27px;
    }

    .date-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        padding: 11px 16px;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }

    /* Statistik utama */

    .stat-card {
        position: relative;
        overflow: hidden;
        min-height: 160px;
        padding: 21px;
        border-radius: 17px;
        background: #fff;
        border: 1px solid #edf0f6;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        width: 115px;
        height: 115px;
        border-radius: 50%;
        right: -35px;
        bottom: -48px;
        background: currentColor;
        opacity: .055;
    }

    .stat-blue { color: #2563eb; }
    .stat-purple { color: #7c3aed; }
    .stat-orange { color: #ea580c; }
    .stat-green { color: #059669; }

    .stat-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: currentColor;
        color: white;
        font-size: 20px;
        margin-bottom: 14px;
    }

    .stat-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-value {
        color: #172554;
        font-size: 29px;
        font-weight: 800;
        line-height: 1.3;
        margin-top: 3px;
    }

    .stat-caption {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 4px;
    }

    /* Statistik tambahan */

    .mini-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border: 1px solid #edf0f6;
        border-radius: 14px;
        padding: 17px 20px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .035);
    }

    .mini-stat span {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .mini-stat h4 {
        color: #172554;
        font-weight: 800;
        margin: 5px 0 0;
    }

    .mini-stat i {
        font-size: 27px;
    }

    /* Kartu dashboard */

    .dashboard-card {
        background: #fff;
        border: 1px solid #edf0f6;
        border-radius: 17px;
        padding: 23px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
    }

    .card-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 22px;
    }

    .card-heading h5 {
        color: #172554;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .card-heading p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    .chart-tag {
        white-space: nowrap;
        border-radius: 20px;
        padding: 7px 11px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
    }

    .chart-container {
        height: 290px;
        position: relative;
    }

    .status-chart-container {
        height: 225px;
        position: relative;
    }

    .top-vacancy-chart {
        height: 260px;
        position: relative;
    }

    /* Legenda grafik */

    .status-legend {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 15px;
        color: #64748b;
        font-size: 12px;
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        display: inline-block;
        border-radius: 50%;
        margin-right: 6px;
    }

    .dot-submitted { background: #3b82f6; }
    .dot-reviewing { background: #f59e0b; }
    .dot-accepted { background: #10b981; }
    .dot-rejected { background: #ef4444; }

    /* Tabel lamaran */

    .dashboard-table thead th {
        color: #94a3b8;
        background: #f8fafc;
        border: 0;
        padding: 13px 15px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        padding: 14px 15px;
        border-color: #f1f5f9;
        color: #475569;
        font-size: 13px;
    }

    .applicant-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .applicant-avatar {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 800;
    }

    .applicant-cell strong {
        display: block;
        color: #1e293b;
        font-size: 12px;
    }

    .applicant-cell small {
        color: #94a3b8;
        font-size: 10px;
    }

    .status-pill {
        display: inline-block;
        border-radius: 20px;
        padding: 6px 10px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-submitted {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-reviewing {
        background: #fffbeb;
        color: #b45309;
    }

    .status-accepted {
        background: #ecfdf5;
        color: #047857;
    }

    .status-rejected {
        background: #fef2f2;
        color: #b91c1c;
    }

    /* Akses cepat */

    .quick-link {
        height: 100%;
        min-height: 125px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 17px;
        text-decoration: none;
        border: 1px solid #edf0f6;
        border-radius: 13px;
        transition: .2s ease;
    }

    .quick-link:hover {
        border-color: #93c5fd;
        background: #f8fbff;
        transform: translateY(-3px);
    }

    .quick-link i {
        color: #2563eb;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .quick-link span {
        color: #1e293b;
        font-size: 13px;
        font-weight: 800;
    }

    .quick-link small {
        color: #94a3b8;
        font-size: 10px;
        margin-top: 4px;
    }

    @media (max-width: 576px) {

        .dashboard-card {
            padding: 16px;
        }

        .dashboard-header h2 {
            font-size: 23px;
        }

        .chart-container {
            height: 240px;
        }

        .top-vacancy-chart {
            height: 230px;
        }

    }

</style>


{{-- BOOTSTRAP ICONS --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


{{-- SCRIPT GRAFIK --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    // Data grafik dari Controller / Route
    const monthlyLabels = @json($monthlyLabels);
    const monthlyData = @json($monthlyApplicationsData);

    const statusLabels = @json($statusLabels);
    const statusData = @json($statusTotals);

    const topVacancyLabels = @json($topVacancyLabels);
    const topVacancyData = @json($topVacancyTotals);


    // Grafik tren lamaran
    const monthlyCanvas = document.getElementById('monthlyApplicationsChart');

    if (monthlyCanvas) {

        new Chart(monthlyCanvas, {
            type: 'line',

            data: {
                labels: monthlyLabels,

                datasets: [{
                    label: 'Jumlah Lamaran',
                    data: monthlyData,

                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.10)',

                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,

                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#172554',
                        padding: 12,
                        displayColors: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    }


    // Grafik distribusi status
    const statusCanvas = document.getElementById('applicationStatusChart');

    if (statusCanvas) {

        new Chart(statusCanvas, {
            type: 'doughnut',

            data: {
                labels: statusLabels,

                datasets: [{
                    data: statusData,

                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#10b981',
                        '#ef4444'
                    ],

                    borderWidth: 0,
                    hoverOffset: 7
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                cutout: '72%',

                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

    }


    // Grafik lowongan paling diminati
    const topVacancyCanvas = document.getElementById('topVacancyChart');

    if (topVacancyCanvas) {

        new Chart(topVacancyCanvas, {
            type: 'bar',

            data: {
                labels: topVacancyLabels,

                datasets: [{
                    label: 'Jumlah Lamaran',
                    data: topVacancyData,

                    backgroundColor: [
                        '#2563eb',
                        '#7c3aed',
                        '#0891b2',
                        '#059669',
                        '#ea580c'
                    ],

                    borderRadius: 8,
                    maxBarThickness: 45
                }]
            },

            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#172554',
                        padding: 12
                    }
                },

                scales: {
                    x: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    }

});

</script>

@endsection
