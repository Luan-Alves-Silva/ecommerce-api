<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

# LOGIN AND LOGOUT ROUTE
Route::post('/login', [Controllers\Auth\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->delete('/logout', [Controllers\Auth\AuthController::class, 'logout']);

# SITE ROUTES
Route::post('/users-site', [Controllers\Users\UserController::class, 'store']);

# AUTHENTICATED ROUTES
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    # USERS ROUTE   
    Route::resource('/users', Controllers\Users\UserController::class);
});
