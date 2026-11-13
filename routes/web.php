
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\OrganizationalUnitController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantVacancyController;
use App\Http\Controllers\ApplicantApplicationController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $role = auth()->user()->role;

    if (in_array($role, ['admin', 'hrd'], true)) {
        return redirect()->route('users.index');
    }

    if ($role === 'applicant') {
        return redirect()->route('applicant.dashboard');
    }

    abort(403);

});

/*
|--------------------------------------------------------------------------
| Login dan Registrasi
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
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Applicant
|--------------------------------------------------------------------------
*/



Route::middleware(['auth', 'role:applicant'])->group(function () {

    // Dashboard Applicant
    Route::get('/applicant/dashboard', function () {
        return view('applicants.dashboard');
    })->name('applicant.dashboard');

    // Profil Applicant
    Route::get('/applicant/profile', [ApplicantProfileController::class, 'edit'])
        ->name('applicant.profile.edit');

    Route::put('/applicant/profile', [ApplicantProfileController::class, 'update'])
        ->name('applicant.profile.update');

    // Daftar Lowongan
    Route::get('/applicant/vacancies', [ApplicantVacancyController::class, 'index'])
        ->name('applicant.vacancies.index');

    // Detail Lowongan
    Route::get('/applicant/vacancies/{id}', [ApplicantVacancyController::class, 'show'])
    ->name('applicant.vacancies.show');

        // Pengajuan dan riwayat lamaran
    Route::get('/applicant/vacancies/{vacancyId}/apply', [
        ApplicantApplicationController::class,
        'create'
    ])->name('applicant.applications.create');

    Route::post('/applicant/vacancies/{vacancyId}/apply', [
        ApplicantApplicationController::class,
        'store'
    ])->name('applicant.applications.store');

    Route::get('/applicant/applications', [
        ApplicantApplicationController::class,
        'index'
    ])->name('applicant.applications.index');

    Route::get('/applicant/applications/{id}', [
        ApplicantApplicationController::class,
        'show'
    ])->name('applicant.applications.show');

});

/*
|--------------------------------------------------------------------------
| Dashboard dan Manajemen Admin / HRD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,hrd'])->group(function () {

    // Manajemen User
    Route::resource('users', UserController::class);

    // Manajemen Applicant
    Route::resource('applicants', ApplicantController::class);

    // Manajemen Lamaran
    Route::resource('applications', ApplicationController::class);

    // Manajemen Lowongan
    Route::resource('vacancies', VacancyController::class);

    // Manajemen Karyawan
    Route::resource('employees', EmployeeController::class);

    // Manajemen Departemen
    Route::resource('departments', DepartmentController::class);

    // Manajemen Jabatan
    Route::resource('positions', PositionController::class);

    // Manajemen Unit Organisasi
    Route::resource('organizational-units', OrganizationalUnitController::class);

});
