<?php

use App\Http\Controllers\AdminCareerFieldController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminTokenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('', [AdminDashboardController::class, 'index'])->name('dashboard_admin');
    Route::get('debug', [AdminLoginController::class, 'debug']);
    Route::get('login', [AdminLoginController::class, 'index'])->name('login_admin');
    Route::post('logout', [AdminLoginController::class, 'logout']);
    Route::post('login', [AdminLoginController::class, 'login']);

    Route::prefix('token')->group(function () {
        Route::get('', [AdminTokenController::class, 'index'])->name('token');
        Route::get('datatable', [AdminTokenController::class, 'datatable']);
        Route::post('generate', [AdminTokenController::class, 'generate']);
    });

    Route::prefix('field')->group(function () {
        Route::get('', [AdminCareerFieldController::class, 'index'])->name('career_field');
        Route::post('', [AdminCareerFieldController::class, 'store']);
        Route::get('datatable', [AdminCareerFieldController::class, 'datatable']);
        Route::patch('{id}', [AdminCareerFieldController::class, 'update']);
        Route::get('{id}',[AdminCareerFieldController::class,'get']);
        Route::delete('{id}',[AdminCareerFieldController::class,'delete']);
    });
});
