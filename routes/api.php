<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookCheckoutController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\BookCheckout;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'role:librarian'])->prefix('admin')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });

    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index');
        Route::get('/books/{id}', 'show');
        Route::post('/books', 'store');
        Route::put('/books/{id}', 'update');
        Route::delete('/books/{id}', 'destroy');
        Route::get('/authors/list', 'listAuthors');
        Route::get('/genres/list', 'listGenres');
    });
    
    Route::controller(BookCheckoutController::class)->group(function () {
        Route::put('/checkouts/{checkout_id}/finish', 'finishCheckout');
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::controller(BookCheckoutController::class)->group(function () {
        Route::post('/books/{id}/checkout', 'checkoutBook');
        Route::get('/checkouts', 'checkoutHistory');
    });
    Route::get('profile', [AuthController::class, 'getProfile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index');
        Route::get('/books/{id}', 'show');
    });
});