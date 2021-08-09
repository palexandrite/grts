<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Admin\{
    OrganizationController,
    ReceiverController,
    SearchController,
    StatsController,
    UserController,
};

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

/**
 * API routes for cells
 */
Route::prefix('mobile')->group(function() {

    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function() {

        Route::post('/login', [AuthController::class, 'login']);

    });

});

/**
 * API routes for the Superadmin
 */
Route::middleware(['auth:sanctum', 'ajax'])->prefix('manager')->group(function() {

    Route::post('/get-stats', StatsController::class);

    Route::prefix('search')->group(function() {

        Route::post('/organizations', [SearchController::class, 'organizations']);

        Route::post('/receivers', [SearchController::class, 'receivers']);

        Route::post('/users', [SearchController::class, 'users']);

    });

    Route::apiResource('receivers', ReceiverController::class);

    Route::apiResource('organizations', OrganizationController::class);

    Route::apiResource('users', UserController::class);

});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });