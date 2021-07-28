<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthenticatedSessionController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [UserController::class, 'index']);

// require __DIR__.'/auth.php';

Route::middleware('guest')->prefix('manager')->group(function() {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

});

Route::middleware(['auth'])->prefix('manager')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::view('/dashboard', 'admin.dashboard');

    Route::view('{remaining_path}', 'admin.dashboard')
        ->where(['remaining_path' => '[\w/-]+']);

    Route::redirect('/', '/manager/dashboard');

});