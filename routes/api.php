<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Email\SendMailController;
use App\Http\Controllers\Api\User\UserController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::post('/store', [UserController::class, 'store']);

Route::post('/send-mail', [SendMailController::class, 'sendMail']);

Route::get('/send-link/{id}', [SendMailController::class, 'verifyToken']);

Route::put('/change-password/{id}', [SendMailController::class, 'changePassword']);

Route::group(['middleware' => ['apiJwt']], function () {
    route::get('/logout', [AuthController::class, 'logout']);
    route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/users/{id}', [UserController::class, 'retrieveOne']);
});
