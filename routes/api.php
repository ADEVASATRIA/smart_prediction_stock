<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CategoryProductController;




//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD DATA CUSTOMERS [ADMIN]
Route::middleware('admin')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

//ROUTE YANG DIGUNAKAN UNTUK PROSES LOGIN,REGISTER,LOGOUT, DLL
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user', [AuthController::class, 'index']);
});

//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD DATA CATEGORY PRODUCT [ADMIN]
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryProductController::class, 'index']);
    Route::post('/', [CategoryProductController::class, 'store']);
    Route::get('/{id}', [CategoryProductController::class, 'show']);
    Route::put('/{id}', [CategoryProductController::class, 'update']);
    Route::delete('/{id}', [CategoryProductController::class, 'destroy']);
});