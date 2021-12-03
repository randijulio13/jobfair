<?php

use App\Http\Controllers\AdminApplicantController;
use App\Http\Controllers\AdminCareerFieldController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminTokenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
Route::get('logout', [LoginController::class, 'logout']);
Route::get('token/{token}', [AdminTokenController::class, 'get']);
Route::post('login', [LoginController::class, 'login']);
Route::post('user/{token}', [UserController::class, 'store']);

Route::prefix('profile')->middleware('auth.applicant')->group(function () {
    Route::get('', [ProfileController::class, 'index'])->name('profile');
    Route::post('',[ProfileController::class,'update']);
});

Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('', [AdminDashboardController::class, 'index'])->name('dashboard_admin');
    Route::get('debug', [AdminLoginController::class, 'debug']);
    Route::get('login', [AdminLoginController::class, 'index'])->name('login_admin');
    Route::get('logout', [AdminLoginController::class, 'logout']);
    Route::post('login', [AdminLoginController::class, 'login']);

    Route::prefix('applicant')->group(function(){
        Route::get('',[AdminApplicantController::class,'index'])->name('applicant');
        Route::get('datatables',[AdminApplicantController::class,'datatables']);
    });

    Route::prefix('token')->group(function () {
        Route::get('', [AdminTokenController::class, 'index'])->name('token');
        Route::get('datatable', [AdminTokenController::class, 'datatable']);
        Route::get('{token}', [AdminTokenController::class, 'get']);

        Route::post('generate', [AdminTokenController::class, 'generate']);
    });

    Route::prefix('field')->group(function () {
        Route::get('', [AdminCareerFieldController::class, 'index'])->name('career_field');
        Route::get('datatable', [AdminCareerFieldController::class, 'datatable']);
        Route::get('{id}', [AdminCareerFieldController::class, 'get']);
        Route::post('', [AdminCareerFieldController::class, 'store']);
        Route::patch('{id}', [AdminCareerFieldController::class, 'update']);
        Route::delete('{id}', [AdminCareerFieldController::class, 'delete']);
    });
});
