<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Public Routes
Route::post('login', [AuthController::class, 'handleLogin']);
Route::post('register', [AuthController::class, 'handleRegister']);
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Guest checkout routes
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/order-items', [OrderItemController::class, 'store']);

// protected Routes (Auth is required)
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::resource('/orders', OrderController::class)->except(['store']);     
});