<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\InternetInstallationController;
use App\Http\Controllers\InternetPackageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();

Route::middleware('admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Route::controller(InternetPackageController::class)->group(function (){
    Route::get('internet-packages', 'index')->name('internet-package.index');
    Route::get('internet-package/create', 'create')->name('internet-package.create');
    Route::post('internet-package/store', 'store')->name('internet-package.store');
    Route::get('internet-package/{id}/edit', 'edit')->name('internet-package.edit');
    Route::put('internet-package/{id}', 'update')->name('internet-package.update');
    Route::delete('internet-package/{id}', 'destroy')->name('internet-package.destroy');
});

Route::controller(BannerController::class)->group(function (){
    Route::get('banners', 'index')->name('banner.index');
    Route::get('banner/create', 'create')->name('banner.create');
    Route::post('banner/store', 'store')->name('banner.store');
    Route::get('banner/{id}/edit', 'edit')->name('banner.edit');
    Route::put('banner/{id}', 'update')->name('banner.update');
    Route::delete('banner/{id}', 'destroy')->name('banner.destroy');
});

// Route::resource('internet-installation', InternetInstallationController::class);
Route::get('internet-installation/{id}/set-status', [InternetInstallationController::class, 'setStatus'])
    ->name('internet-installation.status');

Route::controller(InternetInstallationController::class)->group(function () {
    Route::get('internet-installations', 'index')->name('internet-installation.index');
    Route::get('internet-installation/{id}', 'show')->name('internet-installation.show');
    Route::delete('internet-installation/{id}', 'destroy')->name('internet-installation.destroy'); 
});

Route::get('notification/create', [NotificationController::class, 'create'])->name('notification.create');

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');
