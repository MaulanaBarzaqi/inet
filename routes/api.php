<?php

use App\Http\Controllers\api\BannerController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\InternetInstallationController;
use App\Http\Controllers\api\InternetPackageController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('user')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
});
Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function (){
    // fcm token on user table
    Route::post('/update-fcm-token', [UserController::class, 'updateFcmToken']);
    Route::post('/remove-fcm-token', [UserController::class, 'removeFcmToken']);
    // read all banners
    Route::get('/banners', [BannerController::class, 'readAllBanners']);
    // read all categories
    Route::get('/categories', [CategoryController::class, 'readAllCategories']);
    // read all internet packages
    Route::get('/internet-packages', [InternetPackageController::class, 'readAllInternetPackages']);
    // read internet packages by category
    Route::get('/internet-packages/category/{slug}', [InternetPackageController::class, 'readByCategory']);
    // search internet packages by name
    Route::get('/internet-packages/search/{name}', [InternetPackageController::class, 'searchByName']);
    // internet installation by user
    Route::post('/internet-installations/create', [InternetInstallationController::class, 'create']);
    // read internet installation by user
    Route::get('/internet-installations/user/{id}', [InternetInstallationController::class, 'readByUser']);
});



