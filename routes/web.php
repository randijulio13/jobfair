<?php

use App\Http\Controllers\AdminApplicantController;
use App\Http\Controllers\AdminCareerFieldController;
use App\Http\Controllers\AdminConfigController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminProfilSponsorController;
use App\Http\Controllers\AdminSponsorController;
use App\Http\Controllers\AdminTokenController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminVacancyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
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
Route::prefix('loker')->group(function () {
    Route::get('', [VacancyController::class, 'index'])->name('vacancy');
    Route::get('detail/{id}', [VacancyController::class, 'detail'])->name('detail_vacancy');
    Route::post('', [VacancyController::class, 'store']);
});
Route::post('login', [LoginController::class, 'login']);
Route::post('user/{token?}', [UserController::class, 'register']);
Route::post('message', [MessageController::class, 'store']);
Route::get('check_login', [ProfileController::class, 'check_login']);

Route::prefix('profile')->middleware('auth.applicant')->group(function () {
    Route::get('', [ProfileController::class, 'index'])->name('profile');
    Route::get('account', [ProfileController::class, 'account'])->name('account');
    Route::get('history', [ProfileController::class, 'vacancy_history'])->name('vacancy_history');
    Route::get('notification', [ProfileController::class, 'notification'])->name('notification');
    Route::delete('notification/{id}', [ProfileController::class, 'delete_notif']);
    Route::patch('', [ProfileController::class, 'update_account']);
    Route::patch('password', [ProfileController::class, 'password']);
    Route::patch('token',[ProfileController::class,'token_activation']);
    Route::post('payment', [ProfileController::class, 'payment']);
    Route::post('', [ProfileController::class, 'update']);
});


Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('', [AdminDashboardController::class, 'index'])->name('dashboard_admin');
    Route::get('debug', [AdminLoginController::class, 'debug']);
    Route::get('login', [AdminLoginController::class, 'index'])->name('login_admin');
    Route::get('logout', [AdminLoginController::class, 'logout']);
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::patch('password', [AdminLoginController::class, 'password']);

    Route::prefix('config')->middleware('auth.role:1')->group(function () {
        Route::get('', [AdminConfigController::class, 'index'])->name('admin.config');
        Route::get('datatables_banner',[AdminConfigController::class,'datatables_banner']);
        Route::post('',[AdminConfigController::class,'store_banner']);

        Route::patch('banner/{id}', [AdminConfigController::class, 'update_status_banner']);
        Route::patch('', [AdminConfigController::class, 'update']);

        Route::delete('banner/{id}',[AdminConfigController::class,'delete_banner']);
    });

    Route::prefix('message')->group(function () {
        Route::get('', [AdminMessageController::class, 'index'])->name('admin.message');
        Route::get('datatables', [AdminMessageController::class, 'datatables']);
        Route::get('{id}', [AdminMessageController::class, 'detail'])->name('admin.message_detail');
        Route::post('', [AdminMessageController::class, 'store']);
        Route::delete('{id}', [AdminMessageController::class, 'delete']);
    });

    Route::prefix('profile')->group(function () {
        Route::get('', [AdminProfilSponsorController::class, 'index'])->name('profile.sponsor');
        Route::post('',[AdminProfilSponsorController::class,'update']);
    });

    Route::prefix('applicant')->group(function () {
        Route::get('', [AdminApplicantController::class, 'index'])->name('applicant');
        Route::post('sponsor', [AdminApplicantController::class, 'sponsor']);
        Route::get('datatables', [AdminApplicantController::class, 'datatables']);
    });

    Route::prefix('token')->middleware('auth.role:1')->group(function () {
        Route::get('', [AdminTokenController::class, 'index'])->name('token');
        Route::get('datatable', [AdminTokenController::class, 'datatable']);
        Route::get('{token}', [AdminTokenController::class, 'get']);
        Route::post('generate', [AdminTokenController::class, 'generate']);
        Route::delete('{id}', [AdminTokenController::class, 'delete']);
    });

    Route::prefix('vacancy')->group(function () {
        Route::get('', [AdminVacancyController::class, 'index'])->name('admin.vacancy');
        Route::get('datatables', [AdminVacancyController::class, 'datatables']);
        Route::get('datatables/{id}', [AdminVacancyController::class, 'datatables_detail']);
        Route::get('{id}', [AdminVacancyController::class, 'detail'])->name('admin.detail.vacancy');
        Route::post('', [AdminVacancyController::class, 'store']);
        Route::post('set_seen', [AdminVacancyController::class, 'set_seen']);
        Route::post('{id}', [AdminVacancyController::class, 'update']);
        Route::patch('status/{id}', [AdminVacancyController::class, 'update_status']);
    });

    Route::prefix('field')->middleware('auth.role:1')->group(function () {
        Route::get('', [AdminCareerFieldController::class, 'index'])->name('career_field');
        Route::get('datatable', [AdminCareerFieldController::class, 'datatable']);
        Route::get('{id}', [AdminCareerFieldController::class, 'get']);
        Route::post('', [AdminCareerFieldController::class, 'store']);
        Route::patch('{id}', [AdminCareerFieldController::class, 'update']);
        Route::delete('{id}', [AdminCareerFieldController::class, 'delete']);
    });

    Route::prefix('user')->middleware('auth.role:1')->group(function () {
        Route::get('datatables/{type}', [AdminUserController::class, 'datatables']);
        Route::get('{type}', [AdminUserController::class, 'index'])->name('user');
        Route::post('notif', [AdminUserController::class, 'send_notif']);
        Route::patch('{id}', [AdminUserController::class, 'update_status']);
    });

    Route::prefix('payment')->middleware('auth.role:1')->group(function () {
        Route::get('', [AdminPaymentController::class, 'index'])->name('admin.payment');
        Route::get('datatables', [AdminPaymentController::class, 'datatables']);
        Route::get('{id}', [AdminPaymentController::class, 'get']);
        Route::post('', [AdminPaymentController::class, 'store']);
        Route::post('{id}', [AdminPaymentController::class, 'update']);
        Route::patch('{id}', [AdminPaymentController::class, 'update_status']);
        Route::delete('{id}', [AdminPaymentController::class, 'delete']);
    });

    Route::prefix('sponsor')->middleware('auth.role:1')->group(function () {
        Route::get('', [AdminSponsorController::class, 'index'])->name('sponsor');
        Route::get('select2',[AdminSponsorController::class,'select2']);
        Route::get('datatables', [AdminSponsorController::class, 'datatables']);
        Route::get('{id}', [AdminSponsorController::class, 'get']);
        Route::post('', [AdminSponsorController::class, 'store']);
        Route::post('{id}', [AdminSponsorController::class, 'update']);
        Route::patch('{id}', [AdminSponsorController::class, 'update_status']);
    });
});
