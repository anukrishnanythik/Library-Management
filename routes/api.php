<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\BookController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
    });

    Route::middleware('role:member')->group(function () {
        Route::controller(ReservationController::class)->group(function () {
            Route::post('/reservations', 'store');
            Route::get('/reservations/my', 'view');
        });

        Route::get('/books/search/{query}', [BookController::class, 'search']);
    });
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
