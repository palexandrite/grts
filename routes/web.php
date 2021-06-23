<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    StatsController,
    UserController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index']);

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('manager')->group(function () {

    Route::middleware('ajax')->group(function() {

        Route::post('/get-stats', StatsController::class);

        Route::post('/get-users', [UserController::class, 'index']);

        Route::post('/get-user', [UserController::class, 'get']);

        Route::post('/edit-user', [UserController::class, 'edit']);

    });

    Route::view('/dashboard', 'admin.index');

    Route::view('{remaining_path}', 'admin.index')
        ->where(['remaining_path' => '[\w/]+']);

    Route::redirect('/', '/manager/dashboard');

});