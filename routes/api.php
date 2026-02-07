<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReportController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/books/search/{query}', [BookController::class, 'search']);

    Route::middleware('role:member')->group(function () {
        Route::controller(ReservationController::class)->group(function () {
            Route::post('/reservations', 'create');
            Route::get('/reservations/my', 'view');
        });
    });

    Route::middleware('role:librarian')->group(function () {
        Route::apiResource('books', BookController::class)->only(['store', 'update', 'destroy']);

        // Reports
        Route::get('/reports/overdue', [ReportController::class, 'overdue']);
    });
});
