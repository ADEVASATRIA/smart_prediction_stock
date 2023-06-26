<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\CustomerController;




//ROUTE YANG DIGUNAKAN UNTUK MELAKUKAN CRUD OLEH ADMIN
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