<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InternetInstallationController;
use App\Http\Controllers\InternetPackageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\TermsAndConditionsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['logout'   => false]);

Route::middleware('admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::controller(CategoryController::class)->group(function (){
    Route::get('categories', 'index')->name('category.index');
    Route::get('category/create', 'create')->name('category.create');
    Route::post('category/store', 'store')->name('category.store');
    Route::get('category/{category:slug}/edit', 'edit')->name('category.edit');
    Route::put('category/{category:slug}', 'update')->name('category.update');
    Route::delete('category/{category:slug}', 'destroy')->name('category.destroy');
});

Route::controller(InternetPackageController::class)->group(function (){
    Route::get('internet-packages', 'index')->name('internet-package.index');
    Route::get('internet-package/create', 'create')->name('internet-package.create');
    Route::post('internet-package/store', 'store')->name('internet-package.store');
    Route::get('internet-package/{internet_package:slug}/edit', 'edit')->name('internet-package.edit');
    Route::put('internet-package/{internet_package:slug}', 'update')->name('internet-package.update');
    Route::delete('internet-package/{internet_package:slug}', 'destroy')->name('internet-package.destroy');
});

Route::controller(BannerController::class)->group(function (){
    Route::get('banners', 'index')->name('banner.index');
    Route::get('banner/create', 'create')->name('banner.create');
    Route::post('banner/store', 'store')->name('banner.store');
    Route::get('banner/{banner:slug}/edit', 'edit')->name('banner.edit');
    Route::put('banner/{banner:slug}', 'update')->name('banner.update');
    Route::delete('banner/{banner:slug}', 'destroy')->name('banner.destroy');
});

Route::controller(RegionController::class)->group(function(){
    Route::get('regions', 'index')->name('region.index');
    Route::get('region/create', 'create')->name('region.create');
    Route::post('region/store', 'store')->name('region.store');
    Route::get('region/{region:slug}', 'show')->name('region.show');
    Route::get('region/{region:slug}/edit', 'edit')->name('region.edit');
    Route::put('region/{region:slug}', 'update')->name('region.update');
    Route::delete('region/{region:slug}', 'destroy')->name('region.destroy');
});

Route::controller(InternetInstallationController::class)->group(function () {
    Route::get('internet-installations', 'index')->name('internet-installation.index');
    Route::get('internet-installation/{internet_installation:uuid}', 'show')->name('internet-installation.show');
    Route::delete('internet-installation/{internet_installation:uuid}', 'destroy')->name('internet-installation.destroy'); 
    Route::put('internet-installation/{internet_installation:uuid}/status', 'setStatus')->name('internet-installation.status');
});

Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index')->name('user.index');
    Route::get('user/{user:uuid}', 'show')->name('user.show');
    Route::put('user/{user:uuid}/set-region', 'setRegion')->name('user.region');
});

Route::controller(NotificationController::class)->group(function() {
    Route::get('notifications/create', 'create')->name('notifications.create');
    Route::post('notifications/send', 'send')->name('notifications.send');
    Route::get('notifications/report', 'report')->name('notifications.report');
    Route::delete('notifications/{id}', 'destroy')->name('notifications.destroy');
    Route::get('/notifications/report/pdf', 'exportPdf')->name('notifications.report.pdf');
});

Route::get('terms-and-conditions', [TermsAndConditionsController::class, 'index'])->name('terms.and.conditions');


Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');
