<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\NilaiController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/divisions', [DivisionController::class, 'index']);

    Route::get('/employees', [EmployeeController::class, 'index']);

    Route::apiResource('employees', EmployeeController::class);
});

Route::get('/nilaiRT', [NilaiController::class, 'hitungNilaiRT']);
Route::get('/nilaiST', [NilaiController::class, 'hitungNilaiST']);
