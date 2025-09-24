<?php

use App\Http\Controllers\api\BannerController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\FcmTokenController;
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
Route::get('/users', [UserController::class, 'readAll']);
Route::get('/internet-packages', [InternetPackageController::class, 'readAll']);
Route::get('/banners', [BannerController::class, 'readAll']);
Route::get('/internet-installations', [InternetInstallationController::class, 'readAll']);
Route::get('/categories', [CategoryController::class, 'readAll']);



Route::middleware('auth:sanctum')->group(function (){
    // read all banners
    Route::get('/banners/list', [BannerController::class, 'readAllBanners']);
    // read all categories
    Route::get('/categories/list', [CategoryController::class, 'readAllCategories']);
    // read all internet packages
    Route::get('/internet-packages/list', [InternetPackageController::class, 'readAllInternetPackages']);
    // read internet packages by category
    Route::get('/internet-packages/category/{slug}', [InternetPackageController::class, 'readByCategory']);
    // search internet packages by name
    Route::get('/internet-packages/search/{name}', [InternetPackageController::class, 'searchByName']);
    // internet installation by user
    Route::post('/internet-installations/create', [InternetInstallationController::class, 'create']);
    // read internet installation by user
    Route::get('/internet-installations/user/{id}', [InternetInstallationController::class, 'readByUser']);
    // fcm token on user table
    Route::post('/update-fcm-token', [UserController::class, 'updateFcmToken']);
    Route::post('/remove-fcm-token', [UserController::class, 'removeFcmToken']);

   
});

Route::prefix('notifications')->group(function () {
    Route::post('/send-to-all', [FcmTokenController::class, 'sendToAll']);
    Route::post('/send-to-user/{userId}', [FcmTokenController::class, 'sendToUser']);
    Route::post('/send-to-region/{regionId}', [FcmTokenController::class, 'sendToRegion']);
});

