<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JamaahController;
use App\Http\Controllers\JadwalsholatController;
use App\Http\Controllers\HomeuserController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\UserKajianController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

// Landing Page Route (Accessible by Guests)
Route::get('/', [GuestController::class, 'index'])->name('welcome');

// Infaq Routes (Accessible by Authenticated Users - Admin & User)
Route::middleware(['auth'])->group(function () {
    Route::get('/infaq/create', [HomeuserController::class, 'create'])->name('home.create');
    Route::post('/infaq/store', [HomeuserController::class, 'store'])->name('home.store');
});

// Admin Routes (Requires Admin Role)
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/testadmin', function () {
        return 'Welcome Admin';
    });

    // Admin Home (Jamaah Management)
    Route::get('/home', [JamaahController::class, 'index'])->name('home'); // Admin dashboard
    Route::get('/jamaah', [JamaahController::class, 'getData'])->name('jamaah.index'); // DataTables for Jamaah

    // Infaq Routes (Admin)
    Route::get('/jamaah/{id}', [JamaahController::class, 'show'])->name('infaq.show');
    Route::get('/jamaah/{id}/edit', [JamaahController::class, 'edit'])->name('infaq.edit');
    Route::put('/jamaah/{id}', [JamaahController::class, 'update'])->name('infaq.update');
    Route::delete('/jamaah/{id}', [JamaahController::class, 'destroy'])->name('infaq.destroy');
});

// User Routes (Requires User Role)
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/testuser', function () {
        return 'Welcome User';
    });

    // User Infaq Routes
    Route::get('/homeuser', [HomeuserController::class, 'index'])->name('homeuser');
    Route::get('/homeuser/infaq/{id}', [HomeuserController::class, 'show'])->name('homeuser.infaq.show');
    Route::get('/homeuser/infaq/{id}/edit', [HomeuserController::class, 'edit'])->name('homeuser.infaq.edit');
    Route::put('/homeuser/infaq/{id}', [HomeuserController::class, 'update'])->name('homeuser.infaq.update');
    Route::delete('/homeuser/infaq/{id}', [HomeuserController::class, 'destroy'])->name('homeuser.infaq.destroy');

    // Store Infaq for Users
    Route::post('/homeuser/store', [HomeuserController::class, 'store'])->name('homeuser.store');
});

// Redirect route for role-based home redirection
Route::get('/redirect', [HomeuserController::class, 'redirectToHome'])->name('redirectToHome');

// Prayer Schedule Routes (Accessible by Authenticated Users)
Route::get('/sholat/jadwal', [JadwalsholatController::class, 'showForm'])->name('sholat.form');
Route::post('/sholat/jadwal', [JadwalsholatController::class, 'getJadwalSholat'])->name('sholat.result');

// Kajian Routes (Accessible by All Authenticated Users)
Route::resource('kajians', KajianController::class);

// User Kajian Routes (View Kajian for Users)
Route::get('user/kajians', [UserKajianController::class, 'index'])->name('user.kajians.index');
Route::get('user/kajians/{kajian}', [UserKajianController::class, 'show'])->name('user.kajians.show');

// Feedback Routes (Accessible by All Authenticated Users)
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::post('/feedback', [FeedbackController::class, 'send'])->name('feedback.send');
