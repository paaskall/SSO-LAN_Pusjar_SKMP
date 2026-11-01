<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // TAMBAHKAN INI: Endpoint untuk melengkapi profil
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);

     // Endpoint Khusus Super Admin
    Route::get('/admin/users', [AdminController::class, 'index']);
    Route::post('/admin/users/{id}/access', [AdminController::class, 'updateAccess']);
});