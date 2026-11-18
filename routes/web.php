
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

// Models
use App\Models\User;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Vacancy;
use App\Models\Employee;
use App\Models\OrganizationalUnit;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrganizationalUnitController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantVacancyController;
use App\Http\Controllers\ApplicantApplicationController;
use App\Http\Controllers\SelectionResultController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    switch (auth()->user()->role) {

        case 'admin':
            return redirect()->route('admin.dashboard');

        case 'hrd':
            return redirect()->route('hrd.dashboard');

        case 'applicant':
            return redirect()->route('applicant.dashboard');

        default:
            auth()->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Role akun tidak dikenali. Silakan login kembali.');
    }

})->name('home');


/*
|--------------------------------------------------------------------------
| LOGIN DAN REGISTRASI
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {

        $totalUsers = User::count();
        $totalApplicants = Applicant::count();
        $totalApplications = Application::count();
        $totalVacancies = Vacancy::count();
        $totalEmployees = Employee::count();
        $totalOrganizationalUnits = OrganizationalUnit::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalApplicants',
            'totalApplications',
            'totalVacancies',
            'totalEmployees',
            'totalOrganizationalUnits'
        ));

    })->name('admin.dashboard');


    // Manajemen User
    Route::resource('users', UserController::class);


    // Manajemen Unit Organisasi
    Route::resource(
        'organizational-units',
        OrganizationalUnitController::class
    );

});


/*
|--------------------------------------------------------------------------
| ADMIN DAN HRD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,hrd'])->group(function () {

    // Data Pelamar
    Route::resource('applicants', ApplicantController::class);


    // Perubahan status lamaran tanpa form edit
    Route::patch(
        '/applications/{id}/status',
        [ApplicationController::class, 'updateStatus']
    )->name('applications.update-status');


    // Data Lamaran
    Route::resource('applications', ApplicationController::class);


    // Lowongan Kerja
    Route::resource('vacancies', VacancyController::class);


    // Data Karyawan
    Route::resource('employees', EmployeeController::class);


    // Hasil Seleksi
    Route::get(
        '/applications/{application}/selection-results',
        [SelectionResultController::class, 'index']
    )->name('selection-results.index');

    Route::post(
        '/applications/{application}/selection-results',
        [SelectionResultController::class, 'store']
    )->name('selection-results.store');

    Route::put(
        '/applications/{application}/selection-results/{selectionResult}',
        [SelectionResultController::class, 'update']
    )->name('selection-results.update');

    Route::delete(
        '/applications/{application}/selection-results/{selectionResult}',
        [SelectionResultController::class, 'destroy']
    )->name('selection-results.destroy');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD HRD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hrd'])->group(function () {

    Route::get('/hrd/dashboard', function () {

        // Ringkasan data
        $totalApplicants = DB::table('applicants')->count();

        $totalApplications = DB::table('applications')->count();

        $totalVacancies = DB::table('vacancies')
            ->where('status', 'open')
            ->count();

        $totalEmployees = DB::table('employees')->count();


        // Statistik status lamaran
        $totalSubmitted = DB::table('applications')
            ->where('status', 'submitted')
            ->count();

        $totalReviewing = DB::table('applications')
            ->where('status', 'reviewing')
            ->count();

        $totalAccepted = DB::table('applications')
            ->where('status', 'accepted')
            ->count();

        $totalRejected = DB::table('applications')
            ->where('status', 'rejected')
            ->count();


        // Data grafik distribusi status
        $statusLabels = [
            'Terkirim',
            'Sedang Ditinjau',
            'Diterima',
            'Ditolak',
        ];

        $statusTotals = [
            $totalSubmitted,
            $totalReviewing,
            $totalAccepted,
            $totalRejected,
        ];


        // Data tren lamaran enam bulan terakhir
        $monthlyApplications = DB::table('applications')
            ->select(
                DB::raw('YEAR(applied_at) as year'),
                DB::raw('MONTH(applied_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where(
                'applied_at',
                '>=',
                Carbon::now()->subMonths(5)->startOfMonth()
            )
            ->groupBy(
                DB::raw('YEAR(applied_at)'),
                DB::raw('MONTH(applied_at)')
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyApplicationsData = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $monthlyLabels[] = $date->translatedFormat('M Y');

            $data = $monthlyApplications->first(function ($item) use ($date) {

                return (int) $item->year === (int) $date->year
                    && (int) $item->month === (int) $date->month;

            });

            $monthlyApplicationsData[] = $data
                ? (int) $data->total
                : 0;
        }


        // Lima lowongan dengan lamaran terbanyak
        $topVacancies = DB::table('vacancies')
            ->leftJoin(
                'applications',
                'vacancies.id',
                '=',
                'applications.vacancy_id'
            )
            ->select(
                'vacancies.title',
                DB::raw('COUNT(applications.id) as total')
            )
            ->groupBy(
                'vacancies.id',
                'vacancies.title'
            )
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topVacancyLabels = $topVacancies->pluck('title');
        $topVacancyTotals = $topVacancies->pluck('total');


        // Enam lamaran terbaru
        $latestApplications = Application::with([
            'applicant',
            'vacancy',
        ])
            ->latest('applied_at')
            ->take(6)
            ->get();


        return view('hrd.dashboard', compact(
            'totalApplicants',
            'totalApplications',
            'totalVacancies',
            'totalEmployees',

            'totalSubmitted',
            'totalReviewing',
            'totalAccepted',
            'totalRejected',

            'statusLabels',
            'statusTotals',

            'monthlyLabels',
            'monthlyApplicationsData',

            'topVacancyLabels',
            'topVacancyTotals',

            'latestApplications'
        ));

    })->name('hrd.dashboard');

});


/*
|--------------------------------------------------------------------------
| APPLICANT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:applicant'])->group(function () {

    // Dashboard Applicant
    Route::get('/applicant/dashboard', function () {
        return view('applicants.dashboard');
    })->name('applicant.dashboard');


    // Profil Applicant
    Route::get('/applicant/profile', [
        ApplicantProfileController::class,
        'edit'
    ])->name('applicant.profile.edit');

    Route::put('/applicant/profile', [
        ApplicantProfileController::class,
        'update'
    ])->name('applicant.profile.update');


    // Daftar Lowongan
    Route::get('/applicant/vacancies', [
        ApplicantVacancyController::class,
        'index'
    ])->name('applicant.vacancies.index');


    // Detail Lowongan
    Route::get('/applicant/vacancies/{id}', [
        ApplicantVacancyController::class,
        'show'
    ])->name('applicant.vacancies.show');


    // Form Pengajuan Lamaran
    Route::get('/applicant/vacancies/{vacancyId}/apply', [
        ApplicantApplicationController::class,
        'create'
    ])->name('applicant.applications.create');


    // Simpan Pengajuan Lamaran
    Route::post('/applicant/vacancies/{vacancyId}/apply', [
        ApplicantApplicationController::class,
        'store'
    ])->name('applicant.applications.store');


    // Riwayat Lamaran
    Route::get('/applicant/applications', [
        ApplicantApplicationController::class,
        'index'
    ])->name('applicant.applications.index');


    // Detail Lamaran
    Route::get('/applicant/applications/{id}', [
        ApplicantApplicationController::class,
        'show'
    ])->name('applicant.applications.show');

});
