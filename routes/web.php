<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::group(['middleware' => ['check.role:admin,dinas', 'auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // booking
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'destroy']);
    // travel packages
    Route::resource('travel_packages', \App\Http\Controllers\Admin\TravelPackageController::class)->except('show');
    Route::resource('travel_packages.galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['create', 'index', 'show']);
    // categories
    // Route::resource('categories', CategoryController::class)->except('show');
    // locations
    Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class)->except('show');
    // profile
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('homepage');
// travel packages
Route::get('travel-packages', [\App\Http\Controllers\TravelPackageController::class, 'index'])->name('travel_package.index');
Route::get('travel-packages/{travel_package:slug}', [\App\Http\Controllers\TravelPackageController::class, 'show'])->name('travel_package.show');
// location
Route::get('Location', [\App\Http\Controllers\LokasiWisatacontroller::class, 'index'])->name('location.index');
// contact
Route::get('contact', function () {
    return view('contact');
})->name('contact');
//location

// booking
Route::post('booking', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

//excel exports
Route::get('excel/export/laporan-pemesanan', [\App\Http\Controllers\LaporanController::class, 'laporanExcelPesanan'])->name('excel.export.pemesanan');
