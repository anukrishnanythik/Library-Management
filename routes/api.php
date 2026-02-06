<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\BookController;


Route::middleware('auth:sanctum', 'role:librarian,member')->group(function () {
    Route::controller(ReservationController::class)->group(function () {
        Route::post('/reservations', 'store');
        Route::get('/reservations/my', 'view');
    });

    Route::get('/books/search', [BookController::class, 'search']);
});


Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});


