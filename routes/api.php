<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('login', [AuthController::class, 'handleLogin']);
Route::post('register', [AuthController::class, 'handleRegister']);
Route::resource('products', ProductController::class)->only(['index', 'show']);

// protected Routes
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('products', ProductController::class)->except(['index', 'show']);
        
});