<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('videos', VideoController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('about', AboutController::class);
    Route::resource('advices', AdviceController::class);
    Route::resource('steps', StepController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments-data', [AppointmentController::class, 'data'])->name('appointments.data');
    Route::get('prescriptions', [AppointmentController::class, 'prescriptions'])->name('prescriptions.all');
    Route::get('prescriptions/{history}', [AppointmentController::class, 'viewPrescription'])->name('prescriptions.view');
    Route::get('prescriptions/{history}/edit', [AppointmentController::class, 'editPrescription'])->name('prescriptions.edit');
    Route::put('prescriptions/{history}', [AppointmentController::class, 'updatePrescription'])->name('prescriptions.update');
    Route::get('prescription/{id}/print', [AppointmentController::class, 'print'])->name('prescription.print');


    Route::get('chief-complaints/search', [AppointmentController::class, 'searchComplaint']);
});

require __DIR__ . '/auth.php';
