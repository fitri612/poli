<?php

use App\Http\Controllers\Admin\DrugController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\Users\DoctorController;
use App\Http\Controllers\Admin\Users\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Docter\ScheduleController;
use App\Http\Controllers\Doctor\CheckupController;
use App\Http\Controllers\Doctor\HistoryController;
use App\Http\Controllers\Doctor\ScheduleDoctorController;
use App\Http\Controllers\Patient\PoliController as PatientPoliController;
use App\Http\Controllers\PatientController as ControllersPatientController;
use App\Models\Doctor;
use App\Models\Poli;
use App\Models\ServiceSchedule;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('client.contents.index');
});

Route::get('/register/patient', function () {
    return view('client.register-rm');
})->name('register.patient.view');

Route::post('/register/patient', [ControllersPatientController::class, 'register'])->name('register.patient');
Route::post('/register/poli', [ControllersPatientController::class, 'registerPoli'])->name('register.poli');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('auth')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/patient/poli-register', function () {
    $polis = Poli::all();
    $dataSchedules = ServiceSchedule::with('doctor')->get();
    $schedules = [];
    foreach ($dataSchedules as $schedule) {
        if ($schedule->is_active == 1) {
            array_push($schedules, $schedule);
        }
    }

    return view('client.index', compact('polis', 'schedules'));
})->name('get.register.poli');

Route::get('/info-doctor', function () {
    $doctor = Doctor::all();
    $service = ServiceSchedule::all();
    return view('dashboard.doctor.list-dokter.index', compact('doctor', 'service'));
})->name('info.doctor');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::prefix('patient')->middleware(['auth', 'patient', 'active'])->name('patient.')->group(function () {
        Route::resource('poli', PatientPoliController::class);
    });
    Route::prefix('admin')->middleware(['auth', 'admin', 'active'])->name('admin.')->group(function () {
        Route::resource('drug', DrugController::class);
        Route::resource('poli', PoliController::class);
        Route::prefix('users')->name('users.')->group(function () {
            Route::resource('doctor', DoctorController::class);
            Route::resource('patient', PatientController::class);
        });
    });
    Route::prefix('doctor')->middleware(['auth', 'doctor', 'active'])->name('doctor.')->group(function () {
        Route::resource('schedule', ScheduleDoctorController::class);

        Route::get('checkup', [CheckupController::class, 'index'])->name('checkup.index');
        Route::get('checkup/{id}', [CheckupController::class, 'checkupForm'])->name('checkup.form');
        Route::post('checkup/{id}', [CheckupController::class, 'checkup'])->name('checkup');
        Route::put('checkup/{id}/update', [CheckupController::class, 'update'])->name('checkup.update');

        Route::get('history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('history/{id}', [HistoryController::class, 'show'])->name('history.show');
    });
});
