<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CategoryProductController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;




//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD DATA CUSTOMERS [ADMIN]
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::put('/customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);
});

//ROUTE YANG DIGUNAKAN UNTUK PROSES LOGIN,REGISTER,LOGOUT, DLL
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('users', [AuthController::class, 'index']);
    Route::delete('users/{id}', [AuthController::class, 'destroy']);
});

//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD DATA CATEGORY PRODUCT [ADMIN]
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
    Route::get('categories', [CategoryProductController::class, 'index']);
    Route::get('categories/{id}', [CategoryProductController::class, 'show']);
    Route::post('categories', [CategoryProductController::class, 'store']);
    Route::put('categories/{id}', [CategoryProductController::class, 'update']);
    Route::delete('categories/{id}', [CategoryProductController::class, 'destroy']);
});

//ROUTE YANG DIGUNAKAN UNTUK MENJALANKAN CRUD DATA PRODUCT [ADMIN]
Route::middleware('auth:api')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});



//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD DATA USERS [ADMIN]
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});