<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Admin\{
    OrganizationController,
    ReceiverController,
<<<<<<< HEAD
=======
    SearchController,
>>>>>>> 2c04c23 (Init commit)
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
<<<<<<< HEAD
    
    Route::prefix('/users')->group(function () {

        Route::post('/', [UserController::class, 'index']);

        Route::post('/create', [UserController::class, 'store']);

        Route::post('/show', [UserController::class, 'edit']);

        Route::post('/update', [UserController::class, 'update']);

        Route::post('/search', [UserController::class, 'search']);

        Route::post('/delete', [UserController::class, 'destroy']);

    });

    Route::prefix('/organizations')->group(function () {

        Route::post('/', [OrganizationController::class, 'index']);

        Route::post('/create', [OrganizationController::class, 'store']);

        Route::post('/show', [OrganizationController::class, 'edit']);

        Route::post('/update', [OrganizationController::class, 'update']);

        Route::post('/search', [OrganizationController::class, 'search']);

        Route::post('/delete', [OrganizationController::class, 'destroy']);

    });

    Route::prefix('/receivers')->group(function () {

        Route::post('/', [ReceiverController::class, 'index']);

        Route::post('/create', [ReceiverController::class, 'store']);

        Route::post('/show', [ReceiverController::class, 'show']);

        Route::post('/update', [ReceiverController::class, 'update']);

        Route::post('/search', [ReceiverController::class, 'search']);

        Route::post('/delete', [ReceiverController::class, 'destroy']);

    });
=======

    Route::prefix('search')->group(function() {

        Route::post('/organizations', [SearchController::class, 'organizations']);

        Route::post('/receivers', [SearchController::class, 'receivers']);

        Route::post('/users', [SearchController::class, 'users']);

    });

    Route::apiResource('receivers', ReceiverController::class);

    Route::apiResource('organizations', OrganizationController::class);

    Route::apiResource('users', UserController::class);
>>>>>>> 2c04c23 (Init commit)

});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });