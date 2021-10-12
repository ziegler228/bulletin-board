<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/verify-email/{token}', [\App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke']);

Route::middleware(['guest'])->group(function() {
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'can:admin-panel'])->prefix('admin')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class)->except(['create', 'edit']);
    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class)->except(['create', 'edit']);
});
