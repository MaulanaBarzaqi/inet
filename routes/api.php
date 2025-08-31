<?php

use App\Http\Controllers\api\BannerController;
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



Route::middleware('auth:sanctum')->group(function (){
    // recommendation for internet packages
    Route::get('/internet-packages/recommendation/limit', [InternetPackageController::class, 'readRecommendationLimit']);
    // get banner list
    Route::get('/banners/list', [BannerController::class, 'getBannerList']);
    // search internet packages by name
    Route::get('/internet-packages/search/{name}', [InternetPackageController::class, 'searchByName']);
    // read internet packages by category corporate
    Route::get('/internet-packages/category/corporate', [InternetPackageController::class, 'readByCategoryCorporate']);
    // read internet packages by category student
    Route::get('/internet-packages/category/student', [InternetPackageController::class, 'readByCategoryStudent']);
    // read internet packages by category family
    Route::get('/internet-packages/category/family', [InternetPackageController::class, 'readByCategoryFamily']);
    // internet installation by user
    Route::post('/internet-installations/create', [InternetInstallationController::class, 'create']);
    // read internet installation by user
    Route::get('/internet-installations/user/{id}', [InternetInstallationController::class, 'readByUser']);
});