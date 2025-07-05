<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternetInstallationController;
use App\Http\Controllers\InternetPackageController;
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
    Route::get('internet-package', 'index')->name('internet-package.index');
    Route::get('internet-package/create', 'create')->name('internet-package.create');
    Route::post('internet-package/store', 'store')->name('internet-package.store');
    Route::get('internet-package/{id}/edit', 'edit')->name('internet-package.edit');
    Route::put('internet-package/{id}', 'update')->name('internet-package.update');
    Route::delete('internet-package/{id}', 'destroy')->name('internet-package.destroy');
});
// Route::resource('internet-installation', InternetInstallationController::class);
Route::get('internet-installation/{id}/set-status', [InternetInstallationController::class, 'setStatus'])
    ->name('internet-installation.status');

Route::controller(InternetInstallationController::class)->group(function () {
    Route::get('internet-installation', 'index')->name('internet-installation.index');
    Route::get('internet-installation/{id}', 'show')->name('internet-installation.show');
    Route::delete('internet-installation/{id}', 'destroy')->name('internet-installation.destroy'); 
});


Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');
